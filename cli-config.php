<?php

require_once __DIR__ . '/vendor/autoload.php';

use Magazord\Helper\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$oEntityManagerFactory = new EntityManagerFactory();
$oEntityManager = $oEntityManagerFactory->getEntityManager();

ConsoleRunner::run(
    new SingleManagerProvider($oEntityManager)
);