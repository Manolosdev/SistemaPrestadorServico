<?php

namespace App\Lib;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por tratar erro de URL através da URL amigável 
 * executada no core do sistema.
 * 
 * @package   App\Lib
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      24/06/2021
 */
class ErroView {

    /**
     * Codigo do erro informado no construtor
     * @var integer 
     */
    private $code;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Contrutor da classe onde é carregado dependencias.
     * 
     * @param     integer $codigoErro Codigo do erro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      10/05/2019
     */
    function __construct($codigoErro) {
        $this->code = $codigoErro;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Determina e renderiza pagina de erro.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function render() {
        if (file_exists(PATH . "/App/View/error/" . $this->code . ".php")) {
            require_once PATH . "/App/View/error/" . $this->code . ".php";
        } else {
            require_once PATH . "/App/View/error/500.php";
        }
        exit;
    }

}
