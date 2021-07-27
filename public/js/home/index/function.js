/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */

/**
 * FUNCTION
 * Gera scripts de dashboard do usuario.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */
async function getTemplateUsuario() {
    var listaTemplate = [];
    const template = await getUsuarioTemplateAJAX();
    //TEMPLATE 1
    if (template[0] !== null) {
        await $.getScript(APP_HOST + '/public/js/dashboard/' + template[0]);
        listaTemplate.push(template[0]);
    } else {
        $('.container-fluid').append('<div class="row"><div class="col-12"><div class="card border-default"><div class="card-body" style="padding: 15px"><p class="text-center font-13 mb-0">Item de Dashboard vazio, configure o seu dashboard <a class="text-primary" onclick="setCardUsuarioDashboard()" style="cursor: pointer">aqui</a>.</p></div></div></div></div>');
        return;
    }
    //TEMPLATE 2
    if (template[1] !== null && !listaTemplate.includes(template[1])) {
        await $.getScript(APP_HOST + '/public/js/dashboard/' + template[1]);
        listaTemplate.push(template[1]);
    } else {
        $('.container-fluid').append('<div class="row"><div class="col-12"><div class="card border-default"><div class="card-body" style="padding: 15px"><p class="text-center font-13 mb-0">Item de Dashboard vazio, configure o seu dashboard <a class="text-primary" onclick="setCardUsuarioDashboard()" style="cursor: pointer">aqui</a>.</p></div></div></div></div>');
        return;
    }
    //TEMPLATE 3
    if (template[2] !== null && !listaTemplate.includes(template[2])) {
        await $.getScript(APP_HOST + '/public/js/dashboard/' + template[2]);
    } else {
        $('.container-fluid').append('<div class="row"><div class="col-12"><div class="card border-default"><div class="card-body" style="padding: 15px"><p class="text-center font-13 mb-0">Item de Dashboard vazio, configure o seu dashboard <a class="text-primary" onclick="setCardUsuarioDashboard()" style="cursor: pointer">aqui</a>.</p></div></div></div></div>');
        return;
    }
}

/**
 * FUNCTION
 * Abre card de perfil de usuario.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */
async function setCardUsuarioDashboard(){
    await setCardUsuarioPerfilInit();
    $('#tabUsuarioPerfilDashboard').click();
}

