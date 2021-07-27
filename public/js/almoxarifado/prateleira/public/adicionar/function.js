/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function getCardPrateleiraAdicionarDependencia() {
    $('#cardPrateleiraAdicionarForm').validate().destroy();
    $('#cardPrateleiraAdicionarForm').validate({
        ignore: '',
        errorClass: "error",
        errorElement: 'label',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        onError: function () {
            $('.input-group.error-class').find('.help-block.form-error').each(function () {
                $(this).closest('.form-group').addClass('error').append($(this));
            });
        },
        success: function (element) {
            $(element).parent('.form-group').removeClass('error');
            $(element).remove();
        },
        rules: {}
    });
    //EMPRESAS
    const empresa = await getCardPrateleiraAdicionarEmpresaAJAX();
    if (empresa.length > 0) {
        $('#cardPrateleiraAdicionarEmpresa').html('');
        for (var i = 0; i < empresa.length; i++) {
            var registro = empresa[i];
            $('#cardPrateleiraAdicionarEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
        }
    }
    await sleep(200);
    return true;
}

/**
 * FUNCTION
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function setCardPrateleiraAdicionarSubmit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await setCardPrateleiraAdicionarSubmitAJAX();
    if (retorno > 1) {
        $('#cardPrateleiraAdicionarID').val(retorno);
        await controllerCardPrateleiraAdicionarAnimation.setSuccessAnimation();
        controllerCardPrateleiraAdicionar.setCardAtualizar();
    } else if (isArray(retorno)) {
        setErroServidor(retorno);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
        controllerCardPrateleiraAdicionarAnimation.setErrorAnimation();
    }
    $('#spinnerGeral').fadeOut(50);
}

////////////////////////////////////////////////////////////////////////////////
//                          - INTERNAL FUNCTION -                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna SCRIPT para seu estado inicial.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
function setCardPrateleiraAdicionarEstadoInicial() {
    //TAB INFORMAÇÃO
    $('#cardPrateleiraAdicionarTabGeral').click();
    $('#cardPrateleiraAdicionarID').val('');
    $('#cardPrateleiraAdicionarNome').val('');
    $('#cardPrateleiraAdicionarDescricao').val('');
    //TAB ENDEREÇO
    $('#cardPrateleiraAdicionarEnderecoCep').val('');
    $('#cardPrateleiraAdicionarEnderecoRua').val('');
    $('#cardPrateleiraAdicionarEnderecoNumero').val('');
    $('#cardPrateleiraAdicionarEnderecoReferencia').val('');
    $('#cardPrateleiraAdicionarEnderecoBairro').val('');
    $('#cardPrateleiraAdicionarEnderecoCidade').val('');
    $('#cardPrateleiraAdicionarEnderecoUF').val('');
    $('#cardPrateleiraAdicionarEnderecoIBGE').val('');
    $('#cardPrateleiraAdicionarCardBlock').fadeOut(50);
}