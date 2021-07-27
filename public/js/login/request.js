/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      23/06/2021
 */

/**
 * REQUISIÇÃO AJAX
 * Efetua submit de formulario.
 * 
 * @author    Manoel Louro
 * @data      23/06/2021
 */
function setCardFormularioSubmitAJAX(elementFrm) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: elementFrm.attr('action'),
            data: elementFrm.serialize(),
            type: elementFrm.attr('method'),
            dataType: 'json'
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