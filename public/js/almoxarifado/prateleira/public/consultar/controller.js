/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

//PRINCIPAL
var controllerCardPrateleiraConsultar = {
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
        if ($('#cardPrateleiraConsultar').css('display') === 'flex') {
            $('#cardPrateleiraConsultarBtnBack').click();
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
    setCardFechar: function () {}
};
//ANIMATION
var controllerCardPrateleiraConsultarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardPrateleiraConsultarCard').css('animation', '');
        $('#cardPrateleiraConsultarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardPrateleiraConsultar').fadeIn(50);
        setTimeout("$('#cardPrateleiraConsultarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardPrateleiraConsultarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardPrateleiraConsultar').fadeOut(200);
        setTimeout("$('#cardPrateleiraConsultarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        await controllerCardPrateleiraConsultar.setCardAtualizar();
        await sleep(100);
        $('#cardPrateleiraConsultarCard').fadeOut(0);
        $('#cardPrateleiraConsultarCardDiv').fadeOut(0);
        $('#cardPrateleiraConsultarCard').css('animation', '');
        $('#cardPrateleiraConsultarDivAnimation').fadeIn(100);
        $('#cardPrateleiraConsultarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardPrateleiraConsultarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardPrateleiraConsultar').fadeOut(0);
        $('#cardPrateleiraConsultarCard').css('animation', 'bounceOutRight .9s');
        $('#cardPrateleiraConsultar').fadeOut(650);
        setTimeout(function () {
            $('#cardPrateleiraConsultarCard').css('animation', '');
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setCancelarAnimation: async function () {
        controllerCardPrateleiraConsultar.setCardAtualizar();
        $('#cardPrateleiraConsultarCard').fadeOut(0);
        await sleep(200);
        $('#cardPrateleiraConsultarCard').fadeIn(200);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardPrateleiraConsultarCard').css('animation', 'shake .9s');
        setTimeout(function () {
            $('#cardPrateleiraConsultarCard').css('animation', '');
        }, 500);
    }
};
//TAB PRODUTO
var controllerCardPrateleiraConsultarTabListaProduto = {
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
            $('#cardPrateleiraConsultarListaProdutoBtnAtual').data('id', paginaSelecionada);
            $('#cardPrateleiraConsultarListaProdutoBtnAtual').html(paginaSelecionada);
            $('#cardPrateleiraConsultarListaProdutoBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardPrateleiraConsultarListaProdutoBtnAtual').prop('disabled', false);
            $('#cardPrateleiraConsultarListaProdutoSize').prop('class', '');
            $('#cardPrateleiraConsultarListaProdutoSize').html('Mostrando <b>' + registroPorPagina + '</b> de <b>' + totalRegistro + '</b> registros');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').data('id', 1);
                $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').prop('disabled', false);
                $('#cardPrateleiraConsultarListaProdutoBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardPrateleiraConsultarListaProdutoBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardPrateleiraConsultarListaProdutoBtnAnterior').prop('disabled', false);
            } else {
                $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').data('id', 0);
                $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').prop('disabled', true);
                $('#cardPrateleiraConsultarListaProdutoBtnAnterior').data('id', 0);
                $('#cardPrateleiraConsultarListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardPrateleiraConsultarListaProdutoBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardPrateleiraConsultarListaProdutoBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardPrateleiraConsultarListaProdutoBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardPrateleiraConsultarListaProdutoBtnProximo').prop('disabled', false);
                $('#cardPrateleiraConsultarListaProdutoBtnUltimo').data('id', quantidadePaginas);
                $('#cardPrateleiraConsultarListaProdutoBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardPrateleiraConsultarListaProdutoBtnUltimo').prop('disabled', false);
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
        $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').prop('disabled', true);
        $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').data('id', 0);
        $('#cardPrateleiraConsultarListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardPrateleiraConsultarListaProdutoBtnAnterior').prop('disabled', true);
        $('#cardPrateleiraConsultarListaProdutoBtnAnterior').data('id', 0);
        $('#cardPrateleiraConsultarListaProdutoBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardPrateleiraConsultarListaProdutoBtnAtual').prop('disabled', true);
        $('#cardPrateleiraConsultarListaProdutoBtnAtual').data('id', 0);
        $('#cardPrateleiraConsultarListaProdutoBtnAtual').html('...');
        $('#cardPrateleiraConsultarListaProdutoBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardPrateleiraConsultarListaProdutoBtnProximo').prop('disabled', true);
        $('#cardPrateleiraConsultarListaProdutoBtnProximo').data('id', 0);
        $('#cardPrateleiraConsultarListaProdutoBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardPrateleiraConsultarListaProdutoBtnUltimo').prop('disabled', true);
        $('#cardPrateleiraConsultarListaProdutoBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardPrateleiraConsultarListaProdutoSize').prop('class', '');
        $('#cardPrateleiraConsultarListaProdutoSize').html('Nengum registro encontrado ...');
    }
    
}