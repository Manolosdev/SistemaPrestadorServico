/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase do front-end.
 * 
 * @author    Manoel Louro
 * @data      23/11/2019
 */

var controller = {
    //CONTROLADOR DE SELECIONAMENTO DE CARD
    selecionarCard: true,
    //CONTADOR
    selecionarCardTime: 300
};

var controllerInterfaseGeral = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 17,
    /**
     * Determina o comportamento do elemento de paginacao inferior.
     * @type function
     */
    setEstadoPaginacao: function (registro) {
        if (registro['totalRegistro'] && registro['totalRegistro'] == 0) {
            this.setEstadoInicialPaginacao();
            return true;
        }
        //INIT ELEMENTS
        var totalRegistro = registro['totalRegistro'] ? parseInt(registro['totalRegistro']) : 0;
        var registroPorPagina = registro['listaRegistro'].length ? parseInt(registro['listaRegistro'].length) : this.getNumeroRegistroPorPaginacao;
        var paginaSelecionada = registro['paginaSelecionada'] ? parseInt(registro['paginaSelecionada']) : 0;
        var quantidadePaginas = Math.ceil(totalRegistro / this.getNumeroRegistroPorPaginacao);
        //PAGINAS ANTERIORES
        if (paginaSelecionada > 0) {
            //PAGINA ATUAL
            $('#cardListaBtnAtual').data('id', paginaSelecionada);
            $('#cardListaBtnAtual').html(paginaSelecionada);
            $('#cardListaBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaBtnAtual').prop('disabled', false);
            $('#cardListaTabelaSize').prop('class', '');
            $('#cardListaTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaBtnPrimeiro').data('id', 1);
                $('#cardListaBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnPrimeiro').prop('disabled', false);
                $('#cardListaBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaBtnPrimeiro').data('id', 0);
                $('#cardListaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaBtnPrimeiro').prop('disabled', true);
                $('#cardListaBtnAnterior').data('id', 0);
                $('#cardListaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnProximo').prop('disabled', false);
                $('#cardListaBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaBtnUltimo').prop('disabled', false);
            }
        } else {
            this.setEstadoInicialPaginacao();
        }
    },
    /**
     * Determina estado da paginação.
     * @type function
     */
    setEstadoInicialPaginacao: function () {
        //BTN PAGINATION
        $('#cardListaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnPrimeiro').prop('disabled', true);
        $('#cardListaBtnPrimeiro').data('id', 0);
        $('#cardListaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnAnterior').prop('disabled', true);
        $('#cardListaBtnAnterior').data('id', 0);
        $('#cardListaBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnAtual').prop('disabled', true);
        $('#cardListaBtnAtual').data('id', 0);
        $('#cardListaBtnAtual').html('...');
        $('#cardListaBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnProximo').prop('disabled', true);
        $('#cardListaBtnProximo').data('id', 0);
        $('#cardListaBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaBtnUltimo').prop('disabled', true);
        $('#cardListaBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaTabelaSize').prop('class', '');
        $('#cardListaTabelaSize').html('Nengum registro encontrado ...');
    }
};