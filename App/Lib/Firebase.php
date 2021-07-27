<?php

namespace App\Lib;

use App\Model\Entidade\EntidadeFirebase;
use App\Model\DAO\FirebaseDAO;
use App\Model\DAO\AppTelecomDAO;

/**
 * <b>CLASS</b>
 * 
 * Chamadas da API de notificação push do sistema Firebase da Google
 * responsavel por operações relacionadas as notificações push do sistema 
 * e do App Central do Assinante
 * 
 * @package   App\Controller
 * @author    Original Igor Maximo <igor.maximo@redetelecom.com.br>
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/12/2019
 * @update    25/06/2021
 */
class Firebase {

    /**
     * Chaves de acesso para API do Firebase
     * @var string
     */
    private $FIREBASE_API_URL = "https://fcm.googleapis.com/fcm/send";
    public $KEY_APP_CENTRAL_TELECOM = "AAAAcrmQOY8:APA91bGN4X6jidrA1EKckJlFJnF_0FZY_VAfjBtpI38mjbD_ojuR-w2tru3cTEuFE9MfXkuYbtBW2jIl6nCQ5HOUefdG4GKhVsA60vIz9-19Iiykeanxav0bAiXERMbAtOECX0x42nJL";
    private $KEY_APP_SISREDE = "AAAAFKfuwfY:APA91bH4tSFr9mqzc7QhlQQY1y6yPkpxG_XYVdz8QPTFKgv4a1qz-smJmSmrhbCmEeLSD8GWjjUTi5ekwlF0iSYyjtq_MPs83eHOPQmurBGxZSHSWuZ4SEeqlXrgBelvOJhVhMiXapaJ";

    ////////////////////////////////////////////////////////////////////////////
    //                              - Firebase -                              //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>PAGE</b>
     * <br>Chamada de página de disparo de notificações push.
     * 
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @param     string Telecom - para notificações para central da Telecom
     * @param     string SisRede - para notificações para SisRede App
     * @data      16/12/2019
     */
    function notificacaoMassiva(EntidadeFirebase $entidade) {
        switch ($entidade->getApp()) {
            case "centralAssinante": // Telecom
                $appTelecom = new AppTelecomDAO();
                try {
                    $retorno = $appTelecom->retornaTokensCentralTelecomApp();
                    $limite = 950;
                    if (count($retorno) > $limite) {
                        $array = array_chunk($retorno, $limite);
                        for ($p = 0; $p < count($array); $p++) {
                            $lote = [];
                            $codCli = [];
                            for ($c = 0; $c < $limite; $c++) {
                                array_push($lote, $array[$p][$c]['token']);
                                array_push($codCli, $array[$p][$c]['codcli']);
                            }
                            $result = $this->disparaNotificacoesMassivas($lote, $entidade->getTitulo(), $entidade->getMsg(), $this->KEY_APP_CENTRAL_TELECOM);
                            // Grava na central de notificações (base externa do App)
                            $json = json_decode($result, true);
                            if ($json['success'] >= 1) {
                                for ($i = 0; $i < count($lote); $i++) {
                                    $posts = array(
                                        'titulo' => $entidade->getTitulo(),
                                        'notificacao' => $entidade->getMsg(),
                                        'codcli' => $codCli[$i],
                                        'tipo' => 'Comunicado',
                                        'entregue' => 1,
                                        'seConfirmado' => 0,
                                        'seDependeConfirmacao' => 0,
                                        'protocoloNumero' => 0
                                    );
                                    $json = $this->enviaPostsERecebeJSONArray($posts, "http://187.95.0.9/ncaredeapp/Rotas.php?func=insereNovaNotificacaoMassiva&user=k6NZWq95y9x2NMxF9rRg&pass=1MiTgbYI4jWCKn3RCdub");
                                }
                            } 
                        }
                        return true;
                    } else {
                        $array = $retorno;
                        $lote = [];
                        $codCli = [];
                        for ($c = 0; $c < count($array); $c++) {
                            array_push($lote, $array[$c]['token']);
                            array_push($codCli, $array[$c]['codcli']);
                        }
                        $result = $this->disparaNotificacoesMassivas($lote, $entidade->getTitulo(), $entidade->getMsg(), $this->KEY_APP_CENTRAL_TELECOM);
                        // Grava na central de notificações (base externa do App)
                        $json = json_decode($result, true);
                        if ($json['success'] >= 1) {
                            for ($i = 0; $i < count($lote); $i++) {
                                $posts = array(
                                        'titulo' => $entidade->getTitulo(),
                                        'notificacao' => $entidade->getMsg(),
                                        'codcli' => $codCli[$i],
                                        'tipo' => 'Comunicado',
                                        'entregue' => 1,
                                        'seConfirmado' => 0,
                                        'seDependeConfirmacao' => 0,
                                        'protocoloNumero' => 0
                                    );
                                $json = $this->enviaPostsERecebeJSONArray($posts, "http://187.95.0.9/ncaredeapp/Rotas.php?func=insereNovaNotificacaoMassiva&user=k6NZWq95y9x2NMxF9rRg&pass=1MiTgbYI4jWCKn3RCdub");
                            }
                        }
                        return true;
                    }
                } catch (Exception $ex) {
//                    error_log($ex);
                    echo $ex;
                }
                break;
            case "sisRede": // SisRede App
                $firebaseDAO = new FirebaseDAO();
                try {
                    $retorno = $firebaseDAO->retornaTokensSisRedeApp();
                    $registro = [];
                    $registroCodCli = [];
                    for ($i = 0; $i < count($retorno); $i++) {
                        $registro[$i] = $retorno[$i]['token'];
                    }
                    $result = $this->disparaNotificacoesMassivas($registro, $entidade->getTitulo(), $entidade->getMsg(), $this->KEY_APP_SISREDE);
                    $json = json_decode($result, true);
                    if (intval($json['success']) >= 1) {
                        return true;
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }
                break;
            case "sisRedeSetor": // SisRede App
                $firebaseDAO = new FirebaseDAO();
                try {
                    $retorno = $entidade->getTokensDestino();
                    $registro = [];
                    $registroCodCli = [];
                    for ($i = 0; $i < count($retorno); $i++) {
                        $registro[$i] = $retorno[$i]['token'];
                    }
                    $result = $this->disparaNotificacoesMassivas($registro, $entidade->getTitulo(), $entidade->getMsg(), $this->KEY_APP_SISREDE);
                    $json = json_decode($result, true);
                    if (intval($json['success']) >= 1) {
                        return 1;
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }
                break;
            case "sisRedeUsuariosEspecificos": // SisRede App
                $firebaseDAO = new FirebaseDAO();
                try {
                    for ($i = 0; $i < count($entidade->getTokensDestino()); $i++) {
                        $registro[$i] = $firebaseDAO->getTokenEspecificoSisRedeApp($entidade->getTokensDestino()[$i])['token'];
                    }

                    $result = $this->disparaNotificacoesMassivas($registro, $entidade->getTitulo(), $entidade->getMsg(), $this->KEY_APP_SISREDE);
                    $json = json_decode($result, true);
                    if (intval($json['success']) >= 1) {
                        return 1;
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }
                break;
        }
    }

    /**
     * <b>PAGE</b>
     * <br>Dispara uma notificação push como tarefa para um 
     * cliente do app
     * 
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @data      29/07/2020
     */
    public function setDispararNotificacaoTarefaCliente($tarefa, $protocolo, $codCli, $tokensArray, $tituloPush, $msgPush, $keyApi) {
        try {
            $posts = array(
                'titulo' => $tituloPush,
                'notificacao' => $msgPush,
                'codcli' => $codCli,
                'tipo' => $tarefa,
                'entregue' => 1,
                'seConfirmado' => 0,
                'seDependeConfirmacao' => 1,
                'protocoloNumero' => $protocolo
            );
            // Grava no banco do app
            $a = $this->enviaPostsERecebeJSONArray($posts, "http://187.95.0.9/ncaredeapp/Rotas.php?func=insereNovaNotificacaoMassiva&user=k6NZWq95y9x2NMxF9rRg&pass=1MiTgbYI4jWCKn3RCdub");
            error_log($a); 
            // Dispara push para o app
            return $this->disparaNotificacoesMassivas($tokensArray, $tituloPush, $msgPush, $keyApi);
        } catch (\Exception $ex) {
            $this->setErroDAO(__METHOD__, $ex->getMessage());
        }
    }

    /**
     * <b>PAGE</b>
     * <br>Dispara uma notificação push com base
     * no array de ids de usuários informada (Fire!)
     * 
     * @return    array com tokens
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @data      28/02/2020
     */
    public function setDispararNotificacaoIndividualSisRede($arrayIdsUsuarios, $titulo, $msg) {
        $firebaseDAO = new FirebaseDAO();
        try {
            for ($i = 0; $i < count($arrayIdsUsuarios); $i++) {
                $registro[$i] = $firebaseDAO->getTokenEspecificoSisRedeApp($arrayIdsUsuarios[$i]);
            }

            $result = $this->disparaNotificacoesMassivas($registro, $titulo, $msg, $this->KEY_APP_SISREDE);
            $json = json_decode($result, true);
            if (intval($json['success']) >= 1) {
                return 1;
            }
        } catch (\Exception $ex) {
            $this->setErroDAO(__METHOD__, $ex->getMessage());
        }
    }

    /**
     * <b>PAGE</b>
     * <br>Dispara notificações (Fire!)
     * 
     * @return    array com tokens
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @data      17/12/2019
     */
    public function disparaNotificacoesMassivas($tokensArray, $titulo, $msg, $keyApi) {
        try {
            $arr = array(
                "registration_ids" => $tokensArray,
                "notification" => array(
                    "title" => $titulo,
                    "body" => $msg,
                    "message" => $msg,
                    "sound" => "default",
                    "vibrate" => 1,
                ),
                "data" => array(
                    "name" => $msg,
                    "android_channel_id" => "1"
                )
            );
            // Google Firebase messaging FCM-API url
            $fields = (array) $arr;
            $headers = array(
                'Authorization: key=' . $keyApi,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->FIREBASE_API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);

            if ($result === FALSE) {
                curl_error($ch);
                die();
            }
            curl_close($ch);
            return $result;
        } catch (Exception $ex) {
//            error_log($ex);
        }
    }

    /**
     * <b>PAGE</b>
     * <br>Envia POSTS via cURL e retorna um JSON
     * 
     * @return    JSON
     * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
     * @data      18/12/2019
     */
    public function enviaPostsERecebeJSONArray($postsArray, $url) {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postsArray);
            $cexecute = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $ex) {
            echo $ex;
        }

        return $json = json_decode($cexecute, true);
    }

}
