<?php

namespace App\VK\Commands\Materials;

use App\Models\MaterialBlock;
use App\VK\Commands\Command;
use Illuminate\Http\Client\ConnectionException;

class MaterialBlockCommand extends Command
{
    protected string $name = 'material_block';
    protected string $value = '';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $id = $payload->data->id ?? null;

        if (!$id) {
            return;
        }

        $block = MaterialBlock::find($id);

        $message = $block->title . "\n\n" . $block->text;

        $this->messageService->send($user_id, $message);
    }
}
