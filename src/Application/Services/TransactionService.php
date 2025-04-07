<?php

namespace Application\Services;

use Domain\Repositories\TransactionRepository;

class TransactionService{
    public function __construct(
        private TransactionRepository $transactionRepo
    ){}

    public function getAll(){
        return $this->transactionRepo->findAll();
    }
}