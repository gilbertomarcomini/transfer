<?php

namespace App\Repositories;

use App\Models\User;

class ClientRepository extends UserRepository
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
            'type_users_id' => 1
        ]);
    }

    public function isPayer(int $user_id)
    {
        $payer = $this->user->find($user_id);
        if(!empty($payer) && $payer->type_users_id === 1){
            return $payer;
        }
        return false;
    }

}