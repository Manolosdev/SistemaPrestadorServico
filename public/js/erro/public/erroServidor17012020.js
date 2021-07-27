/**
 * PUBLIC FUNCTION
 * Exibe lista de ERRO(s) encontrados no servidor.
 * 
 * @author    Manoel Louro
 * @date      17/01/2020
 */

/**
 * FUNCTION
 * Constroi e ilustra lista de erros retornados do SERVIDOR.
 * 
 * @author    Manoel Louro
 * @date      17/01/2020
 */
function setErroServidor(erroLista = null) {
    getErroServidorInitHTML();
    if (erroLista && erroLista.length) {
        $('#tabelaErroServidor').html('');
        for (var i = 0; i < erroLista.length; i++) {
            var registro = erroLista[i];
            var html = '';
            html += '<div style="margin-bottom: 5px">';
            html += '   <p class="text-danger" style="padding-top: 8px;margin-bottom: 0px"><b>' + registro[0] + '</b></p>';
            html += '   <small class="text-danger">' + registro[1] + '</small>';
            html += '</div>';
            $('#tabelaErroServidor').append(html);
        }
    } else {
        $('#tabelaErroServidor').html('<p class="text-danger" style="padding-top: 15px">Nenhum registro encontrado ...</p>');
    }
    $('#cardErroServidor').fadeIn(0);
    $('#cardErroServidorCard').addClass('animated shake');
    toastr.error('Ocorreu um erro no servidor', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
    setTimeout(function () {
        $('#cardErroServidorCard').removeClass('animated shake');
    }, 1000);
}

////////////////////////////////////////////////////////////////////////////////
//                              - FUNCTIONS -                                 //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi do elemento HTML.
 * 
 * @param     {array} registro Registro da venda informada
 * @author    Manoel Louro 
 * @date      17/01/2020
 */
function getErroServidorInitHTML() {
    if (!document.querySelector("#cardErroServidor")) {
        //CREATE ELEMENT HTML
        var html = '';
        html += '<div class="internalPage" id="cardErroServidor" style="display: none;background: rgba(0,0,0,.7)">';
        html += '   <div class="col-12" style="max-width: 450px">';
        html += '       <div class="card" style="margin: 0" id="cardErroServidorCard">';
        html += '           <div class="card-body bg-light" style="padding: 15px; padding-top: 10px;padding-bottom: 7px;margin-bottom: 1px">';
        html += '               <p class="text-danger mb-0" style="font-size: 17px">Erro Interno</p>';
        html += '           </div>';
        html += '           <div class="card-body bg-light" style="padding: 15px;padding-top: 10px; padding-bottom: 10px">';
        html += '                <div class="row">';
        html += '                    <div class="col-md-auto d-none d-md-block" style="padding-right: 5px">';
        html += '                        <i class="mdi mdi-server-off text-danger" style="font-size: 23px"></i>';
        html += '                    </div>';
        html += '                    <div class="col">';
        html += '                        <p class="text-danger mb-0 text-truncate" style="font-size: 13px;padding-top: 7px">Informe o administrador do sistema</p>';
        html += '                    </div>';
        html += '                </div>';
        html += '            </div>';
        html += '            <div class="card-body scroll" style="height: 350px;padding: 15px;padding-bottom: 0px;padding-top: 0px" id="tabelaErroServidor">';
        html += '            </div>';
        html += '            <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">';
        html += '                <div class="row">';
        html += '                    <div class="col" style="max-width: 80px;padding-right: 0">';
        html += '                        <button type="button" class="btn btn-dark pull-left font-11" id="btnCardErroServidorBack" style="width: 100%" tabIndex="-1">';
        html += '                            <i class="mdi mdi-arrow-left"></i>';
        html += '                        </button>';
        html += '                    </div>';
        html += '                </div>';
        html += '            </div>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';

        //SET HTML
        $('body').append(html);
    }
    $('#btnCardErroServidorBack').on('click', function () {
        $(this).blur();
        $('#cardErroServidor').fadeOut(150);
    });
    //SET SCROLL
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
}

/**
 * FUNCTION INTERNAL
 * Verifica se parametro informado é um ARRAY
 * 
 * @param     {type} what
 * @returns   {Boolean}
 * @author    Manoel Louro
 * @date      20/12/2019
 */
function isArray(what) {
    return Object.prototype.toString.call(what) === '[object Array]';
}


