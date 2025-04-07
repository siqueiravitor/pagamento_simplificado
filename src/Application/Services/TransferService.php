<?php

namespace Application\Services;

use Exception;
use App\Core\LoggerService;
use Domain\Entities\Transaction;
use Domain\Repositories\UserRepository;
use Domain\Repositories\WalletRepository;
use Domain\Repositories\TransactionRepository;
use Infrastructure\External\Clients\NotificationClient;
use Infrastructure\External\Clients\AuthorizationClient;

class TransferService {
    public function __construct(
        private UserRepository $userRepo,
        private WalletRepository $walletRepo,
        private TransactionRepository $transactionRepo
    ){}

    public function execute(float $value, int $idPayer, int $idPayee){
        if($idPayer == $idPayee){
            throw new Exception("Não é possível transferir para si mesmo.");
        }
        if ($value <= 0) {
            throw new Exception("Valor da transferência inválido.");
        }

        $payer = $this->userRepo->findById($idPayer);
        $payee = $this->userRepo->findById($idPayee);

        if (!$payer || !$payee) {
            throw new Exception("Usuário(s) não encontrado(s).");
        }

        if ($payer->type === 'lojista') {
            throw new Exception("Lojistas não podem realizar transferências.");
        }
        
        $payerWallet = $this->walletRepo->findByUserId($idPayer);
        $payeeWallet = $this->walletRepo->findByUserId($idPayee);

        if (!$payerWallet) {
            throw new Exception("Carteira do pagador não encontrada.");
        }
        if (!$payeeWallet) {
            throw new Exception("Carteira do recebedor não encontrada.");
        }

        if (!$payerWallet->hasBalance($value)) {
            throw new Exception("Saldo insuficiente.");
        }
        
        $authClient = new AuthorizationClient();
        if (!$authClient->isAuthorized()) {
            throw new Exception("Não autorizado.");
        }
        
        $payerWallet->debit($value);
        $payeeWallet->credit($value);

        $this->walletRepo->save($payerWallet);
        $this->walletRepo->save($payeeWallet);

        $transaction = new Transaction(
            id: 0,
            value: $value,
            idPayer: $idPayer,
            idPayee: $idPayee,
            created_at: date('Y-m-d H:i:s')
        );

        $this->transactionRepo->create($transaction);

        try {
            $notifyData = [
                'id_payer' => $idPayer,
                'id_payee' => $idPayee,
                'value' => $value,
                'message' => 'Transferência realizada com sucesso!'
            ];
            $notifier = new NotificationClient();
            $notifier->notify($notifyData);
            LoggerService::log('notify', json_encode($notifyData));
        } catch (Exception $e) {
            LoggerService::log('notify', $e->getMessage());
        }

        return true;
    }
}