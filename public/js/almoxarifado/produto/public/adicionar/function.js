/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */
async function getCardProdutoAdicionarDependencia() {
    $('#cardProdutoAdicionarForm').validate().destroy();
    $('#cardProdutoAdicionarForm').validate({
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
    if ($('#cardProdutoAdicionarEmpresa > option').length <= 1) {
        const empresa = await getCardProdutoAdicionarEmpresaAJAX();
        if (empresa.length > 0) {
            for (var i = 0; i < empresa.length; i++) {
                var registro = empresa[i];
                $('#cardProdutoAdicionarEmpresa').append('<option value="' + registro['id'] + '" ' + (empresa.length === 1 ? 'selected' : '') + '>' + registro['nomeFantasia'] + '</option>');
            }
        }
    }
    $('#cardProdutoAdicionarPrateleira').html('<option value="-1" selected disable>- Selecione primeiro a empresa -</option>');
    $('#cardProdutoAdicionarEmpresa').change();
    await sleep(200);
    return true;
}

/**
 * FUNCTION
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */
async function setCardProdutoAdicionarSubmit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await setCardProdutoAdicionarSubmitAJAX();
    if (retorno > 1) {
        $('#cardProdutoAdicionarID').val(retorno);
        $('#spinnerGeral').fadeOut(50);
        await controllerCardProdutoAdicionarAnimation.setSuccessAnimation();
        controllerCardProdutoAdicionar.setCardAtualizar();
    } else if (isArray(retorno)) {
        setErroServidor(retorno);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
        controllerCardProdutoAdicionarAnimation.setErrorAnimation();
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
 * @date      16/07/2021
 */
function setCardProdutoAdicionarEstadoInicial() {
    $('#cardProdutoAdicionarTabGeral').click();
    $('#cardProdutoAdicionarID').val('');
    $('#cardProdutoAdicionarCardBlock').fadeOut(50);
    //TAB INFORMAÇÃO
    $('#cardProdutoAdicionarCodigo').val('');
    $('#cardProdutoAdicionarNome').val('');
    $('#cardProdutoAdicionarDescricao').val('');
    //TAB estoque
    $('#cardProdutoAdicionarPrateleira').val(-1);
    $('#cardProdutoAdicionarPrateleiraBtn').removeClass('btn-primary').addClass('btn-dark');
    $('#cardProdutoAdicionarPrateleiraBtn').prop('disabled', true);
    $('#cardProdutoAdicionarPrateleiraBtn').unbind();
    $('#cardProdutoAdicionarUnidadeMedida').val(-1);
    $('#cardProdutoAdicionarValorCompra').val('');
    $('#cardProdutoAdicionarValorVenda').val('');
    $('#cardProdutoAdicionarSaldoMinimo').val('');
    $('#cardProdutoAdicionarValorCompra').maskMoney({thousands: '', decimal: ','});
    $('#cardProdutoAdicionarValorVenda').maskMoney({thousands: '', decimal: ','});
}