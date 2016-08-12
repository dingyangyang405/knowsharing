<?php

namespace Topxia\WebBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppInitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:init')
            ->setDescription('Init application.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Init Application.");
        $user = array(
            'name' => 'admin',
            'password' => 'kaifazhe',
            'roles' => array('ROLE_SUPER_ADMIN'),
        );

        $this->getService('user_service')->register($user);

        $output->writeln([
            "Admin name: {$user['name']}",
            "Admin Password: {$user['password']}"
        ]);
    }

    protected function getService($name)
    {
        $biz = $this->getApplication()->getKernel()->getContainer()->get('biz');
        return $biz[$name];
    }


}