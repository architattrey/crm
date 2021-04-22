<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\Clients; 

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // private $SMS_SENDER = "TXTLCL";
    // private $RESPONSE_TYPE = 'json';
    // private $SMS_USERNAME = '';
    // private $SMS_PASSWORD = '';
    // private $API_KEY = "F/UB8hz3Jas-c4tCIHOYE6swkDUujzSWMykZHICw1O";
    protected $signature = 'notify:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails every five minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    
        $data['clients'] = Clients::where('delete_status',"1")
                                    ->orderBy('reminder_time', 'asc')
                                    ->get();
        //send reminder cron job
        foreach($data['clients'] as $client){
            $reminderTime = $client['reminder_time'];
            $mobileNumber = $client['mobile_number'];
            $clientName   = $client['client_name'];
            $toNumber = "9811587227";
            if(date('Y-m-d h:i:s') == date('Y-m-d h:i:s',strtotime($reminderTime))){
                $ch = curl_init();
                
                $encoded_message = urlencode("Dear Sir/Mam please call on this number:" .$mobileNumber."." .$clientName." Please search on your panel with this name.");
                $string1 = "http://api.smscountry.com/SMSCwebservice_bulk.aspx?User=upharfinvest&passwd=Uphar@1074&mobilenumber=8826589808 &message=".$encoded_message."&sid=smscntry&mtype=N&DR=Y";
                curl_setopt($ch, CURLOPT_URL, $string1);
                $response = curl_exec($ch);
                curl_close($ch);
                // $message =  "Dear Sir/Mam please call your Client name: " .$clientName. " Phone number: ".$mobileNumber."Before call this number check last remark of this client";
                // $smsStatus = $this->sendReminderNotification($toNumber, $message);
            }      
        }     
    }
    //SMS for send reminder
    // public function sendReminderNotification($toNumber, $message){
       
    //     $isError = 0;
    //     $errorMessage = true;
    //     $data = array('apikey' => $this->API_KEY, 'numbers' => $toNumber, "sender" => $this->SMS_SENDER, "message" => $message);
    
    //     // Send the POST request with cURL
    //     $ch = curl_init('https://api.textlocal.in/send/');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     $response = json_decode($response);
    //         return "success";
    // }
}
