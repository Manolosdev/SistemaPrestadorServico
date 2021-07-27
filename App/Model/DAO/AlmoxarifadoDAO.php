<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações GERAIS de almoxarifado dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      22/07/2021
 */
class AlmoxarifadoDAO extends BaseDAO {
    ////////////////////////////////////////////////////////////////////////////
    //                              - SELECT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de TOP movimentos efetuados dentro do sistema.
     * 
     * @param     integer $limiteMaximoRegistro Número máximo de registros
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      22/07/2021
     */
    function getTopMovimentoAlmoxarifado($limiteMaximoRegistro = 10) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "(
                        SELECT m.id, 'entrada' AS 'tipo', u.nome_sistema, u.imagem_perfil, d.nome AS 'usuarioDepartamento', p.nome, m.valor_entrada AS 'movimentoValor', m.data_cadastro FROM " . AlmoxarifadoProdutoEntradaDAO::$NOME_TABELA . " AS m 
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON m.fk_usuario = u.id 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                        INNER JOIN " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p ON m.fk_produto = p.id 
                        ORDER BY data_cadastro DESC
                    ) UNION ALL (
                        SELECT m.id, 'saida' AS 'tipo', u.nome_sistema, u.imagem_perfil, d.nome AS 'usuarioDepartamento', p.nome, m.valor_saida AS 'movimentoValor', m.data_cadastro FROM " . AlmoxarifadoProdutoSaidaDAO::$NOME_TABELA . " AS m 
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON m.fk_usuario = u.id 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                        INNER JOIN " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p ON m.fk_produto = p.id 
                        ORDER BY data_cadastro DESC
                    ) UNION ALL (
                        SELECT p.id, 'produto' AS 'tipo', u.nome_sistema, u.imagem_perfil, d.nome AS 'usuarioDepartamento', p.nome, '----' AS 'movimentoValor', p.data_cadastro FROM " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p 
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON p.fk_usuario_cadastro = u.id 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                        ORDER BY data_cadastro DESC
                    ) ORDER BY data_cadastro DESC LIMIT " . $limiteMaximoRegistro
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['movimentoId'] = intval($value['id']);
                    $registro['movimentoTipo'] = $value['tipo'];
                    $registro['movimentoValor'] = intval($value['movimentoValor']);
                    $registro['usuarioNome'] = $value['nome_sistema'];
                    $registro['usuarioPerfil'] = base64_encode($value['imagem_perfil']);
                    $registro['usuarioDepartamento'] = $value['usuarioDepartamento'];
                    $registro['produtoNome'] = $value['nome'];
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

}
