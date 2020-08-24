<?php

namespace App\Repositories;

use App\Models\User;

class StoreRepository extends UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $data)
    {
        return $this->user::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'document' => preg_replace("/[^0-9]/", "", $data['document']),
            'password' => bcrypt($data['password']),
            'type_users_id' => 2
        ]);
    }

    public function isPayee(int $user_id)
    {
        $payee = $this->user->find($user_id);
        if(!empty($payee)){
            return $payee;
        }
        return false;
    }

}