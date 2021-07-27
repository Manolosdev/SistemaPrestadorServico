<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadePermissao;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pela validação de permissões dos usuarios no sistema.
 * 
 * @package   App\Validadores
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      26/06/2021
 */
class ValidadorPermissao extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de edição de permissão informada por parametro.
     * 
     * @param     EntidadePermissao $entidade Entidade carregada informada
     * @return    ResultadoValidador Lista com resultado da validacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function setValidarEditor(EntidadePermissao $entidade) {
        //ID
        if (empty($entidade->getId()) || intval($entidade->getId()) <= 0) {
            $this->validadorResultado->addErro('Código da permissão', 'Código da permissão informado considerado inválido');
        }
        //NOME 
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 30)) {
            $this->validadorResultado->addErro('Nome da permissão', 'Nome da permissão considerado inválido');
        }
        //DESCRICAO
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 4, 250)) {
            $this->validadorResultado->addErro('Descrição da permissão', 'Descrição da permissão considerada inválida');
        }
        //ID DO CARGO
        if (empty($entidade->getFkDepartamento()) || intval($entidade->getFkDepartamento()) <= 0) {
            $this->validadorResultado->addErro('Departamento da permissão', 'Departamento da permissão informado considerado inválido');
        }
        return $this->validadorResultado;
    }

}
