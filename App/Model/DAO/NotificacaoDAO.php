<?php

namespace App\Model\DAO;

use App\Model\Entidade\EntidadeNotificacao;
use App\Lib\Sessao;
use App\Lib\Firebase;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por operações de CRUD relacionados as NOTIFICAÇÕES do 
 * sistema.
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class NotificacaoDAO extends BaseDAO {

    /**
     * Tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_notificacao';

    /**
     * Tabela de relacionamento composto.
     * @var string
     */
    static $NOME_TABELA_RELACIONAMENTO_USUARIO = 'core_notificacao_usuario';

    /**
     * Maximo de registros retornados por consula.
     * @var int 
     */
    private $MAX_REGISTRO = 20;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <Override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Cadastra registro informado por entidade em banco de dados.
     * <br>Atribui notificação aos usuarios listados em array SIMPLES com lista
     * de ID's dos usuarios [0,1,2,3,...].
     * 
     * @param     EntidadeNotificacao $entidade Entidade Notificação carregada
     * @param     array $listaUsuario Vetor com IDs dos usuarios que receberão
     *            a notificação.
     * @return    integer ID do registro inserido
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function setRegistro(EntidadeNotificacao $entidade, $listaUsuario = []) {
        try {
            $this->insert(
                    self::$NOME_TABELA, ":fk_usuario, :titulo, :mensagem, :data_cadastro", [
                ':fk_usuario' => $entidade->getFkUsuario(),
                ':titulo' => ($entidade->getTitulo()),
                ':mensagem' => ($entidade->getMensagem()),
                ':data_cadastro' => date("Y-m-d H:i:s")
                    ]
            );
            $idRegistro = $this->getUltimoRegistro();
            for ($i = 0; $i < count($listaUsuario); $i++) {
                $this->setNotificacaoUsuario($idRegistro, $listaUsuario[$i]);
                //$this->setEnviarChipeiraIndividual($usuarioDAO->getCelularUsuario($listaUsuario[$i]), $entidade->getMensagem());
            }
            //$fireBase = new Firebase();
            //$fireBase->setDispararNotificacaoIndividualSisRede($listaUsuario, $entidade->getTitulo(), $entidade->getMensagem());
            return $idRegistro;
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    /**
     * <b>INSERT</b>
     * <br>Cadastra notificação para todos os usuários do setor informado por 
     * parametro.
     * 
     * @param     EntidadeNotificacao $entidade Entidade carregada
     * @param     integer $departamentoID ID do departamento informado
     * @return    integer ID do registro inserido
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function setRegistroDepartamento(EntidadeNotificacao $entidade, $departamentoID) {
        try {
            $this->insert(
                    self::$NOME_TABELA, ":fk_usuario, :titulo, :mensagem, :data_cadastro", [
                ':fk_usuario' => $entidade->getFkUsuario(),
                ':titulo' => ($entidade->getTitulo()),
                ':mensagem' => ($entidade->getMensagem()),
                ':data_cadastro' => date("Y-m-d H:i:s")
                    ]
            );
            $idRegistro = $this->getUltimoRegistro();
            $departamentoDAO = new DepartamentoDAO();
            $listaUsuario = $departamentoDAO->getListaUsuarioIDPorDepartamento($departamentoID);
            for ($i = 0; $i < count($listaUsuario); $i++) {
                $this->setNotificacaoUsuario($idRegistro, $listaUsuario[$i]);
            }
            return $idRegistro;
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - DELETE -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>DELETE</b>
     * <br>DELETA registro do usuário informado por parametro.
     * 
     * @param     integer $notificacaoID ID do registro informado
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function setDeletarRegistro($notificacaoID, $usuarioID) {
        if ($notificacaoID > 0 && $$usuarioID > 0) {
            try {
                $this->delete(
                        self::$NOME_TABELA, "id = " . $notificacaoID . "AND fk_usuario = " . $usuarioID
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - VIEW -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna registro informado por parametro.
     * Atualiza leitura de usuario caso o mesmo seja o solicitante.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    array Lista com informações do registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getRegistroVetor($registroID) {
        $registro = [];
        if ($registroID > 0) {
            $this->setNotificacaoUsuarioLeitura($registroID, Sessao::getUsuario()->getId());
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $registro['id'] = $value['id'];
                    $registro['fkUsuario'] = $value['fk_usuario'];
                    $registro['titulo'] = ($value['titulo']);
                    $registro['mensagem'] = ($value['mensagem']);
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 10) . ' as ' . substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 11, 5);
                    $usuarioDAO = new UsuarioDAO();
                    $registro['EntidadeUsuarioOrigem'] = $usuarioDAO->getUsuarioArraySimples($value['fk_usuario']);
                    $registro['listaUsuarioEnviados'] = $this->getListaUsuariosNotificacao($value['id']);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $registro;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna vetor com registros de notificações recebidas pelo usuario
     * informado por parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $paginacao Paginação dos registros pesquisados
     * @return    array Lista de entidades carregadas
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getListaRegistroRecebido($usuarioID, $paginacao = 0) {
        $lista = [];
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT n.id, n.fk_usuario, n.titulo, n.mensagem, n.data_cadastro, nu.data_leitura FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS nu 
                        INNER JOIN " . self::$NOME_TABELA . " AS n ON nu.fk_notificacao = n.id 
                        WHERE nu.fk_usuario = " . $usuarioID . " ORDER BY n.id DESC LIMIT " . ($this->MAX_REGISTRO * $paginacao) . ", " . $this->MAX_REGISTRO
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['fkUsuario'] = $value['fk_usuario'];
                        $registro['titulo'] = ($value['titulo']);
                        $registro['mensagem'] = ($value['mensagem']);
                        $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                        $registro['dataLeitura'] = !empty($value['data_leitura']) ? substr(date("d/m/Y H:i", strtotime($value['data_leitura'])), 0, 16) : null;
                        $usuarioDAO = new UsuarioDAO();
                        $registro['EntidadeUsuarioOrigem'] = $usuarioDAO->getUsuarioArraySimples($value['fk_usuario']);
                        array_push($lista, $registro);
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
     * <br>Retorna vetor com registros de notificações ENVIADAS pelo usuario
     * informado por parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $paginacao Paginação dos registros pesquisados
     * @return    array Lista de entidades carregadas
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getListaRegistroEnviado($usuarioID, $paginacao = 0) {
        $lista = [];
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT n.id, n.fk_usuario, n.titulo, n.mensagem, n.data_cadastro FROM " . self::$NOME_TABELA . " AS n 
                        WHERE n.fk_usuario = " . $usuarioID . " ORDER BY n.id DESC LIMIT " . ($this->MAX_REGISTRO * $paginacao) . ", " . $this->MAX_REGISTRO
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['fkUsuario'] = $value['fk_usuario'];
                        $registro['titulo'] = ($value['titulo']);
                        $registro['mensagem'] = ($value['mensagem']);
                        $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                        $usuarioDAO = new UsuarioDAO();
                        $registro['EntidadeUsuarioOrigem'] = $usuarioDAO->getUsuarioArraySimples($value['fk_usuario']);
                        array_push($lista, $registro);
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
     * <br>Retorna lista de requisições pendentes do usuario informado por 
     * parametro.
     * OBS: Retorna apenas notificações que não tenha registro de leitura.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getNotificacaoPendente($usuarioID) {
        $lista = [];
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT n.id, n.fk_usuario AS 'usuarioOrigem', nu.fk_usuario AS 'usuarioDestino', nu.data_leitura, n.titulo, n.mensagem, n.data_cadastro FROM " . self::$NOME_TABELA . " AS n
                        INNER JOIN " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS nu ON nu.fk_notificacao = n.id
                        WHERE nu.fk_usuario = " . $usuarioID . " AND isnull(nu.data_leitura) ORDER BY n.data_cadastro DESC LIMIT 20"
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['fkUsuario'] = $value['usuarioOrigem'];
                        $registro['titulo'] = ($value['titulo']);
                        $registro['mensagem'] = ($value['mensagem']);
                        $registro['dataLeitura'] = substr(date("d/m/Y H:i", strtotime($value['data_leitura'])), 0, 16);
                        $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                        $usuarioDAO = new UsuarioDAO();
                        $registro['EntidadeUsuarioOrigem'] = $usuarioDAO->getUsuarioArraySimples($value['usuarioOrigem']);
                        $registro['EntidadeUsuarioDestino'] = $usuarioDAO->getUsuarioArraySimples($value['usuarioDestino']);
                        array_push($lista, $registro);
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
     * <br>Retorno quantidade de registros cadastrado pelo usuario no sistema. 
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @return    integer Quantidade de registros
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getQuantidadeTotalRegistroUsuario($usuarioID) {
        $retorno = 0;
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT count(id) as 'quantidade' FROM " . self::$NOME_TABELA . " 
                    WHERE fk_usuario = " . $usuarioID
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = $resultado->fetchAll()[0]['quantidade'];
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna estatistica de notificações relacionadas ao usuario informado
     * por parametro
     * Tipo1 - Lista de notificações nos ultimos 6 meses
     * Tipo2 - Notificações recebedias/enviadas durante o mes atual
     * 
     * @param     integer $usuarioID ID do usuario solicitado
     * @param     integer $tipoRelatorio 1 - Mensal
     *                                   2 - Semestral
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getEstatisticaUsuario($usuarioID, $tipoRelatorio) {
        $lista = [];
        if ($usuarioID > 0) {
            if ($tipoRelatorio === 2) {
                try {
                    for ($i = 6; $i > 0; $i--) {
                        $resultado = $this->select(
                                "SELECT count(*) AS 'total' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS nu 
                                INNER JOIN " . self::$NOME_TABELA . " AS n ON nu.fk_notificacao = n.id 
                                WHERE nu.fk_usuario = " . $usuarioID . " AND n.data_cadastro BETWEEN DATE_ADD(NOW(), INTERVAL - " . $i . " MONTH) AND DATE_ADD(NOW(), INTERVAL - " . ($i - 1) . " MONTH)"
                        );
                        if ($resultado && $resultado->rowCount()) {
                            $retorno = $resultado->fetchAll();
                            array_push($lista, $retorno[0]['total']);
                        }
                    }
                } catch (\PDOException $erro) {
                    $this->setErroDAO(__METHOD__, $erro->getMessage());
                }
            } else {
                try {
                    $resultado = $this->select(
                            "SELECT count(*) AS 'total' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS nu 
                            INNER JOIN " . self::$NOME_TABELA . " AS n ON nu.fk_notificacao = n.id 
                            WHERE nu.fk_usuario = " . $usuarioID . " AND n.data_cadastro BETWEEN DATE_ADD(NOW(), INTERVAL - 1 MONTH) AND NOW()"
                    );
                    if ($resultado && $resultado->rowCount()) {
                        $retorno = $resultado->fetchAll();
                        array_push($lista, $retorno[0]['total']);
                    }
                    $resultado = $this->select(
                            "SELECT count(*) AS 'total' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . "  AS nu
                            INNER JOIN " . self::$NOME_TABELA . " AS n ON nu.fk_notificacao = n.id 
                            WHERE n.fk_usuario = " . $usuarioID . " AND n.data_cadastro BETWEEN DATE_ADD(NOW(), INTERVAL - 1 MONTH) AND NOW()"
                    );
                    if ($resultado && $resultado->rowCount()) {
                        $retorno = $resultado->fetchAll();
                        array_push($lista, $retorno[0]['total']);
                    }
                } catch (\PDOException $erro) {
                    $this->setErroDAO(__METHOD__, $erro->getMessage());
                }
            }
        }
        return $lista;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                          - FUNÇÕES INTERNAS -                          //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Efetua atribuição de usuário a notificação informado por parametro.
     * 
     * @param     integer $notificacaoID ID da notificação informado
     * @param     integer $usuarioID ID do usuário informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    private function setNotificacaoUsuario($notificacaoID, $usuarioID) {
        if ($notificacaoID > 0 && $usuarioID > 0) {
            try {
                $this->insert(
                        self::$NOME_TABELA_RELACIONAMENTO_USUARIO, ":fk_notificacao, :fk_usuario", [
                    ':fk_notificacao' => $notificacaoID,
                    ':fk_usuario' => $usuarioID
                        ]
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Efetua cadastro da leitura da notificação de acordo com parametros 
     * informados.
     * 
     * @param     integer $notificacaoID ID da notificação informado
     * @param     integer $usuarioID ID do usuario informado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    private function setNotificacaoUsuarioLeitura($notificacaoID, $usuarioID) {
        if ($notificacaoID > 0 && $usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " 
                    WHERE fk_usuario = " . $usuarioID . " AND fk_notificacao = " . $notificacaoID
                );
                if ($resultado && $resultado->rowCount()) {
                    if (empty($resultado->fetchAll()[0]['data_leitura'])) {
                        $this->update(
                                self::$NOME_TABELA_RELACIONAMENTO_USUARIO, "fk_notificacao = :fk_notificacao, fk_usuario = :fk_usuario, data_leitura = :data_leitura", [
                            ':fk_notificacao' => $notificacaoID,
                            ':fk_usuario' => $usuarioID,
                            ':data_leitura' => date("Y-m-d H:i:s")
                                ], "fk_notificacao = :fk_notificacao AND fk_usuario = :fk_usuario"
                        );
                    }
                }
            } catch (\PDOException $erro) {
                //EMPTY
            }
        }
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Retorna lista de usuarios que receberam a notificação informada.
     * 
     * @param     integer $notificacaoID ID do registro informado
     * @return    array Lista de usuarios e suas leituras
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    private function getListaUsuariosNotificacao($notificacaoID) {
        $lista = [];
        if ($notificacaoID > 0) {
            $usuarioDAO = new UsuarioDAO();
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS n
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON n.fk_usuario = u.id
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                        WHERE fk_notificacao = " . $notificacaoID . " ORDER BY d.nome, u.nome_sistema"
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['entidadeUsuario'] = $usuarioDAO->getUsuarioArraySimples($value['fk_usuario']);
                        $registro['dataLeitura'] = empty($value['data_leitura']) ? null : substr(date("d/m/Y H:i", strtotime($value['data_leitura'])), 0, 16);
                        array_push($lista, $registro);
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $lista;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Obtém último registro inserido em tabela.
     * 
     * @return    integer ID do ultimo registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    private function getUltimoRegistro() {
        try {
            $resultado = $this->select(
                    "SELECT id FROM " . self::$NOME_TABELA . " ORDER BY id DESC LIMIT 1"
            );
            if ($resultado && $resultado->rowCount()) {
                return $resultado->fetchAll()[0]['id'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega Entidade com dados informado pelo ResultSet.
     * 
     * @param     array $registro ResultSet carregado
     * @return    EntidadeNotificacao Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    protected function setCarregarEntidade($registro) {
        $entidade = new EntidadeNotificacao();
        if (!empty($registro)) {
            $entidade->setId($registro['id']);
            $entidade->setFkUsuario($registro['fk_usuario']);
            $entidade->setTitulo(($registro['titulo']));
            $entidade->setMensagem(($registro['mensagem']));
            $entidade->setDataCadastro($registro['data_cadastro']);
        }
        return $entidade;
    }

}
