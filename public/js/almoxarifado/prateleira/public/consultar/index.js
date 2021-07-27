/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

/**
 * FUNCTION
 * Constroi card de consulta de prateleira gerado pelo sistema.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function getCardPrateleiraConsultar(registroID, element = null) {
    //GET EMPRESA
    $('#spinnerGeral').fadeIn(50);
    controllerCardPrateleiraConsultar.setVerificarElementoSelecionado(element);
    const registro = await getCardPrateleiraConsultarRegistroJAX(registroID);
    if (registro && registro['id']) {
        await setCardPrateleiraConsultarInitHTML();
        if (await getCardPrateleiraConsultarDependencia(registro)) {
            await controllerCardPrateleiraConsultar.setCardAbrir();
            controllerCardPrateleiraConsultarAnimation.setOpenAnimation();
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
 * @date      13/07/2021
 */
async function setCardPrateleiraConsultarInitHTML(registro) {
    if (!document.querySelector("#cardPrateleiraConsultar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardPrateleiraConsultar"></div>');
        $('#cardPrateleiraConsultar').load(APP_HOST + '/public/js/almoxarifado/prateleira/public/consultar/card.html');
        await sleep(300);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        //ACTIONS
        cardPrateleiraConsultarBtnAction();
        cardPrateleiraConsultarKeyAction();
        cardPrateleiraConsultarChangeAction();
        cardPrateleiraConsultarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardPrateleiraConsultar'));
    setCardPrateleiraConsultarEstadoInicial();
    await sleep(100);
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardPrateleiraConsultarBtnAction() {
    //BTN CLOSE PRINCIPAL
    $('#cardPrateleiraConsultarBtnBack').on('click', async function () {
        $(this).blur();
        if (controllerCardPrateleiraConsultar.elementSelected !== null) {
            $(controllerCardPrateleiraConsultar.elementSelected).addClass('div-registro').removeClass('div-registro-active');
        }
        await controllerCardPrateleiraConsultarAnimation.setCloseAnimation();
        controllerCardPrateleiraConsultar.setCardFechar();
    });
    $('#cardPrateleiraConsultarListaProdutoBtnPrimeiro').on('click', async function () {
        await getCardPrateleiraConsultarListaProdutoControle($(this).data('id'));
    });
    $('#cardPrateleiraConsultarListaProdutoBtnAnterior').on('click', async function () {
        await getCardPrateleiraConsultarListaProdutoControle($(this).data('id'));
    });
    $('#cardPrateleiraConsultarListaProdutoBtnAtual').on('click', async function () {
        await getCardPrateleiraConsultarListaProdutoControle($(this).data('id'));
    });
    $('#cardPrateleiraConsultarListaProdutoBtnProximo').on('click', async function () {
        await getCardPrateleiraConsultarListaProdutoControle($(this).data('id'));
    });
    $('#cardPrateleiraConsultarListaProdutoBtnUltimo').on('click', async function () {
        await getCardPrateleiraConsultarListaProdutoControle($(this).data('id'));
    });
    $('#cardPrateleiraConsultarListaProdutoBtnRelatorio').on('click', function () {
        $(this).blur();
        let nomeRelatorio = 'relatorioAdministrativoPrateleira';
        let tipoRelatorio = 'getListaRegistroPrateleiraProdutoPDF';
        let registroID = $('#cardPrateleiraConsultarID').val();
        $('#spinnerGeral').fadeIn(50);
        setTimeout(function () {
            window.open(APP_HOST + '/almoxarifado/getRelatorioAJAX?operacao=' + nomeRelatorio + '&tipoRelatorio=' + tipoRelatorio + '&registroID=' + registroID);
            $('#spinnerGeral').fadeOut(150);
        }, 800);
    });
}

//KEY ACTION
function cardPrateleiraConsultarKeyAction() {
    //EMPTY
}

//CHANGE ACTION
function cardPrateleiraConsultarChangeAction() {
    //EMPTY
}

//SUBMIT ACTION
function cardPrateleiraConsultarSubmitAction() {
    //EMPTY
}
