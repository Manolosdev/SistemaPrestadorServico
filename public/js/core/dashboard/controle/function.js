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
 * Inicializa dependencias do controle de registro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setDependencia() {
    //EMPRESA
    const departamento = await getListaDepartamentoAJAX();
    if (departamento.length > 0) {
        $('#cardListaPesquisaDepartamento').html('<option value="0">- Todos departamento -</option>');
        $('#cardEditorDepartamento').html('<option value="0">- Sem departamento -</option>');
        for (var i = 0; i < departamento.length; i++) {
            var registro = departamento[i];
            $('#cardListaPesquisaDepartamento').append('<option value="' + registro['id'] + '">' + registro['nome'] + '</option>');
            $('#cardEditorDepartamento').append('<option value="' + registro['id'] + '">' + registro['nome'] + '</option>');
        }
    } else {
        $('#cardListaPesquisaDepartamento').html('<option value="0" disabled selected>- Erro Interno -</option>');
        $('#cardEditorDepartamento').html('<option value="0" disabled selected>- Erro Interno -</option>');
    }
    //VALIDATION
    $('#cardEditorForm').validate().destroy();
    $('#cardEditorForm').validate({
        ignore: "",
        errorClass: "error",
        errorElement: 'label',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        onError: function () {
            $('.input-group.error-class').find('.help-block.form-error').each(function () {
                $(this).closest('.form-group').addClass('error').append($(this));
            });
        },
        success: function (element) {
            $(element).parent('.form-group').removeClass('error');
            $(element).remove();
        },
        rules: {}
    });
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de registro encontrados.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function setEstatistica() {
    //REGISTROS POR DEPARTAMENTO
    const semestral = await getTotalRegistroPorDepartamentoAJAX();
    if (semestral['departamento']) {
        chart.data.labels = semestral['departamento'];
        chart.data.datasets[0].data = semestral['quantidade'];
        chart.update();
    }
    //TOTAL REGISTROS
    const totalRegistro = await getTotalRegistroAJAX();
    $('#cardEstatisticaTotalRegistro').html(totalRegistro);
    animateContador($('#cardEstatisticaTotalRegistro'));
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
    $('#cardListaTabela').html('<div style="padding-top: 140px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
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
        $('#cardListaTabela').html('<div class="col-12 text-center" style="padding-top: 230px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaTabelaSize').prop('class', '');
        $('#cardListaTabelaSize').html('Nenhum registro encontrado ...');
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
    html = '<div class="d-flex no-block div-registro" style="padding-left: 13px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up .3s ease" onclick="getRegistro(this)">';
    html += '   <input hidden class="registroID" value="' + registro['id'] + '">';
    html += '   <div style="margin-right: 10px;width: 37px">';
    html += '       <p class="color-default font-11" style="margin-bottom: 0px">#' + (parseInt(registro['id']) > 9 ? registro['id'] : '0' + registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-lg-block" style="margin-right: 10px;width: 49px">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-account-multiple"></i> ' + registro['numeroUsuario'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-lg-block" style="width: 170px">';
    html += '       <p class="text-truncate color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-hexagon-multiple"></i> ' + registro['departamentoNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate" style="width: 180px">';
    html += '       <p class="text-truncate color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-chart-arc"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-xl-block" style="max-width: 700px">';
    html += '       <p class="text-truncate color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-information-outline"></i> ' + registro['descricao'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="d-none d-lg-block" style="width: 83px">';
    html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                               - CARD EDITOR -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi elemento de edição de registro selecionado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getRegistro(element) {
    $('#spinnerGeral').fadeIn(50);
    const registro = await getRegistroAJAX($(element).find('.registroID').val());
    if (registro['id'] > 0) {
        $('#cardListaTabela').find('.div-registro-active').removeClass('div-registro-active');
        $(element).addClass('div-registro-active');
        controllerInterfaseGeralCardEditor.setEstadoInicial();
        $('#cardEditorID').val(registro['id']);
        $('#cardEditorTitulo').html('<i class="mdi mdi-chart-arc"></i> Editor de Dashboard #' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']));
        //TAB INFO
        $('#cardEditorNome').val(registro['nome']);
        $('#cardEditorDepartamento').val((registro['fkDepartamento'] == null ? 0 : registro['fkDepartamento']));
        $('#cardEditorDescricao').val(registro['descricao']);
        //TAB DESENVOLVEDOR
        $('#cardEditorScript').val(registro['script']);
        $('#cardEditorScriptImg').val(registro['nomeImagem']);
        $('#cardEditorScriptImg').change();
        controllerInterfaseGeralCardEditor.setOpenAnimation();
        getCardEditorListaUsuarioControle(1);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
async function getCardEditorListaUsuarioControle(numeroPagina = 1) {
    controllerInterfaseGeralCardEditor.setEstadoInicialPaginacao();
    $('#cardEditorListaUsuario').html('<div style="padding-top: 30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardEditorListaUsuarioSize').prop('class', 'flashit');
    $('#cardEditorListaUsuarioSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getCardEditorListaUsuarioJAX(numeroPagina, controllerInterfaseGeralCardEditor.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardEditorListaUsuario').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardEditorListaUsuario').append(setCardEditorListaUsuarioRegistroHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseGeralCardEditor.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardEditorListaUsuario').html('<div class="col-12 text-center" style="padding-top: 110px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardEditorListaUsuarioSize').prop('class', '');
        $('#cardEditorListaUsuarioSize').html('Nenhum registro encontrado ...');
        controllerInterfaseGeralCardEditor.setEstadoInicialPaginacao();
}
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setCardEditorListaUsuarioRegistroHTML(registro, tabelaIndex = 1) {
    var sleep = parseFloat((tabelaIndex / 20) + .2);
    var html = '';
    html = '<div class="d-flex no-block div-registro" style="padding-left: 11px;margin-bottom: 1px;padding-top: 7px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease" onclick="getInfoUsuario(' + registro['id'] + ', this)">';
    html += '   <div class="text-truncate" style="margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-account"></i> ' + registro['usuarioNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 158px">';
    html += '           <p class="text-truncate color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-hexagon-multiple"></i> ' + registro['departamentoNome'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                            - CARD RELATORIO -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi relatorio de acordo com item selecionado.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getRelatorio(element, nomeRelatorio, tipoRelatorio) {
    //MARK ELEMENT
    $(element).parent().children().removeClass('div-registro-active').addClass('div-registro');
    $(element).addClass('div-registro-active').removeClass('div-registro');
    $('#spinnerGeral').fadeIn(50);
    setTimeout(function () {
        window.open(APP_HOST + '/Dashboard/getRelatorioAJAX?operacao=' + nomeRelatorio + '&tipoRelatorio=' + tipoRelatorio);
        $('#spinnerGeral').fadeOut(150);
    }, 800);
}

////////////////////////////////////////////////////////////////////////////////
//                            - FUNÇÕES INTERNAS -                            //
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