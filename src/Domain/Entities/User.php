<?php

namespace Domain\Entities;

class User {
    public function __construct(
        public int $id,
        public string $name,
        public string $cpf_cnpj,
        public string $email,
        public string $password,
        public string $type
    ) {}
}
