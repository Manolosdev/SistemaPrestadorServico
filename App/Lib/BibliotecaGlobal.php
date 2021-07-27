<?php

/**
 * <b>SCRIPT DE FERRAMENTAS</b>
 * 
 * Script com funcionadades e utilitários para execução do sistema.
 * <br>O objetivo é facilitar o acesso a funções basicas ou rotinas bastantes 
 * requisitadas
 * 
 * @package   App\Lib
 * @author    Original Manoel Louro <manoel.louro@retelecom.com.br>
 * @date      10/05/2019
 */

/**
 * <b>FUNÇÃO FERRAMENTA</b>
 * <br>Verifica se chave/indice existe no array informado.
 * 
 * @param     string $chave Nome do indice
 * @param     array $array Lista a ser verificada
 * @return    boolean OK|ERRO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      10/05/2019
 */
function chaveExiste($chave, $array) {
    if (!isset($chave) || !isset($array) || !is_array($array) || is_null($chave) || is_null($array)) {
        return false;
    } else {
        return array_key_exists($chave, $array);
    }
}

/**
 * <b>FUNÇÃO FERRAMENTA</b>
 * <br>Reduz parametro informado de acordo com tamanho especificado.
 * <br><b>Exemplo:</b> 'texto_texto_texto' = 'texto_tex...'
 * 
 * @param     string $texto String a ser formatada
 * @param     integer $tamanho Tamanho a ser formatado
 * @return    string String formatada
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      10/05/2019
 */
function concatTexto($texto, $tamanho) {
    if (gettype($texto) == 'string') {
        if (strlen($texto) > $tamanho) {
            $texto = substr($texto, 0, ($tamanho - 3)) . '...';
        }
    }
    return $texto;
}

////////////////////////////////////////////////////////////////////////////////
//                         - CONVERSORES DE FILES -                           //
////////////////////////////////////////////////////////////////////////////////

/**
 * <b>FUNÇÃO DE VALIDACAO</b>
 * <br>Verifica se parametro BASE64 possui tamanho e tipo correto
 * <br><b>CRITERIOS: </b>File menor que 3MB e fileType = png, jpeg e jpg
 * 
 * @param     booble $imageBase64 Arquivo de imagem base64 informado
 * @return    boolean OK|ERRO
 * @link      https://stackoverflow.com/questions/12658661/validating-base64-encoded-images
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      09/04/2019
 */
function validarDocumentoBase64($imageBase64) {
    //TIPOS DE ARQUIVOS SUPORTADOSS
    $LISTA_IMAGE = ['image/jpeg', 'image/jpg', 'image/png'];
    //VERIFICA TAMANHO DO ARQUIVO
    $size_in_bytes = (int) (strlen(rtrim($imageBase64, '=')) * 3 / 4);
    $size_in_kb = (int) ($size_in_bytes / 1024);
    if ($size_in_kb > 3000) {
        return false;
    }
    //VERIFICA TIPO DO ARQUIVO
    $arquivo = getimagesize($imageBase64);
    if (!in_array(strtolower($arquivo['mime']), $LISTA_IMAGE)) {
        return false;
    }
    return true;
}

/**
 * <b>FUNÇÃO DE CONVERSÃO</b>
 * <br>Converte e redimenciona upload de file do front-end para variavel base64.
 * <br>OBS: Deve se enviar como parametro $_FILES['name']
 * 
 * @param     array $file $_FILES do arquivo de upload
 * @return    string String do arquivo convertido em base64
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      22/05/2019
 */
function convertePostFileBase64($files, $largura = 250, $altura = 250) {
    //PADRONIZACAO
    $wPadrao = $largura;
    $hPadrao = $altura;
    //VERIFICA TIPO
    switch ($files['type']) {
        case 'image/png':
            $image = imagecreatefrompng($files['tmp_name']);
            list($w, $h) = getimagesize($files['tmp_name']);
            $image = imagescale($image, ($w > $wPadrao ? $wPadrao : $w), ($h > $hPadrao ? $hPadrao : $h));
            ob_start();
            imagepng($image);
            $contents = ob_get_contents();
            ob_end_clean();
            return "data:image/png;base64," . base64_encode($contents);
        case 'image/jpeg':
            $image = imagecreatefromjpeg($files['tmp_name']);
            list($w, $h) = getimagesize($files['tmp_name']);
            $image = imagescale($image, ($w > $wPadrao ? $wPadrao : $w), ($h > $hPadrao ? $hPadrao : $h));
            ob_start();
            imagejpeg($image);
            $contents = ob_get_contents();
            ob_end_clean();
            return "data:image/jpeg;base64," . base64_encode($contents);
    }
    return '';
}

/**
 * <b>FUNÇÃO DE CONVERSÃO</b>
 * <br>Converte arquivo BASE64 em string para upload na base dados.
 * 
 * @param     string $base64 Arquivo em BASE64
 * @return    string String para armazenamento em BD blob
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      22/05/2019
 */
function converterBase64String($base64) {
    list($tipo, $dados) = explode(';', $base64);
    //ISOLANDO APENAS O TIPO DA IMAGEM
    list(, $tipo) = explode('/', $tipo);
    //ISOLANDO APENAS O DADOS DA IMAGEM
    list(, $dados) = explode(',', $dados);
    //CONVERTENDO PARA BASE64
    return base64_decode($dados);
}

/**
 * <b>FUNÇÃO INTERNA</b>
 * <br>Converte data no formato SQL para formato front-end.
 * EX1: Caso a data atual seja igual a '31/05/2019 09:30' sendo a data 
 * informada o mesmo dia o formato de retorno seria 'Hoje 09:30'.
 * EX2: Caso a data informada seja 30/05/2019 08:30 o retorno seria 
 * 'Ontem 08:30'.
 * 
 * @param     string $dataSql Data no formato YYYY-MM-DD HH:MM:SS
 * @return    string String formatada
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      31/05/2019
 */
function converterData($dataSql) {
    $retorno = 'Não visualizado';
    if (!empty($dataSql)) {
        $data = substr($dataSql, 0, 10);
        $hora = substr($dataSql, 11, 5);
        if (strtotime($data) === strtotime(date('Y-m-d'))) {
            $retorno = 'Hoje as ' . $hora;
        } else if (true) {
            $retorno = date('d/m/Y', strtotime($data)) . ' as ' . $hora;
        } else {
            $retorno = date('d/m/Y', strtotime($data)) . ' as ' . $hora;
        }
    }
    return $retorno;
}

/**
 * <b>FUNÇÃO PESQUISA</b>
 * <br>Função de pesquisa de ocorrencia de valor informado em
 * registro informado, retorna TRUE caso valor se encontre em
 * registro.
 * 
 * @param     string $valor Valor a ser pesquisado
 * @param     $tring $registro Texto a ser pesquisa ocorrencia
 * @return    boolean OK|ERRO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      08/07/2019
 */
function verificarValorRegistro($valor, $registro) {
    if (is_array($valor)) {
        foreach ($valor as $value) {
            $pattern = '/' . $value . '/';
            if (preg_match($pattern, $registro)) {
                return true;
            }
        }
    } else {
        $pattern = '/' . $valor . '/';
        if (preg_match($pattern, $registro)) {
            return true;
        }
    }
    return false;
}

/**
 * <b>FUNTION CHECK</b>
 * <br>Verifica se valor informado é do tipo INTEIRO.
 * 
 * @param     type $valor Valor a ser verificado
 * @return    boolean TRUE|FALSE
 * @author    Manoel Louro <manoel.louro@redetelecom.com.nbr>
 * @date      22/07/2019
 */
function isInt($valor) {
    if ((int) $valor !== $valor) {
        return true;
    }
    return false;
}

/**
 * <b>FUNCTION</b>
 * <br>Retorna o intervalo de dias entre duas datas.
 * 
 * @param     string $data1 Data inicial
 * @param     string $data2 Data final
 * @return    integer Numero de dias
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      05/02/2020
 */
function getIntervaloDiasEntreDatas($data1, $data2) {
    return date_diff(date_create($data2), date_create($data1))->format('%a');
}

/**
 * <b>FUNCTION</b>
 * <br>Verifica se parametro informado possui sessão criada.
 * 
 * @author    Manoel Louro
 * @date      23/09/2019
 */
function checkSession($param) {
    if (isset($param) && !empty($param) && $param != null) {
        return $param;
    }
    return null;
}

/**
 * <b>FUNCTION<b>
 * <br>Efetua validação de registro informado.
 * <br>UTILIZADO NO LOGIN DO USUARIO
 * 
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      11/05/2020
 */
function setFormatarAutenticacao($valor) {
    $valor = trim($valor);
    $valor = str_replace('', '', $valor);
    $valor = str_replace('-', '', $valor);
    $valor = str_replace('/', '', $valor);
    $valor = str_replace('=', '', $valor);
    return $valor;
}

/**
 * <b>FUNCTION</b>
 * <br>Efetua recorte de STRING a partir dos parametros informados
 * 
 * @param     string $string String a ser recordada
 * @param     string $start A partir dessa ocorrencia
 * @param     string $end Até essa ocorrencia
 * @return    string Recorte retornado
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      13/08/2020
 */
function getRecortarString($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/**
 * <b>FUNCTION</b>
 * <br>Função que verifica se registro existe na lista informada
 * 
 * @param     array $array Lista a ser pesquisada
 * @param     string $key Valor a ser pesquisado na lista
 * @return    string Retorna valor caso encontrado
 * @return    null Retorna nulo caso nao seja encontrado ocorrencia
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      19/08/2020
 */
function verificaArray($array, $key) {
    if (isset($array[$key]) && !empty($array[$key])) {
        return $array[$key];
    }
    return null;
}

/**
 * <b>FUNCTION</b>
 * <br>Efetua as configurações de acesso a plataforma OMIE.
 * 
 * @param     integer $empresaID Codigo da empresa
 * @author    Manoel Louro
 * @date      22/01/2021
 */
function setOmieConfig($empresaID) {
    if ($empresaID > 0) {
        $empresaDAO = new App\Model\DAO\EmpresaDAO();
        $entidade = $empresaDAO->getEntidade($empresaID);
        $GLOBALS['OMIE_APP_KEY'] = $entidade->getIntegracaoOmieAppKey();
        $GLOBALS['OMIE_APP_SECRET'] = $entidade->getIntegracaoOmieAppSecret();
        $GLOBALS['OMIE_USER_LOGIN'] = $entidade->getIntegracaoOmieAppLogin();
        $GLOBALS['OMIE_USER_PASSWORD'] = $entidade->getIntegracaoOmieAppPassword();
        return;
    }
    $GLOBALS['OMIE_APP_KEY'] = \App\Lib\Sessao::getUsuario()->getEntidadeEmpresa()->getIntegracaoOmieAppKey();
    $GLOBALS['OMIE_APP_SECRET'] = \App\Lib\Sessao::getUsuario()->getEntidadeEmpresa()->getIntegracaoOmieAppSecret();
    $GLOBALS['OMIE_USER_LOGIN'] = \App\Lib\Sessao::getUsuario()->getEntidadeEmpresa()->getIntegracaoOmieAppLogin();
    $GLOBALS['OMIE_USER_PASSWORD'] = \App\Lib\Sessao::getUsuario()->getEntidadeEmpresa()->getIntegracaoOmieAppPassword();
}
