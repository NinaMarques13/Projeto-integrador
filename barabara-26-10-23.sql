-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Out-2023 às 20:40
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `barabarateste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arq_midia`
--

CREATE TABLE `arq_midia` (
  `id_arq_midia` int(11) NOT NULL,
  `id_cadastro(FK)` int(11) NOT NULL,
  `id_causa(FK)` int(11) NOT NULL,
  `ds_foto` blob NOT NULL,
  `ds_video` blob NOT NULL,
  `ds_links` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chave_pix`
--

CREATE TABLE `chave_pix` (
  `id_transacao` int(11) NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  `id_causa(FK)` int(11) NOT NULL,
  `id_cadastro(FK)` int(11) NOT NULL,
  `nr_chave_cpf` char(11) NOT NULL,
  `nr_chave_cnpj` char(14) NOT NULL,
  `nr_chave_telefone` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE `contato` (
  `id_contato` int(11) NOT NULL,
  `id_cadastro(FK)` int(11) NOT NULL,
  `id_causa(FK)` int(11) NOT NULL,
  `nr_celular` char(11) NOT NULL,
  `nr_residencial` char(11) NOT NULL,
  `nr_empresarial` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_bancarios`
--

CREATE TABLE `dados_bancarios` (
  `id_dados_bancarios` int(11) NOT NULL,
  `id_causa(FK)` int(11) NOT NULL,
  `id_cadastro(FK)` int(11) NOT NULL,
  `tp_pagamento(FK)` int(11) NOT NULL,
  `nm_banco` varchar(15) NOT NULL,
  `nr_agencia` char(4) NOT NULL,
  `nr_conta_e_digito` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecou_usuario`
--

CREATE TABLE `enderecou_usuario` (
  `id_endereco` int(11) NOT NULL,
  `id_cadastro(FK)` int(11) NOT NULL,
  `nr_cep` varchar(8) NOT NULL,
  `nm_rua` varchar(50) NOT NULL,
  `nm_bairro` varchar(30) NOT NULL,
  `nm_cidade` varchar(30) NOT NULL,
  `nm_pais` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereço_pub`
--

CREATE TABLE `endereço_pub` (
  `id_endereço_pub` int(11) NOT NULL,
  `id_cadastro(FK)` int(11) NOT NULL,
  `id_causa(FK)` int(11) NOT NULL,
  `nr_cep` char(8) NOT NULL,
  `nm_rua` varchar(50) NOT NULL,
  `nm_bairro` varchar(30) NOT NULL,
  `nm_ cidade` varchar(30) NOT NULL,
  `nm_pais` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(10) NOT NULL,
  `tp_pagamento` int(10) NOT NULL,
  `id_cadastro (FK)` int(10) NOT NULL,
  `id_causa (FK)` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pag_inicial`
--

CREATE TABLE `pag_inicial` (
  `id_pag_inicial` int(11) NOT NULL,
  `id_publicaçao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicação`
--

CREATE TABLE `publicação` (
  `id_causa` int(10) NOT NULL,
  `id_cadastro (FK)` int(10) UNSIGNED NOT NULL,
  `qt_meta` float(8,2) NOT NULL,
  `ds_ocorrido` longtext NOT NULL,
  `dt_date` date NOT NULL,
  `hr_hora` time NOT NULL,
  `ds_cortesia` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_cadastro` int(10) NOT NULL,
  `nm_usuario` varchar(120) NOT NULL,
  `nm_email` varchar(50) NOT NULL,
  `nr_cpf` char(11) NOT NULL,
  `nr_senha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `arq_midia`
--
ALTER TABLE `arq_midia`
  ADD PRIMARY KEY (`id_arq_midia`);

--
-- Índices para tabela `chave_pix`
--
ALTER TABLE `chave_pix`
  ADD PRIMARY KEY (`id_transacao`);

--
-- Índices para tabela `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`id_contato`);

--
-- Índices para tabela `dados_bancarios`
--
ALTER TABLE `dados_bancarios`
  ADD PRIMARY KEY (`id_dados_bancarios`);

--
-- Índices para tabela `endereço_pub`
--
ALTER TABLE `endereço_pub`
  ADD PRIMARY KEY (`id_endereço_pub`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`);

--
-- Índices para tabela `publicação`
--
ALTER TABLE `publicação`
  ADD PRIMARY KEY (`id_causa`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_cadastro`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arq_midia`
--
ALTER TABLE `arq_midia`
  MODIFY `id_arq_midia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chave_pix`
--
ALTER TABLE `chave_pix`
  MODIFY `id_transacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contato`
--
ALTER TABLE `contato`
  MODIFY `id_contato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dados_bancarios`
--
ALTER TABLE `dados_bancarios`
  MODIFY `id_dados_bancarios` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `endereço_pub`
--
ALTER TABLE `endereço_pub`
  MODIFY `id_endereço_pub` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `publicação`
--
ALTER TABLE `publicação`
  MODIFY `id_causa` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_cadastro` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
