# Sistema de Gestão de Ponto, Faltas e Auditoria

## Visão Geral

Este sistema é uma aplicação web para gerenciamento completo de controle de ponto, faltas, atrasos, setores, usuários e auditorias internas. Ele permite controlar entradas e saídas de funcionários, registrar faltas e atrasos, organizar setores, gerenciar usuários e manter um histórico auditável das ações realizadas no sistema.

## Tecnologias Utilizadas

- **Laravel Framework (PHP)**: Backend da aplicação, estruturando a lógica de negócio, controle e serviços.
- **Blade Templates**: Sistema de templates para geração de views HTML.
- **Eloquent ORM**: Manipulação e consulta ao banco de dados de forma simples e organizada.
- **MySQL / Outro Banco Relacional**: Armazenamento dos dados do sistema.
- **TCPDF / DomPDF**: Geração de relatórios e documentos PDF a partir dos dados do sistema.
- **Bootstrap 5**: Framework CSS para estilização e layout responsivo das páginas.
- **Logs com Monolog**: Registro de erros e eventos para monitoramento e debugging.

## Funcionalidades Implementadas Até Agora

- **Gerenciamento de Funcionários**: Cadastro, edição, exclusão e listagem.
- **Controle de Ponto**: Registro de entradas e saídas dos funcionários, com validações e visualização dos registros.
- **Gestão de Faltas e Atrasos**: Registro e controle de faltas e atrasos, com possibilidade de justificativa.
- **Gestão de Setores**: Organização e gerenciamento dos setores da empresa, vinculando funcionários e gestores.
- **Gerenciamento de Usuários**: Controle de usuários do sistema, com níveis e tipos de acesso diferenciados.
- **Auditoria do Sistema**: Registro detalhado das ações dos usuários para segurança e rastreabilidade.
- **Relatórios em PDF**: Geração de relatórios personalizados, incluindo ponto, faltas, atrasos e auditorias.
- **Tratamento de Erros**: Controle de exceções com logs para facilitar manutenção e suporte.

## Objetivo do Sistema

O sistema foi desenvolvido para facilitar a gestão de controle de ponto, faltas e atrasos em empresas de pequeno a médio porte, garantindo maior transparência e segurança por meio da auditoria das ações realizadas pelos usuários. Além disso, oferece recursos para organização dos setores, gerenciamento de usuários e geração de relatórios que auxiliam na tomada de decisões e no acompanhamento das atividades diárias dos colaboradores.

---
