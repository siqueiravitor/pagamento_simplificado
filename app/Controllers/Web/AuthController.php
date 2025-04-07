<?php
namespace App\Controllers\Web;

use Exception;
use App\Core\Session;
use App\Core\Database;
use App\Core\Redirect;
use App\Core\ViewRenderer;
use Application\Services\AuthService;
use Infrastructure\Persistence\UserRepositoryImpl;

class AuthController {
    public function index(): void {
        ViewRenderer::render('auth.login');
    }

    public function login(array $params): void {
        Session::start();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $db = Database::connection();
        $userRepo = new UserRepositoryImpl($db);
        $authService = new AuthService($userRepo);

        try {
            $user = $authService->authenticate($email, $password);
            Session::set('user', $user);
            Redirect::to('/dashboard');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            Redirect::to('/login');
        }
    }

    public function logout(): void {
        Session::destroy();
        Redirect::to('/login');
    }
}