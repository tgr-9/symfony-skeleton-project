<?php

declare(strict_types=1);

namespace App\Console;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(name: 'app:setup')]
final class SetupProjectConsoleCommand extends Command
{
    public function __construct(
        private readonly FilesystemOperator $filesystem,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $dockerComposeYml = Yaml::parse($this->filesystem->read('docker-compose.yml'));

        $io->title('Setup project');
        $warnings = [];

        if (!$io->confirm('Do you want to setup PHP-FPM and Nginx?', false)) {
            $this->filesystem->deleteDirectory('docker/php-fpm');
            $this->filesystem->deleteDirectory('docker/nginx');

            unset($dockerComposeYml['services']['php-fpm']);
            unset($dockerComposeYml['services']['nginx']);
        }

        if (!$io->confirm('Do you want to setup MySQL?', false)) {
            $this->filesystem->deleteDirectory('docker/mysql');
            $this->filesystem->deleteDirectory('migrations');
            $this->filesystem->delete('config/packages/doctrine.yaml');
            $this->filesystem->delete('config/packages/doctrine_migrations.yaml');
            $this->filesystem->deleteDirectory('config/packages/doctrine');

            $packagesToRemove = [
                'adrenalinkin/doctrine-naming-strategy',
                'doctrine/*',
            ];

            foreach ($packagesToRemove as $package) {
                $process = new Process(['composer', 'remove', $package]);
                $process->run();
            }

            unset($dockerComposeYml['services']['php-cli']['depends_on']);
            if (isset($dockerComposeYml['services']['nginx']['depends_on'])) {
                unset($dockerComposeYml['services']['nginx']['depends_on']);
            }
            unset($dockerComposeYml['services']['mysql']);
        } else {
            $warnings[] = 'Do not forget to set the database name in ".env DATABASE_URL" and "/docker/mysql/mysql.init.sql"';
        }

        $this->filesystem->write('docker-compose.yml', Yaml::dump(
            input: $dockerComposeYml,
            inline: 10,
        ));

        $warnings[] = 'Do not forget to delete this console command';
        $io->warning($warnings);

        return Command::SUCCESS;
    }
}
