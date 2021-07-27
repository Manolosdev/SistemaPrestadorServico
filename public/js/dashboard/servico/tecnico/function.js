/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */

/**
 * FUNCTION
 * Constroi lista de registros de serviços direcionados ao usuario logado.
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */
async function setDashCardServicoTecnicoListaServico() {
    $('#dashAtendimentoPadraoMeuDepartamentoBlock').fadeOut(50);
    $('#dashServicoTecnicoTabelaServico').html('<div style="padding-top: 90px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    const listaRegistro = await setDashCardServicoTecnicoListaServicoAJAX();
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#dashServicoTecnicoTabelaServico').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#dashServicoTecnicoTabelaServico').append(setDashCardServicoTecnicoListaServicoHTML(listaRegistro['listaRegistro'][i]));
            if (i < 15) {
                await sleep(50);
            }
        }
    } else {
        $('#dashServicoTecnicoTabelaServico').html('<div class="col-12 text-center" style="padding-top: 185px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
    }
    $('#dashAtendimentoPadraoMeuDepartamentoBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi elemento HTML de acordo com registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
 */
function setDashCardServicoTecnicoListaServicoHTML(registro) {
    var html = '';
    var serviceName = 'Erro interno';
    var functionName = '';
    switch (registro['tipoServico']) {
        case '1':
            serviceName = '<i class="mdi mdi-plus-network"></i> Cabeamento Adicional';
            functionName = 'onclick="getCardServicoCabeamentoAdicionalConsultar(' + registro['id'] + ',this)"';
            break;
        case '2':
            serviceName = '<i class="mdi mdi-access-point-network"></i> Mudança de Ponto';
            functionName = 'onclick="getCardServicoTrocaPontoConsultar(' + registro['id'] + ',this)"';
            break;
    }
    html += '<div class="d-flex no-block div-registro" style="margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;padding-left: 12px;cursor: pointer;animation: slide-up .3s ease" ' + functionName + '>';
    html += '   <div class="d-none d-sm-block text-truncate" style="width: 50px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px">#' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate" style="width: 145px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px">' + serviceName + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-sm-block">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px"><i class="mdi mdi-account-box"></i> ' + registro['clienteNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 155px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-home"></i> ' + registro['cidadeNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 115px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataAgendamento'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate" style="margin-left: 10px;width: 104px">';
    switch (parseInt(registro['estadoRegistro'])) {
        case 1:
            html += '   <p class="text-danger mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> pag. pendente</p>';
            break;
        case 2:
            html += '   <p class="text-info mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> pag. efetuado</p>';
            break;
        case 3:
            html += '   <p class="text-cyan mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> serviço agendado</p>';
            break;
        case 4:
            html += '   <p class="text-success mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> serviço concluído</p>';
            break;
        case 10:
            html += '   <p class="text-muted mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> serviço cancelado</p>';
            break;
        default:
            html += '   <p class="text-dark mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> Erro</p>';
            break;
    }
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de registros vinculados ao usuario 
 * informado.
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
 */
async function setDashCardServicoTecnicoQuantidade() {
    //QUANTIDADE DE REGISTRO
    const ultimoMes = await setDashCardServicoTecnicoQuantidadeUltimoMesAJAX(null, null);
    $('#dashServicoTecnicoTotalVinculadosMes').html(ultimoMes);
    animateContador($('#dashServicoTecnicoTotalVinculadosMes'));
    const totalRegistro = await setDashCardServicoTecnicoQuantidadeUltimoMesAJAX('01/01/2000', '01/01/2050');
    $('#dashServicoTecnicoTotalServico').html(totalRegistro);
    animateContador($('#dashServicoTecnicoTotalServico'));
    //GRAFICO
    const registro = await setDashCardServicoTecnicoEstatisticaSemestralAJAX();
    var registroTotal = [0, 0, 0, 0, 0, 0];
    for (var i = 0; i < 6; i++) {
        registroTotal[i] = parseInt(registro[0][i]) + parseInt(registro[1][i]);
    }
    console.log(registroTotal);
    $('#dashServicoTecnicoTabelaSemestral').html('');
    new Chartist.Bar('#dashServicoTecnicoTabelaSemestral', {
        labels: [getMesNome(6).substring(0, 3), getMesNome(5).substring(0, 3), getMesNome(4).substring(0, 3), getMesNome(3).substring(0, 3), getMesNome(2).substring(0, 3), getMesNome(1).substring(0, 3)],
        series: [
            registroTotal
        ]
    }, {
        seriesBarDistance: 20,
        reverseData: true,
        horizontalBars: true,
        axisY: {
            onlyInteger: true,
            offset: 20
        },
        axisX: {
            onlyInteger: true,
            offset: 20
        }
    });
    $('#dashServicoTecnicoTabelaSemestralBlock').fadeOut(50);
}

////////////////////////////////////////////////////////////////////////////////
//                            - INTERNAL FUNCTION -                           //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION INTERNAL
 * Aninação de contagem através de elemento informado
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
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
 * INTERNAL FUNCTION
 * Retorna nome do mes baseado na data atual.
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
 */
function getMesNome(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    monthName = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    return monthName[date.getMonth()];
}

