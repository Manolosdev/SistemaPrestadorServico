/**
 * FUNCTION
 * Objeto responsavel pelas operações de funções dentro do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */

////////////////////////////////////////////////////////////////////////////////
//                  - CARD ATENDIMENTOS PENDENTE/FINALIZADOS -                //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Obtém quantidade de atendimentos pendentes/finalizados durante o mês atual
 * exibindo nos respesctivos card do SCRIPT.
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
async function getDashAtendimentoPadraoAtendimentoMesAtual() {
    //REQUEST
    const mesAtual = await getDashAtendimentoPadraoAtendimentoMesQuantidade(
            getDataFormatada() + '-01', getDataFormatada() + '-31');
    if (mesAtual) {
        $('#dashAtendimentoPadraoAtendimentoPendentes').html(mesAtual['pendentes']);
        animateContador($('#dashAtendimentoPadraoAtendimentoPendentes'));
        $('#dashAtendimentoPadraoAtendimentoFinalizados').html(mesAtual['finalizados']);
        animateContador($('#dashAtendimentoPadraoAtendimentoFinalizados'));
    }
}

////////////////////////////////////////////////////////////////////////////////
//                           - MEUS ATENDIMENTOS -                            //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi lista de atendimentos pendentes do usuario logado.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */
async function setDashAtendimentoPadraoMeusAtendimentos() {
    $('#dashAtendimentoPadraoMeuAtendimentoBlock').fadeIn(50);
    const registros = await getDashAtendimentoPadraoListaUsuarioPendenteAJAX();
    await sleep(300);
    if (registros && registros.length > 0) {
        $('#dashAtendimentoPadraoMeuAtendimentoTabela').html('');
        for (var i = 0; i < registros.length; i++) {
            $('#dashAtendimentoPadraoMeuAtendimentoTabela').append(setDashAtendimentoPadraoMeusAtendimentosHTML(registros[i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
    } else {
        $('#dashAtendimentoPadraoMeuAtendimentoTabela').html('<div class="col-12 text-center" style="padding-top: 180px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
    }
    $('#dashAtendimentoPadraoMeuAtendimentoBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi HTML dos registros de meus atendimentos
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
function setDashAtendimentoPadraoMeusAtendimentosHTML(registro, indice) {
    var html = '';
    var prioridade = '';
    switch (parseInt(registro['prioridade'])) {
        case 1:
            prioridade = '<i class="mdi mdi-alert text-muted" title="Prioridade do atendimento baixa"></i>';
            break;
        case 2:
            prioridade = '<i class="mdi mdi-alert text-warning" title="Prioridade do atendimento média"></i>';
            break;
        case 3:
            prioridade = '<i class="mdi mdi-alert-circle-outline text-danger" title="Prioridade do atendimento alta"></i>';
            break;
    }
    html += '<div class="d-flex no-block div-registro" style="' + (indice === 13 ? 'border-bottom: none;box-shadow: none;' : '') + 'margin-bottom: 1px;padding-left: 10px;padding-top: 7px;padding-bottom: 6px;cursor: pointer;animation: slide-up .3s ease" onclick="setCardAtendimentoEditor(' + registro['id'] + ', this)">';
    if (parseInt(registro['tipo']) === 1) {
        //ATENDIMENTO CLIENTE
        html += '<div class="text-truncate">';
        html += '    <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px"><i class="mdi mdi-account"></i> ' + registro['clienteCodigoISP'] + ' <span> - ' + registro['clienteNomeISP'] + '</span></p>';
        html += '</div>';
    } else {
        //ATENDIMENTO CAIXA
        html += '<div class="text-truncate">';
        html += '    <p class="color-default mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-wifi"></i> ' + registro['pontoAcessoNomeISP'] + '</p>';
        html += '</div>';
    }
    html += '   <div class="ml-auto d-flex">';
    //ESTADO DO REGISTRO
    html += '       <div class="text-truncate" style="margin-left: 10px;width: 37px">';
    switch (parseInt(registro['situacao'])) {
        case 0:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-danger" title="Atendimento pendente"></i> ' + prioridade + '</p>';
            break;
        case 1:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-orange" title="Atendimento em resolução"></i> ' + prioridade + '</p>';
            break;
        case 2:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-info" title="Atendimento em análise"></i> ' + prioridade + '</p>';
            break;
        case 3:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-muted" title="Atendimento aguardando resposta"></i> ' + prioridade + '</p>';
            break;
        case 4:
            html += '   <p class="mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-flag text-warning" title="Atendimento aguardando informação interna"></i> ' + prioridade + '</p>';
            break;
        case 5:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-success" title="Atendimento concluído"></i> ' + prioridade + '</p>';
            break;
        case 6:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-dark" title="Atendimento sem contato"></i> ' + prioridade + '</p>';
            break;
    }
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                            - MEU DEPARTAMENTO -                            //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi lista de atendimentos pendentes relacionados ao departamento do 
 * usuario logado.
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
async function setDashAtendimentoPadraoMeuDepartamento() {
    $('#dashAtendimentoPadraoMeuDepartamentoBlock').fadeIn(50);
    const listaRegistro = await getDashAtendimentoPadraoMeuDepartamentoAJAX();
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#dashAtendimentoPadraoMeuDepartamentoTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#dashAtendimentoPadraoMeuDepartamentoTabela').append(setDashAtendimentoPadraoMeuDepartamentoHTML(listaRegistro['listaRegistro'][i]));
            if (i < 15) {
                await sleep(50);
            }
        }
    } else {
        $('#dashAtendimentoPadraoMeuDepartamentoTabela').html('<div class="col-12 text-center" style="padding-top: 230px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
    }
    $('#dashAtendimentoPadraoMeuDepartamentoBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi HTML dos registros de atendimentos relacionados ao meu departamento.
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
function setDashAtendimentoPadraoMeuDepartamentoHTML(registro) {
    var html = '';
    var prioridade = '';
    switch (parseInt(registro['prioridade'])) {
        case 1:
            prioridade = 'situacaoBaixo';
            break;
        case 2:
            prioridade = 'situacaoMedio';
            break;
        case 3:
            prioridade = 'situacaoAlto';
            break;
    }
    html += '<div class="d-flex no-block ' + prioridade + ' div-registro" style="margin-bottom: 1px;padding-left: 10px;padding-top: 8px;padding-bottom: 6px;cursor: pointer;animation: slide-up .3s ease" onclick="setCardAtendimentoEditor(' + registro['id'] + ', this)">';
    html += '   <div class="d-none d-sm-block" style="margin-right: 5px;width: 45px">';
    html += '       <p class="color-default font-12" style="margin-bottom: 0px">#' + (parseInt(registro['id']) > 9 ? registro['id'] : '0' + registro['id']) + '</p>';
    html += '   </div>';
    if (parseInt(registro['tipo']) === 1) {
        //ATENDIMENTO CLIENTE
        html += '<div class="text-truncate">';
        html += '    <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px"><i class="mdi mdi-account"></i> ' + registro['clienteCodigoISP'] + ' <span> - ' + registro['clienteNomeISP'] + '</span></p>';
        html += '</div>';
    } else {
        //ATENDIMENTO CAIXA
        html += '<div class="text-truncate">';
        html += '    <p class="color-default mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-wifi"></i> ' + registro['pontoAcessoNomeISP'] + '</p>';
        html += '</div>';
    }
    html += '   <div class="ml-auto d-flex">';
    //CATEGORIA
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 230px">';
    html += '           <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px"> ' + registro['descricaoCategoria'] + '</p>';
    html += '       </div>';
    //ESTADO DO REGISTRO
    html += '       <div class="text-truncate" style="margin-left: 10px;width: 105px">';
    switch (parseInt(registro['situacao'])) {
        case 0:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-danger"></i> Pendente</p>';
            break;
        case 1:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-orange"></i> Em resolução</p>';
            break;
        case 2:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-info"></i> Em análise</p>';
            break;
        case 3:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-muted"></i> Aguar. resposta</p>';
            break;
        case 4:
            html += '   <p class="mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-flag text-warning"></i> Aguar. inf. interna</p>';
            break;
        case 5:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-success"></i> Concluído</p>';
            break;
        case 6:
            html += '   <p class="mb-0 font-12" style="margin-bottom: 0px"><i class="mdi mdi-flag text-dark"></i> Sem contato</p>';
            break;
    }
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                               - SEMESTRAL -                                //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi lista de atendimentos relacionados ao usuário no periodo do ultimo 
 * semestre
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
async function setDashAtendimentoPadraoSemestral() {
    var semestre = [];
    var total = 0;
    for (var i = 1; i <= 6; i++) {
        registro = await getDashAtendimentoPadraoAtendimentoMesQuantidade(getDataFormatada(-i) + '-01', getDataFormatada(-i) + '-31');
        total += (registro['pendentes'] + registro['finalizados']);
        semestre.push(registro);
    }
    //REQUEST
    $('#dashAtendimentoPadraoTotalAtendimento').html(total);
    animateContador($('#dashAtendimentoPadraoTotalAtendimento'));
    $('#dashAtendimentoPadraoSemestralTabela').html('');
    new Chartist.Bar('#dashAtendimentoPadraoSemestralTabela', {
        labels: [getMesNome(6).substring(0, 3), getMesNome(5).substring(0, 3), getMesNome(4).substring(0, 3), getMesNome(3).substring(0, 3), getMesNome(2).substring(0, 3), getMesNome(1).substring(0, 3)],
        series: [
            [semestre[5]['pendentes'], semestre[4]['pendentes'], semestre[3]['pendentes'], semestre[2]['pendentes'], semestre[1]['pendentes'], semestre[0]['pendentes']],
            [semestre[5]['finalizados'], semestre[4]['finalizados'], semestre[3]['finalizados'], semestre[2]['finalizados'], semestre[1]['finalizados'], semestre[0]['finalizados']]
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
    $('#dashAtendimentoPadraoSemestralBlock').fadeOut(50);
}

////////////////////////////////////////////////////////////////////////////////
//                           - INTERNAL FUNCTIONS -                           //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna nome do mes baseado na data atual.
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
function getMesNome(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    monthName = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    return monthName[date.getMonth()];
}

/**
 * INTERNAL FUNCTION
 * Retorna data no formato YYYY-MM adicionando/removendo mês informado por 
 * parametro da data atual.
 * 
 * @link      https://stackoverflow.com/questions/32192922/how-do-i-get-a-date-in-yyyy-mm-dd-format
 * @author    Manoel Louro
 * @date      15/10/2020
 */
function getDataFormatada(adicionarMes = 0) {
    let d = new Date();
    d.setMonth(d.getMonth() + adicionarMes);
    const month = d.getMonth() < 9 ? '0' + (d.getMonth() + 1) : d.getMonth() + 1;
    return `${d.getFullYear()}-${month}`;
}

/**
 * INTERNAL FUNCTION
 * Aninação de contagem através de elemento informado
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
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

