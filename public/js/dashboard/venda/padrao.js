/* 
 * DASHBOARD
 * 
 * Template dashboard de VENDAS efetuadas pelo usuário.
 *
 * @author    Manoel Louro
 * @data      01/11/2019
 */

/**
 * FUNCTION
 * Inicializa o dashboard.
 * 
 * @author    Manoel Louro
 * @data      01/11/2019
 */
async function initVendaPadraoScript() {
    initVendaPadraoHTML();
    await setVendaPadraoQuadroTop();
    await setVendaPadraoTopVendedores();
    await setVendaPadraoTopCidade();
    await getVendaPadraoGraficoSemestral();
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
 * @data      01/11/2019
 */
function initVendaPadraoHTML() {
    html = '';
    //QUADRO TOP
    html += '<div class="row" style="position: relative">';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-success text-white">';
    html += '           <div class="divLoadBlock" id="vendaPadraoQuadroTopPlanoBlock" style="display: block"></div>';
    html += '           <div class="card-body">';
    html += '               <div class="d-flex flex-row text-truncate">';
    html += '                   <div style="margin-right: 10px">';
    html += '                       <i class="mdi mdi-shopping" style="font-size: 30px"></i>';
    html += '                   </div>';
    html += '                   <div class="align-self-center ">';
    html += '                       <h4 style="margin-bottom: 2px">Planos</h4>';
    html += '                       <span>Este mês</span>';
    html += '                   </div>';
    html += '                   <div class="ml-auto align-self-center text-right">';
    html += '                       <h3 class="font-medium mb-0" id="vendaPadraoQuadroTopPlano" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaPadraoQuadroTopPlanoValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-info text-white">';
    html += '           <div class="divLoadBlock" id="vendaPadraoQuadroTopRoteadorBlock" style="display: block"></div>';
    html += '           <div class="card-body">';
    html += '               <div class="d-flex flex-row text-truncate">';
    html += '                   <div style="margin-right: 10px">';
    html += '                       <i class="mdi mdi-router-wireless" style="font-size: 30px"></i>';
    html += '                   </div>';
    html += '                   <div class="align-self-center">';
    html += '                       <h4 style="margin-bottom: 2px">Roteadores</h4>';
    html += '                       <span>Este mês</span>';
    html += '                   </div>';
    html += '                   <div class="ml-auto align-self-center text-right">';
    html += '                       <h3 class="font-medium mb-0" id="vendaPadraoQuadroTopRoteador" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaPadraoQuadroTopRoteadorValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-primary text-white">';
    html += '           <div class="divLoadBlock" id="vendaPadraoQuadroTopTelefoniaBlock" style="display: block"></div>';
    html += '           <div class="card-body">';
    html += '               <div class="d-flex flex-row text-truncate">';
    html += '                   <div style="margin-right: 10px">';
    html += '                       <i class="mdi mdi-phone" style="font-size: 30px"></i>';
    html += '                   </div>';
    html += '                   <div class="align-self-center">';
    html += '                       <h4 style="margin-bottom: 2px">Telefonia</h4>';
    html += '                       <span>Este mês</span>';
    html += '                   </div>';
    html += '                   <div class="ml-auto align-self-center text-right">';
    html += '                       <h3 class="font-medium mb-0" id="vendaPadraoQuadroTopTelefonia" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaPadraoQuadroTopTelefoniaValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-cyan text-white">';
    html += '           <div class="divLoadBlock" id="vendaPadraoQuadroTopVendaOnlineBlock" style="display: block"></div>';
    html += '           <div class="card-body">';
    html += '               <div class="d-flex flex-row text-truncate">';
    html += '                   <div style="margin-right: 10px">';
    html += '                       <i class="mdi mdi-internet-explorer" style="font-size: 30px"></i>';
    html += '                   </div>';
    html += '                   <div class="align-self-center">';
    html += '                       <h4 style="margin-bottom: 2px">Vendas online</h4>';
    html += '                       <span>Este mês</span>';
    html += '                   </div>';
    html += '                   <div class="ml-auto align-self-center text-right">';
    html += '                       <h3 class="font-medium mb-0" id="vendaPadraoQuadroTopVendaOnline" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaPadraoQuadroTopVendaOnlineValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<div class="row">';
    html += '   <div class="col-md-6 col-lg-3 order-md-2 order-lg-1">';
    html += '       <div class="card border-default">';
    html += '           <div class="divLoadBlock" id="vendaPadraoTopVendedoresBlock" style="display: block"></div>';
    html += '               <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px; padding-top: 15px">';
    html += '                   <div class="d-flex align-items-center">';
    html += '                       <div class="text-truncate">';
    html += '                           <h4 class="page-title mb-0">Top Vendedores</h4>';
    html += '                       </div>';
    html += '                       <div class="ml-auto">';
    html += '                           <div class="row m-b-10">';
    html += '                           <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="vendaPadraoTopVendedoresSelect">';
    html += '                               <option value="' + getData(0).substring(0, 7) + '" selected="">Este Mês</option>';
    html += '                               <option value="' + getData(1).substring(0, 7) + '">' + getDataNome(1) + '</option>';
    html += '                               <option value="' + getData(2).substring(0, 7) + '">' + getDataNome(2) + '</option>';
    html += '                               <option value="' + getData(3).substring(0, 7) + '">' + getDataNome(3) + '</option>';
    html += '                               <option value="' + getData(4).substring(0, 7) + '">' + getDataNome(4) + '</option>';
    html += '                               <option value="' + getData(5).substring(0, 7) + '">' + getDataNome(5) + '</option>';
    html += '                           </select>';
    html += '                       </div>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding: 0px;max-height: 410px;min-height: 410px">';
    html += '               <div class="ctVendas" id="vendaPadraoTopVendedorGrafico" style="height: 390px;"></div>';
    html += '           </div>';
    html += '           <div class="card-body bg-light text-center" title="Exibir todos dos vendedores" style="padding: 5px;max-height: 30px;min-height: 30px;cursor: pointer" id="vendaPadraoMostrarCardTopVendedor">';
    html += '               <i class="mdi font-13 mdi-chevron-double-down"></i> <small>Mostrar todos <i class="mdi font-13 mdi-chevron-double-down"></i></small>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-md-12 col-lg-6 order-md-1 order-lg-2">';
    html += '       <div class="card border-default">';
    html += '           <div class="divLoadBlock" id="vendaPadraoTopCidadeBlock" style="display: block"></div>';
    html += '               <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px; padding-top: 12px">';
    html += '                   <div class="d-flex align-items-center">';
    html += '                       <div class="text-truncate">';
    html += '                           <h4 class="page-title mb-0">Top Cidades</h4>';
    html += '                       </div>';
    html += '                       <div class="ml-auto">';
    html += '                           <div class="row m-b-10">';
    html += '                           <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="vendaPadraoTopCidadeSelect">';
    html += '                               <option value="' + getData(0).substring(0, 7) + '" selected="">Este Mês</option>';
    html += '                               <option value="' + getData(1).substring(0, 7) + '">' + getDataNome(1) + '</option>';
    html += '                               <option value="' + getData(2).substring(0, 7) + '">' + getDataNome(2) + '</option>';
    html += '                               <option value="' + getData(3).substring(0, 7) + '">' + getDataNome(3) + '</option>';
    html += '                               <option value="' + getData(4).substring(0, 7) + '">' + getDataNome(4) + '</option>';
    html += '                               <option value="' + getData(5).substring(0, 7) + '">' + getDataNome(5) + '</option>';
    html += '                           </select>';
    html += '                       </div>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding-top: 0px;max-height: 410px;min-height: 410px;padding-left: 15px">';
    html += '               <div class="ctVendas" id="vendaPadraoTopCidadeGrafico" style="height: 410px"></div>';
    html += '           </div>';
    html += '           <div class="card-body bg-light text-center" title="Relatorio geral de vendas por cidade" style="padding: 5px;max-height: 30px;min-height: 30px;cursor: pointer" id="vendaPadraoMostrarCardCidadeRelatorio">';
    html += '               <i class="mdi font-13 mdi-chevron-double-down"></i> <small>Exibir mais <i class="mdi mdi-chevron-double-down font-13"></i></small>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-md-6 col-lg-3 order-md-3 order-lg-3">';
    html += '       <div class="card border-default">';
    html += '           <div class="card-body" style="min-height: 393px;max-height: 393px;padding: 0px;padding-left: 20px;padding-right: 15px;padding-top: 10px">';
    html += '               <div class="ctVendas" id="vendaPadraoGraficoIndicador" style="height: 370px"></div>';
    html += '           </div>';
    html += '       </div>';
    html += '       <div class="card card-hover bg-dark text-white" id="vendaPadraoIndicadorUsuarioCard">';
    html += '           <div class="divLoadBlock" id="vendaPadraoIndicadorUsuarioBlock" style="display: block"></div>';
    html += '           <div class="card-body">';
    html += '               <div class="d-flex flex-row text-truncate">';
    html += '                   <div style="margin-right: 10px">';
    html += '                       <i class="mdi mdi-shopping" style="font-size: 30px"></i>';
    html += '                   </div>';
    html += '                   <div class="align-self-center ">';
    html += '                       <span>últimos 30 dias</span>';
    html += '                       <h4 style="margin-bottom: 2px">Planos</h4>';
    html += '                   </div>';
    html += '                   <div class="ml-auto align-self-center text-right">';
    html += '                       <h3 class="font-medium mb-0" id="vendaPadraoIndicadorUsuario" style="font-size: 22px">0</h3>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<!-- CARD TOP VENDEDORES -->';
    html += '<div class="internalPage" style="display: none;" id="cardVendaPadraoTopVendedor">';
    html += '   <div class="col-12" style="max-width: 500px">';
    html += '        <div class="card border-default" style="margin: 10px" id="cardVendaPadraoTopVendedorCard">';
    html += '            <div class="divLoadBlock" id="cardVendaPadraoTopVendedorTotalBlock"></div>';
    html += '            <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px;padding-top: 15px">';
    html += '                <div class="d-flex align-items-center">';
    html += '                    <div class="text-truncate">';
    html += '                        <h4 class="page-title mb-0">Top Vendedores</h4>';
    html += '                    </div>';
    html += '                    <div class="ml-auto">';
    html += '                        <div class="row m-b-10">';
    html += '                            <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="cardVendaPadraoTopVendedorSelect">';
    html += '                               <option class="text-right" value="' + getData(0).substring(0, 7) + '" selected="">Este Mês</option>';
    html += '                               <option value="' + getData(1).substring(0, 7) + '">' + getDataNome(1) + '</option>';
    html += '                               <option value="' + getData(2).substring(0, 7) + '">' + getDataNome(2) + '</option>';
    html += '                               <option value="' + getData(3).substring(0, 7) + '">' + getDataNome(3) + '</option>';
    html += '                               <option value="' + getData(4).substring(0, 7) + '">' + getDataNome(4) + '</option>';
    html += '                               <option value="' + getData(5).substring(0, 7) + '">' + getDataNome(5) + '</option>';
    html += '                            </select>';
    html += '                        </div>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '            <div class="card-body bg-light" style="padding: 15px;padding-top: 12px">';
    html += '                <div class="col-12 p-0">';
    html += '                    <input class="form-control border-custom color-default mb-1" id="cardVendaPadraoTopVendedorPesquisa" placeholder="Localizar vendendor ..." maxlength="30" spellcheck="false" style="border-right: none" autocomplete="off">';
    html += '                </div>';
    html += '            </div>';
    html += '            <div class="scroll" style="height: 409px" id="cardVendaPadraoTopVendedorTabela">';
    html += '            </div>';
    html += '            <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">';
    html += '                <div class="row">';
    html += '                    <div class="col" style="max-width: 110px;padding-right: 0">';
    html += '                        <button id="cardVendaPadraoTopVendedorBack" onclick="$(\'#cardVendaPadraoTopVendedor\').fadeOut(50)" type="button" class="btn btn-dark" style="width: 70px"><i class="mdi mdi-arrow-left"></i></button>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    html += '<!-- CARD TOP CIDADES -->';
    html += '<div class="internalPage" style="display: none;" id="cardVendaPadraoCidadeRelatorio">';
    html += '   <div class="col-12" style="max-width: 530px">';
    html += '        <div class="card border-default" style="margin: 10px" id="cardVendaPadraoTopVendedorCard">';
    html += '            <div class="divLoadBlock" id="cardVendaPadraoCidadeRelatorioBlock"></div>';
    html += '            <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px;padding-top: 15px">';
    html += '                <div class="d-flex align-items-center">';
    html += '                    <div class="text-truncate">';
    html += '                        <h4 class="page-title mb-0">Top Cidades</h4>';
    html += '                    </div>';
    html += '                    <div class="ml-auto">';
    html += '                        <div class="row m-b-10">';
    html += '                            <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="cardVendaPadraoCidadeRelatorioSelect">';
    html += '                               <option class="text-right" value="' + getData(0).substring(0, 7) + '" selected="">Este Mês</option>';
    html += '                               <option value="' + getData(1).substring(0, 7) + '">' + getDataNome(1) + '</option>';
    html += '                               <option value="' + getData(2).substring(0, 7) + '">' + getDataNome(2) + '</option>';
    html += '                               <option value="' + getData(3).substring(0, 7) + '">' + getDataNome(3) + '</option>';
    html += '                               <option value="' + getData(4).substring(0, 7) + '">' + getDataNome(4) + '</option>';
    html += '                               <option value="' + getData(5).substring(0, 7) + '">' + getDataNome(5) + '</option>';
    html += '                            </select>';
    html += '                        </div>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '            <div class="card-body bg-light" style="padding: 15px;padding-top: 12px">';
    html += '                <div class="col-12 p-0">';
    html += '                    <input class="form-control border-custom color-default mb-1" id="cardVendaPadraoCidadeRelatorioPesquisa" placeholder="Localizar cidade ..." maxlength="30" spellcheck="false" style="border-right: none" autocomplete="off">';
    html += '                </div>';
    html += '            </div>';
    html += '            <div class="scroll" style="height: 409px" id="cardVendaPadraoCidadeRelatorioTabela">';
    html += '            </div>';
    html += '            <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">';
    html += '                <div class="row">';
    html += '                    <div class="col" style="max-width: 110px;padding-right: 0">';
    html += '                        <button id="cardVendaPadraoCidadeRelatorioBack" onclick="$(\'#cardVendaPadraoCidadeRelatorio\').fadeOut(50)" type="button" class="btn btn-dark" style="width: 70px"><i class="mdi mdi-arrow-left"></i></button>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    $('.container-fluid').append(html);
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    //INIT ELEMENTS
    new Chartist.Bar('#vendaPadraoGraficoIndicador', {
        labels: [getMesNome(5).substring(0, 3), getMesNome(4).substring(0, 3), getMesNome(3).substring(0, 3), getMesNome(2).substring(0, 3), getMesNome(1).substring(0, 3), getMesNome(0).substring(0, 3)],
        series: [
            [0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0]
        ]
    }, {
        seriesBarDistance: 25,
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
    //EVENTS
    $('#vendaPadraoTopVendedoresSelect').on('change', async function () {
        await setVendaPadraoTopVendedores();
    });
    $('#cardVendaPadraoTopVendedorSelect').on('change', async function () {
        await setVendaPadraoTopVendedoresTotal();
    });
    $('#vendaPadraoTopCidadeSelect').on('change', async function () {
        await setVendaPadraoTopCidade();
    });
    $('#cardVendaPadraoCidadeRelatorioSelect').on('change', async function () {
        await setVendaPadraoCidadeRelatorio();
    });
    $('#cardVendaPadraoTopVendedorPesquisa').on('keyup', function () {
        setVendaPadraoTopVendedorPesquisarNome();
    });
    $('#vendaPadraoMostrarCardTopVendedor').on('click', async function () {
        $('#cardVendaPadraoTopVendedor').fadeIn(100);
        await setVendaPadraoTopVendedoresTotal();
    });
    $('#vendaPadraoMostrarCardCidadeRelatorio').on('click', async function () {
        $('#cardVendaPadraoCidadeRelatorio').fadeIn(100);
        await setVendaPadraoCidadeRelatorio();
    });
    $('#vendaPadraoTopVendedorGrafico').html('<div style="padding: 15px;padding-top: 0px"><small class="text-muted flashit">Carregando registros ...</small></div>');
}

/**
 * FUNCTION 
 * Constroi lista de registro de indicadores de vendas relacionadas ao mes atual
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
async function setVendaPadraoQuadroTop() {
    var sleepValue = 0;
    const retorno = await getVendaPadraoQuadroTopAJAX();
    if (retorno[0]) {
        $('#vendaPadraoQuadroTopPlanoBlock').fadeOut(0);
        $('#vendaPadraoQuadroTopPlano').html(retorno[0][0]);
        $('#vendaPadraoQuadroTopPlanoValor').html((retorno[0][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaPadraoQuadroTopPlano'));
    }
    await sleep(sleepValue);
    if (retorno[1]) {
        $('#vendaPadraoQuadroTopRoteadorBlock').fadeOut(0);
        $('#vendaPadraoQuadroTopRoteador').html(retorno[1][0]);
        $('#vendaPadraoQuadroTopRoteadorValor').html((retorno[1][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaPadraoQuadroTopRoteador'));
    }
    await sleep(sleepValue);
    if (retorno[2]) {
        $('#vendaPadraoQuadroTopTelefoniaBlock').fadeOut(0);
        $('#vendaPadraoQuadroTopTelefonia').html(retorno[2][0]);
        $('#vendaPadraoQuadroTopTelefoniaValor').html((retorno[2][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaPadraoQuadroTopTelefonia'));
    }
    await sleep(sleepValue);
    if (retorno[3]) {
        $('#vendaPadraoQuadroTopVendaOnlineBlock').fadeOut(0);
        $('#vendaPadraoQuadroTopVendaOnline').html(retorno[3][0]);
        $('#vendaPadraoQuadroTopVendaOnlineValor').html((retorno[3][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaPadraoQuadroTopVendaOnline'));
    }
    await sleep(sleepValue);
}

/**
 * FUNCTION
 * Constroi tabela de registros de vendedores ordenados por numero de vendas.
 * 
 * @author    Manoel Louro
 * @date      30/05/2020
 */
async function setVendaPadraoTopVendedores() {
    $('#vendaPadraoTopVendedoresBlock').fadeIn(0);
    var tempo = 200;
    $('#vendaPadraoTopVendedorGrafico').html('<div style="padding: 15px;padding-top: 0px"><small class="text-muted flashit">Carregando registros ...</small></div>');
    const retorno = await getVendaPadraoTopVendedorAJAX();
    if (retorno.length) {
        $('#vendaPadraoTopVendedorGrafico').html('');
        for (var i = 0; i < 6; i++) {
            if (retorno[i]) {
                var registro = retorno[i];
                var html = '';
                html += '<div class="d-flex div-registro" style="cursor: pointer;padding: 10px;margin-top: 1px;padding-left: 15px;padding-right: 10px;animation: slide-up 1s ease">';
                html += '   <div style="padding-top: 14px;width: 25px">';
                html += '       <p class="mb-0"><b>' + (i + 1) + '</b></p>';
                html += '   </div>';
                html += '   <div style="margin-right: 10px;position: relative">';
                html += '       <img src="data:image/png;base64,' + registro['entidadeUsuario']['imagemPerfil'] + '" alt="user" class="rounded-circle img-user" height="47" width="47">';
                if (i === 0) {
                    html += '   <small style="position: absolute; right: -7px; top: -8px;color: yellow"><i class="mdi mdi-crown font-20"></i></small>';
                } else if (i === 1) {
                    html += '   <small class="text-muted" style="position: absolute; right: -7px; top: -8px"><i class="mdi mdi-crown font-20"></i></small>';
                } else if (i === 2) {
                    html += '   <small class="text-orange" style="position: absolute; right: -7px; top: -8px"><i class="mdi mdi-crown font-20"></i></small>';
                }
                if (registro['empresa'] == 'telecom') {
                    html += '   <small style="position: absolute; right: -4px; bottom: 3px"><img style="height: 15px" src="' + APP_HOST + '/public/template/assets/img/faviconTelecom.png"></small>';
                } else {
                    html += '   <small style="position: absolute; right: -4px; bottom: 3px"><img style="height: 15px" src="' + APP_HOST + '/public/template/assets/img/faviconConectividade.png"></small>';
                }
                html += '   </div>';
                html += '   <div class="text-truncate" style="padding-top: 11px">';
                html += '       <h5 class="userNome mb-0 text-truncate color-default font-11">' + registro['entidadeUsuario']['usuarioNome'] + '</h5>';
                html += '       <p class="userCargo mb-0 text-truncate text-muted font-11" style="max-height: 20px">' + registro['entidadeUsuario']['cargoNome'] + '</p>';
                html += '   </div>';
                html += '   <div class="d-flex ml-auto">';
                html += '       <div style="padding-top: 14px;width: 45px" title="Vendas de planos">';
                html += '           <p class="mb-0"><i class="mdi mdi-shopping "></i> ' + registro['quantidade'] + '</p>';
                html += '       </div>';
                html += '       <div style="padding-top: 14px;width: 45px" title="Vendas de roteadores">';
                html += '           <p class="mb-0"><i class="mdi mdi-router-wireless"></i> ' + registro['quantidadeVendaRoteador'] + '</p>';
                html += '       </div>';
                html += '       <div style="padding-top: 14px;width: 45px" title="Vendas de telefonia">';
                html += '           <p class="mb-0"><i class="mdi mdi-phone"></i> ' + registro['quantidadeVendaTelefonia'] + '</p>';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';
                $('#vendaPadraoTopVendedorGrafico').append(html);
                await sleep(tempo);
            }
        }
    } else {
        $('#vendaPadraoTopVendedorGrafico').html('<div style="padding: 15px;padding-top: 0px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    $('#vendaPadraoTopVendedoresBlock').fadeOut(150);
}

/**
 * FUNCTION
 * Constroi tabela de registros de vendedores ordenados por vendas.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
async function setVendaPadraoTopVendedoresTotal() {
    var tempo = 20;
    $('#cardVendaPadraoTopVendedorPesquisa').val('');
    $('#cardVendaPadraoTopVendedorTabela').html('<div style="padding: 15px"><small class="text-muted flashit">Obtendo registros ...</small></div>');
    $('#cardVendaPadraoTopVendedorTotalBlock').fadeIn(50);
    const retorno = await getVendaPadraoTopVendedorTotalAJAX();
    if (retorno.length) {
        $('#cardVendaPadraoTopVendedorTabela').html('');
        for (var i = 0; i < retorno.length; i++) {
            if (retorno[i]) {
                var registro = retorno[i];
                var html = '';
                var rank = (i + 1);
                html += '<div class="d-flex div-registro" style="cursor: pointer;padding: 10px;margin-top: 1px;padding-left: 12px;padding-right: 10px;animation: slide-up 1s ease">';
                html += '   <input hidden class="nome" value="' + registro['entidadeUsuario']['usuarioNome'] + '">';
                html += '   <div style="padding-top: 14px;width: 25px">';
                html += '       <p class="mb-0">' + (rank < 10 ? '0' + rank : rank) + '</p>';
                html += '   </div>';
                html += '   <div style="margin-right: 10px;position: relative">';
                html += '       <img src="data:image/png;base64,' + registro['entidadeUsuario']['imagemPerfil'] + '" alt="user" class="rounded-circle img-user" height="47" width="47">';
                if (i === 0) {
                    html += '   <small style="position: absolute; right: -7px; top: -8px;color: yellow"><i class="mdi mdi-crown font-20"></i></small>';
                } else if (i === 1) {
                    html += '   <small class="text-muted" style="position: absolute; right: -7px; top: -8px"><i class="mdi mdi-crown font-20"></i></small>';
                } else if (i === 2) {
                    html += '   <small class="text-orange" style="position: absolute; right: -7px; top: -8px"><i class="mdi mdi-crown font-20"></i></small>';
                }
                if (registro['empresa'] == 'telecom') {
                    html += '   <small style="position: absolute; right: -4px; bottom: 3px"><img style="height: 15px" src="' + APP_HOST + '/public/template/assets/img/faviconTelecom.png"></small>';
                } else {
                    html += '   <small style="position: absolute; right: -4px; bottom: 3px"><img style="height: 15px" src="' + APP_HOST + '/public/template/assets/img/faviconConectividade.png"></small>';
                }
                html += '   </div>';
                html += '   <div class="text-truncate" style="padding-top: 11px">';
                html += '       <h5 class="userNome mb-0 text-truncate color-default font-11">' + registro['entidadeUsuario']['usuarioNome'] + '</h5>';
                html += '       <p class="userCargo mb-0 text-truncate text-muted font-11" style="max-height: 20px">' + registro['entidadeUsuario']['cargoNome'] + '</p>';
                html += '   </div>';
                html += '   <div class="d-flex ml-auto">';
                html += '       <div style="padding-top: 14px;width: 45px" title="Vendas de planos">';
                html += '           <p class="mb-0"><i class="mdi mdi-shopping "></i> ' + registro['quantidade'] + '</p>';
                html += '       </div>';
                html += '       <div style="padding-top: 14px;width: 45px" title="Vendas de roteadores">';
                html += '           <p class="mb-0"><i class="mdi mdi-router-wireless"></i> ' + registro['quantidadeVendaRoteador'] + '</p>';
                html += '       </div>';
                html += '       <div style="padding-top: 14px;width: 35px" title="Vendas de telefonia">';
                html += '           <p class="mb-0"><i class="mdi mdi-phone"></i> ' + registro['quantidadeVendaTelefonia'] + '</p>';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';
                $('#cardVendaPadraoTopVendedorTabela').append(html);
                await sleep(tempo);
            }
        }
    } else {
        $('#cardVendaPadraoTopVendedorTabela').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    $('#cardVendaPadraoTopVendedorTotalBlock').fadeOut(50);
    $('#cardVendaPadraoTopVendedorPesquisa').focus();
}

/**
 * FUNCTION
 * Constroi grafico de top vendas por cidade.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
async function setVendaPadraoTopCidade() {
    $('#vendaPadraoTopCidadeBlock').fadeIn(0);
    const retorno = await getVendaPadraoTopCidadeAJAX();
    $('#vendaPadraoTopCidadeBlock').fadeOut(150);
    if (retorno.length) {
        var cidade = [];
        var quantidade = [];
        for (var i = 0; i < 12; i++) {
            cidade.push(retorno[i] ? retorno[i]['sigla'] : '---');
            quantidade.push(retorno[i] ? retorno[i]['quantidade'] : 0);
        }
        new Chartist.Bar('#vendaPadraoTopCidadeGrafico', {
            labels: cidade,
            series: [
                quantidade
            ]
        }, {
            seriesBarDistance: 10,
            reverseData: false,
            horizontalBars: false,
            axisY: {
                onlyInteger: true,
                offset: 20
            },
            axisX: {
                onlyInteger: true
            },
            plugins: [
                Chartist.plugins.tooltip()
            ]

        });
    }
    $('#vendaPadraoTopCidadeBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi tabela de registros de vendedores ordenados por vendas.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
async function setVendaPadraoCidadeRelatorio() {
    var tempo = 20;
    $('#cardVendaPadraoCidadeRelatorioPesquisa').val('');
    $('#cardVendaPadraoCidadeRelatorioTabela').html('<div style="padding: 15px"><small class="text-muted flashit">Obtendo registros ...</small></div>');
    $('#cardVendaPadraoCidadeRelatorioBlock').fadeIn(50);
    const retorno = await getVendaPadraoCidadeRelatorioAJAX();
    if (retorno.length) {
        $('#cardVendaPadraoCidadeRelatorioTabela').html('');
        for (var i = 0; i < retorno.length; i++) {
            if (retorno[i]) {
                var registro = retorno[i];
                var html = '';
                var rank = (i + 1);
                html += '<div class="d-flex div-registro" style="cursor: pointer;padding: 10px;margin-top: 1px;padding-left: 12px;padding-right: 10px;animation: slide-up 1s ease">';
                html += '   <input hidden class="nome" value="' + registro['cidade'] + '">';
                html += '   <div style="padding-top: 10px;width: 25px">';
                html += '       <p class="mb-0">' + (rank < 10 ? '0' + rank : rank) + '</p>';
                html += '   </div>';
                html += '   <div class="text-truncate" style="margin-left: 10px;min-width: 100px;position: relative">';
                if (i === 0) {
                    html += '   <small style="position: absolute; right: 43px; top: -8px;color: yellow"><i class="mdi mdi-crown font-20"></i></small>';
                } else if (i === 1) {
                    html += '   <small class="text-muted" style="position: absolute; right: 43px; top: -8px"><i class="mdi mdi-crown font-20"></i></small>';
                } else if (i === 2) {
                    html += '   <small class="text-orange" style="position: absolute; right: 43px; top: -8px"><i class="mdi mdi-crown font-20"></i></small>';
                }
                html += '       <p class="userCargo mb-0 text-truncate text-muted font-11" style="max-height: 20px">Cidade</p>';
                html += '       <p class="color-default" style="margin-bottom: 0px;font-size: 13px"> ' + registro['cidade'] + '</p>';
                html += '   </div>';
                html += '   <div class="d-flex ml-auto">';
                html += '       <div style="padding-top: 0px;width: 55px">';
                html += '           <p class="userCargo mb-0 text-truncate text-muted font-11" style="max-height: 20px">Vendas</p>';
                html += '           <p class="mb-0 font-13"><i class="mdi mdi-shopping"></i> ' + registro['quantidade'] + '</p>';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';
                $('#cardVendaPadraoCidadeRelatorioTabela').append(html);
                await sleep(tempo);
            }
        }
    } else {
        $('#cardVendaPadraoCidadeRelatorioTabela').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    $('#cardVendaPadraoCidadeRelatorioBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi tabela de estatistica do usuario selecionado carregando informações 
 * sobre vendas.
 * 
 * @author    Manoel Louro
 * @date      20/03/2020
 */
async function getVendaPadraoGraficoSemestral() {
    //REQUEST
    const retorno = await getVendaPadraoGraficoSemestralAJAX();
    var mediaPlano = parseInt(retorno[0].reduce((total, numero) => parseInt(total) + parseInt(numero), 0) / 6);
    var ultimosDias = parseInt(retorno[0][5]) * 100;
    var estatistica = parseInt(ultimosDias / mediaPlano);
    if (mediaPlano > ultimosDias) {
        $('#vendaPadraoIndicadorUsuario').html(retorno[0][5] + '<small style="font-size: 13px"><i class="mdi mdi-arrow-up"></i>' + (!isNaN(estatistica) ? estatistica : 0) + '%</small>');
        $('#vendaPadraoIndicadorUsuarioCard').prop('class', 'card card-hover bg-success text-white');
    } else {
        $('#vendaPadraoIndicadorUsuario').html(retorno[0][5] + '<small style="font-size: 13px"><i class="mdi mdi-arrow-down"></i>' + (!isNaN(estatistica) ? estatistica : 0) + '%</small>');
        $('#vendaPadraoIndicadorUsuarioCard').prop('class', 'card card-hover bg-danger text-white');
    }
    $('#vendaPadraoIndicadorUsuarioBlock').fadeOut(50);
    new Chartist.Bar('#vendaPadraoGraficoIndicador', {
        labels: [getMesNome(5).substring(0, 3), getMesNome(4).substring(0, 3), getMesNome(3).substring(0, 3), getMesNome(2).substring(0, 3), getMesNome(1).substring(0, 3), getMesNome(0).substring(0, 3)],
        series: [
            retorno[1],
            retorno[0]
        ]
    }, {
        seriesBarDistance: 25,
        reverseData: true,
        horizontalBars: true,
        axisY: {
            onlyInteger: true,
            offset: 20
        },
        axisX: {
            onlyInteger: true,
            offset: 20
        },
        plugins: [
            Chartist.plugins.tooltip()
        ]
    });
}

/**
 * FUNCTION
 * Efetua filtro de vendedor de acordo com pesquisa informada.
 * 
 * @author    Manoel Louro
 * @date      01/06/2020
 */
function setVendaPadraoTopVendedorPesquisarNome() {
    var pesquisa = $('#cardVendaPadraoTopVendedorPesquisa').val().toUpperCase();
    $('#cardVendaPadraoTopVendedorTabela').children().each(function () {
        if ($(this).hasClass('div-registro')) {
            var nome = $(this).find('.nome').val().toUpperCase();
            if (nome.includes(pesquisa)) {
                $(this).removeClass('d-none');
                $(this).addClass('d-flex');
            } else {
                $(this).removeClass('d-flex');
                $(this).addClass('d-none');
            }
        }
    });
}

/**
 * FUNCTION
 * Efetua filtro de cidade de acordo com pesquisa informada.
 * 
 * @author    Manoel Louro
 * @date      07/07/2020
 */
function setVendaPadraoCidadeRelatorioPesquisarNome() {
    var pesquisa = $('#cardVendaPadraoCidadeRelatorioPesquisa').val().toUpperCase();
    $('#cardVendaPadraoCidadeRelatorioTabela').children().each(function () {
        if ($(this).hasClass('div-registro')) {
            var nome = $(this).find('.nome').val().toUpperCase();
            if (nome.includes(pesquisa)) {
                $(this).removeClass('d-none');
                $(this).addClass('d-flex');
            } else {
                $(this).removeClass('d-flex');
                $(this).addClass('d-none');
            }
        }
    });
}

////////////////////////////////////////////////////////////////////////////////
//                                - REQUEST -                                 //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna quantidade de registros cadastrados duramente mês atual.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
function getVendaPadraoQuadroTopAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getQuantidadeVendasDataAJAX',
            data: {
                idUsuario: $('#idUserLogado').val()
            },
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
 * REQUEST
 * Retorna lista de top vendedores.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
function getVendaPadraoTopVendedorAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendedoresAJAX',
            type: 'post',
            data: {
                dataInicial: $('#vendaPadraoTopVendedoresSelect').val(),
                dataFinal: $('#vendaPadraoTopVendedoresSelect').val(),
                quantidadeMax: 6
            },
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
 * REQUEST
 * Retorna lista de top vendedores.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
function getVendaPadraoTopVendedorTotalAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendedoresAJAX',
            type: 'post',
            data: {
                dataInicial: $('#cardVendaPadraoTopVendedorSelect').val(),
                dataFinal: $('#cardVendaPadraoTopVendedorSelect').val(),
                quantidadeMax: 2000
            },
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
 * REQUEST
 * Retorna lista de top vendas por cidade.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
function getVendaPadraoTopCidadeAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendasCidadeAJAX',
            type: 'post',
            data: {
                dataInicial: $('#vendaPadraoTopCidadeSelect').val(),
                dataFinal: $('#vendaPadraoTopCidadeSelect').val()
            },
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
 * REQUEST
 * Retorna lista de top cidades em vendas.
 * 
 * @author    Manoel Louro
 * @date      07/07/2020
 */
function getVendaPadraoCidadeRelatorioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendasCidadeAJAX',
            type: 'post',
            data: {
                dataInicial: $('#cardVendaPadraoCidadeRelatorioSelect').val(),
                dataFinal: $('#cardVendaPadraoCidadeRelatorioSelect').val()
            },
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
 * Retorna estatisca de venda relacionadas ao usuario logado.
 * 
 * @author    Manoel Louro
 * @date      30/05/2020
 */
function getVendaPadraoGraficoSemestralAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getControleRegistroVendaAJAX',
            data: {
                operacao: 'getRelatorioControleVendaInterfase',
                usuarioID: $('#idUserLogado').val()
            },
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

////////////////////////////////////////////////////////////////////////////////
//                           - INTERNAL FUNCTION -                            //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna data Y-m-d de retirando quantidade de mes solicitado.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
function getData(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    var dia = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
    var mes = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);
    return date.getFullYear() + '-' + mes + '-' + dia;
}

/**
 * INTERNAL FUNCTION
 * Retorna mes e ano da data solicitada.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
function getDataNome(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    return getMesNome(retirarMes) + ' - ' + date.getFullYear();
}

/**
 * INTERNAL FUNCTION
 * Aninação de contagem através de elemento informado
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
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
 * @date      16/04/2020
 */
function getMesNome(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    monthName = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    return monthName[date.getMonth()];
}

//START
initVendaPadraoScript();