<?php

declare(strict_types=1);

namespace Tests\Application\SwitchToggle;

use Application\SwitchToggle\SwitchToggle;
use Application\SwitchToggle\SwitchToggleHandler;
use Domain\Entity\Toggle;
use PHPUnit\Framework\TestCase;

class SwitchToggleTest extends TestCase
{
    public function testActivate(): void
    {
        $toggleName = 'test';
        $repository = new FakeToggleRepository();
        $switch = new SwitchToggle($toggleName, SwitchToggle::ACTION_SWITCH_ON);
        $handler = new SwitchToggleHandler($repository);

        $handler->handle($switch);

        $toggle = $repository->get($toggleName);
        $this->assertInstanceOf(Toggle::class, $toggle);
        $this->assertSame($toggleName, $toggle->name);
        $this->assertTrue($toggle->active);
    }

    public function testInactive(): void
    {
        $toggleName = 'test';
        $repository = new FakeToggleRepository();
        $switch = new SwitchToggle($toggleName, SwitchToggle::ACTION_SWITCH_OFF);
        $handler = new SwitchToggleHandler($repository);

        $handler->handle($switch);

        $toggle = $repository->get($toggleName);
        $this->assertInstanceOf(Toggle::class, $toggle);
        $this->assertSame($toggleName, $toggle->name);
        $this->assertFalse($toggle->active);
    }

    public function testActiveExisting(): void
    {
        $toggleName = 'test';
        $toggle = new Toggle($toggleName);
        $repository = new FakeToggleRepository();
        $repository->save($toggle);

        $switch = new SwitchToggle($toggleName, SwitchToggle::ACTION_SWITCH_ON);
        $handler = new SwitchToggleHandler($repository);

        $handler->handle($switch);

        $changedToggle = $repository->get($toggleName);
        $this->assertSame($toggle, $changedToggle);
        $this->assertTrue($changedToggle->active);
    }

    public function testInactiveExisting(): void
    {
        $toggleName = 'test';
        $toggle = new Toggle($toggleName);
        $toggle->active = true;

        $repository = new FakeToggleRepository();
        $repository->save($toggle);

        $switch = new SwitchToggle($toggleName, SwitchToggle::ACTION_SWITCH_OFF);
        $handler = new SwitchToggleHandler($repository);

        $handler->handle($switch);

        $changedToggle = $repository->get($toggleName);
        $this->assertSame($toggle, $changedToggle);
        $this->assertFalse($changedToggle->active);
    }
}
