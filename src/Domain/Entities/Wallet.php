<?php

namespace Domain\Entities;

class Wallet {
    public function __construct(
        public int $id_user,
        public float $balance
    ) {}

    public function hasBalance(float $value): bool {
        return $this->balance >= $value;
    }

    public function debit(float $value): void {
        if (!$this->hasBalance($value)) {
            throw new \Exception("Saldo insuficiente");
        }
        $this->balance -= $value;
    }

    public function credit(float $value): void {
        $this->balance += $value;
    }
}
