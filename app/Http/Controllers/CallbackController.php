<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handle(CallbackRequest $request)
    {
        $data = $request->validated();

        Log::debug('callback', [$data]);

        return 'ok';
    }
}
