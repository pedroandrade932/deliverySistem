-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 11/11/2024 às 00:15
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ialuana_tocomfome`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adm`
--

CREATE TABLE `adm` (
  `idadm` mediumint(9) NOT NULL,
  `idger` mediumint(9) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `biografia` varchar(100) DEFAULT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `msgs`
--

CREATE TABLE `msgs` (
  `id` int(11) NOT NULL,
  `iduser` mediumint(9) NOT NULL,
  `msg` text NOT NULL,
  `data_envio` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `msgs`
--

INSERT INTO `msgs` (`id`, `iduser`, `msg`, `data_envio`) VALUES
(10, 81059, 'Definitivamente um dos sistemas de delivery já criados', '2024-11-10'),
(11, 81059, 'Queria eu que garotas palhaços fossem uma raça real de pessoas', '2024-11-10'),
(12, 547617, 'menino, e o bixo é bom mesmo', '2024-11-11'),
(13, 163881, 'Ele fica perto dos que estão desanimados e salva os que perderam a esperança.\r\n\r\nSalmos 34:18', '2024-11-11'),
(14, 163881, 'Ele fica perto dos que estão desanimados e salva os que perderam a esperança.\r\n\r\nSalmos 34:18', '2024-11-11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notbox`
--

CREATE TABLE `notbox` (
  `id` int(11) NOT NULL,
  `iduser` mediumint(9) NOT NULL,
  `idmsg` int(11) NOT NULL,
  `lida` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico`
--

CREATE TABLE `servico` (
  `idserv` mediumint(9) NOT NULL,
  `nomeserv` varchar(60) NOT NULL,
  `foto` varchar(60) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `tempo` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `preco` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `servico`
--

INSERT INTO `servico` (`idserv`, `nomeserv`, `foto`, `tipo`, `tempo`, `descricao`, `preco`) VALUES
(5, 'Hamburguer Artesanal', 'hamburguer-artesanal-scaled.jpg', 'Fast food', 20, 'Pão brioche tostado, hambúrguer 100% carne bovina, queijo cheddar derretido, fatias de bacon crocante, alface fresca, tomate, cebola roxa e molho especial da casa.', 24.99),
(6, 'Hamburguer Completo', 'hamburguer-artesanal-scaled.jpg', 'Fast food', 30, 'Pão brioche tostado, hambúrguer 100% carne bovina, queijo cheddar derretido, fatias de bacon crocante, alface fresca, tomate, cebola roxa e molho especial da casa.', 15.55),
(7, 'Pizza de calabresa', 'pizza-468515806.jpg', 'Fast food', 45, '', 49.99);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `iduser` mediumint(9) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `email` varchar(160) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `adm` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`iduser`, `nome`, `active`, `email`, `senha`, `foto`, `adm`) VALUES
(81059, 'Pedrinbola8', 1, 'VsupDoq0D2FgymOAUa+hzA/sbkEZhX8=', 'Bv4F+xIUCZ8=', 'Pedrinbola8-1731241162.jpg', 0),
(163881, 'Lucas', 1, 'W6tmPEzt9zoemkr/cukTPO+8Bg==', 'X6gHvFVqEu8ePoJfVuiV', 'Lucas-1731260723.jpg', 0),
(361326, 'yohanne', 1, 'Tstm4lzpbBR/ej16rkSf0zW4d4/KSbjT23KO9CEtjrQ7yR0=', 'Vs0+MkMhO36e', 'yohanne-1731282737.jpg', 0),
(547617, 'felipe parnaiba', 1, 'UVskM56CB1Rk7aR64ww2FvxOp7UkdrHzLNk=', 'VsimXgIVFG64jtU=', 'felipe parnaiba-1731283740.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario-servico`
--

CREATE TABLE `usuario-servico` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idservico` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`idadm`);

--
-- Índices de tabela `msgs`
--
ALTER TABLE `msgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`);

--
-- Índices de tabela `notbox`
--
ALTER TABLE `notbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idmsg` (`idmsg`);

--
-- Índices de tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`idserv`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`iduser`);

--
-- Índices de tabela `usuario-servico`
--
ALTER TABLE `usuario-servico`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `msgs`
--
ALTER TABLE `msgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `notbox`
--
ALTER TABLE `notbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `idserv` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuario-servico`
--
ALTER TABLE `usuario-servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
