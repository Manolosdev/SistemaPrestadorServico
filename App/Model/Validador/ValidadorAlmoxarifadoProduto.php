<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Validador\ValidadorResultado;
use App\Model\Entidade\EntidadeAlmoxarifadoProduto;
use App\Model\DAO\AlmoxarifadoProdutoDAO;

/**
 * <b>CLASS</b>
 * 
 * Efetua validação de PRODUTOS dentro do sistema.
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      20/07/2021
 */
class ValidadorAlmoxarifadoProduto extends ValidadorBase {

    /**
     * Lista de unidade de medidas disponiveis.
     * @var array
     */
    private $LISTA_UNIDADE_MEDIDA = ['CJ', 'CX', 'GL', 'JG', 'KG', 'LATA', 'M', 'M3', 'ML', 'MT', 'MWh', 'PC', 'PCT', 'PR', 'RL', 'T', 'UN'];

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependecias do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      20/07/2021
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de CADASTRO de registro. 
     * 
     * @param     EntidadeAlmoxarifadoProduto $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      20/07/2021
     */
    function setValidarCadastro(EntidadeAlmoxarifadoProduto $entidade) {
        //CODIGO DO PRODUTO
        $produtoDAO = new AlmoxarifadoProdutoDAO();
        if (!empty($entidade->getCodigoProduto())) {
            if (!$this->isLenght($entidade->getNome(), 1, 50)) {
                $this->validadorResultado->addErro('Código do produto', 'Código do produto informado deve conter entre 1 e 50 caracteres');
            } else if ($produtoDAO->getEntidadePorCodigo($entidade->getCodigoProduto(), $entidade->getFkEmpresa())->getId() > 0) {
                $this->validadorResultado->addErro('Código do produto', 'Código do produto informado JÁ cadastrado dentro do sistema');
            }
        }
        //NOME
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 70)) {
            $this->validadorResultado->addErro('Nome do produto', 'Nome do produto informado deve conter entre 4 e 70 caracteres');
        }
        //DESCRIÇÃO
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 4, 250)) {
            $this->validadorResultado->addErro('Descrição do produto', 'Descrição do produto informado deve conter entre 4 e 250 caracteres');
        }
        //EMPRESA
        if (empty($entidade->getFkEmpresa()) || $entidade->getFkEmpresa() <= 0) {
            $this->validadorResultado->addErro('Empresa do produto', 'Empresa do produto informado considerado inválido');
        }
        //PRATELEIRA
        if (empty($entidade->getFkPrateleira()) || $entidade->getFkPrateleira() <= 0) {
            $this->validadorResultado->addErro('Prateleira do produto', 'Prateleira do produto informado considerado inválido');
        }
        //VALOR DE COMPRA
        if (empty($entidade->getValorCompra()) || floatval($entidade->getValorCompra()) < 0) {
            $this->validadorResultado->addErro('Valor de compra do produto', 'Valor de compra do produto informado deve ser maior/igual a R$ 0,00');
        }
        //VALOR DE VENDA
        if (empty($entidade->getValorVenda()) || floatval($entidade->getValorVenda()) < 0) {
            $this->validadorResultado->addErro('Valor de venda do produto', 'Valor de venda do produto informado deve ser maior/igual a R$ 0,00');
        }
        //VALOR DE VENDA
        if (empty($entidade->getValorVenda()) || floatval($entidade->getValorVenda()) < 0) {
            $this->validadorResultado->addErro('Valor de venda do produto', 'Valor de venda do produto informado deve ser maior/igual a R$ 0,00');
        }
        //UNIDADE DE MEDIDA
        if (empty($entidade->getUnidadeMedida()) || !in_array($entidade->getUnidadeMedida(), $this->LISTA_UNIDADE_MEDIDA)) {
            $this->validadorResultado->addErro('Unidade de medida do produto', 'Unidade de medida do produto informado considerado inválido');
        }
        //SALDO MINIMO
        if (empty($entidade->getSaldoMinimo()) || intval($entidade->getSaldoMinimo()) < 0) {
            $this->validadorResultado->addErro('Saldo minimo do produto', 'Valor de saldo minimo do produto informado deve ser maior/igual a 0');
        }
        return $this->validadorResultado;
    }

}
