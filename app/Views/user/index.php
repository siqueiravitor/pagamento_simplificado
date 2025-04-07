<?php use App\Core\FlashView;
function floatToMoney($amount, $currency = 'R$ '): string
{
    $money = number_format($amount, 2, ',', '.');
    return $currency . $money;
}
function moneyToFloat($money): string
{
    $numbersOnly = preg_replace('/[^0-9,.]/', '', $money);
    $float = str_replace(',', '.', str_replace('.', '', $numbersOnly));
    return $float;
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>
        Página inicial
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Vitor Siqueira" name="author" />
    <meta content="Pagamento simplificado" name="description" />
    <link rel="shortcut icon" href="/assets/images/logos/logo.png">

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet">
    <link href="/assets/css/app.min.css" rel="stylesheet">
</head>

<body>
    <div id="layout-wrapper">
        <div class="row m-0 p-0 pt-3 justify-content-center align-items-start bg-dark bg-soft"
            style="min-height: 100svh;">
           
            <div class="col-md-4">
                <div class="container card p-4 shadow-sm">
                    <div class="content-header mb-2 pb-2 mx-3 border-bottom">
                        <h4 class="mb-0 text-accent">Adicionar saldo</h4>
                    </div>
                    <?php FlashView::render(); ?>

                    <form action="/deposit" method="POST" autocomplete="off" class="card-body">
                        <div class="form-group mb-3">
                            <label>Valor</label>
                            <input name="value" class="form-control" placeholder="R$ 0,00" onkeyup="moneyMask(this)"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Usuário</label>
                            <select class="form-control flex-3" name="user" required>
                                <option value="" selected disabled>Selecione</option>
                                <?php  foreach ($data['users'] as $user) { ?>
                                    <option value="<?= $user->id ?>"><?= ucfirst($user->type) . ' - ' . $user->name . ' - ' . $user->cpf_cnpj ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success">Adicionar</button>
                        </div>
                    </form>
                </div>
                <div class="container card p-4 shadow-sm">
                    <div class="content-header mb-2 pb-2 mx-3 border-bottom">
                        <h4 class="mb-0 text-accent">Transferir dinheiro</h4>
                    </div>
                    <?php FlashView::render(); ?>

                    <form action="/transfer" method="POST" autocomplete="off" class="card-body">
                        <div class="form-group mb-3">
                            <label>Valor</label>
                            <input name="value" class="form-control" placeholder="R$ 0,00" onkeyup="moneyMask(this)"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label>De</label>
                            <select class="form-control flex-3" name="payer" required>
                                <option value="" selected disabled>Selecione</option>
                                <?php  foreach ($data['users'] as $user) { ?>
                                    <option value="<?= $user->id ?>"><?= ucfirst($user->type) . ' - ' . $user->name . ' - ' . $user->cpf_cnpj ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Para</label>
                            <select class="form-control flex-3" name="payee" required>
                                <option value="" selected disabled>Selecione</option>
                                <?php  foreach ($data['users'] as $user) { ?>
                                    <option value="<?= $user->id ?>"><?= ucfirst($user->type) . ' - ' . $user->name . ' - ' . $user->cpf_cnpj ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success">Transferir</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-4">
                
                <div class="container card p-4 shadow-sm">
                    <div class="content-header mb-2 pb-2 mx-3 border-bottom">
                        <h4 class="mb-0 text-accent">Transferências</h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-sm">
                            <thead class="bg-dark bg-soft">
                                <tr>
                                    <th colspan="2" class="text-center">Transferido</th>
                                    <th rowspan="2" class="text-center" style="vertical-align: middle">Valor</th>
                                    <th rowspan="2" class="text-center" style="vertical-align: middle">Data</th>
                                </tr>
                                <tr>
                                    <th> De </th>
                                    <th> Para </th>
                                </tr>
                            </thead>
                            <tbody>                               
                                <?php  foreach ($data['transactions'] as $transaction) { ?>
                                    <tr>
                                        <td><?= $usersMap[$transaction->idPayer] ?></td>
                                        <td><?= $usersMap[$transaction->idPayee] ?></td>
                                        <td><?= floatToMoney($transaction->value) ?></td>
                                        <td><?= $transaction->created_at ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center py-4 bg-dark text-white">
                © <?= date('Y') ?> | Construído por
                <a href="https://vitorsiqueira.com" class="text-info fw-semibold space-1">Vitor
                    Siqueira</a>
            </div>
        </div>

    </div>
</body>
<script src="/assets/js/main.js"></script>

</html>