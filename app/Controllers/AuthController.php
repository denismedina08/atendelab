<?php
// Controller responsável pelo login e logout do sistema.
class AuthController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function exibirLogin(): void
    {
        if (usuarioAutenticado()) {
            header('Location: /atendelab/public/?controller=auth&action=dashboard');
            exit;
        }

        $erroLogin = null;
        $mensagem  = $_GET['mensagem'] ?? null;

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function entrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /atendelab/public/?controller=auth&action=login');
            exit;
        }

        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
        $senha = $_POST['senha'] ?? '';

        // Valida o formato do e-mail antes de consultar o banco.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
            $erroLogin = 'E-mail ou senha inválidos.';
            require __DIR__ . '/../Views/auth/login.php';
            return;
        }

        $sql = 'SELECT id, nome, email, senha, perfil, status
                FROM usuarios
                WHERE email = :email
                LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica senha e se o usuário está ativo.
        if (!$usuario || !password_verify($senha, $usuario['senha']) || $usuario['status'] !== 'ativo') {
            $erroLogin = 'E-mail ou senha inválidos.';
            require __DIR__ . '/../Views/auth/login.php';
            return;
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id'     => (int) $usuario['id'],
            'nome'   => $usuario['nome'],
            'email'  => $usuario['email'],
            'perfil' => $usuario['perfil'],
        ];

        header('Location: /atendelab/public/?controller=auth&action=dashboard');
        exit;
    }

    public function dashboard(): void
    {
        exigirAutenticacao();
        $tituloPagina = 'Dashboard';
        require __DIR__ . '/../Views/dashboard/index.php';
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        header('Location: /atendelab/public/?controller=auth&action=login&mensagem=logout');
        exit;
    }
}
