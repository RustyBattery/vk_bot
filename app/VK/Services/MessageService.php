<?php

namespace App\VK\Services;

use App\vk\DTO\KeyboardDTO;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Promises\LazyPromise;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MessageService
{
    /**
     * @param int $user_id
     * @param string $message
     * @param KeyboardDTO|null $keyboard
     * @param int $random_id
     * @return PromiseInterface|LazyPromise|Response
     * @throws ConnectionException
     */
    public function send(int $user_id, string $message, ?KeyboardDTO $keyboard = null, int $random_id = 0): LazyPromise|PromiseInterface|Response
    {
        $url = env('VK_API_ENDPOINT') . '/messages.send';

        $data = [
            'v' => env('VK_API_VERSION'),
            'access_token' => env('VK_API_ACCESS_TOKEN'),
            'user_id' => $user_id,
            'random_id' => $random_id,
            'message' => $message,
        ];

        if (!empty($keyboard)) {
            $data['keyboard'] = json_encode($keyboard);
//            Log::debug('keyboard', ['keyboard' => $keyboard, 'json' => json_encode($keyboard)]);
        }

        Log::debug('vk_req', ['data' => $data, 'url' => $url]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('VK_BOT_ACCESS_TOKEN'),
        ])->withQueryParameters($data)->get($url);

        Log::debug('vk_resp', [$response]);

        return $response;
    }
}
