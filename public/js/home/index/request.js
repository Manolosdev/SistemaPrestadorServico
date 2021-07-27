/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */

/**
 * REQUEST
 * Obtém lista de registros de dashboard configurados pelo usuario.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */
function getUsuarioTemplateAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuarioConfiguracao/getRegistroAJAX',
            data: {
                operacao: 'getUsuarioDashboardHome'
            },
            type: 'post',
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return [];
    });
}