<?php

class Database{
    public static function getConnection(): PDO {
        $host = 'localhost';
        $port = '5432';
        $dbname = 'desafio-php';
        $user = 'postgres';
        $password = '1234';

        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
            return new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            die('Erro ao conectar com banco de dados: '.$e->getMessage());
        }
    }
}