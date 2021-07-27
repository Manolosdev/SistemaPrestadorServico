<?php

namespace App\Lib;

use PDO;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsável pelas configurações de acesso a base de dados.
 * 
 * @package   App\Lib
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class ConexaoBD {

    /**
     * Conexão padrao do sistema (CRUD INTERNO).
     * 
     * @var PDO
     */
    private static $CONEXAO_DEFAULT;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Construtor da classe bloqueado
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      10/05/2019
     */
    private function __construct() {
        //BLOQUEADO
    }

    /**
     * <b>FUNÇÃO CORE</b>
     * <br>Retorna instancia de conexão com a base de dados padrão do sistema.
     * 
     * @return    PDO Conexão configurada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      10/05/2019
     */
    static function getConnection() {
        //CONFIGURACAO
        $DB_DRIVER = 'mysql';
        $DB_HOST = 'localhost';
        $DB_NAME = 'pinguins_dev';
        $DB_USER = 'root';
        $DB_PASS = 'A.)NoZMZp3dR';
        $pdoConfig = $DB_DRIVER . ":" . "host=" . $DB_HOST . ";";
        $pdoConfig .= "dbname=" . $DB_NAME . ";";
        try {
            if (!isset(self::$CONEXAO_DEFAULT)) {
                self::$CONEXAO_DEFAULT = new PDO($pdoConfig, $DB_USER, $DB_PASS);
                self::$CONEXAO_DEFAULT->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$CONEXAO_DEFAULT;
        } catch (\PDOException $erro) {
            error_log($erro->getMessage());
            exit();
        }
    }

    /**
     * <b>CORE</b>
     * <br>Caso haja alguma conexão DEFAULT a mesma é fechada.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/09/2019
     */
    static function setConnectionClose() {
        if (isset(self::$CONEXAO_DEFAULT)) {
            self::$CONEXAO_DEFAULT = null;
        }
    }

}
