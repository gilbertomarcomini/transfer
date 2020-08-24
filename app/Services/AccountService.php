<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AccountRepository;

class AccountService
{   
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function register(User $user)
    {
        $attributes["user_id"] = $user->id;
        return $this->accountRepository->create($attributes);
    }

}