<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use App\Models\Entry;
use App\VK\Commands\Diary\DiaryAddCommand;
use App\VK\Factories\CommandFactory;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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
                return 'ok';
            }

            $state = Cache::get('state-' . $user_id, null);

            if (!empty($state)) {
                if (str_starts_with($state, 'waiting_entry-')) {
                    $command = $commandFactory->make('diary_add');
                    $command->add_text($user_id, substr($state, strlen('waiting_entry-')), $text);
                }
            }
        }

        return 'ok';
    }
}
