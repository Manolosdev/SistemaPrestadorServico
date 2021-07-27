/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

//PRINCIPAL
var controllerCardPrateleiraAdicionar = {
    /**
     * Evento da VIEW referente a action ESC/Voltar.
     * @returns integer
     */
    setActionEsc: function () {
        if ($('#cardPrateleiraAdicionar').css('display') === 'flex') {
            $('#cardPrateleiraAdicionarBtnBack').click();
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
        $('#cardPrateleiraAdicionarEnderecoBtn').blur();
        $('#cardPrateleiraAdicionarCardBlock').fadeIn(50);
        var cep = $('#cardPrateleiraAdicionarEnderecoCep').val();
        cep = cep.replace(/\D/g, '');
        if (cep != '') {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $('#cardPrateleiraAdicionarEnderecoRua').val('...');
                $('#cardPrateleiraAdicionarEnderecoBairro').val('...');
                $('#cardPrateleiraAdicionarEnderecoCidade').val('...');
                $('#cardPrateleiraAdicionarEnderecoUF').val('');
                $('#cardPrateleiraAdicionarEnderecoIBGE').val('');
                //await sleep(500);
                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=controllerCardPrateleiraAdicionar.getEnderecoAPI';
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
        $('#cardPrateleiraAdicionarCardBlock').fadeOut(50);
    },
    /**
     * Efetua o preenchimento do formulario com resultado da consulta.
     * @returns function 
     */
    getEnderecoAPI: function (retorno) {
        if (!("erro" in retorno)) {
            $('#cardPrateleiraAdicionarEnderecoRua').val(this.truncar(retorno.logradouro.toLocaleUpperCase(), 29).trim());
            $('#cardPrateleiraAdicionarEnderecoRua-error').remove();
            $('#cardPrateleiraAdicionarEnderecoNumero-error').remove();
            $('#cardPrateleiraAdicionarEnderecoBairro').val(this.truncar(retorno.bairro.toLocaleUpperCase(), 30).trim());
            $('#cardPrateleiraAdicionarEnderecoBairro-error').remove();
            $('#cardPrateleiraAdicionarEnderecoCidade').val(this.truncar(retorno.localidade.toLocaleUpperCase(), 30));
            $('#cardPrateleiraAdicionarEnderecoCidade-error').remove();
            $('#cardPrateleiraAdicionarEnderecoUF').val(retorno.uf);
            $('#cardPrateleiraAdicionarEnderecoIBGE').val(retorno.ibge);
            $('#cardPrateleiraAdicionarForm').valid();
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
        $('#cardPrateleiraAdicionarEnderecoRua').val('');
        $('#cardPrateleiraAdicionarEnderecoNumero').val('');
        $('#cardPrateleiraAdicionarEnderecoReferencia').val('');
        $('#cardPrateleiraAdicionarEnderecoBairro').val('');
        $('#cardPrateleiraAdicionarEnderecoCidade').val('');
        $('#cardPrateleiraAdicionarEnderecoUF').val('');
        $('#cardPrateleiraAdicionarEnderecoIBGE').val('');
    },
    /**
     * Executa animação de erro de pesquisa de cep.
     */
    setErroAnimationCep: async function () {
        $('#cardPrateleiraAdicionarEnderecoCep').parent().css('animation', '');
        $('#cardPrateleiraAdicionarEnderecoCep').parent().css('animation', 'shake 1s');
        $('#cardPrateleiraAdicionarEnderecoBtn').addClass('btn-danger').removeClass('btn-primary');
        $('#cardPrateleiraAdicionarEnderecoCep').addClass('error');
        await sleep(500);
        $('#cardPrateleiraAdicionarEnderecoCep').parent().css('animation', '');
        $('#cardPrateleiraAdicionarEnderecoBtn').removeClass('btn-danger').addClass('btn-primary');
        $('#cardPrateleiraAdicionarEnderecoCep').removeClass('error');
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
var controllerCardPrateleiraAdicionarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardPrateleiraAdicionarCard').css('animation', '');
        $('#cardPrateleiraAdicionarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardPrateleiraAdicionar').fadeIn(50);
        setTimeout("$('#cardPrateleiraAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardPrateleiraAdicionarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardPrateleiraAdicionar').fadeOut(200);
        setTimeout("$('#cardPrateleiraAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardPrateleiraAdicionarCard').fadeOut(0);
        $('#cardPrateleiraAdicionarCardDiv').fadeOut(0);
        $('#cardPrateleiraAdicionarCard').css('animation', '');
        $('#cardPrateleiraAdicionarDivAnimation').fadeIn(100);
        $('#cardPrateleiraAdicionarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardPrateleiraAdicionarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardPrateleiraAdicionar').fadeOut(0);
        $('#cardPrateleiraAdicionarCard').css('animation', 'bounceOutRight .9s');
        $('#cardPrateleiraAdicionar').fadeOut(650);
        setTimeout(function () {
            $('#cardPrateleiraAdicionarCard').css('animation', '');
            $('#cardPrateleiraAdicionarDivAnimation').fadeOut(0);
            $('#cardPrateleiraAdicionarDivAnimationImage').css('animation', '');
            $('#cardPrateleiraAdicionarCardDiv').fadeIn(0);
            $('#cardPrateleiraAdicionarCard').fadeIn(0);
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardPrateleiraAdicionarCard').css('animation', 'shake .9s');
        $('#cardPrateleiraAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardPrateleiraAdicionarCard').css('animation', '');
            $('#cardPrateleiraAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};