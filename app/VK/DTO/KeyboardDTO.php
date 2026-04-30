<?php

namespace App\VK\DTO;

readonly class KeyboardDTO
{
    public array $buttons;
    public bool $one_time;
    public bool $inline;

    public function __construct($buttons = [], $one_time = false, $inline = false)
    {
        $this->buttons = $buttons;
        $this->one_time = $one_time;
        $this->inline = $inline;
    }
}
