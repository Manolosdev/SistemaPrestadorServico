/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      10/05/2021
 */

/**
 * FUNCTION
 * Constroi card solicitado.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */
async function getCardTemplateCorTemplate(openAnimation = true) {
    $('#spinnerGeral').fadeIn(50);
    const registro = await getCardVendaVisitaConsultarRegistroJAX(registroID);
    if (registro && registro['id']) {
        await setCardTemplateCorTemplateInitHTML();
        if (await getCardTemplateCorTemplateDependencia(registro)) {
            await controllerCardTemplateCorTemplate.setCardAbrir();
            if (openAnimation) {
                controllerCardTemplateCorTemplateAnimation.setOpenAnimation();
            } else {
                $('#cardTemplateCorTemplateCard').fadeOut(50);
                await sleep(100);
                $('#cardTemplateCorTemplateCard').fadeIn(400);
                await sleep(400);
            }
            $('#cardTemplateCorTemplateCardBlock').fadeOut();
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
 * @date      24/06/2021
 */
async function setCardTemplateCorTemplateInitHTML(registro) {
    if (!document.querySelector("#cardTemplateCorTemplate")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardTemplateCorTemplate"></div>');
        $('#cardTemplateCorTemplate').load(APP_HOST + '/public/js/template/public/templateCor/card.html');
        await sleep(100);
        //ACTIONS
        cardCardTemplateCorTemplateBtnAction();
        cardCardTemplateCorTemplateKeyAction();
        cardCardTemplateCorTemplateChangeAction();
        cardCardTemplateCorTemplateSubmitAction();
    }
    $('#spinnerGeral').before($('#cardTemplateCorTemplate'));
    setCardTemplateCorTemplateEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardCardTemplateCorTemplateBtnAction() {
    ////////////////////////////////////////////////////////////////////////////
    //                          - CARD PRINCIPAL -                            //
    ////////////////////////////////////////////////////////////////////////////
    //BTN CLOSE PRINCIPAL
    $('#cardCardTemplateCorTemplateBtnBack').on('click', async function () {
        await controllerCardTemplateCorTemplateAnimation.setCloseAnimation();
        controllerCardTemplateCorTemplate.setCardFechar();
    });
}

//KEY ACTION
function cardCardTemplateCorTemplateKeyAction() {
    //EMPTY
}

//CHANGE ACTION
function cardCardTemplateCorTemplateChangeAction() {
    //EMPTY
}

//SUBMIT ACTION
function cardCardTemplateCorTemplateSubmitAction() {
    //EMPTY
}
