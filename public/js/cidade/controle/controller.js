/**
 * JAVASCRIPT
 * 
 * Controlador de operações da interfase.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */

/**
 * Controlador da lista de registros (paginação)
 * @type array
 */
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

/**
 * Controlador da lista de registros (paginação)
 * @type array
 */
var controllerInterfaseGeralCardEditor = {
    //Objeto de ilustração do MAP
    map: null,
    //Marcação do maps
    coorX: -20.894207,
    coorY: -51.378088,
    circle: null,
    circleDois: null,
    /**
     * Inicia objeto GoogleMap determinando como padrão a unidade de Andradina.
     */
    setIniciarMap: async function () {
        this.coorX = ($('#cardEditorCoorLatitude').val() !== '' ? $('#cardEditorCoorLatitude').val() : -20.894207);
        this.coorY = ($('#cardEditorCoorLongitude').val() !== '' ? $('#cardEditorCoorLongitude').val() : -51.378088);
        //MAP
        var latLng = new google.maps.LatLng(this.coorX, this.coorY);
        var mapOptions = {
            zoom: 11,
            draggable: true,
            center: latLng,
            gestureHandling: 'greedy',
            disableDefaultUI: true
        };
        this.map = new google.maps.Map(document.getElementById('cardEditorMapa'), mapOptions);
        await sleep(500);
        //DRAW CIRCLE
        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [
                    google.maps.drawing.OverlayType.CIRCLE
                ]
            },
            circleOptions: {
                fillColor: '#7460ee',
                fillOpacity: .3,
                strokeWeight: 1.5,
                strokeColor: '#6a7a8c',
                clickable: false,
                editable: true,
                zIndex: 1
            }
        });
        drawingManager.setMap(this.map);
        google.maps.event.addListener(drawingManager, 'circlecomplete', this.onCircleComplete);
        //CHECK ELEMENT
        if ($('#cardEditorCoorLatitude').val() !== '' && $('#cardEditorCoorLongitude').val() !== '') {
            this.setCircleMap(parseFloat($('#cardEditorCoorLatitude').val()), parseFloat($('#cardEditorCoorLongitude').val()), parseInt($('#cardEditorCoorRaio').val()));
        }
        this.map.setZoom(11);
    },
    /**
     * Obtém coordenadas e o raio do circulo quando completado.
     */
    onCircleComplete: function (shape) {
        if (controllerInterfaseGeralCardEditor.circleDois != null) {
            controllerInterfaseGeralCardEditor.circleDois.setMap(null);
            controllerInterfaseGeralCardEditor.circleDois = null;
        }
        if (shape == null || (!(shape instanceof google.maps.Circle)))
            return;

        if (this.circle != null) {
            this.circle.setMap(null);
            this.circle = null;
        }
        this.circle = shape;
        $('#cardEditorCoorRaio').val(parseInt(this.circle.getRadius()));
        $('#cardEditorCoorRaio').removeClass('error').next('label.error').remove();
        $('#cardEditorCoorLatitude').val(this.circle.getCenter().lat());
        $('#cardEditorCoorLatitude').removeClass('error').next('label.error').remove();
        $('#cardEditorCoorLongitude').val(this.circle.getCenter().lng());
        $('#cardEditorCoorLongitude').removeClass('error').next('label.error').remove();
    },
    /**
     * Desenha circulo no mapa.
     */
    setCircleMap: function (latitude, longitude, raio) {
        this.circleDois = new google.maps.Circle({
            fillColor: '#7460ee',
            fillOpacity: .3,
            strokeWeight: 1.5,
            strokeColor: '#6a7a8c',
            clickable: false,
            editable: true,
            zIndex: 1,
            map: this.map,
            center: {
                lat: latitude,
                lng: longitude
            },
            radius: raio
        });
        this.map.fitBounds(this.circleDois.getBounds());
    }
};