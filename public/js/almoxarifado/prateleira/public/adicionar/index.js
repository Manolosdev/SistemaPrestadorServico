/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function getCardPrateleiraAdicionar() {
    $('#spinnerGeral').fadeIn(50);
    await setCardPrateleiraAdicionarInitHTML();
    if (await getCardPrateleiraAdicionarDependencia()) {
        await controllerCardPrateleiraAdicionar.setCardAbrir();
        await controllerCardPrateleiraAdicionarAnimation.setOpenAnimation();
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#cardPrateleiraAdicionarNome').focus();
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Construção do HTML do recurso de vizualização.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function setCardPrateleiraAdicionarInitHTML() {
    if (!document.querySelector("#cardPrateleiraAdicionar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardPrateleiraAdicionar"></div>');
        $('#cardPrateleiraAdicionar').load(APP_HOST + '/public/js/almoxarifado/prateleira/public/adicionar/card.html');
        await sleep(300);
        //LIBS
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.mask.js');
        $('#cardPrateleiraAdicionarForm').validate({});
        await sleep(100);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        await getCardPrateleiraAdicionarDependencia();
        //ACTIONS
        cardPrateleiraAdicionarBtnAction();
        cardPrateleiraAdicionarKeyAction();
        cardPrateleiraAdicionarChangeAction();
        cardPrateleiraAdicionarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardPrateleiraAdicionar'));
    await setCardPrateleiraAdicionarEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardPrateleiraAdicionarBtnAction() {
    //BTN CLOSE PRINCIPAL
    $('#cardPrateleiraAdicionarBtnBack').on('click', function () {
        $(this).blur();
        controllerCardPrateleiraAdicionarAnimation.setCloseAnimation();
    });
    $('#cardPrateleiraAdicionarBtnSubmit').on('click', async function () {
        $(this).blur();
        if (!$('#cardPrateleiraAdicionarForm').valid()) {
            if ($('#cardPrateleiraAdicionarPanelGeral').find('.error').length) {
                $('#cardPrateleiraAdicionarTabGeral').click();
            } else if ($('#cardPrateleiraAdicionarPanelEndereco').find('.error').length) {
                $('#cardPrateleiraAdicionarTabEndereco').click();
            }
            toastr.error('Corrija os erros de validação do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            controllerCardPrateleiraAdicionarAnimation.setErrorAnimation();
            return false;
        }
        //SUBMIT
        await setCardPrateleiraAdicionarSubmit();
    });
    $('#cardPrateleiraAdicionarEnderecoBtn').on('click', function () {
        controllerCardPrateleiraAdicionar.setPesquisarCep();
    });
}
//KEY ACTION
function cardPrateleiraAdicionarKeyAction() {
    $('#cardPrateleiraAdicionarEnderecoCep').on('keyup', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardPrateleiraAdicionarEnderecoBtn').click();
        }
    });
}
//CHANGE ACTION
function cardPrateleiraAdicionarChangeAction() {
    //EMPTY
}
//SUBMIT ACTION
function cardPrateleiraAdicionarSubmitAction() {
    //EMPTY
}
