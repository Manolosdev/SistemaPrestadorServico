/* 
 * DASHBOARD
 * 
 * Template dashboard de analise de creditos efetuado pelo sistema.
 *
 * @author    Manoel Louro
 * @data      02/10/2019
 */

/**
 * FUNCTION
 * Inicializa o dashboard.
 * 
 * @author    Manoel Louro
 * @data      02/10/2019
 */
async function initAnaliseCreditoScript() {
    initAnaliseCreditoHTML();
    //INIT COMPONENTES
    await setAnaliseCreditoQuadroUm();
    await setAnaliseCreditoQuadroDois();

}

////////////////////////////////////////////////////////////////////////////////
//                                - FUNCTIONS -                               //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Construção do HTML do template e dependencias
 * 
 * @author    Manoel Louro
 * @data      02/10/2019
 */
function initAnaliseCreditoHTML() {
    html = '';
    html += '<div class="row">';
    html += '   <div class="col-lg-9 col-md-12">';
    html += '       <div class="card">';
    html += '           <div class="card-body" style="height: 400px">';
    html += '               <h4 class="card-title" style="margin-bottom: 15px">Consultas SCPC</h4>';
    html += '               <div class="row">';
    html += '                   <div class="col-12" id="analise_credito_quadro_um" style="height: 320px">';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-sm-12 col-lg-3" style="min-height:400px;max-height:400px;margin-bottom: 20px">';
    html += '       <div class="col-12 p-0" style="height: 50%">';
    html += '           <div class="card bg-light mb-0" style="height: 100%">';
    html += '               <div class="card-body">';
    html += '                   <div class="row">';
    html += '                       <div class="col-md-12">';
    html += '                           <p class="font-24" style="margin-bottom: 10px">Consultas hoje</p>';
    html += '                           <h1 class="display-1 text-right" style="margin-bottom: 0px" id="analise_credito_quantidade_total"><i class="mdi mdi-arrow-up display-4 text-info"></i>0</h1>';
    html += '                       </div>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '       <div class="col-12 p-0" style="height: 25%">';
    html += '           <div class="card mb-0" style="height: 100%">';
    html += '               <div class="card-body" style="padding-top: 25px">';
    html += '                   <div class="row">';
    html += '                       <div class="col-md-12">';
    html += '                           <div class="d-flex no-block align-items-center">';
    html += '                               <div>';
    html += '                                   <p class="font-16" style="margin-bottom: 5px"><i class="mdi mdi-account-check font-20"></i> Documentos aprovadas</p>';
    html += '                               </div>';
    html += '                               <div class="ml-auto">';
    html += '                                   <h1 class="font-light text-right mb-0" id="analise_credito_label_aprovado">0</h1>';
    html += '                               </div>';
    html += '                           </div>';
    html += '                       </div>';
    html += '                       <div class="col-12">';
    html += '                           <div class="progress">';
    html += '                               <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
    html += '                           </div>';
    html += '                       </div>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '       <div class="col-12 p-0" style="height: 25%">';
    html += '           <div class="card mb-0" style="height: 100%">';
    html += '               <div class="card-body" style="padding-top: 5px">';
    html += '                   <div class="row">';
    html += '                       <div class="col-md-12">';
    html += '                           <div class="d-flex no-block align-items-center">';
    html += '                               <div>';
    html += '                                   <p class="font-16" style="margin-bottom: 5px"><i class="mdi mdi-account-alert font-20"></i> Documentos recusadas</p>';
    html += '                               </div>';
    html += '                               <div class="ml-auto">';
    html += '                                   <h1 class="font-light text-right mb-0" id="analise_credito_label_recusado">0</h1>';
    html += '                               </div>';
    html += '                           </div>';
    html += '                       </div>';
    html += '                       <div class="col-12">';
    html += '                           <div class="progress">';
    html += '                               <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
    html += '                           </div>';
    html += '                       </div>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';

    $('.container-fluid').append(html);
}

/**
 * FUNCTION 
 * Constroi grafico com numero de consultas aprovadas e recusadas durante 
 * periodo de tempo determinado.
 * 
 * @author    Manoel Louro
 * @data      02/10/2019
 */
async function setAnaliseCreditoQuadroUm() {
    const retorno = await getAnaliseCreditoDashboardGraficoAJAX();
    if (retorno['aprovado']) {
        var data = retorno['data'];
        var aprovado = retorno['aprovado'];
        var recusado = retorno['recusado'];
        var d = new Date();
        new Chartist.Bar('#analise_credito_quadro_um', {
            labels: [data[11], data[10], data[9], data[8], data[7], data[6], data[5], data[4], data[3], data[2], data[1], data[0]],
            series: [
                [aprovado[11], aprovado[10], aprovado[9], aprovado[8], aprovado[7], aprovado[6], aprovado[5], aprovado[4], aprovado[3], aprovado[2], aprovado[1], aprovado[0]],
                [recusado[11], recusado[10], recusado[9], recusado[8], recusado[7], recusado[6], recusado[5], recusado[4], recusado[3], recusado[2], recusado[1], recusado[0]]
            ]
        }, {
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function (value) {
                    return (value / 1);
                },
                scaleMinSpace: 55
            },
            axisX: {
                showGrid: true
            },
            plugins: [
                Chartist.plugins.tooltip()
            ],
            seriesBarDistance: 1,
            chartPadding: {
                top: 15,
                right: 15,
                bottom: 5,
                left: 0
            }
        }).on('draw', function (data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 25px'
                });
            }
        });
    } else {
        $('#analise_credito_quadro_um').html('<small>Nenhum registro encontrado</small>');
    }
}

/**
 * FUNCTION 
 * Constroi elemento de ilustração de numero de requisições totais, aprovadas e 
 * recusadas na data atual.
 * 
 * @author    Manoel Louro
 * @data      02/10/2019
 */
async function setAnaliseCreditoQuadroDois() {
    //REQUEST
    const retorno = await getAnaliseCreditoDashboardHojeAJAX();
    //SET
    if (retorno['total']) {
        //TOTAL
        $('#analise_credito_label_aprovado').html('' + retorno['aprovado']);
        //APROVADO
        $('#analise_credito_label_recusado').html('' + retorno['recusado']);
        //RECUSADO
        $('#analise_credito_quantidade_total').html('<i class="mdi mdi-arrow-up display-4 text-info"></i>' + retorno['total']);
    }
}

////////////////////////////////////////////////////////////////////////////////
//                                - REQUEST -                                 //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUISIÇÃO AJAX
 * Retorna quantidade de usuarios cadastrados no sistema: total, ativos e inativos.
 * 
 * @author    Manoel Louro
 * @data      02/08/2019
 */
function getAnaliseCreditoDashboardHojeAJAX() {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/analiseCredito/getAnaliseCreditoDashboardHojeDASH',
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
 * REQUISIÇÃO AJAX
 * Retorna quantidade de usuarios cadastrados no sistema: total, ativos e inativos.
 * 
 * @author    Manoel Louro
 * @data      02/08/2019
 */
function getAnaliseCreditoDashboardGraficoAJAX() {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/analiseCredito/getAnaliseCreditoDashboardGraficoDASH',
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

//START
initAnaliseCreditoScript();