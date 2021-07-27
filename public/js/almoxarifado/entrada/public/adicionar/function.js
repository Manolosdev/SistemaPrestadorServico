/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */
async function getCardEntradaProdutoAdicionarDependencia() {
    $('#cardEntradaProdutoAdicionarForm').validate().destroy();
    $('#cardEntradaProdutoAdicionarForm').validate({
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
 * @date      20/07/2021
 */
async function setCardEntradaProdutoAdicionarSubmit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await setCardEntradaProdutoAdicionarSubmitAJAX();
    if (retorno === 0) {
        $('#spinnerGeral').fadeOut(50);
        await controllerCardEntradaProdutoAdicionarAnimation.setSuccessAnimation();
        controllerCardEntradaProdutoAdicionar.setCardAtualizar();
    } else if (isArray(retorno)) {
        setErroServidor(retorno);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
        controllerCardEntradaProdutoAdicionarAnimation.setErrorAnimation();
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
 * @date      20/07/2021
 */
function setCardEntradaProdutoAdicionarEstadoInicial() {
    $('#cardEntradaProdutoAdicionarProdutoID').val('');
    $('#cardEntradaProdutoAdicionarProdutoEmpresaID').val('');
    $('#cardEntradaProdutoAdicionarProdutoLabelID').html('# -----');
    $('#cardEntradaProdutoAdicionarProdutoDataCadastro').html('<i class="mdi mdi-calendar-clock"></i> -----');
    $('#cardEntradaProdutoAdicionarProdutoCodigo').html('<i class="mdi mdi-barcode"></i> -----');
    $('#cardEntradaProdutoAdicionarProdutoNome').html('<i class="mdi mdi-tag"></i> -----');
    $('#cardEntradaProdutoAdicionarProdutoMinimoEstoque').html('<i class="mdi mdi-information-outline"></i> -----');
    $('#cardEntradaProdutoAdicionarProdutoEstoqueAtual').html('<i class="mdi mdi-dropbox"></i> -----');
    $('#cardEntradaProdutoAdicionarProdutoEstoqueAtual').prop('class', 'font-12 mb-1');
    $('#cardEntradaProdutoAdicionarValorEntradaSpan').html('--');
    $('#cardEntradaProdutoAdicionarValorEntrada').val('');
    $('#cardEntradaProdutoAdicionarValorEntrada').removeClass('error');
    $('#cardEntradaProdutoAdicionarValorEntrada.error').remove();
    $('#cardEntradaProdutoAdicionarComentario').val('');
    $('#cardEntradaProdutoAdicionarCardBlock').fadeOut(50);
}