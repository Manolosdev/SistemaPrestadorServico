<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Validador\ValidadorResultado;
use App\Model\Entidade\EntidadeAlmoxarifadoProdutoEntrada;
use App\Model\DAO\AlmoxarifadoProdutoDAO;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas validações de movimentos de ENTRADA de produtos 
 * dentro do sistema.
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      21/07/2021
 */
class ValidadorAlmoxarifadoProdutoEntrada extends ValidadorBase {

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
     * @param     EntidadeAlmoxarifadoProdutoEntrada $entidade Entidade 
     *            carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      21/07/2021
     */
    function setValidarCadastro(EntidadeAlmoxarifadoProdutoEntrada $entidade) {
        //PRODUTO SELECIONADO
        if (empty($entidade->getFkProduto()) || $entidade->getFkProduto() <= 0) {
            $this->validadorResultado->addErro('Código do produto', 'Código interno do produto informado considerado inválido');
        } else {
            $produtoDAO = new AlmoxarifadoProdutoDAO();
            if ($produtoDAO->getEntidade($entidade->getFkProduto())->getId() <= 0) {
                $this->validadorResultado->addErro('Produto informado', 'Produto informado não foi encontrado dentro do sistema');
            }
        }
        //VALOR DE ENTRADA
        if (empty($entidade->getValorEntrada()) || $entidade->getValorEntrada() <= 0) {
            $this->validadorResultado->addErro('Valor de entrada', 'Valor de entrada do produto deve ser maior que 0 (zero)');
        }
        if (empty($entidade->getComentario()) || !$this->isLenght($entidade->getComentario(), 1, 250)) {
            $this->validadorResultado->addErro('Comentário do movimento', 'Comentário do movimento de entrada de produto deve conter entre 4 e 250 caracteres');
        }
        return $this->validadorResultado;
    }

}
