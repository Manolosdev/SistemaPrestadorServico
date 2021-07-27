<?php

namespace App\Model\DAO;

use App\Lib\ConexaoBD;

/**
 * <b>ABSTRACT CLASS</b>
 * 
 * Responsável pelas operações de CRUD na base de dados padrão.
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      01/05/2019
 * @update    16/06/2021
 */
abstract class BaseDAO {

    /**
     * Conexão padrão do sistema.
     * @var PDO
     */
    private $conexao;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicia dependencias do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    function __construct() {
        $this->conexao = ConexaoBD::getConnection();
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Instrução SELECT na base de dados.
     * <protected>
     * 
     * @param     string $sql Instrução informada
     * @return    \PDOStatement Retorna resultado da VIEW
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @data      16/06/2021
     */
    protected function select($sql) {
        if (!empty($sql)) {
            try {
                return $this->conexao->query($sql);
            } catch (\PDOException $erro) {
                $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                $this->setErroDAO($trace[count($trace) - 1]['class'] . '::' . $trace[count($trace) - 1]['function'], $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Instrução INSERT na base de dados.
     * <protected>
     * 
     * @param     string $tabela Nome da tabela informada
     * @param     array $colunas Lista de colunas informada
     * @param     array $valores Lista de valores informado
     * @return    integer 1 - OK, 0 - ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    protected function insert($tabela, $colunas, $valores) {
        if (!empty($tabela) && !empty($colunas)) {
            try {
                $parametros = $colunas;
                $colunas = str_replace(":", "", $colunas);
                $stmt = $this->conexao->prepare("INSERT INTO $tabela ($colunas) VALUES ($parametros)");
                $stmt->execute($valores);
                return $stmt->rowCount();
            } catch (\PDOException $erro) {
                $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                $this->setErroDAO($trace[count($trace) - 1]['class'] . '::' . $trace[count($trace) - 1]['function'], $erro->getMessage());
            }
        } else {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $this->setErroDAO($trace[count($trace) - 1]['class'] . '::' . $trace[count($trace) - 1]['function'], $erro->getMessage());
        }
        return 0;
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Instrução UPDATE na base de dados.
     * <protected>
     * 
     * @param     string $tabela Nome da tabela informada
     * @param     array $colunas Lista de colunas informada
     * @param     array $valores Lista de valores informada
     * @param     string where Condição da instrução informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    protected function update($tabela, $colunas, $valores, $where = null) {
        if (!empty($tabela) && !empty($colunas) && !empty($valores)) {
            if ($where) {
                $where = " WHERE $where ";
            }
            try {
                $stmt = $this->conexao->prepare("UPDATE $tabela SET $colunas $where");
                $stmt->execute($valores);
                return $stmt->rowCount();
            } catch (\PDOException $erro) {
                $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                $this->setErroDAO($trace[count($trace) - 1]['class'] . '::' . $trace[count($trace) - 1]['function'], $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>Instrução DELETE em registro na base de dados
     * 
     * @param     string $tabela Nome da tabela informado
     * @param     string $where Condição da instrução informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    protected function delete($tabela, $where = null) {
        if (!empty($tabela)) {
            if ($where) {
                $where = " WHERE $where ";
            }
            try {
                $stmt = $this->conexao->prepare("DELETE FROM $tabela $where");
                $stmt->execute();
                return true;
            } catch (\PDOException $erro) {
                $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                $this->setErroDAO($trace[count($trace) - 1]['class'] . '::' . $trace[count($trace) - 1]['function'], $erro->getMessage());
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                    UTILITARIOS - FUNÇÕES INTERNAS                      //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>PROTECTED FUNCTION</b>
     * <br>UTILITARIO: Armazena registro de erro na tabela responsavel pelo 
     * armazenamento de erros do sistema.
     * <protected>
     * 
     * @param     string $origem Local do erro informado
     * @param     string $erro Descrição do erro informado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    protected function setErroDAO($origem, $erro) {
        $this->insert(
                ErroLogDAO::$NOME_TABELA, ":local,:descricao,:data_cadastro", [
            ':local' => $this->validarOrigem($origem),
            ':descricao' => $this->validarErro($erro),
            ':data_cadastro' => date("Y-m-d H:i:s")
                ]
        );
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Valida parametro 'ORIGEM' verificando caracteres e tamanho, utilizada 
     * na validação de cadastro de erros do sistema, max_lenght: 100.
     * <private>
     * 
     * @param     string $origem String com origem log de erro informado
     * @return    string Texto formatado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    private function validarOrigem($origem) {
        if ($origem && !empty($origem)) {
            if (strlen($origem) > 100) {
                $origem = substr($origem, 0, 100);
            }
        } else {
            $origem = 'Origem vazia';
        }
        return $origem;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Valida parametro ERRO verificando caracteres e tamanho, utilizada 
     * na validação de cadastro de erros do sistema, max_lenght: 2000
     * <private>
     * 
     * @param     string $erro Descrição do erro informado
     * @return    string Texto formatado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/06/2021
     */
    private function validarErro($erro) {
        if ($erro && !empty($erro)) {
            if (strlen($erro) > 2000) {
                $erro = substr($erro, 0, 2000);
            }
        } else {
            $erro = 'Erro vazio';
        }
        return $erro;
    }

}
