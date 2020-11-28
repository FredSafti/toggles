<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Command;

use Application\ListToggles\ListToggles;
use Application\SwitchToggle\SwitchToggle;
use Application\SwitchToggle\SwitchToggleHandler;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ToggleCommand extends Command
{
    private SwitchToggleHandler $switcher;
    private ListToggles $lister;

    public function __construct(
        SwitchToggleHandler $switcher,
        ListToggles $lister
    ) {
        $this->switcher = $switcher;
        $this->lister = $lister;

        parent::__construct('app:toggle');
    }

    protected function configure(): void
    {
        $this->addArgument('toggleName', InputArgument::OPTIONAL);
        $this->addArgument('state', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $nameArgument = $input->getArgument('toggleName');

        if ((! is_string($nameArgument)) || (empty($nameArgument))) {
            $this->showToggleList($io);
            return Command::SUCCESS;
        }

        $stateArgument = $input->getArgument('state');
        if ((! is_string($stateArgument)) || (strtolower($stateArgument) !== 'on')) {
            $state = SwitchToggle::ACTION_SWITCH_OFF;
        } else {
            $state = SwitchToggle::ACTION_SWITCH_ON;
        }

        $this->switcher->handle(new SwitchToggle($nameArgument, $state));
        $io->success('"' . $nameArgument . '" toggle switched ' . $state);

        return Command::SUCCESS;
    }

    private function showToggleList(SymfonyStyle $io): void
    {
        $list = array();
        foreach ($this->lister->get() as $toggle) {
            $list[] = [
                'name' => $toggle->name,
                'state' => ($toggle->active ? 'ON' : 'OFF')
            ];
        }

        if (empty($list)) {
            $io->note('No toggle defined');
            return;
        }

        $io->table(['name', 'state'], $list);
    }
}
