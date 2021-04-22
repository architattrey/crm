<?php 
namespace App\Exports;
use App\models\Clients;

use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    public function collection()
    {
        return Clients::get(['lead_generate_by',
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
                            'reminder_time',
                            'reference',
                            'created_at'
                            ]);
    }
}