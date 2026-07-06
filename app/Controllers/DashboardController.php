<?php
// Controller responsável pelos dados exibidos no dashboard.
class DashboardController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function resumo(): void
    {
        exigirAutenticacao();
        header('Content-Type: application/json; charset=utf-8');

        $totalPessoas = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM pessoas WHERE status = 'ativo'")
            ->fetchColumn();

        $totalTipos = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM tipos_atendimentos WHERE status = 'ativo'")
            ->fetchColumn();

        $totalAtendimentos = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM atendimentos")
            ->fetchColumn();

        echo json_encode([
            'indicadores' => [
                'total_pessoas'      => $totalPessoas,
                'total_tipos'        => $totalTipos,
                'total_atendimentos' => $totalAtendimentos,
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}