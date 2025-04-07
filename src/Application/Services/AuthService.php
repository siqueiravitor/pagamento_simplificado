<?php
namespace Application\Services;

use Exception;
use Domain\Repositories\UserRepository;

class AuthService {
    public function __construct(private UserRepository $userRepo) {}

    public function authenticate(string $email, string $password): array {
        $user = $this->userRepo->findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception("Credenciais inválidas.");
        }

        return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'type' => $user->type
        ];
    }
}
