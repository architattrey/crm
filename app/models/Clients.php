<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class Clients extends Model
{
    protected $table = 'clients';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'user_type',
        'asigned_bdm',
        'status',
        'lead_generate_by',
        'client_name',
        'country',
        'state',
        'city',
        'proposal_date',
        'services',
        'mobile_no',
        'email_id',
        'organization_name',
        'requirement',
        'reference',
        'reminder_time',
        'delete_status',
        'created_at',
        'updated_at',
    ];
}
