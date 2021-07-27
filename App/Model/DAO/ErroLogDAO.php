<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por operações de CRUD relacionados a <b>ERROS</b> capturados
 * no sistema
 * 
 * Objeto destinado o captura de erros em função que não estejam na camada DAO,
 * sendo uma plataforma para registros de problemas encontrados. 
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      16/06/2021
 */
class ErroLogDAO extends BaseDAO {

    /**
     * Tabela principal
     * @var string
     */
    static $NOME_TABELA = 'erro_log';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <Override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - INSERT -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Armazena registro de erro no banco de dados.
     * 
     * @param     string $origem Local do erro
     * @param     string $erro Descrição do erro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function setErro($origem, $erro) {
        $this->setErroDAO($origem, $erro);
        return true;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                                - VIEW -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna vetor do registro informado por parametro.
     * 
     * @param     integer $registroID ID do registro
     * @return    array Vetor carregada com informações
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
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
                    $retorno['id'] = $registro['id'];
                    $retorno['local'] = ($registro['local']);
                    $retorno['descricao'] = ($registro['descricao']);
                    $retorno['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($registro['data_cadastro'])), 0, 16);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros de acordo com os parametros informados.
     * 
     * @param     string $dataInicial Data inicial da consulta
     * @param     string $dataFinal Data final da consulta
     * @param     string $pesquisaLocal Filtro de pesquisa da consulta
     * @param     integer $numeroPagina Filtro da paginação
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Retorna lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function getListaControle($dataInicial, $dataFinal, $pesquisaLocal = "", $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT e.* FROM " . self::$NOME_TABELA . " AS e
                    WHERE e.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' AND local LIKE '%" . $pesquisaLocal . "%' 
                    ORDER BY e.id DESC LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = $value['id'];
                    $registro['local'] = ($value['local']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros da consulta informada, utilizado para 
     * paginação do sistema.
     * 
     * @param     string $dataInicial Data inicial da consulta
     * @param     string $dataFinal Data final da consulta
     * @param     string $pesquisaLocal Filtro da pesquisa da consulta
     * @return    integer Numero de registro encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function getListaControleTotal($dataInicial, $dataFinal, $pesquisaLocal = "") {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(e.id) AS 'total' FROM " . self::$NOME_TABELA . " AS e
                    WHERE e.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' AND local LIKE '%" . $pesquisaLocal . "%'"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registro do ultimo semestre registrado de acordo 
     * com os parametros informados
     * 
     * @return    array Lista de registro encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function getEstatisticaSemestral() {
        $retorno = [];
        try {
            for ($i = 6; $i > 0; $i--) {
                $resultado = $this->select(
                        "SELECT count(id) AS 'total' FROM " . self::$NOME_TABELA . " 
                        WHERE data_cadastro BETWEEN '" . date('Y-m-01', strtotime('-' . $i . ' month')) . " 00:00' AND '" . date('Y-m-31', strtotime('-' . $i . ' month')) . " 23:59'"
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    array_push($retorno, $registros[0]['total']);
                } else {
                    array_push($retorno, 0);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registro encontrados dentro do sistema.
     * 
     * @param     string $dataInicial Data inicial da consulta
     * @param     string $dataFinal Data final da consulta
     * @return    integer Quantidade retorno
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function getQuantidadeRegistro($dataInicial, $dataFinal) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(e.id) AS 'total' FROM " . self::$NOME_TABELA . " AS e 
                    WHERE e.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59'"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = intval($resultado->fetchAll()[0]['total']);
            }
        } catch (\PDOException $erro) {
            $this->setErro(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

}
