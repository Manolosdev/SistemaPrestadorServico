/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      10/05/2021
 */

//PRINCIPAL
var controllerCardVendaVisitaConsultar = {
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
        if ($('#cardVendaVisitaConsultarCardAlterarSituacao').css('display') === 'flex') {
            $('#cardVendaVisitaConsultarCardAlterarSituacaoBtnBack').click();
            return 0;
        }
        if ($('#cardVendaVisitaConsultarCardAdicionarComentario').css('display') === 'flex') {
            $('#cardVendaVisitaConsultarCardAdicionarComentarioBtnBack').click();
            return 0;
        }
        if ($('#cardVendaVisitaConsultarCardDetalheHistorico').css('display') === 'flex') {
            $('#cardVendaVisitaConsultarCardDetalheHistoricoBtnBack').click();
            return 0;
        }
        if ($('#cardVendaVisitaConsultarCardMapa').css('display') === 'flex') {
            $('#cardVendaVisitaConsultarCardMapaBtnBack').click();
            return 0;
        }
        if ($('#cardVendaVisitaConsultar').css('display') === 'flex') {
            if (this.elementSelected !== null) {
                $(this.elementSelected).addClass('div-registro').removeClass('div-registro-active');
            }
            $('#cardVendaVisitaConsultarBtnBack').click();
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
var controllerCardVendaVisitaConsultarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardVendaVisitaConsultarCard').css('animation', '');
        $('#cardVendaVisitaConsultarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardVendaVisitaConsultar').fadeIn(50);
        setTimeout("$('#cardVendaVisitaConsultarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardVendaVisitaConsultarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardVendaVisitaConsultar').fadeOut(200);
        setTimeout("$('#cardVendaVisitaConsultarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardVendaVisitaConsultarCard').fadeOut(0);
        $('#cardVendaVisitaConsultarCardDiv').fadeOut(0);
        $('#cardVendaVisitaConsultarCard').css('animation', '');
        $('#cardVendaVisitaConsultarDivAnimation').fadeIn(100);
        $('#cardVendaVisitaConsultarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardVendaVisitaConsultarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardVendaVisitaConsultar').fadeOut(0);
        $('#cardVendaVisitaConsultarCard').css('animation', 'bounceOutRight .9s');
        $('#cardVendaVisitaConsultar').fadeOut(650);
        setTimeout(function () {
            $('#cardVendaVisitaConsultarCard').css('animation', '');
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setCancelarAnimation: async function () {
        controllerCardVendaVisitaConsultar.setCardAtualizar();
        $('#cardVendaVisitaConsultarCard').fadeOut(0);
        await sleep(200);
        $('#cardVendaVisitaConsultarCard').fadeIn(200);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardVendaVisitaConsultarCard').css('animation', 'shake .9s');
        $('#cardVendaVisitaConsultarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardVendaVisitaConsultarCard').css('animation', '');
            $('#cardVendaVisitaConsultarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};
//TAB HISTORICO
var controllerCardVendaVisitaConsultarTabHistorico = {
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
            $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').data('id', paginaSelecionada);
            $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').html(paginaSelecionada);
            $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').prop('disabled', false);
            $('#cardVendaVisitaConsultarTabHistoricoTabelaSize').prop('class', '');
            $('#cardVendaVisitaConsultarTabHistoricoTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnPrimeiro').data('id', 1);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnPrimeiro').prop('disabled', false);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAnterior').prop('disabled', false);
            } else {
                $('#cardVendaVisitaConsultarTabHistoricoTabelaPrimeiro').data('id', 0);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardVendaVisitaConsultarTabHistoricoTabelaPrimeiro').prop('disabled', true);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaAnterior').data('id', 0);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardVendaVisitaConsultarTabHistoricoTabelaAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnProximo').prop('disabled', false);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnUltimo').data('id', quantidadePaginas);
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnUltimo').prop('disabled', false);
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
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnPrimeiro').prop('disabled', true);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnPrimeiro').data('id', 0);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAnterior').prop('disabled', true);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAnterior').data('id', 0);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').prop('disabled', true);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').data('id', 0);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnAtual').html('...');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnProximo').prop('disabled', true);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnProximo').data('id', 0);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnUltimo').prop('disabled', true);
        $('#cardVendaVisitaConsultarTabHistoricoTabelaBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardVendaVisitaConsultarTabHistoricoTabelaSize').prop('class', '');
        $('#cardVendaVisitaConsultarTabHistoricoTabelaSize').html('Nengum registro encontrado ...');
    }
};
////////////////////////////////////////////////////////////////////////////////
//                          - CARD DETALHE HISTORICO -                        //
////////////////////////////////////////////////////////////////////////////////
var controllerCardVendaVisitaConsultarCardDetalheHistorico = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardVendaVisitaConsultarCardDetalheHistoricoCard').css('animation', '');
        $('#cardVendaVisitaConsultarCardDetalheHistoricoCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardVendaVisitaConsultarCardDetalheHistorico').fadeIn(50);
        setTimeout("$('#cardVendaVisitaConsultarCardDetalheHistoricoCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardVendaVisitaConsultarCardDetalheHistoricoCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardVendaVisitaConsultarCardDetalheHistorico').fadeOut(200);
        setTimeout("$('#cardVendaVisitaConsultarCardDetalheHistoricoCard').css('animation', '')", 500);
    }
};
////////////////////////////////////////////////////////////////////////////////
//                        - CARD ADICIONAR COMENTÁRIO -                       //
////////////////////////////////////////////////////////////////////////////////
var controllerCardVendaVisitaConsultarCardAdicionarComentario = {
    /**
     * Retorna formulario para seu estado inicial
     */
    setEstadoInicial: function () {
        $('#cardVendaVisitaConsultarCardAdicionarComentarioForm').validate().resetForm();
        $('#cardVendaVisitaConsultarCardAdicionarComentarioForm').find('.error').removeClass('error');
        $('#cardVendaVisitaConsultarCardAdicionarComentarioComentario').val('');
    },
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', '');
        $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardVendaVisitaConsultarCardAdicionarComentario').fadeIn(50);
        setTimeout("$('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardVendaVisitaConsultarCardAdicionarComentario').fadeOut(200);
        setTimeout("$('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', '');
        $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', 'bounceOut .5s');
        $('#cardVendaVisitaConsultarCardAdicionarComentario').fadeOut(600);
        setTimeout(function () {
            $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', '');
        }, 600);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', 'shake .9s');
        $('#cardVendaVisitaConsultarCardAdicionarComentarioBtnSubmit').addClass('btn-danger').removeClass('btn-success');
        setTimeout(function () {
            $('#cardVendaVisitaConsultarCardAdicionarComentarioBtnSubmit').addClass('btn-success').removeClass('btn-danger');
            $('#cardVendaVisitaConsultarCardAdicionarComentarioCard').css('animation', '');
        }, 500);
    }
};
////////////////////////////////////////////////////////////////////////////////
//                         - CARD ALTERAR SITUAÇÃO -                          //
////////////////////////////////////////////////////////////////////////////////
var controllerCardVendaVisitaConsultarCardAlterarSituacao = {
    /**
     * Retorna formulario para seu estado inicial
     */
    setEstadoInicial: function () {
        $('#cardVendaVisitaConsultarCardAlterarSituacaoForm').validate().resetForm();
        $('#cardVendaVisitaConsultarCardAlterarSituacaoForm').find('.error').removeClass('error');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoSituacao').val(-1);
        $('#cardVendaVisitaConsultarCardAlterarSituacaoDias').val('');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoDias').prop('disabled', true);
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoNome').val('');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoNome').prop('disabled', true);
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoNome').prop('required', false);
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoCelular').val('');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoCelular').prop('disabled', true);
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoCelular').prop('required', false);
        $('#cardVendaVisitaConsultarCardAlterarSituacaoComentario').val('');
    },
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoNome').val($('#cardVendaVisitaConsultarTabCadastroLabelContatoNome').text() !== '-----' ? $('#cardVendaVisitaConsultarTabCadastroLabelContatoNome').text() : '');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoContatoCelular').val($('#cardVendaVisitaConsultarTabCadastroLabelContatoCelular').text() !== '-----' ? $('#cardVendaVisitaConsultarTabCadastroLabelContatoCelular').text() : '');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', '');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardVendaVisitaConsultarCardAlterarSituacao').fadeIn(50);
        setTimeout("$('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardVendaVisitaConsultarCardAlterarSituacao').fadeOut(200);
        setTimeout("$('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', '');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', 'bounceOut .5s');
        $('#cardVendaVisitaConsultarCardAlterarSituacao').fadeOut(600);
        setTimeout(function () {
            $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', '');
        }, 600);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', 'shake .9s');
        $('#cardVendaVisitaConsultarCardAlterarSituacaoBtnSubmit').addClass('btn-danger').removeClass('btn-success');
        setTimeout(function () {
            $('#cardVendaVisitaConsultarCardAlterarSituacaoBtnSubmit').addClass('btn-success').removeClass('btn-danger');
            $('#cardVendaVisitaConsultarCardAlterarSituacaoCard').css('animation', '');
        }, 500);
    }
};