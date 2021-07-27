/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */

/**
 * REQUEST
 * Retorna lista de permissões cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getPermissaoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getPermissaoCadastro'
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
 * Retorna lista para construção de estatistica de usuarios ativos e inativos 
 * dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getEstatisticaDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaUsuarioDepartamento'
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
            url: APP_HOST + '/departamento/getRegistroAJAX',
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
 * REQUEST
 * Obtém lista de registros cadastrado no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaControleAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#pesquisa').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getListaControleNovo',
                pesquisa: pesquisa,
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
 * Obtém registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getRegistroAJAX(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                id: id
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
 * Efetua submit de formulario de atualização de permissao
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setSubmitEditor() {
    var frm = $('#cardEditorForm').serializeArray().concat({name: 'operacao', value: 'setEditarRegistro'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/setRegistroAJAX',
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
 * REQUEST
 * Obtém lista de permissões do departamento selecionado
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaPermissaoPadraoDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getPermissaoDepartamento',
                id: $('#cardEditorID').val()
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
 * Obtém lista de usuarios do departamento
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getUsuarioDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getUsuarioDepartamento',
                id: $('#cardEditorID').val()
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
 * Adiciona permissao ao usuario selecionado
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setAdicionarPermissaoAJAX(idPermissao) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/setRegistroAJAX',
            data: {
                operacao: 'setAdicionarPermissaoDepartamento',
                departamentoID: $('#cardEditorID').val(),
                permissaoID: idPermissao
            },
            type: 'post'
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
 * REQUEST
 * Remove permissao do departamento selecionado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setRemoverPermissaoAJAX(idPermissao) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/setRegistroAJAX',
            data: {
                operacao: 'setRemoverPermissaoDepartamento',
                departamentoID: $('#cardEditorID').val(),
                permissaoID: idPermissao
            },
            type: 'post'
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