# AtendeLab

<!-- Sistema de Controle de Atendimentos Acadêmicos -->

## Tecnologias

- PHP 8.x + PDO
- MySQL (XAMPP porta 3307)
- HTML + CSS + Bootstrap 5.3
- JavaScript + Fetch API (x-www-form-urlencoded)
- Arquitetura MVC simples (sem framework)

### Pré-requisitos

- XAMPP com Apache e MySQL ativos
- MySQL rodando na **porta 3307**

## Como executar localmente
1. Clonar o repositório.
2. Colocar a pasta no htdocs do XAMPP.
3. Iniciar Apache e MySQL.
4. Criar o banco atendelab.
5. Importar o script database/atendelab.sql.
6. Acessar http://localhost/atendelab/public/

## Acesso ao sistema

A tela de login é exibida automaticamente ao abrir o sistema
Inserir as credenciais de acesso previamente cadastradas.

Campo   Campo
Email | -------
Senha | -------

Usuários com status `inativo` não conseguem acessar o sistema mesmo com credenciais corretas.

## URLs principais

Login                 `/atendelab/public/?controller=auth&action=login`
Dashboard             `/atendelab/public/?controller=auth&action=dashboard`
Pessoas (visual)      `/atendelab/public/?controller=frontend&action=pessoas`
Tipos (visual)        `/atendelab/public/?controller=frontend&action=tipos`
Atendimentos (visual) `/atendelab/public/?controller=frontend&action=atendimentos`
Dashboard JSON        `/atendelab/public/?controller=dashboard&action=resumo`
Pessoas JSON          `/atendelab/public/?controller=pessoas&action=listar`
Tipos JSON            `/atendelab/public/?controller=tipos&action=listar`
Atendimentos JSON     `/atendelab/public/?controller=atendimentos&action=listar`

## Fluxo técnico

Navegador
  -> public/index.php
  -> routes.php (?controller=X&action=Y)
  -> Middleware (exigirAutenticacao)
  -> Controller::metodo()
  -> PDO -> banco atendelab
  -> JSON
  -> api.js (AtendeLabApi)
  -> Tela atualizada