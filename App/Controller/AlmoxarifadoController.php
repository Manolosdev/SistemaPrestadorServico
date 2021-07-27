<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\Validador\ValidadorAlmoxarifadoProduto;
use App\Model\Entidade\EntidadeAlmoxarifadoProduto;
use App\Model\DAO\AlmoxarifadoPrateleiraDAO;
use App\Model\DAO\AlmoxarifadoDAO;
use App\Model\Entidade\EntidadeAlmoxarifadoProdutoEntrada;
use App\Model\Entidade\EntidadeAlmoxarifadoProdutoSaida;
use App\Model\Validador\ValidadorAlmoxarifadoProdutoEntrada;
use App\Model\Validador\ValidadorAlmoxarifadoProdutoSaida;
use App\Model\DAO\AlmoxarifadoProdutoDAO;
use App\Model\DAO\AlmoxarifadoProdutoEntradaDAO;
use App\Model\DAO\AlmoxarifadoProdutoSaidaDAO;
use App\Model\Entidade\EntidadeAlmoxarifadoPrateleira;
use App\Model\Validador\ValidadorAlmoxarifadoPrateleira;
use App\Model\Entidade\EntidadeEndereco;
use App\Model\DAO\ErroLogDAO;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de controle de produtos dentro do sistema 
 * tais como entrada e saida de serviço.
 * 
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      
 */
class AlmoxarifadoController extends Controller {

    /**
     * Permissão principal.
     * @var integer 
     */
    private $ID_PERMISSAO = 2;

    /**
     * <b>PAGE</b>
     * <br>Chamada de pagina de controle de produtos dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function controleEstoque() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle do Almoxarifado');
            $this->render('almoxarifado/geral/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>PAGE</b>
     * <br>Chamada de pagina de controle de prateleiras dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/201
     */
    function controlePrateleira() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Prateleiras');
            $this->render('almoxarifado/prateleira/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Chamada de integrações de registro do BACK-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function setRegistroAJAX() {
        switch ($_POST['operacao']) {
            ////////////////////////////////////////////////////////////////////
            //                           - PRODUTO -                          //
            ////////////////////////////////////////////////////////////////////
            /**
             * Efetua cadastro de registro dentro do sistema.
             */
            case 'setCadastrarRegistroProduto':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $entidade = new EntidadeAlmoxarifadoProduto();
                    //GERAL
                    $entidade->setCodigoProduto(@$_POST['cardProdutoAdicionarCodigo']);
                    $entidade->setNome(@$_POST['cardProdutoAdicionarNome']);
                    $entidade->setDescricao(@$_POST['cardProdutoAdicionarDescricao']);
                    $entidade->setFkEmpresa(@$_POST['cardProdutoAdicionarEmpresa']);
                    $entidade->setFkUsuarioCadastro(Sessao::getUsuario()->getId());
                    //ESTOQUE
                    $entidade->setFkPrateleira(@$_POST['cardProdutoAdicionarPrateleira']);
                    $entidade->setValorCompra(@$_POST['cardProdutoAdicionarValorCompra'] ? str_replace(',', '.', $_POST['cardProdutoAdicionarValorCompra']) : NULL);
                    $entidade->setValorVenda(@$_POST['cardProdutoAdicionarValorVenda'] ? str_replace(',', '.', $_POST['cardProdutoAdicionarValorVenda']) : NULL);
                    $entidade->setUnidadeMedida(@$_POST['cardProdutoAdicionarUnidadeMedida']);
                    $entidade->setSaldoMinimo(@$_POST['cardProdutoAdicionarSaldoMinimo'] ? intval($_POST['cardProdutoAdicionarSaldoMinimo']) : null);
                    //VALIDADOR
                    $validador = new ValidadorAlmoxarifadoProduto();
                    $resultadoValidador = $validador->setValidarCadastro($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO 
                    $produtoDAO = new AlmoxarifadoProdutoDAO();
                    $registroID = $produtoDAO->setRegistro($entidade);
                    if ($registroID > 0) {
                        echo $registroID;
                        die();
                    }
                }
                break;
            ////////////////////////////////////////////////////////////////////
            //                       - ENTRADA PRODUTO -                      //
            ////////////////////////////////////////////////////////////////////
            /**
             * Efetua cadastro de registro dentro do sistema.
             */
            case 'setCadastrarRegistroEntradaProduto':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $entidade = new EntidadeAlmoxarifadoProdutoEntrada();
                    $entidade->setFkProduto(@$_POST['cardEntradaProdutoAdicionarProdutoID']);
                    $entidade->setFkUsuario(Sessao::getUsuario()->getId());
                    $entidade->setComentario(@$_POST['cardEntradaProdutoAdicionarComentario']);
                    //SALDO
                    $produtoDAO = new AlmoxarifadoProdutoDAO();
                    $entidade->setValorAnterior($produtoDAO->getEntidade(@$_POST['cardEntradaProdutoAdicionarProdutoID'])->getSaldoAtual());
                    $entidade->setValorEntrada(@$_POST['cardEntradaProdutoAdicionarValorEntrada'] ? intval($_POST['cardEntradaProdutoAdicionarValorEntrada']) : 0);
                    //VALIDADOR
                    $validador = new ValidadorAlmoxarifadoProdutoEntrada();
                    $resultadoValidador = $validador->setValidarCadastro($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO 
                    $produtoDAO = new AlmoxarifadoProdutoEntradaDAO();
                    $registroID = $produtoDAO->setRegistro($entidade);
                    if ($registroID > 0) {
                        echo 0;
                        die();
                    }
                }
                break;
            ////////////////////////////////////////////////////////////////////
            //                        - SAIDA PRODUTO -                       //
            ////////////////////////////////////////////////////////////////////
            /**
             * Efetua cadastro de registro dentro do sistema.
             */
            case 'setCadastrarRegistroSaidaProduto':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $entidade = new EntidadeAlmoxarifadoProdutoSaida();
                    $entidade->setFkProduto(@$_POST['cardSaidaProdutoAdicionarProdutoID']);
                    $entidade->setFkUsuario(Sessao::getUsuario()->getId());
                    $entidade->setComentario(@$_POST['cardSaidaProdutoAdicionarComentario']);
                    //SALDO
                    $produtoDAO = new AlmoxarifadoProdutoDAO();
                    $entidade->setValorAnterior($produtoDAO->getEntidade(@$_POST['cardSaidaProdutoAdicionarProdutoID'])->getSaldoAtual());
                    $entidade->setValorSaida(@$_POST['cardSaidaProdutoAdicionarValorSaida'] ? intval($_POST['cardSaidaProdutoAdicionarValorSaida']) : 0);
                    //VALIDADOR
                    $validador = new ValidadorAlmoxarifadoProdutoSaida();
                    $resultadoValidador = $validador->setValidarCadastro($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO 
                    $saidaDAO = new AlmoxarifadoProdutoSaidaDAO();
                    $registroID = $saidaDAO->setRegistro($entidade);
                    if ($registroID > 0) {
                        echo 0;
                        die();
                    }
                }
                break;
            ////////////////////////////////////////////////////////////////////
            //                         - PRATELEIRA -                         //
            ////////////////////////////////////////////////////////////////////
            /**
             * Efetua cadastro de registro dentro do sistema.
             */
            case 'setCadastrarRegistroPrateleira':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $entidade = new EntidadeAlmoxarifadoPrateleira();
                    $entidade->setNome(@$_POST['cardPrateleiraAdicionarNome']);
                    $entidade->setDescricao(@$_POST['cardPrateleiraAdicionarDescricao']);
                    $entidade->setFkEmpresa(@$_POST['cardPrateleiraAdicionarEmpresa']);
                    //ENDERECO
                    $endereco = new EntidadeEndereco();
                    $endereco->setCep(@$_POST['cardPrateleiraAdicionarEnderecoCep']);
                    $endereco->setRua(@$_POST['cardPrateleiraAdicionarEnderecoRua']);
                    $endereco->setNumero(@$_POST['cardPrateleiraAdicionarEnderecoNumero']);
                    $endereco->setReferencia(@$_POST['cardPrateleiraAdicionarEnderecoReferencia']);
                    $endereco->setBairro(@$_POST['cardPrateleiraAdicionarEnderecoBairro']);
                    $endereco->setCidade(@$_POST['cardPrateleiraAdicionarEnderecoCidade']);
                    $endereco->setUf(@$_POST['cardPrateleiraAdicionarEnderecoUF']);
                    $endereco->setIbge(@$_POST['cardPrateleiraAdicionarEnderecoIBGE']);
                    $entidade->setEntidadeEndereco($endereco);
                    //VALIDADOR
                    $validador = new ValidadorAlmoxarifadoPrateleira();
                    $resultadoValidador = $validador->setValidarCadastro($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO 
                    $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                    $registroID = $prateleiraDAO->setRegistro($entidade);
                    if ($registroID > 0) {
                        echo $registroID;
                        die();
                    }
                }
                break;
            /**
             * Efetua a edição de registro informado.
             */
            case 'setEditarRegistroPrateleira' :
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                    $entidade = new EntidadeAlmoxarifadoPrateleira();
                    $entidade = $prateleiraDAO->getEntidadeCompleta(@$_POST['cardEditorID']);
                    $entidade->setNome(@$_POST['cardEditorNome']);
                    $entidade->setDescricao(@$_POST['cardEditorDescricao']);
                    $entidade->setFkEmpresa(@$_POST['cardEditorEmpresa']);
                    //ENDERECO
                    $endereco = $entidade->getEntidadeEndereco();
                    $endereco->setCep(@$_POST['cardEditorEnderecoCep']);
                    $endereco->setRua(@$_POST['cardEditorEnderecoRua']);
                    $endereco->setNumero(@$_POST['cardEditorEnderecoNumero']);
                    $endereco->setReferencia(@$_POST['cardEditorEnderecoReferencia']);
                    $endereco->setBairro(@$_POST['cardEditorEnderecoBairro']);
                    $endereco->setCidade(@$_POST['cardEditorEnderecoCidade']);
                    $endereco->setUf(@$_POST['cardEditorEnderecoUF']);
                    $endereco->setIbge(@$_POST['cardEditorEnderecoIBGE']);
                    //VALIDADOR
                    $validador = new ValidadorAlmoxarifadoPrateleira();
                    $resultadoValidador = $validador->setValidarEditor($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO 
                    if ($prateleiraDAO->setEditar($entidade)) {
                        echo 0;
                        die();
                    }
                }
                break;
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Chamada de recursos solicitados pelo FRONT-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function getRegistroAJAX() {
        switch ($_POST['operacao']) {
            ////////////////////////////////////////////////////////////////////
            //                             - GERAL -                          //
            ////////////////////////////////////////////////////////////////////
            /**
             * Retorna ultimos registros de movimentos dentro do almoxarifado.
             * @return integer
             */
            case 'getTopMovimentoAlmoxarifado':
                $retorno = [];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $almoxarifadoDAO = new AlmoxarifadoDAO();
                    $retorno = $almoxarifadoDAO->getTopMovimentoAlmoxarifado(
                            @$_POST['numeroMaximoRegistro'] ? $_POST['numeroMaximoRegistro'] : null
                    );
                }
                print_r(json_encode($retorno));
                die();
            ////////////////////////////////////////////////////////////////////
            //                          - PRATELEIRA -                        //
            ////////////////////////////////////////////////////////////////////
            /**
             * Retorna registro soliciado por parametro.
             * @return array
             */
            case 'getRegistroPrateleira':
                $retorno = [];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                    $retorno = $prateleiraDAO->getVetorCompleto($_POST['registroID']);
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de registro.
             * @return array
             */
            case 'getListaControlePrateleira':
                $retorno = [];
                $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $prateleiraDAO->getListaControleTotal(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['empresa'] ? $_POST['empresa'] : null
                    );
                    $retorno['listaRegistro'] = $prateleiraDAO->getListaControle(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['empresa'] ? $_POST['empresa'] : null,
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de produtos continuar na prateleira informada.
             * @return array
             */
            case 'getListaControleProdutoPrateleira':
                $retorno = [];
                $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $prateleiraDAO->getListaControleProdutoPrateleiraTotal(
                            @$_POST['registroID']
                    );
                    $retorno['listaRegistro'] = $prateleiraDAO->getListaControleProdutoPrateleira(
                            @$_POST['registroID'],
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna total de registro cadastrados dentro do sistema de acordo 
             * com filtro informado.
             * @return integer
             */
            case 'getTotalRegistroPrateleira':
                $retorno = 0;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                    $retorno = $prateleiraDAO->getTotalRegistro(
                            @$_POST['empresa'] ? $_POST['empresa'] : null
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna total de registro cadastrados dentro do sistema de acordo 
             * com filtro informado.
             * @return integer
             */
            case 'getTopPrateleiraListaProduto':
                $retorno = [];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                    $retorno = $prateleiraDAO->getTopListaProduto(
                            @$_POST['numeroMaximoRegistro'] ? $_POST['numeroMaximoRegistro'] : null
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista simples de prateleiras cadastradas.
             * @return array
             */
            case 'getListaPrateleira' :
                $retorno = [];
                $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                $retorno = $prateleiraDAO->getListaVetor(
                        @$_POST['empresaID'] ? $_POST['empresaID'] : null
                );
                print_r(json_encode($retorno));
                die();
            ////////////////////////////////////////////////////////////////////
            //                           - PRODUTO -                          //
            ////////////////////////////////////////////////////////////////////
            /**
             * Retorna registro solicitado por parametro.
             * @return array
             */
            case 'getRegistroProduto':
                $retorno = [];
                $produtoDAO = new AlmoxarifadoProdutoDAO();
                $retorno = $produtoDAO->getVetorCompleto($_POST['registroID']);
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de registro.
             * @return array
             */
            case 'getListaControleProduto':
                $retorno = [];
                $produtoDAO = new AlmoxarifadoProdutoDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $produtoDAO->getListaControleTotal(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['empresa'] ? $_POST['empresa'] : null,
                            $_POST['situacaoRegistro']
                    );
                    $retorno['listaRegistro'] = $produtoDAO->getListaControle(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['empresa'] ? $_POST['empresa'] : null,
                            $_POST['situacaoRegistro'],
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna total de registro cadastrados dentro do sistema de acordo 
             * com filtro informado.
             * @return integer
             */
            case 'getTotalRegistroProduto':
                $retorno = 0;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $produtoDAO = new AlmoxarifadoProdutoDAO();
                    $retorno = $produtoDAO->getTotalRegistro(
                            $_POST['situacaoRegistro'] ? $_POST['situacaoRegistro'] : null
                    );
                }
                print_r(json_encode($retorno));
                die();
            ////////////////////////////////////////////////////////////////////
            //                           - ENTRADA -                          //
            ////////////////////////////////////////////////////////////////////
            /**
             * Retorna registro solicitado por parametro.
             * @return array
             */
            case 'getRegistroEntradaProduto':
                $retorno = [];
                $entradaDAO = new AlmoxarifadoProdutoEntradaDAO();
                $retorno = $entradaDAO->getVetorCompleto($_POST['registroID']);
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de registros cadastrados.
             * @return array
             */
            case 'getListaControleEntrada':
                $retorno = [];
                $entradaDAO = new AlmoxarifadoProdutoEntradaDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $entradaDAO->getListaControleTotal(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('01/m/Y'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('31/m/Y'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : ''
                    );
                    $retorno['listaRegistro'] = $entradaDAO->getListaControle(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('01/m/Y'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('31/m/Y'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de registros cadastrados.
             * @return array
             */
            case 'getListaHistoricoEntradaProduto':
                $retorno = [];
                $entradaDAO = new AlmoxarifadoProdutoEntradaDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $entradaDAO->getListaHistoricoProdutoTotal(@$_POST['produtoID']);
                    $retorno['listaRegistro'] = $entradaDAO->getListaHistoricoProduto(
                            @$_POST['produtoID'],
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            ////////////////////////////////////////////////////////////////////
            //                            - SAIDA -                           //
            ////////////////////////////////////////////////////////////////////
            /**
             * Retorna lista de registros cadastrados.
             * @return array
             */
            case 'getListaControleSaida':
                $retorno = [];
                $saidaDAO = new AlmoxarifadoProdutoSaidaDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $saidaDAO->getListaControleTotal(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('01/m/Y'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('31/m/Y'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : ''
                    );
                    $retorno['listaRegistro'] = $saidaDAO->getListaControle(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('01/m/Y'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('31/m/Y'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
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
            //OPERAÇÃO
            switch (@$_GET['operacao']) {
                /**
                 * Relatorio administrativo de PRATELEIRAS cadastrados.
                 */
                case 'relatorioAdministrativoPrateleira':
                    switch (@$_GET['tipoRelatorio']) {
                        /**
                         * Arquivo CSV com lista de todas as prateleiras 
                         * cadastradas dentro do sistema.
                         */
                        case 'getListaRegistroPrateleiraCSV':
                            $lista = [];
                            $nomeRelatorio = 'RELATÓRIO DE PRATELEIRAS CADASTRADAS';
                            $arquivo = 'relatorioPrateleirasCadastradas' . date('dmY') . '.xls';
                            setlocale(LC_MONETARY, "pt_BR", "ptb");
                            $html = '<meta charset="utf-8">';
                            $html .= '  <table style="min-width: 900px;max-width: 900px;border: 1px solid black">';
                            $html .= '      <tr><th colspan="15" style="text-align: left"><h3 style="margin-bottom: 0">' . $nomeRelatorio . '</h3></th></tr>';
                            $html .= '      <tr><th colspan="15" style="text-align: left"><p style="margin-bottom: 0">Construído em ' . date('d') . ' de ' . $nomeMes[date('m')] . ' de ' . date('Y') . ' às ' . date('H:i') . '</tr>';
                            $html .= '      <tr><th colspan="15" style="text-align: left"><p style="margin-bottom: 0">Por ' . Sessao::getUsuario()->getNomeCompleto() . '</tr>';
                            $html .= '      <tr>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">COD. INTERNO</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">EMPRESA</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">NOME</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">N° PRODUTOS</th>';
                            $html .= '          <th colspan="3" style="text-align: left;border: 1px solid black;vertical-align: text-top">DESCRIÇÃO</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">CEP</th>';
                            $html .= '          <th colspan="2" style="text-align: left;border: 1px solid black;vertical-align: text-top">ENDEREÇO</th>';
                            $html .= '          <th colspan="2" style="text-align: left;border: 1px solid black;vertical-align: text-top">REFERÊNCIA</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">BAIRRO</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">CIDADE</th>';
                            $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">CADASTRADO EM</th>';
                            $html .= '      </tr>';
                            $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                            $lista = $prateleiraDAO->getRelatorioCSV();
                            foreach ($lista as $value) {
                                $colunaName = ($value['numeroProduto'] > 0 ? 'th' : 'td');
                                $html .= '  <tr style="vertical-align: text-top">';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['prateleiraID'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['empresaNome'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['prateleiraNome'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['numeroProduto'] . ' produtos</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' colspan="3" style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['prateleiraDescricao'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['enderecoCep'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' colspan="2" style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['enderecoRua'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' colspan="2" style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['enderecoReferencia'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['enderecoBairro'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['enderecoCidade'] . '</' . $colunaName . '>';
                                $html .= '      <' . $colunaName . ' style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['prateleiraCadastro'] . '</' . $colunaName . '>';
                                $html .= '  </tr>';
                            }
                            $html .= '  </table>';
                            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                            header("Cache-Control: no-cache, must-revalidate");
                            header("Pragma: no-cache");
                            header("Content-type: application/x-msexcel");
                            header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
                            header("Content-Description: PHP Generated Data");
                            print_r($html);
                            die();
                        /**
                         * Gera arquivo PDF com lista de todas as prateleiras 
                         * cadastradas junto com lista de produtos cadastrados
                         */
                        case 'getListaRegistroPrateleiraProdutoPDF':
                            ob_start();
                            $urlLayout = 'public/documento/relatorio/almoxarifado/prateleira/relatorioGeralPrateleiraProdutosPDF.phtml';
                            $registroID = (@$_GET['registroID'] ? $_GET['registroID'] : 1001);
                            if (empty($registroID)) {
                                $tituloRelatorio = 'RELATÓRIO GERAL DE PRATELEIRAS';
                            } else {
                                $tituloRelatorio = 'RELATÓRIO INDIVIDUAL DE PRATELEIRA';
                            }
                            //VARIAVEIS DO PHTML -------------------------------
                            $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
                            $listaRegistro = $prateleiraDAO->getRelatorioPDF($registroID);
                            extract(array(
                                'APP_HOST' => APP_HOST,
                                'tituloRelatorio' => $tituloRelatorio,
                                'usuarioNome' => Sessao::getUsuario()->getNomeCompleto(),
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
