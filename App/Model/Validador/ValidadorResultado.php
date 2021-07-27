<?php

namespace App\Model\Validador;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por armazenar os erros de validação em uma lista.
 * 
 * @package   App\Validadores
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class ValidadorResultado {

    /**
     * Lista para armazenamento de erros
     * @var array
     */
    private $erros = [];

    /**
     * <b>FUNCTION</b>
     * <br>Adiciona elemento (erro) a lista de erros
     * 
     * @param     string $campo Nome do campo de erro
     * @param     string $mensagem Descrição do erro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function addErro($campo, $mensagem) {
        array_push($this->erros, array($campo, $mensagem));
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de erros armazenados.
     * 
     * @return    array Lista de erros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getErros() {
        return $this->erros;
    }

}
