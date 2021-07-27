<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Validador\ValidadorResultado;
use App\Model\Entidade\EntidadeAlmoxarifadoProdutoSaida;
use App\Model\DAO\AlmoxarifadoProdutoDAO;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas validações de movimentos de SAÍDA de produtos dentro 
 * do sistema.
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      22/07/2021
 */
class ValidadorAlmoxarifadoProdutoSaida extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependecias do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      21/07/2021
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de cadastro de registro informado por parametro.
     * 
     * @param     EntidadeAlmoxarifadoProdutoSaida $entidade Entidade 
     *            carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      21/07/2021
     */
    function setValidarCadastro(EntidadeAlmoxarifadoProdutoSaida $entidade) {
        //PRODUTO SELECIONADO
        $produtoDAO = new AlmoxarifadoProdutoDAO();
        if (empty($entidade->getFkProduto()) || $entidade->getFkProduto() <= 0) {
            $this->validadorResultado->addErro('Código do produto', 'Código interno do produto informado considerado inválido');
        } else {
            if ($produtoDAO->getEntidade($entidade->getFkProduto())->getId() <= 0) {
                $this->validadorResultado->addErro('Produto informado', 'Produto informado não foi encontrado dentro do sistema');
            }
        }
        //VALOR DE SAIDA
        if (empty($entidade->getValorSaida()) || $entidade->getValorSaida() <= 0) {
            $this->validadorResultado->addErro('Valor de saída', 'Valor de saída do produto deve ser maior que 0 (zero)');
        } else {
            $estoqueAtual = $produtoDAO->getEntidade($entidade->getFkProduto())->getSaldoAtual();
            if ($estoqueAtual < $entidade->getValorSaida()) {
                $this->validadorResultado->addErro('Valor de saída', 'Valor de saída do produto deve ser menor/igual ao disponivel no estoque: ' . $estoqueAtual);
            }
        }
        if (empty($entidade->getValorSaida()) || $entidade->getValorSaida() <= 0) {
            $this->validadorResultado->addErro('Valor de saída', 'Valor de saída do produto deve ser maior que 0 (zero)');
        }
        if (empty($entidade->getComentario()) || !$this->isLenght($entidade->getComentario(), 1, 250)) {
            $this->validadorResultado->addErro('Comentário do movimento', 'Comentário do movimento de saída de produto deve conter entre 4 e 250 caracteres');
        }
        return $this->validadorResultado;
    }

}
