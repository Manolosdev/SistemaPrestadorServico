/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
async function getCardSaidaProdutoAdicionarDependencia() {
    $('#cardSaidaProdutoAdicionarForm').validate().destroy();
    $('#cardSaidaProdutoAdicionarForm').validate({
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
    await sleep(200);
    return true;
}

/**
 * FUNCTION
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
async function setCardSaidaProdutoAdicionarSubmit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await setCardSaidaProdutoAdicionarSubmitAJAX();
    if (retorno === 0) {
        $('#spinnerGeral').fadeOut(50);
        await controllerCardSaidaProdutoAdicionarAnimation.setSuccessAnimation();
        controllerCardSaidaProdutoAdicionar.setCardAtualizar();
    } else if (isArray(retorno)) {
        setErroServidor(retorno);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
        controllerCardSaidaProdutoAdicionarAnimation.setErrorAnimation();
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
 * @date      22/07/2021
 */
function setCardSaidaProdutoAdicionarEstadoInicial() {
    $('#cardSaidaProdutoAdicionarProdutoID').val('');
    $('#cardSaidaProdutoAdicionarProdutoEmpresaID').val('');
    $('#cardSaidaProdutoAdicionarProdutoLabelID').html('# -----');
    $('#cardSaidaProdutoAdicionarProdutoDataCadastro').html('<i class="mdi mdi-calendar-clock"></i> -----');
    $('#cardSaidaProdutoAdicionarProdutoCodigo').html('<i class="mdi mdi-barcode"></i> -----');
    $('#cardSaidaProdutoAdicionarProdutoNome').html('<i class="mdi mdi-tag"></i> -----');
    $('#cardSaidaProdutoAdicionarProdutoMinimoEstoque').html('<i class="mdi mdi-information-outline"></i> -----');
    $('#cardSaidaProdutoAdicionarProdutoEstoqueAtual').html('<i class="mdi mdi-dropbox"></i> -----');
    $('#cardSaidaProdutoAdicionarProdutoEstoqueAtual').prop('class', 'font-12 mb-1');
    $('#cardSaidaProdutoAdicionarValorSaidaSpan').html('--');
    $('#cardSaidaProdutoAdicionarValorSaida').val('');
    $('#cardSaidaProdutoAdicionarValorSaida').prop('max', 99999);
    $('#cardSaidaProdutoAdicionarValorSaida').removeClass('error');
    $('#cardSaidaProdutoAdicionarValorSaida-error').remove();
    $('#cardSaidaProdutoAdicionarComentario').val('');
    $('#cardSaidaProdutoAdicionarCardBlock').fadeOut(50);
}