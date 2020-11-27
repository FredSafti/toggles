<?php

namespace Application\SwitchToggle;

use Domain\Repository\ToggleRepository;

class SwitchToggleHandler
{
    private ToggleRepository $repository;

    public function __construct(ToggleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(SwitchToggle $switchToggle): void
    {
        if ($switchToggle->action !== SwitchToggle::ACTION_SWITCH_ON
        && $switchToggle->action !== SwitchToggle::ACTION_SWITCH_OFF) {
            throw new InvalidSwitchAction();
        }

        $toggle = $this->repository->get($switchToggle->name);

        $toggle->active = ($switchToggle->action == SwitchToggle::ACTION_SWITCH_ON);
        $this->repository->save($toggle);
    }
}
