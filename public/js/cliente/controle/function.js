/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do controle de registro.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
async function setDependencia() {
    //CIDADES
    const cidade = await getListaCidadeAJAX();
    if (cidade.length) {
        for (var i = 0; i < cidade.length; i++) {
            $('#cardListaPesquisaCidade').append('<option value="' + cidade[i]['id'] + '">' + cidade[i]['nome'] + '</ption>');
        }
    }
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de registro encontrados.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */
async function setEstatistica() {
    //REGISTROS POR DEPARTAMENTO
    const estatistica = await getEstatisticaPorCidadeAJAX();
    if (estatistica['cidade']) {
        chart.data.labels = estatistica['cidade'];
        chart.data.datasets[0].data = estatistica['quantidade'];
        chart.update();
    }
    //LOG ERROS
    const totalRegistro = await getTotalRegistroAJAX();
    $('#cardEstatisticaTotal').html(totalRegistro);
    animateContador($('#cardEstatisticaTotal'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
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
            $('#cardListaTabela').append(setRegistroControleHTML(listaRegistro['listaRegistro'][i], i));
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
 * @date      15/07/2021
 */
function setRegistroControleHTML(registro, tabelaIndex = 1) {
    var sleep = parseFloat((tabelaIndex / 20) + .2);
    var html = '';
    html = '<div class="d-flex no-block div-registro" style="padding-left: 10px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease" onclick="getCardClienteEditor(' + registro['id'] + ', this)">';
    html += '   <input hidden class="registroID" value="' + registro['id'] + '">';
    html += '   <div style="margin-right: 10px;width: 52px">';
    html += '       <p class="color-default mb-0 font-11">#' + registro['id'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-xl-block" style="margin-right: 5px;width: 98px">';
    if (registro['tipoPessoa'] == 'f') {
        html += '   <p class="text-truncate color-default mb-0 font-11"><i class="mdi mdi-account-box"></i> Pessoa Física</p>';
    } else {
        html += '   <p class="text-truncate color-default mb-0 font-11"><i class="mdi mdi-account-box"></i> Pessoa Jurídica</p>';
    }
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-md-block" style="width: 125px">';
    html += '       <p class="text-truncate color-default mb-0 font-11"><i class="mdi mdi-account-card-details"></i> ' + registro['documento'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="text-truncate color-default mb-0 font-11"><i class="mdi mdi-account"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 150px">';
    html += '           <p class="text-truncate color-default mb-0 font-11"><i class="mdi mdi-home"></i> ' + registro['cidadeNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 85px">';
    html += '           <p class="text-truncate color-default mb-0 font-11"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                           - INTERNAL FUNCTION -                            //
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