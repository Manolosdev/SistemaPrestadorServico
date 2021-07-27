/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @data      01/07/2020
 */

/**
 * REQUEST
 * Retorna registro solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @data      01/07/2020
 */
function getRegistroAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: $('#usuarioID').val()
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