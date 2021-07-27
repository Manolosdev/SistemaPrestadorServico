/**
 * CONTROLLER
 * 
 * Objeto responsavel pelo controle de elementos e rotinas da interfase.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */

var controllerInterfaseGeral = {
};

//TAB PRODUTO
var controllerInterfaseTabPrateleira = {
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
            $('#cardListaPrateleiraBtnAtual').data('id', paginaSelecionada);
            $('#cardListaPrateleiraBtnAtual').html(paginaSelecionada);
            $('#cardListaPrateleiraBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaPrateleiraBtnAtual').prop('disabled', false);
            $('#cardListaPrateleiraTabelaSize').prop('class', '');
            $('#cardListaPrateleiraTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaPrateleiraBtnPrimeiro').data('id', 1);
                $('#cardListaPrateleiraBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaPrateleiraBtnPrimeiro').prop('disabled', false);
                $('#cardListaPrateleiraBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaPrateleiraBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaPrateleiraBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaPrateleiraBtnPrimeiro').data('id', 0);
                $('#cardListaPrateleiraBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaPrateleiraBtnPrimeiro').prop('disabled', true);
                $('#cardListaPrateleiraBtnAnterior').data('id', 0);
                $('#cardListaPrateleiraBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaPrateleiraBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaPrateleiraBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaPrateleiraBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaPrateleiraBtnProximo').prop('disabled', false);
                $('#cardListaPrateleiraBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaPrateleiraBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaPrateleiraBtnUltimo').prop('disabled', false);
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
        $('#cardListaPrateleiraBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaPrateleiraBtnPrimeiro').prop('disabled', true);
        $('#cardListaPrateleiraBtnPrimeiro').data('id', 0);
        $('#cardListaPrateleiraBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaPrateleiraBtnAnterior').prop('disabled', true);
        $('#cardListaPrateleiraBtnAnterior').data('id', 0);
        $('#cardListaPrateleiraBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaPrateleiraBtnAtual').prop('disabled', true);
        $('#cardListaPrateleiraBtnAtual').data('id', 0);
        $('#cardListaPrateleiraBtnAtual').html('...');
        $('#cardListaPrateleiraBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaPrateleiraBtnProximo').prop('disabled', true);
        $('#cardListaPrateleiraBtnProximo').data('id', 0);
        $('#cardListaPrateleiraBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaPrateleiraBtnUltimo').prop('disabled', true);
        $('#cardListaPrateleiraBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaPrateleiraTabelaSize').prop('class', '');
        $('#cardListaPrateleiraTabelaSize').html('Nengum registro encontrado ...');
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
            $('#cardEditorListaProdutoBtnAtual').data('id', paginaSelecionada);
            $('#cardEditorListaProdutoBtnAtual').html(paginaSelecionada);
            $('#cardEditorListaProdutoBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardEditorListaProdutoBtnAtual').prop('disabled', false);
            $('#cardEditorListaProdutoSize').prop('class', '');
            $('#cardEditorListaProdutoSize').html('Mostrando <b>' + registroPorPagina + '</b> de <b>' + totalRegistro + '</b> registros');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardEditorListaProdutoBtnPrimeiro').data('id', 1);
                $('#cardEditorListaProdutoBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaProdutoBtnPrimeiro').prop('disabled', false);
                $('#cardEditorListaProdutoBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardEditorListaProdutoBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaProdutoBtnAnterior').prop('disabled', false);
            } else {
                $('#cardEditorListaProdutoBtnPrimeiro').data('id', 0);
                $('#cardEditorListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardEditorListaProdutoBtnPrimeiro').prop('disabled', true);
                $('#cardEditorListaProdutoBtnAnterior').data('id', 0);
                $('#cardEditorListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardEditorListaProdutoBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardEditorListaProdutoBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardEditorListaProdutoBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaProdutoBtnProximo').prop('disabled', false);
                $('#cardEditorListaProdutoBtnUltimo').data('id', quantidadePaginas);
                $('#cardEditorListaProdutoBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardEditorListaProdutoBtnUltimo').prop('disabled', false);
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
        $('#cardEditorListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaProdutoBtnPrimeiro').prop('disabled', true);
        $('#cardEditorListaProdutoBtnPrimeiro').data('id', 0);
        $('#cardEditorListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaProdutoBtnAnterior').prop('disabled', true);
        $('#cardEditorListaProdutoBtnAnterior').data('id', 0);
        $('#cardEditorListaProdutoBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaProdutoBtnAtual').prop('disabled', true);
        $('#cardEditorListaProdutoBtnAtual').data('id', 0);
        $('#cardEditorListaProdutoBtnAtual').html('...');
        $('#cardEditorListaProdutoBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaProdutoBtnProximo').prop('disabled', true);
        $('#cardEditorListaProdutoBtnProximo').data('id', 0);
        $('#cardEditorListaProdutoBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardEditorListaProdutoBtnUltimo').prop('disabled', true);
        $('#cardEditorListaProdutoBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardEditorListaProdutoSize').prop('class', '');
        $('#cardEditorListaProdutoSize').html('Nengum registro encontrado ...');
    },
    /**
     * Efetua pesquisa de CEP informado no endereco.
     * @returns function
     */
    setPesquisarCep: async function () {
        $('#cardEditorEnderecoCepBtn').blur();
        $('#cardEditorCardBlock').fadeIn(50);
        var cep = $('#cardEditorEnderecoCep').val();
        cep = cep.replace(/\D/g, '');
        if (cep != '') {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $('#cardEditorEnderecoRua').val('...');
                //$('#cardEditorEnderecoReferencia').val('...');
                $('#cardEditorEnderecoBairro').val('...');
                $('#cardEditorEnderecoCidade').val('...');
                $('#cardEditorEnderecoUF').val('');
                $('#cardEditorEnderecoIBGE').val('');
                //await sleep(500);
                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=controllerInterfaseGeralCardEditor.getEnderecoAPI';
                document.body.appendChild(script);
            } else {
                this.setErroAnimationCep();
                this.setLimparFormularioEndereco();
                toastr.error('CEP informado inválido', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            }
        } else {
            this.setErroAnimationCep();
            this.setLimparFormularioEndereco();
            toastr.error('CEP informado inválido', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
        }
        $('#cardEditorCardBlock').fadeOut(50);
    },
    /**
     * Efetua o preenchimento do formulario com resultado da consulta.
     * @returns function 
     */
    getEnderecoAPI: function (retorno) {
        if (!("erro" in retorno)) {
            $('#cardEditorEnderecoRua').val(this.truncar(retorno.logradouro.toLocaleUpperCase(), 29).trim());
            $('#cardEditorEnderecoRua-error').remove();
            $('#cardEditorEnderecoNumero-error').remove();
            $('#cardEditorEnderecoBairro').val(this.truncar(retorno.bairro.toLocaleUpperCase(), 30).trim());
            $('#cardEditorEnderecoBairro-error').remove();
            $('#cardEditorEnderecoCidade').val(this.truncar(retorno.localidade.toLocaleUpperCase(), 30));
            $('#cardEditorEnderecoCidade-error').remove();
            $('#cardEditorEnderecoUF').val(retorno.uf);
            $('#cardEditorEnderecoIBGE').val(retorno.ibge);
        } else {
            this.setLimparFormularioEndereco();
            toastr.error('Nenhum endereço encontrado', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1500'});
        }
    },
    /**
     * Remove valores do formulario de endereco.
     * @returns function
     */
    setLimparFormularioEndereco: function () {
        $('#cardEditorEnderecoRua').val('');
        $('#cardEditorEnderecoNumero').val('');
        $('#cardEditorEnderecoReferencia').val('');
        $('#cardEditorEnderecoBairro').val('');
        $('#cardEditorEnderecoCidade').val('');
        $('#cardEditorEnderecoUF').val('');
        $('#cardEditorEnderecoIBGE').val('');
    },
    /**
     * Executa animação de erro de pesquisa de cep.
     */
    setErroAnimationCep: async function () {
        $('#cardEditorEnderecoCep').parent().css('animation', '');
        $('#cardEditorEnderecoCep').parent().css('animation', 'shake 1s');
        $('#cardEditorEnderecoCepBtn').addClass('btn-danger').removeClass('btn-primary');
        $('#cardEditorEnderecoCep').addClass('error');
        await sleep(500);
        $('#cardEditorEnderecoCep').parent().css('animation', '');
        $('#cardEditorEnderecoCepBtn').removeClass('btn-danger').addClass('btn-primary');
        $('#cardEditorEnderecoCep').removeClass('error');
    },
    /**
     * Recorta parametro de acordo com numero de caracteres informados.
     * @returns function
     */
    truncar: function (texto, limite) {
        if (texto.length > limite) {
            limite--;
            last = texto.substr(limite - 1, 1);
            while (last != ' ' && limite > 0) {
                limite--;
                last = texto.substr(limite - 1, 1);
            }
            last = texto.substr(limite - 2, 1);
            if (last == ',' || last == ';' || last == ':') {
                texto = texto.substr(0, limite - 2);
            } else if (last == '.' || last == '?' || last == '!') {
                texto = texto.substr(0, limite - 1);
            } else {
                texto = texto.substr(0, limite - 1);
            }
        }
        return texto;
    },
    /**
     * Retorna formulario para estado inicial de edição.
     */
    setEstadoInicial: function () {
        $("#cardEditorForm").validate().resetForm();
        $('#cardEditorTitulo').html('<i class="mdi mdi-chart-arc"></i> Editor de Prateleira #----');
        //TAB INFO
        $('#cardEditorID').val('');
        $('#cardEditorLabelID').html('#-----');
        $('#cardEditorLabelDataCadastro').html('<i class="mdi mdi-calendar-check"></i> -----');
        $('#cardEditorNome').val('');
        $('#cardEditorDescricao').val('');
        //TAB ENDEREÇO
        $('#cardEditorEnderecoCep').val('');
        this.setLimparFormularioEndereco();
        //TAB PRODUTO
        $('#cardEditorListaProduto').html('<div class="col-12 text-center" style="padding-top: 115px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardEditorListaProdutoSize').html('<b>0</b> registro(s) encontrado(s)');
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
        $('#cardEditor').fadeOut(500);
        setTimeout(function () {
            $('#cardEditorCard').css('animation', '');
        }, 500);
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
//                             - CARD RELATORIO -                             //
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
        $('#cardRelatorio').fadeOut(500);
        setTimeout(function () {
            $('#cardRelatorioCard').css('animation', '');
        }, 500);
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
