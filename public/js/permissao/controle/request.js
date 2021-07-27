/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */

/**
 * FUNCTION
 * Retorna lista de cargos cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
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
 * FUNCTION
 * Retorna lista para construção de estatistica de usuarios ativos e inativos 
 * dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getEstatisticaDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaPermissaoDepartamento'
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
 * Retorna quantidade de registros cadastrados no sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getTotalRegistroAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistro'
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
 * FUNCTION
 * Obtém lista de registros cadastrados no sistema aplicando filtros.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaRegistroCadastradoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getListaControleRegistro',
                pesquisa: $('#pesquisa').val()
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
 * FUNCTION
 * Obtém informações do registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getRegistroAJAX(idRegistro) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idPermissao: idRegistro
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
        return 1;
    });
}

/**
 * FUNCTION
 * Efetua submit de formulario de atualização de permissao
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setSubmitEditor() {
    var frm = $('#cardEditorForm').serializeArray().concat({name: 'operacao', value: 'setEditarRegistro'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/setRegistroAJAX',
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

/**
 * FUNCTION
 * Obtém lista de cargos que possuem essa permissão.
 * 
 * @author    Manoel Louro
 * @date      23/06/2020
 */
function getPermissaoDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getDepartamentoPermissao',
                idPermissao: $('#cardEditorID').val()
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
 * FUNCTION
 * Obtém lista de usuarios com permissao selecionada.
 * 
 * @author    Manoel Louro
 * @date      26/06/2020
 */
function getPermissaoUsuarioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getPermissaoUsuario',
                idPermissao: $('#cardEditorID').val()
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
        return 1;
    });
}