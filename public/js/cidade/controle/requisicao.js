/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */

/**
 * REQUISIÇÃO AJAX
 * Obtém quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */
function getTotalRegistroAJAX(situacao) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cidade/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistro',
                situacao: situacao
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
 * REQUEST
 * Obtém lista de cidades por UF.
 * 
 * @author    Manoel Louro
 * @date      14/06/2021
 */
function getEstatisticaPorCidadeAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cliente/getRegistroAJAX',
            data: {
                operacao: 'getClientesPorCidade'
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
 * Obtém lista de empresas cadastradas.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */
function getEmpresaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/empresa/getRegistroAJAX',
            data: {
                operacao: 'getEmpresaGeral'
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
 * @date      27/01/2021
 */
function getListaControleAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#pesquisa').val();
    var empresa = $('#pesquisaEmpresa').val();
    var situacao = $('#pesquisaSituacao').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cidade/getRegistroAJAX',
            data: {
                operacao: 'getListaControle',
                pesquisa: pesquisa,
                empresa: empresa,
                situacao: situacao,
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
 * Obtem registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      28/01/2021
 */
function getRegistroAJAX(idRegistro) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cidade/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: idRegistro
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