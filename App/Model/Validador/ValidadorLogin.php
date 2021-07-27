<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeUsuario;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pela validação dos processos referente aa venda
 * 
 * @package   App\Validadores
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class ValidadorLogin extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function __construct() {
        $this->resultadoValidacao = new ValidadorResultado();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Valida as informações de usuario e senha.
     * 
     * @param     EntidadeUsuario $entidade Entidade usuário informado
     * @return    ValidacaoResultado Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setValidarLogin(EntidadeUsuario $entidade) {
        $this->resultadoValidacao = new ValidadorResultado();
        //USUARIO
        if ($this->isEmpty($entidade->getLogin())) {
            $this->resultadoValidacao->addErro('Login do usuário', 'Login do usuário é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getLogin(), 4, 20)) {
                $this->resultadoValidacao->addErro('Login do usuário', 'Login do usuário deve conter entre 4 e 20 caracteres');
            }
        }
        //SENHA
        if ($this->isEmpty($entidade->getSenha())) {
            $this->resultadoValidacao->addErro('Senha do usuário', 'Senha do usuário é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getSenha(), 4, 20)) {
                $this->resultadoValidacao->addErro('Senha do usuário', 'Senha do usuário deve conter enrte 4 e 20 caracteres');
            }
        }
        return $this->resultadoValidacao;
    }

}
