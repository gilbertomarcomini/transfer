<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payer_id', 'payee_id', 'value', 'type_transaction_id', 'description'
    ];

    public function payer()
    {
        return $this->hasOne('App\Models\User', 'payer_id');
    }

    public function payee()
    {
        return $this->hasOne('App\Models\User', 'payee_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\TypeTransaction', 'type_transaction_id');
    }

}
