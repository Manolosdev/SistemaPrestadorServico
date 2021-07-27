<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorResultado;

/**
 * <b>CLASS</b>
 * 
 * Classe generica com operações basicas de validação de entidades.
 *
 * @package   App\Model\Validador
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
abstract class ValidadorBase {

    /**
     * Entidade com resuldado da validacao
     * @var ValidadorResultado 
     */
    protected $validadorResultado;

    /**
     * <b>FUNCTION</b>
     * <br>Inicia dependencias do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function __construct() {
        $this->validadorResultado = new ValidadorResultado();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                         - PROTECTED FUNCTIONS -                        //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////
    
    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Verifica se tamanho do parametro possui o valor minimo e maximo 
     * determinados por parametro.
     * <protected>
     * 
     * @param     string $valor Valor a ser validado
     * @param     integer $minLenght Valor minino do lenght
     * @param     integer $maxLenght Valor maximo do lenght
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    protected function isLenght($valor, $minLength, $maxLength) {
        if (empty($valor)) {
            return false;
        }
        if (strlen($valor) < $minLength) {
            return false;
        }
        if (strlen($valor) > $maxLength) {
            return false;
        }
        return true;
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Verifica se valor é nulo, vazio ou apenas um espaço.
     * <protected>
     * 
     * @param     string $valor Valor a ver verificado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    protected function isEmpty($valor) {
        if (empty($valor) || $valor == '' || $valor == null) {
            return true;
        }
        return false;
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Valida date em formato yyyy-mm-dd.
     * <protected>
     * 
     * @param     string $dat Date a ser formatada
     * @link      https://www.codigofonte.com.br/codigos/validar-date-php-checkdate 
     *            ADAPTADO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    protected function validaDate($dat) {
        $date = explode("-", "$dat");
        $d = $date[2];
        $m = $date[1];
        $y = $date[0];
        $res = checkdate($m, $d, $y);
        if ($res == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Validador documento de CPF informado.
     * <protected>
     * 
     * @param     striong $cpf Cpf informado
     * @return    boolean OK|ERRO
     * @link      http://www.geradorcpf.com/script-validar-cpf-php
     * @author    Manoel Louro <manoel.louro@retelecom.com.br>
     * @date      17/06/2021
     */
    protected function validaCPF($cpf = null) {
        if (empty($cpf)) {
            return false;
        }
        $cpf = preg_replace('/[^[:digit:]]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        if (strlen($cpf) != 11) {
            return false;
        }
        else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return false;
        } else {
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Validador de documento de CNPJ.
     * <protected>
     * 
     * @param     string $cnpj CNPJ informado
     * @return    boolean OK|ERRO
     * @link      https://www.todoespacoonline.com/w/2014/08/validar-cnpj-com-php/
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    protected function validaCNPJ($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        $cnpj = (string) $cnpj;
        $cnpj_original = $cnpj;
        $primeiros_numeros_cnpj = substr($cnpj, 0, 12);
        if (!function_exists('multiplica_cnpj')) {
            function multiplica_cnpj($cnpj, $posicao = 5) {
                $calculo = 0;
                for ($i = 0; $i < strlen($cnpj); $i++) {
                    $calculo = $calculo + ( $cnpj[$i] * $posicao );
                    $posicao--;
                    if ($posicao < 2) {
                        $posicao = 9;
                    }
                }
                return $calculo;
            }
        }
        $primeiro_calculo = multiplica_cnpj($primeiros_numeros_cnpj);
        $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 : 11 - ( $primeiro_calculo % 11 );
        $primeiros_numeros_cnpj .= $primeiro_digito;
        $segundo_calculo = multiplica_cnpj($primeiros_numeros_cnpj, 6);
        $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 : 11 - ( $segundo_calculo % 11 );
        $cnpj = $primeiros_numeros_cnpj . $segundo_digito;
        if ($cnpj === $cnpj_original) {
            return true;
        }
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Efetua conexão webservice para obter endereço atraves do cep informado.
     * <protected>
     * 
     * @param     string $cep CEP informado
     * @return    string XML de retorno do <b>VIA CEP</b>
     * @link      https://www.youtube.com/watch?v=MxXUyqzXSwE
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    protected function getEnderecoViaCep($cep) {
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $url = "http://viacep.com.br/ws/$cep/xml/";
        $xml = simplexml_load_file($url);
        return $xml;
    }
    
}
