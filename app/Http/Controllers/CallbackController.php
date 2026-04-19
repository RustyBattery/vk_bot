<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use App\VK\Commands\StartCommand;
use App\VK\Services\MessageService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function handle(CallbackRequest $request)
    {
        $data = $request->validated();

        Log::debug('callback', [$data]);

        $type = $data['type'];

        if ($type == 'message_new' && isset($payload->command)) {
            $message = $data['object']['message'];
            $user_id = $message['from_id'];
            $text = $message['text'];
            $payload = json_decode($message['payload']);

            if($payload->command == 'start'){
                $command = new StartCommand(new MessageService());
                $command->handle($user_id);
            }
        }

        return 'ok';
    }
}
