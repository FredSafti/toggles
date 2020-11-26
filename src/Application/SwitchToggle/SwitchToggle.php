<?php

namespace Application\SwitchToggle;

class SwitchToggle
{
    public const ACTION_SWITCH_ON = 'on';
    public const ACTION_SWITCH_OFF = 'off';

    public string $name;
    public string $action;

    public function __construct(string $name, string $action)
    {
        $this->name = $name;
        $this->action = $action;
    }
}
