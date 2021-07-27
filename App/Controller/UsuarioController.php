<?php

namespace App\Controller;

use App\Model\DAO\UsuarioDAO;
use App\Lib\Sessao;
use App\Model\Entidade\EntidadeUsuario;
use App\Model\Validador\ValidadorUsuario;
use App\Model\DAO\UsuarioConfiguracaoDAO;
use App\Model\Entidade\EntidadeUsuarioConfiguracao;
use App\Model\DAO\NotificacaoDAO;
use App\Model\DAO\PermissaoDAO;
use App\Model\DAO\DashboardDAO;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações relacionadas aos usuarios do sistema.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class UsuarioController extends Controller {

    /**
     * ID padrão de controle de usuarios dentro do sistema.
     * @var integer 
     */
    private $ID_PERMISSAO = 1;

    ////////////////////////////////////////////////////////////////////////////
    //                                - PAGES -                               // 
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>PAGE</b>
     * <br>Interfase de controle de registros de usuarios cadastrados dentro do
     * sistema, efetua controle de solicitações de usuarios.
     * 
     * @author    Manoel Louro manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            @$_POST['situacao'] ? $_SESSION['usuario_controle_situacao'] = $_POST['situacao'] : $_SESSION['usuario_controle_situacao'] = 3;
            $this->setViewParam('tituloPagina', 'Controle de Usuários');
            $this->render('usuario/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>PAGE</b>
     * <br>Editor de registro de usuario cadastrado no sistema.
     * OBS: Somente ADMINISTRADOR ou SUPERIOR poderá alterar permissões e 
     * credenciais do usuario.
     * 
     * @param     array $GET $_GET informado com ID do registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function editor($GET) {
        if (isset($GET) && $GET[0]) {
            $usuarioDAO = new UsuarioDAO();
            if (Sessao::getUsuario()->getId() === $GET[0]) {
                $this->controle();
                die();
            } else if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                $this->setViewParam('ID', intval($GET[0]));
                $this->setViewParam('tituloPagina', 'Editor de Usuário');
                $this->render('/usuario/editor');
                die();
            }
        }
        $this->redirect('/');
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna recurso solicitado por parametro.
     * 
     * @return    array Lista de recursos solicitados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Retorna estatistica de registros de usuarios cadastrados.
                 */
                case 'getEstatisticaUsuarioSistema':
                    $retorno = [];
                    $usuarioDAO = new UsuarioDAO();
                    $retorno[0] = $usuarioDAO->getTotalUsuario();
                    $retorno[1] = $usuarioDAO->getTotalUsuarioAtivo();
                    $retorno[2] = $usuarioDAO->getTotalUsuarioInativo();
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista paginada de registros cadastrados de acordo com 
                 * parametros enviados.
                 */
                case 'getListaControleNovo' :
                    $retorno = [];
                    $usuarioDAO = new UsuarioDAO();
                    //DAO
                    $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                    $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $retorno['totalRegistro'] = $usuarioDAO->getListaControleTotal(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['empresa'] ? $_POST['empresa'] : 1,
                                @$_POST['situacao'] ? $_POST['situacao'] : null);
                        $retorno['listaRegistro'] = $usuarioDAO->getListaControle(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['empresa'] ? $_POST['empresa'] : 1,
                                @$_POST['situacao'] ? $_POST['situacao'] : null, null,
                                @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                                @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                        );
                    } else {
                        $retorno['totalRegistro'] = $usuarioDAO->getListaControleTotal(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['empresa'] ? $_POST['empresa'] : 1,
                                @$_POST['situacao'] ? $_POST['situacao'] : null);
                        $retorno['listaRegistro'] = $usuarioDAO->getListaControle(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['empresa'] ? $_POST['empresa'] : 1,
                                @$_POST['situacao'] ? $_POST['situacao'] : null,
                                Sessao::getUsuario()->getId(),
                                @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                                @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                        );
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista para controle de registros cadastrados.
                 */
                case 'getListaControle':
                    $retorno = [];
                    @$_POST['situacao'] ? $_SESSION['usuario_controle_situacao'] = $_POST['situacao'] : $_SESSION['usuario_controle_situacao'] = 3;
                    @$_POST['pesquisa'] ? $_SESSION['usuario_controle_pesquisa'] = $_POST['pesquisa'] : $_SESSION['usuario_controle_pesquisa'] = '';
                    $usuarioDAO = new UsuarioDAO();
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $retorno = $usuarioDAO->getListaRegistroControleUsuario(@$_POST['pesquisa'], @$_POST['situacao'], (@$_POST['empresa'] ? $_POST['empresa'] : Sessao::getUsuario()->getFkEmpresa()));
                    } else {
                        $retorno = $usuarioDAO->getListaRegistroControleUsuario(@$_POST['pesquisa'], @$_POST['situacao'], (@$_POST['empresa'] ? $_POST['empresa'] : Sessao::getUsuario()->getFkEmpresa()), Sessao::getUsuario()->getId());
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna registro de acordo com parametro informado
                 */
                case 'getRegistro':
                    $retorno = [];
                    if (@$_POST['idRegistro']) {
                        $usuarioDAO = new UsuarioDAO();
                        $retorno = $usuarioDAO->getRegistroVetor($_POST['idRegistro']);
                        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO) || Sessao::getUsuario()->getId() == $_POST['idRegistro']) {
                            $retorno['tipoConsulta'] = '1';
                        } else {
                            $retorno['tipoConsulta'] = '2';
                        }
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de permissões do usuário informado.
                 */
                case 'getListaPermissaoUsuario':
                    $retorno = [];
                    if (@$_POST['idUsuario']) {
                        $permissaoDAO = new PermissaoDAO();
                        $usuarioDAO = new UsuarioDAO();
                        if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario'])) {
                            $retorno = $permissaoDAO->getListaRegistroControle();
                        } else {
                            $retorno = $permissaoDAO->getPermissaoUsuarioVetor($_POST['idUsuario']);
                        }
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de dashboards dispónivies do usuário.
                 */
                case 'getListaDashboardUsuario':
                    $retorno = [];
                    $dashboardDAO = new DashboardDAO();
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                        $retorno = $dashboardDAO->getListaDashboardVetor(null);
                    } else {
                        $retorno = $dashboardDAO->getListaDashboardVetor(Sessao::getUsuario()->getId());
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de dashboards dispónivies do usuário.
                 */
                case 'getListaSubordinadoUsuario':
                    $retorno = [];
                    $usuarioDAO = new UsuarioDAO();
                    $retorno = $usuarioDAO->getListaSubordinadoUsuarioVetor(@$_POST['idUsuario']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de usuarios ativos dentro do sistema.
                 */
                case 'getListaUsuarioAtivo':
                    $retorno = [];
                    $usuarioDAO = new UsuarioDAO();
                    $retorno = $usuarioDAO->getListaUsuarioNomeVetor(1, @$_POST['empresa'] ? $_POST['empresa'] : Sessao::getUsuario()->getFkEmpresa());
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de notificações pendentes do usuario logado.
                 */
                case 'getNotificacaoPendenteUsuario':
                    $retorno = [];
                    $dao = new NotificacaoDAO();
                    $retorno = $dao->getNotificacaoPendente(Sessao::getUsuario()->getId());
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de usuários de acordo
                 */
                case 'getListaUsuarioOrdenadoDepartamento':
                    $usuarioDAO = new UsuarioDAO();
                    $retorno = $usuarioDAO->getListaUsuarioDepartamento(@$_POST['empresa'] ? $_POST['empresa'] : Sessao::getUsuario()->getFkEmpresa());
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de registros ordenados por departamento.
                 */
                case 'getListaUsuarioPorDepartamento':
                    $retorno = [];
                    $usuarioDAO = new UsuarioDAO();
                    $retorno = $usuarioDAO->getListaUsuarioSimplesArray(
                            @$_POST['situacaoRegistro'] ? $_POST['situacaoRegistro'] : null,
                            @$_POST['empresa'] ? $_POST['empresa'] : Sessao::getUsuario()->getFkEmpresa()
                    );
                    print_r(json_encode($retorno));
                    die();
            }
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua inserções/alterações de registros dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function setRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Efetua cadastrado de registro informado por POST.
                 */
                case 'setRegistro':
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $entidade = new EntidadeUsuario();
                        $entidade->setNomeCompleto(@$_POST['cardCadastroNomeCompleto']);
                        $entidade->setNomeSistema(@$_POST['cardCadastroNomeSistema']);
                        $entidade->setCelular(@$_POST['cardCadastroCelular']);
                        $entidade->setEmail(@$_POST['cardCadastroEmail']);
                        $entidade->setFkSuperior(@$_POST['cardCadastroSuperior']);
                        $entidade->setFkDepartamento(@$_POST['cardCadastroDepartamento']);
                        $entidade->setFkEmpresa(@$_POST['cardCadastroEmpresa']);
                        $entidade->setLogin(@$_POST['cardCadastroLogin']);
                        $entidade->setImagemPerfil(isset($_FILES['cardCadastroPerfil']) && !empty($_FILES['cardCadastroPerfil']['name']) ? convertePostFileBase64($_FILES['cardCadastroPerfil']) : '');
                        //VALIDAÇÃO
                        $validador = new ValidadorUsuario();
                        $resultado = $validador->setValidarCadastro($entidade);
                        if ($resultado->getErros()) {
                            print_r(json_encode($resultado->getErros()));
                            die();
                        }
                        $usuarioDAO = new UsuarioDAO();
                        if (empty($usuarioDAO->getUsuarioPorLogin($entidade->getLogin())->getId())) {
                            $senha = rand(100000, 999999);
                            $idUsuario = $usuarioDAO->setCadastrarUsuario($entidade, $senha);
                            if ($idUsuario > 0) {
                                //PERMISSÕES
                                $permissaoDAO = new PermissaoDAO();
                                if (!empty($_POST['cardCadastroPermissao'])) {
                                    $permissoes = explode(',', @$_POST['cardCadastroPermissao']);
                                    for ($i = 0; $i < count($permissoes); $i++) {
                                        $permissaoDAO->setPermissaoUsuario($permissoes[$i], $idUsuario);
                                    }
                                } else {
                                    $permissoes = $permissaoDAO->getListaPermissaoPadraoDepartamento($entidade->getFkDepartamento());
                                    for ($i = 0; $i < count($permissoes); $i++) {
                                        $permissaoDAO->setPermissaoUsuario($permissoes[$i]['id'], $idUsuario);
                                    }
                                }
                                //DASHBOARD
                                $dashboardDAO = new DashboardDAO();
                                $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                                if (@$_POST['cardAdicionarDashboard1'] && $_POST['cardAdicionarDashboard1'] > 0) {
                                    $dashboardDAO->setDashboardUsuario($_POST['cardAdicionarDashboard1'], $idUsuario);
                                    $usuarioConfigDAO->setUsuarioConfiguracao($idUsuario, 3, $_POST['cardAdicionarDashboard1']);
                                }
                                if (@$_POST['cardAdicionarDashboard2'] && $_POST['cardAdicionarDashboard2'] > 0) {
                                    $dashboardDAO->setDashboardUsuario($_POST['cardAdicionarDashboard2'], $idUsuario);
                                    $usuarioConfigDAO->setUsuarioConfiguracao($idUsuario, 4, $_POST['cardAdicionarDashboard2']);
                                }
                                if (@$_POST['cardAdicionarDashboard3'] && $_POST['cardAdicionarDashboard3'] > 0) {
                                    $dashboardDAO->setDashboardUsuario($_POST['cardAdicionarDashboard3'], $idUsuario);
                                    $usuarioConfigDAO->setUsuarioConfiguracao($idUsuario, 5, $_POST['cardAdicionarDashboard3']);
                                }
                                echo '0';
                                die();
                            }
                            echo '1';
                            die();
                        } else {
                            echo '2';
                            die();
                        }
                    }
                    break;
                /**
                 * Efetua atualização de perfil do usuário.
                 */
                case 'setAtualizarPerfil':
                    $entidade = new EntidadeUsuario();
                    $entidade->setId(Sessao::getUsuario()->getId());
                    $entidade->setNomeSistema(@$_POST['cardUsuarioPerfilNomeSistema']);
                    $entidade->setNomeCompleto(@$_POST['cardUsuarioPerfilNomeCompleto']);
                    $entidade->setEmail(@$_POST['cardUsuarioPerfilEmail']);
                    $entidade->setCelular(@$_POST['cardUsuarioPerfilCelular']);
                    $entidade->setLogin(@$_POST['cardUsuarioPerfilLogin']);
                    $entidade->setSenha(@$_POST['cardUsuarioPerfilSenha']);
                    $entidade->setImagemPerfil(isset($_FILES['cardUsuarioPerfilFile']) && !empty($_FILES['cardUsuarioPerfilFile']['name']) ? convertePostFileBase64($_FILES['cardUsuarioPerfilFile']) : '');
                    $validador = new ValidadorUsuario();
                    $resultadoValidador = $validador->setValidarPerfilGeral($entidade, isset($_POST['cardUsuarioPerfilNovaSenha']) ? $_POST['cardUsuarioPerfilNovaSenha'] : '');
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DASHBOARD 1
                    $dashboard1 = new EntidadeUsuarioConfiguracao();
                    $dashboard1->setId(3);
                    $dashboard1->setFkUsuario($entidade->getId());
                    $dashboard1->setValor(!empty(@$_POST['cardUsuarioPerfilDashboard1']) ? @$_POST['cardUsuarioPerfilDashboard1'] : 0);
                    //DASHBOARD 2
                    $dashboard2 = new EntidadeUsuarioConfiguracao();
                    $dashboard2->setId(4);
                    $dashboard2->setFkUsuario($entidade->getId());
                    $dashboard2->setValor(!empty(@$_POST['cardUsuarioPerfilDashboard2']) ? @$_POST['cardUsuarioPerfilDashboard2'] : 0);
                    //DASHBOARD 3
                    $dashboard3 = new EntidadeUsuarioConfiguracao();
                    $dashboard3->setId(5);
                    $dashboard3->setFkUsuario($entidade->getId());
                    $dashboard3->setValor(!empty(@$_POST['cardUsuarioPerfilDashboard3']) ? @$_POST['cardUsuarioPerfilDashboard3'] : 0);
                    //VALIDADOR
                    $validador = new ValidadorUsuario();
                    $resultadoValidador = $validador->setValidarPerfilDashboard($dashboard1, $dashboard2, $dashboard3);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO
                    $usuarioDAO = new UsuarioDAO();
                    if ($usuarioDAO->setAtualizarPerfil($entidade, isset($_POST['cardUsuarioPerfilNovaSenha']) ? $_POST['cardUsuarioPerfilNovaSenha'] : null)) {
                        $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                        $usuarioConfigDAO->setUsuarioConfiguracao($dashboard1->getFkUsuario(), $dashboard1->getId(), $dashboard1->getValor());
                        $usuarioConfigDAO->setUsuarioConfiguracao($dashboard2->getFkUsuario(), $dashboard2->getId(), $dashboard2->getValor());
                        $usuarioConfigDAO->setUsuarioConfiguracao($dashboard3->getFkUsuario(), $dashboard3->getId(), $dashboard3->getValor());
                        Sessao::setSessao($usuarioDAO->getEntidade(Sessao::getUsuario()->getId()));
                        echo 0;
                        die();
                    }
                    break;
                /**
                 * Atualiza registros relacionados as informações publicas do 
                 * usuario informado.
                 */
                case 'setEditorUsuarioInformacaoPublico' :
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $entidade = new EntidadeUsuario();
                        $entidade->setId(@$_POST['usuarioID']);
                        $entidade->setFkEmpresa(@$_POST['usuarioEmpresa']);
                        $entidade->setNomeSistema(@$_POST['nomeSistema']);
                        $entidade->setNomeCompleto(@$_POST['nomeCompleto']);
                        $entidade->setEmail(@$_POST['email']);
                        $entidade->setCelular(@$_POST['celular']);
                        $entidade->setUsuarioAtivo(@$_POST['usuarioAtivo']);
                        $entidade->setImagemPerfil(isset($_FILES['imagemPerfil']) && !empty($_FILES['imagemPerfil']['name']) ? convertePostFileBase64($_FILES['imagemPerfil']) : '');
                        //VALIDADOR
                        $validador = new ValidadorUsuario();
                        $resultado = $validador->setValidarInformacaoPublica($entidade);
                        if ($resultado->getErros()) {
                            print_r(json_encode($resultado->getErros()));
                            die();
                        }
                        $usuarioDAO = new UsuarioDAO();
                        if ($usuarioDAO->setEditarInformacaoPublicaUsuario($entidade)) {
                            echo '0';
                            die();
                        }
                    }
                    break;
                /**
                 * Atualiza crendenciais do usuário/reenvia crendenciais para 
                 * e-mail/celular informado ou padrão.
                 */
                case 'setEditorUsuarioCredencial':
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        //AUXILIARES
                        $emailAuxiliar = @$_POST['emailAuxiliar'];
                        $enviarEmail = isset($_POST['enviarEmail']) ? true : false;
                        $enviarCelular = isset($_POST['enviarCelular']) ? true : false;
                        //POST
                        $entidade = new EntidadeUsuario();
                        $entidade->setId(@$_POST['idUsuario']);
                        $entidade->setLogin(@$_POST['login']);
                        $entidade->setFkDepartamento(@$_POST['departamento']);
                        $entidade->setFkSuperior(@$_POST['idSuperior']);
                        $entidade->setSenha(@$_POST['novaSenha']);
                        //VALIDADOR
                        $validador = new ValidadorUsuario();
                        $resultado = $validador->setValidarCredenciais($entidade);
                        if ($resultado->getErros()) {
                            print_r(json_encode($resultado->getErros()));
                            die();
                        }
                        $usuarioDAO = new UsuarioDAO();
                        if ($usuarioDAO->setEditarCredenciaisUsuario($entidade)) {
                            if (isset($_POST['novaSenha'])) {
                                //SEND E-MAIL
                                $entidade = $usuarioDAO->getEntidade($_POST['idUsuario']);
                                if ($enviarEmail) {
                                    //EMPTY
                                }
                                //SEND SMS
                                if ($enviarCelular) {
                                    //EMPTY
                                }
                            }
                            echo 0;
                            die();
                        }
                        break;
                    }
            }
        }
        echo 1;
    }

}
