/* 
 * DASHBOARD
 * 
 * Template dashboard de requisições redirecionadas ao almoxarifado.
 *
 * @author    Manoel Louro
 * @data      21/08/2019
 */

/**
 * FUNCTION
 * Inicializa os dashboard.
 * 
 * @author    Manoel Louro
 * @data      31/07/2019
 */
async function initRequisicaoAlmoxarifadoScript() {
    initRequisicaoAlmoxarifadoHTML();
    await setRequisicaoAlmoxarifadoQuadroUm();
    await setRequisicaoAlmoxarifadoQuadroDois();
    setInterval(async function () {
        await setRequisicaoAlmoxarifadoQuadroUm();
        await setRequisicaoAlmoxarifadoQuadroDois();
    }, 60000);
}

////////////////////////////////////////////////////////////////////////////////
//                                - FUNCTIONS -                               //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Construção do HTML do template e dependencias.
 * 
 * @author    Manoel Louro
 * @data      21/08/2019
 */
function initRequisicaoAlmoxarifadoHTML() {
    html = '';
    html += '<div class="row">';
    html += '   <div class="col-lg-9 col-md-12">';
    html += '       <div class="card">';
    html += '           <div class="card-body" style="height: 400px">';
    html += '               <h4 class="card-title" style="margin-bottom: 15px">Requisições por Cargo</h4>';
    html += '               <div class="row">';
    html += '                   <div class="col-12" id="requisicao_almoxarifado_quadro_um" style="height: 320px">';
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
    html += '                           <p class="font-24" style="margin-bottom: 10px">Requisições hoje</p>';
    html += '                           <h1 class="display-1 text-right" style="margin-bottom: 0px" id="requisicao_almoxarifado_quantidade_total"><i class="mdi mdi-arrow-up display-4 text-info"></i>0</h1>';
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
    html += '                                   <p class="font-16" style="margin-bottom: 5px"><i class="mdi mdi-calendar-check font-20"></i> Requisições pendentes</p>';
    html += '                               </div>';
    html += '                               <div class="ml-auto">';
    html += '                                   <h1 class="font-light text-right mb-0" id="requisicao_almoxarifado_label_pendente">0</h1>';
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
    html += '       <div class="col-12 p-0" style="height: 25%">';
    html += '           <div class="card mb-0" style="height: 100%">';
    html += '               <div class="card-body" style="padding-top: 5px">';
    html += '                   <div class="row">';
    html += '                       <div class="col-md-12">';
    html += '                           <div class="d-flex no-block align-items-center">';
    html += '                               <div>';
    html += '                                   <p class="font-16" style="margin-bottom: 5px"><i class="mdi mdi-calendar-clock font-20"></i> Requisições prontas</p>';
    html += '                               </div>';
    html += '                               <div class="ml-auto">';
    html += '                                   <h1 class="font-light text-right mb-0" id="requisicao_almoxarifado_label_prontas">0</h1>';
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
    html += '   </div>';
    html += '</div>';

    $('.container-fluid').append(html);
}

/**
 * FUNCTION
 * Constroi quadro TOP com informações dos registros dentro do sistema.
 * 
 * @author    Manoel Louro
 * @data      05/08/2019
 */
async function setRequisicaoAlmoxarifadoQuadroUm() {
    //REQUEST
    const resultado = await getRequisicaoAlmoxarifadoPorCargoHojeAJAX();
    if (resultado['cargo'].length > 1) {
        $('#requisicao_almoxarifado_quadro_um').html('');
        var chart = new Chartist.Line('#requisicao_almoxarifado_quadro_um', {
            labels: resultado['cargo'],
            series: [resultado['quantidade']]
        }, {
            low: 0,
            showArea: true,
            fullWidth: true,
            plugins: [
                Chartist.plugins.tooltip()
            ],
            axisY: {
                onlyInteger: true,
                scaleMinSpace: 40,
                offset: 20
            },
            chartPadding: {
                right: 35
            }
        });
    } else {
        $('#requisicao_almoxarifado_quadro_um').html('<small>Poucos registros encontrados para construção de gráfico</small>');
    }
}

/**
 * FUNCTION
 * Constroi quadro UM com informações de usuarios e solicitações no sistema.
 * 
 * @author    Manoel Louro
 * @data      01/08/2019
 */
async function setRequisicaoAlmoxarifadoQuadroDois() {
    //REQUEST
    const retorno = await getRequisicaoAlmoxarifadoRequisicoesQuantidadeAJAX();
    //REQUEST
    if (retorno.length) {
        //REQUISIÇÕES PENDENTES ------------------------------------------------
        $('#requisicao_almoxarifado_label_pendente').html('' + retorno[0]);
        //REQUISIÇÕES PRONTAS --------------------------------------------------
        $('#requisicao_almoxarifado_label_prontas').html('' + retorno[1]);
        //QUANTIDADE TODAL
        $('#requisicao_almoxarifado_quantidade_total').html('<i class="mdi mdi-arrow-up display-4 text-info"></i>' + retorno[2]);
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
function getRequisicaoAlmoxarifadoPorCargoHojeAJAX() {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/requisicao/getRequisicaoAlmoxarifadoCargoDASH',
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
 * Retorna quantidade de requisições pendentes e finalizadas no sistema.
 * 
 * @author    Manoel Louro
 * @data      21/08/2019
 */
function getRequisicaoAlmoxarifadoRequisicoesQuantidadeAJAX() {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/requisicao/getRequisicaoAlmoxarifadoQuantidadeDASH',
            type: 'post',
            dataType: 'json'
        }).done(function (resultado) {
            if (resultado.length !== undefined) {
                resolve(resultado);
            } else {
                reject();
            }
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
 * Obtém quantidade de usuarios por cargo.
 * 
 * @author    Manoel Louro
 * @data      02/08/2019
 */
async function getDesenvolvedorPadraoEstatisticaUsuarioCargoAJAX() {
    //AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cargo/getUsuariosCargoDASH',
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
initRequisicaoAlmoxarifadoScript();