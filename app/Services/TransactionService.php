<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\ClientRepository;
use App\Repositories\StoreRepository;
use App\Traits\ValidatorTrait;

class TransactionService
{
    use ValidatorTrait;
    
    protected $transactionRepository;
    protected $clientRepository;
    protected $storeRepository;

    public function __construct(
                        TransactionRepository $transactionRepository, 
                        ClientRepository $clientRepository,
                        StoreRepository $storeRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->clientRepository = $clientRepository;
        $this->storeRepository = $storeRepository;
    }

    public function register(array $datas)
    {
        $validation = $this->validator($datas, $this->transactionRepository->rules());

        if($validation->fails()){
            return ["success" => false, "messages" => $validation->errors()];
        }

        $payer = $this->clientRepository->isPayer($datas['payer']);
        $payee = $this->storeRepository->isPayee($datas['payee']);

        if(!$payer){
            return ["success" => false, "messages" => "User can't make payments or does not exist"];
        }

        if(!$payee){
            return ["success" => false, "messages" => "user can't receive payments or does not exist"];
        }

        // if(!array_get($datas, "limitless", false) && $payer->account->value <= 0){
        //     return ["success" => false, "messages" => "Usuário não possui saldo na conta"];
        // }

        return $this->transactionRepository->transaction($payer, $payee, $datas["value"]);
    }

}