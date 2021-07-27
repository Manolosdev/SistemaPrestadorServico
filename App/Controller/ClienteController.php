<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\DAO\ClienteDAO;
use App\Model\Entidade\EntidadeCliente;
use App\Model\Entidade\EntidadeEndereco;
use App\Model\DAO\EnderecoDAO;
use App\Model\Validador\ValidadorCliente;
use App\Model\Validador\ValidadorEndereco;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações envolvendo clientes cadastrados dentro do 
 * sistema.
 * 
 * @package   App\Controller
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      30/06/2021
 */
class ClienteController extends Controller {

    /**
     * Permissão principal
     * @var integer 
     */
    private $ID_PERMISSAO = 1;

    /**
     * <b>PAGE</b>
     * <br>Chamada de VIEW de controle de registros dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Clientes');
            $this->render('cliente/controle');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Chamada de inserção de dados do FRONT-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function setRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Efetua cadastro de registro dentro do sistema.
             */
            case 'setRegistro':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $clienteDAO = new ClienteDAO();
                    $enderecoDAO = new EnderecoDAO();
                    $entidadeCliente = new EntidadeCliente();
                    //CHECK CLIENTE EXISTENTE
                    $entidadeCliente = $clienteDAO->getEntidadePorDocumento(
                            @$_POST['cardClienteAdicionarGeralCPF'],
                            @$_POST['cardClienteAdicionarGeralCNPJ']
                    );
                    $entidadeCliente->setFkUsuarioCadastro(Sessao::getUsuario()->getId());
                    $entidadeCliente->setTipoPessoa(@$_POST['cardClienteAdicionarGeralTipoPessoa']);
                    $entidadeCliente->setCpf(@$_POST['cardClienteAdicionarGeralCPF']);
                    $entidadeCliente->setRg(@$_POST['cardClienteAdicionarGeralRG']);
                    $entidadeCliente->setCnpj(@$_POST['cardClienteAdicionarGeralCNPJ']);
                    $entidadeCliente->setInscricaoMunicipal(@$_POST['cardClienteAdicionarGeralInscricaoMunicipal']);
                    $entidadeCliente->setInscricaoEstadual(@$_POST['cardClienteAdicionarInscricaoGeralEstadual']);
                    $entidadeCliente->setNome(@$_POST['cardClienteAdicionarGeralNome']);
                    $entidadeCliente->setEmail(@$_POST['cardClienteAdicionarGeralEmail']);
                    $entidadeCliente->setCelular(@$_POST['cardClienteAdicionarGeralCelular']);
                    $entidadeCliente->setTelefone(@$_POST['cardClienteAdicionarGeralTelefone']);
                    //$entidade->setDataNascimento(@$_POST['']);
                    //ENDEREÇO
                    $entidadeEndereco = $entidadeCliente->getEntidadeEndereco();
                    $entidadeEndereco->setCep(@$_POST['cardClienteAdicionarEnderecoCep']);
                    $entidadeEndereco->setRua(@$_POST['cardClienteAdicionarEnderecoRua']);
                    $entidadeEndereco->setNumero(@$_POST['cardClienteAdicionarEnderecoNumero']);
                    $entidadeEndereco->setReferencia(@$_POST['cardClienteAdicionarEnderecoReferencia']);
                    $entidadeEndereco->setBairro(@$_POST['cardClienteAdicionarEnderecoBairro']);
                    $entidadeEndereco->setCidade(@$_POST['cardClienteAdicionarEnderecoCidade']);
                    $entidadeEndereco->setUf(@$_POST['cardClienteAdicionarEnderecoUF']);
                    $entidadeEndereco->setIbge(@$_POST['cardClienteAdicionarEnderecoIBGE']);
                    $entidadeCliente->setEntidadeEndereco($entidadeEndereco);
                    //VALIDAR CLIENTE
                    $validadorCliente = new ValidadorCliente();
                    $resultadoValidadorCliente = $validadorCliente->setValidarCadastro($entidadeCliente);
                    if ($resultadoValidadorCliente->getErros()) {
                        print_r(json_encode($resultadoValidadorCliente->getErros()));
                        die();
                    }
                    //VALIDAR ENDEREÇO
                    $validadorEndereco = new ValidadorEndereco();
                    $resultadoValidadorEndereco = $validadorEndereco->setValidarRegistro($entidadeEndereco);
                    if ($resultadoValidadorEndereco->getErros()) {
                        print_r(json_encode($resultadoValidadorEndereco->getErros()));
                        die();
                    }
                    //ENDEREÇO DAO -------------------------------------------------
                    if ($entidadeEndereco->getId() > 0) {
                        $enderecoDAO->setEditar($entidadeEndereco);
                    } else {
                        $entidadeCliente->setFkEndereco($enderecoDAO->setRegistro($entidadeEndereco));
                    }
                    //CLIENTE DAO --------------------------------------------------
                    if ($entidadeCliente->getId() > 0) {
                        if ($clienteDAO->setEditarRegistro($entidadeCliente)) {
                            echo $entidadeCliente->getId();
                            die();
                        }
                    } else {
                        $registroID = $clienteDAO->setRegistro($entidadeCliente);
                        if ($registroID > 0) {
                            echo $registroID;
                            die();
                        }
                    }
                }
                break;

            /**
             * Efetua edição de registro.
             */
            case 'setEditarRegistro' :
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $clienteDAO = new ClienteDAO();
                    $enderecoDAO = new EnderecoDAO();
                    //CHECK CLIENTE EXISTENTE
                    $entidadeCliente = $clienteDAO->getEntidade(@$_POST['cardClienteEditorID']);
                    if ($entidadeCliente->getId() > 0) {
                        $entidadeCliente->setRg(@$_POST['cardClienteEditorGeralRG']);
                        $entidadeCliente->setInscricaoMunicipal(@$_POST['cardClienteEditorGeralInscricaoMunicipal']);
                        $entidadeCliente->setInscricaoEstadual(@$_POST['cardClienteEditorInscricaoGeralEstadual']);
                        $entidadeCliente->setNome(@$_POST['cardClienteEditorGeralNome']);
                        $entidadeCliente->setEmail(@$_POST['cardClienteEditorGeralEmail']);
                        $entidadeCliente->setCelular(@$_POST['cardClienteEditorGeralCelular']);
                        $entidadeCliente->setTelefone(@$_POST['cardClienteEditorGeralTelefone']);
                        //ENDEREÇO
                        $entidadeEndereco = $enderecoDAO->getEntidadeCompleta($_POST['cardClienteEditorEnderecoID']);
                        $entidadeEndereco->setCep(@$_POST['cardClienteEditorEnderecoCep']);
                        $entidadeEndereco->setRua(@$_POST['cardClienteEditorEnderecoRua']);
                        $entidadeEndereco->setNumero(@$_POST['cardClienteEditorEnderecoNumero']);
                        $entidadeEndereco->setReferencia(@$_POST['cardClienteEditorEnderecoReferencia']);
                        $entidadeEndereco->setBairro(@$_POST['cardClienteEditorEnderecoBairro']);
                        $entidadeEndereco->setCidade(@$_POST['cardClienteEditorEnderecoCidade']);
                        $entidadeEndereco->setUf(@$_POST['cardClienteEditorEnderecoUF']);
                        $entidadeEndereco->setIbge(@$_POST['cardClienteEditorEnderecoIBGE']);
                        $entidadeCliente->setEntidadeEndereco($entidadeEndereco);
                        //VALIDAR CLIENTE
                        $validadorCliente = new ValidadorCliente();
                        $resultadoValidadorCliente = $validadorCliente->setValidarEditor($entidadeCliente);
                        if ($resultadoValidadorCliente->getErros()) {
                            print_r(json_encode($resultadoValidadorCliente->getErros()));
                            die();
                        }
                        //VALIDAR ENDEREÇO
                        $validadorEndereco = new ValidadorEndereco();
                        $resultadoValidadorEndereco = $validadorEndereco->setValidarRegistro($entidadeEndereco);
                        if ($resultadoValidadorEndereco->getErros()) {
                            print_r(json_encode($resultadoValidadorEndereco->getErros()));
                            die();
                        }
                        //ENDEREÇO DAO -------------------------------------------------
                        if (!$enderecoDAO->setEditar($entidadeEndereco)) {
                            echo 1;
                            die();
                        }
                        //CLIENTE DAO --------------------------------------------------
                        if ($clienteDAO->setEditarRegistro($entidadeCliente)) {
                            echo 0;
                            die();
                        }
                    } else {
                        $retorno = [];
                        array_push($retorno, array('ERRO GRAVE', 'Cliente informado não foi encontrado no sistema.'));
                        print_r(json_encode($retorno));
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
     * @date      30/06/2021
     */
    function getRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Retorna registro solicitado por parametro.
             * @return array
             */
            case 'getRegistro':
                $retorno = [];
                $clienteDAO = new ClienteDAO();
                $retorno = $clienteDAO->getVetorCompleto(@$_POST['registroID']);
                print_r(json_encode($retorno));
                die();
            /**
             * Lista de registro cadastrados com paginação.
             * @var array
             */
            case 'getListaControle' :
                $retorno = [];
                $clienteDAO = new ClienteDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $clienteDAO->getListaControleTotal(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : null,
                            @$_POST['cidade'] ? $_POST['cidade'] : ''
                    );
                    $retorno['listaRegistro'] = $clienteDAO->getListaControle(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['cidade'] ? $_POST['cidade'] : null,
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna quantidade de registros encontrados dentro do sistema.
             * @return integer
             */
            case 'getQuantidadeRegistro' :
                $retorno = 0;
                $clienteDAO = new ClienteDAO();
                $retorno = $clienteDAO->getQuantidadeRegistro();
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de clientes por cidade.
             * @return array
             */
            case 'getClientesPorCidade':
                $retorno = [];
                $clienteDAO = new ClienteDAO();
                $retorno = $clienteDAO->getEstatisticaClientePorCidade();
                print_r(json_encode($retorno));
                die();
        }
        echo 1;
    }

}
