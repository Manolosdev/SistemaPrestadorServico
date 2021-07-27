<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\DAO\DashboardDAO;
use App\Model\DAO\UsuarioDAO;
use App\Model\DAO\UsuarioConfiguracaoDAO;
use App\Model\Entidade\EntidadeUsuarioConfiguracao;
use App\Model\Entidade\EntidadeDashboard;
use App\Model\Validador\ValidadorDashboard;
use App\Model\DAO\ErroLogDAO;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsável por operações relacionadas a area inicial do sistema.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      24/06/2021
 */
class DashboardController extends Controller {

    /**
     * Permissão principal
     * @var integer 
     */
    private $ID_PERMISSAO = 1;

    /**
     * <b>PAGE</b>
     * <br>Chamada de pagina de controle de registros dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Dashboard');
            $this->render('dashboard/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Objeto responsavel pelas operações de inserção de dados do FRONT-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/06/2021
     */
    function setRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Efetua edição do registro informado.
             */
            case 'setEditarRegistro':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $entidade = new EntidadeDashboard();
                    $entidade->setId(@$_POST['cardEditorID']);
                    $entidade->setNome(@$_POST['cardEditorNome']);
                    $entidade->setDescricao(@$_POST['cardEditorDescricao']);
                    $entidade->setFkDepartamento(@$_POST['cardEditorDepartamento']);
                    $entidade->setNomeImagem(@$_POST['cardEditorScriptImg']);
                    //VALIDATION
                    $validador = new ValidadorDashboard();
                    $resultadoValidador = $validador->setValidarEditor($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO
                    $dashboardDAO = new DashboardDAO();
                    if ($dashboardDAO->setEditar($entidade) === 0) {
                        echo 1;
                        die();
                    }
                    echo 0;
                    die();
                }
                break;
            /**
             * Adiciona dashboard ao usuario informado.
             */
            case 'setAdicionarDashboardUsuario' :
                if (@$_POST['idDashboard']) {
                    $dashboardDAO = new DashboardDAO();
                    $usuarioDAO = new UsuarioDAO();
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                        if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario'])) {
                            echo 0;
                            die();
                        }
                        if ($dashboardDAO->getUsuarioPossuiDashboard($_POST['idDashboard'], $_POST['idUsuario']) || $dashboardDAO->setDashboardUsuario($_POST['idDashboard'], $_POST['idUsuario'])) {
                            $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                            $usuarioConfigDAO->setRemoverDashboardUsuario($_POST['idUsuario'], $_POST['idDashboard']);
                            echo 0;
                            die();
                        }
                    } else if ($dashboardDAO->getUsuarioPossuiDashboard($_POST['idDashboard'], Sessao::getUsuario()->getId())) {
                        if ($dashboardDAO->getUsuarioPossuiDashboard($_POST['idDashboard'], $_POST['idUsuario']) || $dashboardDAO->setDashboardUsuario($_POST['idDashboard'], $_POST['idUsuario'])) {
                            echo 0;
                            die();
                        }
                    }
                }
                break;
            /**
             * Remove dashboard ao usuario informado.
             */
            case 'setRemoverDashboardUsuario' :
                if (@$_POST['idUsuario'] && @$_POST['idDashboard']) {
                    $dashboardDAO = new DashboardDAO();
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                        if ($dashboardDAO->setDeletarDashboardUsuario($_POST['idUsuario'], $_POST['idDashboard'])) {
                            echo 0;
                            die();
                        }
                    } else if ($dashboardDAO->getUsuarioPossuiDashboard($_POST['idDashboard'], Sessao::getUsuario()->getId())) {
                        if ($dashboardDAO->setDeletarDashboardUsuario($_POST['idUsuario'], $_POST['idDashboard'])) {
                            echo 0;
                            die();
                        }
                    }
                    echo 1;
                    die();
                }
                break;
            /**
             * Configura dashboard enviado por parametro nas configurações 
             * de interfase do usuario logado.
             */
            case 'setDashboardUsuario' :
                if (@$_POST['idDashboard'] && @$_POST['posicao']) {
                    $dashboardDAO = new DashboardDAO();
                    if ($dashboardDAO->usuarioPossuiDashboard($_POST['idDashboard'], Sessao::getUsuario()->getId())) {
                        //VERIFICA SE O REGISTRO JA SE ENCONTR EM ALGUM SLOT
                        $configuracaoDAO = new UsuarioConfiguracaoDAO();
                        $configUsuario = $configuracaoDAO->getConfiguracaoUsuario(Sessao::getUsuario()->getId());
                        for ($i = 2; $i < 5; $i++) {
                            if (array_key_exists($i, $configUsuario)) {
                                if (intval($configUsuario[$i]->getParcelaValor()) === intval($_POST['idDashboard'])) {
                                    //USUARIO JÁ POSSUI DASHBOARD CONFIGURADO
                                    echo 2;
                                    die();
                                }
                            }
                        }
                        //ENTIDADE
                        $entidade = new EntidadeUsuarioConfiguracao();
                        $entidade->setFkUsuario(Sessao::getUsuario()->getId());
                        $entidade->setValor($_POST['idDashboard']);
                        if ($_POST['posicao'] === 'top') {
                            $entidade->setId(3);
                            if ($configuracaoDAO->setConfig($entidade)) {
                                echo 0;
                                die();
                            }
                        } else if ($_POST['posicao'] === 'mid') {
                            $entidade->setId(4);
                            if ($configuracaoDAO->setConfig($entidade)) {
                                echo 0;
                                die();
                            }
                        } else if ($_POST['posicao'] === 'bot') {
                            $entidade->setId(5);
                            if ($configuracaoDAO->setConfig($entidade)) {
                                echo 0;
                                die();
                            }
                        }
                    }
                }
                break;
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de registro solicitado por parametro.
     * 
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2020
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Retorna dados do registro solicitado por parametro.
                 */
                case 'getRegistro':
                    $retorno = [];
                    $dashboardDAO = new DashboardDAO();
                    $retorno = $dashboardDAO->getRegistro(@$_POST['idRegistro']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de registros utilizados no controle de registro
                 * @return array
                 */
                case 'getListaRegistroControle':
                    $retorno = [];
                    $dashboardDAO = new DashboardDAO();
                    //DAO
                    $retorno['totalRegistro'] = 0;
                    $retorno['listaRegistro'] = [];
                    $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                    $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $retorno['totalRegistro'] = $dashboardDAO->getListaControleTotal(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['departamento'] ? $_POST['departamento'] : null);
                        $retorno['listaRegistro'] = $dashboardDAO->getListaControle(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['departamento'] ? $_POST['departamento'] : null,
                                @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                                @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                        );
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna quantidade de permissões por cargo cadastrado.
                 */
                case 'getEstatisticaRegistroPorDepartamento':
                    $retorno = [];
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $dashboardDAO = new DashboardDAO();
                        $retorno = $dashboardDAO->getQuantidadeRegistroPorDepartamento();
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna total de registro cadastrados de acordo com filtros 
                 * aplicados.
                 * @return integer
                 */
                case 'getTotalRegistro':
                    $retorno = 0;
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $dashboardDAO = new DashboardDAO();
                        $retorno = $dashboardDAO->getTotalRegistro(@$_POST['departamentoID'] ? $_POST['departamentoID'] : null);
                    }
                    print_r($retorno);
                    die();
                /**
                 * Retorna lista de usuarios que possuem permissão informada.
                 */
                case 'getListaUsuarioRegistro':
                    $retorno = [];
                    $dashboardDAO = new DashboardDAO();
                    //DAO
                    $retorno['totalRegistro'] = 0;
                    $retorno['listaRegistro'] = [];
                    $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                    $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $retorno['totalRegistro'] = $dashboardDAO->getListaUsuarioRegistroTotal(@$_POST['registroID']);
                        $retorno['listaRegistro'] = $dashboardDAO->getListaUsuarioRegistro(
                                @$_POST['registroID'],
                                @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                                @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30);
                    }
                    print_r(json_encode($retorno));
                    die();

                /**
                 * Retorna lista de dashboards disponiveis ao usuario logado.
                 */
                case 'getListaDashboardDisponivel' :
                    $retorno = [];
                    $dashboardDAO = new DashboardDAO();
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                        $retorno = $dashboardDAO->getListaDashboardVetor();
                    } else {
                        $retorno = $dashboardDAO->getListaDashboardVetor(Sessao::getUsuario()->getId());
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de dashboard disponiveis do usuario.
                 */
                case 'getListaDashboardUsuario':
                    $retorno = [];
                    if (@$_POST['idUsuario']) {
                        $dashboardDAO = new DashboardDAO();
                        $usuarioDAO = new UsuarioDAO();
                        if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario'])) {
                            $retorno = $dashboardDAO->getListaDashboardVetor();
                        } else {
                            $retorno = $dashboardDAO->getListaDashboardVetor($_POST['idUsuario']);
                        }
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna registro de dashboard do usuario de acordo com 
                 * posicão enviada por parametro.
                 */
                case 'getDashboardUsuario' :
                    $retorno = [];
                    if (@$_POST['posicao']) {
                        $posicao = $_POST['posicao'];
                        $configDAO = new UsuarioConfiguracaoDAO();
                        $dashboardDAO = new DashboardDAO();
                        $lista = $configDAO->getConfiguracaoUsuario(Sessao::getUsuario()->getId());
                        foreach ($lista as $value) {
                            if ($posicao === 'top' && intval($value->getId()) === 3) {
                                $retorno = $dashboardDAO->getVetor($value->getParcelaValor());
                                break;
                            }
                            if ($posicao === 'mid' && intval($value->getId()) === 4) {
                                $retorno = $dashboardDAO->getVetor($value->getParcelaValor());
                                break;
                            }
                            if ($posicao === 'bot' && intval($value->getId()) === 5) {
                                $retorno = $dashboardDAO->getVetor($value->getParcelaValor());
                                break;
                            }
                        }
                    }
                    print_r(json_encode($retorno));
                    die();
            }
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Objeto responsavel pelas operações de impressão de relatorios via GET 
     * do FRONT-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/05/2021
     */
    function getRelatorioAJAX() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            //VETOR DE MESES
            $nomeMes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            //OPERAÇÕES
            switch (@$_GET['operacao']) {
                /**
                 * Relatorio geral de dashboard.
                 */
                case 'relatorioGeralDashboard':
                    switch (@$_GET['tipoRelatorio']) {
                        case 'pdf':
                            ob_start();
                            $urlLayout = 'public/documento/relatorio/controle/dashboard/relatorioGeralPDF.phtml';
                            $dashboardDAO = new DashboardDAO();
                            $listaRegistro = $dashboardDAO->getRelatorioGeral();
                            //VARIAVEIS DO PHTML -------------------------------
                            extract(array(
                                'APP_HOST' => APP_HOST,
                                'tituloRelatorio' => 'Relatorio geral de dashboards',
                                'usuarioNome' => Sessao::getUsuario()->getNomeSistema(),
                                'listaRegistro' => $listaRegistro
                            ));
                            //PDF ----------------------------------------------
                            include $urlLayout;
                            $contentHTML = ob_get_clean();
                            $arquivoPDF = '';
                            try {
                                $mpdf = new \Mpdf\Mpdf(['tempDir' => 'public/documento']);
                                $mpdf->WriteHTML($contentHTML);
                                $arquivoPDF = $mpdf->Output();
                            } catch (\Exception $erro) {
                                $erroDAO = new ErroLogDAO();
                                $erroDAO->setErro(__METHOD__, $erro->getMessage());
                            }
                            return $arquivoPDF;
                    }
                    break;
            }
        }
        echo 1;
    }

}
