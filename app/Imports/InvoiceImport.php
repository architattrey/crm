<?php

namespace App\Imports;

use App\models\Clients;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoiceImport implements ToModel
{
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function model(array $row){
  //dd($row[11]);
    try{		
        new Clients([
          'user_id'  => auth('admin')->user()? auth('admin')->user()->id :'',
          'user_type'=> auth('admin')->user()? auth('admin')->user()->is_super:'',
          'status' => '0',
          'lead_generate_by'=> (isset($row[0]) && !empty($row[0]))? $row[0]:" ",
          'client_name'=> (isset($row[1]) && !empty($row[1]))? $row[1]:" ",
          'country'=>(isset($row[2]) && !empty($row[2]))? $row[2]:" ",
          'state'=>(isset($row[3]) && !empty($row[3]))? $row[3]:" ",
          'city'=>(isset($row[4]) && !empty($row[4]))? $row[4]:" ",
          'proposal_date'=> (isset($row[5]) && !empty($row[5]))? date('Y-m-d',strtotime($row[5])):" ",
          'services'=> (isset($row[6]) && !empty($row[6]))? $row[6]:" ",
          'mobile_no'=> (isset($row[7]) && !empty($row[7]))? $row[7]:" ",
          'email_id'=>(isset($row[8]) && !empty($row[8]))? $row[8]:" " ,
          'organization_name'=> (isset($row[9]) && !empty($row[9]))? $row[9]:" ",
          'requirement'=> (isset($row[10]) && !empty($row[10]))? $row[10]:" ",
          'reminder_time'=> (isset($row[11]) && !empty($row[11]))? date('Y-m-d h:i:s',strtotime($row[11])):" ",
          'reference'=> (isset($row[12]) && !empty($row[12]))? $row[12]:" ",
          'created_at'=>  date('Y-m-d'),
          'delete_status' => "1",
        ]);
    }catch(\Exception $e){
      return false;
    }
  }
}
