<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\DAO\FinanceiroPagamentoDAO;
use App\Model\DAO\FinanceiroPagamentoTipoDAO;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações FINANCEIRAS dentro do sistema, 
 * principalmente operações de pagamento.
 * 
 * @package   App\Controller
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      29/06/2021
 */
class FinanceiroPagamentoController extends Controller {

    /**
     * Permissão padrão.
     * @var integer
     */
    private $ID_PERMISSAO = 2;

    /**
     * <b>PAGE</b>
     * <br>View de controle de pagamentos realizados dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function controlePagamento() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Pagamentos');
            $this->render('financeiro/pagamento/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Objeto responsavel pelas operações de consulta dentro do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Retorna formas de pagamentos cadastradas no sistema.
             * @return array
             */
            case 'getPagamento':
                $retorno = [];
                $pagamentoDAO = new FinanceiroPagamentoDAO();
                $retorno = $pagamentoDAO->getVetorCompleto(@$_POST['registroID']);
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna tipos de pagamento cadastrados dentro do sistema.
             * @return array
             */
            case 'getListaPagamentoTipo':
                $retorno = [];
                $pagamentoTipoDAO = new FinanceiroPagamentoTipoDAO();
                $retorno = $pagamentoTipoDAO->getListaVetor(
                        @$_POST['situacaoRegistro'] ? $_POST['situacaoRegistro'] : 10
                );
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna quantidade de registros de acordo com filtros informados.
             * @return integer
             */
            case 'getTotalRegistroPagamento' :
                $retorno = 0;
                $pagamentoDAO = new FinanceiroPagamentoDAO();
                $retorno = $pagamentoDAO->getTotalRegistro(
                        $_POST['dataInicial'] ? $_POST['dataInicial'] : date('01/m/Y'),
                        $_POST['dataFinal'] ? $_POST['dataFinal'] : date('31/m/Y'),
                        @$_POST['situacaoRegistro'] ? $_POST['situacaoRegistro'] : null
                );
                print_r($retorno);
                die();
            /**
             * Retorna estatistica de serviços durante o semestre vincualdos ao 
             * usuario informado.
             * @return array
             */
            case 'getQuantidadeSemestral':
                $retorno[0] = [0, 0, 0, 0, 0, 0];
                $retorno[1] = [0, 0, 0, 0, 0, 0];
                $retorno[2] = [0, 0, 0, 0, 0, 0];
                $pagamentoDAO = new FinanceiroPagamentoDAO();
                //PENDENTES
                $retorno[0] = $pagamentoDAO->getEstatisticaSemestral(0);
                //FINALIZADOS
                $retorno[1] = $pagamentoDAO->getEstatisticaSemestral(1);
                //CANCELADOS
                $retorno[2] = $pagamentoDAO->getEstatisticaSemestral(2);
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de registros com paginação.
             * @return array
             */
            case 'getListaControlePagamento':
                $retorno = [];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $pagamentoDAO = new FinanceiroPagamentoDAO();
                    //DAO
                    $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                    $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                    $retorno['totalRegistro'] = $pagamentoDAO->getListaControleTotal(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('Y-m-01'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('Y-m-31'),
                            @$_POST['pagamentoTipo'] ? $_POST['pagamentoTipo'] : null,
                            @$_POST['situacaoRegistro'] ? $_POST['situacaoRegistro'] : null
                    );
                    $retorno['listaRegistro'] = $pagamentoDAO->getListaControle(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('Y-m-01'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('Y-m-31'),
                            @$_POST['pagamentoTipo'] ? $_POST['pagamentoTipo'] : null,
                            @$_POST['situacaoRegistro'] ? $_POST['situacaoRegistro'] : null,
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Responsavel pelas operações de chamadas dentro do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function setRegistroAJAX() {
        switch (@$_POST['operacao']) {
            //TODO HERE
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Responsavel pelas operações envolvendo relatorios do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/03/2021
     */
    function getRelatorioAJAX() {
        switch (@$_GET['operacao']) {
            /**
             * Relatório geral de pagamentos realizados pelo sistema.
             * @return CSV
             */
            case 'getRelatorioPagamentoGeral':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $lista = [];
                    $formaPagamento = [];
                    $nomeRelatorio = 'Relatório Geral';
                    switch (@$_GET['formaPagamento']) {
                        case 'ecommerce'://ECOMMERCE
                            array_push($formaPagamento, 1);
                            $nomeRelatorio = 'Relatório Ecommerce';
                            break;
                        case 'boleto'://BOLETO
                            array_push($formaPagamento, 4);
                            $nomeRelatorio = 'Relatório Boleto bancário';
                            break;
                        case 'sitef'://SITEF
                            array_push($formaPagamento, 5);
                            array_push($formaPagamento, 6);
                            $nomeRelatorio = 'Relatório Sitef (Maquininha de cartão)';
                            break;
                        case 'totem'://TOTEM
                            array_push($formaPagamento, 8);
                            array_push($formaPagamento, 9);
                            $nomeRelatorio = 'Relatório Totem (Totem Telecom)';
                            break;
                    }
                    $arquivo = 'relatorioPagamento' . date('dmY') . '.xls';
                    setlocale(LC_MONETARY, "pt_BR", "ptb");
                    $html = '<meta charset="utf-8">';
                    $html .= '  <table style="min-width: 900px;max-width: 900px;border: 1px solid black">';
                    $html .= '      <tr><th colspan="11" style="text-align: left"><h3 style="margin-bottom: 0">RELATÓRIO DE PAGAMENTOS</h3></th></tr>';
                    $html .= '      <tr><th colspan="11" style="text-align: left"><p style="margin-bottom: 0">Período de ' . @$_GET['dataInicial'] . ' até ' . @$_GET['dataFinal'] . '</p></th></tr>';
                    $html .= '      <tr><th colspan="11" style="text-align: left"><h4 style="margin-bottom: 0">' . $nomeRelatorio . '</h4></th></tr>';
                    $html .= '      <tr>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Código</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Origem</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Forma de pagamento</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Situação</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Cod. cielo</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Cod. Aut. cielo</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Valor</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">N° parcelas</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Cartão</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Nome cartão</th>';
                    $html .= '          <th style="text-align: left;border: 1px solid black;vertical-align: text-top">Data cadastro</th>';
                    $html .= '      </tr>';
                    $pagamentoDAO = new FinanceiroPagamentoDAO();
                    $lista = $pagamentoDAO->getListaControleRelatorio(@$_GET['dataInicial'], @$_GET['dataFinal'], $formaPagamento);
                    foreach ($lista as $value) {
                        $html .= '  <tr style="vertical-align: text-top">';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['id'] . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . ($value['origemPagamento'] === 'cabeamento_adicional' ? 'CABEAMENTO ADICIONAL' : 'MUDANÇA DE PONTO') . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . strtoupper($value['formaPagamento']) . '</td>';
                        switch ($value['estadoRegistro']) {
                            case 'Pendente':
                                $html .= '<td style="text-align: left;border: 1px solid black;vertical-align: top;color: red"><b>PAGAMENTO PENDENTE</b></td>';
                                break;
                            case 'Concluído':
                                $html .= '<td style="text-align: left;border: 1px solid black;vertical-align: top;color: green"><b>PAGAMENTO CONCLUÍDO</b></td>';
                                break;
                            default:
                                $html .= '<td style="text-align: left;border: 1px solid black;vertical-align: top;color: gray"><b>PAGAMENTO CANCELADO</b></td>';
                                break;
                        }
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . (!empty($value['codigoCielo']) ? $value['codigoCielo'] : '-----') . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . (!empty($value['codigoAutorizacaoCielo']) ? $value['codigoAutorizacaoCielo'] : '-----') . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . money_format('%n', $value['valor']) . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['numeroParcela'] . 'x</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . (!empty($value['cartaoNome']) ? strtoupper($value['cartaoNome']) : '-----') . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . ($value['cartaoNumero'] !== '****.****.****.' ? $value['cartaoNumero'] . ' - ' . $value['cartaoBandeira'] : '-----') . '</td>';
                        $html .= '      <td style="text-align: left;border: 1px solid black;vertical-align: top">' . $value['dataCadastro'] . '</td>';
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
                }
        }
        echo 1;
    }

}
