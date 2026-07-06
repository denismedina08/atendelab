<?php
// Registra, lista e atualiza o status dos atendimentos realizados.
class AtendimentosController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function listar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        // JOIN com as três tabelas relacionadas para montar a listagem completa.
        $sql = 'SELECT a.id,
                        p.nome  AS pessoa,
                        t.nome  AS tipo,
                        u.nome  AS responsavel,
                        a.descricao,
                        a.status,
                        a.data_atendimento,
                        a.horario_atendimento,
                        a.observacao_final,
                        a.criado_em
                FROM atendimentos a
                JOIN pessoas            p ON p.id = a.pessoa_id
                JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id
                JOIN usuarios           u ON u.id = a.usuario_id
                ORDER BY a.data_atendimento DESC, a.horario_atendimento DESC';

        $stmt = $this->pdo->query($sql);
        $atendimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['atendimentos' => $atendimentos], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function visualizar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']);
            return;
        }

        $sql = 'SELECT a.id,
                        a.pessoa_id,
                        a.tipo_atendimento_id,
                        a.usuario_id,
                        p.nome  AS pessoa,
                        t.nome  AS tipo,
                        u.nome  AS responsavel,
                        a.descricao,
                        a.status,
                        a.data_atendimento,
                        a.horario_atendimento,
                        a.observacao_final,
                        a.criado_em
                FROM atendimentos a
                JOIN pessoas            p ON p.id = a.pessoa_id
                JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id
                JOIN usuarios           u ON u.id = a.usuario_id
                WHERE a.id = :id
                LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $atendimento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$atendimento) {
            http_response_code(404);
            echo json_encode(['erro' => 'Atendimento não encontrado.']);
            return;
        }

        echo json_encode(['atendimento' => $atendimento], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function criar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $pessoaId  = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
        $tipoId    = filter_input(INPUT_POST, 'tipo_atendimento_id', FILTER_VALIDATE_INT);
        $descricao = trim($_POST['descricao'] ?? '');
        $data      = trim($_POST['data_atendimento'] ?? '');
        $horario   = trim($_POST['horario_atendimento'] ?? '');

        $usuarioId = $_SESSION['usuario']['id'] ?? null;

        if (!$pessoaId) {
            http_response_code(400);
            echo json_encode(['erro' => 'Pessoa é obrigatória.']);
            return;
        }

        if (!$tipoId) {
            http_response_code(400);
            echo json_encode(['erro' => 'Tipo de atendimento é obrigatório.']);
            return;
        }

        if ($descricao === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'Descrição é obrigatória.']);
            return;
        }

        if ($data === '' || $horario === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'Data e horário são obrigatórios.']);
            return;
        }

        try {
            $sql = "INSERT INTO atendimentos
                        (pessoa_id, tipo_atendimento_id, usuario_id, descricao,
                            status, data_atendimento, horario_atendimento)
                    VALUES
                        (:pessoa_id, :tipo_id, :usuario_id, :descricao,
                            'aberto', :data, :horario)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':pessoa_id',  $pessoaId, PDO::PARAM_INT);
            $stmt->bindValue(':tipo_id',    $tipoId,   PDO::PARAM_INT);
            $stmt->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
            $stmt->bindValue(':descricao',  $descricao);
            $stmt->bindValue(':data',       $data);
            $stmt->bindValue(':horario',    $horario);
            $stmt->execute();

            $novoId    = (int) $this->pdo->lastInsertId();
            $protocolo = 'ATD-' . str_pad((string) $novoId, 4, '0', STR_PAD_LEFT);

            http_response_code(201);
            echo json_encode([
                'mensagem'  => 'Atendimento registrado com sucesso.',
                'id'        => $novoId,
                'protocolo' => $protocolo,
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao registrar atendimento.']);
        }
    }

    public function alterarStatus(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id              = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $status          = $_POST['status'] ?? '';
        $observacaoFinal = trim($_POST['observacao_final'] ?? '');

        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']);
            return;
        }

        $statusValidos = ['aberto', 'em_andamento', 'concluido'];
        if (!in_array($status, $statusValidos, true)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Status inválido.']);
            return;
        }

        // Observação final obrigatória
        if ($status === 'concluido' && $observacaoFinal === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'Observação final é obrigatória ao concluir o atendimento.']);
            return;
        }

        try {
            $sql = 'UPDATE atendimentos
                    SET status           = :status,
                        observacao_final = :obs
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':obs',    $observacaoFinal ?: null);
            $stmt->bindValue(':id',     $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['mensagem' => 'Status atualizado com sucesso.'], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar status.']);
        }
    }
}
