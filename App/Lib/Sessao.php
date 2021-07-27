<?php

namespace App\Lib;

use App\Model\Entidade\EntidadeUsuario;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pelas operações do usuario logado ($_SESSION) no sistema
 * <Modelo Singletoon>
 * 
 * @package   App\Lib
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class Sessao {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Construtor bloqueado
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function __construct() {
        //BLOQUEADO
    }

    /**
     * <b>FUNCTION</b>
     * <br>Função que retorna informações do usuario logado em sessão 
     * ($_SESSION)
     * 
     * @return    EntidadeUsuario Sessao nao existe ou expirou
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    static function getUsuario() {
        if (isset($_SESSION['usuario'])) {
            return $_SESSION['usuario'];
        }
        return null;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Destroi a sessão atual ($_SESSION).
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    static function destruirSessao() {
        unset($_SESSION['usuario']);
        session_start();
        session_destroy();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Inicia sessão armazenando dados do usuario informado
     * 
     * @param     EntidadeUsuario $usuario Entidade carregada
     * @return    array Lista com informações do usuario
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    static function setSessao(EntidadeUsuario $usuario) {
        session_start();
        session_destroy();
        $sessionAtivas = scandir(session_save_path());
        $ocorrencia = 'sess_' . $usuario->getId() . 'pinguins';
        foreach ($sessionAtivas as $session) {
            if (strpos($session, $ocorrencia) !== false) {
                session_id(str_replace('sess_', '', $session));
                session_start();
                session_destroy();
            }
        }
        $sessionNome = $usuario->getId() . 'pinguins' . rand(999999, 9999999);
        session_id($sessionNome);
        session_start();
        if ($usuario instanceof EntidadeUsuario && !empty($usuario)) {
            $_SESSION['usuario'] = $usuario;
        }
        return $_SESSION['usuario'];
    }

    /**
     * <b>FUNCTION</b>
     * <br>Verifica se usuário em $_SESSION possui permissão solicitada.
     * 
     * @param     integer $permissaoID ID da permissao solicitada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    static function getPermissaoUsuario($permissaoID) {
        if (isset($_SESSION['usuario'])) {
            if (self::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                return true;
            }
            foreach (self::getUsuario()->getListaPermissao() as $registro) {
                if (intval($registro->getId()) === intval($permissaoID)) {
                    return true;
                }
            }
        }
        return false;
    }

}
