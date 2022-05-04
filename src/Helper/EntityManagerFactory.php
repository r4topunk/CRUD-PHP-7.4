<?php

namespace Magazord\Helper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../../vendor/autoload.php';

class EntityManagerFactory
{

    public function getEntityManager(): EntityManagerInterface
    {
        $sRootDir = __DIR__ . '/../../';
        $config = ORMSetup::createAnnotationMetadataConfiguration(
            array($sRootDir . '/src'),
            true
        );

        $sCaminhoConfig = __DIR__ . '/../Infraestrutura/config.ini';
        $aConfigBanco = parse_ini_file(realpath($sCaminhoConfig));

        $conn = array(
            'url' => "mysql://{$aConfigBanco['db_user']}:{$aConfigBanco['db_password']}@{$aConfigBanco['db_host']}/{$aConfigBanco['db_name']}"
        );
        
        return EntityManager::create($conn, $config);
    }

}