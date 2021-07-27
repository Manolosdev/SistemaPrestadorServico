/* 
 * DASHBOARD
 * 
 * Dashboard administrativo de vendas executadas pelo sistema.
 *
 * @author    Manoel Louro
 * @date      25/04/2020
 */

/**
 * FUNCTION
 * Inicializa o dashboard.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
async function initVendaAdminScript() {
    initVendaAdminHTML();
    //INIT COMPONENTES
    await setVendaAdminQuadroTop();
    await setVendaAdminTopVendedores();
    await setVendaAdminTopCidade();
    await getEstatisticaVendas();
    await setVendaAdminTopVendedoresTotal();
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
 * @date      25/04/2020
 */
function initVendaAdminHTML() {
    html = '';
    //QUADRO TOP
    html += '<div class="row" style="position: relative">';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-success text-white">';
    html += '           <div class="divLoadBlock" id="vendaAdminQuadroTopPlanoBlock" style="display: block"></div>';
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
    html += '                       <h3 class="font-medium mb-0" id="vendaAdminQuadroTopPlano" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaAdminQuadroTopPlanoValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-info text-white">';
    html += '           <div class="divLoadBlock" id="vendaAdminQuadroTopRoteadorBlock" style="display: block"></div>';
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
    html += '                       <h3 class="font-medium mb-0" id="vendaAdminQuadroTopRoteador" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaAdminQuadroTopRoteadorValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-primary text-white">';
    html += '           <div class="divLoadBlock" id="vendaAdminQuadroTopTelefoniaBlock" style="display: block"></div>';
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
    html += '                       <h3 class="font-medium mb-0" id="vendaAdminQuadroTopTelefonia" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaAdminQuadroTopTelefoniaValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6">';
    html += '       <div class="card card-hover bg-cyan text-white">';
    html += '           <div class="divLoadBlock" id="vendaAdminQuadroTopVendaOnlineBlock" style="display: block"></div>';
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
    html += '                       <h3 class="font-medium mb-0" id="vendaAdminQuadroTopVendaOnline" style="font-size: 22px">0</h3>';
    html += '                       <small class="text-right" id="vendaAdminQuadroTopVendaOnlineValor">R$ 0,00</small>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    //QUADRO BOTTOM
    html += '<div class="row">';
    html += '   <div class="col-md-6 col-lg-3 order-md-2 order-lg-1">';
    html += '       <div class="card border-default">';
    html += '           <div class="divLoadBlock" id="vendaAdminTopVendedoresBlock" style="display: block"></div>';
    html += '               <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px; padding-top: 15px">';
    html += '                   <div class="d-flex align-items-center">';
    html += '                       <div class="text-truncate">';
    html += '                           <h4 class="page-title mb-0">Top Vendedores</h4>';
    html += '                       </div>';
    html += '                       <div class="ml-auto">';
    html += '                           <div class="row m-b-10">';
    html += '                           <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="vendaAdminTopVendedoresSelect">';
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
    html += '               <div class="ctVendas" id="vendaAdminTopVendedorGrafico" style="height: 390px;"></div>';
    html += '           </div>';
    html += '           <div class="card-body bg-light text-center" title="Exibir todos dos vendedores" style="padding: 5px;max-height: 30px;min-height: 30px;cursor: pointer" id="vendaAdminMostrarCardTopVendedor">';
    html += '               <i class="mdi font-13 mdi-chevron-double-down"></i> <small>Mostrar todos <i class="mdi mdi-chevron-double-down font-13"></i></small>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-md-12 col-lg-6 order-md-1 order-lg-2">';
    html += '       <div class="card border-default">';
    html += '           <div class="divLoadBlock" id="vendaAdminTopCidadeBlock" style="display: block"></div>';
    html += '               <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px; padding-top: 12px">';
    html += '                   <div class="d-flex align-items-center">';
    html += '                       <div class="text-truncate">';
    html += '                           <h4 class="page-title mb-0">Top Cidades</h4>';
    html += '                       </div>';
    html += '                       <div class="ml-auto">';
    html += '                           <div class="row m-b-10">';
    html += '                           <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="vendaAdminTopCidadeSelect">';
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
    html += '           <div class="card-body" style="padding-top: 0px;padding-bottom: 0px;max-height: 410px;min-height: 410px;padding-left: 15px">';
    html += '               <div class="ctVendas" id="vendaAdminTopCidadeGrafico" style="height: 410px;"></div>';
    html += '           </div>';
    html += '           <div class="card-body bg-light text-center" title="Relatorio geral de vendas por cidade" style="padding: 5px;max-height: 30px;min-height: 30px;cursor: pointer" id="vendaAdminMostrarCardCidadeRelatorio">';
    html += '               <i class="mdi font-13 mdi-chevron-double-down"></i> <small>Exibir mais <i class="mdi mdi-chevron-double-down font-13"></i></small>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-3 col-md-6 order-md-3 order-lg-3">';
    html += '       <div class="card border-default">';
    html += '          <div class="divLoadBlock" id="vendaAdminEstatisticaBlock" style="display: block"></div>';
    html += '           <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px; padding-top: 12px">';
    html += '               <div class="d-flex align-items-center">';
    html += '                   <div class="text-truncate">';
    html += '                       <h4 class="page-title mb-0">Vendas</h4>';
    html += '                   </div>';
    html += '                   <div class="ml-auto">';
    html += '                       <div class="row m-b-10">';
    html += '                           <select class="form-control border-0 text-muted" style="padding: 0px;height: 21px" id="vendaAdminEstatisticaSelect">';
    html += '                               <option value="' + getData(0) + '" selected="">Últimos 30 dias</option>';
    html += '                               <option value="' + getData(1).substring(0, 7) + '-31">' + getDataNome(1) + '</option>';
    html += '                               <option value="' + getData(2).substring(0, 7) + '-31">' + getDataNome(2) + '</option>';
    html += '                               <option value="' + getData(3).substring(0, 7) + '-31">' + getDataNome(3) + '</option>';
    html += '                               <option value="' + getData(4).substring(0, 7) + '-31">' + getDataNome(4) + '</option>';
    html += '                               <option value="' + getData(5).substring(0, 7) + '-31">' + getDataNome(5) + '</option>';
    html += '                           </select>';
    html += '                       </div>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '           <div class="card-body bg-light">';
    html += '               <div class="d-flex flex-row text-truncate">';
    html += '                   <div class="align-self-center">';
    html += '                       <h4 class="mb-0">Total</h4>';
    html += '                       <span>Venda planos</span>';
    html += '                   </div>';
    html += '                   <div class="ml-auto align-self-center">';
    html += '                       <h2 class="font-medium mb-0" id="vendaAdminEstatisticaValorTotal">R$ 0,00</h2>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding-top: 20px;min-height: 358px; max-height: 358px">';
    html += '               <ul class="list-style-none country-state">';
    html += '                   <li style="margin-bottom: 15px">';
    html += '                       <div>';
    html += '                           <h2 class="mb-0"><i class="mdi mdi-shopping"></i> <span id="vendaAdminEstatisticaVendaPlano">0</span></h2>';
    html += '                           <small>Vendas de plano</small>';
    html += '                           <div class="float-right" id="vendaAdminEstatisticaVendaPlanoLabelPorc">0% <i class="mdi mdi-arrow-down-bold text-muted"></i></div>';
    html += '                       </div>';
    html += '                       <div class="progress" style="width: 100%">';
    html += '                           <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="vendaAdminEstatisticaVendaPlanoProgress"></div>';
    html += '                       </div>';
    html += '                   </li>';
    html += '                   <li style="margin-bottom: 15px">';
    html += '                       <h2 class="mb-0"><i class="mdi mdi-router-wireless"></i> <span id="vendaAdminEstatisticaVendaRoteador">0</span></h2>';
    html += '                       <small>Vendas de roteador</small>';
    html += '                       <div class="float-right" id="vendaAdminEstatisticaVendaRoteadorLabelPorc">0% <i class="mdi mdi-arrow-down-bold text-muted"></i></div>';
    html += '                       <div class="progress" style="width: 100%">';
    html += '                           <div class="progress-bar bg-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="vendaAdminEstatisticaVendaRoteadorProgress"></div>';
    html += '                       </div>';
    html += '                   </li>';
    html += '                   <li style="margin-bottom: 15px">';
    html += '                       <h2 class="mb-0"><i class="mdi mdi-phone"></i> <span id="vendaAdminEstatisticaVendaTelefoniaLabel">0</span></h2>';
    html += '                       <small>Vendas de telefonia</small>';
    html += '                       <div class="float-right" id="vendaAdminEstatisticaVendaTelefoniaLabelPorc">0% <i class="mdi mdi-arrow-down-bold text-muted"></i></div>';
    html += '                       <div class="progress" style="width: 100%">';
    html += '                           <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="vendaAdminEstatisticaVendaTelefoniaProgress"></div>';
    html += '                       </div>';
    html += '                   </li>';
    html += '                   <li style="margin-bottom: 15px">';
    html += '                       <h2 class="mb-0"><i class="mdi mdi-internet-explorer"></i> <span id="vendaAdminEstatisticaVendaOnline">0</span></h2>';
    html += '                       <small>Vendas online</small>';
    html += '                       <div class="float-right" id="vendaAdminEstatisticaVendaOnlineLabelPorc">0% <i class="mdi mdi-arrow-down-bold text-muted"></i></div>';
    html += '                       <div class="progress" style="width: 100%">';
    html += '                           <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="vendaAdminEstatisticaVendaOnlineProgress"></div>';
    html += '                       </div>';
    html += '                   </li>';
    html += '               </ul>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<!-- CARD TOP VENDEDORES -->';
    html += '<div class="internalPage" style="display: none;" id="cardVendaAdminTopVendedor">';
    html += '   <div class="col-12" style="max-width: 530px">';
    html += '        <div class="card border-default" style="margin: 10px" id="cardVendaAdminTopVendedorCard">';
    html += '            <div class="divLoadBlock" id="cardVendaAdminTopVendedorTotalBlock"></div>';
    html += '            <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px;padding-top: 15px">';
    html += '                <div class="d-flex align-items-center">';
    html += '                    <div class="text-truncate">';
    html += '                        <h4 class="page-title mb-0">Top Vendedores</h4>';
    html += '                    </div>';
    html += '                    <div class="ml-auto">';
    html += '                        <div class="row m-b-10">';
    html += '                            <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="cardVendaAdminTopVendedorSelect">';
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
    html += '                    <input class="form-control border-custom color-default mb-1" id="cardVendaAdminTopVendedorPesquisa" placeholder="Localizar vendendor ..." maxlength="30" spellcheck="false" style="border-right: none" autocomplete="off">';
    html += '                </div>';
    html += '            </div>';
    html += '            <div class="scroll" style="height: 409px" id="cardVendaAdminTopVendedorTabela">';
    html += '            </div>';
    html += '            <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">';
    html += '                <div class="row">';
    html += '                    <div class="col" style="max-width: 110px;padding-right: 0">';
    html += '                        <button id="cardVendaAdminTopVendedorBack" onclick="$(\'#cardVendaAdminTopVendedor\').fadeOut(50)" type="button" class="btn btn-dark" style="width: 70px"><i class="mdi mdi-arrow-left"></i></button>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    html += '<!-- CARD TOP CIDADES -->';
    html += '<div class="internalPage" style="display: none;" id="cardVendaAdminCidadeRelatorio">';
    html += '   <div class="col-12" style="max-width: 530px">';
    html += '        <div class="card border-default" style="margin: 10px" id="cardVendaAdminTopVendedorCard">';
    html += '            <div class="divLoadBlock" id="cardVendaAdminCidadeRelatorioBlock"></div>';
    html += '            <div class="card-body" style="min-height: 60px;max-height: 60px;padding-bottom: 0px;padding-top: 15px">';
    html += '                <div class="d-flex align-items-center">';
    html += '                    <div class="text-truncate">';
    html += '                        <h4 class="page-title mb-0">Top Cidades</h4>';
    html += '                    </div>';
    html += '                    <div class="ml-auto">';
    html += '                        <div class="row m-b-10">';
    html += '                            <select class="form-control border-0 text-muted text-right" style="padding: 0px;height: 21px;" id="cardVendaAdminCidadeRelatorioSelect">';
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
    html += '                    <input class="form-control border-custom color-default mb-1" id="cardVendaAdminCidadeRelatorioPesquisa" placeholder="Localizar cidade ..." maxlength="30" spellcheck="false" style="border-right: none" autocomplete="off">';
    html += '                </div>';
    html += '            </div>';
    html += '            <div class="scroll" style="height: 409px" id="cardVendaAdminCidadeRelatorioTabela">';
    html += '            </div>';
    html += '            <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">';
    html += '                <div class="row">';
    html += '                    <div class="col" style="max-width: 110px;padding-right: 0">';
    html += '                        <button id="cardVendaAdminCidadeRelatorioBack" onclick="$(\'#cardVendaAdminCidadeRelatorio\').fadeOut(50)" type="button" class="btn btn-dark" style="width: 70px"><i class="mdi mdi-arrow-left"></i></button>';
    html += '                    </div>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    $('.container-fluid').append(html);
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    //INIT ELEMENTS
    new Chartist.Bar('#vendaAdminTopCidadeGrafico', {
        labels: ['---', '---', '---', '---', '---', '---', '---', '---', '---', '---', '---', '---'],
        series: [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
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
        }
    });
    $('#vendaAdminTopCidadeSelect').on('change', async function () {
        await setVendaAdminTopCidade();
    });
    $('#vendaAdminTopVendedoresSelect').on('change', async function () {
        await setVendaAdminTopVendedores();
    });
    $('#vendaAdminEstatisticaSelect').on('change', async function () {
        await getEstatisticaVendas();
    });
    $('#cardVendaAdminTopVendedorSelect').on('change', async function () {
        await setVendaAdminTopVendedoresTotal();
    });
    $('#cardVendaAdminCidadeRelatorioSelect').on('change', async function () {
        await setVendaAdminCidadeRelatorio();
    });
    $('#cardVendaAdminTopVendedorPesquisa').on('keyup', function () {
        setVendaAdminTopVendedorPesquisarNome();
    });
    $('#cardVendaAdminCidadeRelatorioPesquisa').on('keyup', function () {
        setVendaAdminCidadeRelatorioPesquisarNome();
    });
    $('#vendaAdminMostrarCardTopVendedor').on('click', async function () {
        $('#cardVendaAdminTopVendedor').fadeIn(100);
        await setVendaAdminTopVendedoresTotal();
    });
    $('#vendaAdminMostrarCardCidadeRelatorio').on('click', async function () {
        $('#cardVendaAdminCidadeRelatorio').fadeIn(100);
        await setVendaAdminCidadeRelatorio();
    });
    $('#vendaAdminTopVendedorGrafico').html('<div style="padding: 15px;padding-top: 0px"><small class="text-muted flashit">Carregando registros ...</small></div>');
}

/**
 * FUNCTION 
 * Constroi lista de registro de indicadores de vendas relacionadas ao mes atual
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
async function setVendaAdminQuadroTop() {
    var sleepValue = 0;
    const retorno = await getVendaAdminQuadroTopAJAX();
    if (retorno[0]) {
        $('#vendaAdminQuadroTopPlanoBlock').fadeOut(0);
        $('#vendaAdminQuadroTopPlano').html(retorno[0][0]);
        $('#vendaAdminQuadroTopPlanoValor').html((retorno[0][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaAdminQuadroTopPlano'));
    }
    await sleep(sleepValue);
    if (retorno[1]) {
        $('#vendaAdminQuadroTopRoteadorBlock').fadeOut(0);
        $('#vendaAdminQuadroTopRoteador').html(retorno[1][0]);
        $('#vendaAdminQuadroTopRoteadorValor').html((retorno[1][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaAdminQuadroTopRoteador'));
    }
    await sleep(sleepValue);
    if (retorno[2]) {
        $('#vendaAdminQuadroTopTelefoniaBlock').fadeOut(0);
        $('#vendaAdminQuadroTopTelefonia').html(retorno[2][0]);
        $('#vendaAdminQuadroTopTelefoniaValor').html((retorno[2][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaAdminQuadroTopTelefonia'));
    }
    await sleep(sleepValue);
    if (retorno[3]) {
        $('#vendaAdminQuadroTopVendaOnlineBlock').fadeOut(0);
        $('#vendaAdminQuadroTopVendaOnline').html(retorno[3][0]);
        $('#vendaAdminQuadroTopVendaOnlineValor').html((retorno[3][1]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //animateContador($('#vendaAdminQuadroTopVendaOnline'));
    }
    await sleep(sleepValue);
}

/**
 * FUNCTION
 * Constroi tabela de registros de vendedores ordenados por vendas.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
async function setVendaAdminTopVendedores() {
    $('#vendaAdminTopVendedoresBlock').fadeIn(0);
    var tempo = 200;
    $('#vendaAdminTopVendedorGrafico').html('<div style="padding: 15px;padding-top: 0px"><small class="text-muted flashit">Carregando registros ...</small></div>');
    const retorno = await getVendaAdminTopVendedorAJAX();
    if (retorno.length) {
        $('#vendaAdminTopVendedorGrafico').html('');
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
                $('#vendaAdminTopVendedorGrafico').append(html);
                await sleep(tempo);
            }
        }
    } else {
        $('#vendaAdminTopVendedorGrafico').html('<div style="padding: 15px;padding-top: 0px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    $('#vendaAdminTopVendedoresBlock').fadeOut(150);
}

/**
 * FUNCTION
 * Constroi tabela de registros de vendedores ordenados por vendas.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
async function setVendaAdminTopVendedoresTotal() {
    var tempo = 20;
    $('#cardVendaAdminTopVendedorPesquisa').val('');
    $('#cardVendaAdminTopVendedorTabela').html('<div style="padding: 15px"><small class="text-muted flashit">Obtendo registros ...</small></div>');
    $('#cardVendaAdminTopVendedorTotalBlock').fadeIn(50);
    const retorno = await getVendaAdminTopVendedorTotalAJAX();
    if (retorno.length) {
        $('#cardVendaAdminTopVendedorTabela').html('');
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
                $('#cardVendaAdminTopVendedorTabela').append(html);
                await sleep(tempo);
            }
        }
    } else {
        $('#cardVendaAdminTopVendedorTabela').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    $('#cardVendaAdminTopVendedorTotalBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi grafico de top vendas por cidade.
 * 
 * @author    Manoel Louro
 * @date      25/04/2020
 */
async function setVendaAdminTopCidade() {
    $('#vendaAdminTopCidadeBlock').fadeIn(0);
    const retorno = await getVendaAdminTopCidadeAJAX();
    $('#vendaAdminTopCidadeBlock').fadeOut(150);
    if (retorno.length) {
        var sigla = [];
        var cidade = [];
        var quantidade = [];
        for (var i = 0; i < retorno.length; i++) {
            sigla.push(retorno[i] ? retorno[i]['sigla'] : '---');
            cidade.push(retorno[i] ? retorno[i]['cidade'] : '---');
            quantidade.push(retorno[i] ? retorno[i]['quantidade'] : 0);
            if(i > 12){
                break;
            }
        }
        new Chartist.Bar('#vendaAdminTopCidadeGrafico', {
            labels: sigla,
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
    $('#vendaAdminTopCidadeBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi tabela de registros de vendedores ordenados por vendas.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
async function setVendaAdminCidadeRelatorio() {
    var tempo = 20;
    $('#cardVendaAdminCidadeRelatorioPesquisa').val('');
    $('#cardVendaAdminCidadeRelatorioTabela').html('<div style="padding: 15px"><small class="text-muted flashit">Obtendo registros ...</small></div>');
    $('#cardVendaAdminCidadeRelatorioBlock').fadeIn(50);
    const retorno = await getVendaAdminTopCidadeAJAX();
    if (retorno.length) {
        $('#cardVendaAdminCidadeRelatorioTabela').html('');
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
                $('#cardVendaAdminCidadeRelatorioTabela').append(html);
                await sleep(tempo);
            }
        }
    } else {
        $('#cardVendaAdminCidadeRelatorioTabela').html('<div style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    $('#cardVendaAdminCidadeRelatorioBlock').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi estatisticas de vendas de acordo com parametro informado.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
async function getEstatisticaVendas() {
    $('#vendaAdminEstatisticaBlock').fadeIn(0);
    var tempo = 200;
    //INIT
    $('#vendaAdminEstatisticaValorTotal').html((0).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
    $('#vendaAdminEstatisticaVendaPlano').html(0);
    $('#vendaAdminEstatisticaVendaPlanoLabelPorc').html('0% <i class="mdi mdi-arrow-down-bold text-muted"></i>');
    $('#vendaAdminEstatisticaVendaPlanoProgress').css('width', '0%');
    $('#vendaAdminEstatisticaVendaRoteadorLabelPorc').html('0% <i class="mdi mdi-arrow-down-bold text-muted"></i>');
    $('#vendaAdminEstatisticaVendaRoteadorProgress').css('width', '0%');
    $('#vendaAdminEstatisticaVendaTelefoniaLabelPorc').html('0% <i class="mdi mdi-arrow-down-bold text-muted"></i>');
    $('#vendaAdminEstatisticaVendaTelefoniaProgress').css('width', '0%');
    $('#vendaAdminEstatisticaVendaOnlineLabelPorc').html('0% <i class="mdi mdi-arrow-down-bold text-muted"></i>');
    $('#vendaAdminEstatisticaVendaOnlineProgress').css('width', '0%');
    await sleep(tempo);
    const retorno = await getVendaAdminEstatisticaVendaAJAX();
    if (retorno.length) {
        $('#vendaAdminEstatisticaValorTotal').html((retorno[0]).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //PLANO
        $('#vendaAdminEstatisticaVendaPlano').html(retorno[1][0]);
        //animateContador($('#vendaAdminEstatisticaVendaPlano'));
        var estatistica = parseInt(retorno[1][1]);
        if (estatistica > 0) {
            $('#vendaAdminEstatisticaVendaPlanoLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-up-bold text-success"></i>');
            $('#vendaAdminEstatisticaVendaPlanoProgress').prop('class', 'progress-bar bg-success');
            $('#vendaAdminEstatisticaVendaPlanoProgress').css('width', estatistica + '%');
        } else {
            $('#vendaAdminEstatisticaVendaPlanoLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-down-bold text-danger"></i>');
            $('#vendaAdminEstatisticaVendaPlanoProgress').prop('class', 'progress-bar bg-danger');
            $('#vendaAdminEstatisticaVendaPlanoProgress').css('width', (0 - estatistica) + '%');
        }
        await sleep(tempo);
        //ROTEADOR
        $('#vendaAdminEstatisticaVendaRoteador').html(retorno[2][0]);
        //animateContador($('#vendaAdminEstatisticaVendaRoteador'));
        var estatistica = parseInt(retorno[2][1]);
        if (estatistica > 0) {
            $('#vendaAdminEstatisticaVendaRoteadorLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-up-bold text-success"></i>');
            $('#vendaAdminEstatisticaVendaRoteadorProgress').prop('class', 'progress-bar bg-success');
            $('#vendaAdminEstatisticaVendaRoteadorProgress').css('width', estatistica + '%');
        } else {
            $('#vendaAdminEstatisticaVendaRoteadorLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-down-bold text-danger"></i>');
            $('#vendaAdminEstatisticaVendaRoteadorProgress').prop('class', 'progress-bar bg-danger');
            $('#vendaAdminEstatisticaVendaRoteadorProgress').css('width', (0 - estatistica) + '%');
        }
        await sleep(tempo);
        //TELEFONIA
        $('#vendaAdminEstatisticaVendaTelefonia').html(retorno[3][0]);
        //animateContador($('#vendaAdminEstatisticaVendaTelefonia'));
        var estatistica = parseInt(retorno[3][1]);
        if (estatistica > 0) {
            $('#vendaAdminEstatisticaVendaTelefoniaLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-up-bold text-success"></i>');
            $('#vendaAdminEstatisticaVendaTelefoniaProgress').prop('class', 'progress-bar bg-success');
            $('#vendaAdminEstatisticaVendaTelefoniaProgress').css('width', estatistica + '%');
        } else {
            $('#vendaAdminEstatisticaVendaTelefoniaLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-down-bold text-danger"></i>');
            $('#vendaAdminEstatisticaVendaTelefoniaProgress').prop('class', 'progress-bar bg-danger');
            $('#vendaAdminEstatisticaVendaTelefoniaProgress').css('width', (0 - estatistica) + '%');
        }
        await sleep(tempo);
        //VENDA ONLINE
        $('#vendaAdminEstatisticaVendaOnline').html(retorno[4][0]);
        //animateContador($('#vendaAdminEstatisticaVendaOnline'));
        var estatistica = parseInt(retorno[4][1]);
        if (estatistica > 0) {
            $('#vendaAdminEstatisticaVendaOnlineLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-up-bold text-success"></i>');
            $('#vendaAdminEstatisticaVendaOnlineProgress').prop('class', 'progress-bar bg-success');
            $('#vendaAdminEstatisticaVendaOnlineProgress').css('width', estatistica + '%');
        } else {
            $('#vendaAdminEstatisticaVendaOnlineLabelPorc').html(estatistica + '% <i class="mdi mdi-arrow-down-bold text-danger"></i>');
            $('#vendaAdminEstatisticaVendaOnlineProgress').prop('class', 'progress-bar bg-danger');
            $('#vendaAdminEstatisticaVendaOnlineProgress').css('width', (0 - estatistica) + '%');
        }
    }
    $('#vendaAdminEstatisticaBlock').fadeOut(150);
}

/**
 * FUNCTION
 * Efetua filtro de vendedor de acordo com pesquisa informada.
 * 
 * @author    Manoel Louro
 * @date      01/06/2020
 */
function setVendaAdminTopVendedorPesquisarNome() {
    var pesquisa = $('#cardVendaAdminTopVendedorPesquisa').val().toUpperCase();
    $('#cardVendaAdminTopVendedorTabela').children().each(function () {
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
function setVendaAdminCidadeRelatorioPesquisarNome() {
    var pesquisa = $('#cardVendaAdminCidadeRelatorioPesquisa').val().toUpperCase();
    $('#cardVendaAdminCidadeRelatorioTabela').children().each(function () {
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
function getVendaAdminQuadroTopAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getQuantidadeVendasDataAJAX',
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
function getVendaAdminTopVendedorAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendedoresAJAX',
            type: 'post',
            data: {
                dataInicial: $('#vendaAdminTopVendedoresSelect').val(),
                dataFinal: $('#vendaAdminTopVendedoresSelect').val(),
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
function getVendaAdminTopVendedorTotalAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendedoresAJAX',
            type: 'post',
            data: {
                dataInicial: $('#cardVendaAdminTopVendedorSelect').val(),
                dataFinal: $('#cardVendaAdminTopVendedorSelect').val(),
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
function getVendaAdminTopCidadeAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendasCidadeAJAX',
            type: 'post',
            data: {
                dataInicial: $('#vendaAdminTopCidadeSelect').val(),
                dataFinal: $('#vendaAdminTopCidadeSelect').val()
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
function getVendaAdminCidadeRelatorioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaTopVendasCidadeAJAX',
            type: 'post',
            data: {
                dataInicial: $('#cardVendaAdminCidadeRelatorioSelect').val(),
                dataFinal: $('#cardVendaAdminCidadeRelatorioSelect').val()
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
 * Retorna lista de estatisticas de vendas realizadas pelo sistema.
 * 
 * @author    Manoel Louro
 * @date      27/04/2020
 */
function getVendaAdminEstatisticaVendaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/venda/getVendaAdminQuadroEstatisticaAJAX',
            type: 'post',
            data: {
                dataPesquisa: $('#vendaAdminEstatisticaSelect').val()
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
//START
initVendaAdminScript();