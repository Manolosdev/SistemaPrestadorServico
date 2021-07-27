/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização dos recursos do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */

/**
 * FUNCTION
 * Inicializa o SCRIPT de dashboard.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
async function setInitDashFinanceiroBoletoScript() {
    await setDashFinanceiroBoletoHTML();
    await setDashFinanceiroBoletoDependencias();
}

/**
 * FUNCTION
 * Inicializa os elementos necessários pra a execução do SCRIPT de dashboard.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
async function setDashFinanceiroBoletoHTML() {
    if (!document.querySelector('#dashFinanceiroBoletoDIV')) {
        $('.container-fluid').append('<div id="dashFinanceiroBoletoDIV" style="width: 100%"></div>');
        $('#dashFinanceiroBoletoDIV').load(APP_HOST + '/public/js/dashboard/financeiro/boleto/html.html');
        await $.getScript(APP_HOST + '/public/js/dashboard/financeiro/boleto/function.js');
        await $.getScript(APP_HOST + '/public/js/dashboard/financeiro/boleto/request.js');
        $('#dashFinanceiroBoletoCardRemessaTabela').html('<div style="padding-top: 45px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashFinanceiroBoletoCardTabelaBoleto').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashFinanceiroBoletoCardBoletoTabela').html('<div style="padding-top: 45px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        //SCRIPT BOLETO
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/boleto/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_BOLETO_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/boleto/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_BOLETO_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/boleto/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_BOLETO_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/boleto/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_BOLETO_CONSULTAR_REQUEST);
        await sleep(100);
        //SCRIPT REMESSA
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/remessa/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_REMESSA_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/remessa/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_REMESSA_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/remessa/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_REMESSA_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/remessa/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_REMESSA_CONSULTAR_REQUEST);
        await sleep(100);
        //SCRIPT RETORNO
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/retorno/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_RETORNO_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/retorno/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_RETORNO_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/retorno/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_RETORNO_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/financeiro/boleto/public/retorno/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_RETORNO_CONSULTAR_REQUEST);
        $('#dashAtendimentoPadraoRedirecionarBtn').prop('href', APP_HOST + '/financeiroBoleto/controleBoleto');
    }
    await sleep(100);
}

/**
 * FUNCTION
 * Inicializa os recursos e actions do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
async function setDashFinanceiroBoletoDependencias() {
    //CONFIG
    await setDashFinanceiroBoletoConfigScriptPublico();
    //TABELA DE BOLETOS
    await setDashFinanceiroEstatisticaSemestralRemessa();
    await setDashCardServicoTecnicoListaServico();
    await setDashFinanceiroEstatisticaSemestralBoleto();
}

/**
 * FUNCTION
 * configuração de eventos dos SCRIPTS public utilizado pelo DASHBOARD 
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function setDashFinanceiroBoletoConfigScriptPublico() {
    //TODO HERE
}

////////////////////////////////////////////////////////////////////////////////
//                             - START SCRIPT -                               //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

setInitDashFinanceiroBoletoScript();