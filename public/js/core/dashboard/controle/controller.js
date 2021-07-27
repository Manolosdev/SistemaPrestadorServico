/**
 * JAVASCRIPT
 * 
 * Controlador de operações da interfase.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */

/**
 * Controlador da lista de registros (paginação)
 * @type array
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
    }
};

////////////////////////////////////////////////////////////////////////////////
//                              - CARD EDITOR -                               //
////////////////////////////////////////////////////////////////////////////////
var controllerInterfaseGeralCardEditor = {
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
            $('#cardEditorListaUsuarioBtnAtual').data('id', paginaSelecionada);
            $('#cardEditorListaUsuarioBtnAtual').html(paginaSelecionada);
            $('#cardEditorListaUsuarioBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardEditorListaUsuarioBtnAtual').prop('disabled', false);
            $('#cardEditorListaUsuarioSize').prop('class', '');
            $('#cardEditorListaUsuarioSize').html('Mostrando <b>' + registroPorPagina + '</b> de <b>' + totalRegistro + '</b> registros');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardEditorListaUsuarioBtnPrimeiro').data('id', 1);
                $('#cardEditorListaUsuarioBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaUsuarioBtnPrimeiro').prop('disabled', false);
                $('#cardEditorListaUsuarioBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardEditorListaUsuarioBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaUsuarioBtnAnterior').prop('disabled', false);
            } else {
                $('#cardEditorListaUsuarioBtnPrimeiro').data('id', 0);
                $('#cardEditorListaUsuarioBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardEditorListaUsuarioBtnPrimeiro').prop('disabled', true);
                $('#cardEditorListaUsuarioBtnAnterior').data('id', 0);
                $('#cardEditorListaUsuarioBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardEditorListaUsuarioBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardEditorListaUsuarioBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardEditorListaUsuarioBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaUsuarioBtnProximo').prop('disabled', false);
                $('#cardEditorListaUsuarioBtnUltimo').data('id', quantidadePaginas);
                $('#cardEditorListaUsuarioBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaUsuarioBtnUltimo').prop('disabled', false);
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
        $('#cardEditorListaUsuarioBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaUsuarioBtnPrimeiro').prop('disabled', true);
        $('#cardEditorListaUsuarioBtnPrimeiro').data('id', 0);
        $('#cardEditorListaUsuarioBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaUsuarioBtnAnterior').prop('disabled', true);
        $('#cardEditorListaUsuarioBtnAnterior').data('id', 0);
        $('#cardEditorListaUsuarioBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaUsuarioBtnAtual').prop('disabled', true);
        $('#cardEditorListaUsuarioBtnAtual').data('id', 0);
        $('#cardEditorListaUsuarioBtnAtual').html('...');
        $('#cardEditorListaUsuarioBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaUsuarioBtnProximo').prop('disabled', true);
        $('#cardEditorListaUsuarioBtnProximo').data('id', 0);
        $('#cardEditorListaUsuarioBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaUsuarioBtnUltimo').prop('disabled', true);
        $('#cardEditorListaUsuarioBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardEditorListaUsuarioSize').prop('class', '');
        $('#cardEditorListaUsuarioSize').html('Nengum registro encontrado ...');
    },
    /**
     * Retorna formulario para estado inicial de edição.
     */
    setEstadoInicial: function () {
        $('#cardEditorTitulo').html('<i class="mdi mdi-chart-arc"></i> Editor de Dashboard #----');
        //TAB INFO
        $('#cardEditorID').val('');
        $('#cardEditorDepartamento').val('0');
        $('#cardEditorDescricao').val('');
        //TAB DESENVOLVEDOR
        $('#cardEditorScript').val('');
        $('#cardEditorScriptImg').val('dashboard_default1.png');
        $('#cardEditorScriptImg').change();
        $('#cardEditorScriptRodape').html(APP_HOST +'/public/js/dashboard/...');
        //TAB USUARIOS
        $('#cardEditorListaUsuario').html('<div class="col-12 text-center" style="padding-top: 115px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardEditorListaUsuarioSize').html('<b>0</b> registro(s) encontrado(s)');
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

////////////////////////////////////////////////////////////////////////////////
//                            - CARD RELATORIO -                              //
////////////////////////////////////////////////////////////////////////////////
var controllerInterfaseGeralCardRelatorio = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardRelatorioCard').css('animation', '');
        $('#cardRelatorioCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardRelatorio').fadeIn(50);
        setTimeout("$('#cardRelatorioCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardRelatorioTabela').children().removeClass('div-registro-active').addClass('div-registro');
        $('#cardRelatorioCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardRelatorio').fadeOut(200);
        setTimeout("$('#cardRelatorioCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        $('#cardRelatorioCard').css('animation', '');
        $('#cardRelatorioCard').css('animation', 'bounceOut .5s');
        $('#cardRelatorio').fadeOut(600);
        setTimeout(function () {
            $('#cardRelatorioCard').css('animation', '');
        }, 600);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardRelatorioCard').css('animation', 'shake .9s');
        setTimeout(function () {
            $('#cardRelatorioCard').css('animation', '');
        }, 500);
    }
};