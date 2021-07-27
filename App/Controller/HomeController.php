<?php

namespace App\Controller;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações da tela inicial do sistema.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class HomeController extends Controller {

    /**
     * <b>PAGE</b>
     * <br>Função de chamada da pagina dashboard do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function index() {
        $this->setViewParam('tituloPagina', 'Dashboard');
        $this->render('home/index');
    }

}
