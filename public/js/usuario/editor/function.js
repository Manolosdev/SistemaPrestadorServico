/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */

/**
 * FUNCTION
 * Seleciona card de acordo com parametro informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setSelecionarCard(cardNumero) {
    $('#card1').fadeOut(100);
    $('#menuLabel1').prop('class', 'text-muted');
    $('#card2').fadeOut(100);
    $('#menuLabel2').prop('class', 'text-muted');
    $('#card3').fadeOut(100);
    $('#menuLabel3').prop('class', 'text-muted');
    $('#card4').fadeOut(100);
    $('#menuLabel4').prop('class', 'text-muted');
    $('#card5').fadeOut(100);
    $('#menuLabel5').prop('class', 'text-muted');
    $('#card6').fadeOut(100);
    $('#menuLabel6').prop('class', 'text-muted');
    $('#card7').fadeOut(100);
    $('#menuLabel7').prop('class', 'text-muted');
    $('#card8').fadeOut(100);
    $('#menuLabel8').prop('class', 'text-muted');
    setTimeout(function () {
        switch (cardNumero) {
            case 1:
                $('#card1').fadeIn(200);
                $('#menuLabel1').prop('class', 'font-bold');
                return true;
            case 2:
                $('#card2').fadeIn(200);
                $('#menuLabel2').prop('class', 'font-bold');
                break;
            case 3:
                $('#card3').fadeIn(200);
                $('#menuLabel3').prop('class', 'font-bold');
                break;
            case 4:
                $('#card4').fadeIn(200);
                $('#menuLabel4').prop('class', 'font-bold');
                break;
            case 5:
                $('#card5').fadeIn(200);
                $('#menuLabel5').prop('class', 'font-bold');
                break;
            case 6:
                $('#card6').fadeIn(200);
                $('#menuLabel6').prop('class', 'font-bold');
                break;
            case 7:
                $('#card7').fadeIn(200);
                $('#menuLabel7').prop('class', 'font-bold');
                break;
            case 8:
                $('#card8').fadeIn(200);
                $('#menuLabel8').prop('class', 'font-bold');
                break;
            default:

                break;
        }
    }, 100);
}

/**
 * FUNCTION
 * Constroi dados do usuario de acordo ID informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getUsuarioEditorInfo() {
    var id = $('#usuarioID').val();
    const retorno = await getRegistroUsuarioInfoAJAX(id);
    if (retorno['id']) {
        //CARD INFO
        $('#infoUsuarioPerfil').prop('src', 'data:image/png;base64,' + retorno['perfil']);
        $('#infoUsuarioNomeSistema').html(retorno['nomeSistema']);
        if (retorno['id'] < 10) {
            $('#infoUsuarioSubordinados').html('#00' + retorno['id']);
        } else if (retorno['id'] < 100) {
            $('#infoUsuarioSubordinados').html('#0' + retorno['id']);
        } else {
            $('#infoUsuarioSubordinados').html('#' + retorno['id']);
        }
        if (parseInt(retorno['ativo']) === 1) {
            $('#infoUsuarioAtivo').prop('class', 'text-primary');
            $('#infoUsuarioAtivo').html('<i class="mdi mdi-hexagon-multiple"></i> Conta ativa');
        } else {
            $('#infoUsuarioAtivo').prop('class', 'text-muted');
            $('#infoUsuarioAtivo').html('<i class="mdi mdi-hexagon-multiple"></i> Conta inativa');
        }
        $('#infoUsuarioNomeCompleto').html(retorno['nomeCompleto']);
        $('#infoUsuarioEmpresa').html(retorno['entidadeEmpresa']['nomeFantasia']);
        $('#infoUsuarioEmail').html(retorno['email']);
        $('#infoUsuarioCelular').html(retorno['celular']);
        $('#usuarioRequisicao').html(retorno['quantidadeRequisicao']);
        animateContador($('#usuarioRequisicao'));
        $('#usuarioNotificacao').html(retorno['quantidadeNotificacao']);
        animateContador($('#usuarioNotificacao'));
        $('#usuarioOrcamento').html(retorno['quantidadeVenda']);
        animateContador($('#usuarioOrcamento'));
        //PUBLIC
        $('#usuarioEmpresa').html('<option value="' + retorno['entidadeEmpresa']['id'] + '">' + retorno['entidadeEmpresa']['nomeFantasia'] + '</option>');
        $('#nomeSistema').val(retorno['nomeSistema']);
        $('#nomeCompleto').val(retorno['nomeCompleto']);
        $('#usuarioAtivo').val(retorno['ativo']);
        $('#email').val(retorno['email']);
        $('#celular').val(retorno['celular']);
        $('#celular').val(retorno['celular']);
        $('#card1').find('.divLoadBlock').fadeOut(50);
        //CREDENCIAIS
        await getUsuarioEditorCrendentecias(retorno);
    }
}

/**
 * FUNCTION
 * Constrou dados do usuario relacionados as suas CREDENCIAIS dentro do sitema
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getUsuarioEditorCrendentecias(retorno = null) {
    var id = $('#usuarioID').val();
    if (!retorno) {
        retorno = await getRegistroUsuarioInfoAJAX(id);
    }
    if (retorno['id']) {
        $('#novaSenha').val('');
        $('#confirmarSenha').val('');
        $('#emailAuxiliar').val('');

        $('#login').val(retorno['login']);
        $('#departamento').val(retorno['fkDepartamento']);
        $('#superiorID').val(retorno['superior']['id']);
        $('#superiorImg').prop('src', 'data:image/png;base64,' + retorno['superior']['imagemPerfil']);
        $('#superiorImg').unbind('click');
        $('#superiorImg').on('click', async function () {
            await getInfoUsuario(retorno['superior']['id']);
        });
        $('#superiorNome').html(retorno['superior']['usuarioNome']);
        $('#superiorDepartamento').html(retorno['superior']['departamentoNome']);
    }
    $('#card7').find('.divLoadBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi lista de depencias do usuario: permissoes, subordinados, dashboards
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getUsuarioListaDependencias() {
    await setListaSubordinadosUsuario();
    await setListaPermissaoUsuario();
    await setListaDashboardUsuario();
    await setListaDashboardUsuarioConfiguracao();
}

// SUBORDINDADOS/USUARIOS
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Gera lista de subordinados atribuidos ao usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setListaSubordinadosUsuario() {
    $('#listaSubordinadosSize').html('0 registro(s) encontrado(s)');
    $('#listaSubordinados').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    //REQUEST
    const registro = await getListaSubordinadoUsuarioAJAX();
    if (registro.length) {
        $('#listaSubordinados').html('');
        var html;
        var categoriaAnterior = '';
        for (i = 0; i < registro.length; i++) {
            html = '';
            if (categoriaAnterior !== registro[i]['departamentoNome']) {
                categoriaAnterior = registro[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                html += '    <p class="mb-0 font-13">' + registro[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="d-flex div-registro" onclick="getInfoUsuario(' + registro[i]['id'] + ')" style="animation: slide-up 1s ease">';
            html += '   <div class="d-flex" style="width: 50px">';
            html += '       <img src="data:image/png;base64,' + registro[i]['usuarioPerfil'] + '" class="rounded-circle" width="45" height="45">';
            html += '   </div>';
            html += '   <div style="padding-top: 7px;width: 140px;padding-left: 5px">';
            html += '       <h5 class="font-13 color-default" style="margin-bottom: 0px">' + registro[i]['usuarioNome'] + '</h5>';
            html += '       <span class="text-muted font-13">' + registro[i]['departamentoNome'] + '</span>';
            html += '   </div>';
            html += '   <div class="ml-auto d-flex">';
            html += '       <div style="padding-top: 4px;width: 60px">';
            html += '           <small class="text-muted">Situação</small>';
            if (parseInt(registro[i]['ativo']) === 1) {
                html += '       <p class="text-info font-13" style="margin-bottom: 0px"><i class="mdi mdi-checkbox-blank-circle font-12"></i> ativo</p>';
            } else {
                html += '       <p class="text-secondary font-13" style="margin-bottom: 0px"><i class="mdi mdi-checkbox-blank-circle font-12"></i> inativo</p>';
            }
            html += '       </div>';
            html += '       <div class="d-flex" style="padding-top: 4px">';
            html += '           <div class="d-none d-lg-block" style="margin-left: 20px">';
            html += '               <small class="text-muted">Subordinados</small>';
            html += '               <p class="color-default font-13" style="margin-bottom: 0px;font-size: 13px"><i class="mdi mdi-account-multiple font-14"></i> ' + registro[i]['subordinados'] + '</p>';
            html += '           </div>';
            html += '           <div class="d-none d-lg-block" style="margin-left: 20px">';
            html += '               <small class="text-muted">Permissões</small>';
            html += '               <p class="color-default font-13" style="margin-bottom: 0px;font-size: 13px"><i class="mdi mdi-lock-open font-14"></i> ' + registro[i]['permissoes'] + '</p>';
            html += '           </div>';
            html += '       </div>';
            html += '       <div class="d-none d-sm-block" style="margin-left: 20px;min-width: 80px;padding-top: 4px">';
            html += '           <small class="text-muted">Cadastrado</small>';
            html += '           <p class="color-default font-13" style="margin-bottom: 0px">' + registro[i]['dataCadastro'] + '</p>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#listaSubordinados').append(html);
            $('#listaSubordinadosSize').html((i + 1) + ' registro(s) encontrado(s)');
            await sleep(80);
        }
    } else {
        $('#listaSubordinados').html('<div style="padding: 10px;"><small class="text-muted">Nenhum subordinado atribuído ...</small></div>');
    }
    $('#card2').find('.divLoadBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Gera lista de usuários cadastrados no sistema de acordo com parametro 
 * informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setListaUsuario() {
    if ($('#cardUsuarioPesquisar').val().length < 2) {
        $('#btnCardUsuarioPesquisar').prop('class', 'btn btn-danger');
        $('.input-lista-usuario').addClass('animated shake');
        toastr.error('Obrigatório o mínimo de 2 caracteres na pesquisa', 'Operação Negada',
                {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
        setTimeout(function () {
            $('#btnCardUsuarioPesquisar').prop('class', 'btn btn-info');
            $('.input-lista-usuario').removeClass('animated shake');
        }, 1000);
        $('#cardUsuarioPesquisar').focus();
        return false;
    }
    $('#cardUsuarioTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    //REQUEST
    const registro = await getListaUsuarioAJAX($('#cardUsuarioPesquisar').val());
    if (registro.length) {
        $('#cardUsuarioTabela').html('');
        var html;
        var categoriaAnterior = '';
        for (i = 0; i < registro.length; i++) {
            html = '';
            if (categoriaAnterior !== registro[i]['departamentoNome']) {
                categoriaAnterior = registro[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                html += '    <p class="mb-0 font-13">' + registro[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="d-flex div-registro" onclick="setAdicionarSuperior(this)" style="animation: slide-up 1s ease">';
            html += '   <input hidden class="id" value="' + registro[i]['id'] + '">';
            html += '   <input hidden class="perfil" value="' + registro[i]['usuarioPerfil'] + '">';
            html += '   <input hidden class="nome" value="' + registro[i]['usuarioNome'] + '">';
            html += '   <input hidden class="departamento" value="' + registro[i]['departamentoNome'] + '">';
            html += '   <div class="d-flex" style="width: 50px">';
            html += '       <img src="data:image/png;base64,' + registro[i]['usuarioPerfil'] + '" class="rounded-circle" width="45" height="45">';
            html += '   </div>';
            html += '   <div style="padding-top: 7px;width: 160px;padding-left: 5px">';
            html += '       <h5 class="font-13 color-default" style="margin-bottom: 0px">' + registro[i]['usuarioNome'] + '</h5>';
            html += '       <span class="text-muted font-11">' + registro[i]['empresaNome'] + '</span>';
            html += '   </div>';
            html += '   <div class="ml-auto d-flex">';
            html += '       <div style="padding-top: 4px;width: 60px">';
            html += '           <small class="text-muted">Situação</small>';
            if (parseInt(registro[i]['ativo']) === 1) {
                html += '       <p class="text-success font-13" style="margin-bottom: 0px"><i class="mdi mdi-checkbox-blank-circle font-12"></i> ativo</p>';
            } else {
                html += '       <p class="text-danger font-13" style="margin-bottom: 0px"><i class="mdi mdi-checkbox-blank-circle font-12"></i> inativo</p>';
            }
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#cardUsuarioTabela').append(html);
            await sleep(50);
        }
    } else {
        $('#cardUsuarioTabela').html('<div style="padding: 15px;"><small class="text-muted">Nenhum usuário encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Adiciona superior ao formulário de CRENDENCIAIS.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setAdicionarSuperior(element) {
    $('#superiorID').val($(element).find('.id').val());
    $('#superiorImg').prop('src', 'data:image/png;base64,' + $(element).find('.perfil').val());
    $('#superiorNome').html($(element).find('.nome').val());
    $('#superiorDepartamento').html($(element).find('.departamento').val());
    $('#btnCardUsuarioBack').click();
}

// DASHBOARDS
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Gera lista de dashboard das configurações do usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setListaDashboardUsuarioConfiguracao() {
    //REQUEST
    const retorno = await getListaDashboardUsuarioConfiguracaoAJAX();
    //DASHBAOARD 1
    if (retorno[0] && retorno[0]['id']) {
        $('#imgDashboard1').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + retorno[0]['nomeImagem']);
        $('#labelDashboard1').html(retorno[0]['nome']);
        $('#descricaoDashboard1').html(retorno[0]['descricao']);

        $('#btnDashboard1Add').prop('class', 'btn btn-sm btn-info');
        $('#btnDashboard1Add').unbind('click');
        $('#btnDashboard1Add').on('click', function () {
            setListaDashboardUsuarioConfig(3);
        });
        $('#btnDashboard1Remove').prop('class', 'btn btn-sm btn-secondary');
        $('#btnDashboard1Remove').unbind('click');
        $('#btnDashboard1Remove').on('click', function () {
            setRemoverDashboardSelecionado(3);
        });
    } else {
        $('#imgDashboard1').removeAttr('src').replaceWith($('#imgDashboard1').clone());
        $('#labelDashboard1').html('Vazio ...');
        $('#descricaoDashboard1').html('Nenhum dashboard configurado ...');
        $('#btnDashboard1Add').prop('class', 'btn btn-sm btn-info');
        $('#btnDashboard1Add').unbind('click');
        $('#btnDashboard1Add').on('click', function () {
            setListaDashboardUsuarioConfig(3);
        });
        $('#btnDashboard1Remove').prop('class', 'btn btn-sm btn-secondary');
        $('#btnDashboard1Remove').unbind('click');
    }
    $('#divDashboard1').addClass('animated fadeIn');
    await sleep(100);
    //DASHBAOARD 2
    if (retorno[1] && retorno[1]['id']) {
        $('#imgDashboard2').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + retorno[1]['nomeImagem']);
        $('#labelDashboard2').html(retorno[1]['nome']);
        $('#descricaoDashboard2').html(retorno[1]['descricao']);

        $('#btnDashboard2Add').prop('class', 'btn btn-sm btn-info');
        $('#btnDashboard2Add').unbind('click');
        $('#btnDashboard2Add').on('click', function () {
            setListaDashboardUsuarioConfig(4);
        });
        $('#btnDashboard2Remove').prop('class', 'btn btn-sm btn-secondary');
        $('#btnDashboard2Remove').unbind('click');
        $('#btnDashboard2Remove').on('click', function () {
            setRemoverDashboardSelecionado(4);
        });
    } else {
        $('#imgDashboard2').removeAttr('src').replaceWith($('#imgDashboard2').clone());
        $('#labelDashboard2').html('Vazio ...');
        $('#descricaoDashboard2').html('Nenhum dashboard configurado ...');
        $('#btnDashboard2Add').prop('class', 'btn btn-sm btn-info');
        $('#btnDashboard2Add').unbind('click');
        $('#btnDashboard2Add').on('click', function () {
            setListaDashboardUsuarioConfig(4);
        });
        $('#btnDashboard2Remove').prop('class', 'btn btn-sm btn-secondary');
        $('#btnDashboard2Remove').unbind('click');
    }
    $('#divDashboard2').addClass('animated fadeIn');
    await sleep(100);
    //DASHBAOARD 3
    if (retorno[2] && retorno[2]['id']) {
        $('#imgDashboard3').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + retorno[2]['nomeImagem']);
        $('#labelDashboard3').html(retorno[2]['nome']);
        $('#descricaoDashboard3').html(retorno[2]['descricao']);

        $('#btnDashboard3Add').prop('class', 'btn btn-sm btn-info');
        $('#btnDashboard3Add').unbind('click');
        $('#btnDashboard3Add').on('click', function () {
            setListaDashboardUsuarioConfig(5);
        });
        $('#btnDashboard3Remove').prop('class', 'btn btn-sm btn-secondary');
        $('#btnDashboard3Remove').unbind('click');
        $('#btnDashboard3Remove').on('click', function () {
            setRemoverDashboardSelecionado(5);
        });
    } else {
        $('#imgDashboard3').removeAttr('src').replaceWith($('#imgDashboard3').clone());
        $('#labelDashboard3').html('Vazio ...');
        $('#descricaoDashboard3').html('Nenhum dashboard configurado ...');
        $('#btnDashboard3Add').prop('class', 'btn btn-sm btn-info');
        $('#btnDashboard3Add').unbind('click');
        $('#btnDashboard3Add').on('click', function () {
            setListaDashboardUsuarioConfig(5);
        });
        $('#btnDashboard3Remove').prop('class', 'btn btn-sm btn-secondary');
        $('#btnDashboard3Remove').unbind('click');
    }
    $('#divDashboard3').addClass('animated fadeIn');
    //REMOVE ANIMATION
    setTimeout(function () {
        $('#divDashboard1').removeClass('animated fadeIn');
        $('#divDashboard2').removeClass('animated fadeIn');
        $('#divDashboard3').removeClass('animated fadeIn');
    }, 1000);
    $('#card6').find('.divLoadBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Gera lista de DASHBOARDS atribuidos ao usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setListaDashboardUsuario() {
    $('#listaDashboardsSize').html('0 registro(s) encontrado(s)');
    $('#listaDashboards').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    //REQUEST
    const registro = await getListaDashboardUsuarioAJAX();
    if (registro.length) {
        $('#listaDashboards').html('');
        var html;
        var categoriaAnterior = '';
        for (i = 0; i < registro.length; i++) {
            html = '';
            if (categoriaAnterior !== registro[i]['departamentoNome']) {
                categoriaAnterior = registro[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                html += '    <p class="mb-0 font-13">' + registro[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="div-registro d-flex" style="animation: slide-up 1s ease">';
            html += '   <div>';
            html += '       <small class="text-muted">' + registro[i]['nome'] + '</small>';
            html += '       <p class="mb-0 font-13">' + registro[i]['descricao'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="padding-left: 5px">';
            html += '       <button class="btn btn-sm btn-secondary" type="button" style="margin-top: 10px" onclick="setRemoverDashboard(' + registro[i]['id'] + ')" title="Remover dashboard do usuário"><i class="mdi mdi-delete-forever" style="color: white"></i></button>';
            html += '   </div>';
            html += '</div>';
            $('#listaDashboards').append(html);
            $('#listaDashboardsSize').html((i + 1) + ' registro(s) encontrado(s)');
            await sleep(80);
        }
    } else {
        $('#listaDashboards').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhuma permissão atribuída ...</small></div>');
    }
    $('#card4').find('.divLoadBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Gera lista de permissões disponiveis de acordo com o usuario logado, efetua
 * filtro atraves de input informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getListaDashboard() {
    $('#cardDashboardTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    //REQUEST
    const retorno = await getListaDashboardAJAX();
    if (retorno.length) {
        $('#cardDashboardTabela').html('');
        var html = '';
        var categoriaAnterior = '';
        for (i = 0; i < retorno.length; i++) {
            html = '';
            if (categoriaAnterior !== retorno[i]['departamentoNome']) {
                categoriaAnterior = retorno[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                html += '    <p class="mb-0 font-13">' + retorno[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="div-registro d-flex" style="animation: slide-up 1s ease">';
            html += '   <div>';
            html += '       <small class="text-muted">' + retorno[i]['nome'] + '</small>';
            html += '       <p class="mb-0 font-13">' + retorno[i]['descricao'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="padding-left: 5px">';
            html += '       <button class="btn btn-sm btn-primary" style="margin-top: 10px" onclick="setAdicionarDashboard(' + retorno[i]['id'] + ')" title="Adicionar dashboard ao usuário"><i class="mdi mdi-arrow-down" style="color: white"></i></button>';
            html += '   </div>';
            html += '</div>';
            $('#cardDashboardTabela').append(html);
        }
    } else {
        $('#cardDashboardTabela').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Adiciona DASHBOARD informado por parametro a lista de dashboards do usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setAdicionarDashboard(idDashboard) {
    if (idDashboard > 0) {
        $('#spinnerGeral').fadeIn(50);
        //REQUEST
        const retorno = await setAdicionarDashboardAJAX(idDashboard);
        if (retorno) {
            $('#spinnerGeral').fadeOut(50);
            toastr.success('Dashboard adiciona com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
            setListaDashboardUsuario();
            return true;
        }
    }
    toastr.error('Erro encontrado, não foi possível identificar o dashboard selecionado', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    $('#spinnerGeral').fadeOut(50);
    return true;
}

/**
 * FUNCTION
 * Remove DASHBOARD do usuario informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setRemoverDashboard(idDashboard) {
    if (idDashboard > 0) {
        var functionDelete = async function (id) {
            $('#spinnerGeral').fadeIn(50);
            //REQUEST
            const retorno = await setRemoverDashboardAJAX(idDashboard);
            if (retorno) {
                $('#spinnerGeral').fadeOut(50);
                toastr.success('Dashboard REMOVIDO com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
                setListaDashboardUsuario();
                return true;
            }
            toastr.error('Erro encontrado, não foi possível identificar a DASHBOARD selecionado', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
            $('#spinnerGeral').fadeOut(50);
            return true;
        };
        //ALERT 
        Swal.fire({
            title: 'Você tem certeza',
            text: "Deseja REMOVER o dashboard do usuário?",
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.value) {
                functionDelete(idDashboard);
            }
        });
    }
}

/**
 * FUNCTION
 * Exibe lista de dashboards atribuídos ao usuário para configuração de 
 * dashboard selecionados do usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setListaDashboardUsuarioConfig(slotDashboard) {
    if (slotDashboard > 2 && slotDashboard < 6) {
        //CREATE TABLE
        $('#cardDashboardUsuarioTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
        $('#cardDashboardUsuario').fadeIn(50);
        //REQUEST
        const registro = await getListaDashboardUsuarioAJAX();
        if (registro.length) {
            $('#cardDashboardUsuarioTabela').html('');
            var html;
            var categoriaAnterior = '';
            for (i = 0; i < registro.length; i++) {
                html = '';
                if (categoriaAnterior !== registro[i]['departamentoNome']) {
                    categoriaAnterior = registro[i]['departamentoNome'];
                    html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                    html += '    <p class="mb-0 font-13">' + registro[i]['departamentoNome'] + '</p>';
                    html += '</div>';
                }
                html += '<div class="div-registro d-flex" style="animation: slide-up 1s ease">';
                html += '   <input hidden class="id" value="' + registro[i]['id'] + '">';
                html += '   <input hidden class="nome" value="' + registro[i]['nome'] + '">';
                html += '   <input hidden class="script" value="' + registro[i]['script'] + '">';
                html += '   <input hidden class="nomeImagem" value="' + registro[i]['nomeImagem'] + '">';
                html += '   <input hidden class="descricao" value="' + registro[i]['descricao'] + '">';
                html += '   <input hidden class="geral" value="' + registro[i]['geral'] + '">';
                html += '   <div>';
                html += '       <small class="text-muted">' + registro[i]['nome'] + '</small>';
                html += '       <p class="mb-0 font-13">' + registro[i]['descricao'] + '</p>';
                html += '   </div>';
                html += '   <div class="ml-auto" style="padding-left: 5px">';
                html += '       <button class="btn btn-sm btn-primary" type="button" style="margin-top: 10px" onclick="setAdicionarDashboardUsuarioConfig(' + registro[i]['id'] + ',' + slotDashboard + ')"><i class="mdi mdi-arrow-down" style="color: white"></i></button>';
                html += '   </div>';
                html += '</div>';
                $('#cardDashboardUsuarioTabela').append(html);
                await sleep(80);
            }
        } else {
            $('#cardDashboardUsuarioTabela').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhuma permissão atribuída ...</small></div>');
        }
    } else {
        toastr.error('Erro encontrado, não foi possível identificar o DASHBOARD selecionado', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    }
}

/**
 * FUNCTION
 * Adiciona dashboard informado por parametro ao slot de dashboard do usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setAdicionarDashboardUsuarioConfig(idDashboard, slot) {
    if (idDashboard > 0 || slot > 0) {
        const retorno = await setAdicionarDashboardUsuarioConfigAJAX(idDashboard, slot);
        if (retorno == 0) {
            $('#btnCardDashboardUsuarioBack').click();
            toastr.success('Dashboard configurado com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
            setListaDashboardUsuarioConfiguracao();
        } else if (isArray(retorno)) {
            setErroServidor(retorno);
        } else {
            toastr.error('Ocorreu um ERRO INTERNO, entre em contato com o administrador do sistema', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '6000'});
        }
    }
    return true;
}

/**
 * FUNCTION
 * Remove dashboard informado do SLOT informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setRemoverDashboardSelecionado(slot) {
    if (slot > 0) {
        const retorno = await setAdicionarDashboardUsuarioConfigAJAX(0, slot);
        if (retorno == 0) {
            toastr.success('Configuração de dashboard removida com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
            setListaDashboardUsuarioConfiguracao();
        } else if (isArray(retorno)) {
            setErroServidor(retorno);
        } else {
            toastr.error('Ocorreu um ERRO INTERNO, entre em contato com o administrador do sistema', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '6000'});
        }
    }
    return true;
}

// PERMISSÕES
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Gera lista de permissões atribuidas ao usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setListaPermissaoUsuario() {
    $('#listaPermissoesSize').html('0 registro(s) encontrado(s)');
    $('#listaPermissoes').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    //REQUEST
    const registro = await getListaPermissaoUsuarioAJAX();
    if (registro.length) {
        $('#listaPermissoes').html('');
        var categoriaAnterior = '';
        var html = '';
        for (i = 0; i < registro.length; i++) {
            html = '';
            if (categoriaAnterior !== registro[i]['departamentoNome']) {
                categoriaAnterior = registro[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                html += '    <p class="mb-0 font-13">' + registro[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="div-registro d-flex" style="animation: slide-up 1s ease">';
            html += '   <div>';
            html += '       <small class="text-muted">' + registro[i]['nome'] + '</small>';
            html += '       <p class="mb-0 font-13">' + registro[i]['descricao'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="padding-left: 5px">';
            html += '       <button class="btn btn-sm btn-secondary" type="button" style="margin-top: 10px" onclick="setRemoverPermissao(' + registro[i]['id'] + ')" title="Remover permissão do usuario"><i class="mdi mdi-delete-forever" style="color: white"></i></button>';
            html += '   </div>';
            html += '</div>';
            $('#listaPermissoes').append(html);
            $('#listaPermissoesSize').html((i + 1) + ' registro(s) encontrado(s)');
            await sleep(80);
        }
    } else {
        $('#listaPermissoes').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhuma permissão atribuída ...</small></div>');
    }
    $('#card3').find('.divLoadBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Gera lista de permissões disponiveis de acordo com o usuario logado, efetua
 * filtro atraves de input informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getListaPermissao() {
    $('#cardPermissaoTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    //REQUEST
    const retorno = await getListaPermissaoAJAX();
    if (retorno.length) {
        $('#cardPermissaoTabela').html('');
        var html = '';
        var categoriaAnterior = '';
        for (i = 0; i < retorno.length; i++) {
            html = '';
            if (categoriaAnterior !== retorno[i]['departamentoNome']) {
                categoriaAnterior = retorno[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 6px;padding-left: 15px">';
                html += '    <p class="mb-0 font-13">' + retorno[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="div-registro d-flex" style="animation: slide-up 1s ease">';
            html += '   <div>';
            html += '       <small class="text-muted">' + retorno[i]['nome'] + '</small>';
            html += '       <p class="mb-0 font-13">' + retorno[i]['descricao'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="padding-left: 5px">';
            html += '       <button class="btn btn-sm btn-primary" style="margin-top: 10px" onclick="setAdicionarPermissao(' + retorno[i]['id'] + ')"><i class="mdi mdi-arrow-down" style="color: white"></i></button>';
            html += '   </div>';
            html += '</div>';
            $('#cardPermissaoTabela').append(html);
        }
    } else {
        $('#cardPermissaoTabela').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Adiciona PERMISSÃO informado por parametro a lista de permissões do usuario.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setAdicionarPermissao(idPermissao) {
    if (idPermissao > 0) {
        $('#spinnerGeral').fadeIn(50);
        //REQUEST
        const retorno = await setAdicionarPermissaoAJAX(idPermissao);
        if (retorno) {
            $('#spinnerGeral').fadeOut(50);
            toastr.success('Permissão adiciona com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
            setListaPermissaoUsuario();
            return true;
        }
    }
    toastr.error('Erro encontrado, não foi possível identificar a permissão selecionada', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    $('#spinnerGeral').fadeOut(50);
    return true;
}

/**
 * FUNCTION
 * Remove PERMISSAO do usuario informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setRemoverPermissao(idPermissao) {
    if (idPermissao > 0) {
        var functionDelete = async function (id) {
            $('#spinnerGeral').fadeIn(50);
            //REQUEST
            const retorno = await setRemoverPermissaoAJAX(idPermissao);
            if (retorno) {
                $('#spinnerGeral').fadeOut(50);
                toastr.success('Permissão REMOVIDA com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
                setListaPermissaoUsuario();
                return true;
            }
            toastr.error('Erro encontrado, não foi possível identificar a permissão selecionada', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
            $('#spinnerGeral').fadeOut(50);
            return true;
        };
        //ALERT 
        Swal.fire({
            title: 'Você tem certeza',
            text: "Deseja REMOVER a permissão do usuário?",
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.value) {
                functionDelete(idPermissao);
            }
        });
    }
}

////////////////////////////////////////////////////////////////////////////////
//                         - INTERNAL FUNCTION -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION INTERNAL
 * Aninação de contagem através de elemento informado
 * 
 * @author    Manoel Louro
 * @date      29/11/2019
 */
function animateContador(element) {
    var $this = $(element);
    jQuery({Counter: 0}).animate({Counter: $this.text()}, {
        duration: 1000,
        easing: 'swing',
        step: function () {
            $this.text(Math.ceil(this.Counter));
        }
    });
}

/**
 * FUNCTION INTERNAL
 * Verifica se parametro informado é um ARRAY
 * 
 * @param     {type} what
 * @returns   {Boolean}
 * @author    Manoel Louro
 * @date      20/12/2019
 */
function isArray(what) {
    return Object.prototype.toString.call(what) === '[object Array]';
}