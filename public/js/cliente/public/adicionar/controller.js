/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */

//PRINCIPAL
var controllerCardClienteAdicionar = {
    /**
     * Evento da VIEW referente a action ESC/Voltar.
     * @returns integer
     */
    setActionEsc: function () {
        if ($('#cardClienteAdicionar').css('display') === 'flex') {
            $('#cardClienteAdicionarBtnBack').click();
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
        $('#cardClienteAdicionarEnderecoBtn').blur();
        $('#cardClienteAdicionarCardBlock').fadeIn(50);
        var cep = $('#cardClienteAdicionarEnderecoCep').val();
        cep = cep.replace(/\D/g, '');
        if (cep != '') {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $('#cardClienteAdicionarEnderecoRua').val('...');
                //$('#cardClienteAdicionarEnderecoReferencia').val('...');
                $('#cardClienteAdicionarEnderecoBairro').val('...');
                $('#cardClienteAdicionarEnderecoCidade').val('...');
                $('#cardClienteAdicionarEnderecoUF').val('');
                $('#cardClienteAdicionarEnderecoIBGE').val('');
                //await sleep(500);
                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=controllerCardClienteAdicionar.getEnderecoAPI';
                document.body.appendChild(script);
                $('#cardClienteAdicionarForm').validate().resetForm();
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
        $('#cardClienteAdicionarCardBlock').fadeOut(50);
    },
    /**
     * Efetua o preenchimento do formulario com resultado da consulta.
     * @returns function 
     */
    getEnderecoAPI: function (retorno) {
        if (!("erro" in retorno)) {
            $('#cardClienteAdicionarEnderecoRua').val(this.truncar(retorno.logradouro.toLocaleUpperCase(), 29).trim());
            $('#cardClienteAdicionarEnderecoRua-error').remove();
            $('#cardClienteAdicionarEnderecoNumero-error').remove();
            $('#cardClienteAdicionarEnderecoBairro').val(this.truncar(retorno.bairro.toLocaleUpperCase(), 30).trim());
            $('#cardClienteAdicionarEnderecoBairro-error').remove();
            $('#cardClienteAdicionarEnderecoCidade').val(this.truncar(retorno.localidade.toLocaleUpperCase(), 30));
            $('#cardClienteAdicionarEnderecoCidade-error').remove();
            $('#cardClienteAdicionarEnderecoUF').val(retorno.uf);
            $('#cardClienteAdicionarEnderecoIBGE').val(retorno.ibge);
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
        $('#cardClienteAdicionarEnderecoRua').val('');
        $('#cardClienteAdicionarEnderecoNumero').val('');
        $('#cardClienteAdicionarEnderecoReferencia').val('');
        $('#cardClienteAdicionarEnderecoBairro').val('');
        $('#cardClienteAdicionarEnderecoCidade').val('');
        $('#cardClienteAdicionarEnderecoUF').val('');
        $('#cardClienteAdicionarEnderecoIBGE').val('');
    },
    /**
     * Executa animação de erro de pesquisa de cep.
     */
    setErroAnimationCep: async function () {
        $('#cardClienteAdicionarEnderecoCep').parent().css('animation', '');
        $('#cardClienteAdicionarEnderecoCep').parent().css('animation', 'shake 1s');
        $('#cardClienteAdicionarEnderecoBtn').addClass('btn-danger').removeClass('btn-primary');
        $('#cardClienteAdicionarEnderecoCep').addClass('error');
        await sleep(500);
        $('#cardClienteAdicionarEnderecoCep').parent().css('animation', '');
        $('#cardClienteAdicionarEnderecoBtn').removeClass('btn-danger').addClass('btn-primary');
        $('#cardClienteAdicionarEnderecoCep').removeClass('error');
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
var controllerCardClienteAdicionarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardClienteAdicionarCard').css('animation', '');
        $('#cardClienteAdicionarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardClienteAdicionar').fadeIn(50);
        setTimeout("$('#cardClienteAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardClienteAdicionarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardClienteAdicionar').fadeOut(200);
        setTimeout("$('#cardClienteAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardClienteAdicionarCard').fadeOut(0);
        $('#cardClienteAdicionarCardDiv').fadeOut(0);
        $('#cardClienteAdicionarCard').css('animation', '');
        $('#cardClienteAdicionarDivAnimation').fadeIn(100);
        $('#cardClienteAdicionarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardClienteAdicionarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardClienteAdicionar').fadeOut(0);
        $('#cardClienteAdicionarCard').css('animation', 'bounceOutRight .9s');
        $('#cardClienteAdicionar').fadeOut(650);
        setTimeout(function () {
            $('#cardClienteAdicionarCard').css('animation', '');
            $('#cardClienteAdicionarDivAnimation').fadeOut(0);
            $('#cardClienteAdicionarDivAnimationImage').css('animation', '');
            $('#cardClienteAdicionarCardDiv').fadeIn(0);
            $('#cardClienteAdicionarCard').fadeIn(0);
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardClienteAdicionarCard').css('animation', 'shake .9s');
        $('#cardClienteAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardClienteAdicionarCard').css('animation', '');
            $('#cardClienteAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};