<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class RegisterController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('user');
    }

    public function register(Request $request)
    {
        $result = $this->userService->register($request->all());

        if(array_get($result, "success")){
            return response($result, 200);
        }

        return response($result, 406);
    }

    public function findUser($user_id)
    {
        $result = $this->userService->findUser($user_id);

        if(array_get($result, "success")){
            return response($result, 200);
        }

        return response($result, 404);
    }

}