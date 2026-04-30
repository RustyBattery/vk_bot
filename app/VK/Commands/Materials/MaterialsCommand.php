<?php

namespace App\VK\Commands\Materials;

use App\Models\Material;
use App\VK\Commands\Command;
use App\VK\DTO\ButtonDTO;
use App\VK\DTO\KeyboardDTO;
use Illuminate\Http\Client\ConnectionException;

class MaterialsCommand extends Command
{
    protected string $name = 'materials';
    protected string $value = 'Образовательное руководство';

    /**
     * @throws ConnectionException
     */
    public function handle(int $user_id, ?object $payload = null): void
    {
        $buttons = [];

        $materials = Material::all();

        foreach ($materials as $material) {
            $buttons[] = [new ButtonDTO(
                label: $material->id . '. ' . $material->title,
                payload: json_encode(['command' => 'material_item', 'data' => ['id' => $material->id]]),
            )];
        }

        $message = "Прочитайте это всеобъемлющее руководство, чтобы понять основы управления стрессом. Каждый раздел основывается на предыдущем, чтобы дать вам полную основу. \n\nСодержание:";

        $this->messageService->send($user_id, $message, new KeyboardDTO($buttons, false, true));
    }
}
