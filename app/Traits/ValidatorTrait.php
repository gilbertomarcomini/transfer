<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidatorTrait
{

	/**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }

}