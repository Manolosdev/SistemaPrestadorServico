/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor
 * 
 * @author    Igor Maximo
 * @data      16/12/2019
 */




/**
 * FUNCTION
 * Dispara a notificação via AJAX para Controller
 * 
 * @author    Igor Maximo
 * @data      18/12/2019
 */ 
function setNotificacaoMassivaAJAX(app, titulo, msg) {
    //AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/notificacaoPush/setCadastrarDispararNotificacaoMassiva',
            dataType: 'json',
            type: 'POST',
            data: {
                app: app,
                titulo: titulo,
                msg: msg
            }
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return false;
    });
}