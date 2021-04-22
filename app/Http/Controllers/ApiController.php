<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
//use Maatwebsite\Excel\Excel;
//use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
use App\models\User; 
use App\models\Remarks; 
use App\models\Clients; 
use App\models\Admin;
use App\models\BDM;
use App\models\LG; 
use App\Exports\InvoicesExport;
use App\Imports\InvoiceImport;
use Excel;
use File;
use DB;

class ApiController extends Controller
{   
    #login of admin,bdm,lg
    public function login(Request $request){
        try{
            # check usertype 
            if($request->is_super == '1' || $request->is_lg == '3' || $request->is_bdm =='2'){
                $validator = Validator::make($request->all(), [
                    'email'              => 'required|Email',
                    'password'           => 'required',
                ]);
                if($validator->fails()) {
                    return response()->json([
                        'message'=>$validator->messages(),
                        'status'=>'error'
                    ]);
                }
                #login amdin
                if($request->is_super == 1){

                    if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){
                        $response['admin_info'] = Admin::where('id',auth('admin')->user()->id)->first();
                    }else{
                        return response()->json([
                            'message' =>'something went wrong with login.Please try again later',
                            'status'=>'error'
                        ]);

                    }
                #login bdm
                }elseif($request->is_bdm == 2){
                    if(Auth::guard('bdm')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){
                        $response['bdm_info'] = Admin::where('id',auth('bdm')->user()->id)->first();
                    }else{
                        return response()->json([
                            'message' =>'something went wrong with login.Please try again later',
                            'status'=>'error'
                        ]);
                    }
                #login lg
                }elseif($request->is_lg == 3){
                    if(Auth::guard('lg')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){
                        $response['lg_info'] = Admin::where('id',auth('lg')->user()->id)->first();
                    }else{
                        return response()->json([
                            'message' =>'something went wrong with login.Please try again later',
                            'status'=>'error'
                        ]);
                    }
                    if($response['lg_info'] || $response['admin_info'] || $response['bdm_info']){
                         #send response
                        return response()->json([
                            'message'=>'login successfully.',
                            'code'=>200,
                            'data'=>$response,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message' =>'Username or password may be incorrect pls try again.',
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message' =>'Sorry you can not login with us.',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"You are not able to login on this application.",
                    'status'=>'error'
                ]);
                
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    # update lg,bdm,admin
    public function updateUser(Request $request){
        try{
            #check if admin
            if($request->is_super && $request->id){
                $adminData = Admin::where('id',$request->id)->first();

                if($adminData){
                    $returnData = Admin::where('id',$request->id)->update([
                        'name'=> $request->name,
                        'email'=> $request->email
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Updated successfully.',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                        
                    }else{
                        return response()->json([
                            'message'=>"Something went wrong with this request.Please try again later",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"sorry login credentials not matched",
                        'status'=>'error'
                    ]);
                }
            # check if bdm
            }elseif($request->is_bdm && $request->id){
                $bdmData = BDM::where('id',$request->id)->first();

                if($bdmData){
                    $returnData = BDM::where('id',$request->id)->update([
                        'name'=> $request->name,
                        'email'=> $request->email
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Updated successfully.',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                        
                    }else{
                        return response()->json([
                            'message'=>"Something went wrong with this request.Please try again later",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"sorry login credentials not matched",
                        'status'=>'error'
                    ]);
                }
            # check if bdm
            }elseif($request->is_lg && $request->id){
                $lgData = LG::where('id',$request->id)->first();

                if($lgData){
                    $returnData = LG::where('id',$request->id)->update([
                        'name'=> $request->name,
                        'email'=> $request->email
                    ]);
                    if($returnData){
                        return response()->json([
                            'message'=>'Updated successfully.',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                        
                    }else{
                        return response()->json([
                            'message'=>"Something went wrong with this request.Please try again later",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"sorry login credentials not matched",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"You are not able to login with us",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #registered  and update client
    public function registerClient(Request $request){
        try{

            $remark = new Remarks();
            $client = new Clients();
            //update client information
            # id is or not
            if(!empty($request->id) && isset($request->id)){
            
                #select client data
                $clientData= Clients::where('delete_status',"1")
                                    ->where('id',$request->id)
                                    ->where('user_id',$request->user_id)
                                    ->first();
               
                #check client is in database
                if(!empty($clientData) && isset($clientData)) {
                    $validator = Validator::make($request->all(),[
                        
                        'lead_generate_by'  =>'required',
                        'client_name'       =>'required',
                        'proposal_date'     =>'required',
                        'services'          =>'required',  
                        'mobile_no'         =>'required|min:10',
                        'remider_time'      =>'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);                        
                    }
                    //dd($request->lead_generate_by);
                    $returnClientData = Clients::where('id',$request->id)->Where('delete_status','1')->update([
                        
                        'lead_generate_by' => $request->lead_generate_by,
                        'client_name'      => $request->client_name,
                        'country'          => $request->country,
                        'state'            => $request->state,
                        'city'             => $request->city,
                        'proposal_date'    => date('Y-m-d',strtotime($request->proposal_date)),
                        'services'         => $request->services,
                        'mobile_no'        => $request->mobile_no,
                        'email_id'         => $request->email_id,
                        'organization_name'=> $request->organization_name,
                        'requirement'      => $request->requirement,
                        'reference'	       => $request->reference,
                        'updated_at'       => date("Y-m-d"),
                    ]);
                    
                    if($returnClientData){
                        return response()->json([
                            'message'=>'Updated successfully.',
                            'code'=>200,
                            'status'=>'success'
                    ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong contact with administrator.",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"Client Not Found",
                        'status'=>'error'
                    ]);
                } 
            }else{
                //insert new data of client
                $validator = Validator::make($request->all(), [
                        
                    'lead_generate_by'  =>'required',
                    'client_name'       =>'required',
                    'proposal_date'     =>'required',
                    'services'          =>'required',
                    'mobile_no'         =>'required|min:10',
                ]);
                if($validator->fails()){
                    return response()->json([
                        'message'=>$validator->messages(),
                        'status'=>'error'
                    ]);
                }else{
                    //dd($request->all());
                    $client->user_id   = $request->user_id;
                    $client->user_type = $request->user_type;
                    $client->email_id  = $request->email_id;
                    $client->status    = '0';
                    $client->organization_name = $request->organization_name;
                    $client->requirement       = $request->requirement;
                    $client->reference         = $request->reference;
                    $client->lead_generate_by  = $request->lead_generate_by;
                    $client->client_name       = $request->client_name;
                    $client->country           = $request->country;
                    $client->state             = $request->state;
                    $client->city              = $request->city;
                    $client->proposal_date     = date('Y-m-d',strtotime($request->proposal_date));
                    $client->services          = $request->services;
                    $client->mobile_no         = $request->mobile_no;
                    $client->reminder_time     = date('Y-m-d h:i:s',strtotime($request->reminder_time));
                    $client->delete_status     = "1";
                    $client->created_at        = date("Y-m-d");
                    $client->save();
                    if($client->id){
                        $remark->client_id = $client->id;
                        $remark->remarks = $request->remarks;
                        $remark->created_at = date("Y-m-d");
                        $remark->save();
                        return response()->json([
                            'message'=>'Registered successfully.',
                            'code'=>200,
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"something went wrong contact with administrator.",
                            'status'=>'error'
                        ]);
                    }
                }
            }    
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #for admin get all live clients 
    public function getLiveClients(Request $request){
        try{ 
            $response['clients'] = Clients::where('delete_status',"1")
                                        ->orderBy('reminder_time', 'asc')
                                        ->get();
            $response['all_bdm'] = BDM::get();
            if($response){
                return response()->json([
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"Data not found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #for admin get deleted clients
    public function getDeletedClients(Request $request){
        try{
            $response['clients'] = Clients::where('delete_status',"0")
                                    ->orderBy('created_at', 'asc')
                                    ->get();
            if($response){
                return response()->json([
                    'code'=>200,
                    'data'=>$response,
                    'status'=>'success'
                ]);
            }else{
                return response()->json([
                    'message'=>"Data not found",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    # for admin delete live client 
    public function deletetLiveClients(Request $request){
        try{
            $clientId = $request->client_id;
            if(!empty($clientId) && isset($clientId)){
                $clients = Clients::where('id', $clientId)->Where('delete_status',1)->first();
                if(!empty($clients) && isset($clients)){
                 
                    $result =  Clients::where('id', $clientId)->orWhere('delete_status',1)->update([
                      
                                    'delete_status'  => '0',
                    ]);
                    if($result){
                        return response()->json([
                            'code'=>200,
                            'message'=>"client information has been successfully deleted",
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"Something went wrong with this request.Please contact to administer",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"Client not found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Something went wrong please try again",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    #get all remarks of particular client
    public function getAllRemarks(Request $request){
        try{
            if(!empty($request->client_id) && isset($request->client_id)){
                $response['remarks'] = Remarks::with('clients')
                                          ->where('client_id',decrypt($request->client_id))
                                          ->orderBy('created_at', 'dsc')
                                          ->get();
                if($response){
                    return response()->json([
                        'code'=>200,
                        'data'=>$response,
                        'status'=>'success'
                    ]);
                }else{
                    return response()->json([
                        'message'=>"Data not found",
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>"Provide client id",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
    # submit data of remarks
    public function submitRemark(Request $request){
        try{
            $remark = new Remarks();
            $client = new Clients();
            //update client information
            # id is or not
            if(!empty($request->client_id) && isset($request->client_id)){
            
                $clientId = $request->client_id;
                #select client data
                $clientData = Clients::where('delete_status',"1")->where('id',$clientId)->first();
                #check client is in database
                if(!empty($clientData) && isset($clientData)) {
                    $validator = Validator::make($request->all(),[
                        'remarks'  =>'required',
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                            'message'=>$validator->messages(),
                            'status'=>'error'
                        ]);
                    }
                    $returnClientData = Clients::where('id', $clientId)->orWhere('delete_status','1')->update([
                        'reminder_time'    => date('Y-m-d h:i:s',strtotime($request->reminder_time)),
                        'updated_at'       => date("Y-m-d"),
                    ]);
                    if($returnClientData){
                        $remark->remarks     = $request->remarks;
                        $remark->client_id   = $clientId;
                        $remark->created_at  = date("Y-m-d h:i:s");
                        $remark->save();
                        
                        return response()->json([
                            'code'=>200,
                            'message'=>"Remark has successfully created",
                            'status'=>'success'
                        ]);
                    }else{
                        return response()->json([
                            'message'=>"Something went wrong with this request.Please contact to administer",
                            'status'=>'error'
                        ]);
                    }
                }else{
                    return response()->json([
                        'message'=>"Client Not Found",
                        'status'=>'error'
                    ]);
                } 
            }else{
                return response()->json([
                    'message'=>"Something went wrong. please try again later",
                    'status'=>'error'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message'=>"Something went wrong. Please contact administrator.".$e->getMessage(),
                'status'=>'error'
            ]);
        }
    }
}
