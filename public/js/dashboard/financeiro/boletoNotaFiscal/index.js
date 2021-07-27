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
        $('#dashFinanceiroBoletoDIV').load(APP_HOST + '/public/js/dashboard/financeiro/boletoNotaFiscal/html.html');
        await $.getScript(APP_HOST + '/public/js/dashboard/financeiro/boletoNotaFiscal/function.js');
        await $.getScript(APP_HOST + '/public/js/dashboard/financeiro/boletoNotaFiscal/request.js');
        $('#dashFinanceiroBoletoCardBoletoTabela').html('<div style="padding-top: 45px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashFinanceiroBoletoCardTabelaBoleto').html('<div style="margin-top: -30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashFinanceiroBoletoCardTabelaNfs').html('<div style="margin-top: -30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashFinanceiroBoletoCardTabelaBoleto').html('<div style="margin-top: -30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashFinanceiroBoletoCardNfsTabela').html('<div style="padding-top: 45px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
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
        await sleep(100);
        //SCRIPT RPS
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/rps/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_RPS_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/rps/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_RPS_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/rps/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_RPS_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/rps/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_RPS_CONSULTAR_REQUEST);
        //SCRIPT LOTE
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/lote/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_LOTE_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/lote/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_LOTE_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/lote/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_LOTE_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/financeiro/notaFiscalServico/public/lote/consultar/' + SCRIPT_PUBLIC_FINANCEIRO_NFSE_LOTE_CONSULTAR_REQUEST);
        await sleep(100);
        $('#dashFinanceiroBoletoCardTabelaBoletoRedirecionarBtn').prop('href', APP_HOST + '/financeiroBoleto/controleBoleto');
        $('#dashFinanceiroBoletoCardTabelaNfsRedirecionarBtn').prop('href', APP_HOST + '/FinanceiroNotaFiscalServico/controleNotaFiscal');
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
    await setDashFinanceiroBoletoEstatisticaSemestralBoleto();
    await setDashFinanceiroBoletoListaBoleto();
    await setDashFinanceiroBoletoListaNfs();
    await setDashFinanceiroBoletoEstatisticaSemestralNfs();
}

/**
 * FUNCTION
 * configuração de eventos dos SCRIPTS public utilizado pelo DASHBOARD 
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function setDashFinanceiroBoletoConfigScriptPublico() {
    //ACTION DE NFSE
    controllerCardFinanceiroNfseRpsConsultar.setCardAtualizar = async function () {
        await setDashFinanceiroBoletoListaNfs();
    };
}

////////////////////////////////////////////////////////////////////////////////
//                             - START SCRIPT -                               //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

setInitDashFinanceiroBoletoScript();