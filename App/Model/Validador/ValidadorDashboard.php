<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeDashboard;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de validação de registros de DASHBOARDS 
 * registrados denro do sistema.
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      28/06/2021
 */
class ValidadorDashboard extends ValidadorBase {

    /**
     * Lista de registros de imagem disponiveis dentro do sistema.
     * @var array
     */
    private $LIST_IMAGEM_DASHBOARD = ['dashboard_default1.png', 'dashboard_default2.png', 'dashboard_default3.png'];

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
     * <br>Efetua validação de edição de registro informado.
     * 
     * @param     EntidadeDashboard $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function setValidarEditor(EntidadeDashboard $entidade) {
        //NOME
        if (empty($entidade->getNome()) || !$this->isLenght($entidade->getNome(), 4, 30)) {
            $this->validadorResultado->addErro('Nome do registro', 'Nome do dashboard informado considerado inválido');
        }
        //DESCRIÇÃO
        if (empty($entidade->getDescricao()) || !$this->isLenght($entidade->getDescricao(), 4, 120)) {
            $this->validadorResultado->addErro('Descrição do registro', 'Descrição do dashboard informado considerado inválido');
        }
        //NOME IMAGEM
        if (empty($entidade->getNomeImagem()) || !$this->isLenght($entidade->getNomeImagem(), 4, 50) || !in_array($entidade->getNomeImagem(), $this->LIST_IMAGEM_DASHBOARD)) {
            $this->validadorResultado->addErro('Imagem do script', 'Imagem do script do dashboard informado considerado inválido');
        }
        return $this->validadorResultado;
    }

}
