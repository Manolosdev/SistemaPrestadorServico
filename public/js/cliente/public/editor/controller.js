/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */

//PRINCIPAL
var controllerCardClienteEditor = {
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
        if ($('#cardClienteEditor').css('display') === 'flex') {
            $('#cardClienteEditorBtnBack').click();
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
     * Efetua pesquisa de CEP informado no endereco.
     * @returns function
     */
    setPesquisarCep: async function () {
        $('#cardClienteEditorEnderecoBtn').blur();
        $('#cardClienteEditorCardBlock').fadeIn(50);
        var cep = $('#cardClienteEditorEnderecoCep').val();
        cep = cep.replace(/\D/g, '');
        if (cep != '') {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $('#cardClienteEditorEnderecoRua').val('...');
                //$('#cardClienteEditorEnderecoReferencia').val('...');
                $('#cardClienteEditorEnderecoBairro').val('...');
                $('#cardClienteEditorEnderecoCidade').val('...');
                $('#cardClienteEditorEnderecoUF').val('');
                $('#cardClienteEditorEnderecoIBGE').val('');
                //await sleep(500);
                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=controllerCardClienteEditor.getEnderecoAPI';
                document.body.appendChild(script);
                $('#cardClienteEditorForm').validate().resetForm();
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
        $('#cardClienteEditorCardBlock').fadeOut(50);
    },
    /**
     * Efetua o preenchimento do formulario com resultado da consulta.
     * @returns function 
     */
    getEnderecoAPI: function (retorno) {
        if (!("erro" in retorno)) {
            $('#cardClienteEditorEnderecoRua').val(this.truncar(retorno.logradouro.toLocaleUpperCase(), 29).trim());
            $('#cardClienteEditorEnderecoRua-error').remove();
            $('#cardClienteEditorEnderecoNumero-error').remove();
            $('#cardClienteEditorEnderecoBairro').val(this.truncar(retorno.bairro.toLocaleUpperCase(), 30).trim());
            $('#cardClienteEditorEnderecoBairro-error').remove();
            $('#cardClienteEditorEnderecoCidade').val(this.truncar(retorno.localidade.toLocaleUpperCase(), 30));
            $('#cardClienteEditorEnderecoCidade-error').remove();
            $('#cardClienteEditorEnderecoUF').val(retorno.uf);
            $('#cardClienteEditorEnderecoIBGE').val(retorno.ibge);
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
        $('#cardClienteEditorEnderecoRua').val('');
        $('#cardClienteEditorEnderecoNumero').val('');
        $('#cardClienteEditorEnderecoReferencia').val('');
        $('#cardClienteEditorEnderecoBairro').val('');
        $('#cardClienteEditorEnderecoCidade').val('');
        $('#cardClienteEditorEnderecoUF').val('');
        $('#cardClienteEditorEnderecoIBGE').val('');
    },
    /**
     * Executa animação de erro de pesquisa de cep.
     */
    setErroAnimationCep: async function () {
        $('#cardClienteEditorEnderecoCep').parent().css('animation', '');
        $('#cardClienteEditorEnderecoCep').parent().css('animation', 'shake 1s');
        $('#cardClienteEditorEnderecoBtn').addClass('btn-danger').removeClass('btn-primary');
        $('#cardClienteEditorEnderecoCep').addClass('error');
        await sleep(500);
        $('#cardClienteEditorEnderecoCep').parent().css('animation', '');
        $('#cardClienteEditorEnderecoBtn').removeClass('btn-danger').addClass('btn-primary');
        $('#cardClienteEditorEnderecoCep').removeClass('error');
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
    }
};
//ANIMATION
var controllerCardClienteEditorAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardClienteEditorCard').css('animation', '');
        $('#cardClienteEditorCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardClienteEditor').fadeIn(50);
        setTimeout("$('#cardClienteEditorCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardClienteEditorCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardClienteEditor').fadeOut(200);
        setTimeout("$('#cardClienteEditorCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardClienteEditorCard').fadeOut(0);
        $('#cardClienteEditorCardDiv').fadeOut(0);
        $('#cardClienteEditorCard').css('animation', '');
        $('#cardClienteEditorDivAnimation').fadeIn(100);
        $('#cardClienteEditorDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardClienteEditorDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardClienteEditor').fadeOut(0);
        $('#cardClienteEditorCard').css('animation', 'bounceOutRight .9s');
        $('#cardClienteEditor').fadeOut(650);
        controllerCardClienteEditor.elementSelected !== null ? $(controllerCardClienteEditor.elementSelected).addClass('div-registro').removeClass('div-registro-active') : null;
        await sleep(500);
        $('#cardClienteEditorCard').css('animation', '');
        $('#cardClienteEditorDivAnimation').fadeOut(0);
        $('#cardClienteEditorDivAnimationImage').css('animation', '');
        $('#cardClienteEditorCardDiv').fadeIn(0);
        $('#cardClienteEditorCard').fadeIn(0);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardClienteEditorCard').css('animation', 'shake .9s');
        $('#cardClienteEditorBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardClienteEditorCard').css('animation', '');
            $('#cardClienteEditorBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};