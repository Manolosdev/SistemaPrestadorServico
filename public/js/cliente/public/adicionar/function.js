/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */
async function getCardClienteAdicionarDependencia() {
    $('#cardClienteAdicionarForm').validate().destroy();
    $('#cardClienteAdicionarForm').validate({
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
        rules: {
            cardClienteAdicionarGeralCPF: {
                required: {
                    depends: function () {
                        if ($('#cardClienteAdicionarGeralTipoPessoa').val() === 'f') {
                            return true;
                        }
                    }
                }
            },
            cardClienteAdicionarGeralRG: {
                required: {
                    depends: function () {
                        if ($('#cardClienteAdicionarGeralTipoPessoa').val() === 'f') {
                            return true;
                        }
                    }
                }
            },
            cardClienteAdicionarGeralCNPJ: {
                required: {
                    depends: function () {
                        if ($('#cardClienteAdicionarGeralTipoPessoa').val() === 'j') {
                            return true;
                        }
                    }
                }
            }
        }
    });
    await sleep(200);
    return true;
}

/**
 * FUNCTION
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */
async function setCardClienteAdicionarSubmit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await setCardClienteAdicionarSubmitAJAX();
    if (retorno > 1) {
        $('#cardClienteAdicionarID').val(retorno);
        controllerCardClienteAdicionarAnimation.setSuccessAnimation();
        controllerCardClienteAdicionar.setCardAtualizar();
    } else if (isArray(retorno)) {
        setErroServidor(retorno);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
        controllerCardClienteAdicionarAnimation.setErrorAnimation();
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
 * @date      30/06/2021
 */
function setCardClienteAdicionarEstadoInicial() {
    //TAB GERAL
    $('#cardClienteAdicionarForm').validate().resetForm();
    $('#cardClienteAdicionarForm').find('.error').removeClass('error');
    $('#cardClienteAdicionarGeralTipoPessoa').val('f');
    $('#cardClienteAdicionarDivPessoaJuridica').fadeOut(0);
    $('#cardClienteAdicionarDivPessoaJuridicaIcm').fadeOut(0);
    $('#cardClienteAdicionarDivPessoaFisica').fadeIn(0);
    $('#cardClienteAdicionarGeralID').val('');
    $('#cardClienteAdicionarGeralCPF').val('');
    $('#cardClienteAdicionarGeralRG').val('');
    $('#cardClienteAdicionarGeralCNPJ').val('');
    $('#cardClienteAdicionarGeralInscricaoMunicipal').val('');
    $('#cardClienteAdicionarGeralInscricaoEstadual').val('');
    $('#cardClienteAdicionarGeralNome').val('');
    $('#cardClienteAdicionarGeralEmail').val('');
    $('#cardClienteAdicionarGeralCelular').val('');
    $('#cardClienteAdicionarGeralTelefone').val('');
    //TAB ENDEREÇO
    $('#cardClienteAdicionarEnderecoCep').val('');
    $('#cardClienteAdicionarEnderecoRua').val('');
    $('#cardClienteAdicionarEnderecoNumero').val('');
    $('#cardClienteAdicionarEnderecoReferencia').val('');
    $('#cardClienteAdicionarEnderecoBairro').val('');
    $('#cardClienteAdicionarEnderecoCidade').val('');
    $('#cardClienteAdicionarEnderecoUF').val('');
    $('#cardClienteAdicionarEnderecoIBGE').val('');
    
    $('#cardClienteAdicionarCardBlock').fadeOut(50);
    $('#cardClienteAdicionarTabGeral').click();
}