<?php

/**
 * @file Console based application.
 */

use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

$console = new Console\Application('PPBE Statutes Online', '0.1');

$helperSet = new Console\Helper\HelperSet();
$helperSet->set(new Console\Helper\QuestionHelper(), 'question');
$console->setHelperSet($helperSet);


// Cache clear command
$console
  ->register('cache:clear')
  ->setDescription('Clears the cache')
  ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
    $cacheDir = $app['cache.path'];
    $finder = Finder::create()->in($cacheDir)->notName('.gitkeep');

    $filesystem = new Filesystem();
    $filesystem->remove($finder);

    $output->writeln(sprintf("%s <info>success</info>", 'cache:clear'));
});

// Install command
$console
  ->register('installer:install')
  ->setDescription('Install the application')
  ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {

    $cacheDir = $app['cache.path'];
    $filesystem = new Filesystem();
    $filesystem->mkdir($cacheDir);

    $logDir = $app['log.path'];
    $filesystem = new Filesystem();
    $filesystem->mkdir($logDir);

    $output->writeln(sprintf("%s <info>success</info>", 'installer:install'));
});

return $console;
