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
use Maatwebsite\Excel\Facades\Excel;
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
//use Excel;
use File;
use DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['export','import','getLiveClients','getDeletedClients','deletetLiveClients','asignBdm','clientRegistrationView','clientRegistered','ShowAllLeads']); 
    }
    
    #emport and export file 
    public function export(){
        //return "jhgvjhk";
        return Excel::download(new InvoicesExport, 'clients.xlsx');
    }
    
    public function import(Request $request){
        //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));

        if($request->hasFile('file')){
            //$extension = File::extension($request->file->getClientOriginalName()); also we can use
            $extension = $request->file->getClientOriginalExtension();

            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $file_name = 'clients_'.date('d-m-y').".".$extension;
				 
                $path = Storage::put($file_name, $request->file,'public');
                $path = $request->file->storeAs('public/clients_files', $file_name);
				//dd($path);
                $return = Excel::import(new InvoiceImport, $path);
				if($return==true){
                    Session::flash('flash_message', 'Your Data has successfully imported. Incase you are unable to see the data please check your file formate again');
                    return back();
				}else{
					Session::flash('flash_error', 'Excel sheet is not well formated');
                    return back();
                }
            }else{
                Session::flash('flash_error', 'File is a '.$extension.' file.!! Please upload a valid xls/xlsx/csv file..!!');
                return back();
            }	
        }else{
            Session::flash('flash_error', 'Something went wrong with this request.Please try again later');
            return back();
        }
    }
    #clients registration view
    public function clientRegistrationView(Request $request){

        #used for update and also for insert 
        if($request->client_id){
            $data['client'] = Clients::where('delete_status',$request->delete_status)
                                       ->where('id',decrypt($request->client_id))
                                       ->get();
        }else{
            $data['client']="";
        }
        return view('common.clients_registration',$data);
    } 
    // # clients registration data submit
    public function clientRegistered(Request $request){
       // dd(decrypt($request->user_id));
       
        try{
           
            $remark = new Remarks();
            $client = new Clients();
            //update client information
            # id is or not
            if(!empty($request->id) && isset($request->id)){
               
                #select client data
                $clientData= Clients::where('delete_status',"1")
                                    ->where('id', decrypt($request->id))
                                    ->where('user_id',decrypt($request->user_id))
                                    ->first();
               
                           
                #check client is in database
                if(!empty($clientData) && isset($clientData)) {
                    $validator = Validator::make($request->all(),[
                        
                        'lead_generate_by'  =>'required',
                        'client_name'       =>'required',
                        'proposal_date'     =>'required',
                        'services'          =>'required',  
                        'mobile_no'         =>'required|min:10',
                         
                    ]);
                    if ($validator->fails()) {
                        Session::flash('flash_error',$validator->messages());    
                        return back();
                        
                    }
                    //dd($request->lead_generate_by);
                    $returnClientData = Clients::where('id',decrypt($request->id))->Where('delete_status','1')->update([
                        
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
                        Session::flash('flash_message','Profile successfully updated');    
                        return back();
                    }else{
                        Session::flash('flash_error',"Something went wrong with this request.Please contact to administer"); 
                        return back();
                    }
                }else{
                    Session::flash('flash_error', 'Client Not Found ');    
                    return back();
                } 
            }else{
                
                //insert new data of client
                $validator = Validator::make($request->all(), [
                     
                    'lead_generate_by'  =>'required',
                    'client_name'       =>'required',
                    'services'          =>'required',
                    'mobile_no'         =>'required|min:10',
                ]);
                if($validator->fails()){
                    Session::flash('flash_error',$validator->messages());    
                    return back();
                     
                }else{
                    //dd($request->all());
                    $client->user_id   = decrypt($request->user_id);
                    $client->user_type = decrypt($request->user_type);
                    $client->email_id  = $request->email_id;
                    $client->status  = '0';
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
                        Session::flash('flash_message','Client has successfully created');    
                        return redirect('/clients-registraion-admin');
                    }else{
                        Session::flash('flash_message','Something went wrong please try again later');  
                        return back();
                    }
                }
            }
        }catch(\Exception $e){
            Session::flash('flash_error',"Something went wrong. please contact to administration"); 
            return back();
        }
    }
    # show clients bidding for lead generator
    public function ShowAllLeads($id = NULL, $userType = NULL, Request $request){
        try{
            $data['allLeads'] = Clients::where('user_id',decrypt($id))
                                        ->where('user_type',$userType)
                                        ->get();
            
            return view('admin.own_clients_listing', $data);

        }catch(\Exception $e){
            Session::flash('flash_message','Something went wrong please try again later');    
            return back();

        }
    }

    # get all live clients
    public function getLiveClients(Request $request){
        try{ 
            $data['clients'] = Clients::where('delete_status',"1")
                                        ->orderBy('reminder_time', 'asc')
                                        ->get();
            $data['delete_status'] = '1';
            $data['all_bdm'] = BDM::get();
            //dd($data['clients']);
            //var_dump($data['clients'][0]['asigned_bdm']);die;
            return view('admin.clients_listing',$data);
        }catch(\Exception $e){
            Session::flash('flash_error',"Something went wrong with this request.Please contact to administer"); 
            return back();
        }
    }
    
    # get all deleted clients
    public function getDeletedClients(Request $request){
        
        try{
            $data['clients'] = Clients::where('delete_status',"0")
                                    ->orderBy('created_at', 'asc')
                                    ->get();
            $data['delete_status'] = '0';
                
            return view('admin.clients_listing', $data);
        }catch(\Exception $e){
            Session::flash('flash_error',"Something went wrong with this request.Please contact to administer"); 
            return back();
        }
    }
    # delete live client 
    public function deletetLiveClients(Request $request){
        try{
            $clientId = decrypt($request->client_id);
            if(!empty($clientId) && isset($clientId)){
                $agent = Clients::where('id', $clientId)->first();
                if(!empty($agent) && isset($agent)){
                 
                    $result =  Clients::where('id', $clientId)->orWhere('delete_status',1)->update([
                      'delete_status'  => '0',
                    ]);
                    if($result){
                        Session::flash('flash_message',"client information has been successfully deleted"); 
                        return back();
                    }else{
                        
                        Session::flash('flash_error',"Something went wrong with this request.Please contact to administer"); 
                        return back();
                    }
                }else{
                    Session::flash('flash_error',"Client not found"); 
                    return back();
                }
            }else{
                Session::flash('flash_error',"Something went wrong please try again"); 
                return back();
            }
        }catch(\Exception $e){
            Session::flash('flash_error',"We can not delete this user. please contact to administration"); 
            return back();
        }
    }
    # get all remarks of particular client
    public function getAllRemarks(Request $request){
        try{
            if(!empty($request->client_id) && isset($request->client_id)){
                $data['remarks'] = Remarks::with('clients')
                                          ->where('client_id',decrypt($request->client_id))
                                          ->orderBy('created_at', 'dsc')
                                          ->get();
                $data['client_id'] =  $request->client_id;
                return view('admin.remarks_listing', $data);
            }else{
                Session::flash('flash_error',"Something went wrong please try again"); 
                return back();
            }
        }catch(\Exception $e){
            Session::flash();
            return back('flash_error',"Something went wrong with this request. please contact to administration");
        }
    }
    # add remark view of particular client
    public function clientRemarkView(Request $request){
        try{
            if(!empty($request->client_id) && isset($request->client_id)){
                $data['client'] = Clients::where('delete_status',"1")
                                            ->where('id',decrypt($request->client_id))
                                            ->get();             
                return view('admin.add_remarks', $data);                          
            }else{
                Session::flash('flash_error',"Something went wrong please try again"); 
                return back();
            }
        }catch(\Exception $e){
            Session::flash('flash_error',"Something went wrong with this request. please contact to administration");
            return back();
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
                        Session::flash('flash_error','Please fill all field carefully');    
                        return back();
                        
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

                        Session::flash('flash_message','Remark has successfully created');    
                        return back();
                    }else{
                        Session::flash('flash_error',"Something went wrong with this request.Please contact to administer"); 
                        return back();
                    }
                }else{
                    Session::flash('flash_error', 'Client Not Found ');    
                    return back();
                } 
            }else{
                Session::flash('flash_error',"Something went wrong. please try again later"); 
                return back();   
            }
        }catch(\Exception $e){
            Session::flash('flash_error',"Something went wrong. please contact to administration"); 
            return back();
        }


    }
    # assign bdm
    public function asignBdm(Request $request){
       // try{
            if(!empty($request->data)){

                $splictData = explode('-',$request->data);
                $id = $splictData[0];
                $bdmName  = $splictData[1];
                $clientId = $splictData[2];
                $clientData = Clients::where('delete_status',"1")->where('id',$clientId)->first();

                 
                if($clientData){
                    # send sms to agent for login details
                    // $ch = curl_init();
                    // $encoded_message = urlencode("Dear Sir/Mam please check your dashboard new client has been assigned to you. Please search on your panel with this name : ".$clientData['client_name']);

                    // $url = "http://api.smscountry.com/SMSCwebservice_bulk.aspx?User=upharfinvest&passwd=Uphar@1074&mobilenumber=9568083266 &message=".$encoded_message."&sid=smscntry&mtype=N&DR=Y";
                    
                    // // return response()->json([
                    // //     'message'=>$string1,
                    // //     'status'=>'error'
                    // // ]);
                    // //curl_setopt($ch, CURLOPT_POST, true);
                    // curl_setopt($ch, CURLOPT_URL, $url);
                    // //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // $response = curl_exec($ch);
                    // curl_close($ch);
                     
                   
                    
                    // return response()->json([
                    //     'message'=>$response,
                    //     'status'=>'error'
                    // ]);
                    
                    // if($response == true){
                        #update customer table for insert field boy
                         
                        $returnData =  Clients::where('id',$clientId)->update([
                            'asigned_bdm' => $id.','.$bdmName,
                            'status'=>'1',
                        ]);
                        if($returnData){
                            return response()->json([
                                'message'=>'Successfully assigned the task of BDM',
                                'status'=>'success'
                            ]);
                        }else{
                            return response()->json([
                                'message'=>'Something went wrong.Please try again after some time.',
                                'status'=>'error'
                            ]);
                        }
                    // }else{
                    //     return response()->json([
                    //         'message'=>'Message is not sending from service provider.Please try again after some time.',
                    //         'status'=>'error'
                    //     ]);
                    // }

                }else{
                    return response()->json([
                        'message'=>'something went wrong with server.Please try again after sone time.',
                        'status'=>'error'
                    ]);
                }
            }else{
                return response()->json([
                    'message'=>'You are not able to performe this task',
                    'status'=>'error'
                ]);
            }    

        // }catch(\Exception $e){
        //     Session::flash('flash_error',"Something went wrong. please contact to administration"); 
        //     return back();
        // }

    }
    
}
