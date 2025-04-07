<?php

namespace App\Controllers\Api;

use Exception;
use App\Core\Database;
use Application\Services\TransferService;
use Infrastructure\Persistence\UserRepositoryImpl;
use Infrastructure\Persistence\WalletRepositoryImpl;
use Infrastructure\Persistence\TransactionRepositoryImpl;

class TransferController {
    public function handle(array $params): void {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $value = $input['value'] ?? null;
        $payer = $input['payer'] ?? null;
        $payee = $input['payee'] ?? null;

        if (!$value || !$payer || !$payee) {
            http_response_code(400);
            echo json_encode(['error' => 'Parâmetros inválidos']);
            return;
        }

        $db = Database::connection();
        $userRepo = new UserRepositoryImpl($db);
        $walletRepo = new WalletRepositoryImpl($db);
        $transactionRepo = new TransactionRepositoryImpl($db);

        $service = new TransferService($userRepo, $walletRepo, $transactionRepo);

        try {
            $service->execute((float)$value, (int)$payer, (int)$payee);
            echo json_encode(['success' => true, 'message' => 'Transferência realizada com sucesso.']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
