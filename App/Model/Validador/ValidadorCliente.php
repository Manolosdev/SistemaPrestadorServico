<?php

namespace App\Model\Validador;

use App\Model\Entidade\EntidadeCliente;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas validações de CLIENTES dentro do sistema.
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      01/07/2021
 */
class ValidadorCliente extends ValidadorBase {

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de cadastro de cliente dentro do sistema.
     * 
     * @param     EntidadeCliente $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/07/2021
     */
    function setValidarCadastro(EntidadeCliente $entidade) {
        //TIPO PESSOA
        if ($entidade->getTipoPessoa() === 'f') {
            //CPF
            if ($this->isEmpty($entidade->getCpf())) {
                $this->validadorResultado->addErro('CPF do cliente', 'CPF do cliente é obrigatório.');
            } else {
                if (!$this->isLenght($entidade->getCpf(), 14, 14)) {
                    $this->validadorResultado->addErro('CPF do cliente', 'Formato do CPF do cliente considerado inválido.');
                } else {
                    if (VALIDATE_DOCUMENT_CPF_CNPJ) {
                        if (!$this->validaCPF($entidade->getCpf())) {
                            $this->validadorResultado->addErro('CPF do cliente', 'CPF do cliente considerado inválido.');
                        }
                    }
                }
            }
            //RG
            if ($this->isEmpty($entidade->getRg())) {
                $this->validadorResultado->addErro('RG do cliente', 'RG do cliente é obrigatório.');
            } else {
                if (!$this->isLenght($entidade->getRg(), 6, 20)) {
                    $this->validadorResultado->addErro('RG do cliente', 'Formato do RG do cliente deve conter entre 6 e 20 caracteres.');
                }
            }
        } else if ($entidade->getTipoPessoa() === 'j') {
            //CNPJ
            if ($this->isEmpty($entidade->getCnpj())) {
                $this->validadorResultado->addErro('CNPJ do cliente', 'CNPJ do cliente é obrigatório.');
            } else {
                if (!$this->isLenght($entidade->getCnpj(), 18, 18)) {
                    $this->validadorResultado->addErro('CNPJ do cliente', 'Formato do CNPJ do cliente considerado inválido.');
                }
            }
            //INSCRICAO MUNICIPAL
            if (!$this->isEmpty($entidade->getInscricaoMunicipal())) {
                if (intval($entidade->getInscricaoMunicipal()) === 0) {
                    $this->validadorResultado->addErro('Inscrição municipal do cliente', 'Valor da inscrição municipal deve ser diferente de 00000, considere não informar inscrição municipal, campo não obrigatório.');
                }
                if (!$this->isLenght($entidade->getInscricaoMunicipal(), 4, 20)) {
                    $this->validadorResultado->addErro('Inscrição municipal do cliente', 'Formato da inscrição municipal do cliente deve conter entre 4 e 20 caracteres.');
                }
            }
            //INSCRICAO ESTADUAL
            if (!$this->isEmpty($entidade->getInscricaoEstadual())) {
                if (intval($entidade->getInscricaoEstadual()) === 0) {
                    $this->validadorResultado->addErro('Inscrição estadual do cliente', 'Valor da inscrição estadual deve ser diferente de 00000, considere não informar inscrição estadual, campo não obrigatório.');
                }
                if (!$this->isLenght($entidade->getInscricaoEstadual(), 4, 20)) {
                    $this->validadorResultado->addErro('Inscrição estadual do cliente', 'Formato da Inscrição estadual do cliente deve conter entre 4 e 20 caracteres.');
                }
            }
        } else {
            $this->validadorResultado->addErro('Tipo de cliente', 'Tipo de cliente informado considerado inválido.');
            return $this->validadorResultado;
        }
        //EMAIL
        if ($this->isEmpty($entidade->getEmail())) {
            $this->validadorResultado->addErro('E-mail do cliente', 'E-mail do cliente é obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getEmail(), 10, 50)) {
                $this->validadorResultado->addErro('E-mail do cliente', 'Formato do e-mail do cliente considerado inválido.');
            } else {
                if (!filter_var($entidade->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $this->validadorResultado->addErro('E-mail do cliente', 'E-mail do cliente considerado inválido.');
                }
            }
        }
        //NOME
        if ($this->isEmpty($entidade->getNome())) {
            $this->validadorResultado->addErro('Nome do cliente', 'Nome do cliente obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getNome(), 5, 50)) {
                $this->validadorResultado->addErro('Nome do cliente', 'Formato do nome do cliente deve conter entre 5 e 50 caracteres.');
            }
        }
        //CELULAR
        if ($this->isEmpty($entidade->getCelular())) {
            $this->validadorResultado->addErro('Celular do cliente', 'Celular do cliente é obrigatório.');
        } else {
            if (!$this->isLenght($entidade->getCelular(), 15, 15)) {
                $this->validadorResultado->addErro('Celular do cliente', 'Formato do celular do cliente considerado inválido.');
            }
        }
        //TELEFONE
        if (!$this->isEmpty($entidade->getTelefone())) {
            if (!$this->isLenght($entidade->getTelefone(), 14, 14)) {
                $this->validadorResultado->addErro('Telefone do cliente', 'Formato do telefone do cliente considerado inválido.');
            }
        }
        return $this->validadorResultado;
    }
    
    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de cadastro de cliente dentro do sistema.
     * 
     * @param     EntidadeCliente $entidade Entidade informada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/07/2021
     */
    function setValidarEditor(EntidadeCliente $entidade) {
        //ID INTERNO
        if ($this->isEmpty($entidade->getId())) {
            $this->validadorResultado->addErro('Código interno do cliente', 'Código interno do cliente deve ser informado');
        } else {
            if ($entidade->getId() <= 0) {
                $this->validadorResultado->addErro('Código interno do cliente', 'Código interno do cliente deve ser maior que zero.');
            }
        }
        $this->setValidarCadastro($entidade);
        return $this->validadorResultado;
    }

}
