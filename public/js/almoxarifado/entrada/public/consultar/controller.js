/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */

//PRINCIPAL
var controllerCardEntradaProdutoConsultar = {
    /**
     * Elemento da tabela selecionado
     * @type element
     */
    elementSelected: null,
    /**
     * Determina ação relacionado a elemento de registro informado.
     * @param {type} element HTML 'div-registro'
     */
    setVerificarElementoSelecionado: function (element) {
        if (element !== null) {
            if ($(element).hasClass('div-registro') || $(element).hasClass('div-registro-active')) {
                $(element).parent().children().each(function () {
                    if ($(this).hasClass('div-registro') || $(this).hasClass('div-registro-active')) {
                        $(this).removeClass('div-registro-active');
                        $(this).addClass('div-registro');
                    }
                });
                $(element).addClass('div-registro-active').removeClass('div-registro');
                this.elementSelected = element;
            }
        }
    },
    /**
     * Evento da VIEW referente a action ESC/Voltar.
     * @returns integer
     */
    setActionEsc: function () {
        //CARD ENTRADA PRODUTO ADICIONAR
        if ($('#cardEntradaProdutoAdicionar').css('display') === 'flex') {
            $('#cardEntradaProdutoAdicionarBtnBack').click();
            return 0;
        }
        //CARD PRINCIPAL
        if ($('#cardEntradaProdutoConsultar').css('display') === 'flex') {
            $('#cardEntradaProdutoConsultarBtnBack').click();
            return 0;
        }
    },
    /**
     * Action de acionamento ao abrir elemento publico.
     * @returns function
     */
    setCardAbrir: function () {},
    /**
     * Action de acionamento ao atualizar elemento publico.
     * @returns function
     */
    setCardAtualizar: function () {},
    /**
     * Action de acionamento ao fechar elemento publico.
     * @returns function
     */
    setCardFechar: function () {},
};
//ANIMATION
var controllerCardEntradaProdutoConsultarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardEntradaProdutoConsultarCard').css('animation', '');
        $('#cardEntradaProdutoConsultarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardEntradaProdutoConsultar').fadeIn(50);
        setTimeout("$('#cardEntradaProdutoConsultarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardEntradaProdutoConsultarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardEntradaProdutoConsultar').fadeOut(200);
        setTimeout("$('#cardEntradaProdutoConsultarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardEntradaProdutoConsultarCard').fadeOut(0);
        $('#cardEntradaProdutoConsultarCardDiv').fadeOut(0);
        $('#cardEntradaProdutoConsultarCard').css('animation', '');
        $('#cardEntradaProdutoConsultarDivAnimation').fadeIn(100);
        $('#cardEntradaProdutoConsultarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardEntradaProdutoConsultarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardEntradaProdutoConsultar').fadeOut(0);
        $('#cardEntradaProdutoConsultarCard').css('animation', 'bounceOutRight .9s');
        $('#cardEntradaProdutoConsultar').fadeOut(650);
        setTimeout(function () {
            $('#cardEntradaProdutoConsultarCard').css('animation', '');
            $('#cardEntradaProdutoConsultarDivAnimation').fadeOut(0);
            $('#cardEntradaProdutoConsultarDivAnimationImage').css('animation', '');
            $('#cardEntradaProdutoConsultarCardDiv').fadeIn(0);
            $('#cardEntradaProdutoConsultarCard').fadeIn(0);
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardEntradaProdutoConsultarCard').css('animation', 'shake .9s');
        $('#cardEntradaProdutoConsultarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardEntradaProdutoConsultarCard').css('animation', '');
            $('#cardEntradaProdutoConsultarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};
//TAB HISTORICO
var controllerCardEntradaProdutoConsultarTabHistorico = {
     /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 10,
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
            $('#cardEntradaProdutoConsultarHistoricoBtnAtual').data('id', paginaSelecionada);
            $('#cardEntradaProdutoConsultarHistoricoBtnAtual').html(paginaSelecionada);
            $('#cardEntradaProdutoConsultarHistoricoBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardEntradaProdutoConsultarHistoricoBtnAtual').prop('disabled', false);
            $('#cardEntradaProdutoConsultarHistoricoTabelaSize').prop('class', '');
            $('#cardEntradaProdutoConsultarHistoricoTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> de <b>' + totalRegistro + '</b> registros');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').data('id', 1);
                $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').prop('disabled', false);
                $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').prop('disabled', false);
            } else {
                $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').data('id', 0);
                $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').prop('disabled', true);
                $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').data('id', 0);
                $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardEntradaProdutoConsultarHistoricoBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardEntradaProdutoConsultarHistoricoBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardEntradaProdutoConsultarHistoricoBtnProximo').prop('disabled', false);
                $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').data('id', quantidadePaginas);
                $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').prop('disabled', false);
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
        $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').prop('disabled', true);
        $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').data('id', 0);
        $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').prop('disabled', true);
        $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').data('id', 0);
        $('#cardEntradaProdutoConsultarHistoricoBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEntradaProdutoConsultarHistoricoBtnAtual').prop('disabled', true);
        $('#cardEntradaProdutoConsultarHistoricoBtnAtual').data('id', 0);
        $('#cardEntradaProdutoConsultarHistoricoBtnAtual').html('...');
        $('#cardEntradaProdutoConsultarHistoricoBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEntradaProdutoConsultarHistoricoBtnProximo').prop('disabled', true);
        $('#cardEntradaProdutoConsultarHistoricoBtnProximo').data('id', 0);
        $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').prop('disabled', true);
        $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardEntradaProdutoConsultarHistoricoTabelaSize').prop('class', '');
        $('#cardEntradaProdutoConsultarHistoricoTabelaSize').html('Nengum registro encontrado ...');
    }
};