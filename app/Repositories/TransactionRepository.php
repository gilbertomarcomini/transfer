<?php

namespace App\Repositories;

use App\Jobs\PushNotifications;
use App\Models\Transaction;
use App\Models\User;
use DB;

class TransactionRepository
{
    protected $transaction;
    protected $userRepository;

    public function __construct(Transaction $transaction, UserRepository $userRepository)
    {
        $this->transaction = $transaction;
        $this->userRepository = $userRepository;
    }

    public function rules()
    {
        return [
            'value' => 'required|numeric|min:0',
            'payer' => 'required|integer|different:payee',
            'payee' => 'required|integer|different:payer',
            'limitless' => 'boolean'
        ];
    }

    public function create(array $data)
    {   
        return $this->transaction::create([
            'payer_id' => array_get($data, 'payer_id'),
            'payee_id' => array_get($data, 'payee_id'),
            'value' => array_get($data, 'value'),
            'type_transaction_id' => array_get($data, 'type_transaction'),
            'description' => array_get($data, 'description')
        ]);
    }

    public function transaction(User $payer, User $payee, $value)
    {
        DB::beginTransaction();
        try {
            $transaction = [
                'payer_id' => $payer->id,
                'payee_id' => $payee->id,
                'value' => $value,
                'type_transaction' => 1
            ];

            if(!$this->create($transaction)){
                throw new \Exception("Erro ao registrar transação");
            }
            
            if(!$this->userRepository->debit($payer, $value)){
                throw new \Exception("Erro ao retirar valor");
            }

            if(!$this->userRepository->deposit($payee, $value)){
                throw new \Exception("Erro ao depositar valor");
            }

            if(!$this->checkAuthorization()){
                throw new \Exception("Não autorizado");
            }

            $this->dispatchNotification($payee, $payer, $value);

            DB::commit();
            return ["success" => true, "messages" => "Transação efetuada com sucesso."];
        } catch (\Exception $e) {
            DB::rollback();
            return ["success" => false, "messages" => $e->getMessage()];
        }

    }

    public function checkAuthorization()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('CHECK_AUTHORIZATION'));

        if($response->getStatusCode() === 200){
            return true;
        }
        
        return false;
    }

    public function dispatchNotification(User $payee, User $payer, $value)
    {
        $notification = "$payee->name o usuário $payer->name enviou R$ $value para sua conta.";
        PushNotifications::dispatch($payee, $notification);
    }

}