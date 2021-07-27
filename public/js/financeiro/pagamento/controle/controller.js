/**
 * CONTROLLER
 * 
 * Objeto responsavel pelo controle de elementos e rotinas da interfase.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */

var controllerInterfaseGeral = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 17,
    /**
     * Determina o comportamento do elemento de paginacao inferior.
     * @type function
     */
    setEstadoPaginacao: function (registro) {
        if (registro['totalRegistro'] && registro['totalRegistro'] == 0) {
            this.setEstadoInicialPaginacao();
            return true;
        }
        //INIT ELEMENTS
        var totalRegistro = registro['totalRegistro'] ? parseInt(registro['totalRegistro']) : 0;
        var registroPorPagina = registro['listaRegistro'].length ? parseInt(registro['listaRegistro'].length) : this.getNumeroRegistroPorPaginacao;
        var paginaSelecionada = registro['paginaSelecionada'] ? parseInt(registro['paginaSelecionada']) : 0;
        var quantidadePaginas = Math.ceil(totalRegistro / this.getNumeroRegistroPorPaginacao);
        //PAGINAS ANTERIORES
        if (paginaSelecionada > 0) {
            //PAGINA ATUAL
            $('#cardListaBtnAtual').data('id', paginaSelecionada);
            $('#cardListaBtnAtual').html(paginaSelecionada);
            $('#cardListaBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaBtnAtual').prop('disabled', false);
            $('#cardListaTabelaSize').prop('class', '');
            $('#cardListaTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaBtnPrimeiro').data('id', 1);
                $('#cardListaBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnPrimeiro').prop('disabled', false);
                $('#cardListaBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaBtnPrimeiro').data('id', 0);
                $('#cardListaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaBtnPrimeiro').prop('disabled', true);
                $('#cardListaBtnAnterior').data('id', 0);
                $('#cardListaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnProximo').prop('disabled', false);
                $('#cardListaBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnUltimo').prop('disabled', false);
            }
        } else {
            this.setEstadoInicialPaginacao();
        }
    },
    /**
     * Determina estado da paginação.
     * @type function
     */
    setEstadoInicialPaginacao: function () {
        //BTN PAGINATION
        $('#cardListaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnPrimeiro').prop('disabled', true);
        $('#cardListaBtnPrimeiro').data('id', 0);
        $('#cardListaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnAnterior').prop('disabled', true);
        $('#cardListaBtnAnterior').data('id', 0);
        $('#cardListaBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnAtual').prop('disabled', true);
        $('#cardListaBtnAtual').data('id', 0);
        $('#cardListaBtnAtual').html('...');
        $('#cardListaBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnProximo').prop('disabled', true);
        $('#cardListaBtnProximo').data('id', 0);
        $('#cardListaBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnUltimo').prop('disabled', true);
        $('#cardListaBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaTabelaSize').prop('class', '');
        $('#cardListaTabelaSize').html('Nengum registro encontrado ...');
    },
    /**
     * Retorna formulario para estado inicial.
     * @type function
     */
    setEstadoInicialCardPagamento: function () {
        $('#cardPagamentoCodigoPagamento').html('#----');
        $('#cardPagamentoSituacaoDiv').prop('class', 'card-body bg-light');
        $('#cardPagamentoSituacao').html('-----');
        $('#cardPagamentoCadastro').html('-----');
        $('#cardPagamentoOrigem').html('-----');
        $('#cardPagamentoOrigemSituacao').prop('class', 'color-default mb-0 font-13');
        $('#cardPagamentoOrigemSituacao').html('<i class="mdi mdi-hexagon-multiple"></i> -----');
        $('#cardPagamentoOrigemBtn').removeClass('btn-info').addClass('btn-dark');
        $('#cardPagamentoOrigemBtn').prop('disabled', true);
        $('#cardPagamentoOrigemBtn').unbind();
        $('#cardPagamentoFormaTipo').html('-----');
        $('#cardPagamentoFormaDescricao').html('-----');
        $('#cardPagamentoParcela').html('-----');
        $('#cardPagamentoValor').html('-----');
        //DIV FORMA PAGAMENTO 
        $('#cardPagamentoDivDefault').fadeIn(0);
        $('#cardPagamentoDivBoleto').fadeOut(0);
        $('#cardPagamentoDivBoletoCodigo').html('#----');
        $('#cardPagamentoDivBoletoSituacao').prop('class', 'color-default mb-2 font-13');
        $('#cardPagamentoDivBoletoSituacao').html('-----');
        $('#cardPagamentoDivBoletoCliente').html('-----');
        $('#cardPagamentoDivBoletoCadastro').html('-----');
        $('#cardPagamentoDivBoletoVencimento').html('-----');
        $('#cardPagamentoDivBoletoBtnBoleto').prop('disabled', true);
        $('#cardPagamentoDivBoletoBtnBoleto').removeClass('btn-info').addClass('btn-dark');
        $('#cardPagamentoDivBoletoBtnBoleto').unbind();
        $('#cardPagamentoDivEcommerce').fadeOut(0);
        $('cardPagamentoDivEcommerceNumero').html('-----');
        $('cardPagamentoDivEcommerceNome').html('-----');
        $('cardPagamentoDivEcommerceCodigo').html('-----');
        $('cardPagamentoDivEcommercePaymentID').html('-----');
        $('#cardPagamentoDivSitefBtnPagamento').prop('disabled', true);
        $('#cardPagamentoDivSitefBtnPagamento').addClass('btn-dark').removeClass('btn-info');
        $('#cardPagamentoDivSitefBtnPagamento').unbind();
        $('#cardPagamentoDivSitefBtnCancelamentoDiv').fadeOut();
        $('#cardPagamentoDivSitefBtnCancelamento').prop('disabled', true);
        $('#cardPagamentoDivSitefBtnCancelamento').addClass('btn-dark').removeClass('btn-info');
        $('#cardPagamentoDivSitefBtnCancelamento').unbind();
        $('#cardPagamentoDivSitef').fadeOut(0);
        $('#cardPagamentoDivTotemNome').html('<i class="mdi mdi-home"></i> -----');
        $('#cardPagamentoDivTotemBtnPagamento').prop('disabled', true);
        $('#cardPagamentoDivTotemBtnPagamento').addClass('btn-dark').removeClass('btn-info');
        $('#cardPagamentoDivTotemBtnPagamento').unbind();
        $('#cardPagamentoDivTotemBtnCancelamentoDiv').fadeOut();
        $('#cardPagamentoDivTotemBtnCancelamento').prop('disabled', true);
        $('#cardPagamentoDivTotemBtnCancelamento').addClass('btn-dark').removeClass('btn-info');
        $('#cardPagamentoDivTotemBtnCancelamento').unbind();
        //TAB HISTORICO
        $('#cardPagamentoHistoricoTabela').html('<div class="col-12 text-center" style="padding-top: 105px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardPagamentoHistoricoTabelaSize').html('<b>0</b> registros encontrados');
        $('#cardPagamentoDivTotem').fadeOut(0);
    }
};
////////////////////////////////////////////////////////////////////////////////
//                          - CARD DETALHE PAGAMENTO -                        //
////////////////////////////////////////////////////////////////////////////////
var controllerCardPagamento = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardPagamentoCard').css('animation', '');
        $('#cardPagamentoCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardPagamento').fadeIn(50);
        setTimeout("$('#cardPagamentoCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardPagamentoCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardPagamento').fadeOut(200);
        setTimeout("$('#cardPagamentoCard').css('animation', '')", 500);
    }
};
////////////////////////////////////////////////////////////////////////////////
//                      - CARD DETALHE PAGAMENTO HISTORICO -                  //
////////////////////////////////////////////////////////////////////////////////
var controllerCardPagamentoDetalheHistorico = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardPagamentoCardDetalheHistoricoCard').css('animation', '');
        $('#cardPagamentoCardDetalheHistoricoCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardPagamentoCardDetalheHistorico').fadeIn(50);
        setTimeout("$('#cardPagamentoCardDetalheHistoricoCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardPagamentoCardDetalheHistoricoCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardPagamentoCardDetalheHistorico').fadeOut(200);
        setTimeout("$('#cardPagamentoCardDetalheHistoricoCard').css('animation', '')", 500);
    }
};