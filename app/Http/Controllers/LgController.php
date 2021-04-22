<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
//use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Validator;
use Session;
use App\models\Remarks; 
use App\models\Clients;
use App\models\LG;  #like user model

class LgController extends Controller
{
    public function __construct()
    {
        $this->middleware('lg')->only(['clientRegistrationView','clientRegistered','ShowAllLeads']); 
    }
    # show clients bidding for lead generator
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
                        return redirect('/clients-registraion-lg');
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
    public function ShowAllLeads($id = NULL, $userType = NULL, Request $request){
        try{
            $data['allLeads'] = Clients::where('user_id',decrypt($id))
                                        ->where('user_type',$userType)
                                        ->get();
            
            return view('lg.clients_listing', $data);

        }catch(\Exception $e){
            Session::flash('flash_message','Something went wrong please try again later');    
            return back();

        }
    }
    

     
}
