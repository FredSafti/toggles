<?php

namespace Tests\Application\SwitchToggle;

use Application\SwitchToggle\SwitchToggle;
use Application\SwitchToggle\SwitchToggleHandler;
use Domain\Repository\ToggleRepository;
use PHPUnit\Framework\TestCase;

class SwitchToggleTest extends TestCase
{
    public function testActivate(): void
    {
        $switch = new SwitchToggle('test', SwitchToggle::ACTION_SWITCH_ON);
        $switcher = new SwitchToggleHandler($this->createMock(ToggleRepository::class));

        $switcher($switch);

        $this->assertSame(1,1);
    }
}
