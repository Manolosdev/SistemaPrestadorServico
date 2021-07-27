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
    //PERMISSÃO
    $('#cardPermissaoCadastro').html('<div style="padding: 15px"><small class="text-muted">Buscando registros ...</small></div>');
    var retorno = await getPermissaoAJAX();
    if (retorno.length) {
        $('#cardPermissaoCadastro').html('');
        var nomeDepartamento = '';
        var contadorTab = 0;
        var html = '';
        for (var i = 0; i < retorno.length; i++) {
            var registro = retorno[i];
            if (nomeDepartamento !== registro['departamentoNome']) {
                $('#cardPermissaoCadastro').append((html === '' ? html : html + '</div>'));
                html = '';
                nomeDepartamento = registro['departamentoNome'];
                contadorTab++;
                html += '<div class="divColapse border-default bg-light color-default" data-toggle="collapse" data-collapse="collapse' + contadorTab + '" data-target="#collapse' + contadorTab + '" aria-controls="collapse' + contadorTab + '" style="animation: slide-up .2s ease">+ ' + nomeDepartamento + '</div>';
                html += '<div id="collapse' + contadorTab + '" class="collapse ' + (contadorTab === 1 ? 'show' : '') + '" data-parent="#listaPermissao">';
            }
            html += '<div class="div-registro" style="padding-top: 5px;padding-bottom: 8px">';
            html += '   <div class="d-flex no-block align-items-center" style="margin-bottom: 0px">';
            html += '       <div style="margin-right: 10px">';
            html += '           <small class="text-muted">' + registro['nome'] + '</small>';
            html += '           <p class="mb-0 font-11">' + registro['descricao'] + '</p>';
            html += '       </div>';
            html += '       <div class="ml-auto">';
            html += '           <button type="button" class="btn btn-xs btn-primary pull-right" onclick="setAdicionarPermissao(' + registro['id'] + ', this)" title="Adicionar permissão ao cargo selecionado"><i class="mdi mdi-arrow-down"></i></button>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        }
        $('#cardPermissaoCadastro').append(html);
    } else {
        $('#cardPermissaoCadastro').html('<div style="padding: 15px"><small class="text-muted">Nenhum registros encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de usuarios por departamento cadastrado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setEstatistica() {
    //USUARIOS
    const departamento = await getEstatisticaDepartamentoAJAX();
    if (departamento['departamento']) {
        chart.data.labels = departamento['departamento'];
        chart.data.datasets[0].data = departamento['quantidade'];
        chart.update();
    }
    //TOTAL REGISTROS
    const totalDepartamento = await getTotalRegistroAJAX();
    $('#cardEstatisticaDepartamentoTodos').html(totalDepartamento);
    animateContador($('#cardEstatisticaDepartamentoTodos'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getListaControle(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseGeral.setEstadoInicialPaginacao();
    $('#cardListaTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaTabelaSize').prop('class', 'flashit');
    $('#cardListaTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleAJAX(numeroPagina, controllerInterfaseGeral.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaTabela').append(setRegistroControleHTML(listaRegistro['listaRegistro'][i]));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseGeral.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaTabela').html('<div class="col-12 text-center" style="padding-top: 220px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaTabelaSize').prop('class', '');
        $('#cardListaTabelaSize').html('Nengum registro encontrado ...');
        controllerInterfaseGeral.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setRegistroControleHTML(registro) {
    var html = '';
    html = '<div class="d-flex no-block div-registro" style="padding-left: 10px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up .3s ease;" onclick="getRegistro(this)">';
    html += '   <input hidden class="id" value="' + registro['id'] + '">';
    html += '   <div style="margin-right: 10px;width: 30px">';
    html += '       <p class="color-default font-11" style="margin-bottom: 0px">#' + (parseInt(registro['id']) > 9 ? registro['id'] : '0' + registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-md-block" style="margin-right: 10px;width: 95px">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-key"></i> ' + (registro['administrador'] === 1 ? 'Administrativo' : 'Comum') + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-md-block" style="margin-right: 10px;width: 154px">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-home"></i> ' + registro['nomeEmpresa'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-hexagon-multiple"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="d-none d-md-block" style="width: 91px">';
    html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-lock-open"></i> ' + registro['numeroPermissao'] + '</p>';
    html += '       </div>';
    html += '       <div class="d-none d-md-block" style="width: 60px">';
    html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-account-multiple"></i> ' + registro['numeroUsuario'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Abre tela interna com informações do departamento informada por parametro
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getRegistro(element) {
    $('#cardListaTabela').find('.div-registro-active').each(function () {
        $(this).removeClass('div-registro-active');
    });
    $(element).addClass('div-registro-active');
    $('#spinnerGeral').fadeIn(150);
    estadoInicialInternal();
    const retorno = await getRegistroAJAX($(element).find('.id').val());
    if (retorno['id']) {
        $('#cardEditorID').val(retorno['id']);
        $('#cardEditorNome').val(retorno['nome']);
        $('#cardEditorAdministrador').val(retorno['administrador']);
        $('#cardEditorDescricao').val(retorno['descricao']);
        await setCardEditorPermissao();
        await setCardEditorUsuario();
        $('#cardEditorCard').css('animation', '');
        $('#cardEditorCard').css('animation', 'fadeInLeftBig .3s');
        $('#cardEditor').fadeIn(200);
        setTimeout(function () {
            $('#cardEditorCard').css('animation', '');
        }, 300);
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
async function setCardEditorPermissao() {
    $('#cardEditorPermissao').html('<div style="padding-top: 15px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardEditorPermissaoSize').html('<b>0</b> registro(s) encontrado(s)');
    var lista = await getListaPermissaoPadraoDepartamentoAJAX();
    if (lista.length) {
        $('#cardEditorPermissao').html('');
        var html = '';
        for (var i = 0; i < lista.length; i++) {
            var registro = lista[i];
            html = '<div class="div-registro" style="padding-top: 5px;padding-bottom: 8px;animation: slide-up 1s ease">';
            html += '   <div class="d-flex no-block align-items-center" style="margin-bottom: 0px">';
            html += '       <div style="margin-right: 10px">';
            html += '           <small class="text-muted">' + registro['nome'] + '</small>';
            html += '           <p class="mb-0 font-11">' + registro['descricao'] + '</p>';
            html += '       </div>';
            html += '       <div class="ml-auto">';
            html += '           <button type="button" class="btn btn-xs btn-secondary pull-right" onclick="setRemoverPermissao(' + registro['id'] + ', this)" title="Remover permissão padrão do cargo selecionado"><i class="mdi mdi-delete-forever"></i></button>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#cardEditorPermissao').append(html);
            $('#cardEditorPermissaoSize').html('<b>' + (i + 1) + '</b> registro(s) encontrado(s)');
        }
    } else {
        $('#cardEditorPermissao').html('<div style="padding: 15px"><small>Nenhum permissão associada ...</small></div>');
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
    $('#cardEditorUsuario').html('<div style="padding: 15px"><small class="text-muted">Buscando registros ...</small></div>');
    var lista = await getUsuarioDepartamentoAJAX();
    if (lista.length) {
        $('#cardEditorUsuario').html('');
        var html = '';
        for (var i = 0; i < lista.length; i++) {
            var registro = lista[i];
            var html = '';
            html += '<div class="d-flex div-registro" onclick="getInfoUsuario(' + registro['id'] + ', this)" style="cursor: pointer;margin-top: 1px;padding: 10px;padding-left: 20px;padding-right: 15px;animation: slide-up 1s ease">';
            html += '   <div style="margin-right: 10px;position: relative">';
            html += '       <img src="data:image/png;base64,' + registro['usuarioPerfil'] + '" alt="user" class="rounded-circle img-user" height="45" width="45">';
            if (registro['usuarioAtivo'] == 1) {
                html += '   <small class="text-info" data-ativo="1" style="position: absolute; right: -5px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-16"></i></small>';
            } else {
                html += '   <small class="text-secondary" data-ativo="0" style="position: absolute; right: -5px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-16"></i></small>';
            }
            html += '   </div>';
            html += '   <div class="text-truncate" style="padding-top: 8px;min-width: 90px">';
            html += '       <h5 class="mb-0 text-truncate color-default font-11">' + registro['usuarioNome'] + '</h5>';
            html += '       <p class="mb-0 text-truncate text-muted font-11" style="max-height: 20px">' + registro['empresaNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="width: 60px">';
            html += '       <small class="text-muted">Permissões</small>';
            html += '       <p class="color-default" style="margin-bottom: 0px;font-size: 12px" title="Quantidade de permissões atribuída a esse usuário"><i class="mdi mdi-lock-open"></i>  ' + registro['numeroPermissao'] + '</p>';
            html += '    </div>';
            html += '</div>';
            $('#cardEditorUsuario').append(html);
            $('#cardEditorUsuarioSize').html('<b>' + (i + 1) + '</b> registro(s) encontrado(s)');
        }
    } else {
        $('#cardEditorUsuario').html('<div style="padding: 15px"><small class="text-muted">Nenhum registros encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Remove permissao enviada por parametro
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setRemoverPermissao(idPermissao, element = null) {
    if (element !== null) {
        $(element).blur();
    }
    Swal.fire({
        title: 'Você tem certeza?',
        text: "Deseja remover esta permissão padrão do departamento",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar'
    }).then((result) => {
        if (result.value) {
            controller.functionRemoverPermissao(idPermissao);
        }
    });
}

/**
 * FUNCTION
 * Adiciona permissao ao departamento de acordo com parametro
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setAdicionarPermissao(idPermissao, element) {
    $(element).blur();
    $('#cardPermissaoCadastro').find('.div-registro-active').each(function () {
        $(this).removeClass('div-registro-active');
    });
    $(element).parent().parent().parent().addClass('div-registro-active');
    Swal.fire({
        title: 'Você tem certeza?',
        text: "Deseja adicionar permissão como permissão padrão do departamento",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar'
    }).then((result) => {
        if (result.value) {
            controller.functionAdicionarPermissao(idPermissao);
        }
    });
}

////////////////////////////////////////////////////////////////////////////////
//                           - INTERNAL FUNCTION -                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * UTILITARIA | FUNCTION
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
