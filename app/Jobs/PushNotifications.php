<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use Exception;

class PushNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $notification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        if (!$this->sendNotification())
            throw new Exception("Falha ao enviar notificação: {$this->user->id}");
    }

    public function sendNotification()
    {
        try{
            $body = [
                'user_id' => $this->user->id,
                'message' => $this->notification
            ];
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', env('PUSH_NOTIFICATION'), ['form_params' => $body]);

            if($response->getStatusCode() !== 200){
                return false;
            }

            return true;
        }catch(Exception $error){
            return false;
        }
    }

}
