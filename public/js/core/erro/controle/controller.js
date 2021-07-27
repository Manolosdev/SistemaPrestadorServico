/**
 * JAVASCRIPT
 * 
 * Controlador de operações da interfase.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */

/**
 * Controlador da lista de registros (paginação)
 * @type array
 */
var controllerInterfaseGeral = {
    //EMPTY
};

/**
 * Controlador da lista de registros (paginação)
 * @type array
 */
var controllerInterfaseGeralTabErroLog = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 16,
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
            $('#cardListaErroLogBtnAtual').data('id', paginaSelecionada);
            $('#cardListaErroLogBtnAtual').html(paginaSelecionada);
            $('#cardListaErroLogBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaErroLogBtnAtual').prop('disabled', false);
            $('#cardListaErroLogTabelaSize').prop('class', '');
            $('#cardListaErroLogTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaErroLogBtnPrimeiro').data('id', 1);
                $('#cardListaErroLogBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroLogBtnPrimeiro').prop('disabled', false);
                $('#cardListaErroLogBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaErroLogBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroLogBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaErroLogBtnPrimeiro').data('id', 0);
                $('#cardListaErroLogBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaErroLogBtnPrimeiro').prop('disabled', true);
                $('#cardListaErroLogBtnAnterior').data('id', 0);
                $('#cardListaErroLogBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaErroLogBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaErroLogBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaErroLogBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroLogBtnProximo').prop('disabled', false);
                $('#cardListaErroLogBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaErroLogBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroLogBtnUltimo').prop('disabled', false);
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
        $('#cardListaErroLogBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroLogBtnPrimeiro').prop('disabled', true);
        $('#cardListaErroLogBtnPrimeiro').data('id', 0);
        $('#cardListaErroLogBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroLogBtnAnterior').prop('disabled', true);
        $('#cardListaErroLogBtnAnterior').data('id', 0);
        $('#cardListaErroLogBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroLogBtnAtual').prop('disabled', true);
        $('#cardListaErroLogBtnAtual').data('id', 0);
        $('#cardListaErroLogBtnAtual').html('...');
        $('#cardListaErroLogBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroLogBtnProximo').prop('disabled', true);
        $('#cardListaErroLogBtnProximo').data('id', 0);
        $('#cardListaErroLogBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroLogBtnUltimo').prop('disabled', true);
        $('#cardListaErroLogBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaErroLogTabelaSize').prop('class', '');
        $('#cardListaErroLogTabelaSize').html('Nengum registro encontrado ...');
    }
};

/**
 * Controlador da lista de registros (paginação)
 * @type array
 */
var controllerInterfaseGeralTabErroApi = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 16,
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
            $('#cardListaErroApiBtnAtual').data('id', paginaSelecionada);
            $('#cardListaErroApiBtnAtual').html(paginaSelecionada);
            $('#cardListaErroApiBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaErroApiBtnAtual').prop('disabled', false);
            $('#cardListaErroApiTabelaSize').prop('class', '');
            $('#cardListaErroApiTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaErroApiBtnPrimeiro').data('id', 1);
                $('#cardListaErroApiBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroApiBtnPrimeiro').prop('disabled', false);
                $('#cardListaErroApiBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaErroApiBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroApiBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaErroApiBtnPrimeiro').data('id', 0);
                $('#cardListaErroApiBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaErroApiBtnPrimeiro').prop('disabled', true);
                $('#cardListaErroApiBtnAnterior').data('id', 0);
                $('#cardListaErroApiBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaErroApiBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaErroApiBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaErroApiBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroApiBtnProximo').prop('disabled', false);
                $('#cardListaErroApiBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaErroApiBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaErroApiBtnUltimo').prop('disabled', false);
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
        $('#cardListaErroApiBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroApiBtnPrimeiro').prop('disabled', true);
        $('#cardListaErroApiBtnPrimeiro').data('id', 0);
        $('#cardListaErroApiBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroApiBtnAnterior').prop('disabled', true);
        $('#cardListaErroApiBtnAnterior').data('id', 0);
        $('#cardListaErroApiBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroApiBtnAtual').prop('disabled', true);
        $('#cardListaErroApiBtnAtual').data('id', 0);
        $('#cardListaErroApiBtnAtual').html('...');
        $('#cardListaErroApiBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroApiBtnProximo').prop('disabled', true);
        $('#cardListaErroApiBtnProximo').data('id', 0);
        $('#cardListaErroApiBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaErroApiBtnUltimo').prop('disabled', true);
        $('#cardListaErroApiBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaErroApiTabelaSize').prop('class', '');
        $('#cardListaErroApiTabelaSize').html('Nengum registro encontrado ...');
    }
};

////////////////////////////////////////////////////////////////////////////////
//                              - CARD EDITOR -                               //
////////////////////////////////////////////////////////////////////////////////
var controllerInterfaseGeralCardEditor = {
    /**
     * Retorna formulario para estado inicial de edição.
     */
    setEstadoInicial: function () {
        $('#cardEditorTitulo').html('<i class="mdi mdi-information-outline"></i> Editor de Dashboard #----');
        $('#cardEditorLabelID').html('#-----');
        $('#cardEditorDataCadastro').html('<i class="mdi mdi-calendar-clock"></i> -----');
        $('#cardEditorLocal').val('');
        $('#cardEditorDescricao').val('');
    },
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardEditorCard').css('animation', '');
        $('#cardEditorCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardEditor').fadeIn(50);
        setTimeout("$('#cardEditorCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardEditorCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardEditor').fadeOut(200);
        setTimeout("$('#cardEditorCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        $('#cardEditorCard').css('animation', '');
        $('#cardEditorCard').css('animation', 'bounceOut .5s');
        $('#cardEditor').fadeOut(600);
        setTimeout(function () {
            $('#cardEditorCard').css('animation', '');
        }, 600);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardEditorCard').css('animation', 'shake .9s');
        $('#cardEditorBtnSalvar').addClass('btn-danger').removeClass('btn-success');
        setTimeout(function () {
            $('#cardEditorBtnSalvar').addClass('btn-success').removeClass('btn-danger');
            $('#cardEditorCard').css('animation', '');
        }, 500);
    }
};