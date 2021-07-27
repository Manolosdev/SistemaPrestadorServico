/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */

/**
 * REQUEST
 * Retorna registro solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
function getCardClienteEditorRegistroAJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cliente/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                registroID: registroID
            },
            type: 'POST',
            dataType: 'json',
            cache: false
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

/**
 * REQUEST
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
function setCardClienteEditorSubmitAJAX() {
    var form = $('#cardClienteEditorForm').serializeArray().concat({name: 'operacao', value: 'setEditarRegistro'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cliente/setRegistroAJAX',
            data: form,
            type: 'POST',
            dataType: 'json',
            cache: false
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return 1;
    });
}
