/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */

// SUBMIT
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Efetua submit do card "INFORMAÇÕES PÚBLICAS".
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function setSubmitCardUmAJAX() {
    var form = $('#formCard1')[0];
    var data = new FormData(form);
    data.append('operacao', 'setEditorUsuarioInformacaoPublico');
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/setRegistroAJAX',
            data: data,
            type: 'POST',
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
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

/**
 * REQUEST
 * Efetua submot do card "CREDENCIAIS DO USUARIO".
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setSubmitCardSeteAJAX() {
    var frm = $('#formCard7');
    var serialize = frm.serializeArray();
    serialize.push({name: 'operacao', value: 'setEditorUsuarioCredencial'});
    serialize.push({name: 'idUsuario', value: $('#usuarioID').val()});
    serialize.push({name: 'idSuperior', value: $('#superiorID').val()});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/setRegistroAJAX',
            data: serialize,
            type: 'POST',
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
 * Retorna lista de DEPARTAMENTOS cadastrados no sistema.
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
 * REQUEST
 * Retorna lista de usuarios cadastrados no sistema de acordo com parametro de 
 * filtro informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaUsuarioAJAX(pesquisa) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'getListaControle',
                pesquisa: pesquisa,
                situacao: 1
            },
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

// SUBORDINADOS
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna lista de SUBORDINADOS do usuario informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaSubordinadoUsuarioAJAX() {
    var idUsuario = $('#usuarioID').val();
    //REQUEST
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'getListaSubordinadoUsuario',
                idUsuario: idUsuario
            },
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

// PERMISSOES
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna lista de PERMISSÕES do usuario.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function getListaPermissaoUsuarioAJAX() {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'getListaPermissaoUsuario',
                idUsuario: idUsuario
            },
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
 * Retorna lista de PERMISSÕES disponiveis no sistema.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function getListaPermissaoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/getRegistroAJAX',
            data: {
                operacao: 'getListaPermissaoDisponivel'
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
 * Adiciona permissao ao usuario selecionado de acordo com parametros informados.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function setAdicionarPermissaoAJAX(idPermissao) {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/setRegistroAJAX',
            data: {
                operacao: 'setAdicionarPermissaoUsuario',
                idUsuario: idUsuario,
                idPermissao: idPermissao
            },
            type: 'post'
        }).done(function (resultado) {
            if (parseInt(resultado) === 0) {
                resolve();
            } else {
                reject();
            }
        }).fail(function () {
            reject();
        });
    }).then(function () {
        return true;
    }).catch(function () {
        return false;
    });
}

/**
 * REQUEST
 * Remove permissao do usuario informado.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function setRemoverPermissaoAJAX(idPermissao) {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/permissao/setRegistroAJAX',
            data: {
                operacao: 'setRemoverPermissaoUsuario',
                idUsuario: idUsuario,
                idPermissao: idPermissao
            },
            type: 'post'
        }).done(function (resultado) {
            if (parseInt(resultado) === 0) {
                resolve();
            } else {
                reject();
            }
        }).fail(function () {
            reject();
        });
    }).then(function () {
        return true;
    }).catch(function () {
        return false;
    });
}

// DASHBOARD
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna lista de CONFIGURAÇÃO DE DASHBOARD do usuario informado.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function getListaDashboardUsuarioConfiguracaoAJAX() {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuarioConfiguracao/getRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'getConfiguracaoUsuarioDashboard',
                idUsuario: idUsuario
            },
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
 * Retorna lista de DASHBOARD do usuario informado.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function getListaDashboardUsuarioAJAX() {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'getListaDashboardUsuario',
                idUsuario: idUsuario
            },
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
 * Retorna lista de DASHBOARDS disponiveis no sistema.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function getListaDashboardAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getListaDashboardDisponivel'
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
 * Adiciona DASHBOARD ao usuario selecionado de acordo com parametros informados.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function setAdicionarDashboardAJAX(idDashboard) {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/setRegistroAJAX',
            data: {
                operacao: 'setAdicionarDashboardUsuario',
                idUsuario: idUsuario,
                idDashboard: idDashboard
            },
            type: 'post'
        }).done(function (resultado) {
            if (parseInt(resultado) === 0) {
                resolve();
            } else {
                reject();
            }
        }).fail(function () {
            reject();
        });
    }).then(function () {
        return true;
    }).catch(function () {
        return false;
    });
}

/**
 * REQUEST
 * Remove permissao do usuario informado.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function setRemoverDashboardAJAX(idDashboard) {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/setRegistroAJAX',
            data: {
                operacao: 'setRemoverDashboardUsuario',
                idUsuario: idUsuario,
                idDashboard: idDashboard
            },
            type: 'post'
        }).done(function (resultado) {
            if (parseInt(resultado) === 0) {
                resolve();
            } else {
                reject();
            }
        }).fail(function () {
            reject();
        });
    }).then(function () {
        return true;
    }).catch(function () {
        return false;
    });
}

/**
 * REQUEST
 * Adiciona DASHBOARD as configurações do usuario selecionado.
 * 
 * @author    Manoel Louro
 * @data      28/06/2021
 */
function setAdicionarDashboardUsuarioConfigAJAX(idDashboard, idConfiguracao) {
    var idUsuario = $('#usuarioID').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuarioConfiguracao/setRegistroAJAX',
            data: {
                operacao: 'setUsuarioConfiguracaoDashboard',
                idUsuario: idUsuario,
                idConfiguracao: idConfiguracao,
                idDashboard: idDashboard
            },
            type: 'post',
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