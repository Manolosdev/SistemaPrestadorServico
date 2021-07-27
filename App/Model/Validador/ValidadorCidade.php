<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeCidade;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pela validação de cidades dentro do sistema.
 * 
 * @package   App\Validador
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      28/06/2021
 */
class ValidadorCidade extends ValidadorBase {

    /**
     * Lista de UF disponivel no Brasil
     * @var array
     */
    private $LISTA_UF = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
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
     * <br>Efetua validação de INSERT de registro
     * 
     * @param     EntidadeCidade $entidade Entidade carregada
     * @return    ResultadoValidador Lista com resultado da validacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function setAdicionar(EntidadeCidade $entidade) {
        //NOME 
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 30)) {
            $this->validadorResultado->addErro('nome', 'nome inválido');
        }
        //IBGE 
        if (empty($entidade->getIbge()) || intval($entidade->getIbge()) <= 0) {
            $this->validadorResultado->addErro('ibge', 'IBGE inválido');
        }
        //SIGLA 
        if (empty($entidade->getSigla()) || !$this->isLenght($entidade->getSigla(), 3, 4)) {
            $this->validadorResultado->addErro('sigla', 'sigla inválido');
        }
        //UF
        if (empty($entidade->getUF()) || !$this->isLenght($entidade->getUF(), 2, 2)) {
            $this->validadorResultado->addErro('uf', 'UF inválido');
        } else {
            if (!in_array($entidade->getUF(), $this->LISTA_UF)) {
                $this->validadorResultado->addErro('uf', 'UF inválido');
            }
        }
        return $this->validadorResultado;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de edição de CIDADE informada por parametro.
     * 
     * @param     EntidadeCidade $entidade Entidade carregada
     * @return    ResultadoValidador Lista com resultado da validacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function setEditor(EntidadeCidade $entidade) {
        //ID
        if (empty($entidade->getId()) || intval($entidade->getId()) <= 0) {
            $this->validadorResultado->addErro('ID da cidade', 'ID informado considerado inválido');
        }
        if (intval($entidade->getAtivo()) < 0 || intval($entidade->getAtivo()) > 1) {
            $this->validadorResultado->addErro('Situação da cidade', 'Situação informada considerada inválida');
        }
        //IBGE
        if (empty($entidade->getIbge()) || intval($entidade->getIbge()) <= 0) {
            $this->validadorResultado->addErro('IBGE da cidade', 'IBGE informado considerado inválido');
        }
        //NOME 
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 30)) {
            $this->validadorResultado->addErro('Nome da cidade', 'Nome informado considerado inválido');
        }
        //SIGLA 
        if (empty($entidade->getSigla()) || !$this->isLenght($entidade->getSigla(), 3, 4)) {
            $this->validadorResultado->addErro('Sigla da cidade', 'Sigla informada considerada inválida');
        }
        //UF
        if (empty($entidade->getUF()) || !$this->isLenght($entidade->getUF(), 2, 2)) {
            $this->validadorResultado->addErro('UF da cidade', 'UF informado considerado inválido');
        } else {
            if (!in_array($entidade->getUF(), $this->LISTA_UF)) {
                $this->validadorResultado->addErro('UF da cidade', 'UF informado não pode ser encontrado');
            }
        }
        return $this->validadorResultado;
    }

}
