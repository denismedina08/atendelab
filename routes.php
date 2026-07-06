<?php
// Carrega o middleware de autenticação usado em todas as rotas protegidas.
require_once __DIR__ . '/app/Middleware/auth.php';

// Define controller e action por query string.
// Exemplo: ?controller=pessoas&action=listar
$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action']     ?? 'login';

switch ($controller) {

    case 'auth':
        require_once __DIR__ . '/app/Controllers/AuthController.php';
        $authController = new AuthController();

        switch ($action) {
            case 'login':
                $authController->exibirLogin();
                break;
            case 'entrar':
                $authController->entrar();
                break;
            case 'dashboard':
                $authController->dashboard();
                break;
            case 'logout':
                $authController->logout();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    case 'dashboard':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/DashboardController.php';
        $dashboardController = new DashboardController();

        switch ($action) {
            case 'resumo':
                $dashboardController->resumo();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    case 'frontend':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/FrontendController.php';
        $frontendController = new FrontendController();

        switch ($action) {
            case 'pessoas':
                $frontendController->pessoas();
                break;
            case 'tipos':
                $frontendController->tiposAtendimentos();
                break;
            case 'atendimentos':
                $frontendController->atendimentos();
                break;
            default:
                echo 'Página não encontrada.';
        }
        break;

    case 'pessoas':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/PessoasController.php';
        $pessoasController = new PessoasController();

        switch ($action) {
            case 'listar':
                $pessoasController->listar();
                break;
            case 'buscar':
            case 'buscarPorId':
                $pessoasController->buscar();
                break;
            case 'criar':
                $pessoasController->criar();
                break;
            case 'atualizar':
                $pessoasController->atualizar();
                break;
            case 'inativar':
                $pessoasController->inativar();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    case 'tipos':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/TiposAtendimentosController.php';
        $tiposController = new TiposAtendimentosController();

        switch ($action) {
            case 'listar':
                $tiposController->listar();
                break;
            case 'buscar':
            case 'buscarPorId':
                $tiposController->buscarPorId();
                break;
            case 'criar':
                $tiposController->criar();
                break;
            case 'atualizar':
                $tiposController->atualizar();
                break;
            case 'inativar':
                $tiposController->inativar();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    case 'atendimentos':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/AtendimentosController.php';
        $atendimentosController = new AtendimentosController();

        switch ($action) {
            case 'listar':
                $atendimentosController->listar();
                break;
            case 'visualizar':
                $atendimentosController->visualizar();
                break;
            case 'criar':
                $atendimentosController->criar();
                break;
            case 'alterarStatus':
            case 'atualizarStatus':
                $atendimentosController->alterarStatus();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    case 'usuarios':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/UsuariosController.php';
        $usuariosController = new UsuariosController();

        switch ($action) {
            case 'listar':
                $usuariosController->listar();
                break;
            case 'criar':
                $usuariosController->criar();
                break;
            case 'inativar':
                $usuariosController->inativar();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    case 'relatorios':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/RelatoriosController.php';
        $relatoriosController = new RelatoriosController();

        switch ($action) {
            case 'atendimentos':
                $relatoriosController->atendimentos();
                break;
            default:
                echo 'Ação não encontrada.';
        }
        break;

    default:
        echo '<h1>AtendeLab</h1>';
        echo '<p>Use ?controller=X&action=Y para navegar.</p>';
}
