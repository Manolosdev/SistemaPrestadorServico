<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeFinanceiroPagamentoTipo;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de armazenamento de informações 
 * relacionadas aos tipos de pagamentos dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      29/06/2021
 */
class FinanceiroPagamentoTipoDAO extends BaseDAO {

    /**
     * Nome da tabela principal
     * @var string
     */
    static $NOME_TABELA = 'fin_pagamento_tipo';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependencias do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                             - VIEW -                                   //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    EntidadeFinanceiroPagamentoTipo Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeFinanceiroPagamentoTipo();
        if ($entidade->getId() > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $entidade = $this->setCarregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    array Resultado retornado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getVetor($registroID) {
        $retorno = [];
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registro = $resultado->fetchAll()[0];
                    $retorno['id'] = intval($registro['id']);
                    $retorno['situacaoRegistro'] = intval($registro['situacao_registro']);
                    $retorno['nome'] = $registro['nome'];
                    $retorno['descricao'] = $registro['descricao'];
                    $retorno['parcelaMinimo'] = intval($registro['parcela_minimo']);
                    $retorno['parcelaMaximo'] = intval($registro['parcela_maximo']);
                    $retorno['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($registro['data_cadastro'])), 0, 10);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de entidade cadastradas dentro do sistema de acordo com 
     * parametro informado.
     * 
     * @param     integer $situacaoRegistro Filtro de situação informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getListaEntidade($situacaoRegistro = null) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA .
                    ($situacaoRegistro >= 0 ? "WHERE situacao_registro = " . $situacaoRegistro : "")
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    array_push($retorno, $this->setCarregarEntidade($value));
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de array de registros cadastradas dentro do sistema de 
     * acordo com parametro informado.
     * 
     * @param     integer $situacaoRegistro Filtro de situação informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getListaVetor($situacaoRegistro = 10) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA .
                    ($situacaoRegistro < 10 ? " WHERE situacao_registro = " . $situacaoRegistro : "")
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = intval($value['id']);
                    $registro['situacaoRegistro'] = intval($value['situacao_registro']);
                    $registro['nome'] = $value['nome'];
                    $registro['descricao'] = $value['descricao'];
                    $registro['parcelaMinimo'] = intval($value['parcela_minimo']);
                    $registro['parcelaMaximo'] = intval($value['parcela_maximo']);
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 10);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                          - INTERNAL FUNCTION -                         //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega entidade de acordo com registro informado.
     * 
     * @param     array $registro Registro informado
     * @return    EntidadeFinanceiroPagamentoTipo Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeFinanceiroPagamentoTipo();
        if (!empty($registro)) {
            $entidade->setId(intval($registro['id']));
            $entidade->setSituacaoRegistro(intval($registro['situacao_registro']));
            $entidade->setNome($registro['nome']);
            $entidade->setDescricao($registro['descricao']);
            $entidade->setParcelaMinimo(intval($registro['parcela_minimo']));
            $entidade->setParcelaMaximo(intval($registro['parcela_maximo']));
            $entidade->setDataCadastro($registro['data_cadastro']);
        }
        return $entidade;
    }

}
