<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Validador\ValidadorResultado;
use App\Model\Entidade\EntidadeAlmoxarifadoPrateleira;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de validação de prateleiras dentro do 
 * sistema.
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      12/07/2021
 */
class ValidadorAlmoxarifadoPrateleira extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependecias do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de CADASTRO de registro. 
     * 
     * @param     EntidadeAlmoxarifadoPrateleira $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/07/2021
     */
    function setValidarCadastro(EntidadeAlmoxarifadoPrateleira $entidade) {
        //NOME
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 50)) {
            $this->validadorResultado->addErro('Nome da prateleira', 'Nome da prateleira informado considerado inválido');
        }
        //DESCRIÇÃO
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 4, 250)) {
            $this->validadorResultado->addErro('Descrição da prateleira', 'Descrição da prateleira informado considerado inválido');
        }
        //EMPRESA
        if (empty($entidade->getFkEmpresa()) || $entidade->getFkEmpresa() <= 0) {
            $this->validadorResultado->addErro('Empresa da prateleira', 'Empresa da prateleira informado considerado inválido');
        }
        $endereco = $entidade->getEntidadeEndereco();
        //ENTIDADE ENDEREÇO
        //IBGE
        if ($this->isEmpty($endereco->getIbge())) {
            $this->validadorResultado->addErro('IBGE do endereço', 'IBGE do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getIbge(), 2, 7)) {
                $this->validadorResultado->addErro('IBGE do endereço', 'IBGE do endereço considerado inválido.');
            }
        }
        //CEP
        if ($this->isEmpty($endereco->getCep())) {
            $this->validadorResultado->addErro('CEP do endereço', 'CEP do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getCep(), 9, 9)) {
                $this->validadorResultado->addErro('CEP do endereço', 'Formato do CEP do endereço considerado inválido.');
            }
        }
        //RUA
        if ($this->isEmpty($endereco->getRua())) {
            $this->validadorResultado->addErro('Rua do endereço', 'Rua do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getRua(), 1, 50)) {
                $this->validadorResultado->addErro('Rua do endereço', 'Rua do endereço deve conter entre 1 e 50 caracteres.');
            }
        }
        //NUMERO
        if ($this->isEmpty($endereco->getNumero())) {
            $this->validadorResultado->addErro('Número da rua', 'Número da rua do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getNumero(), 1, 10)) {
                $this->validadorResultado->addErro('Número da rua', 'Número da rua do endereço deve conter entre 1 e 10 caracteres.');
            }
        }
        //REFERENCIA
        if (!$this->isEmpty($endereco->getReferencia())) {
            if (!$this->isLenght($endereco->getReferencia(), 1, 50)) {
                $this->validadorResultado->addErro('Referência do endereço', 'Referência do endereço deve conter entre 1-50 caracteres.');
            }
        }
        //BAIRRRO
        if ($this->isEmpty($endereco->getBairro())) {
            $this->validadorResultado->addErro('Bairro do endereço', 'Bairro do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getBairro(), 1, 50)) {
                $this->validadorResultado->addErro('Bairro do endereço', 'Bairro do endereço deve conter entre 1 e 50 caracteres.');
            }
        }
        //CIDADE
        if ($this->isEmpty($endereco->getCidade())) {
            $this->validadorResultado->addErro('Cidade do endereço', 'Cidade do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getCidade(), 1, 40)) {
                $this->validadorResultado->addErro('Cidade do endereço', 'Cidade do endereço deve conter entre 1 e 40 caracteres.');
            }
        }
        //UF
        if ($this->isEmpty($endereco->getUf())) {
            $this->validadorResultado->addErro('UF do endereço', 'Estado(UF) do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getUf(), 2, 2)) {
                $this->validadorResultado->addErro('UF do endereço', 'Estado(UF) do endereço deve conter 2 caracteres');
            }
        }
        return $this->validadorResultado;
    }
    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de editor de registro. 
     * 
     * @param     EntidadeAlmoxarifadoPrateleira $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function setValidarEditor(EntidadeAlmoxarifadoPrateleira $entidade) {
        //NOME
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 50)) {
            $this->validadorResultado->addErro('Nome da prateleira', 'Nome da prateleira informado considerado inválido');
        }
        //DESCRIÇÃO
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 4, 250)) {
            $this->validadorResultado->addErro('Descrição da prateleira', 'Descrição da prateleira informado considerado inválido');
        }
        //EMPRESA
        if (empty($entidade->getFkEmpresa()) || $entidade->getFkEmpresa() <= 0) {
            $this->validadorResultado->addErro('Empresa da prateleira', 'Empresa da prateleira informado considerado inválido');
        }
        $endereco = $entidade->getEntidadeEndereco();
        //ENTIDADE ENDEREÇO
        //IBGE
        if ($this->isEmpty($endereco->getIbge())) {
            $this->validadorResultado->addErro('IBGE do endereço', 'IBGE do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getIbge(), 2, 7)) {
                $this->validadorResultado->addErro('IBGE do endereço', 'IBGE do endereço considerado inválido.');
            }
        }
        //CEP
        if ($this->isEmpty($endereco->getCep())) {
            $this->validadorResultado->addErro('CEP do endereço', 'CEP do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getCep(), 9, 9)) {
                $this->validadorResultado->addErro('CEP do endereço', 'Formato do CEP do endereço considerado inválido.');
            }
        }
        //RUA
        if ($this->isEmpty($endereco->getRua())) {
            $this->validadorResultado->addErro('Rua do endereço', 'Rua do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getRua(), 1, 50)) {
                $this->validadorResultado->addErro('Rua do endereço', 'Rua do endereço deve conter entre 1 e 50 caracteres.');
            }
        }
        //NUMERO
        if ($this->isEmpty($endereco->getNumero())) {
            $this->validadorResultado->addErro('Número da rua', 'Número da rua do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getNumero(), 1, 10)) {
                $this->validadorResultado->addErro('Número da rua', 'Número da rua do endereço deve conter entre 1 e 10 caracteres.');
            }
        }
        //REFERENCIA
        if (!$this->isEmpty($endereco->getReferencia())) {
            if (!$this->isLenght($endereco->getReferencia(), 1, 50)) {
                $this->validadorResultado->addErro('Referência do endereço', 'Referência do endereço deve conter entre 1-50 caracteres.');
            }
        }
        //BAIRRRO
        if ($this->isEmpty($endereco->getBairro())) {
            $this->validadorResultado->addErro('Bairro do endereço', 'Bairro do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getBairro(), 1, 50)) {
                $this->validadorResultado->addErro('Bairro do endereço', 'Bairro do endereço deve conter entre 1 e 50 caracteres.');
            }
        }
        //CIDADE
        if ($this->isEmpty($endereco->getCidade())) {
            $this->validadorResultado->addErro('Cidade do endereço', 'Cidade do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getCidade(), 1, 40)) {
                $this->validadorResultado->addErro('Cidade do endereço', 'Cidade do endereço deve conter entre 1 e 40 caracteres.');
            }
        }
        //UF
        if ($this->isEmpty($endereco->getUf())) {
            $this->validadorResultado->addErro('UF do endereço', 'Estado(UF) do endereço obrigatório.');
        } else {
            if (!$this->isLenght($endereco->getUf(), 2, 2)) {
                $this->validadorResultado->addErro('UF do endereço', 'Estado(UF) do endereço deve conter 2 caracteres');
            }
        }
        return $this->validadorResultado;
    }

}
