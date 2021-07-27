<?php

namespace App\Model\DAO;

use App\Model\Entidade\EntidadeFirebase;
use App\Model\DAO\BaseDAO;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável por operações de armazenamento de tokens do firebase.
 * 
 * @package   App\Model\DAO
 * @author    Original Igor Maximo <igor.maximo@redetelecom.com.br>
 * @author    updated Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class FirebaseDAO extends BaseDAO {

    /**
     * Tabela de relacionamento 1-N
     * @var string
     */
    static $NOME_TABELA = 'core_firebase_usuario';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <Override>
     * 
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @date      25/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - VIEW -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna o ID (FK) do usuário por login de usuário
     * 
     * @return    array Retorna lista com todos os tokens
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @date      25/06/2021
     */
    function retornaTokensSisRedeApp() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT firebase_token, nome_completo FROM " . UsuarioDAO::$NOME_TABELA
            );
            if ($resultado && $resultado->rowCount()) {
                $resultados = $resultado->fetchAll();
                foreach ($resultados as $value) {
                    $registro = [];
                    $registro['token'] = $value['firebase_token'];
                    $registro['nomeCompleto'] = $value['nome_completo'];
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna o Token de um usuário específico.
     * 
     * @return    string Token solicitado
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getTokenEspecificoSisRedeApp($usuarioID) {
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT firebase_token FROM " . UsuarioDAO::$NOME_TABELA . " WHERE id = " . $usuarioID
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = $resultado->fetchAll();
                    foreach ($retorno as $value) {
                        return $value['firebase_token'];
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>FUNÇÃO INTERNA</b>
     * <br>Retorna o Token de um setor específico.
     * 
     * @param     integer $departamentoID ID do departamento informado
     * @return    array Lista de resultados
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getTokenSetorSisRedeApp($departamentoID) {
        $retorno = [];
        if ($departamentoID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT firebase_token, nome_completo FROM " . UsuarioDAO::$NOME_TABELA . " fk_departamento = " . $departamentoID
                );
                if ($resultado && $resultado->rowCount()) {
                    $resultados = $resultado->fetchAll();
                    foreach ($resultados as $value) {
                        $registro = [];
                        $registro['token'] = $value['firebase_token'];
                        $registro['nomeCompleto'] = $value['nome_completo'];
                        array_push($retorno, $registro);
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - INSERT -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Cadastra os tokens do firebase ref. ao login de usuário.
     * 
     * @param     EntidadeFirebase $entidade Entidade carregada
     * @author    Igor Maximo <igor.maximo@redetecom.com.br>
     * @date      25/06/2021
     */
    function setRegistro(EntidadeFirebase $entidade) {
        try {
            $idUser = $this->retornaIdUsuario($entidade->getUser());
            $this->insert(
                    self::$NOME_TABELA, ":firebase_token,"
                    . ":fk_usuario,"
                    . ":ultima_atualizacao", [
                ':token' => $entidade->getToken(),
                ':fk_usuario' => $idUser,
                ':ultima_atualizacao' => date('Y-m-d H:i:s')
                    ]
            );
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        // return $this->retornaUltimoIdPPPoECadastrado();
    }
    
    ////////////////////////////////////////////////////////////////////////////
    //                          - INTERNAL FUNCTION -                         //
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Retorna o ID (FK) do usuário por login de usuário.
     * 
     * @param     string $login Login informado
     * @return    integer ID do registro solicitado
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @date      25/06/2021
     */
    private function retornaIdUsuario($login) {
        if (!empty($login)) {
            try {
                $resultado = $this->select(
                        "SELECT id FROM " . self::$NOME_TABELA_RELACIONAMENTO . " WHERE login = '" . $login . "'"
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = $resultado->fetchAll()[0];
                }
                return $retorno['id'];
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

}
