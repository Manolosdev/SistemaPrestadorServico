/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      26/06/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do controle de usuarios.
 * 
 * @author    Manoel Louro
 * @date      26/06/2021
 */
async function setDependencia() {
    //EMPRESA
    const empresa = await getEmpresaAJAX();
    if (empresa.length > 0) {
        for (var i = 0; i < empresa.length; i++) {
            var registro = empresa[i];
            $('#pesquisaEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
            $('#cardCadastroEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
        }
    } else {
        $('#pesquisaEmpresa').html('<option value="0" disabled selected>- Erro Interno -</option>');
        $('#cardCadastroEmpresa').html('<option value="0" disabled selected>- Erro Interno -</option>');
    }
    const departamento = await getDepartamentoAJAX();
    if (departamento.length > 0) {
        for (var i = 0; i < departamento.length; i++) {
            var registro = departamento[i];
            $('#cardCadastroDepartamento').append('<option value="' + registro['id'] + '">' + registro['nome'] + '</option>');
        }
    } else {
        $('#cardCadastroDepartamento').html('<option value="0" disabled selected>- Erro Interno -</option>');
    }
    setEstadoInicialCadastroUsuario();
}

/**
 * FUNCTION
 * Atualiza dependencias do formulario de cadastro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setDependenciaCadastro() {
    //USUARIOS
    const usuario = await getListaUsuarioAtivoAJAX();
    $('#cardCadastroSuperior').html('<option disabled selected>- Selecione o Superior -</option>');
    if (usuario.length > 0) {
        for (var i = 0; i < usuario.length; i++) {
            var registro = usuario[i];
            $('#cardCadastroSuperior').append('<option value="' + registro['id'] + '">' + (registro['departamentoNome'] + ' - ' + registro['usuarioNome']) + '</option>');
        }
    } else {
        $('#cardCadastroSuperior').html('<option value="0">- Erro Interno -</option>');
    }
    //PERMISSÕES
    var permissao = await getPermissaoUsuarioAJAX();
    if (permissao.length) {
        $('#cardListaPermissao').html('');
        var nomeDepartamento = '';
        var contadorTab = 0;
        var html = '';
        for (var i = 0; i < permissao.length; i++) {
            var registro = permissao[i];
            if (nomeDepartamento !== registro['departamentoNome']) {
                $('#cardListaPermissao').append((html === '' ? html : html + '</div>'));
                html = '';
                nomeDepartamento = registro['departamentoNome'];
                contadorTab++;
                html += '<div class="divColapse border-default bg-light color-default" data-toggle="collapse" data-collapse="collapsePermissao' + contadorTab + '" data-target="#collapsePermissao' + contadorTab + '" aria-controls="collapsePermissao' + contadorTab + '" style="animation: slide-up .2s ease">+ ' + nomeDepartamento + '</div>';
                html += '<div id="collapsePermissao' + contadorTab + '" class="collapse ' + (contadorTab === 1 ? 'show' : '') + '" data-parent="#listaPermissao">';
            }
            html += '<div class="div-registro" style="padding-top: 5px;padding-bottom: 8px;padding-left: 15px">';
            html += '   <input hidden class="id" value="' + registro['id'] + '">';
            html += '   <input hidden class="nome" value="' + registro['nome'] + '">';
            html += '   <input hidden class="descricao" value="' + registro['descricao'] + '">';
            html += '   <div class="d-flex no-block align-items-center" style="margin-bottom: 0px">';
            html += '       <div style="margin-right: 10px">';
            html += '           <small class="text-muted">' + registro['nome'] + '</small>';
            html += '           <p class="mb-0 font-13">' + registro['descricao'] + '</p>';
            html += '       </div>';
            html += '       <div class="ml-auto">';
            html += '           <button type="button" class="btn btn-sm btn-primary pull-right font-11" onclick="setCadastroAdicionarPermissao(this)" title="Adicionar permissão ao novo usuário selecionado"><i class="mdi mdi-arrow-down"></i></button>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        }
        $('#cardListaPermissao').append(html);
    } else {
        $('#cardListaPermissao').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    //DASHBOARD
    var dashboard = await getDashboardUsuarioAJAX();
    if (dashboard.length) {
        $('#cardListaDashboard').html('');
        var nomeDepartamento = '';
        var contadorTab = 0;
        var html = '';
        for (var i = 0; i < dashboard.length; i++) {
            var registro = dashboard[i];
            if (nomeDepartamento !== registro['departamentoNome']) {
                $('#cardListaDashboard').append((html === '' ? html : html + '</div>'));
                html = '';
                nomeDepartamento = registro['departamentoNome'];
                contadorTab++;
                html += '<div class="divColapse border-default bg-light color-default" data-toggle="collapse" data-collapse="collapseDashboard' + contadorTab + '" data-target="#collapseDashboard' + contadorTab + '" aria-controls="collapseDashboard' + contadorTab + '" style="animation: slide-up .2s ease">+ ' + nomeDepartamento + '</div>';
                html += '<div id="collapseDashboard' + contadorTab + '" class="collapse ' + (contadorTab === 1 ? 'show' : '') + '" data-parent="cardListaDashboard">';
            }
            html += '<div class="div-registro" style="padding-top: 5px;padding-bottom: 8px;padding-left: 15px">';
            html += '   <input hidden class="id" value="' + registro['id'] + '">';
            html += '   <div class="d-flex no-block align-items-center" style="margin-bottom: 0px">';
            html += '       <div style="margin-right: 10px">';
            html += '           <small class="text-muted">' + registro['nome'] + '</small>';
            html += '           <p class="mb-0 font-13">' + registro['descricao'] + '</p>';
            html += '       </div>';
            html += '       <div class="ml-auto">';
            html += '           <button type="button" class="btn btn-sm btn-primary pull-right" onclick="setCadastroAdicionarDashboard($(this).parent().parent().parent())" title="Adicionar permissão ao departamento selecionado"><i class="mdi mdi-arrow-down"></i></button>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
        }
        $('#cardListaDashboard').append(html);
    } else {
        $('#cardListaDashboard').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
}

/**
 * FUNCTION
 * Constroi estatistica de usuarios ativos e inativos dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      25/11/2019
 */
async function setEstatisticaUsuario() {
    //USUARIOS departamento
    const departamento = await getEstatisticaDepartamentoAJAX();
    if (departamento['departamento']) {
        chart.data.labels = departamento['departamento'];
        chart.data.datasets[0].data = departamento['quantidade'];
        chart.update();
    }
    //USUARIOS SITUAÇÃO
    const usuario = await getEstatisticaAJAX();
    if (usuario.length === 3) {
        var maxValor = parseInt(usuario[0]);
        //TODOS ----------------------------------------------------------------
        $('#cardEstatisticaUsuarioTodos').html(maxValor);
        animateContador($('#cardEstatisticaUsuarioTodos'));
        //ATIVOS ---------------------------------------------------------------
        $('#cardEstatisticaUsuarioAtivo').html(usuario[1]);
        animateContador($('#cardEstatisticaUsuarioAtivo'));
        //INATIVOS -------------------------------------------------------------
        $('#cardEstatisticaUsuarioInativo').html(usuario[2]);
        animateContador($('#cardEstatisticaUsuarioInativo'));
    }
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      18/01/2021
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
 * @date      18/01/2021
 */
function setRegistroControleHTML(registro) {
    var html = '';
    html += '<div class="d-flex no-block div-registro" style="margin-bottom: 1px;padding-left: 8px;padding-right: 11px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up .3s ease;border-left: ' + (registro['ativo'] == 1 ? '4px solid #15d458' : '4px solid #6c757d') + '" onclick="getInfoUsuario(' + registro['id'] + ', this)">';
    html += '   <div class="text-truncate" style="width: 40px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px">#' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px"><i class="mdi mdi-account"></i> ' + registro['usuarioNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 150px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-hexagon-multiple"></i>  ' + registro['departamentoNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-right: 10px;width: 80px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-account-multiple"></i>  ' + registro['subordinados'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-right: 10px;width: 70px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-lock-open"></i>  ' + registro['permissoes'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-right: 10px;width: 70px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-chart-pie"></i> ' + registro['dashboards'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 115px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-calendar-check"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Adiciona permissão informada por parametro
 * 
 * @author    Manoel Louro
 * @date      27/06/2020
 */
function setCadastroAdicionarPermissao(element) {
    $(element).blur();
    var ocorrencia = false;
    element = $(element).parent().parent().parent();
    $('#cardCadastroListaPermissao').children('.div-registro').each(function () {
        if ($(this).find('.id').val() == $(element).find('.id').val()) {
            ocorrencia = true;
            return true;
        }
    });
    //ANIMATION
    $(element).closest('.div-registro').fadeOut(0);
    $(element).closest('.div-registro').fadeIn(200);
    if (ocorrencia) {
        return true;
    }
    $('#cardCadastroListaPermissao').find('.listaVazia').remove();
    var html = '';
    html += '<div class="div-registro" style="padding-top: 5px;padding-bottom: 8px;padding-left: 15px">';
    html += '   <input hidden class="id" value="' + $(element).find('.id').val() + '">';
    html += '   <div class="d-flex no-block align-items-center" style="margin-bottom: 0px">';
    html += '       <div style="margin-right: 10px">';
    html += '           <small class="text-muted">' + $(element).find('.nome').val() + '</small>';
    html += '           <p class="mb-0 font-13">' + $(element).find('.descricao').val() + '</p>';
    html += '       </div>';
    html += '       <div class="ml-auto">';
    html += '           <button type="button" class="btn btn-sm btn-secondary pull-right font-11" onclick="setCadastroRemoverPermissao($(this).parent().parent().parent())" title="Remove permissão selecionada"><i class="mdi mdi-close"></i></button>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    $('#cardCadastroListaPermissao').append(html);
    toastr.success("Permissão atribuida com sucesso", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "600"});
    $('#cardCadastroListaPermissaoSize').html($('#cardCadastroListaPermissao').find('.div-registro').length + ' permissõe(s) atribuída(s)');
}

/**
 * FUNCTION
 * Remove elemento informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      27/06/2020
 */
function setCadastroRemoverPermissao(element) {
    $(element).hide(100);
    setTimeout(function () {
        $(element).remove();
        if ($('#cardCadastroListaPermissao').find('.div-registro').length == 0) {
            $('#cardCadastroListaPermissao').html('<div class="listaVazia" style="padding: 15px"><small class="text-muted">Nenhum registros encontrado ...</small></div>');
            $('#cardCadastroListaPermissaoSize').html('0 permissõe(s) atribuída(s)');
        } else {
            $('#cardCadastroListaPermissaoSize').html($('#cardCadastroListaPermissao').find('.div-registro').length + ' permissõe(s) atribuída(s)');
        }
    }, 100);

}

/**
 * FUNCTION
 * Adiciona Dashboard informado por parametro
 * 
 * @author    Manoel Louro
 * @date      29/06/2020
 */
async function setCadastroAdicionarDashboard(element) {
    var idRegistro = $(element).find('.id').val();
    if (idRegistro == $('#cardAdicionarDashboard1').val() || idRegistro == $('#cardAdicionarDashboard2').val() || idRegistro == $('#cardAdicionarDashboard3').val()) {
        $(element).find('button').prop('class', 'btn btn-sm btn-danger');
        $('#cardDashboardCard').prop('class', 'card animated shake');
        setTimeout(function () {
            $(element).find('button').prop('class', 'btn btn-sm btn-primary');
            $('#cardDashboardCard').prop('class', 'card');
        }, 800);
        toastr.error("Dashboard já configurado na lista de dashboard do usuário", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "1000"});
        return false;
    }
    $('#spinnerGeral').fadeIn(50);
    const registro = await getDashboardAJAX(idRegistro);
    if (registro['id']) {
        var numeroElemento = $('#cardDashboardSelected').val();
        $('#cardAdicionarDashboard' + numeroElemento).val(registro['id']);
        $('#cardAdicionarDashboardTitulo' + numeroElemento).html(registro['nome']);
        $('#cardAdicionarDashboardDescricao' + numeroElemento).html(registro['descricao']);
        $('#cardAdicionarDashboardImg' + numeroElemento).prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + registro['nomeImagem']);
        toastr.success("Dashboard atribuída com sucesso", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "600"});
        $('#cardDashboardCard').css('animation', '');
        $('#cardDashboardCard').css('animation', 'fadeOutRight .6s');
        $('#cardDashboard').fadeOut(200);
        setTimeout(function () {
            $('#cardDashboardCard').css('animation', '');
        }, 630);
        $('#cardDashboard').fadeOut(50);
        $('#spinnerGeral').fadeOut(50);
        $('#cardAdicionarDashboardDiv' + numeroElemento).fadeOut(0);
        await sleep(100);
        $('#cardAdicionarDashboardDiv' + numeroElemento).fadeIn(0);
    }
    $('#spinnerGeral').fadeOut(50);

}

////////////////////////////////////////////////////////////////////////////////
//                         - INTERNAL FUNCTIONS -                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna estado do formulario de cadastro de usuario para estado inicial.
 * 
 * @author    Manoel Louro
 * @date      27/11/2019
 */
function setEstadoInicialCadastroUsuario() {
    $("#cardCadastroForm").validate().resetForm();
    $('#cardCadastroImagem').prop('src', APP_HOST + '/public/template/assets/img/user_default.png');
    $('#cardCadastroPerfil').val('');
    $('#cardCadastroNomeCompleto').val('');
    $('#cardCadastroNomeSistema').val('');
    $('#cardCadastroCelular').val('');
    $('#cardCadastroEmail').val('');
    $('#cardCadastroLogin').val('');
    $('#cardCadastroDepartamento').val(0);
    $('#cardCadastroUsuarioISP option').eq(0).prop('selected', true);
    $('#cardCadastroVendedorISP option').eq(0).prop('selected', true);
    //PERMISSÃO
    $('#cardCadastroListaPermissao').html('<div class="listaVazia" style="padding: 15px"><small class="text-muted">Nenhum registros encontrado ...</small></div>');
    $('#cardCadastroListaPermissaoSize').html('0 permissõe(s) atribuída(s)');
    //DASHBOARD
    setEstadoInicialCadastroUsuarioDashboard(1);
    setEstadoInicialCadastroUsuarioDashboard(2);
    setEstadoInicialCadastroUsuarioDashboard(3);
    setDependenciaCadastro();
}

/**
 * INTERNAL FUNCTION 
 * Determina estado inicial do formulario de definição de dashboard do usuario.
 * 
 * @author    Manoel Louro
 * @date      29/06/2020
 */
function setEstadoInicialCadastroUsuarioDashboard(numeroElemento) {
    $('#cardAdicionarDashboard' + numeroElemento).val(null);
    $('#cardAdicionarDashboardTitulo' + numeroElemento).html('Vazio ...');
    $('#cardAdicionarDashboardDescricao' + numeroElemento).html('Nenhum dashboard configurado ...');
    $('#cardAdicionarDashboardImg' + numeroElemento).removeAttr('src').replaceWith($('#cardAdicionarDashboardImg' + numeroElemento).clone());
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