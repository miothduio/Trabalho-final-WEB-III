<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TotemModel;

class TotemApi extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Ativar Totem (consome a chave)
    |--------------------------------------------------------------------------
    |
    | Chamado uma única vez, quando o totem físico ainda não tem identidade.
    | A chave só pode ativar UM totem: depois de usada, fica bloqueada para
    | novas ativações (o administrador precisa gerar uma nova chave para
    | liberar o totem de novo). Quem ativa recebe de volta um token secreto,
    | que passa a ser usado em todas as chamadas seguintes (identificar e
    | heartbeat), no lugar da chave.
    |
    */

    public function ativar()
    {
        try {

            $chave = strtoupper(trim($this->request->getPost('chave') ?? $this->request->getGet('chave')));

            if (empty($chave)) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Chave não informada.'

                ]);

            }

            $model = new TotemModel();

            $totem = $model
                ->where('chave', $chave)
                ->where('ativo', 1)
                ->first();

            if (!$totem) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Chave inválida ou totem inativo.'

                ]);

            }

            if ($totem['ativado']) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Esta chave já foi ativada em outro totem. Peça ao administrador uma nova chave.'

                ]);

            }

            $token = $model->gerarToken();

            $model->update($totem['id'], [

                'token' => $token,

                'ativado' => 1,

                'ip' => $this->request->getIPAddress(),

                'online' => 1,

                'ultima_conexao' => date('Y-m-d H:i:s')

            ]);

            $totem = $model->find($totem['id']);

            return $this->response->setJSON([

                'status' => true,

                'token' => $token,

                'totem' => $this->totemPublico($totem)

            ]);

        }

        catch (\Exception $e) {

            return $this->response->setJSON([

                'status' => false,

                'erro' => $e->getMessage()

            ]);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Identificar Totem
    |--------------------------------------------------------------------------
    |
    | Chamado sempre que o cliente_restaurante iniciar, usando o token que
    | esse navegador recebeu na ativação (não a chave).
    |
    */

    public function identificar()
    {
        try {

            $token = trim($this->request->getGet('token'));

            if (empty($token)) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Token não informado.'

                ]);

            }

            $model = new TotemModel();

            $totem = $model
                ->where('token', $token)
                ->where('ativo', 1)
                ->first();

            if (!$totem) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Token inválido. Este totem precisa ser ativado novamente.'

                ]);

            }

            $model->update($totem['id'], [

                'ip' => $this->request->getIPAddress(),

                'online' => 1,

                'ultima_conexao' => date('Y-m-d H:i:s')

            ]);

            $totem = $model->find($totem['id']);

            return $this->response->setJSON([

                'status' => true,

                'totem' => $this->totemPublico($totem)

            ]);

        }

        catch (\Exception $e) {

            return $this->response->setJSON([

                'status' => false,

                'erro' => $e->getMessage()

            ]);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Heartbeat
    |--------------------------------------------------------------------------
    |
    | Chamado automaticamente pelo cliente_restaurante a cada 30 segundos.
    | Apenas informa que o totem continua online.
    |
    */

    public function heartbeat()
    {
        try {

            $token = trim($this->request->getPost('token'));

            if (empty($token)) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Token não informado.'

                ]);

            }

            $model = new TotemModel();

            $totem = $model
                ->where('token', $token)
                ->where('ativo', 1)
                ->first();

            if (!$totem) {

                return $this->response->setJSON([

                    'status' => false,

                    'mensagem' => 'Token inválido.'

                ]);

            }

            $model->update($totem['id'], [

                'ip' => $this->request->getIPAddress(),

                'online' => 1,

                'ultima_conexao' => date('Y-m-d H:i:s')

            ]);

            return $this->response->setJSON([

                'status' => true,

                'mensagem' => 'Heartbeat recebido.',

                'hora' => date('Y-m-d H:i:s')

            ]);

        }

        catch (\Exception $e) {

            return $this->response->setJSON([

                'status' => false,

                'erro' => $e->getMessage()

            ]);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Atualizar Totens Offline
    |--------------------------------------------------------------------------
    |
    | Marca como offline todos os totens que ficaram mais de
    | 2 minutos sem enviar heartbeat.
    |
    */

    public function atualizarOffline()
    {
        $model = new TotemModel();

        $limite = date(
            'Y-m-d H:i:s',
            strtotime('-2 minutes')
        );

        $model
            ->where('ultima_conexao <', $limite)
            ->set([
                'online' => 0
            ])
            ->update();

        return $this->response->setJSON([

            'status' => true,

            'mensagem' => 'Verificação concluída.'

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Dados públicos do totem (nunca inclui chave nem token)
    |--------------------------------------------------------------------------
    */

    private function totemPublico(array $totem): array
    {
        return [

            'id' => $totem['id'],

            'numero_totem' => $totem['numero_totem'],

            'descricao' => $totem['descricao'],

            'ip' => $totem['ip'],

            'online' => (bool) $totem['online'],

            'ultima_conexao' => $totem['ultima_conexao']

        ];
    }

}
