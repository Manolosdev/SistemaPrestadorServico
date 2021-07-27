/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização dos recursos do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */

/**
 * FUNCTION
 * Inicializa o SCRIPT de dashboard.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */
async function setInitAtendimentoDashPadraoScript() {
    await setAtendimentoDashPadraoHTML();
    await setAtendimentoDashPadraoDepdentencias();
}

/**
 * FUNCTION
 * Inicializa os elementos necessários pra a execução do SCRIPT de dashboard.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */
async function setAtendimentoDashPadraoHTML() {
    if (!document.querySelector('#divAtendimentoPadrao')) {
        $('.container-fluid').append('<div id="divAtendimentoDashPadrao" style="width: 100%"></div>');
        $('#divAtendimentoDashPadrao').load(APP_HOST + '/public/js/dashboard/atendimento/padrao/html.html');
        await sleep(100);
        $('#dashAtendimentoPadraoRedirecionarBtn').prop('href', APP_HOST + '/atendimento/controle');
        $('#dashAtendimentoPadraoMeuAtendimentoTabela').html('<div style="padding-top: 95px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashAtendimentoPadraoMeuDepartamentoTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $("#dashAtendimentoPadraoSemestralTabela").html('<div style="padding-top: 50px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        await $.getScript(APP_HOST + '/public/js/dashboard/atendimento/padrao/function.js');
        await $.getScript(APP_HOST + '/public/js/dashboard/atendimento/padrao/request.js');
        //ATENDIMENTO
        await $.getScript(APP_HOST + '/public/js/atendimento/public/editor/' + SCRIPT_PUBLIC_ATENDIMENTO_EDITOR_INDEX);
        await $.getScript(APP_HOST + '/public/js/atendimento/public/editor/' + SCRIPT_PUBLIC_ATENDIMENTO_EDITOR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/atendimento/public/editor/' + SCRIPT_PUBLIC_ATENDIMENTO_EDITOR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/atendimento/public/editor/' + SCRIPT_PUBLIC_ATENDIMENTO_EDITOR_REQUEST);
    }
    await sleep(100);
}

/**
 * FUNCTION
 * Inicializa os recursos e actions do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */
async function setAtendimentoDashPadraoDepdentencias() {
    //CONFIG
    setDashAtendimentoPadraoConfigScriptPublico();
    //ELEMENTS
    await getDashAtendimentoPadraoAtendimentoMesAtual();
    await setDashAtendimentoPadraoMeusAtendimentos();
    await sleep(200);
    await setDashAtendimentoPadraoMeuDepartamento();
    await sleep(200);
    await setDashAtendimentoPadraoSemestral();
}

/**
 * FUNCTION
 * configuração de eventos dos SCRIPTS public utilizado pelo DASHBOARD 
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
function setDashAtendimentoPadraoConfigScriptPublico() {
    //CARD ATENDIMENTO EDITOR
    controllerCardAtendimentoEditor.setCardFechar = function () {
        $('#dashAtendimentoPadraoMeuDepartamentoTabela').children('div').each(async function () {
            $(this).addClass('div-registro').removeClass('div-registro-active');
        });
        $('#dashAtendimentoPadraoMeuAtendimentoTabela').children('div').each(async function () {
            $(this).addClass('div-registro').removeClass('div-registro-active');
        });
    };
    controllerCardAtendimentoEditor.setCardAtualizar = async function () {
        await setDashAtendimentoPadraoMeusAtendimentos();
        await setDashAtendimentoPadraoMeuDepartamento();
    };
}

////////////////////////////////////////////////////////////////////////////////
//                             - START SCRIPT -                               //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

setInitAtendimentoDashPadraoScript();