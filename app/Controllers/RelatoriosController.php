<?php
// Controller de relatórios.
// Permite filtrar atendimentos por período para geração de relatórios.
class RelatoriosController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function atendimentos(): void
    {
        exigirAutenticacao();
        header('Content-Type: application/json; charset=utf-8');

        // Usa o mês atual como período padrão se não informado.
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim    = $_GET['data_fim']    ?? date('Y-m-d');

        try {
            $sql = "SELECT a.id,
                            CONCAT('ATD-', LPAD(a.id, 4, '0')) AS protocolo,
                            p.nome AS pessoa,
                            t.nome AS tipo,
                            u.nome AS responsavel,
                            a.descricao,
                            a.status,
                            a.data_atendimento,
                            a.horario_atendimento,
                            a.observacao_final
                    FROM atendimentos a
                    JOIN pessoas            p ON p.id = a.pessoa_id
                    JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id
                    JOIN usuarios           u ON u.id = a.usuario_id
                    WHERE a.data_atendimento BETWEEN :inicio AND :fim
                    ORDER BY a.data_atendimento ASC, a.horario_atendimento ASC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':inicio', $dataInicio);
            $stmt->bindValue(':fim',    $dataFim);
            $stmt->execute();
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'periodo'      => ['inicio' => $dataInicio, 'fim' => $dataFim],
                'total'        => count($registros),
                'atendimentos' => $registros,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao gerar relatório.']);
        }
    }
}
