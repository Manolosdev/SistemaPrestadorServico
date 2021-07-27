/**
 * JAVASCRIPT
 * 
 * Inicialização de processos e eventos.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */

$(document).ready(async function () {
    getTemplateUsuario();
    //PRELOAD ------------------------------------------------------------------
    $(".loader-wrapper").fadeOut();
    //CHECK NOTIFICAÇÕES
    if (document.referrer == APP_HOST + '/') {
        $('#interfase_notificacao_count').addClass('animated zoomIn');
    }
});


