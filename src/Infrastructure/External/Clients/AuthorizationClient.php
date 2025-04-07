<?php

namespace Infrastructure\External\Clients;

use Exception;

class AuthorizationClient {
    private const URL = 'https://util.devi.tools/api/v2/authorize';

    public function isAuthorized(): bool|string {
        try {
            $curl = curl_init(self::URL);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (curl_errno($curl)) {
                $error = curl_error($curl);
                curl_close($curl);
                throw new Exception("Erro ao acessar serviço de autorização: $error");
            }
    
            curl_close($curl);
    
            if ($statusCode !== 200) {
                throw new Exception("Serviço de autorização retornou código HTTP $statusCode");
            }
    
            $data = json_decode($response);
            
            return $data->data->authorization;
        } catch (Exception $e) {
            return false;
        }
    }
}
