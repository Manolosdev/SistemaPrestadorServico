<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\DAO\EmpresaDAO;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsável por operações relacionadas a empresas cadastradas dentro 
 * do sistema.
 * 
 * @package   App\Controller
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      26/06/2021
 */
class EmpresaController extends Controller {

    /**
     * <b>FUNCTION</b>
     * <br>Retorna registros solicitados por parametro.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Retorna dados da empresa solicitada por parametro.
                 * @return array
                 */
                case 'getRegistro' :
                    $retorno = [];
                    $empresaDAO = new EmpresaDAO();
                    $retorno = $empresaDAO->getRegistroVetor(@$_POST['empresaID'] ? $_POST['empresaID'] : Sessao::getUsuario()->getFkEmpresa());
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de registro ativos e visiveis dentro do sistema
                 */
                case 'getEmpresaVisivel':
                    $empresaDAO = new EmpresaDAO();
                    print_r(json_encode($empresaDAO->getListaControle(1, 1)));
                    die();
                /**
                 * Retorna lista de registros cadastros dentro do sistema
                 */
                case 'getEmpresaGeral':
                    $empresaDAO = new EmpresaDAO();
                    print_r(json_encode($empresaDAO->getListaControle(10, 1)));
                    die();
                /**
                 * Retorna lista de registro ativos e visiveis dentro do sistema
                 */
                case 'getEmpresaUsuario':
                    $empresaDAO = new EmpresaDAO();
                    print_r(json_encode($empresaDAO->getRegistroVetorSimples(Sessao::getUsuario()->getFkEmpresa())));
                    die();
                /**
                 * Retorna STORE_ID do sistema SITEF da empresa informada ou 
                 * usuario logado.
                 */
                case 'getSitefStoreIdUsuario':
                    $empresaDAO = new EmpresaDAO();
                    print_r(json_encode($empresaDAO->getEntidade(@$_POST['empresaID'] ? $_POST['empresaID'] : Sessao::getUsuario()->getFkEmpresa())->getIntegracaoSitefStoreID()));
                    die();
                /**
                 * Retorna codigo do SITEF para o parametro 'ParmsClient=1' do 
                 * sistema SITEF sem caracteres especiais.
                 */
                case 'getSitefParamEmpresaUsuario':
                    $empresaDAO = new EmpresaDAO();
                    print_r(json_encode(str_replace(['.', '-', '/'], '', $empresaDAO->getEntidade(@$_POST['empresaID'] ? $_POST['empresaID'] : Sessao::getUsuario()->getFkEmpresa())->getCnpj())));
                    die();
                /**
                 * Retorna lista de empresas cadastrada no sistema
                 */
                case 'getEmpresaCompra':
                    $empresaDAO = new EmpresaDAO();
                    print_r(json_encode($empresaDAO->getListaControle(1, 1)));
                    die();
            }
        }
        echo 1;
    }

}
