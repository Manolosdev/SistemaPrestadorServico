<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeAlmoxarifadoProdutoSaida;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de registro de saida de produtos em 
 * estoque.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      12/07/2021
 */
class AlmoxarifadoProdutoSaidaDAO extends BaseDAO {

    /**
     * Nome da tabela principal.
     * @var string
     */
    static $NOME_TABELA = 'amx_produto_saida';

    ////////////////////////////////////////////////////////////////////////////
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Efetua cadastro de registro informado por parametro.
     * 
     * @param     EntidadeAlmoxarifadoProdutoSaida $entidade Entidade carregada
     * @return    integer Registro retornado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function setRegistro(EntidadeAlmoxarifadoProdutoSaida $entidade) {
        $retorno = 0;
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_produto, 
                    :fk_usuario, 
                    :valor_anterior,
                    :valor_saida,
                    :comentario,
                    :data_cadastro", [
                ':fk_produto' => $entidade->getFkProduto(),
                ':fk_usuario' => $entidade->getFkUsuario(),
                ':valor_anterior' => intval($entidade->getValorAnterior()),
                ':valor_saida' => intval($entidade->getValorSaida()),
                ':comentario' => $entidade->getComentario(),
                ':data_cadastro' => date('Y-m-d H:i:s')
            ]);
            $retorno = $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - SELECT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeAlmoxarifadoProdutoSaida Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeAlmoxarifadoProdutoSaida();
        if ($registroID > 0) {
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
     * <br>Retorna entidade carregada COMPLETA de acordo com parametro informado.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeAlmoxarifadoProdutoSaida Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getEntidadeCompleta($registroID) {
        $entidade = new EntidadeAlmoxarifadoProdutoSaida();
        $entidade = $this->getEntidade($registroID);
        if ($entidade->getId() > 0) {
            //PRODUTO
            $produtoDAO = new AlmoxarifadoProdutoDAO();
            $entidade->setEntidadeProduto($produtoDAO->getEntidade($entidade->getFkProduto()));
            //USUARIO
            $usuarioDAO = new UsuarioDAO();
            $entidade->setEntidadeUsuario($usuarioDAO->getEntidade($entidade->getFkUsuario()));
        }
        return $entidade;
    }
    
    /**
     * <b>VIEW</b>
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
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
                    $retorno['fkUsuario'] = $registro['fk_usuario'];
                    $retorno['fkProduto'] = $registro['fk_produto'];
                    $retorno['valor'] = floatval($registro['valor']);
                    $retorno['comentario'] = $registro['comentario'];
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
     * <br>Retorna registro COMPLETO solicitado por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getVetorCompleto($registroID) {
        $retorno = [];
        $retorno = $this->getVetor($registroID);
        if (count($retorno) > 0) {
            //PRODUTO
            $produtoDAO = new AlmoxarifadoProdutoDAO();
            $retorno['entidadeProduto'] = $produtoDAO->getVetor($retorno['fkProduto']);
            //USUARIO
            $usuarioDAO = new UsuarioDAO();
            $retorno['entidadeUsuario'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuario']);
        }
        return $retorno;
    }
    
    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros de acordo com parametros informados.
     * 
     * @param     string $dataInicial Data inicial da pesquisa
     * @param     string $dataFinal Data final da pesquisa
     * @param     string $pesquisa Filtro pesquisa informada(nome/descrição/codigo)
     * @param     integer $numeroPagina Filtro da pagina
     * @param     integer $registroPorPagina Registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      22/07/2021
     */
    function getListaControle($dataInicial, $dataFinal, $pesquisa = '', $numeroPagina, $registroPorPagina) {
        $lista = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT e.*, p.nome AS 'produtoNome', p.saldo_minimo, p.unidade_medida, u.nome_sistema AS 'usuarioNome', emp.nome_fantasia AS 'empresaNome'  FROM " . self::$NOME_TABELA . " AS e
                    INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON e.fk_usuario = u.id 
                    INNER JOIN " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p ON e.fk_produto = p.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS emp ON p.fk_empresa = emp.id 
                    WHERE e.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' AND (p.nome LIKE '%" . $pesquisa . "%' OR p.descricao LIKE '%" . $pesquisa . "%' OR p.codigo_produto LIKE '%" . $pesquisa . "%')
                    ORDER BY e.id DESC LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = intval($value['id']);
                    $registro['usuarioNome'] = $value['usuarioNome'];
                    $registro['empresaNome'] = $value['empresaNome'];
                    $registro['produtoNome'] = $value['produtoNome'];
                    $registro['produtoUnidadeMedida'] = $value['unidade_medida'];
                    $registro['produtoValorMinimo'] = intval($value['saldo_minimo']);
                    $registro['valorAnterior'] = intval($value['valor_anterior']);
                    $registro['valorSaida'] = intval($value['valor_saida']);
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                    array_push($lista, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $lista;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros da consulta informada, utilizado para 
     * paginação do sistema.
     * 
     * @param     string $dataInicial Filtro de data inicial informado
     * @param     string $dataFinal Filtro de data final informado
     * @param     string $pesquisa Filtro de pesquisa informado
     * @return    integer Total de registros
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      22/07/2021
     */
    function getListaControleTotal($dataInicial, $dataFinal, $pesquisa = '') {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(e.id) AS 'total' FROM " . self::$NOME_TABELA . " AS e 
                    INNER JOIN " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p ON e.fk_produto = p.id 
                    WHERE e.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' AND (p.nome LIKE '%" . $pesquisa . "%' OR p.descricao LIKE '%" . $pesquisa . "%' OR p.codigo_produto LIKE '%" . $pesquisa . "%')"
            );
            if ($resultado && $resultado->rowCount()) {
                $quantidade = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $quantidade;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                        - INTERNAL FUNCTION -                           //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Retorna ultimo registro inserido na tabela principal.
     * 
     * @return    integer Ultimo registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    private function getUltimoRegistro() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT id FROM " . self::$NOME_TABELA . " ORDER BY id DESC LIMIT 1"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = intval($resultado->fetchAll()[0]['id']);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Efetua carregamento de entidade de acordo com parametro informado.
     * 
     * @param     array $registro Registro informado
     * @return    EntidadeAlmoxarifadoProdutoSaida Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeAlmoxarifadoProdutoSaida();
        if (!empty($registro)) {
            $entidade->setId(intval($registro['id']));
            $entidade->setFkProduto($registro['fk_produto']);
            $entidade->setFkUsuario($registro['fk_usuario']);
            $entidade->setValorAnterior(floatval($registro['valor_anterior']));
            $entidade->setValorSaida(floatval($registro['valor_saida']));
            $entidade->setComentario($registro['comentario']);
            $entidade->setDataCadastro($registro['data_cadastro']);
        }
        return $entidade;
    }

}
