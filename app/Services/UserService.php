<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\ClientRepository;
use App\Repositories\StoreRepository;
use App\Services\AccountService;
use App\Traits\ValidatorTrait;
use App\Libraries\Validate;
use Exception;

class UserService
{
    use ValidatorTrait;
    
    protected $userRepository;
    protected $clientRepository;
    protected $storeRepository;
    protected $accountService;

    public function __construct(
                        UserRepository $userRepository, 
                        ClientRepository $clientRepository, 
                        StoreRepository $storeRepository,
                        AccountService $accountService)
    {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
        $this->storeRepository = $storeRepository;
        $this->accountService = $accountService;
    }

    public function register(array $datas)
    {
        $attributes = $this->userRepository->sanitaze($datas);
        $validation = $this->validator($attributes, $this->userRepository->rules());

        if($validation->fails()){
            return ["success" => false, "messages" => $validation->errors()];
        }

        $document = array_get($attributes, "document");

        if( Validate::validateCpf($document) ){
            return $this->create($attributes, $this->clientRepository);
        }

        if( Validate::validateCnpj($document) ){
            return $this->create($attributes, $this->storeRepository);
        }

        return ["success" => false, "messages" => "Invalid document - CPF/CNPJ"];
    }

    public function create(array $attributes, UserRepository $userRepository)
    {
        try{
            $register = $userRepository->create($attributes);
            $register["account"] = $this->accountService->register($register);
            return ["success" => true, "messages" => $register];
        }catch(Exception $error){
            return ["success" => false, "messages" => $error->getMessage()];
        }
    }

    public function findUser($user_id)
    {
        $user = $this->userRepository->findUser($user_id);

        if(!$user->isEmpty()){
            return ["success" => true, "messages" => $user];
        }

        return ["success" => false, "message" => "User:$user_id not found"];
    }

}