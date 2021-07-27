/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */

/**
 * REQUEST
 * Obtém estatistica de notificações efetuadas pelo usuario.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getEstatisticaSemestralAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/notificacao/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaUsuario',
                tipo: 2
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
 * Obtém estatistica de notificações efetuadas pelo usuario.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getEstatisticaMensalAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/notificacao/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaUsuario',
                tipo: 1
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
 * Obtém lista de registro de notificações RECEBIDOS pelo usuario dentro do 
 * sistema.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getListaRegistroRecebidoAJAX(pagination = 1) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/notificacao/getRegistroAJAX',
            data: {
                operacao: 'getListaRegistroRecebidoUsuario',
                pagination: pagination
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
 * Obtém lista de registro de notificações ENVIADOS pelo usuario dentro do 
 * sistema.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getListaRegistroEnviadoAJAX(pagination = 1) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/notificacao/getRegistroAJAX',
            data: {
                operacao: 'getListaRegistroEnviadoUsuario',
                pagination: pagination
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
 * Retorna informaçõe do registro solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getRegistroAJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/notificacao/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                id: registroID
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
 * Retorna lista de usuários cadastrados e ativos dentro do sistema
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getListaUsuarioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getListaUsuarioPorDepartamento',
                situacaoRegistro: 1
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
 * Efetua requisição ajax de formulario de cadastro de registro.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
function setRegistroAJAX(usuarios) {
    var frm = $('#formAdicionar');
    var serialize = frm.serializeArray().concat({name: 'usuarios', value: usuarios}).concat({name: 'operacao', value: 'setRegistro'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: frm.attr('action'),
            data: serialize,
            type: frm.attr('method'),
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