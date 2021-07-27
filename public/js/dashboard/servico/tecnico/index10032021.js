/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização dos recursos do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */

/**
 * FUNCTION
 * Inicializa o SCRIPT de dashboard.
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */
async function setInitDashServicoTecnicoScript() {
    await setDashServicoTecnicoHTML();
    await setDashServicoTecnicoDependencias();
}

/**
 * FUNCTION
 * Inicializa os elementos necessários pra a execução do SCRIPT de dashboard.
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */
async function setDashServicoTecnicoHTML() {
    if (!document.querySelector('#dashServicoTecnicoDIV')) {
        $('.container-fluid').append('<div id="dashServicoTecnicoDIV" style="width: 100%"></div>');
        $('#dashServicoTecnicoDIV').load(APP_HOST + '/public/js/dashboard/servico/tecnico/html.html');
        $('#dashServicoTecnicoTabelaServico').html('<div style="padding-top: 125px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        await $.getScript(APP_HOST + '/public/js/dashboard/servico/tecnico/function.js');
        await $.getScript(APP_HOST + '/public/js/dashboard/servico/tecnico/request.js');
        $('#dashServicoTecnicoTabelaServico').html('<div style="padding-top: 90px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        $('#dashServicoTecnicoTabelaSemestral').html('<div style="padding-top: 40px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
        //SCRIPT CABEAMENTO ADICIONAL
        await $.getScript(APP_HOST + '/public/js/servico/public/cabeamentoAdicional/consultar/' + SCRIPT_PUBLIC_SERVICO_CABEAMENTO_ADICIONAL_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/servico/public/cabeamentoAdicional/consultar/' + SCRIPT_PUBLIC_SERVICO_CABEAMENTO_ADICIONAL_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/servico/public/cabeamentoAdicional/consultar/' + SCRIPT_PUBLIC_SERVICO_CABEAMENTO_ADICIONAL_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/servico/public/cabeamentoAdicional/consultar/' + SCRIPT_PUBLIC_SERVICO_CABEAMENTO_ADICIONAL_CONSULTAR_REQUEST);
        await sleep(100);
        //SCRIPT TROCA PONTO
        await $.getScript(APP_HOST + '/public/js/servico/public/trocaPonto/consultar/' + SCRIPT_PUBLIC_SERVICO_TROCA_PONTO_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/servico/public/trocaPonto/consultar/' + SCRIPT_PUBLIC_SERVICO_TROCA_PONTO_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/servico/public/trocaPonto/consultar/' + SCRIPT_PUBLIC_SERVICO_TROCA_PONTO_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/servico/public/trocaPonto/consultar/' + SCRIPT_PUBLIC_SERVICO_TROCA_PONTO_CONSULTAR_REQUEST);
    }
    await sleep(100);
}

/**
 * FUNCTION
 * Inicializa os recursos e actions do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */
async function setDashServicoTecnicoDependencias() {
    //CONFIG
    setDashServicoTecnicoConfigScriptPublico();
    //ELEMENTS
    await setDashCardServicoTecnicoListaServico();
    await setDashCardServicoTecnicoQuantidade();
}

/**
 * FUNCTION
 * configuração de eventos dos SCRIPTS public utilizado pelo DASHBOARD 
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */
function setDashServicoTecnicoConfigScriptPublico() {
    //TROCA PONTO CONSULTAR
    controllerCardServicoTrocaPontoConsultar.setCardAtualizar = async function () {
        await setDashCardServicoTecnicoListaServico();
        await setDashCardServicoTecnicoQuantidade();
    };
    //TROCA CABEAMENTO ADICIONAL
    controllerCardServicoCabeamentoAdicionalConsultar.setCardAtualizar = async function () {
        await setDashCardServicoTecnicoListaServico();
        await setDashCardServicoTecnicoQuantidade();
    };
}

////////////////////////////////////////////////////////////////////////////////
//                             - START SCRIPT -                               //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

setInitDashServicoTecnicoScript();