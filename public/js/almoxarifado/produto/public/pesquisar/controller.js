/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */

//PRINCIPAL
var controllerCardProdutoPesquisar = {
    /**
     * ID do produto selecionado.
     * @type Number
     */
    produtoSelecionadoID: 0,
    /**
     * Evento da VIEW referente a action ESC/Voltar.
     * @returns integer
     */
    setActionEsc: function () {
        //CARD PRINCIPAL
        if ($('#cardProdutoPesquisar').css('display') === 'flex') {
            $('#cardProdutoPesquisarBtnBack').click();
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
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 9,
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
            $('#cardProdutoPesquisarListaProdutoBtnAtual').data('id', paginaSelecionada);
            $('#cardProdutoPesquisarListaProdutoBtnAtual').html(paginaSelecionada);
            $('#cardProdutoPesquisarListaProdutoBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardProdutoPesquisarListaProdutoBtnAtual').prop('disabled', false);
            $('#cardProdutoPesquisarListaProdutoSize').prop('class', '');
            $('#cardProdutoPesquisarListaProdutoSize').html('Mostrando <b>' + registroPorPagina + '</b> de <b>' + totalRegistro + '</b> registros');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').data('id', 1);
                $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').prop('disabled', false);
                $('#cardProdutoPesquisarListaProdutoBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardProdutoPesquisarListaProdutoBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardProdutoPesquisarListaProdutoBtnAnterior').prop('disabled', false);
            } else {
                $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').data('id', 0);
                $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').prop('disabled', true);
                $('#cardProdutoPesquisarListaProdutoBtnAnterior').data('id', 0);
                $('#cardProdutoPesquisarListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardProdutoPesquisarListaProdutoBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardProdutoPesquisarListaProdutoBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardProdutoPesquisarListaProdutoBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardProdutoPesquisarListaProdutoBtnProximo').prop('disabled', false);
                $('#cardProdutoPesquisarListaProdutoBtnUltimo').data('id', quantidadePaginas);
                $('#cardProdutoPesquisarListaProdutoBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardProdutoPesquisarListaProdutoBtnUltimo').prop('disabled', false);
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
        $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').prop('disabled', true);
        $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').data('id', 0);
        $('#cardProdutoPesquisarListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardProdutoPesquisarListaProdutoBtnAnterior').prop('disabled', true);
        $('#cardProdutoPesquisarListaProdutoBtnAnterior').data('id', 0);
        $('#cardProdutoPesquisarListaProdutoBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardProdutoPesquisarListaProdutoBtnAtual').prop('disabled', true);
        $('#cardProdutoPesquisarListaProdutoBtnAtual').data('id', 0);
        $('#cardProdutoPesquisarListaProdutoBtnAtual').html('...');
        $('#cardProdutoPesquisarListaProdutoBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardProdutoPesquisarListaProdutoBtnProximo').prop('disabled', true);
        $('#cardProdutoPesquisarListaProdutoBtnProximo').data('id', 0);
        $('#cardProdutoPesquisarListaProdutoBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardProdutoPesquisarListaProdutoBtnUltimo').prop('disabled', true);
        $('#cardProdutoPesquisarListaProdutoBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardProdutoPesquisarListaProdutoSize').prop('class', '');
        $('#cardProdutoPesquisarListaProdutoSize').html('Nengum registro encontrado ...');
    }
};
//ANIMATION
var controllerCardProdutoPesquisarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardProdutoPesquisarCard').css('animation', '');
        $('#cardProdutoPesquisarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardProdutoPesquisar').fadeIn(50);
        setTimeout("$('#cardProdutoPesquisarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardProdutoPesquisarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardProdutoPesquisar').fadeOut(200);
        setTimeout("$('#cardProdutoPesquisarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardProdutoPesquisarCard').css('animation', '');
        $('#cardProdutoPesquisarCard').css('animation', 'bounceOut .5s');
        await sleep(450);
        $('#cardProdutoPesquisar').fadeOut(0);
        $('#cardProdutoPesquisarCard').css('animation', '');
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardProdutoPesquisarCard').css('animation', 'shake .9s');
        $('#cardProdutoPesquisarBtnSubmit').removeClass('btn-primary').addClass('btn-danger');
        setTimeout(function () {
            $('#cardProdutoPesquisarCard').css('animation', '');
            $('#cardProdutoPesquisarBtnSubmit').addClass('btn-primary').removeClass('btn-danger');
        }, 500);
    }
};