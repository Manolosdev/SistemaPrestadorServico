/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */
async function getCardClienteAdicionar() {
    $('#spinnerGeral').fadeIn(50);
    await setCardClienteAdicionarInitHTML();
    if (await getCardClienteAdicionarDependencia()) {
        await controllerCardClienteAdicionar.setCardAbrir();
        await controllerCardClienteAdicionarAnimation.setOpenAnimation();
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
 * @date      30/06/2021
 */
async function setCardClienteAdicionarInitHTML() {
    if (!document.querySelector("#cardClienteAdicionar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardClienteAdicionar"></div>');
        $('#cardClienteAdicionar').load(APP_HOST + '/public/js/cliente/public/adicionar/card.html');
        await sleep(500);
        //LIBS
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.mask.js');
        $('#cardClienteAdicionarForm').validate({});
        await sleep(100);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        await getCardClienteAdicionarDependencia();
        //ACTIONS
        cardClienteAdicionarBtnAction();
        cardClienteAdicionarKeyAction();
        cardClienteAdicionarChangeAction();
        cardClienteAdicionarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardClienteAdicionar'));
    await setCardClienteAdicionarEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardClienteAdicionarBtnAction() {
    //BTN CLOSE PRINCIPAL
    $('#cardClienteAdicionarBtnBack').on('click', function () {
        $(this).blur();
        controllerCardClienteAdicionarAnimation.setCloseAnimation();
    });
    $('#cardClienteAdicionarBtnSubmit').on('click', async function () {
        $(this).blur();
        if (!$('#cardClienteAdicionarForm').valid()) {
            if ($('#cardClienteAdicionarPanelGeral').find('.error').length) {
                $('#cardClienteAdicionarTabGeral').click();
            } else if ($('#cardClienteAdicionarPanelEndereco').find('.error').length) {
                $('#cardClienteAdicionarTabEndereco').click();
            }
            toastr.error('Corrija os erros de validação do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            controllerCardClienteAdicionarAnimation.setErrorAnimation();
            return false;
        }
        //SUBMIT
        await setCardClienteAdicionarSubmit();
    });
    $('#cardClienteAdicionarEnderecoBtn').on('click', function () {
        controllerCardClienteAdicionar.setPesquisarCep();
    });
}
//KEY ACTION
function cardClienteAdicionarKeyAction() {
    $('#cardClienteAdicionarEnderecoCep').on('keyup', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardClienteAdicionarEnderecoBtn').click();
        }
    });
}
//CHANGE ACTION
function cardClienteAdicionarChangeAction() {
    $('#cardClienteAdicionarGeralTipoPessoa').on('change', function () {
        if ($(this).val() === 'f') {
            $('#cardClienteAdicionarDivPessoaJuridica').fadeOut(0);
            $('#cardClienteAdicionarDivPessoaJuridicaIcm').fadeOut(0);
            $('#cardClienteAdicionarDivPessoaFisica').fadeIn(0);
        } else {
            $('#cardClienteAdicionarDivPessoaFisica').fadeOut(0);
            $('#cardClienteAdicionarDivPessoaJuridica').fadeIn(0);
            $('#cardClienteAdicionarDivPessoaJuridicaIcm').fadeIn(0);
        }
    });
}
//SUBMIT ACTION
function cardClienteAdicionarSubmitAction() {
    //EMPTY
}
