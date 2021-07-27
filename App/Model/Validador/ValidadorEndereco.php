<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeEndereco;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pela validação de ENDEREÇOS dentro do sistema.
 * 
 * @package   App\Validador
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      01/07/2021
 */
class ValidadorEndereco extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      01/07/2021
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * <b>VALIDADOR</b>
     * <br>Efetua validação de registro informado por parametro.
     * 
     * @param     EntidadeEndereco $entidade Entidade carregada
     * @return    ResultadoValidador Lista com resultado da validacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      05/05/2020
     */
    function setValidarRegistro(EntidadeEndereco $entidade) {
        //IBGE
        if ($this->isEmpty($entidade->getIbge())) {
            $this->validadorResultado->addErro('IBGE do endereço', 'IBGE do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getIbge(), 2, 7)) {
                $this->validadorResultado->addErro('IBGE do endereço', 'IBGE do endereço considerado inválido.');
            }
        }
        //CEP
        if ($this->isEmpty($entidade->getCep())) {
            $this->validadorResultado->addErro('CEP do endereço', 'CEP do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getCep(), 9, 9)) {
                $this->validadorResultado->addErro('CEP do endereço', 'Formato do CEP do endereço considerado inválido.');
            }
        }
        //RUA
        if ($this->isEmpty($entidade->getRua())) {
            $this->validadorResultado->addErro('Rua do endereço', 'Rua do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getRua(), 1, 50)) {
                $this->validadorResultado->addErro('Rua do endereço', 'Rua do endereço deve conter entre 1 e 50 caracteres.');
            }
        }
        //NUMERO
        if ($this->isEmpty($entidade->getNumero())) {
            $this->validadorResultado->addErro('Número da rua', 'Número da rua do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getNumero(), 1, 10)) {
                $this->validadorResultado->addErro('Número da rua', 'Número da rua do endereço deve conter entre 1 e 10 caracteres.');
            }
        }
        //REFERENCIA
        if (!$this->isEmpty($entidade->getReferencia())) {
            if (!$this->isLenght($entidade->getReferencia(), 1, 50)) {
                $this->validadorResultado->addErro('Referência do endereço', 'Referência do endereço deve conter entre 1-50 caracteres.');
            }
        }
        //BAIRRRO
        if ($this->isEmpty($entidade->getBairro())) {
            $this->validadorResultado->addErro('Bairro do endereço', 'Bairro do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getBairro(), 1, 50)) {
                $this->validadorResultado->addErro('Bairro do endereço', 'Bairro do endereço deve conter entre 1 e 50 caracteres.');
            }
        }
        //CIDADE
        if ($this->isEmpty($entidade->getCidade())) {
            $this->validadorResultado->addErro('Cidade do endereço', 'Cidade do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getCidade(), 1, 40)) {
                $this->validadorResultado->addErro('Cidade do endereço', 'Cidade do endereço deve conter entre 1 e 40 caracteres.');
            }
        }
        //UF
        if ($this->isEmpty($entidade->getUf())) {
            $this->validadorResultado->addErro('UF do endereço', 'Estado(UF) do endereço obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getUf(), 2, 2)) {
                $this->validadorResultado->addErro('UF do endereço', 'Estado(UF) do endereço deve conter 2 caracteres');
            }
        }
        return $this->validadorResultado;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de registro informado.
     * 
     * @param     EntidadeEndereco $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/07/2021
     */
    function setValidarEditor(EntidadeEndereco $entidade) {
        //ID INTERNO
        if ($this->isEmpty($entidade->getId())) {
            $this->validadorResultado->addErro('Código interno do endereço', 'Código interno do endereço deve ser informado');
        } else {
            if ($entidade->getId() <= 0) {
                $this->validadorResultado->addErro('Código interno do endereço', 'Código interno do endereço deve ser maior que zero.');
            }
        }
        $this->setValidarRegistro($entidade);
        return $this->validadorResultado;
    }

}
