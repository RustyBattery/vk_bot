<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use App\VK\Factories\CommandFactory;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function handle(CallbackRequest $request, CommandFactory $commandFactory)
    {
        $data = $request->validated();

        Log::debug('callback', [$data]);

        $type = $data['type'];

        if ($type == 'message_new') {
            $message = $data['object']['message'];

            $user_id = $message['from_id'];
            $text = $message['text'];

            $payload = isset($message['payload']) ? json_decode($message['payload']) : null;

            if (!empty($payload->command ?? null)) {
                $command = $commandFactory->make($payload->command);
                $command?->handle($user_id, $payload);
            }
        }

        return 'ok';
    }
}
