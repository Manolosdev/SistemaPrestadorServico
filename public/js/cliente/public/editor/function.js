/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
async function getCardClienteEditorDependencia(registro) {
    //VALIDATE
    $('#cardClienteEditorForm').validate().destroy();
    $('#cardClienteEditorForm').validate({
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
            cardClienteEditorGeralCPF: {
                required: {
                    depends: function () {
                        if ($('#cardClienteEditorGeralTipoPessoa').val() === 'f') {
                            return true;
                        }
                    }
                }
            },
            cardClienteEditorGeralRG: {
                required: {
                    depends: function () {
                        if ($('#cardClienteEditorGeralTipoPessoa').val() === 'f') {
                            return true;
                        }
                    }
                }
            },
            cardClienteEditorGeralCNPJ: {
                required: {
                    depends: function () {
                        if ($('#cardClienteEditorGeralTipoPessoa').val() === 'j') {
                            return true;
                        }
                    }
                }
            }
        }
    });
    //EDITOR
    $('#cardClienteEditorID').val(registro['id']);
    $('#cardClienteEditorEnderecoID').val(registro['fkEndereco']);
    //TAB INFORMAÇÃO
    $('#cardClienteEditorTitulo').html('<i class="mdi mdi-account-edit"></i> Editor de Cliente #' + registro['id']);
    $('#cardClienteEditorGeralTipoPessoa').val(registro['tipoPessoa']);
    $('#cardClienteEditorGeralTipoPessoa').change();
    $('#cardClienteEditorGeralCPF').val(registro['cpf']);
    $('#cardClienteEditorGeralRG').val(registro['rg']);
    $('#cardClienteEditorGeralCNPJ').val(registro['cnpj']);
    $('#cardClienteEditorGeralInscricaoMunicipal').val(registro['inscricaoMunicipal']);
    $('#cardClienteEditorGeralInscricaoEstadual').val(registro['inscricaoEstadual']);
    $('#cardClienteEditorGeralNome').val(registro['nome']);
    $('#cardClienteEditorGeralEmail').val(registro['email']);
    $('#cardClienteEditorGeralCelular').val(registro['celular']);
    $('#cardClienteEditorGeralTelefone').val(registro['telefone']);
    //TAB ENDEREÇO
    if (registro['entidadeEndereco'] && registro['entidadeEndereco']['id']) {
        let endereco = registro['entidadeEndereco'];
        $('#cardClienteEditorEnderecoCep').val(endereco['cep']);
        $('#cardClienteEditorEnderecoRua').val(endereco['rua']);
        $('#cardClienteEditorEnderecoNumero').val(endereco['numero']);
        $('#cardClienteEditorEnderecoReferencia').val(endereco['referencia']);
        $('#cardClienteEditorEnderecoBairro').val(endereco['bairro']);
        $('#cardClienteEditorEnderecoCidade').val(endereco['cidade']);
        $('#cardClienteEditorEnderecoUF').val(endereco['uf']);
        $('#cardClienteEditorEnderecoIBGE').val(endereco['ibge']);
    }
    await sleep(200);
    return true;
}

/**
 * FUNCTION
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
async function setCardClienteEditorSubmit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await setCardClienteEditorSubmitAJAX();
    if (retorno === 0) {
        controllerCardClienteEditorAnimation.setSuccessAnimation();
        controllerCardClienteEditor.setCardAtualizar();
    } else if (isArray(retorno)) {
        setErroServidor(retorno);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
        controllerCardClienteEditorAnimation.setErrorAnimation();
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
 * @date      15/07/2021
 */
function setCardClienteEditorEstadoInicial() {
    //TAB GERAL
    $('#cardClienteEditorForm').validate().resetForm();
    $('#cardClienteEditorForm').find('.error').removeClass('error');
    $('#cardClienteEditorGeralTipoPessoa').val('f');
    $('#cardClienteEditorDivPessoaJuridica').fadeOut(0);
    $('#cardClienteEditorDivPessoaJuridicaIcm').fadeOut(0);
    $('#cardClienteEditorDivPessoaFisica').fadeIn(0);
    $('#cardClienteEditorTitulo').html('<i class="mdi mdi-account-edit"></i> Editor de Cliente #');
    $('#cardClienteEditorID').val('');
    $('#cardClienteEditorEnderecoID').val('');
    $('#cardClienteEditorGeralCPF').val('');
    $('#cardClienteEditorGeralRG').val('');
    $('#cardClienteEditorGeralCNPJ').val('');
    $('#cardClienteEditorGeralInscricaoMunicipal').val('');
    $('#cardClienteEditorGeralInscricaoEstadual').val('');
    $('#cardClienteEditorGeralNome').val('');
    $('#cardClienteEditorGeralEmail').val('');
    $('#cardClienteEditorGeralCelular').val('');
    $('#cardClienteEditorGeralTelefone').val('');
    //TAB ENDEREÇO
    $('#cardClienteEditorEnderecoCep').val('');
    $('#cardClienteEditorEnderecoRua').val('');
    $('#cardClienteEditorEnderecoNumero').val('');
    $('#cardClienteEditorEnderecoReferencia').val('');
    $('#cardClienteEditorEnderecoBairro').val('');
    $('#cardClienteEditorEnderecoCidade').val('');
    $('#cardClienteEditorEnderecoUF').val('');
    $('#cardClienteEditorEnderecoIBGE').val('');

    $('#cardClienteEditorCardBlock').fadeOut(50);
    $('#cardClienteEditorTabGeral').click();
}