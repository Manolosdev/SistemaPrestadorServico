/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */

/**
 * REQUISIÇÃO AJAX
 * Obtém quantidade de registros por departamento cadastrado.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getTotalRegistroPorDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaRegistroPorDepartamento'
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
 * REQUISIÇÃO AJAX
 * Obtém quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getTotalRegistroAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistro',
                departamentoID: null
            },
            type: 'post'
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
 * REQUISIÇÃO AJAX
 * Obtém lista de DEPARTAMENTOS cadastrados.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getListaDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getListaControleRegistro'
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
 * REQUISIÇÃO AJAX
 * Obtém lista de registros cadastrado no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getListaControleAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#cardListapesquisa').val();
    var departamento = $('#cardListaPesquisaDepartamento').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getListaRegistroControle',
                pesquisa: pesquisa,
                departamento: departamento,
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

/**
 * REQUEST
 * Efetua submit de formulario editor de registro.
 * 
 * @author    Manoel Louro
 * @date      28/01/2021
 */
function setSubmitEditorAJAX() {
    var frm = $('#cardEditorForm').serializeArray().concat({name: 'operacao', value: 'setEditarRegistro'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cidade/setRegistroAJAX',
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

////////////////////////////////////////////////////////////////////////////////
//                               - CARD EDITOR -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Obtem registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getRegistroAJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: registroID
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
 * Obtem lista de usuarios que possuem esse DASHBOARD.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getCardEditorListaUsuarioJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getListaUsuarioRegistro',
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
 * @date      15/06/2021
 */
function setCardEditorSubmitAJAX() {
    var frm = $('#cardEditorForm').serializeArray().concat({name: 'operacao', value: 'setEditarRegistro'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/setRegistroAJAX',
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