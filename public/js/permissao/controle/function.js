/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      04/07/2019
 * @update    28/06/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do controle de usuarios.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setDependencia() {
    //CARGOS
    const departamento = await getListaDepartamentoAJAX();
    if (departamento.length > 0) {
        $('#cardEditorDepartamento').html('');
        for (var i = 0; i < departamento.length; i++) {
            var registro = departamento[i];
            $('#cardEditorDepartamento').append('<option value="' + registro['id'] + '">' + registro['nome'] + '</option>');
        }
    } else {
        $('#cardEditorDepartamento').html('<option value="0" disabled selected>- Erro Interno -</option>');
    }
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de usuarios por cargo cadastrado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setEstatistica() {
    //PERMISSÕES DO DEPARTAMENTO
    const departamento = await getEstatisticaDepartamentoAJAX();
    if (departamento['departamento']) {
        chart.data.labels = departamento['departamento'];
        chart.data.datasets[0].data = departamento['quantidade'];
        chart.update();
    }
    //TOTAL REGISTROS
    const totalPermissao = await getTotalRegistroAJAX();
    $('#cardEstatisticaPermissaoTodos').html(totalPermissao);
    animateContador($('#cardEstatisticaPermissaoTodos'));
}

/**
 * FUNCTION
 * Constroi tabela de cargos cadastradas de acordo com filtos de pesquisa 
 * aplicados
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getListaRegistro() {
    $('.divLoadBlock').fadeIn(0);
    $('#tabelaGeral').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#tabelaGeral').html('<div style="padding-top: 150px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#tabelaGeralSize').html('<b>0</b> registro(s) encontrado(s)');
    const listaRegistro = await getListaRegistroCadastradoAJAX();
    if (listaRegistro.length > 0) {
        $('#tabelaGeral').html('');
        var nomeDepartamento = '';
        var contadorTab = 0;
        var html = '';
        for (var i = 0; i < listaRegistro.length; i++) {
            var registro = listaRegistro[i];
            if (nomeDepartamento !== registro['departamentoNome']) {
                $('#tabelaGeral').append((html === '' ? html : html + '</div>'));
                html = '';
                nomeDepartamento = registro['departamentoNome'];
                contadorTab++;
                html += '<div class="divColapse bg-light color-default" data-toggle="collapse" data-collapse="collapse' + contadorTab + '" data-target="#collapse' + contadorTab + '" aria-controls="collapse' + contadorTab + '" style="animation: slide-up .2s ease">+ ' + nomeDepartamento + '</div>';
                html += '<div id="collapse' + contadorTab + '" class="collapse show" data-parent="#listaPermissao">';
            }
            html += '<div class="d-flex no-block div-registro" style="padding-top: 7px;padding-bottom: 7px;cursor: pointer" onclick="getRegistro(this)">';
            html += '   <input hidden class="id" value="' + registro['id'] + '">';
            html += '   <div style="margin-right: 10px;min-width: 40px;max-width: 40px">';
            html += '       <small class="text-muted">ID</small>';
            html += '       <p class="color-default font-11" style="margin-bottom: 0px">#' + (parseInt(registro['id']) > 9 ? registro['id'] : '0' + registro['id']) + '</p>';
            html += '   </div>';
            html += '   <div class="" style="margin-right: 10px">';
            html += '       <small class="text-muted">' + registro['nome'] + '</small>';
            html += '       <p class="text-justify color-default mb-0 font-11" style="margin-bottom: 0px">' + registro['descricao'] + '</p>';
            html += '   </div>';
            html += '   <div class="d-flex ml-auto">';
            html += '       <div class="d-none d-md-block" style="width: 100px">';
            html += '           <small class="text-muted">Departamentos</small>';
            html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px" title="Quantidade de cargos que possuém essa permissão por padrão"><i class="mdi mdi-hexagon-multiple"></i> ' + registro['numeroDepartamento'] + '</p>';
            html += '       </div>';
            html += '       <div class="d-none d-md-block" style="width: 50px">';
            html += '           <small class="text-muted">Usuários</small>';
            html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px" title="Quantidade de usuários que possuém essa permissão"><i class="mdi mdi-account-multiple"></i> ' + registro['numeroUsuario'] + '</p>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        }
        $('#tabelaGeral').append(html);
        $('#tabelaGeralSize').html('<b>' + listaRegistro.length + '</b> registro(s) encontrado(s)');
    } else {
        $('#tabelaGeral').html('<div class="col-12 text-center" style="padding-top: 240px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#tabelaGeralSize').html('<b>0</b> registro(s) encontrado(s)');
    }
    $('.divLoadBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Abre tela interna com informações do cargo informada por parametro
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getRegistro(element) {
    $('#tabelaGeral').find('.div-registro-active').removeClass('div-registro-active');
    $(element).addClass('div-registro-active');
    $('#spinnerGeral').fadeIn(150);
    estadoInicialInternal();
    const retorno = await getRegistroAJAX($(element).find('.id').val());
    if (retorno['id']) {
        $('#cardEditorID').val(retorno['id']);
        $('#cardEditorNome').val(retorno['nome']);
        $('#cardEditorDescricao').val(retorno['descricao']);
        $("#cardEditorDepartamento").val(retorno['fkDepartamento']).change();
        await setCardEditorDepartamento();
        await setCardEditorUsuario();
        $('#cardEditorCard').css('animation', '');
        $('#cardEditorCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardEditor').fadeIn(200);
        setTimeout(function () {
            $('#cardEditorCard').css('animation', '');
        }, 400);
        $('#cardEditor').fadeIn(150);
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNÇÃO CORE
 * Cria lista de permissões do departamento informado
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setCardEditorDepartamento() {
    $('#cardEditorListaDepartamento').html('<div style="padding: 15px"><small class="text-muted">Buscando registros ...</small></div>');
    $('#cardEditorListaDepartamentoSize').html('<b>0</b> departamento(s) encontrado(s)');
    var lista = await getPermissaoDepartamentoAJAX();
    if (lista.length) {
        $('#cardEditorListaDepartamento').html('');
        var html = '';
        for (var i = 0; i < lista.length; i++) {
            var registro = lista[i];
            html = '<div class="div-registro" style="padding-top: 7px;padding-bottom: 6px;animation: slide-up 1s ease">';
            html += '   <div class="d-flex no-block align-items-center" style="margin-bottom: 0px">';
            html += '       <div style="margin-right: 10px">';
            html += '           <p class="mb-0 font-13">' + registro['nome'] + '</p>';
            html += '           <small class="text-muted">' + registro['empresaNome'] + '</small>';
            html += '       </div>';
            html += '       <div class="ml-auto" style="width: 45px;padding-top: 5px">';
            html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 13px" title="Quantidade de usuários que são desse departamento"><i class="mdi mdi-account-multiple font-14"></i> ' + registro['numeroUsuario'] + '</p>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#cardEditorListaDepartamento').append(html);
            $('#cardEditorListaDepartamentoSize').html('<b>' +(i + 1) + '</b> departamento(s) encontrado(s)');
        }
    } else {
        $('#cardEditorListaDepartamento').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Constroi lista de usuarios cadastrado no departamento informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setCardEditorUsuario() {
    $('#cardEditorListaUsuario').html('<div style="padding: 15px"><small class="text-muted">Buscando registros ...</small></div>');
    $('#cardEditorListaUsuarioSize').html('<b>0</b> usuário(s) encontrado(s)');
    var usuarios = await getPermissaoUsuarioAJAX();
    if (usuarios.length) {
        $('#cardEditorListaUsuario').html('');
        var nomeDepartamento = '';
        var contadorTab = 0;
        var html = '';
        for (var i = 0; i < usuarios.length; i++) {
            var registro = usuarios[i];
            if (nomeDepartamento !== registro['departamentoNome']) {
                $('#cardEditorListaUsuario').append((html === '' ? html : html + '</div>'));
                html = '';
                nomeDepartamento = registro['departamentoNome'];
                contadorTab++;
                html += '<div class="divColapse bg-light color-default" data-toggle="collapse" data-collapse="collapseUsuario' + contadorTab + '" data-target="#collapseUsuario' + contadorTab + '" aria-controls="collapseUsuario' + contadorTab + '" style="animation: slide-up .2s ease">+ ' + nomeDepartamento + '</div>';
                html += '<div id="collapseUsuario' + contadorTab + '" class="collapse show" data-parent="#listaUsuarioPermissao">';
            }
            html += '<div class="d-flex div-registro" onclick="getInfoUsuario(' + registro['id'] + ', this)" style="cursor: pointer;margin-top: 1px;padding: 10px;padding-left: 15px;animation: slide-up 1s ease">';
            html += '   <div style="margin-right: 10px;position: relative">';
            html += '       <img src="data:image/png;base64,' + registro['usuarioPerfil'] + '" alt="user" class="rounded-circle img-user" height="45" width="45">';
            if (registro['usuarioAtivo'] == 1) {
                html += '   <small class="userAtivo text-info" data-ativo="1" style="position: absolute; right: -5px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-16"></i></small>';
            } else {
                html += '   <small class="userAtivo text-secondary" data-ativo="0" style="position: absolute; right: -5px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-16"></i></small>';
            }
            html += '   </div>';
            html += '   <div class="text-truncate" style="padding-top: 8px;min-width: 90px">';
            html += '       <h5 class="userNome mb-0 text-truncate color-default font-11">' + registro['usuarioNome'] + '</h5>';
            html += '       <p class="userCargo mb-0 text-truncate text-muted font-11" style="max-height: 20px">' + registro['departamentoNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="width: 60px">';
            html += '       <small class="text-muted">Permissões</small>';
            html += '       <p class="color-default" style="margin-bottom: 0px;font-size: 13px" title="Quantidade de permissões atribuída a esse usuário"><i class="mdi mdi-lock-open font-14"></i>  ' + registro['numeroPermissao'] + '</p>';
            html += '    </div>';
            html += '</div>';
        }
        $('#cardEditorListaUsuario').append(html);
        $('#cardEditorListaUsuarioSize').html('<b>' + usuarios.length + '</b> usuário(s) encontrado(s)');
    } else {
        $('#cardEditorListaUsuario').html('<div style="padding: 15px"><small class="text-muted">Nenhum registros encontrado ...</small></div>');
    }
}

////////////////////////////////////////////////////////////////////////////////
//                            - FUNÇÕES INTERNAS -                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION INTERNAL
 * Limpa o formulario e determina o estado inicial do internal
 * 
 * @author    Manoel Louro
 * @date      04/07/2019
 */
function estadoInicialInternal() {
    $('#cardEditorID').val('');
    $('#cardEditorNome').val('');
    $('#cardEditorDescricao').val('');
    $("label.error").hide();
    $(".error").removeClass("error");
}

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
