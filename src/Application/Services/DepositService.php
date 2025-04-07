<?php

namespace Application\Services;

use Domain\Repositories\WalletRepository;
use Exception;

class DepositService{
    public function __construct(
        private WalletRepository $walletRepo
    ){}

    public function deposit(int $idUser, float $value): void {
        if ($value <= 0) {
            throw new Exception("Valor inválido para depósito.");
        }

        $wallet = $this->walletRepo->findByUserId($idUser);
        if (!$wallet) {
            throw new Exception("Carteira não encontrada.");
        }

        $wallet->credit($value);
        $this->walletRepo->save($wallet);
    }
}