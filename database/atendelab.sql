-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 05-Jul-2026 às 21:29
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atendelab`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentos`
--

CREATE TABLE `atendimentos` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  `tipo_atendimento_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `status` enum('aberto','em_andamento','concluido') DEFAULT 'aberto',
  `data_atendimento` date NOT NULL,
  `horario_atendimento` time NOT NULL,
  `observacao_final` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `atendimentos`
--

INSERT INTO `atendimentos` (`id`, `pessoa_id`, `tipo_atendimento_id`, `usuario_id`, `descricao`, `status`, `data_atendimento`, `horario_atendimento`, `observacao_final`, `criado_em`, `atualizado_em`) VALUES
(1, 1, 1, 1, 'Duvida sobre a metodologia de avaliacao', 'concluido', '2026-06-01', '08:00:00', 'Metodologia explicada e material de apoio enviado ao aluno', '2026-07-05 19:23:18', '2026-07-05 19:23:18'),
(2, 2, 2, 2, 'Solicitacao de orientacao para definicao do tema do projeto', 'concluido', '2026-06-02', '09:15:00', 'Tema aprovado e cronograma inicial definido em conjunto', '2026-07-05 19:23:18', '2026-07-05 19:23:18'),
(3, 3, 3, 1, 'Relato de falha no acesso ao ambiente virtual da faculdade', 'concluido', '2026-06-03', '10:30:00', 'Credenciais nao validadas no acesso ao sistema', '2026-07-05 19:23:18', '2026-07-05 19:23:18'),
(4, 1, 4, 2, 'Pedido de emissao de declaracao de matricula', 'concluido', '2026-06-04', '13:00:00', 'Declaracao emitida', '2026-07-05 19:23:18', '2026-07-05 19:23:18'),
(5, 2, 5, 1, 'Reserva do laboratorio para ensaio', 'concluido', '2026-06-05', '14:45:00', 'Espaco reservado', '2026-07-05 19:23:18', '2026-07-05 19:23:18'),
(6, 3, 2, 2, 'Necessidade de orientacao sobre normas de formatacao do trabalho de conclusao', 'em_andamento', '2026-06-08', '08:30:00', NULL, '2026-07-05 19:23:18', '2026-07-05 19:23:18'),
(8, 1, 4, 2, 'Solicitacao de historico escolar atualizado para processo seletivo externo', 'aberto', '2026-06-10', '09:00:00', NULL, '2026-07-05 19:23:18', '2026-07-05 19:23:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `documento` varchar(30) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `curso` varchar(120) DEFAULT NULL,
  `periodo` varchar(20) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `nome`, `documento`, `telefone`, `email`, `curso`, `periodo`, `observacoes`, `status`, `criado_em`, `atualizado_em`) VALUES
(1, 'Denis Medina Crusado', '109.567.890-11', '(47) 91788-1308', 'denisito@univille.com', 'Engenharia de Software', '5o', NULL, 'ativo', '2026-07-05 18:47:13', '2026-07-05 18:47:13'),
(2, 'Beatriz Souza Ferreira', '309.600.901-22', '(47) 98999-1002', 'beatriz.ferreira@ex.com', 'Nutricao', '3o', 'Aluno Bolsista', 'ativo', '2026-07-05 18:47:13', '2026-07-05 18:47:13'),
(3, 'Andre Manoel Santana', '490.789.098-33', '(47) 99001-1267', 'cabecadecaixa@exemplo.com', 'Ciencia da Computacao', '4o', 'Aluno PCD', 'ativo', '2026-07-05 18:47:13', '2026-07-05 18:47:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_atendimentos`
--

CREATE TABLE `tipos_atendimentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tipos_atendimentos`
--

INSERT INTO `tipos_atendimentos` (`id`, `nome`, `descricao`, `status`, `criado_em`, `atualizado_em`) VALUES
(1, 'Duvida academica', 'Duvidas sobre disciplinas, avaliacoes e conteudos', 'ativo', '2026-07-05 18:57:01', '2026-07-05 18:57:01'),
(2, 'Orientacao de Processos', 'Orientacoes sobre trabalhos, TCC e projetos academicos', 'ativo', '2026-07-05 18:57:01', '2026-07-05 18:57:01'),
(3, 'Suporte Tecnico', 'Problemas com sistemas, equipamentos e acessos digitais', 'ativo', '2026-07-05 18:57:01', '2026-07-05 18:57:01'),
(4, 'Matricula e documentacao', 'Solicitacoes de matricula, declaracoes e historicos escolares', 'ativo', '2026-07-05 18:57:01', '2026-07-05 18:57:01'),
(5, 'Alterar Permissoes de Acesso', 'Liberacao de acesso considerando o perfil de usuário', 'ativo', '2026-07-05 18:57:01', '2026-07-05 18:57:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','atendente') DEFAULT 'atendente',
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `status`, `criado_em`, `atualizado_em`) VALUES
(1, 'Administrador', 'admin@atendelab.com', '$2b$10$0u0ecyLW1hi.0cYnwdaKJOAyNDEuVI3watZ/uXtBVRhuKLbYNqT6y', 'admin', 'ativo', '2026-07-05 19:10:07', '2026-07-05 19:10:07'),
(2, 'Atendente', 'atendente@atendelab.com', '$2b$10$Fztrt2KtdImJG7MEymqAlOejAtV1HAx4n0KEMaFxhzmbuLBRAIdAq', 'atendente', 'ativo', '2026-07-05 19:10:07', '2026-07-05 19:10:07');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atendimentos_pessoa` (`pessoa_id`),
  ADD KEY `fk_atendimentos_tipo` (`tipo_atendimento_id`),
  ADD KEY `fk_atendimentos_usuario` (`usuario_id`);

--
-- Índices para tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Índices para tabela `tipos_atendimentos`
--
ALTER TABLE `tipos_atendimentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipos_atendimentos`
--
ALTER TABLE `tipos_atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD CONSTRAINT `fk_atendimentos_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`id`),
  ADD CONSTRAINT `fk_atendimentos_tipo` FOREIGN KEY (`tipo_atendimento_id`) REFERENCES `tipos_atendimentos` (`id`),
  ADD CONSTRAINT `fk_atendimentos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
