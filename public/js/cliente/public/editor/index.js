/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
async function getCardClienteEditor(registroID, element = null) {
    $('#spinnerGeral').fadeIn(50);
    controllerCardClienteEditor.setVerificarElementoSelecionado(element);
    const registro = await getCardClienteEditorRegistroAJAX(registroID);
    console.log(registro);
    if (registro && registro['id']) {
        await setCardClienteEditorInitHTML();
        if (await getCardClienteEditorDependencia(registro)) {
            await controllerCardClienteEditor.setCardAbrir();
            controllerCardClienteEditorAnimation.setOpenAnimation();
        } else {
            toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
        }
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Construção do HTML do recurso de vizualização.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
async function setCardClienteEditorInitHTML() {
    if (!document.querySelector("#cardClienteEditor")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardClienteEditor"></div>');
        $('#cardClienteEditor').load(APP_HOST + '/public/js/cliente/public/editor/card.html');
        await sleep(500);
        //LIBS
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.mask.js');
        $('#cardClienteEditorForm').validate({});
        await sleep(100);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        //ACTIONS
        cardClienteEditorBtnAction();
        cardClienteEditorKeyAction();
        cardClienteEditorChangeAction();
        cardClienteEditorSubmitAction();
    }
    $('#spinnerGeral').before($('#cardClienteEditor'));
    await setCardClienteEditorEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardClienteEditorBtnAction() {
    //BTN CLOSE PRINCIPAL
    $('#cardClienteEditorBtnBack').on('click', async function () {
        $(this).blur();
        if (controllerCardClienteEditor.elementSelected !== null) {
            $(controllerCardClienteEditor.elementSelected).addClass('div-registro').removeClass('div-registro-active');
        }
        await controllerCardClienteEditorAnimation.setCloseAnimation();
        controllerCardClienteEditor.setCardFechar();
    });
    $('#cardClienteEditorBtnSubmit').on('click', async function () {
        $(this).blur();
        if (!$('#cardClienteEditorForm').valid()) {
            if ($('#cardClienteEditorPanelGeral').find('.error').length) {
                $('#cardClienteEditorTabGeral').click();
            } else if ($('#cardClienteEditorPanelEndereco').find('.error').length) {
                $('#cardClienteEditorTabEndereco').click();
            }
            toastr.error('Corrija os erros de validação do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            controllerCardClienteEditorAnimation.setErrorAnimation();
            return false;
        }
        //SUBMIT
        await setCardClienteEditorSubmit();
    });
    $('#cardClienteEditorEnderecoBtn').on('click', function () {
        controllerCardClienteEditor.setPesquisarCep();
    });
}
//KEY ACTION
function cardClienteEditorKeyAction() {
    $('#cardClienteEditorEnderecoCep').on('keyup', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardClienteEditorEnderecoBtn').click();
        }
    });
}
//CHANGE ACTION
function cardClienteEditorChangeAction() {
    $('#cardClienteEditorGeralTipoPessoa').on('change', function () {
        if ($(this).val() === 'f') {
            $('#cardClienteEditorDivPessoaJuridica').fadeOut(0);
            $('#cardClienteEditorDivPessoaJuridicaIcm').fadeOut(0);
            $('#cardClienteEditorDivPessoaFisica').fadeIn(0);
        } else {
            $('#cardClienteEditorDivPessoaFisica').fadeOut(0);
            $('#cardClienteEditorDivPessoaJuridica').fadeIn(0);
            $('#cardClienteEditorDivPessoaJuridicaIcm').fadeIn(0);
        }
    });
}
//SUBMIT ACTION
function cardClienteEditorSubmitAction() {
    //EMPTY
}
