<?php

namespace Infrastructure\Symfony\Command;

use Application\ListToggles\ListToggles;
use Application\SwitchToggle\SwitchToggle;
use Application\SwitchToggle\SwitchToggleHandler;
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
        $name = $input->getArgument('toggleName');

        if (is_null($name)) {
            $list = array();
            foreach($this->lister->get() as $toggle) {
                $list[] = [
                    'name' => $toggle->name,
                    'state' => ($toggle->active ? 'ON' : 'OFF')
                ];
            }

            if (empty($list)) {
                $io->note('No toggle defined');
                return Command::SUCCESS;
            }

            $io->table(['name', 'state'], $list);
            return Command::SUCCESS;
        }

        $state = SwitchToggle::ACTION_SWITCH_OFF;
        if (strtolower($input->getArgument('state')) == 'on') {
            $state = SwitchToggle::ACTION_SWITCH_ON;
        }

        $this->switcher->handle(new SwitchToggle($name, $state));

        $io->success('"' . $name . '" toggle switched ' . $state);

        return Command::SUCCESS;
    }
}
