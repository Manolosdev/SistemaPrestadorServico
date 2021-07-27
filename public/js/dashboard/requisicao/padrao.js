/* 
 * DASHBOARD
 * 
 * Template de estudo para construção de dashboard customizado pelo usuario.
 *
 * @author    Manoel Louro
 * @date      31/07/2019
 */

/**
 * FUNCTION
 * Inicializa o template
 * 
 * @author    Manoel Louro
 * @date      31/07/2019
 */
async function initScript() {
    initHTML();
    $('.scroll').perfectScrollbar();
    await setQuadroUm();
    await setQuadroDois();
    //SET INTERVAL
    setInterval(async function () {
        await setQuadroUm();
        await setQuadroDois();
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
 * @date      31/07/2019
 */
function initHTML() {
    html = '<div class="row">';
    html += '   <div class="col-lg-6">';
    html += '       <div class="card">';
    html += '           <div class="card-body" style="padding-bottom: 10px">';
    html += '               <h4 class="card-title mb-0" style="margin-bottom: 10px">Minhas Requisições</h4>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding: 0px">';
    html += '               <div class="col p-0 scroll" id="requisicao_padrao_quadro_1" style="min-height: 330px;max-height: 330px;overflow-x: hidden !important">';
    html += '                   <div class="d-flex justify-content-center">';
    html += '                       <div class="spinner-border text-secondary" role="status" style="margin-top: 100px;width: 4rem; height: 4rem;">';
    html += '                           <span class="sr-only">Loading...</span>';
    html += '                       </div>';
    html += '                   </div>';
    html += '                   <br>';
    html += '                   <center>';
    html += '                       <small>Carregando registros...</small>';
    html += '                   </center>';
    html += '               </div>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding: 15px">';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '   <div class="col-lg-6">';
    html += '       <div class="card">';
    html += '           <div class="card-body" style="padding-bottom: 10px">';
    html += '               <h4 class="card-title mb-0">Entrega de Roteadores</h4>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding: 0px">';
    html += '               <div class="col p-0 scroll" id="requisicao_padrao_quadro_2" style="min-height: 330px;max-height: 330px;overflow-x: hidden !important">';
    html += '                   <div class="d-flex justify-content-center">';
    html += '                       <div class="spinner-border text-secondary" role="status" style="margin-top: 100px;width: 4rem; height: 4rem;">';
    html += '                           <span class="sr-only">Loading...</span>';
    html += '                       </div>';
    html += '                   </div>';
    html += '                   <br>';
    html += '                   <center>';
    html += '                       <small>Carregando registros...</small>';
    html += '                   </center>';
    html += '               </div>';
    html += '           </div>';
    html += '           <div class="card-body" style="padding: 15px">';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    $('.container-fluid').append(html);
}

/**
 * FUNCTION
 * Constroi tabela de requisições do usuario logado
 * 
 * @author    Manoel Louro
 * @date      31/07/2019
 */
async function setQuadroUm() {
    const lista = await getRequisicaoPadraoListaRequisicaoUsuarioAJAX();
    //TABELA DE REGISTROS
    if (lista.length > 0) {
        $('#requisicao_padrao_quadro_1').html('');
        for (var i = 0; i < lista.length; i++) {
            var html = '', registro = lista[i];
            html += '<div class="d-flex div-dash" style="animation: slide-up 1s ease"id="requisicao_padrao_elemento' + (i + 1) + '">';
            html += '   <div class="d-flex no-block" style="padding-top: 4px;min-width: 190px">';
            if (parseInt(registro['idUsuarioCriou']) === parseInt($('#template_user_id').val())) {
                html += '   <div style="position: absolute;left: 43px"><i class="mdi mdi-arrow-up-bold fa-2x text-success" id="detalhe_icon_principal"></i></div>';
            } else {
                html += '   <div style="position: absolute;left: 43px"><i class="mdi mdi-arrow-down-bold fa-2x text-warning" id="detalhe_icon_principal"></i></div>';
            }
            html += '           <div style="margin-right: 10px">';
            html += '               <img src="data:image/png;base64,' + registro['usuarioPerfil'] + '" alt="user" class="rounded-circle" width="40" height="40">';
            html += '           </div>';
            html += '           <div>';
            html += '               <h5 class="font-16 color-default" style="margin-bottom: 0px">' + registro['nomeUsuario'] + '</h5>';
            html += '               <span class="text-muted">' + registro['cargoUsuario'] + '</span>';
            html += '           </div>';
            html += '       </div>';
            html += '       <div class="d-none d-md-block" style="width: 100%;padding-right: 20px;padding-top: 4px">';
            html += '           <div class="d-flex">';
            html += '               <small class="text-muted">Produtos/Materiais</small>';
            html += '               <small class="text-muted ml-auto">Quantidade</small>';
            html += '           </div>';
            //LISTA DE MATERIAIS
            var produtos = registro['produtos'];
            for (var i2 = 0; i2 < produtos.length; i2++) {
                var produto = produtos[i2];
                var color = parseInt(produto['quantidadeEntregue']) === parseInt(produto['quantidadeSolicitada']) ? 'color-default' : 'text-muted';
                html += '       <div class="d-flex">';
                if (produto['comentario'] !== '') {
                    html += '       <i class="mdi mdi-comment-alert ' + color + '" style="margin-right: 5px"></i>';
                }
                html += '           <p class="mb-0 font-13 ' + color + '">' + produto['produtoOmie']['descricao'] + '</p>';
                html += '           <p class="mb-0 font-13 ml-auto ' + color + '">' + produto['quantidadeEntregue'] + '/' + produto['quantidadeSolicitada'] + '</p>';
                html += '       </div>';
            }
            html += '       </div>';
            html += '       <div class="d-flex no-block ml-auto">';
            html += '           <div class="item-dataCadastro d-none d-md-block" style="min-width: 120px">';
            html += '               <small class="text-muted">Data da solicitação</small>';
            html += '               <p class="color-default font-13 mb-0">' + registro['dataCadastro'] + '</p>';
            html += '           </div>';
            var situacao = 'Erro';
            var classSituacao = 'text-danger';
            switch (parseInt(registro['situacao'])) {
                case 1:
                    situacao = 'Pendente';
                    classSituacao = 'text-danger';
                    break;
                case 2:
                    situacao = 'Recusada';
                    classSituacao = 'text-dark';
                    break;
                case 3:
                    situacao = 'Separando';
                    classSituacao = 'text-warning';
                    break;
                case 4:
                    situacao = 'Pronta';
                    classSituacao = 'text-info';
                    break;
                case 5:
                    situacao = 'Finalizada';
                    classSituacao = 'text-success';
                    break;
            }
            html += '       <div class="item-situacao" style="min-width: 80px;margin-left: 20px">';
            html += '           <small class="text-muted">Situação</small>';
            html += '           <p class="' + classSituacao + ' mb-0 font-13">' + situacao + '</p>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#requisicao_padrao_quadro_1').append(html);
            await sleep(100);
        }
    } else {
        $('#requisicao_padrao_quadro_1').html('<div style="padding-left: 20px"><small>Nenhum registros encontrado...</small></div>');
    }
}

/**
 * FUNCTION
 * Constroi tabela de requisições do usuario logado
 * 
 * @author    Manoel Louro
 * @date      31/07/2019
 */
async function setQuadroDois() {
    const lista = await getRequisicaoPadraoListaEntregaRoteadorAJAX();
    //TABELA DE REGISTROS
    if (lista.length > 0) {
        $('#requisicao_padrao_quadro_2').html('');
        for (var i = 0; i < lista.length; i++) {
            var html = '', registro = lista[i];
            html += '<div class="d-flex div-dash" style="animation: slide-up 1s ease; margin-top: 1px;padding-right: 3px">';
            html += '   <div class="d-flex no-block" style="padding-top: 7px">';
            html += '       <div class="d-none d-lg-block" style="margin-right: 10px;width: 40px;position: relative">';
            html += '           <img src="data:image/png;base64,' + registro['entidadeUsuario']['imagemPerfil'] + '" alt="user" class="rounded-circle" width="40" height="40">';
            html += '           <i class="mdi mdi-arrow-down-bold fa-2x text-info" style="position: absolute;right: -13px;top: 10px"></i>';
            html += '       </div>';
            html += '       <div class="d-none d-lg-block" style="width: 120px">';
            html += '           <h5 class="font-16 color-default text-truncate" style="margin-bottom: 0px">' + registro['entidadeUsuario']['usuarioNome'] + '</h5>';
            html += '           <span class="text-muted text-truncate">' + registro['entidadeUsuario']['cargoNome'] + '</span>';
            html += '       </div>';
            html += '   </div>';
            html += '   <div style="margin-right: 10px">';
            html += '       <small class="text-muted">Cliente</small>';
            html += '       <p class="color-default mb-0 font-13">' + registro['codigoISP'] + ' - ' + registro['clienteNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="d-flex no-block ml-auto">';
            html += '       <div class="d-none d-lg-block" style="width: 300px;margin-right: 10px;position: relative">';
            html += '           <small class="text-muted">Roteador</small>';
            html += '           <p class="color-default mb-0 font-13 text-truncate">' + registro['roteadorSelecionado'] + '</p>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#requisicao_padrao_quadro_2').append(html);
            await sleep(100);
        }
    } else {
        $('#requisicao_padrao_quadro_2').html('<div style="padding-left: 20px"><small>Nenhum registros encontrado...</small></div>');
    }
}

////////////////////////////////////////////////////////////////////////////////
//                                - REQUEST -                                 //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUISIÇÃO AJAX
 * Retorna lista de requisições do back-end de acordo com os filtros aplicados
 * 
 * @author    Manoel Louro
 * @date      01/08/2019
 */
function getRequisicaoPadraoListaRequisicaoUsuarioAJAX() {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/requisicao/getListaRequisicaoUsuarioDASH',
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
 * Retorna lista de vendas de roteadores atribuidas ao usuário informado.
 * 
 * @author    Manoel Louro
 * @date      08/04/2020
 */
function getRequisicaoPadraoListaEntregaRoteadorAJAX() {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroControleVendaAJAX',
            data: {
                operacao: 'getRoteadorEntregaParaUsuario'
            },
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

//START
initScript();