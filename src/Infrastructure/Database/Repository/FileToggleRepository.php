<?php

declare(strict_types=1);

namespace Infrastructure\Database\Repository;

use Domain\Entity\Toggle;
use Domain\Repository\ToggleRepository;
use function Safe\file_get_contents;
use function Safe\file_put_contents;

class FileToggleRepository implements ToggleRepository
{
    private string $filename;
    private bool $loaded = false;
    /** @var Toggle[] */
    private array $catalog = array();

    public function __construct(string $projectDir)
    {
        $this->filename = $projectDir . '/var/toggles';
    }

    private function needCatalog(): void
    {
        if (! $this->loaded) {
            if (! is_file($this->filename)) {
                $this->catalog = array();
                return;
            }

            $this->catalog = unserialize(
                file_get_contents($this->filename)
            );

            $this->loaded = true;
        }
    }

    private function saveCatalog(): void
    {
        file_put_contents($this->filename, serialize($this->catalog));
    }

    public function getAll(): array
    {
        $this->needCatalog();
        return $this->catalog;
    }

    public function get(string $name): Toggle
    {
        $this->needCatalog();

        if (! isset($this->catalog[$name])) {
            $this->catalog[$name] = new Toggle($name);
        }

        return $this->catalog[$name];
    }

    public function save(Toggle $toggle): void
    {
        $this->needCatalog();

        $this->catalog[$toggle->name] = $toggle;
        $this->saveCatalog();
    }
}
