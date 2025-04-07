<?php

namespace Infrastructure\External\Clients;

use Exception;

class NotificationClient
{
    private const URL = 'https://util.devi.tools/api/v1/notify';

    public function notify(array $payload): bool
    {
        try {
            $curl = curl_init(self::URL);

            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json']
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200) {
                throw new Exception("Falha ao notificar usuário (HTTP $httpCode).");
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
