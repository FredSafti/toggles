<?php

namespace Infrastructure\Database\Repository;

use Domain\Entity\Toggle;
use Domain\Repository\ToggleRepository;

class FileToggleRepository implements ToggleRepository
{
    private string $filename;
    private array $catalog;

    public function __construct(string $projectDir)
    {
        $this->filename = $projectDir . '/var/toggles';
    }

    private function loadCatalog(): void
    {
        if (is_null($this->catalog)) {
            if (! is_file($this->filename)) {
                $this->catalog = array();
                return;
            }

            $this->catalog = unserialize(
                file_get_contents($this->filename)
            );
        }
    }

    private function saveCatalog(): void
    {
        file_put_contents($this->filename, serialize($this->catalog));
    }

    public function get(string $name): Toggle
    {
        $this->loadCatalog();

        if (isset($this->catalog[$name])) {
            return $this->catalog[$name];
        }

        return new Toggle($name);
    }

    public function save(Toggle $toggle): void
    {
        $this->loadCatalog();

        $this->catalog[$toggle->name] = $toggle;
        $this->saveCatalog();
    }
}
