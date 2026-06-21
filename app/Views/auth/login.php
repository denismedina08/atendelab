<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login – AtendeLab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            margin: 0;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-primary {
            background-color: #333;
            border-color: #333;
        }
        .btn-primary:hover {
            background-color: #111;
            border-color: #111;
        }
        .form-control:focus {
            border-color: #aaa;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h5 mb-1 fw-bold">AtendeLab</h1>
                        <p class="text-muted mb-4" style="font-size: 0.9rem;">
                            Informe suas credenciais para acessar o sistema
                        </p>

                        <?php if (!empty($erro)): ?>
                            <div class="alert alert-danger py-2" style="font-size: 0.875rem;">
                                <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($mensagem)): ?>
                            <div class="alert alert-success py-2" style="font-size: 0.875rem;">
                                <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="?controller=auth&action=entrar">
                            <div class="mb-3">
                                <label for="email" class="form-label text-muted" style="font-size: 0.875rem;">E-mail</label>
                                <input type="email" name="email" id="email"
                                        class="form-control"
                                        placeholder="inserir@email.com"
                                        required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label text-muted" style="font-size: 0.875rem;">Senha</label>
                                <input type="password" name="senha" id="senha"
                                        class="form-control"
                                        placeholder="senha"
                                        required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                Entrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>