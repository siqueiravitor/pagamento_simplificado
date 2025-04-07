<?php
namespace App\Controllers\Web;

use Application\Services\DepositService;
use Exception;
use App\Core\Session;
use App\Core\Redirect;
use App\Core\Database;
use App\Core\ViewRenderer;
use Application\Services\UserService;
use Application\Services\TransferService;
use Application\Services\TransactionService;
use Infrastructure\Persistence\UserRepositoryImpl;
use Infrastructure\Persistence\WalletRepositoryImpl;
use Infrastructure\Persistence\TransactionRepositoryImpl;

class UserController {
    public function index(): void {
        $transactions = self::getTransactions();
        $users = self::getUsers();
        $usersMap = self::getUsersMap();

        ViewRenderer::render('user.index', [
            'transactions' => $transactions,
            'users' => $users,
            'usersMap' => $usersMap
        ]);
    }
    public function deposit(array $params): void {
        $value = self::moneyToFloat($_POST['value']) ?? null;
        $user = $_POST['user'] ?? null;

        if (!$value || !$user) {
            Session::flash('error', "Preencha todos os campos");
            Redirect::to('/dashboard');
        }

        $db = Database::connection();
        $walletRepo = new WalletRepositoryImpl($db);
        
        $deposit = new DepositService($walletRepo);

        try {
            $deposit->deposit($user, $value);
            Session::flash('success', 'Valor adicionado com sucesso.');
            Redirect::to('/dashboard');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            Redirect::to('/dashboard');
        }
    }
    public function transfer(array $params): void {
        $value = self::moneyToFloat($_POST['value']) ?? null;
        $payer = $_POST['payer'] ?? null;
        $payee = $_POST['payee'] ?? null;

        if (!$value || !$payer || !$payee) {
            Session::flash('error', "Preencha todos os campos");
            Redirect::to('/login');
        }

        $db = Database::connection();
        $userRepo = new UserRepositoryImpl($db);
        $walletRepo = new WalletRepositoryImpl($db);
        $transactionRepo = new TransactionRepositoryImpl($db);

        $service = new TransferService($userRepo, $walletRepo, $transactionRepo);

        try {
            $service->execute((float)$value, (int)$payer, (int)$payee);
            Session::flash('success', 'Transferência realizada com sucesso.');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
        }
        
        Redirect::to('/dashboard');
    }

    private function getTransactions(): array{
        $db = Database::connection();
        $transactionRepo = new TransactionRepositoryImpl($db);
        $transactionService = new TransactionService($transactionRepo);

        try{
            $transactions = $transactionService->getAll();
            return $transactions;
        } catch (Exception $e){
            return [];
        }
    }

    private function getUsers(): array{
        $db = Database::connection();
        $userRepo = new UserRepositoryImpl($db);
        $userService = new UserService($userRepo);

        try{
            $users = $userService->getAll();
            return $users;
        } catch (Exception $e){
            return [];
        }
    }
    private function getUsersMap(): array{
        $db = Database::connection();
        $userRepo = new UserRepositoryImpl($db);
        $userService = new UserService($userRepo);

        try{
            $users = $userService->getAll();
            $map = json_encode($users);
            $users = json_decode($map, true);
            $map = [];
            foreach ($users as $user) {
                $map[$user['id']] = $user['name'];
            }
            return $map;
        } catch (Exception $e){
            return [];
        }
    }

    private function moneyToFloat($money): string
    {
        $numbersOnly = preg_replace('/[^0-9,.]/', '', $money);
        $float = str_replace(',', '.', str_replace('.', '', $numbersOnly));
        return $float;
    }
}