/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pelas operações de requisição no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */

/**
 * REQUEST
 * Retorna lista empresas cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getEmpresaAJAX() {
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
 * Retorna lista de prateleiras com mais produtos atribuidos.
 * 
 * @author    Manoel Louro
 * @date      14/07/2021
 */
function getTopPrateleiraListaProduto(numeroMaximoRegistro = 10) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getTopPrateleiraListaProduto',
                numeroMaximoRegistro: numeroMaximoRegistro
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
        return 0;
    });
}

/**
 * REQUEST
 * Retorna quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getQuantidadeTotalRegistroAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroPrateleira'
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
        return 0;
    });
}

/**
 * REQUEST
 * Retorna lista registros cadastradoss dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getListaControlePrateleiraAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#cardListaPrateleiraPesquisa').val();
    var empresa = $('#cardListaPrateleiraPesquisaEmpresa').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControlePrateleira',
                pesquisa: pesquisa,
                empresa: empresa,
                paginaSelecionada: paginaSelecionada,
                registroPorPagina: registroPorPagina
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

////////////////////////////////////////////////////////////////////////////////
//                               - CARD EDITOR -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Obtem registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getRegistroAJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getRegistroPrateleira',
                registroID: registroID
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
 * Obtem lista de PRODUTOS disponiveis nessa prateleira.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getCardEditorListaProdutoJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControleProdutoPrateleira',
                registroID: $('#cardEditorID').val(),
                paginaSelecionada: paginaSelecionada,
                registroPorPagina: registroPorPagina
            },
            type: 'POST',
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (resultado) {
        return resultado;
    }).catch(function () {
        return [];
    });
}

/**
 * REQUEST
 * Efetua submit de formulario editor de registro.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function setCardEditorSubmitAJAX() {
    var frm = $('#cardEditorForm').serializeArray().concat({name: 'operacao', value: 'setEditarRegistroPrateleira'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/setRegistroAJAX',
            data: frm,
            type: 'POST',
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (resultado) {
        return resultado;
    }).catch(function () {
        return 1;
    });
}