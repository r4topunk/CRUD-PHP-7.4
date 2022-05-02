<?php

namespace Magazord\Infraestrutura\Persistencia;

use PDO;
use PDOException;

class CriadorConexao
{
    public static function criarConexao(): PDO
    {
        try {
            $sCaminhoConfig = __DIR__ . '/../config.ini';
            $config = parse_ini_file(realpath($sCaminhoConfig));
            $pdo = new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']}", $config['db_user'], $config['db_password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();
        }
    }
}