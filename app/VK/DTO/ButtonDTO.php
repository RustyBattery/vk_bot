<?php

namespace App\VK\DTO;

readonly class ButtonDTO
{
    const string PRIMARY_BUTTON = 'primary';
    const string SECONDARY_BUTTON = 'secondary';
    const string NEGATIVE_BUTTON = 'negative';
    const string POSITIVE_BUTTON = 'positive';

    public ButtonActionDTO $action;
    public string $color;

    public function __construct($label, $color = self::PRIMARY_BUTTON, $type = 'text', $payload = '')
    {
        $this->action = new ButtonActionDTO($label, $type, $payload);
        $this->color = $color;
    }
}
