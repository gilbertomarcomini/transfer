<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function sanitaze(array $attributes)
    {
        $attributes["name"] = trim(array_get($attributes, "name"));
        $attributes["email"] = trim(array_get($attributes, "email"));
        $attributes["document"] = preg_replace("/[^a-zA-Z0-9]/", "", array_get($attributes, "document"));

        return $attributes;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'document' => 'required|string|max:255|unique:users|regex:/^[0-9]/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function deposit(User $user, $value)
    {
        $user->account->value += $value;
        return $user->account->update();
    }

    public function debit(User $user, $value)
    {
        $user->account->value -= $value;
        return $user->account->update();
    }

    public function findUser($user_id)
    {
        return $this->user->where('id', $user_id)
                        ->with('account')
                        ->get();
    }

}