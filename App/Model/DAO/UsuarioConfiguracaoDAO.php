<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeUsuarioConfiguracao;

/**
 * <b>CLASS</b>
 * 
 * Classe interna responsavel por operações de CRUD relacionados as 
 * configurações dos USUÁRIOS cadastrados dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class UsuarioConfiguracaoDAO extends BaseDAO {

    /**
     * Tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_usuario_configuracao';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <Override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - UPDATE -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Altera configuração informada por parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $configuracaoID ID da configuração informado
     * @param     integer $valor Valor da configuracao informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setUsuarioConfiguracao($usuarioID, $configuracaoID, $valor) {
        if ($usuarioID > 0 && $configuracaoID > 0 && $valor >= 0) {
            try {
                $this->update(
                        self::$NOME_TABELA, "valor = :valor", [
                    ':id_configuracao' => $configuracaoID,
                    ':fk_usuario' => $usuarioID,
                    ':valor' => $valor,
                        ], "id_configuracao = :id_configuracao AND fk_usuario = :fk_usuario"
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>UPDATE</b>
     * <br>Altera a configuração informada por parametro.
     * 
     * @param     EntidadeUsuarioConfiguracao $entidade Entidade carregada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setConfig(EntidadeUsuarioConfiguracao $entidade) {
        try {
            $this->update(
                    self::$NOME_TABELA, "valor = :valor", [
                ':id_configuracao' => $entidade->getId(),
                ':fk_usuario' => $entidade->getFkUsuario(),
                ':valor' => $entidade->getValor(),
                    ], "id_configuracao = :id_configuracao and fk_usuario = :fk_usuario"
            );
            return true;
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return false;
    }

    /**
     * <b>UPDATE</b>
     * <br>Percorre lista de dashboard do usuario informado onde encontrando 
     * dashboard configurado atribui o valor 0.
     * 
     * @param     integer $usuarioID ID do usuario a ser alterado dashboard
     * @param     integer $dashboardID Ocorrencia de registro de dashboard para 
     *            ser removido
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setRemoverDashboardUsuario($usuarioID, $dashboardID) {
        if ($usuarioID > 0 && $dashboardID > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA, "valor = :valor", [
                    ':id_configuracao1' => 2,
                    ':id_configuracao2' => 6,
                    ':removerDashboard' => $dashboardID,
                    ':fk_usuario' => $usuarioID,
                    ':valor' => 0,
                        ], "id_configuracao > :id_configuracao1 AND id_configuracao < :id_configuracao2 AND fk_usuario = :fk_usuario AND valor = :removerDashboard"
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - SELECT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    EntidadeUsuarioConfiguracao Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $configuracao = new EntidadeUsuarioConfiguracao();
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id_configuracao = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $configuracao = $this->carregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $configuracao;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de entidades de configuração do usuario informado por
     * parametro
     * 
     * @param     integer $usuarioID ID do usuario infomado
     * @return    array Lista de EntidadeUsuarioConfiguracao carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getConfiguracaoUsuario($usuarioID) {
        $retorno = [];
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE fk_usuario = " . $usuarioID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registro = $resultado->fetchAll();
                    foreach ($registro as $value) {
                        array_push($retorno, $this->carregarEntidade($value));
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de ID's dos DASHBOARDs configurados do usuário.
     * <br>Posição: 3,4,5.
     * 
     * @param     integer $usuarioID ID do usuário informado
     * @return    array Lista de configurações do usuario
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getConfiguracaoDashboardUsuario($usuarioID) {
        $lista = [];
        if ($usuarioID > 0) {
            try {
                $retorno = $this->select(
                        "SELECT valor FROM " . self::$NOME_TABELA . " 
                        WHERE fk_usuario = " . $usuarioID . " AND id_configuracao IN(3,4,5)"
                );
                if ($retorno && $retorno->rowCount()) {
                    $registro = $retorno->fetchAll();
                    foreach ($registro as $value) {
                        array_push($lista, $value['valor']);
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $lista;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de configuração de DASHBOARD do usuário informado por
     * parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $configuracaoID ID da configuração informado
     * @return    array Lista de dashboard em ordem
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getConfiguracaoDashboardUsuarioVetor($usuarioID, $configuracaoID) {
        $registro = [];
        if ($usuarioID > 0 && $configuracaoID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT u.id_configuracao, dp.nome AS 'departamentoNome', d.id, d.script, d.nome_img, d.nome, d.descricao, d.data_cadastro FROM " . UsuarioConfiguracaoDAO::$NOME_TABELA . " AS u
                        INNER JOIN " . DashboardDAO::$NOME_TABELA . " AS d ON d.id = u.valor 
                        LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " AS dp ON d.fk_departamento = dp.id 
                        WHERE u.fk_usuario = " . $usuarioID . " AND u.id_configuracao = " . $configuracaoID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $registro = [];
                    $registro['idConfiguracao'] = $value['id_configuracao'];
                    $registro['id'] = $value['id'];
                    $registro['script'] = $value['script'];
                    $registro['nomeImagem'] = $value['nome_img'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['departamentoNome'] = $value['departamentoNome'] === null ? 'Geral' : ($value['departamentoNome']);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $registro;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                          -INTERNAL FUNCTION -                          //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega EntidadeUsuarioConfiguracao com dados informado pelo 
     * ResultSet.
     * 
     * @param     array $registro ResultSet carregado
     * @return    EntidadeUsuarioConfiguracao Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function carregarEntidade($registro) {
        $config = new EntidadeUsuarioConfiguracao();
        if (!empty($registro)) {
            $config->setId($registro['id_configuracao']);
            $config->setFkUsuario($registro['fk_usuario']);
            $config->setValor($registro['valor']);
        }
        return $config;
    }

}
