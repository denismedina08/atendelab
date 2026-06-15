<?php

// Controller da entidade pessoas

class PessoasController {
    private PDO $pdo;

    public function __construct() {
        require __DIR__ . '\..\..\config\database.php';
        $this->pdo = $pdo;
    }

    public function listar(): void {
        header('Content-Type: application/json; charset=utf-8');

        $sql = 'SELECT * 
                FROM pessoas
                ORDER BY id DESC';

        $stmt = $this->pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function buscarPorId(): void {
        header('Content-Type: application/json; charset=utf-8');

        // Lê e valida o ID recebido por GET
        $id = filter_input(INPUT_GET, 'id, FILTER_VALIDATE_INT');

        if(!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']);
            return;
        }

        $sql = 'SELECT id, nome, documento, telefone, curso, periodo, criado em
                FROM pessoas
                WHERE id = :id';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!usuario) {
            http_response_code(400);
            echo json_encode(['erro' => 'Pessoa não encontrada.']);
            return;
        }

        echo json_encode($usuario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function criar(): void {
        header('Content-Type: application/json; charset=utf-8');

         // coleta dados do formulário (POST)
        $nome = trim($_POST['nome'] ?? '');
        $documento = trim($_POST['documento'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $curso = trim($_POST['curso'] ?? '');
        $periodo = trim($_POST['periodo'] ?? '');


        // regras mínimas de validação de entrada
        if ($nome === '' || $documento === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome e documento são obrigatórios.']);
            return;
        }

        try {
            $sql = 'INSERT INTO pessoas (nome, documento, telefone, curso, periodo)
                    VALUES (:nome, :documento, :telefone, :curso, :periodo)'; 
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':documento', $documento);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':curso', $curso);
            $stmt->bindValue(':periodo', $periodo);
            $stmt->execute();

            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Usuário cadastrado com sucesso.',
                'id' => $this->pdo->lastInsertId()
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastrar usuário.']);
        }

    }

    public function atualizar(): void {
        header('Content-Type: application/json; charset=utf-8');

        // dados POST
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nome = trim($_POST['nome'] ?? '');
        $documento = trim($_POST['documento'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $curso = trim($_POST['curso'] ?? '');
        $periodo = trim($_POST['periodo'] ?? '');


        // regras mínimas de validação de entrada
        if ($nome === '' || $documento === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'Nome e documento são obrigatórios.']);
            return;
        }


        try {
            $sql = 'UPDATE pessoas
                    SET nome = :nome,
                        documento = :documento,
                        telefone = :telefone,
                        curso = :curso,
                        periodo = :periodo
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':documento', $documento);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':curso', $curso);
            $stmt->bindValue(':periodo', $periodo);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(
                ['mensagem' => 'Pessoa atualizada com sucesso.'],
                JSON_UNESCAPED_UNICODE
            );
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar pessoa.']);
        }
    }

    public function excluir(): void {
        header('Content-Type: application/json; charset=utf-8');

               // exclusão por ID recebido no corpo da requisição.
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']);
            return;
        }

        try {
            $sql = 'DELETE FROM pessoas WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(
                ['mensagem' => 'Pessoa excluída com sucesso.'],
                JSON_UNESCAPED_UNICODE
            );
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao excluir pessoa.']);
        }
    }
}

?>