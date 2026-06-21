<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard – AtendeLab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #222 !important; 
            /* Prioridad Elevada */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .card-body {
            padding: 1.5rem;
        }
        .btn-primary {
            background-color: #333;
            border-color: #333;
            font-size: 0.875rem;
        }
        .btn-primary:hover {
            background-color: #111;
            border-color: #111;
        }
        .btn-outline-light {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <span class="navbar-brand" style="font-size: 1rem;">AtendeLab</span>
        <a class="btn btn-outline-light btn-sm"
            href="?controller=auth&action=logout">
            Sair
        </a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-none">
        <div class="card-body">
            <h1 class="h5 mb-3">Área restrita</h1>
                <?php if ($usuario['perfil'] === 'admin'): ?>
                    <p class="mb-1" style="font-size: 0.9rem;">
                        Bem-vindo, <strong><?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?></strong>
                        Você tem acesso total no sistema
                    </p>
                <?php else: ?>
                    <p class="mb-1" style="font-size: 0.9rem;">
                        Bem-vindo, <strong><?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </p>
                <?php endif; ?>
                <p class="text-muted mb-3" style="font-size: 0.85rem;">
                    Perfil: <?= htmlspecialchars($usuario['perfil'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            <a class="btn btn-primary"
                href="?controller=usuarios&action=listar">
                Testar rota protegida de usuários
            </a>
        </div>
    </div>
</div>

</body>
</html>