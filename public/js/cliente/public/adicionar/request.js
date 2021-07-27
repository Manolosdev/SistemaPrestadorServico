/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */

/**
 * REQUEST
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */
function setCardClienteAdicionarSubmitAJAX() {
    var form = $('#cardClienteAdicionarForm').serializeArray().concat({name: 'operacao', value: 'setRegistro'});
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
