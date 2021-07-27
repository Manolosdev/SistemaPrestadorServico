/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

/**
 * REQUEST
 * Retorna lista empresas cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      14/07/2021
 */
function getCardPrateleiraAdicionarEmpresaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/empresa/getRegistroAJAX',
            data: {
                operacao: 'getEmpresaVisivel'
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

/**
 * REQUEST
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      14/07/2021
 */
function setCardPrateleiraAdicionarSubmitAJAX() {
    var form = $('#cardPrateleiraAdicionarForm').serializeArray().concat({name: 'operacao', value: 'setCadastrarRegistroPrateleira'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/setRegistroAJAX',
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
