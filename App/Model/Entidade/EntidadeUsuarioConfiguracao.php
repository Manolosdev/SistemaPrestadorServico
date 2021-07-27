<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel pelo armazenamento de informações relacionadas as 
 * configurações dos usuarios cadastrados no sistema (GETTER,SETTER), tais como
 * cordo do layout, disposição dos elementos, etc.
 * 
 * @package   App\Model\Entidade
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class EntidadeUsuarioConfiguracao {

    private $id;
    private $fkUsuario;
    private $valor;

    function getId() {
        return $this->id;
    }

    function getFkUsuario() {
        return $this->fkUsuario;
    }

    function getValor() {
        return $this->valor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFkUsuario($fkUsuario) {
        $this->fkUsuario = $fkUsuario;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

}
