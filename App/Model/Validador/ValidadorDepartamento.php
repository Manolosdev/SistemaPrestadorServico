<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeDepartamento;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pela validação de departamentos dentro do sistema.
 * 
 * @package   App\Validador
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      26/06/2021
 */
class ValidadorDepartamento extends ValidadorBase {

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
     * <br>Efetua validação de edição de departamento informada por parametro.
     * 
     * @param     EntidadeDepartamento $entidade Entidade informada
     * @return    ResultadoValidador Lista com resultado da validacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function setValidarEditor(EntidadeDepartamento $entidade) {
        //ID
        if (empty($entidade->getId()) || intval($entidade->getId()) <= 0) {
            $this->validadorResultado->addErro('Código do departamento', 'Código do departamento informado considerado inválido');
        }
        //EMPRESA
        if(empty($entidade->getFkEmpresa()) || $entidade->getFkEmpresa() <= 0){
            $this->validadorResultado->addErro('Empresa do departamento', 'Empresa do departamento informado considerado inválido');
        }
        //NOME 
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 3, 30)) {
            $this->validadorResultado->addErro('Nome do departamento', 'Nome do departamento considerado inválido');
        }
        //DESCRIÇÃO
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 3, 100)) {
            $this->validadorResultado->addErro('Descrição do departamento', 'Descrição do departamento considerado inválido');
        }
        //ADMINISTRADOR
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 3, 100)) {
            $this->validadorResultado->addErro('Descrição do departamento', 'Descrição do departamento considerado inválido');
        }
        return $this->validadorResultado;
    }

}
