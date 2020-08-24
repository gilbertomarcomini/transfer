<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function create(array $data)
    {   
        return $this->account::create([
            'user_id' => $data['user_id']
        ]);
    }

}