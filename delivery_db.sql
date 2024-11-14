-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/11/2024 às 23:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `delivery_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `descricao`) VALUES
(1, 'Tradicional', 'Sabor tradicional'),
(2, 'Com cobertura', ''),
(3, 'Recheado', NULL),
(4, 'Gourmet', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_menu`
--

CREATE TABLE `itens_menu` (
  `id` int(11) NOT NULL,
  `categorias_id` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `disponivel` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `itens_menu`
--

INSERT INTO `itens_menu` (`id`, `categorias_id`, `nome`, `descricao`, `preco`, `disponivel`, `criado_em`, `atualizado_em`) VALUES
(1, 1, '1', '1', 1.00, 1, '2024-11-14 20:36:37', '2024-11-14 20:36:37'),
(2, 1, '2', '2', 2.00, 1, '2024-11-14 20:37:07', '2024-11-14 20:37:07'),
(3, 1, '3', '3', 3.00, 1, '2024-11-14 20:37:54', '2024-11-14 20:37:54'),
(4, 1, '4', '4', 4.00, 1, '2024-11-14 20:39:19', '2024-11-14 20:39:19'),
(5, 3, '5', '5', 5.00, 0, '2024-11-14 20:41:53', '2024-11-14 20:41:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedidos`
--

CREATE TABLE `itens_pedidos` (
  `id` int(11) NOT NULL,
  `pedidos_id` int(11) NOT NULL,
  `itens_menu_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `estado` enum('pendente','completo','cancelado') DEFAULT 'pendente',
  `preco_total` decimal(10,2) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tipo` enum('admin','usuario') DEFAULT 'usuario',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`, `email`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'adminTest', '$2y$10$S2bYTFo8GLVL6gUiJ39.o.owQNrLTJZ4mSJVDtjCHDQwT4vknsbr6', '111@111', 'admin', '2024-11-14 16:29:33', '2024-11-14 16:29:33'),
(2, 'userTest', '$2y$10$093LvjJfT9wIAmMYI5zlbu4U7e/WQY.qvGJzjjOLWMFZAs8Kud0lG', '222@222', 'usuario', '2024-11-14 16:30:35', '2024-11-14 16:30:35');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_menu`
--
ALTER TABLE `itens_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorias_id` (`categorias_id`);

--
-- Índices de tabela `itens_pedidos`
--
ALTER TABLE `itens_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_id` (`pedidos_id`),
  ADD KEY `itens_menu_id` (`itens_menu_id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_id` (`usuarios_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `itens_menu`
--
ALTER TABLE `itens_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `itens_pedidos`
--
ALTER TABLE `itens_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_menu`
--
ALTER TABLE `itens_menu`
  ADD CONSTRAINT `itens_menu_ibfk_1` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`);

--
-- Restrições para tabelas `itens_pedidos`
--
ALTER TABLE `itens_pedidos`
  ADD CONSTRAINT `itens_pedidos_ibfk_1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `itens_pedidos_ibfk_2` FOREIGN KEY (`itens_menu_id`) REFERENCES `itens_menu` (`id`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
