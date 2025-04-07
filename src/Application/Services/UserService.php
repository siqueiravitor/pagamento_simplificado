<?php

namespace Application\Services;

use Domain\Repositories\UserRepository;

class UserService{
    public function __construct(
        private UserRepository $userRepo
    ){}

    public function getAll(){
        return $this->userRepo->findAll();
    }
}