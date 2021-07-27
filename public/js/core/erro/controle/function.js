/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do controle de registro.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
async function setDependencia() {
    //TODO HERE
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de registro encontrados.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
async function setEstatistica() {
    //REGISTROS POR DEPARTAMENTO
    const semestral = await getEstatisticaSemestralAJAX();
    if (semestral && semestral.length) {
        chart.data.datasets[0].data = semestral[0];
        chart.data.datasets[1].data = semestral[1];
        chart.update();
    }
    //LOG ERROS
    const logErro = await getTotalErroLogAJAX();
    $('#cardEstatisticaLogErroTotal').html(logErro);
    animateContador($('#cardEstatisticaLogErroTotal'));
    //LOG INTEGRAÇÃO
    const logIntegracao = await getTotalErroApiAJAX();
    $('#cardEstatisticaTotalRegistro').html(logIntegracao);
    animateContador($('#cardEstatisticaTotalRegistro'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
async function getListaControleErroLog(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseGeralTabErroLog.setEstadoInicialPaginacao();
    $('#cardListaErroLogTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaErroLogTabela').html('<div style="padding-top: 140px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaErroLogTabelaSize').prop('class', 'flashit');
    $('#cardListaErroLogTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleErroLogAJAX(numeroPagina, controllerInterfaseGeralTabErroLog.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaErroLogTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaErroLogTabela').append(setRegistroControleErroHTML(listaRegistro['listaRegistro'][i], 1, i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseGeralTabErroLog.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaErroLogTabela').html('<div class="col-12 text-center" style="padding-top: 230px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaErroLogTabelaSize').prop('class', '');
        $('#cardListaErroLogTabelaSize').html('Nenhum registro encontrado ...');
        controllerInterfaseGeralTabErroLog.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
async function getListaControleErroApi(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseGeralTabErroApi.setEstadoInicialPaginacao();
    $('#cardListaErroApiTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaErroApiTabela').html('<div style="padding-top: 140px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaErroApiTabelaSize').prop('class', 'flashit');
    $('#cardListaErroApiTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleErroApiAJAX(numeroPagina, controllerInterfaseGeralTabErroApi.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaErroApiTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaErroApiTabela').append(setRegistroControleErroHTML(listaRegistro['listaRegistro'][i], 2, i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseGeralTabErroApi.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaErroApiTabela').html('<div class="col-12 text-center" style="padding-top: 230px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaErroApiTabelaSize').prop('class', '');
        $('#cardListaErroApiTabelaSize').html('Nenhum registro encontrado ...');
        controllerInterfaseGeralTabErroApi.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function setRegistroControleErroHTML(registro, tipoRegistro, tabelaIndex = 1) {
    var sleep = parseFloat((tabelaIndex / 20) + .2);
    var html = '';
    html = '<div class="d-flex no-block div-registro" style="padding-left: 11px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease" onclick="getRegistroEditor(this, ' + tipoRegistro + ')">';
    html += '   <input hidden class="registroID" value="' + registro['id'] + '">';
    html += '   <input hidden class="registroTipo" value="' + tipoRegistro + '">';
    html += '   <div style="margin-right: 10px;width: 52px">';
    html += '       <p class="color-default font-11" style="margin-bottom: 0px">#' + (parseInt(registro['id']) > 9 ? registro['id'] : '0' + registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate" style="width: 240px">';
    html += '       <p class="text-truncate color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-server-network"></i> ' + registro['local'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-xl-block" style="max-width: 700px">';
    html += '       <p class="text-truncate color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-information-outline"></i> ' + registro['descricao'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="d-none d-lg-block" style="width: 110px">';
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
 * @date      14/06/2021
 */
async function getRegistroEditor(element) {
    $('#spinnerGeral').fadeIn(50);
    let registroID = $(element).find('.registroID').val();
    let registroTipo = parseInt($(element).find('.registroTipo').val());
    const registro = await getRegistroAJAX(
            registroID,
            registroTipo
            );
    if (registro['id'] > 0) {
        $('#cardListaErroLogTabela').find('.div-registro-active').removeClass('div-registro-active');
        $('#cardListaErroApiTabela').find('.div-registro-active').removeClass('div-registro-active');
        $(element).addClass('div-registro-active');
        controllerInterfaseGeralCardEditor.setEstadoInicial();
        $('#cardEditorTitulo').html('<i class="mdi mdi mdi-information-outline"></i> Erro Capturado #' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']));
        $('#cardEditorLabelID').html('#' + registro['id']);
        $('#cardEditorDataCadastro').html('<i class="mdi mdi-calendar-clock"></i> '+registro['dataCadastro']);
        $('#cardEditorLocal').val(registro['local']);
        $('#cardEditorDescricao').val(registro['descricao']);
        controllerInterfaseGeralCardEditor.setOpenAnimation();
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

////////////////////////////////////////////////////////////////////////////////
//                            - CARD RELATORIO -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi relatorio de acordo com item selecionado.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
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
 * INTERNAL FUNCTION
 * Retorna nome do mes baseado na data atual.
 * 
 * @author    Manoel Louro
 * @date      03/05/2021
 */
function getMesNome(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    monthName = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    return monthName[date.getMonth()];
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