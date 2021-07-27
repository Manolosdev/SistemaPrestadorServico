/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */

/**
 * REQUEST
 * Retorna lista empresas cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */
function getCardProdutoAdicionarEmpresaAJAX() {
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
 * Retorna lista prateleiras cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */
function getCardProdutoAdicionarPrateleiraAJAX(empresaID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaPrateleira',
                empresaID: empresaID
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
 * @date      16/07/2021
 */
function setCardProdutoAdicionarSubmitAJAX() {
    var form = $('#cardProdutoAdicionarForm').serializeArray().concat({name: 'operacao', value: 'setCadastrarRegistroProduto'});
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
