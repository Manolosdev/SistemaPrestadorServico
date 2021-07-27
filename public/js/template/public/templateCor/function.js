/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */

/**
 * FUNCTION
 * Inicializa as dependecias do recurso.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */
async function getCardTemplateCorTemplateDependencia() {
    return true;
}

////////////////////////////////////////////////////////////////////////////////
//                          - INTERNAL FUNCTION -                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna SCRIPT para seu estado inicial.
 * 
 * @author    Manoel Louro
 * @date      24/06/2021
 */
function setCardVendaVisitaConsultarEstadoInicial() {
    ////////////////////////////////////////////////////////////////////////////
    //                          - CARD PRINCIPAL -                            //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardVendaVisitaConsultarDivAnimation').fadeOut(0);
    $('#cardVendaVisitaConsultarCard').fadeIn(0);
    $('#cardVendaVisitaConsultarCardDiv').fadeIn(0);
    $('#cardVendaVisitaConsultarID').val('');
    $('#cardVendaVisitaConsultarTitulo').html('<i class="mdi mdi-home-map-marker"></i> Consulta de Visita #----');
    $('#cardVendaVisitaConsultarTituloSituacao').html('<i class="mdi mdi-hexagon-multiple"></i> ----');
    $('#cardVendaVisitaConsultarTituloSituacao').prop('class', 'color-default mb-0');
    $('#cardVendaVisitaConsultarNavHistoricoTotal').html(0);
    //TAB CADASTRO -------------------------------------------------------------
    $('#cardVendaVisitaConsultarTabCadastroLabelID').html('#-----');
    $('#cardVendaVisitaConsultarTabCadastroLabelSituacao').prop('class', 'color-default mb-2 font-13');
    $('#cardVendaVisitaConsultarTabCadastroLabelSituacao').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroUsuarioPerfil').prop('src', APP_HOST + '/public/template/assets/img/user_default.png');
    $('#cardVendaVisitaConsultarTabCadastroUsuarioNome').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroUsuarioDepartamento').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroUsuarioDataCadastro').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroUsuarioDataFinalizacao').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroLabelContatoNome').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroLabelContatoCelular').html('-----');
    $('#cardVendaVisitaConsultarTabCadastroLabelComentario').val('-----');
    //TAB CONCLUSÃO ------------------------------------------------------------
    $('#tabCardVendaVisitaConsultarFinalizacao').addClass('disabled');
    $('#cardVendaVisitaConsultarTabConclusaoLabelSituacao').html('-----');
    $('#cardVendaVisitaConsultarTabConclusaoUsuarioPerfil').prop('src', APP_HOST + '/public/template/assets/img/user_default.png');
    $('#cardVendaVisitaConsultarTabConclusaoUsuarioNome').html('-----');
    $('#cardVendaVisitaConsultarTabConclusaoUsuarioDepartamento').html('-----');
    $('#cardVendaVisitaConsultarTabConclusaoLabelComentario').val('-----');
    $('#cardVendaVisitaConsultarTabConclusaoLabelDataCadastro').html('<i class="mdi mdi-calendar-plus"></i> -----');
    $('#cardVendaVisitaConsultarTabConclusaoLabelDataProspecto').html('<i class="mdi mdi-calendar-clock"></i> -----');
    $('#cardVendaVisitaConsultarTabConclusaoLabelDataFinalizacao').html('<i class="mdi mdi-calendar-check"></i> -----');
    //TAB ENDEREÇO -------------------------------------------------------------
    $('#cardVendaVisitaConsultarTabEnderecoCEP').html('----');
    $('#cardVendaVisitaConsultarTabEnderecoRua').html('----');
    $('#cardVendaVisitaConsultarTabEnderecoReferencia').html('----');
    $('#cardVendaVisitaConsultarTabEnderecoBairro').html('----');
    $('#cardVendaVisitaConsultarTabEnderecoCidade').html('----');
    $('#cardVendaVisitaConsultarTabEnderecoCoordenadaX').html('----');
    $('#cardVendaVisitaConsultarTabEnderecoCoordenadaY').html('----');
    $('#cardVendaVisitaTabMapsMapa').html('');
    //TAB HISTORICO ------------------------------------------------------------
    $('#cardVendaVisitaConsultarTabHistoricoTabela').html('<div class="col-12 text-center" style="padding-top: 115px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
    $('#cardVendaVisitaConsultarTabHistoricoTabelaSize').html('Quantidade de <b>0</b> registro(s) registrado(s)');
    //RODAPÉ
    $('#cardVendaVisitaConsultarDivBotoes').fadeOut(0);
    ////////////////////////////////////////////////////////////////////////////
    //                        - CARD MAPA MAXIMIZADO -                        //
    ////////////////////////////////////////////////////////////////////////////
    //EMPTY
    ////////////////////////////////////////////////////////////////////////////
    //                       - CARD DETALHE HISTORICO -                       //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardVendaVisitaConsultarCardDetalheHistoricoUsuarioPerfil').prop('src', APP_HOST + '/public/template/assets/img/user_default.png');
    $('#cardVendaVisitaConsultarCardDetalheHistoricoUsuarioNome').html('-----');
    $('#cardVendaVisitaConsultarCardDetalheHistoricoUsuarioDepartamento').html('-----');
    $('#cardVendaVisitaConsultarCardDetalheHistoricoID').html('#----');
    $('#cardVendaVisitaConsultarCardDetalheHistoricoCadastro').html('-----');
    $('#cardVendaVisitaConsultarCardDetalheHistoricoTitulo').html('-----');
    $('#cardVendaVisitaConsultarCardDetalheHistoricoComentario').html('-----');
    ////////////////////////////////////////////////////////////////////////////
    //                       - CARD ADICIONAR COMENTARIO -                    //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardVendaVisitaConsultarCardAdicionarComentario.setEstadoInicial();
    ////////////////////////////////////////////////////////////////////////////
    //                         - CARD ALTERAR SITUAÇÃO -                      //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardVendaVisitaConsultarCardAlterarSituacao.setEstadoInicial();
}