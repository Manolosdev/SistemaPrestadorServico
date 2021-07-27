/**
 * CONTROLLER
 * 
 * Objeto responsavel pelo controle de elementos e rotinas da interfase.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */

var controllerInterfaseGeral = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 17
};

//TAB PRODUTO
var controllerInterfaseTabProduto = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 16,
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
            $('#cardListaProdutoBtnAtual').data('id', paginaSelecionada);
            $('#cardListaProdutoBtnAtual').html(paginaSelecionada);
            $('#cardListaProdutoBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaProdutoBtnAtual').prop('disabled', false);
            $('#cardListaProdutoTabelaSize').prop('class', '');
            $('#cardListaProdutoTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaProdutoBtnPrimeiro').data('id', 1);
                $('#cardListaProdutoBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaProdutoBtnPrimeiro').prop('disabled', false);
                $('#cardListaProdutoBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaProdutoBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaProdutoBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaProdutoBtnPrimeiro').data('id', 0);
                $('#cardListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaProdutoBtnPrimeiro').prop('disabled', true);
                $('#cardListaProdutoBtnAnterior').data('id', 0);
                $('#cardListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaProdutoBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaProdutoBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaProdutoBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaProdutoBtnProximo').prop('disabled', false);
                $('#cardListaProdutoBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaProdutoBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaProdutoBtnUltimo').prop('disabled', false);
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
        $('#cardListaProdutoBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaProdutoBtnPrimeiro').prop('disabled', true);
        $('#cardListaProdutoBtnPrimeiro').data('id', 0);
        $('#cardListaProdutoBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaProdutoBtnAnterior').prop('disabled', true);
        $('#cardListaProdutoBtnAnterior').data('id', 0);
        $('#cardListaProdutoBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaProdutoBtnAtual').prop('disabled', true);
        $('#cardListaProdutoBtnAtual').data('id', 0);
        $('#cardListaProdutoBtnAtual').html('...');
        $('#cardListaProdutoBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaProdutoBtnProximo').prop('disabled', true);
        $('#cardListaProdutoBtnProximo').data('id', 0);
        $('#cardListaProdutoBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaProdutoBtnUltimo').prop('disabled', true);
        $('#cardListaProdutoBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaProdutoTabelaSize').prop('class', '');
        $('#cardListaProdutoTabelaSize').html('Nengum registro encontrado ...');
    }
};

//TAB ENTRADA
var controllerInterfaseTabEntrada = {
    /**
     * Numero de registros por paginacao
     * @type integer
     */
    getNumeroRegistroPorPaginacao: 16,
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
            $('#cardListaEntradaBtnAtual').data('id', paginaSelecionada);
            $('#cardListaEntradaBtnAtual').html(paginaSelecionada);
            $('#cardListaEntradaBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaEntradaBtnAtual').prop('disabled', false);
            $('#cardListaEntradaTabelaSize').prop('class', '');
            $('#cardListaEntradaTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaEntradaBtnPrimeiro').data('id', 1);
                $('#cardListaEntradaBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaEntradaBtnPrimeiro').prop('disabled', false);
                $('#cardListaEntradaBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaEntradaBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaEntradaBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaEntradaBtnPrimeiro').data('id', 0);
                $('#cardListaEntradaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaEntradaBtnPrimeiro').prop('disabled', true);
                $('#cardListaEntradaBtnAnterior').data('id', 0);
                $('#cardListaEntradaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaEntradaBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaEntradaBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaEntradaBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaEntradaBtnProximo').prop('disabled', false);
                $('#cardListaEntradaBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaEntradaBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaEntradaBtnUltimo').prop('disabled', false);
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
        $('#cardListaEntradaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaEntradaBtnPrimeiro').prop('disabled', true);
        $('#cardListaEntradaBtnPrimeiro').data('id', 0);
        $('#cardListaEntradaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaEntradaBtnAnterior').prop('disabled', true);
        $('#cardListaEntradaBtnAnterior').data('id', 0);
        $('#cardListaEntradaBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaEntradaBtnAtual').prop('disabled', true);
        $('#cardListaEntradaBtnAtual').data('id', 0);
        $('#cardListaEntradaBtnAtual').html('...');
        $('#cardListaEntradaBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaEntradaBtnProximo').prop('disabled', true);
        $('#cardListaEntradaBtnProximo').data('id', 0);
        $('#cardListaEntradaBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaEntradaBtnUltimo').prop('disabled', true);
        $('#cardListaEntradaBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaEntradaTabelaSize').prop('class', '');
        $('#cardListaEntradaTabelaSize').html('Nengum registro encontrado ...');
    }
};

//TAB SAIDA
var controllerInterfaseTabSaida = {
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
            $('#cardListaSaidaBtnAtual').data('id', paginaSelecionada);
            $('#cardListaSaidaBtnAtual').html(paginaSelecionada);
            $('#cardListaSaidaBtnAtual').prop('class', 'btn btn-info btn-sm');
            $('#cardListaSaidaBtnAtual').prop('disabled', false);
            $('#cardListaSaidaTabelaSize').prop('class', '');
            $('#cardListaSaidaTabelaSize').html('Mostrando <b>' + registroPorPagina + '</b> registros de <b>' + totalRegistro + '</b> registros, página <b>' + paginaSelecionada + '</b>/<b>' + quantidadePaginas + '</b>');
            //PAGINA ANTERIOR
            if (paginaSelecionada > 1) {
                $('#cardListaSaidaBtnPrimeiro').data('id', 1);
                $('#cardListaSaidaBtnPrimeiro').prop('class', 'btn btn-info btn-sm');
                $('#cardListaSaidaBtnPrimeiro').prop('disabled', false);
                $('#cardListaSaidaBtnAnterior').data('id', (paginaSelecionada - 1));
                $('#cardListaSaidaBtnAnterior').prop('class', 'btn btn-info btn-sm');
                $('#cardListaSaidaBtnAnterior').prop('disabled', false);
            } else {
                $('#cardListaSaidaBtnPrimeiro').data('id', 0);
                $('#cardListaSaidaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaSaidaBtnPrimeiro').prop('disabled', true);
                $('#cardListaSaidaBtnAnterior').data('id', 0);
                $('#cardListaSaidaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
                $('#cardListaSaidaBtnAnterior').prop('disabled', true);
            }
            //PROXIMA PAGINA
            if (quantidadePaginas > paginaSelecionada) {
                $('#cardListaSaidaBtnProximo').data('id', (paginaSelecionada + 1));
                $('#cardListaSaidaBtnProximo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaSaidaBtnProximo').prop('disabled', false);
                $('#cardListaSaidaBtnUltimo').data('id', quantidadePaginas);
                $('#cardListaSaidaBtnUltimo').prop('class', 'btn btn-info btn-sm');
                $('#cardListaSaidaBtnUltimo').prop('disabled', false);
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
        $('#cardListaSaidaBtnPrimeiro').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaSaidaBtnPrimeiro').prop('disabled', true);
        $('#cardListaSaidaBtnPrimeiro').data('id', 0);
        $('#cardListaSaidaBtnAnterior').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaSaidaBtnAnterior').prop('disabled', true);
        $('#cardListaSaidaBtnAnterior').data('id', 0);
        $('#cardListaSaidaBtnAtual').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaSaidaBtnAtual').prop('disabled', true);
        $('#cardListaSaidaBtnAtual').data('id', 0);
        $('#cardListaSaidaBtnAtual').html('...');
        $('#cardListaSaidaBtnProximo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaSaidaBtnProximo').prop('disabled', true);
        $('#cardListaSaidaBtnProximo').data('id', 0);
        $('#cardListaSaidaBtnUltimo').prop('class', 'btn btn-secondary btn-sm');
        $('#cardListaSaidaBtnUltimo').prop('disabled', true);
        $('#cardListaSaidaBtnUltimo').data('id', 0);
        //TABELA SIZE
        $('#cardListaSaidaTabelaSize').prop('class', '');
        $('#cardListaSaidaTabelaSize').html('Nengum registro encontrado ...');
    }
};
