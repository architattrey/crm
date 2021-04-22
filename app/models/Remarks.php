<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class remarks extends Model
{
    protected $table = 'remarks';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'client_id',
        'remarks',
        'created_at',
        'updated_at',
    ];
    public function clients(){
        return $this->belongsTo('App\models\Clients','client_id');
    }
}
