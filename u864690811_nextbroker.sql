-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 25/09/2025 às 15:10
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u864690811_nextbroker`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `username` varchar(70) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `image` varchar(120) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'r3nato90@hotmail.com', 'r3nato90@hotmail.com', '$2y$10$tC.uVnvFxEzgPzOxEI5WE.PPydCekuCXPpAZvGqhMNA0sdo53BSBC', NULL, NULL, NULL, NULL, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(2, 'Admin User', 'brenoperegrino@gmail.com', 'brenoperegrino@gmail.com', '$2y$10$ImCthG8piB6nHYaoL0PBqeS0RcDClew7BmVefCvdvw7EYWR9rEbyy', NULL, NULL, NULL, NULL, '2025-09-16 12:39:17', '2025-09-16 12:39:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `token` varchar(60) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 2,
  `details` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `investment_log_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `contacts`
--

INSERT INTO `contacts` (`id`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'dianacruz.mkt@gmail.com', 'Re: Increase traffic to your website', 'Hello team, \"nextbroker.online\"\n\nI just wanted to know if you require a better solution to manage SEO, SMO, SMM, PPC Campaigns, keyword research, Reporting etc. We are a leading Digital Marketing Agency, offering marketing solutions at affordable prices.\n\n Because of this you\'re losing a ton of calls to your competitors!\n\nWe can place your website on Google\'s 1st page. We will improve your website’s position on Google and get more traffic.\n\nIf interested, kindly provide me your name, phone number, and email.\n\n\nThank you,\n\nDiana Cruz', '2025-09-17 08:42:55', '2025-09-17 08:42:55'),
(2, 'briannawebsolution@gmail.com', 'Re: Improve your website traffic and SEO', '\"Hi,\r\nI visited your website online and discovered that it was not showing up in any search results for the majority of keywords related to your company on Google, Yahoo, or Bing.\r\n\r\nDo you want more targeted visitors on your website?\r\n\r\nWe can place your website on Google’s 1st Page. yahoo, AOL, Bing. Etc.\r\n\r\nIf interested, kindly provide me your name, phone number, and email.\r\n\r\nRegards,\r\nBrianna Belton\"', '2025-09-18 06:45:26', '2025-09-18 06:45:26'),
(3, 'joannariggs278@gmail.com', 'Explainer Video for nextbroker.online?', 'Hi,\r\n\r\nI just visited nextbroker.online and wondered if you\'ve ever considered an impactful video to advertise your business? Our videos can generate impressive results on both your website and across social media.\r\n\r\nOur prices start from just $195 (USD).\r\n\r\nLet me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nJoanna\r\n\r\nUnsubscribe: https://unsubscribe.video/unsubscribe.php?d=nextbroker.online', '2025-09-18 14:01:00', '2025-09-18 14:01:00'),
(4, 'daniel.websolution04@gmail.com', 'Question about your website', '\"Hello,\r\n\r\nFollowing the completion of your website, we conducted a quick backend check to ensure everything was functioning smoothly. However, the results revealed that your website is currently not appearing on major search engines like Google and Bing when relevant keywords related to your business are searched.\r\n\r\nThis is primarily due to the lack of proper SEO (Search Engine Optimization), which is currently incomplete. Without it, your website will struggle to appear in search results, meaning your target audience won’t be able to find you and your site won’t receive the traffic or conversions it was designed to generate.\r\n\r\nPlease share your phone number and a convenient time for a brief call. We’d be happy to guide you on how we can help you attract more traffic.\r\n\r\nThanks,\r\nDaniel Edwards\"', '2025-09-18 17:13:21', '2025-09-18 17:13:21'),
(5, 'domains@searchindexing.pro', 'Add nextbroker.online to Google Search Index!', 'Hi,\r\n\r\nRegister nextbroker.online in the Google Search Index to have it displayed in search results. Visit now:  -->\r\n\r\nhttps://SearchRegister.org/', '2025-09-18 21:07:05', '2025-09-18 21:07:05'),
(6, 'gemma.marshall.112@gmail.com', 'Social Media Growth: 700 new followers each month', 'Hi,\r\n\r\nWe run a Social Media service, which increases your number of followers by 700+ a month both safely and practically.\r\n\r\nThe process is safe, followers are real (they follow because they are interested in your content), and we can even create a profile for you if required.\r\n\r\nIf you are interested, I\'d be happy to forward you some further information.\r\n\r\nKind Regards,\r\nGemma', '2025-09-19 09:42:35', '2025-09-19 09:42:35'),
(7, 'domains@searchindexing.pro', 'Add nextbroker.online to Google Search Index!', 'Hi,\r\n\r\nRegister nextbroker.online in the Google Search Index to have it displayed in search results. Visit now:  -->\r\n\r\nhttps://SearchRegister.org/', '2025-09-19 15:41:21', '2025-09-19 15:41:21'),
(8, 'domains@searchindexing.pro', 'Add nextbroker.online to Google Search Index!', 'Hi,\r\n\r\nRegister nextbroker.online in the Google Search Index to have it displayed in search results. Visit now:  -->\r\n\r\nhttps://SearchRegister.org/', '2025-09-19 15:48:17', '2025-09-19 15:48:17'),
(9, 'emanibrahim2027@gmail.com', 'Freelance graphic designer with over 7 years of experience - جرافيك ديزاينر فريلانسر خبره أكثر من 7 سنوات', 'Experience: Working with over 100 clients (companies) from various Arab countries, including Egypt, Saudi Arabia, the UAE, Qatar, and Kuwait. Social media designs - logos - business cards - banners - flyers - company profiles - company catalogs.\r\n\r\n\r\nSome of my work : https://www.behance.net/emanibrahim3\r\nAvailable \r\n\r\nfor work : \r\nTo contact us via WhatsApp: 00201098839623 \r\n\r\n\r\nTo contact us: 009660553501506', '2025-09-20 00:25:11', '2025-09-20 00:25:11'),
(10, 'domains@searchindexing.pro', 'Add nextbroker.online to Google Search Index!', 'Hi,\r\n\r\nRegister nextbroker.online in the Google Search Index to have it displayed in search results. Visit now:  -->\r\n\r\nhttps://SearchRegister.org/', '2025-09-21 17:28:51', '2025-09-21 17:28:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `crons`
--

CREATE TABLE `crons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `ideal_time` varchar(255) DEFAULT NULL,
  `last_run` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `crons`
--

INSERT INTO `crons` (`id`, `name`, `code`, `ideal_time`, `last_run`, `created_at`, `updated_at`) VALUES
(1, 'Crypto-Currency', '1', 'Daily', NULL, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(2, 'Investment Process', '2', 'Every Minute', NULL, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(3, 'Trade Outcome', '3', 'Every Minute', NULL, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(4, 'Queue Work', '4', 'Every Minute', NULL, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `crypto_currencies`
--

CREATE TABLE `crypto_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(190) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('crypto') NOT NULL,
  `current_price` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `previous_price` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `total_volume` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `market_cap` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rank` int(11) NOT NULL DEFAULT 0,
  `change_percent` decimal(10,4) DEFAULT NULL,
  `base_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `image_url` varchar(500) DEFAULT NULL,
  `tradingview_symbol` varchar(50) DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `crypto_currencies`
--

INSERT INTO `crypto_currencies` (`id`, `name`, `symbol`, `status`, `created_at`, `updated_at`, `type`, `current_price`, `previous_price`, `total_volume`, `market_cap`, `rank`, `change_percent`, `base_currency`, `image_url`, `tradingview_symbol`, `last_updated`) VALUES
(1, 'Bitcoin', 'BTC', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 115422.00000000, 115422.00000000, 37666781906.00000000, 2298884588758.00000000, 1, 0.4683, 'USD', 'https://coin-images.coingecko.com/coins/images/1/large/bitcoin.png?1696501400', 'CRYPTOCAP:BTC', '2025-09-16 12:39:16'),
(2, 'Ethereum', 'ETH', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 4502.33000000, 4502.33000000, 25217347159.00000000, 543313559353.00000000, 2, -0.4955, 'USD', 'https://coin-images.coingecko.com/coins/images/279/large/ethereum.png?1696501628', 'CRYPTOCAP:ETH', '2025-09-16 12:39:16'),
(3, 'Tether', 'USDT', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 1.00000000, 1.00000000, 80553536543.00000000, 170288470788.00000000, 4, -0.0131, 'USD', 'https://coin-images.coingecko.com/coins/images/325/large/Tether.png?1696501661', 'CRYPTOCAP:USDT', '2025-09-16 12:39:16'),
(4, 'BNB', 'BNB', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 927.40000000, 927.40000000, 1180138767.00000000, 129050182734.00000000, 5, 0.8003, 'USD', 'https://coin-images.coingecko.com/coins/images/825/large/bnb-icon2_2x.png?1696501970', 'CRYPTOCAP:BNB', '2025-09-16 12:39:16'),
(5, 'Solana', 'SOL', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 235.41000000, 235.41000000, 7186044976.00000000, 127696019039.00000000, 6, -0.3490, 'USD', 'https://coin-images.coingecko.com/coins/images/4128/large/solana.png?1718769756', 'CRYPTOCAP:SOL', '2025-09-16 12:39:16'),
(6, 'USD Coin', 'USDC', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.99980000, 0.99980000, 8152021335.00000000, 73117941732.00000000, 7, 0.0107, 'USD', 'https://coin-images.coingecko.com/coins/images/6319/large/usdc.png?1696506694', 'CRYPTOCAP:USDC', '2025-09-16 12:39:16'),
(7, 'Lido Staked ETH', 'STETH', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 4497.39000000, 4497.39000000, 42150552.00000000, 38700841055.00000000, 9, -0.4201, 'USD', 'https://coin-images.coingecko.com/coins/images/13442/large/steth_logo.png?1696513206', 'CRYPTOCAP:STETH', '2025-09-16 12:39:16'),
(8, 'Dogecoin', 'DOGE', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.26604600, 0.26604600, 3736414762.00000000, 40115516616.00000000, 8, 0.9247, 'USD', 'https://coin-images.coingecko.com/coins/images/5/large/dogecoin.png?1696501409', 'CRYPTOCAP:DOGE', '2025-09-16 12:39:16'),
(9, 'Cardano', 'ADA', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.87030400, 0.87030400, 1231132290.00000000, 31758056073.00000000, 11, 0.9459, 'USD', 'https://coin-images.coingecko.com/coins/images/975/large/cardano.png?1696502090', 'CRYPTOCAP:ADA', '2025-09-16 12:39:16'),
(10, 'TRON', 'TRX', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.34606600, 0.34606600, 639373454.00000000, 32765122110.00000000, 10, 0.2500, 'USD', 'https://coin-images.coingecko.com/coins/images/1094/large/tron-logo.png?1696502193', 'CRYPTOCAP:TRX', '2025-09-16 12:39:16'),
(11, 'Avalanche', 'AVAX', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 30.43000000, 30.43000000, 1235337556.00000000, 12843560243.00000000, 18, 5.8971, 'USD', 'https://coin-images.coingecko.com/coins/images/12559/large/Avalanche_Circle_RedWhite_Trans.png?1696512369', 'CRYPTOCAP:AVAX', '2025-09-16 12:39:16'),
(12, 'Chainlink', 'LINK', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 23.64000000, 23.64000000, 700546806.00000000, 16029511779.00000000, 13, 1.2869, 'USD', 'https://coin-images.coingecko.com/coins/images/877/large/chainlink-new-logo.png?1696502009', 'CRYPTOCAP:LINK', '2025-09-16 12:39:16'),
(13, 'Shiba Inu', 'SHIB', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.00001303, 0.00001303, 200770867.00000000, 7680563600.00000000, 31, 0.0017, 'USD', 'https://coin-images.coingecko.com/coins/images/11939/large/shiba.png?1696511800', 'CRYPTOCAP:SHIB', '2025-09-16 12:39:16'),
(14, 'Bitcoin Cash', 'BCH', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 591.33000000, 591.33000000, 265571182.00000000, 11780283900.00000000, 23, -0.3086, 'USD', 'https://coin-images.coingecko.com/coins/images/780/large/bitcoin-cash-circle.png?1696501932', 'CRYPTOCAP:BCH', '2025-09-16 12:39:16'),
(15, 'Polkadot', 'DOT', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 4.22000000, 4.22000000, 288129822.00000000, 6417063347.00000000, 34, 0.7885, 'USD', 'https://coin-images.coingecko.com/coins/images/12171/large/polkadot.png?1696512008', 'CRYPTOCAP:DOT', '2025-09-16 12:39:16'),
(16, 'NEAR Protocol', 'NEAR', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 2.69000000, 2.69000000, 134108570.00000000, 3357450289.00000000, 49, 2.4482, 'USD', 'https://coin-images.coingecko.com/coins/images/10365/large/near.jpg?1696510367', 'CRYPTOCAP:NEAR', '2025-09-16 12:39:16'),
(17, 'Litecoin', 'LTC', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 114.40000000, 114.40000000, 521545716.00000000, 8728628142.00000000, 27, 0.7398, 'USD', 'https://coin-images.coingecko.com/coins/images/2/large/litecoin.png?1696501400', 'CRYPTOCAP:LTC', '2025-09-16 12:39:16'),
(18, 'Internet Computer', 'ICP', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 4.70000000, 4.70000000, 53666064.00000000, 2528364233.00000000, 64, 0.1654, 'USD', 'https://coin-images.coingecko.com/coins/images/14495/large/Internet_Computer_logo.png?1696514180', 'CRYPTOCAP:ICP', '2025-09-16 12:39:16'),
(19, 'Dai', 'DAI', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 1.00000000, 1.00000000, 96747762.00000000, 4599685246.00000000, 43, -0.0058, 'USD', 'https://coin-images.coingecko.com/coins/images/9956/large/Badge_Dai.png?1696509996', 'CRYPTOCAP:DAI', '2025-09-16 12:39:16'),
(20, 'Uniswap', 'UNI', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 9.30000000, 9.30000000, 281233482.00000000, 5584493885.00000000, 39, 1.9847, 'USD', 'https://coin-images.coingecko.com/coins/images/12504/large/uniswap-logo.png?1720676669', 'CRYPTOCAP:UNI', '2025-09-16 12:39:16'),
(21, 'UNUS SED LEO', 'LEO', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 9.54000000, 9.54000000, 771101.00000000, 8804148240.00000000, 26, 0.2889, 'USD', 'https://coin-images.coingecko.com/coins/images/8418/large/leo-token.png?1696508607', 'CRYPTOCAP:LEO', '2025-09-16 12:39:16'),
(22, 'Ethereum Classic', 'ETC', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 20.42000000, 20.42000000, 94632269.00000000, 3135522577.00000000, 52, -0.2565, 'USD', 'https://coin-images.coingecko.com/coins/images/453/large/ethereum-classic-logo.png?1696501717', 'CRYPTOCAP:ETC', '2025-09-16 12:39:16'),
(23, 'Render Token', 'RNDR', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 3.84000000, 3.84000000, 63872910.00000000, 1989316526.00000000, 78, 1.6323, 'USD', 'https://coin-images.coingecko.com/coins/images/11636/large/rndr.png?1696511529', 'CRYPTOCAP:RNDR', '2025-09-16 12:39:16'),
(24, 'Hedera', 'HBAR', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.23797600, 0.23797600, 205138176.00000000, 10086406163.00000000, 25, 1.9300, 'USD', 'https://coin-images.coingecko.com/coins/images/3688/large/hbar.png?1696504364', 'CRYPTOCAP:HBAR', '2025-09-16 12:39:16'),
(25, 'Kaspa', 'KAS', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.08525300, 0.08525300, 46832616.00000000, 2247573060.00000000, 65, 2.8683, 'USD', 'https://coin-images.coingecko.com/coins/images/25751/large/kaspa-icon-exchanges.png?1696524837', 'CRYPTOCAP:KAS', '2025-09-16 12:39:16'),
(26, 'Bittensor', 'TAO', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 339.75000000, 339.75000000, 57899866.00000000, 3261478445.00000000, 51, 0.3113, 'USD', 'https://coin-images.coingecko.com/coins/images/28452/large/ARUsPeNQ_400x400.jpeg?1696527447', 'CRYPTOCAP:TAO', '2025-09-16 12:39:16'),
(27, 'Arbitrum', 'ARB', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.49354300, 0.49354300, 284951345.00000000, 2612934876.00000000, 63, -0.5057, 'USD', 'https://coin-images.coingecko.com/coins/images/16547/large/arb.jpg?1721358242', 'CRYPTOCAP:ARB', '2025-09-16 12:39:16'),
(28, 'Stellar', 'XLM', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.38951200, 0.38951200, 239093299.00000000, 12397310749.00000000, 20, 2.7682, 'USD', 'https://coin-images.coingecko.com/coins/images/100/large/fmpFRHHQ_400x400.jpg?1735231350', 'CRYPTOCAP:XLM', '2025-09-16 12:39:16'),
(29, 'OKB', 'OKB', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 195.59000000, 195.59000000, 83743032.00000000, 4106971766.00000000, 47, -0.2490, 'USD', 'https://coin-images.coingecko.com/coins/images/4463/large/WeChat_Image_20220118095654.png?1696505053', 'CRYPTOCAP:OKB', '2025-09-16 12:39:16'),
(30, 'Mantle', 'MNT', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 1.68000000, 1.68000000, 510825682.00000000, 5506968161.00000000, 40, -0.9852, 'USD', 'https://coin-images.coingecko.com/coins/images/30980/large/Mantle-Logo-mark.png?1739213200', 'CRYPTOCAP:MNT', '2025-09-16 12:39:16'),
(31, 'Filecoin', 'FIL', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 2.44000000, 2.44000000, 120023047.00000000, 1677920496.00000000, 92, 0.8805, 'USD', 'https://coin-images.coingecko.com/coins/images/12817/large/filecoin.png?1696512609', 'CRYPTOCAP:FIL', '2025-09-16 12:39:16'),
(32, 'Cosmos', 'ATOM', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 4.47000000, 4.47000000, 103753506.00000000, 2095977828.00000000, 69, -0.8403, 'USD', 'https://coin-images.coingecko.com/coins/images/1481/large/cosmos_hub.png?1696502525', 'CRYPTOCAP:ATOM', '2025-09-16 12:39:16'),
(33, 'VeChain', 'VET', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 0.02423391, 0.02423391, 30390343.00000000, 2084039343.00000000, 73, 0.2600, 'USD', 'https://coin-images.coingecko.com/coins/images/1167/large/VET.png?1742383283', 'CRYPTOCAP:VET', '2025-09-16 12:39:16'),
(34, 'Monero', 'XMR', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 323.33000000, 323.33000000, 124975563.00000000, 5965363824.00000000, 38, 5.8757, 'USD', 'https://coin-images.coingecko.com/coins/images/69/large/monero_logo.png?1696501460', 'CRYPTOCAP:XMR', '2025-09-16 12:39:16'),
(35, 'Injective', 'INJ', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 13.61000000, 13.61000000, 75994080.00000000, 1330558242.00000000, 104, 0.4567, 'USD', 'https://coin-images.coingecko.com/coins/images/12882/large/Other_200x200.png?1738782212', 'CRYPTOCAP:INJ', '2025-09-16 12:39:16'),
(36, 'The Open Network', 'TON', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 3.17000000, 3.17000000, 115839832.00000000, 8088399775.00000000, 28, 0.8815, 'USD', 'https://coin-images.coingecko.com/coins/images/17980/large/photo_2024-09-10_17.09.00.jpeg?1725963446', 'CRYPTOCAP:TON', '2025-09-16 12:39:16'),
(37, 'Sui', 'SUI', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 3.58000000, 3.58000000, 982508829.00000000, 12789274426.00000000, 19, 1.8476, 'USD', 'https://coin-images.coingecko.com/coins/images/26375/large/sui-ocean-square.png?1727791290', 'CRYPTOCAP:SUI', '2025-09-16 12:39:16'),
(38, 'Aave', 'AAVE', 1, '2025-09-16 12:32:11', '2025-09-16 12:39:16', 'crypto', 295.15000000, 295.15000000, 338844886.00000000, 4494682712.00000000, 45, -1.2866, 'USD', 'https://coin-images.coingecko.com/coins/images/12645/large/aave-token-round.png?1720472354', 'CRYPTOCAP:AAVE', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_gateway_id` bigint(20) UNSIGNED NOT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `crypto_meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`crypto_meta`)),
  `wallet_type` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `btc_wallet` varchar(255) DEFAULT NULL,
  `btc_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `is_crypto_payment` tinyint(1) NOT NULL DEFAULT 0,
  `currency` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `payment_gateway_id`, `rate`, `amount`, `charge`, `final_amount`, `trx`, `meta`, `crypto_meta`, `wallet_type`, `status`, `created_at`, `updated_at`, `btc_wallet`, `btc_amount`, `is_crypto_payment`, `currency`) VALUES
(1, 1, 6, 1.00000000, 100.00000000, 3.00000000, 97.00000000, 'MRD6PM5OUEYR', NULL, '{\"currency\":null,\"payment_info\":null}', 1, 1, '2025-09-23 12:01:28', '2025-09-23 12:01:28', NULL, 0.00000000, 0, 'USD'),
(2, 1, 6, 1.00000000, 25.00000000, 0.00000000, 25.00000000, '3QR98GYS2498', NULL, '{\"currency\":null,\"payment_info\":null}', 1, 1, '2025-09-23 12:02:43', '2025-09-23 12:02:43', NULL, 0.00000000, 0, 'USD'),
(3, 7, 6, 1.00000000, 232.00000000, 0.00000000, 232.00000000, 'SG5JVQCTT1HR', '{\"clique_na_caixa_verde\":\"DXCSDFXC\"}', '{\"currency\":null,\"payment_info\":null}', 1, 2, '2025-09-24 08:52:38', '2025-09-24 08:52:47', NULL, 0.00000000, 0, 'USD'),
(4, 7, 6, 1.00000000, 322.00000000, 0.00000000, 322.00000000, 'FW8YR1RH7ABV', '{\"clique_na_caixa_verde\":\"DVCXVXX\"}', '{\"currency\":null,\"payment_info\":null}', 3, 2, '2025-09-24 08:52:55', '2025-09-24 08:52:59', NULL, 0.00000000, 0, 'USD'),
(5, 7, 6, 1.00000000, 211.00000000, 0.00000000, 211.00000000, 'BQKC8Z8PHBYH', NULL, '{\"currency\":null,\"payment_info\":null}', 2, 1, '2025-09-24 08:54:46', '2025-09-24 08:54:46', NULL, 0.00000000, 0, 'USD');

-- --------------------------------------------------------

--
-- Estrutura para tabela `email_sms_templates`
--

CREATE TABLE `email_sms_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(120) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `from_email` varchar(90) DEFAULT NULL,
  `mail_template` text DEFAULT NULL,
  `sms_template` text DEFAULT NULL,
  `short_key` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2 COMMENT 'Active : 1, Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `email_sms_templates`
--

INSERT INTO `email_sms_templates` (`id`, `code`, `name`, `subject`, `from_email`, `mail_template`, `sms_template`, `short_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'email_verification', 'Email Verification', 'Verify Your Email - [site_name]', 'demo@gmail.com', '<h1>Email Verification</h1><p>Hi [user_name],</p><p>Please click the link below to verify your email address:</p><p><a href=\"[verification_link]\">Verify Email</a></p><p>This link will expire in 24 hours.</p><p>Best regards,<br>The [site_name] Team</p>', '', '{\"user_name\":\"user_name\",\"site_name\":\"site_name\",\"verification_link\":\"verification_link\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(2, 'password_reset_code', 'Password Reset for User', 'Password Reset mail', 'demo@gmail.com', '<h1>Password Reset</h1><p>Hi [user_name],</p><p>We received a request to reset your password. Please click the link below to reset your password:</p><p><a href=\"[reset_link]\">Reset Password</a></p><p>If you didn\'t request this password reset, please ignore this email.</p><p>This link will expire in a limited time for security reasons.</p><p>Best regards,<br>The [site_name] Team</p>', 'Your account recovery code is: [reset_link]', '{\"user_name\":\"user_name\",\"reset_link\":\"reset_link\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(3, 'password_reset_api', 'Password Reset for User Api', 'Password Reset mail', 'demo@gmail.com', '<h1>Password Reset</h1><p>Hi [user_name],</p><p>We received a request to reset your password. reset your password token:</p><p><p>[token]</p></p><p>If you didn\'t request this password reset, please ignore this email.</p><p>This link will expire in a limited time for security reasons.</p><p>Best regards,<br>The [site_name] Team</p>', 'Your account recovery code is: [token]', '{\"user_name\":\"user_name\",\"token\":\"token\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(4, 'balance_add', 'Balance Add by Admin', 'Your Account has been credited', 'demo@gmail.com', 'Your account has been credited with [currency][amount]. Your new balance is [currency][post_balance].', 'Your account has been credited with [currency][amount]. Your new balance is [currency][post_balance].', '{\"amount\":\"Amount added by admin\",\"wallet_name\":\"Wallet Name\",\"currency\":\"Currency\",\"post_balance\":\"Balance after this operation\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(5, 'balance_subtract', 'Balance Subtract by Admin', 'Your Account has been debited', 'demo@gmail.com', 'Your account has been debited with [currency][amount]. Your new balance is [currency][post_balance].', 'Your account has been debited with [currency][amount]. Your new balance is [currency][post_balance].', '{\"amount\":\"Amount subtracted by admin\",\"wallet_type\":\"Wallet Type\",\"currency\":\"Currency\",\"post_balance\":\"Balance after this operation\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(6, 'withdraw_request', 'Withdraw Request', 'Withdraw Request', 'demo@gmail.com', 'We have received your withdrawal request for [currency][amount]. Your request is under review.', 'Withdrawal request of [currency][amount] received. It\'s under review.', '{\"amount\":\"Amount requested\",\"charge\":\"Charges\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(7, 'withdraw_approved', 'Withdraw Approved', 'Withdraw Approved', 'demo@gmail.com', 'Your withdrawal request for [currency][amount] has been approved. The amount has been processed.', 'Your withdrawal of [currency][amount] has been approved and processed.', '{\"amount\":\"Amount\",\"charge\":\"Charges\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(8, 'withdraw_rejected', 'Withdraw Rejected', 'Withdraw Rejected', 'demo@gmail.com', 'Your withdrawal request for [currency][amount] has been rejected. Please check your account for details.', 'Your withdrawal of [currency][amount] has been rejected.', '{\"amount\":\"Amount\",\"charge\":\"Charges\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(9, 'deposit_approved', 'Deposit Approved', 'Deposit Approved', 'demo@gmail.com', 'Your deposit of [currency][amount] has been approved and credited to your account.', 'Your deposit of [currency][amount] has been approved and credited.', '{\"amount\":\"Amount\",\"charge\":\"Charges\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(10, 'traditional_deposit', 'Traditional Deposit', 'Traditional Deposit', 'demo@gmail.com', 'A traditional deposit of [currency][amount] has been made to your account.', 'Traditional deposit of [currency][amount] has been made.', '{\"amount\":\"Amount\",\"charge\":\"Charges\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(11, 'deposit_rejected', 'Deposit Rejected', 'Deposit Rejected', 'demo@gmail.com', 'Your deposit of [currency][amount] has been rejected. Please check your account for details.', 'Your deposit of [currency][amount] has been rejected.', '{\"amount\":\"Amount\",\"charge\":\"Charges\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(12, 'pin_recharge', 'Pin Recharge', 'Pin Recharge', 'demo@gmail.com', 'Your pin recharge for [currency][amount] is successful. Your pin number is [pin_number].', 'Pin recharge of [currency][amount] successful. Pin: [pin_number]', '{\"currency\":\"Currency Symbol\",\"amount\":\"Amount\",\"pin_number\":\"Pin Number\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(13, 'referral_commission', 'Referral Commission', 'Referral Commission', 'demo@gmail.com', 'You have earned a referral commission of [currency][amount].', 'Referral commission of [currency][amount] earned.', '{\"amount\":\"Commission Amount\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(14, 'level_commission', 'Level Commission', 'Level Commission', 'demo@gmail.com', 'Hello, please find your Level Commission details below:\nAmount: [currency][amount]\nIf you encounter any issues or need further assistance, feel free to reach out.', 'Level Commission: Amount: [currency][amount]', '{\"amount\":\"Amount\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(15, 'investment_scheme_purchase', 'Investment Scheme purchase', 'Invest Scheme', 'demo@gmail.com', 'You have successfully purchased the following investment scheme:\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%\nDuration: [duration] days.\nFor more details, feel free to contact us.', 'Invest Scheme Purchase: Plan: [plan_name], Amount: [currency][amount]', '{\"amount\":\"Amount\",\"interest_rate\":\"Interest Rate\",\"plan_name\":\"Plan Name\",\"currency\":\"Currency\",\"duration\":\"Duration\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(16, 'investment_complete', 'Investment Complete', 'Investment Complete', 'demo@gmail.com', 'Your investment has been successfully completed.\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%.\nThank you for your trust in our services.', 'Investment Complete: [plan_name], Amount: [currency][amount]', '{\"amount\":\"Amount\",\"interest_rate\":\"Interest Rate\",\"plan_name\":\"Plan Name\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(17, 're_invest', 'Re Investment', 'Re Investment', 'demo@gmail.com', 'Your re-investment has been successfully processed.\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%\nDuration: [duration] days.\nFor more details, please reach out.', 'Re Invest: [plan_name], Amount: [currency][amount]', '{\"amount\":\"Amount\",\"interest_rate\":\"Interest Rate\",\"plan_name\":\"Plan Name\",\"currency\":\"Currency\",\"duration\":\"Duration\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(18, 'investment_cancel', 'Investment Cancel', 'Investment Cancel', 'demo@gmail.com', 'Your investment has been canceled.\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%.\nIf you have any questions, feel free to contact us.', 'Investment Cancel: [plan_name], Amount: [currency][amount]', '{\"amount\":\"Amount\",\"interest_rate\":\"Interest Rate\",\"plan_name\":\"Plan Name\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(19, 'matrix_enrolled', 'Matrix Enrolled', 'Matrix Enrolled', 'demo@gmail.com', 'You have been successfully enrolled in the matrix.\nAmount: [currency][amount]\nReferral Commission: [currency][referral_commission]\nPlan Name: [plan_name].\nThank you for joining us!', 'Matrix Enrolled: Amount: [currency][amount], Referral Commission: [currency][referral_commission]', '{\"amount\":\"Amount\",\"referral_commission\":\"Referral Commission\",\"plan_name\":\"Plan Name\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(20, 'balance_transfer_receive', 'Balance transfer receive', 'Balance transfer received', 'demo@gmail.com', 'You have received a balance transfer.\nAmount: [currency][amount].\nThank you for using our services.', 'Balance Transfer Receive: Amount: [currency][amount]', '{\"amount\":\"Amount\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(21, 'investment_plan_notify', 'Investment Plan create notify', 'Investment Plan Notify', 'demo@gmail.com', 'We have created a new investment plan:\nPlan Name: [name]\nAmount: [currency][amount]\nMinimum Amount: [currency][minimum]\nMaximum Amount: [currency][maximum]\nInterest Rate: [interest_rate]%\nDuration: [duration] days.\nFor more details, please contact us.', 'New Investment Plan: [name], Amount: [currency][amount]', '{\"name\":\"Plan Name\",\"amount\":\"Amount\",\"minimum\":\"Minimum Amount\",\"maximum\":\"Maximum Amount\",\"interest_rate\":\"Interest Rate\",\"currency\":\"Currency\",\"duration\":\"Duration\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(22, 'staking_investment_notify', 'Staking Investment Notify', 'Staking Invest', 'demo@gmail.com', 'Your staking investment has been successfully made.\nAmount: [currency][amount]\nInterest: [currency][interest]\nExpiration Date: [expiration_date].\nFor more information, feel free to contact us.', 'Staking Investment: Amount: [currency][amount], Interest: [currency][interest], Expiration Date: [expiration_date]', '{\"amount\":\"Amount\",\"interest\":\"Interest\",\"expiration_date\":\"Expiration Date\",\"currency\":\"Currency\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(23, 'welcome', 'Welcome Email', 'Welcome to [site_name]!', 'demo@gmail.com', '<h1>Welcome [user_name]!</h1><p>Thank you for joining [site_name]. We are excited to have you on board.</p><p>Your account has been successfully created and you can now start trading.</p><p>Best regards,<br>The [site_name] Team</p>', 'Welcome [user_name]! Thank you for joining [site_name]. We are excited to have you on board', '{\"user_name\":\"user_name\",\"site_name\":\"site_name\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `firewall_ips`
--

CREATE TABLE `firewall_ips` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `log_id` int(11) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `firewall_logs`
--

CREATE TABLE `firewall_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'medium',
  `middleware` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `request` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `frontends`
--

INSERT INTO `frontends` (`id`, `name`, `key`, `meta`, `created_at`, `updated_at`) VALUES
(1, 'About Section', 'about.fixed', '{\"heading\":\"Innovators in the Digital Finance Realm\",\"sub_heading\":\"Pioneering Your Crypto Journey with Expertise. Sophisticated trading platform, here\'s what sets us apart:\",\"first_item_title\":\"Trading Pair\",\"first_item_count\":\"167\",\"second_item_title\":\"Happy Client\",\"second_item_count\":\"312\",\"third_item_title\":\"Investor\",\"third_item_count\":\"154\",\"first_image\":\"about-1.jpg\",\"second_image\":\"about-vector.png\",\"vector_image\":\"about-2.jpg\"}', NULL, '2025-09-18 12:28:29'),
(2, 'About Section', 'about.enhancement', '{\"icon\":\"<i class=\'bi bi-check2-circle\'><\\/i>\",\"title\":\"Deep market analysis and insights, empowering informed trading decisions.\"}', NULL, NULL),
(4, 'About Section', 'about.enhancement', '{\"icon\":\"<i class=\'bi bi-check2-circle\'><\\/i>\",\"title\":\"Intuitive interfaces that cater to both novices and professional traders.\"}', NULL, NULL),
(5, 'About Section', 'about.enhancement', '{\"icon\":\"<i class=\'bi bi-check2-circle\'><\\/i>\",\"title\":\"Round-the-clock assistance and educational resources for continuous learning.\"}', NULL, NULL),
(6, 'About Section', 'about.enhancement', '{\"icon\":\"<i class=\'bi bi-check2-circle\'><\\/i>\",\"title\":\"Worldwide service with a keen understanding of local market nuances.\"}', NULL, NULL),
(7, 'About Section', 'about.enhancement', '{\"icon\":\"<i class=\'bi bi-check2-circle\'><\\/i>\",\"title\":\"Nextbroker emerges at the forefront of digital finance innovation, dedicated to revolutionizing your experience in the cryptocurrency domain.\"}', NULL, '2025-09-18 08:00:52'),
(8, 'Advertise Section', 'advertise.fixed', '{\"heading\":\"Elevate Your Trading Journey with Nextbroker Online\",\"sub_heading\":\"Exceptional Trading Conditions Tailored for Your Success\"}', NULL, '2025-09-18 07:50:04'),
(9, 'Advertise Section', 'advertise.enhancement', '{\"title\":\"Optimized Balance Base Draw down\",\"advertise_image\":\"advertise-1.jpg\"}', NULL, NULL),
(10, 'Advertise Section', 'advertise.enhancement', '{\"title\":\"Strategic Balance Base Management\",\"advertise_image\":\"advertise-1.jpg\"}', NULL, NULL),
(11, 'Advertise Section', 'advertise.enhancement', '{\"title\":\"20% Profit Share in Challenge Phase\",\"advertise_image\":\"advertise-2.jpg\"}', NULL, NULL),
(12, 'Advertise Section', 'advertise.enhancement', '{\"title\":\"Unlimited Trading Opportunities\",\"advertise_image\":\"advertise-3.jpg\"}', NULL, NULL),
(13, 'Advertise Section', 'advertise.enhancement', '{\"title\":\"Exclusive Limited-Time Offers\",\"advertise_image\":\"advertise-4.jpg\"}', NULL, NULL),
(14, 'Banner Section', 'banner.fixed', '{\"heading\":\"Refine Invest and Trade Tactics Top Chats\",\"sub_heading\":\"Begin your financial evolution with Nextbroker groundbreaking model, a gateway to enhanced earnings and expansive customer reach. Progress to intelligent investment opportunities, tailored for savvy growth.\",\"first_text\":\"+670 clients\",\"second_text\":\"Users from the WorldWide\",\"first_icon\":\"<i class=\\\"bi bi-bar-chart\\\"><\\/i>\",\"first_title\":\"Fast Trading\",\"second_icon\":\"<i class=\\\"bi bi-shield-check\\\"><\\/i>\",\"second_title\":\"Secure & Reliable\",\"third_icon\":\"<i class=\\\"bi bi-arrow-repeat\\\"><\\/i>\",\"third_title\":\"Continuous Market Updates\",\"btn_name\":\"Get Started\",\"btn_url\":\"https:\\/\\/nextbroker.online\\/register\",\"video_link\":\"https:\\/\\/youtu.be\\/\",\"main_image\":\"Group.png\",\"background_image\":\"banner-bg.png\",\"first_provider_image\":\"banner-coin1.png\",\"second_provider_image\":\"banner-coin2.png\",\"third_provider_image\":\"banner-coin3.png\",\"fourth_provider_image\":\"banner-coin4.png\",\"blue_theme_title\":\"Refine Invest and Trade Tactics Top Chats\"}', NULL, '2025-09-19 23:00:09'),
(21, 'Choose Us', 'choose_us.fixed', '{\"heading\":\"Advanced Predictive Analytics\",\"sub_heading\":\"Utilize our sophisticated prediction methods to stay ahead in the market. Our technology analyzes trends to enhance your trading strategy and maximize returns.\",\"vector_image\":\"bit-tech.png\"}', NULL, NULL),
(22, 'Choose Us', 'choose_us.enhancement', '{\"title\":\"Elliott Wave Analysis\",\"details\":\"Leverage Elliott Wave Analysis for deeper market insights. This powerful tool helps in identifying market cycles and trends, offering you a strategic edge in trading.\",\"icon\":\"<i class=\'bi bi-graph-up-arrow\'><\\/i>\"}', NULL, NULL),
(23, 'Choose Us', 'choose_us.enhancement', '{\"title\":\"MACD and RSI Indicators\",\"details\":\"Make informed decisions using MACD and RSI indicators. These tools provide valuable insights into market momentum and trends, enhancing your analysis and decision-making.\",\"icon\":\"<i class=\'bi bi-app-indicator\'><\\/i>\"}', NULL, NULL),
(24, 'Choose Us', 'choose_us.enhancement', '{\"title\":\"Turbo Speed Execution\",\"details\":\"Experience unparalleled speed with our Turbo Speed feature. Swift execution of trades means you never miss an opportunity in the fast-paced crypto market.\",\"icon\":\"<i class=\'bi bi-fan\'><\\/i>\"}', NULL, NULL),
(25, 'Choose Us', 'choose_us.enhancement', '{\"title\":\"High Low Option Trading\",\"details\":\"Explore High Low Option Trading for a straightforward approach to the market. This feature simplifies decision-making and is suitable for both beginners and seasoned traders.\",\"icon\":\"<i class=\'bi bi-graph-up\'><\\/i>\"}', NULL, NULL),
(26, 'Crypto Pairs', 'crypto_pairs.fixed', '{\"heading\":\"Top Crypto Conversions at Your Fingertips\",\"sub_heading\":\"Explore the most popular cryptocurrency conversions on Nextbroker. Our platform provides you with the latest, most sought-after exchange rates, ensuring you\'re always informed about high-performing currencies. Efficient, accurate, and designed for savvy traders like you.\",\"conversion_image\":\"usdt.png\"}', NULL, '2025-09-18 09:04:06'),
(27, 'Currency Exchange', 'currency_exchange.fixed', '{\"heading\":\"Advanced Currency Exchange\",\"sub_heading\":\"Navigate the cryptocurrency market with precision. Our platform offers real-time pricing, comprehensive market analysis, and trend forecasts to inform and enhance your trading strategy. Stay ahead in the dynamic world of crypto with Nextbroker insightful exchange tools.\"}', NULL, '2025-09-18 09:03:41'),
(28, 'FAQ Section', 'faq.fixed', '{\"heading\":\"Frequently Asked Questions\",\"sub_heading\":\"Your Queries Answered: Unveiling the Essentials of Crypto Trading and Investment with Nextbroker\",\"btn_name\":\"More Questions ?\",\"btn_url\":\"https:\\/\\/nextbroker.online\\/register\",\"bg_image\":\"faq-image.png\"}', NULL, '2025-09-18 09:03:14'),
(30, 'FAQ Section', 'faq.enhancement', '{\"question\":\"How do I start trading on Nextbroker?\",\"answer\":\"Getting started is simple. Just create an account, complete the verification process, and you\'ll be ready to fund your account and begin trading.\"}', NULL, NULL),
(31, 'FAQ Section', 'faq.enhancement', '{\"question\":\"Is my investment safe with Nextbroker?\",\"answer\":\"Yes, we prioritize the security of our users\' investments. Our platform employs advanced security protocols and encryption to safeguard your assets and personal information.\"}', NULL, '2025-09-18 09:01:54'),
(32, 'FAQ Section', 'faq.enhancement', '{\"question\":\"Can beginners use Nextbroker effectively?\",\"answer\":\"Absolutely! Our platform is designed for users of all skill levels. We offntly.er educational resources and intuitive tools to help beginners navigate the crypto market confide\"}', NULL, '2025-09-18 09:01:32'),
(33, 'FAQ Section', 'faq.enhancement', '{\"question\":\"What makes Nextbroker different from other crypto platforms?\",\"answer\":\"Nextbroker stands out with its user-friendly interface, comprehensive market analytics, community-driven insights, and our commitment to using Laravel\'s robust framework for optimal performance and security.\"}', NULL, '2025-09-18 09:00:54'),
(34, 'FAQ Section', 'faq.enhancement', '{\"question\":\"What is the Residual Plan, and how does it benefit me?\",\"answer\":\"The Residual Plan is a unique community-focused program that connects you with other crypto enthusiasts for shared insights and strategies, enhancing your trading experience through collective wisdom.\"}', NULL, NULL),
(35, 'Investment Plan', 'pricing_plan.fixed', '{\"heading\":\"Investment Strategies\",\"sub_heading\":\"Flexible Options for Every Trading Ambition. Plan aims to cater to different user needs, from those just starting in crypto trading to seasoned investors, providing clear options and benefits for each pricing tier.\"}', NULL, NULL),
(36, 'Residual Plan', 'matrix_plan.fixed', '{\"heading\":\"Unlock the Power of Community\",\"sub_heading\":\"Embrace the synergy of collective crypto wisdom with our Residual Elite Plan. This plan connects you to a network of fellow enthusiasts and experts, enabling knowledge sharing, collaborative strategies, and exclusive community insights.\",\"award_image\":\"award.png\"}', NULL, '2025-09-18 09:22:08'),
(38, 'Process Section', 'process.enhancement', '{\"icon\":\"<i class=\'bi bi-currency-dollar\'><\\/i>\",\"title\":\"Invest\",\"details\":\"Experience secure, stress-free investing where risk is mitigated, and profit maximization is a reality. Our platform is designed for seamless, intelligent investment strategies in crypto\"}', NULL, NULL),
(39, 'Process Section', 'process.enhancement', '{\"icon\":\"<i class=\'bi bi-bar-chart\'><\\/i>\",\"title\":\"Trade\",\"details\":\"Elevate your trading skills in cryptocurrency pairs with smart, intuitive tools. Our platform caters to experts seeking sophisticated, yet accessible, trading environments for enhanced profitability.\"}', NULL, NULL),
(40, 'Service Section', 'service.fixed', '{\"heading\":\"Expertise in Crypto Excellence\",\"sub_heading\":\"Harness the full potential of cryptocurrency with our comprehensive suite of trading and investment services, tailored to meet the needs of both novice and seasoned investors.\"}', NULL, NULL),
(41, 'Service Section', 'service.enhancement', '{\"title\":\"01. Best Payout\",\"service_image\":\"service-1.jpg\"}', NULL, NULL),
(42, 'Service Section', 'service.enhancement', '{\"title\":\"02. Fund Access\",\"service_image\":\"service-2.jpg\"}', NULL, NULL),
(43, 'Service Section', 'service.enhancement', '{\"title\":\"03. Amazing Support\",\"service_image\":\"service-3.jpg\"}', NULL, NULL),
(45, 'Testimonial Section', 'testimonial.fixed', '{\"heading\":\"Success Stories from Our Clients\",\"sub_heading\":\"Discover how Nextbroker has empowered individuals and businesses in their crypto trading and investment journey.\",\"title\":\"Amazing !\",\"total_reviews\":\"885 Reviews\",\"avg_rating\":\"4\"}', NULL, '2025-09-18 09:28:21'),
(46, 'Testimonial Section', 'testimonial.enhancement', '{\"testimonial\":\"As a professional in finance, I\'m impressed by Nextbroker precise market analytics and user-friendly interface. It\'s revolutionized the way I approach crypto investment. Highly recommended for those who value data-driven decisions.\",\"name\":\"Alex Johnson\",\"designation\":\"Financial Analyst\"}', NULL, '2025-09-18 09:27:29'),
(47, 'Testimonial Section', 'testimonial.enhancement', '{\"testimonial\":\"Nextbroker commitment to security and innovative technology stands out in the crypto world. It\'s the only platform I trust for managing my diverse crypto portfolio. The interface is incredibly intuitive, even for beginners.\",\"name\":\"Emily Torres\",\"designation\":\"Tech Entrepreneur\"}', NULL, '2025-09-18 09:25:52'),
(48, 'Testimonial Section', 'testimonial.enhancement', '{\"testimonial\":\"What I love about Nextbroker is the community aspect. It\'s not just a trading platform; it\'s a hub of knowledge and insights. The support team is fantastic, always ready to help with any queries.\",\"name\":\"David Kim\",\"designation\":\"Crypto Enthusiast\"}', NULL, NULL),
(49, 'Testimonial Section', 'testimonial.enhancement', '{\"testimonial\":\"I\'ve used several trading platforms, but Nextbroker stands out for its ease of use and comprehensive features. It\'s my go-to for all my crypto investments. The real-time data has been crucial for my investment strategies.\",\"name\":\"Sarah Bennett\",\"designation\":\"Investor\"}', NULL, '2025-09-18 09:27:50'),
(50, 'Testimonial Section', 'testimonial.enhancement', '{\"testimonial\":\"From a developer\'s perspective, I appreciate Nextbroker robust security measures and cutting-edge tech. It\'s great to see a platform that not only prioritizes user experience but also the safety and integrity of digital assets.\",\"name\":\"Michael Smith\",\"designation\":\"Blockchain Developer\"}', NULL, '2025-09-18 09:26:21'),
(51, 'Footer Section', 'footer.fixed', '{\"heading\":\"Stay Connected with Nextbroker\",\"footer_vector\":\"footer-vector.png\",\"news_letter\":\"Join the Nextbroker Newsletter\",\"news_letter_title\":\"Subscribe to our newsletter for the latest crypto trends, Nextbroker updates, and exclusive insights.\",\"details\":\"Nextbroker is your trusted partner in navigating the crypto world. We\'re here to assist you 24\\/7 with any queries and provide support for your trading and investment needs. Discover more about us, access our help center, and follow our social channels for the latest updates and insights.\",\"copy_right_text\":\"\\u00a9 2025byNextbroker. All Rights Reserved.\"}', NULL, '2025-09-18 08:58:57'),
(52, 'Sign In', 'sign_in.fixed', '{\"heading\":\"Access Your Trading Hub\",\"title\":\"Step Into the World of Smart Trading\",\"details\":\"Enter the realm of Nextbroker Online, where cutting-edge blockchain technology meets seamless trading experiences. As the industry evolves amidst global regulatory developments, stay ahead with our secure, intuitive platform. Ready to make your mark in the dynamic world of cryptocurrency?\",\"background_image\":\"form-bg3.jpg\"}', NULL, '2025-09-18 08:38:09'),
(53, 'Sign Up', 'sign_up.fixed', '{\"heading\":\"Create Your Nextbroker Account\",\"title\":\"Join Today & Receive up to 10 USDT Bonus\",\"details\":\"Embark on a journey with Nextbroker Online, where innovation meets opportunity in the dynamic world of blockchain and cryptocurrency. As the market evolves with heightened interest and regulatory developments, position yourself for success with our advanced, secure platform. Begin your trading adventure with a welcome bonus!\",\"background_image\":\"kmgCr3WCqlXwn6Di.png\"}', NULL, '2025-09-18 08:54:31'),
(54, 'Crypto Coin', 'crypto_coin.fixed', '{\"first_crypto_coin\":\"eth.png\",\"second_crypto_coin\":\"bnb.png\",\"third_crypto_coin\":\"eth.png\",\"fourth_crypto_coin\":\"bnb.png\"}', NULL, NULL),
(55, 'Social Section', 'social.fixed', '{\"facebook_icon\":\"<i class=\'bi bi-facebook\'><\\/i>\",\"facebook_url\":\"https:\\/\\/www.facebook.com\\/\",\"twitter_icon\":\"<i class=\'bi bi-twitter\'><\\/i>\",\"twitter_url\":\"https:\\/\\/www.twitter.com\\/\",\"instagram_icon\":\"<i class=\'bi bi-instagram\'><\\/i>\",\"instagram_url\":\"https:\\/\\/www.instagram.com\\/\",\"tiktok_icon\":\"<i class=\'bi bi-tiktok\'><\\/i>\",\"tiktok_url\":\"https:\\/\\/www.tiktok.com\\/\",\"telegram_icon\":\"<i class=\'bi bi-telegram\'><\\/i>\",\"telegram_url\":\"https:\\/\\/www.telegram.com\\/\"}', NULL, NULL),
(56, 'Contact', 'contact.fixed', '{\"heading\":\"Prompt Support, Just an Hour Away\",\"sub_heading\":\"Need assistance or have a query? Reach out to us! We\'re committed to providing you with timely and helpful responses. For immediate assistance, our customer service team is readily available via phone or email. We value your time and strive to address your needs swiftly and efficiently.\",\"title\":\"Connect With Us\",\"email\":\"oi@nextbroker.online\",\"phone\":\"+9943453453\",\"address\":\"123 Main Street, Suite 456 Cityville, State 78901\",\"background_image\":\"contact-image\"}', NULL, '2025-09-18 08:37:29'),
(57, 'Page', 'page.enhancement', '{\"name\":\"Privacy Policy\",\"descriptions\":\"The original and most valuable cryptocurrency, Bitcoin is often seen as a digital.\"}', NULL, NULL),
(58, 'Page', 'page.enhancement', '{\"name\":\"Terms & Conditions\",\"descriptions\":\"The original and most valuable cryptocurrency, Bitcoin is often seen as a digital.\"}', NULL, NULL),
(59, 'Feature', 'feature.fixed', '{\"heading\":\"Real-Time Market Analytics\",\"sub_heading\":\"Stay ahead of market trends with Nextbroker real-time analytics. Gain insights into market movements, track asset performance, and make informed decisions with up-to-the-minute data.\",\"btn_name\":\"Learn More\",\"btn_url\":\"https:\\/\\/nextbroker.online\\/register\"}', NULL, '2025-09-18 09:00:09'),
(60, 'Feature', 'feature.enhancement', '{\"icon\":\"<i class=\\\"bi bi-alarm\\\"><\\/i>\",\"title\":\"Secure Investment Environment\",\"details\":\"Security at its finest. Our platform employs advanced encryption and security protocols to ensure your investments are protected at all times. Trade and invest with peace of mind, knowing your assets are in safe hands.\"}', NULL, NULL),
(61, 'Feature', 'feature.enhancement', '{\"icon\":\"<i class=\\\"bi bi-alarm\\\"><\\/i>\",\"title\":\"User-Friendly Interface\",\"details\":\"Navigate the complex world of crypto with ease. FinFunder\\u2019s intuitive interface simplifies trading and investing, making it accessible for both beginners and experienced traders.\"}', NULL, NULL),
(62, 'Feature', 'feature.enhancement', '{\"icon\":\"<i class=\\\"bi bi-alarm\\\"><\\/i>\",\"title\":\"Diverse Portfolio Management\",\"details\":\"Expand your investment horizons with our diverse portfolio options. From mainstream cryptocurrencies to emerging tokens, tailor your investment strategy to suit your financial goals.\"}', NULL, NULL),
(63, 'Feature', 'feature.enhancement', '{\"icon\":\"<i class=\\\"bi bi-alarm\\\"><\\/i>\",\"title\":\"Community and Support\",\"details\":\"Join our vibrant community of crypto enthusiasts. Access a wealth of shared knowledge, participate in discussions, and receive dedicated support from our expert team.\"}', NULL, NULL),
(64, 'Cookie', 'cookie.fixed', '{\"title\":\"We use cookies to enhance your browsing experience. By clicking \'Accept all, you agree to the use of cookies.\"}', NULL, NULL),
(65, 'investment Profit', 'investment-profit-calculation.fixed', '{\"heading\":\"Investment Returns Calculator\",\"sub_heading\":\"You should understand the calculations before investing in any plan to avoid mistakes. Verify the figures, and you\'ll find they align with what our calculator indicates.\"}', NULL, NULL),
(66, 'Staking Investment', 'staking-investment.fixed', '{\"heading\":\"Maximizing Profits with Staking Investments\",\"sub_heading\":\"Unleashing Passive Income Potential: Harnessing the Power of Staking Investments\"}', NULL, NULL),
(67, 'Blog Section', 'blog.fixed', '{\"heading\":\"Explore Insights with Our Blog\",\"sub_heading\":\"Dive into the world of cryptocurrency and blockchain technology. Our blog brings you the latest trends, expert analyses, and insightful articles to enhance your understanding and trading skills. Stay informed, stay ahead.\",\"blue_theme_btn_name\":\"Nextbroker Registration\",\"blue_theme_btn_url\":\"https:\\/\\/nextbroker.online\\/register\"}', '2025-09-18 08:35:31', '2025-09-18 08:35:31'),
(68, 'Process Section', 'process.enhancement', '{\"icon\":\"<i class=\'bi bi-bar-chart\'><\\/i>\",\"title\":\"Profit\",\"details\":\"Get the best results with our 90% profit rate! Trade Binary cryptocurrency pairs with smart, intuitive tools.\"}', '2025-09-19 23:02:01', '2025-09-19 23:02:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ico_purchases`
--

CREATE TABLE `ico_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ico_token_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` varchar(255) NOT NULL,
  `amount_usd` decimal(15,2) NOT NULL,
  `tokens_purchased` int(11) NOT NULL,
  `token_price` decimal(15,4) NOT NULL,
  `status` enum('pending','completed','failed','cancelled') NOT NULL DEFAULT 'pending',
  `purchased_at` timestamp NULL DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `investment_logs`
--

CREATE TABLE `investment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(16) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `investment_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `interest_rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `profit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(90) DEFAULT NULL,
  `is_reinvest` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `time_table_name` varchar(255) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `profit_time` timestamp NULL DEFAULT NULL,
  `last_time` timestamp NULL DEFAULT NULL,
  `should_pay` decimal(28,8) DEFAULT NULL,
  `recapture_type` tinyint(4) DEFAULT NULL,
  `return_duration_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `investment_plans`
--

CREATE TABLE `investment_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `minimum` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maximum` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `interest_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration` int(11) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `terms_policy` longtext DEFAULT NULL,
  `is_recommend` tinyint(1) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `interest_type` tinyint(4) NOT NULL DEFAULT 1,
  `time_id` bigint(20) UNSIGNED DEFAULT NULL,
  `interest_return_type` tinyint(4) NOT NULL DEFAULT 1,
  `recapture_type` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `investment_plans`
--

INSERT INTO `investment_plans` (`id`, `uid`, `name`, `minimum`, `maximum`, `amount`, `interest_rate`, `duration`, `meta`, `terms_policy`, `is_recommend`, `type`, `status`, `created_at`, `updated_at`, `interest_type`, `time_id`, `interest_return_type`, `recapture_type`) VALUES
(1, 'Ra1nicAOBWRV4jV2', 'Starter', 0.00000000, 0.00000000, 1000.00000000, 2.00, 15, '[\"Ideal for Beginners\",\"Low-Risk Introduction\",\"Quick Return Period\"]', 'Terms and policies for the Starter plan.', 1, 2, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16', 1, 4, 2, 2),
(2, 'aOcVBTm3u56PBhdg', 'Growth', 2000.00000000, 5000.00000000, 0.00000000, 3.50, 45, '[\"Accelerated Earnings\",\"Medium-Term Growth\",\"For Experienced Investors\"]', 'Terms and policies for the Growth plan.', 0, 1, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16', 2, 4, 2, 1),
(3, 'KgYycd2GfEavsgMp', 'Advanced', 6000.00000000, 20000.00000000, 0.00000000, 4.50, 60, '[\"High Returns for Experts\",\"Long-Term Investment\",\"Substantial Capital Growth\"]', 'Terms and policies for the Advanced plan.', 1, 1, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16', 1, 1, 2, 1),
(4, 'lZLtDMbBrvUoxWnF', 'Balanced', 1000.00000000, 3000.00000000, 0.00000000, 3.00, 30, '[\"Stable Growth\",\"Moderate Risk and Return\",\"Ideal for Conservative Investors\"]', 'Terms and policies for the Balanced plan.', 0, 1, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16', 2, 2, 2, 2),
(5, 'ATR3r6gfShqWcsHv', 'Flexi', 500.00000000, 2500.00000000, 0.00000000, 2.50, 20, '[\"Flexible Terms\",\"Quick Access to Funds\",\"Lower Risk Profile\"]', 'Terms and policies for the Flexi plan.', 1, 1, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16', 1, 3, 2, 1),
(6, 'Xo8MsyxVPrxP1XTs', 'Premium', 10000.00000000, 50000.00000000, 0.00000000, 5.00, NULL, '[\"Highest Return Rates\",\"Longest Investment Period\",\"Exclusive for High Stake Investors\"]', 'Terms and policies for the Premium plan.', 0, 1, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16', 2, 4, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `investment_user_rewards`
--

CREATE TABLE `investment_user_rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(90) NOT NULL,
  `level` varchar(90) NOT NULL,
  `invest` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `team_invest` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `deposit` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `referral_count` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `reward` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `investment_user_rewards`
--

INSERT INTO `investment_user_rewards` (`id`, `name`, `level`, `invest`, `team_invest`, `deposit`, `referral_count`, `reward`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bronze Starter', 'Level-1', 1000.00000000, 5000.00000000, 200.00000000, 10.00000000, 100.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(2, 'Silver Investor', 'Level-2', 2000.00000000, 10000.00000000, 400.00000000, 20.00000000, 200.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(3, 'Gold Partner', 'Level-3', 3000.00000000, 15000.00000000, 600.00000000, 30.00000000, 300.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(4, 'Platinum Sponsor', 'Level-4', 4000.00000000, 20000.00000000, 800.00000000, 40.00000000, 400.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(5, 'Diamond Elite', 'Level-5', 5000.00000000, 25000.00000000, 1000.00000000, 50.00000000, 500.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(6, 'Ruby Champion', 'Level-6', 6000.00000000, 30000.00000000, 1200.00000000, 60.00000000, 600.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(7, 'Sapphire Master', 'Level-7', 7000.00000000, 35000.00000000, 1400.00000000, 70.00000000, 700.00000000, 1, '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(8, 'Bronze Starter', 'Level-1', 1000.00000000, 5000.00000000, 200.00000000, 10.00000000, 100.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(9, 'Silver Investor', 'Level-2', 2000.00000000, 10000.00000000, 400.00000000, 20.00000000, 200.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(10, 'Gold Partner', 'Level-3', 3000.00000000, 15000.00000000, 600.00000000, 30.00000000, 300.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(11, 'Platinum Sponsor', 'Level-4', 4000.00000000, 20000.00000000, 800.00000000, 40.00000000, 400.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(12, 'Diamond Elite', 'Level-5', 5000.00000000, 25000.00000000, 1000.00000000, 50.00000000, 500.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(13, 'Ruby Champion', 'Level-6', 6000.00000000, 30000.00000000, 1200.00000000, 60.00000000, 600.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(14, 'Sapphire Master', 'Level-7', 7000.00000000, 35000.00000000, 1400.00000000, 70.00000000, 700.00000000, 1, '2025-09-16 12:38:31', '2025-09-16 12:38:31'),
(15, 'Bronze Starter', 'Level-1', 1000.00000000, 5000.00000000, 200.00000000, 10.00000000, 100.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(16, 'Silver Investor', 'Level-2', 2000.00000000, 10000.00000000, 400.00000000, 20.00000000, 200.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(17, 'Gold Partner', 'Level-3', 3000.00000000, 15000.00000000, 600.00000000, 30.00000000, 300.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(18, 'Platinum Sponsor', 'Level-4', 4000.00000000, 20000.00000000, 800.00000000, 40.00000000, 400.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(19, 'Diamond Elite', 'Level-5', 5000.00000000, 25000.00000000, 1000.00000000, 50.00000000, 500.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(20, 'Ruby Champion', 'Level-6', 6000.00000000, 30000.00000000, 1200.00000000, 60.00000000, 600.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(21, 'Sapphire Master', 'Level-7', 7000.00000000, 35000.00000000, 1400.00000000, 70.00000000, 700.00000000, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"a03d2b82-9064-4a40-895f-2140b2a9dfd2\",\"displayName\":\"App\\\\Mail\\\\GlobalMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:19:\\\"App\\\\Mail\\\\GlobalMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"emailSubject\\\";s:37:\\\"Verify Your Email - Nextbroker Online\\\";s:9:\\\"emailBody\\\";s:438:\\\"<h1>Email Verification<\\/h1><p>Hi Renato Gomes da Conceição Júnior ,<\\/p><p>Please click the link below to verify your email address:<\\/p><p><a href=\\\"https:\\/\\/nextbroker.online\\/email\\/verify\\/1\\/5ffc804c52428f57ef8226ae7256730dde6b7862?expires=1758245738&signature=447f360ffd66dbf993a01220f751a8099e2c80a9ab2cab28f7bea8c7725b197c\\\">Verify Email<\\/a><\\/p><p>This link will expire in 24 hours.<\\/p><p>Best regards,<br>The Nextbroker Online Team<\\/p>\\\";s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}', 0, NULL, 1758159338, 1758159338),
(2, 'default', '{\"uuid\":\"d49be700-d3f8-4b5a-8df2-367c7184b130\",\"displayName\":\"App\\\\Mail\\\\GlobalMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:19:\\\"App\\\\Mail\\\\GlobalMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"emailSubject\\\";s:37:\\\"Verify Your Email - Nextbroker Online\\\";s:9:\\\"emailBody\\\";s:435:\\\"<h1>Email Verification<\\/h1><p>Hi RENATO GOMES DA CONCEICAO JUNIOR ,<\\/p><p>Please click the link below to verify your email address:<\\/p><p><a href=\\\"https:\\/\\/nextbroker.online\\/email\\/verify\\/2\\/e3ae0eff488a4be6fed6434a8deab26b1bec6f2a?expires=1758247201&signature=5fa10614abd648846d5cfe523092a7e59864e02bf7edad9cf67de61c71659a5d\\\">Verify Email<\\/a><\\/p><p>This link will expire in 24 hours.<\\/p><p>Best regards,<br>The Nextbroker Online Team<\\/p>\\\";s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}', 0, NULL, 1758160801, 1758160801),
(3, 'default', '{\"uuid\":\"362e42c1-3b7c-429a-9365-c89936b2a3df\",\"displayName\":\"App\\\\Mail\\\\GlobalMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:19:\\\"App\\\\Mail\\\\GlobalMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"emailSubject\\\";s:37:\\\"Verify Your Email - Nextbroker Online\\\";s:9:\\\"emailBody\\\";s:438:\\\"<h1>Email Verification<\\/h1><p>Hi Renato Gomes da Conceição Júnior ,<\\/p><p>Please click the link below to verify your email address:<\\/p><p><a href=\\\"https:\\/\\/nextbroker.online\\/email\\/verify\\/3\\/d350ede62528c3121bd0a41f94e26bb53c466fa0?expires=1758416711&signature=830060497514f5706a5fc9f38d0504ff259d1b66a7ae8cc5c614b6a598176e89\\\">Verify Email<\\/a><\\/p><p>This link will expire in 24 hours.<\\/p><p>Best regards,<br>The Nextbroker Online Team<\\/p>\\\";s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}', 0, NULL, 1758330311, 1758330311),
(4, 'default', '{\"uuid\":\"d7a1a985-9821-436d-b225-3cf2239e161c\",\"displayName\":\"App\\\\Mail\\\\GlobalMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:19:\\\"App\\\\Mail\\\\GlobalMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"emailSubject\\\";s:37:\\\"Verify Your Email - Nextbroker Online\\\";s:9:\\\"emailBody\\\";s:438:\\\"<h1>Email Verification<\\/h1><p>Hi Renato Gomes da Conceição Júnior ,<\\/p><p>Please click the link below to verify your email address:<\\/p><p><a href=\\\"https:\\/\\/nextbroker.online\\/email\\/verify\\/4\\/7cb3683447de424577eb70c1714663968d7f748d?expires=1758417221&signature=7abe276452a35b53e88bb21702b9aa96fa3f1c34887a03e522155fc947347bdd\\\">Verify Email<\\/a><\\/p><p>This link will expire in 24 hours.<\\/p><p>Best regards,<br>The Nextbroker Online Team<\\/p>\\\";s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}', 0, NULL, 1758330821, 1758330821),
(5, 'default', '{\"uuid\":\"27ad73d6-59b1-4fde-9dd6-e33428edcc00\",\"displayName\":\"App\\\\Mail\\\\GlobalMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:19:\\\"App\\\\Mail\\\\GlobalMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"emailSubject\\\";s:37:\\\"Verify Your Email - Nextbroker Online\\\";s:9:\\\"emailBody\\\";s:438:\\\"<h1>Email Verification<\\/h1><p>Hi Renato Gomes da Conceição Júnior ,<\\/p><p>Please click the link below to verify your email address:<\\/p><p><a href=\\\"https:\\/\\/nextbroker.online\\/email\\/verify\\/5\\/2b000f0af662d3b47d6d3f855d5128cc1c2b085c?expires=1758417916&signature=fe954b3d9c7d01ccc080c380a2e498026230423302bdd1ed4a70290028ef28dd\\\">Verify Email<\\/a><\\/p><p>This link will expire in 24 hours.<\\/p><p>Best regards,<br>The Nextbroker Online Team<\\/p>\\\";s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}', 0, NULL, 1758331516, 1758331516),
(6, 'default', '{\"uuid\":\"0fec964a-8cb4-4241-ab12-78d9ffd333eb\",\"displayName\":\"App\\\\Mail\\\\GlobalMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:19:\\\"App\\\\Mail\\\\GlobalMail\\\":4:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"emailSubject\\\";s:37:\\\"Verify Your Email - Nextbroker Online\\\";s:9:\\\"emailBody\\\";s:435:\\\"<h1>Email Verification<\\/h1><p>Hi RENATO GOMES DA CONCEICAO JUNIOR ,<\\/p><p>Please click the link below to verify your email address:<\\/p><p><a href=\\\"https:\\/\\/nextbroker.online\\/email\\/verify\\/6\\/4be9ea98d2cdb80269ba972d673e5bbede62d6fa?expires=1758418486&signature=7e37b2bf49ad7ce0bf3726c0a6b2d59c4c51b0bc67190db0a624dd30291a785e\\\">Verify Email<\\/a><\\/p><p>This link will expire in 24 hours.<\\/p><p>Best regards,<br>The Nextbroker Online Team<\\/p>\\\";s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}', 0, NULL, 1758332086, 1758332086),
(7, 'default', '{\"uuid\":\"7d4fc1c4-1b03-47b8-a7af-37ff6e2715de\",\"displayName\":\"App\\\\Notifications\\\\DepositNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Deposit\\\";s:2:\\\"id\\\";a:1:{i:0;i:3;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\DepositNotification\\\":2:{s:19:\\\"\\u0000*\\u0000notificationType\\\";E:44:\\\"App\\\\Enums\\\\Payment\\\\NotificationType:REQUESTED\\\";s:2:\\\"id\\\";s:36:\\\"edce6903-6d75-4856-93ec-b1d399af0841\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1758703967, 1758703967),
(8, 'default', '{\"uuid\":\"5c3dc72f-86cf-4d83-bba5-1c4ee6d32646\",\"displayName\":\"App\\\\Notifications\\\\DepositNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Deposit\\\";s:2:\\\"id\\\";a:1:{i:0;i:4;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\DepositNotification\\\":2:{s:19:\\\"\\u0000*\\u0000notificationType\\\";E:44:\\\"App\\\\Enums\\\\Payment\\\\NotificationType:REQUESTED\\\";s:2:\\\"id\\\";s:36:\\\"cd131619-378e-4d68-b15d-ab3b59ea0867\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1758703979, 1758703979);

-- --------------------------------------------------------

--
-- Estrutura para tabela `kyc_verifications`
--

CREATE TABLE `kyc_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `document_front_path` varchar(255) DEFAULT NULL,
  `document_back_path` varchar(255) DEFAULT NULL,
  `selfie_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','reviewing','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `successful` tinyint(1) NOT NULL DEFAULT 0,
  `attempted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `user_id`, `email`, `ip_address`, `user_agent`, `location`, `device_type`, `browser`, `platform`, `successful`, `attempted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'r3nato90@hotmail.com', '179.162.71.42', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Parnamirim, Rio Grande do Norte, Brazil', 'Desktop', 'Google Chrome', 'Linux', 0, '2025-09-19 03:22:37', '2025-09-19 03:22:37', '2025-09-19 03:22:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ltu_languages`
--

CREATE TABLE `ltu_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `ltu_languages`
--

INSERT INTO `ltu_languages` (`id`, `name`, `code`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '2025-09-16 12:32:12', '2025-09-19 22:54:09'),
(2, 'Português', 'pt-br', 2, '2025-09-16 12:38:31', '2025-09-19 22:54:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `matrix`
--

CREATE TABLE `matrix` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(32) NOT NULL,
  `name` varchar(90) NOT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `referral_reward` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `is_recommend` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `matrix_investments`
--

CREATE TABLE `matrix_investments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(16) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `trx` varchar(90) DEFAULT NULL,
  `price` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `referral_reward` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `referral_commissions` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `level_commissions` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `matrix_levels`
--

CREATE TABLE `matrix_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `level` int(11) DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `matrix_levels`
--

INSERT INTO `matrix_levels` (`id`, `plan_id`, `level`, `amount`, `created_at`, `updated_at`) VALUES
(31, 1, 1, 13.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(32, 1, 2, 3.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(33, 1, 3, 3.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(34, 1, 4, 3.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(35, 1, 5, 3.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(36, 2, 1, 15.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(37, 2, 2, 5.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(38, 2, 3, 5.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(39, 2, 4, 5.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(40, 2, 5, 5.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(41, 3, 1, 20.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(42, 3, 2, 7.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(43, 3, 3, 7.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(44, 3, 4, 7.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(45, 3, 5, 7.00000000, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `section_key` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`section_key`)),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `parent_id`, `is_default`, `section_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'https://nextbroker.online', NULL, 1, NULL, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(2, 'Trade', 'https://nextbroker.online/trades', NULL, 1, NULL, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(3, 'Pricing', 'plans', NULL, 0, '[\"pricing_plan\",\"matrix_plan\",\"service\",\"feature\",\"faq\"]', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(4, 'Features', 'features', NULL, 0, '[\"about\",\"process\",\"service\",\"choose_us\",\"testimonial\"]', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_07_15_000000_create_firewall_ips_table', 1),
(5, '2019_07_15_000000_create_firewall_logs_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2022_07_22_181617_create_admins_table', 1),
(9, '2022_08_15_073439_create_settings_table', 1),
(10, '2022_08_15_130411_create_email_sms_templates_table', 1),
(11, '2022_08_18_090649_create_sms_gateways_table', 1),
(12, '2022_10_23_180535_create_admin_password_resets_table', 1),
(13, '2022_11_05_163156_create_transactions_table', 1),
(14, '2022_11_11_170906_create_plugin_configurations_table', 1),
(15, '2023_03_09_173433_create_jobs_table', 1),
(16, '2023_04_07_033225_create_matrix_table', 1),
(17, '2023_04_07_033953_create_matrix_levels_table', 1),
(18, '2023_04_07_100450_create_pin_generates_table', 1),
(19, '2023_05_01_011415_create_withdraw_methods_table', 1),
(20, '2023_05_04_003818_create_investment_plans_table', 1),
(21, '2023_10_09_052732_create_crypto_currencies_table', 1),
(22, '2023_10_09_052913_create_trade_logs_table', 1),
(23, '2023_11_09_165436_create_menus_table', 1),
(24, '2023_12_07_015820_create_frontends_table', 1),
(25, '2023_12_29_033331_create_deposits_table', 1),
(26, '2023_12_29_044224_create_payment_method_table', 1),
(27, '2023_12_29_132520_create_wallets_table', 1),
(28, '2023_12_30_120958_create_commissions_table', 1),
(29, '2023_12_31_055200_create_withdraw_logs_table', 1),
(30, '2024_01_06_075523_create_investment_logs_table', 1),
(31, '2024_01_07_150350_create_matrix_investments_table', 1),
(32, '2024_02_11_113450_create_languages_table', 1),
(33, '2024_02_26_113307_create_notifications_table', 1),
(34, '2024_03_14_224525_create_subscribers_table', 1),
(35, '2024_03_22_191502_create_contacts_table', 1),
(36, '2024_03_30_215030_create_crons_table', 1),
(37, '2024_04_20_071436_create_notification_id_table', 1),
(38, '2024_04_28_113202_create_payment_details_table', 1),
(39, '2024_04_28_170353_create_referrals_table', 1),
(40, '2024_05_05_113825_create_time_tables_table', 1),
(41, '2024_05_05_142818_create_investment_plan_times_table', 1),
(42, '2024_05_12_104928_create_holidays_table', 1),
(43, '2024_05_15_021055_create_staking_plans_table', 1),
(44, '2024_05_15_021110_create_staking_investments_table', 1),
(45, '2024_06_06_085329_add_expires_at_to_personal_access_tokens_table', 1),
(46, '2024_07_13_140643_deposit_btc_tokens_table', 1),
(47, '2024_07_27_120544_create_investment_user_rewards_table', 1),
(48, '2024_08_25_223627_create_trade_win_balance_table', 1),
(49, '2024_08_26_194630_create_theme_template_setting_table', 1),
(50, '2024_11_25_204332_crypto_payment_table', 1),
(51, '2024_12_22_125628_deposit_currency_table', 1),
(52, '2025_01_13_161910_create_tokens_table', 1),
(53, '2025_02_08_080206_maintenance_mode_migration', 1),
(54, '2025_08_05_031357_update_tokens_table', 1),
(55, '2025_08_05_063620_create_ico_purchases_table', 1),
(56, '2025_08_05_063654_create_token_sales_table', 1),
(57, '2025_08_07_092418_create_trade_settings_table', 1),
(58, '2025_08_07_092529_add_new_columns_to_trades_table', 1),
(59, '2025_08_07_142255_update_crypto_currencies_table', 1),
(60, '2025_08_09_034808_create_login_attempts_table', 1),
(61, '2025_08_09_044220_restructure_settings_table', 1),
(62, '2025_08_10_055338_create_kyc_verifications_table', 1),
(63, '2025_08_10_101322_update_kyc_status_enum_values_in_users_table', 1),
(64, '2025_08_10_114927_add_two_factor_columns_to_admins_table', 1),
(65, '2025_08_15_202606_add_last_login_at_to_users_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `percent_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `name` varchar(30) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL,
  `file` varchar(190) DEFAULT NULL,
  `parameter` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameter`)),
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `details` longtext DEFAULT NULL,
  `minimum` decimal(28,8) DEFAULT NULL,
  `maximum` decimal(28,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `currency`, `percent_charge`, `rate`, `name`, `code`, `file`, `parameter`, `type`, `status`, `created_at`, `updated_at`, `details`, `minimum`, `maximum`) VALUES
(1, 'USD', 0.00000000, 1.00000000, 'Stripe', 'stripe', 'stripe.png', '{\"secret_key\":\"##################\",\"publishable_key\":\"#####################\"}', 1, 2, '2025-09-16 12:39:16', '2025-09-17 23:58:11', NULL, 100.00000000, 100000.00000000),
(2, 'USD', 1.00000000, 1.00000000, 'Paypal', 'paypal', 'paypal.png', '{\"environment\":\"sandbox\",\"client_id\":\"############\",\"secret\":\"##############\",\"app_id\":\"#################\"}', 1, 2, '2025-09-16 12:39:16', '2025-09-17 23:59:52', NULL, 100.00000000, 100000.00000000),
(3, 'USD', 1.00000000, 10.00000000, 'Flutterwave', 'flutter-wave', 'flutter-wave.png', '{\"public_key\":\"############\",\"secret_key\":\"############\",\"secret_hash\":\"############\"}', 1, 2, '2025-09-16 12:39:16', '2025-09-18 00:00:01', NULL, 100.00000000, 100000.00000000),
(4, 'USD', 1.00000000, 10.00000000, 'Pay Stack', 'pay-stack', 'pay-stack.png', '{\"public_key\":\"############\",\"secret_key\":\"############\",\"payment_url\":\"https:\\/\\/api.paystack.co\",\"merchant_email\":\"#######@gmail.com\"}', 1, 2, '2025-09-16 12:39:16', '2025-09-18 00:00:18', NULL, 100.00000000, 100000.00000000),
(5, 'USDT-TRC20', 3.00000000, 1.00000000, 'Payment Solutions', '7LtFR', 'atm-card.png', '{\"usdt-trc20\":{\"field_label\":\"USDT-TRC20\",\"field_name\":\"usdt-trc20\",\"field_type\":\"text\"}}', 2, 2, '2025-09-16 12:39:16', '2025-09-19 00:13:48', NULL, 100.00000000, 100000.00000000),
(6, 'USD', 0.00000000, 1.00000000, 'Depósito PIX', 'IQhTG', 'online-payment.png', '{\"clique_na_caixa_verde\":{\"field_label\":\"CLIQUE NA CAIXA VERDE\",\"field_name\":\"clique_na_caixa_verde\",\"field_type\":\"textarea\"}}', 2, 1, '2025-09-16 12:39:16', '2025-09-23 12:02:35', NULL, 10.00000000, 100000.00000000),
(7, 'USD', 3.00000000, 1.00000000, 'Versell', 'Versell', 'online-payment.png', '{\"trx\":{\"field_label\":\"Trx\",\"field_name\":\"trx\",\"field_type\":\"text\"}}', 2, 2, '2025-09-16 12:39:16', '2025-09-16 12:39:16', NULL, 100.00000000, 100000.00000000);

-- --------------------------------------------------------

--
-- Estrutura para tabela `payment_methods_2`
--

CREATE TABLE `payment_methods_2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `currency` varchar(50) DEFAULT 'USD',
  `enabled` tinyint(1) DEFAULT 1,
  `payment_gateway` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `custom_params` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Despejando dados para a tabela `payment_methods_2`
--

INSERT INTO `payment_methods_2` (`id`, `name`, `api_key`, `secret_key`, `api_url`, `currency`, `enabled`, `payment_gateway`, `created_at`, `updated_at`, `custom_params`) VALUES
(1, 'OndaPay', 'c4a05c1a-2c57-41e2-b795-98bd55540490	', 'VKtEa8Qz4Nm5uVZy6OA6yu3wPCJ4j6bJ\n', 'https://api.ondapay.app/payment', 'USD', 1, 'ondapay', '2025-09-20 02:11:23', '2025-09-20 02:14:41', '0'),
(2, 'PagHiper', 'YOUR_PAGHIPER_API_KEY', 'YOUR_PAGHIPER_SECRET_KEY', 'https://api.paghiper.com/charge', 'BRL', 1, 'paghiper', '2025-09-20 02:11:23', '2025-09-20 02:11:23', '0'),
(3, 'GestãoPay', 'YOUR_GESTAOPAY_API_KEY', 'YOUR_GESTAOPAY_SECRET_KEY', 'https://api.gestaopay.com.br/charge', 'BRL', 1, 'gestaopay', '2025-09-20 02:11:23', '2025-09-20 02:11:23', '0'),
(4, 'BSPay', 'YOUR_BSPAY_API_KEY', 'YOUR_BSPAY_SECRET_KEY', 'https://api.bspay.com/payment', 'USD', 1, 'bspay', '2025-09-20 02:11:23', '2025-09-20 02:11:23', '0'),
(5, 'Coinbase', 'YOUR_COINBASE_API_KEY', 'YOUR_COINBASE_SECRET_KEY', 'https://api.coinbase.com/v2/payment', 'USD', 1, 'coinbase', '2025-09-20 02:11:23', '2025-09-20 02:11:23', '0'),
(6, 'OndaPay', 'YOUR_ONDAPAY_API_KEY', 'YOUR_ONDAPAY_SECRET_KEY', 'https://api.ondapay.app/payment', 'USD', 1, 'ondapay', '2025-09-20 02:24:01', '2025-09-20 02:24:01', '0'),
(7, 'PagHiper', 'YOUR_PAGHIPER_API_KEY', 'YOUR_PAGHIPER_SECRET_KEY', 'https://api.paghiper.com/charge', 'BRL', 1, 'paghiper', '2025-09-20 02:24:01', '2025-09-20 02:24:01', '0'),
(8, 'GestãoPay', 'YOUR_GESTAOPAY_API_KEY', 'YOUR_GESTAOPAY_SECRET_KEY', 'https://api.gestaopay.com.br/charge', 'BRL', 1, 'gestaopay', '2025-09-20 02:24:01', '2025-09-20 02:24:01', '0'),
(9, 'BSPay', 'YOUR_BSPAY_API_KEY', 'YOUR_BSPAY_SECRET_KEY', 'https://api.bspay.com/payment', 'USD', 1, 'bspay', '2025-09-20 02:24:01', '2025-09-20 02:24:01', '0'),
(10, 'Coinbase', 'YOUR_COINBASE_API_KEY', 'YOUR_COINBASE_SECRET_KEY', 'https://api.coinbase.com/v2/payment', 'USD', 1, 'coinbase', '2025-09-20 02:24:01', '2025-09-20 02:24:01', '0');

-- --------------------------------------------------------

--
-- Estrutura para tabela `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `payment_gateway` varchar(50) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `qr_code` text DEFAULT NULL,
  `pix_code` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(50) DEFAULT 'USD',
  `status` enum('pending','paid','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pin_generates`
--

CREATE TABLE `pin_generates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(32) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `set_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `pin_number` varchar(120) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Unused : 1, Used : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `plugin_configurations`
--

CREATE TABLE `plugin_configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(60) DEFAULT NULL,
  `name` varchar(120) DEFAULT NULL,
  `short_key` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `plugin_configurations`
--

INSERT INTO `plugin_configurations` (`id`, `code`, `name`, `short_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TAWK-111', 'Tawk.to Configuration', '{\"api_key\":\"demo\"}', 2, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(2, 'GOOGLE-ANALYTICS', 'Google Analytics', '{\"api_key\":\"demo\"}', 2, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(3, 'hoory-113', 'Hoory Configuration', '{\"api_key\":\"demo\"}', 2, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level` int(11) NOT NULL,
  `percent` decimal(8,2) NOT NULL,
  `commission_type` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `referrals`
--

INSERT INTO `referrals` (`id`, `level`, `percent`, `commission_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1.00, 3, NULL, NULL),
(2, 2, 1.00, 3, NULL, NULL),
(3, 3, 1.00, 3, NULL, NULL),
(4, 4, 1.00, 3, NULL, NULL),
(5, 5, 1.00, 3, NULL, NULL),
(6, 6, 1.00, 3, NULL, NULL),
(7, 7, 1.00, 3, NULL, NULL),
(8, 8, 1.00, 3, NULL, NULL),
(9, 9, 1.00, 3, NULL, NULL),
(10, 10, 1.00, 3, NULL, NULL),
(11, 11, 1.00, 3, NULL, NULL),
(12, 12, 1.00, 3, NULL, NULL),
(13, 13, 1.00, 3, NULL, NULL),
(14, 14, 1.00, 3, NULL, NULL),
(15, 15, 1.00, 3, NULL, NULL),
(16, 16, 1.00, 3, NULL, NULL),
(17, 17, 1.00, 3, NULL, NULL),
(18, 18, 1.00, 3, NULL, NULL),
(19, 19, 1.00, 3, NULL, NULL),
(20, 20, 1.00, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `created_at`, `updated_at`) VALUES
(1, 'logo_dark', 'engznLl2JlxMGpMS.png', 'file', 'appearance', 'Dark Logo', 'Logo file for dark theme', '2025-09-16 12:32:12', '2025-09-23 11:55:32'),
(2, 'logo_white', '9uTiAgxYnZc6ysKv.png', 'file', 'appearance', 'White Logo', 'Logo file for white theme', '2025-09-16 12:32:12', '2025-09-23 11:55:32'),
(3, 'logo_favicon', 'MnT67ihRAOo1UlXO.png', 'file', 'appearance', 'Favicon Logo', 'Logo file for favicon theme', '2025-09-16 12:32:12', '2025-09-23 11:55:32'),
(4, 'email', 'demo@example.com', 'email', 'appearance', 'Email', 'Application email setting', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(5, 'phone', '1234567890', 'text', 'appearance', 'Phone', 'Application phone setting', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(6, 'address', '3971 Roden Dr', 'text', 'appearance', 'Address', 'Application address setting', '2025-09-16 12:32:12', '2025-09-23 11:55:32'),
(7, 'paginate', '20', 'number', 'appearance', 'Paginate', 'Application paginate setting', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(8, 'timezone', 'UTC', 'text', 'appearance', 'Timezone', 'Application timezone setting', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(9, 'site_title', 'Nextbroker Online', 'text', 'appearance', 'Site title', 'Application site_title setting', '2025-09-16 12:32:12', '2025-09-16 12:44:45'),
(10, 'currency_code', 'USD', 'text', 'appearance', 'Currency code', 'Application currency_code setting', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(11, 'currency_symbol', '$', 'text', 'appearance', 'Currency symbol', 'Application currency_symbol setting', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(12, 'module_e_pin', '0', 'select', 'system', 'E pin Module', 'If you disable this module, users won\'t be able to recharge E-pins on this system.', '2025-09-16 12:32:12', '2025-09-17 22:55:19'),
(13, 'module_language', '0', 'select', 'system', 'Language Module', 'If you disable this module, users won\'t be able to change the system language.', '2025-09-16 12:32:12', '2025-09-23 11:57:58'),
(14, 'module_binary_trade', '1', 'select', 'system', 'Binary trade Module', 'If you deactivate the binary trade option, the binary trading feature will be turned off.', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(15, 'module_practice_trade', '1', 'select', 'system', 'Practice trade Module', 'If you deactivate the practice trade option, the practice trading feature will be turned off.', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(16, 'module_balance_transfer', '0', 'select', 'system', 'Balance transfer Module', 'Enabling this module allows users to initiate balance transfers within the system.', '2025-09-16 12:32:12', '2025-09-17 22:55:19'),
(17, 'module_kyc_verification', '0', 'select', 'system', 'Kyc verification Module', 'If you disable this module, users won\'t undergo KYC verification in this system.', '2025-09-16 12:32:12', '2025-09-23 11:57:58'),
(18, 'module_sms_notification', '0', 'select', 'system', 'Sms notification Module', 'If you disable this module, users won\'t receive SMS notifications in this system.', '2025-09-16 12:32:12', '2025-09-17 22:55:19'),
(19, 'module_withdraw_request', '1', 'select', 'system', 'Withdraw request Module', 'If you disable this module, users won\'t be able to submit withdrawal requests in this system.', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(20, 'module_cookie_activation', '1', 'select', 'system', 'Cookie activation Module', 'If you disable this module, users won\'t be able to activate cookies in this system.', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(21, 'module_investment_reward', '1', 'select', 'system', 'Investment reward Module', 'Enabling this module allows users to receive rewards for their investments within the system.', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(22, 'module_email_notification', '0', 'select', 'system', 'Email notification Module', 'If you disable this module, users won\'t receive email notifications in this system.', '2025-09-16 12:32:12', '2025-09-23 11:57:58'),
(23, 'module_email_verification', '0', 'select', 'system', 'Email verification Module', 'If you deactivate the email verification module, users won\'t be able to verify their email addresses in this system.', '2025-09-16 12:32:12', '2025-09-23 11:57:58'),
(24, 'module_registration_status', '1', 'select', 'system', 'Registration status Module', 'If you disable this module, new users won\'t be able to register on this system.', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(25, 'primary_color', '#7CB241', 'color', 'theme', 'Primary color', 'Theme primary_color configuration', '2025-09-16 12:32:12', '2025-09-17 23:05:56'),
(26, 'secondary_color', '#7CB241', 'color', 'theme', 'Secondary color', 'Theme secondary_color configuration', '2025-09-16 12:32:12', '2025-09-17 23:05:56'),
(27, 'primary_text_color', '#150801', 'color', 'theme', 'Primary text color', 'Theme primary_text_color configuration', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(28, 'secondary_text_color', '#6a6a6a', 'color', 'theme', 'Secondary text color', 'Theme secondary_text_color configuration', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(29, 'mail_host', 'smtp.hostinger.com', 'text', 'mail', 'Mail Host', 'Email host configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(30, 'mail_port', '465', 'number', 'mail', 'Mail Port', 'Email port configuration', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(31, 'mail_password', '$zb@au2mX#HsbR@', 'text', 'mail', 'Mail Password', 'Email password configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(32, 'mail_username', 'oi@nextbroker.online', 'text', 'mail', 'Mail Username', 'Email username configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(33, 'mail_from_name', 'Nextbroker Online', 'text', 'mail', 'Mail From name', 'Email from_name configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(34, 'mail_encryption', 'ssl', 'text', 'mail', 'Mail Encryption', 'Email encryption configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(35, 'mail_from_email', 'oi@nextbroker.online', 'text', 'mail', 'Mail From email', 'Email from_email configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(36, 'mail_template', 'Olá!', 'textarea', 'mail', 'Mail Template', 'Mail Template configuration', '2025-09-16 12:32:12', '2025-09-17 22:25:20'),
(37, 'investment_matrix', '0', 'select', 'investment', 'Matrix Investment', 'Enable/disable matrix investment feature', '2025-09-16 12:32:12', '2025-09-17 22:17:07'),
(38, 'investment_ico_token', '0', 'select', 'investment', 'Ico token Investment', 'Enable/disable ico_token investment feature', '2025-09-16 12:32:12', '2025-09-17 22:17:07'),
(39, 'investment_investment', '0', 'select', 'investment', 'Investment Investment', 'Enable/disable investment investment feature', '2025-09-16 12:32:12', '2025-09-17 22:17:07'),
(40, 'investment_trade_prediction', '1', 'select', 'investment', 'Trade prediction Investment', 'Enable/disable trade_prediction investment feature', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(41, 'investment_staking_investment', '1', 'select', 'investment', 'Staking investment Investment', 'Enable/disable staking_investment investment feature', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(42, 'e_pin_charge', '10', 'number', 'finance', 'E pin charge', 'Commission/charge for e_pin_charge', '2025-09-16 12:32:12', '2025-09-23 11:56:53'),
(43, 'balance_transfer_charge', '10', 'number', 'finance', 'Balance transfer charge', 'Commission/charge for balance_transfer_charge', '2025-09-16 12:32:12', '2025-09-23 11:56:53'),
(44, 'investment_cancel_charge', '0', 'number', 'finance', 'Investment cancel charge', 'Commission/charge for investment_cancel_charge', '2025-09-16 12:32:12', '2025-09-23 11:56:53'),
(45, 'investment_transfer_charge', '1', 'number', 'finance', 'Investment transfer charge', 'Commission/charge for investment_transfer_charge', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(46, 'seo_image', NULL, 'text', 'seo', 'SEO Image', 'SEO image configuration', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(47, 'seo_title', '-', 'text', 'seo', 'SEO Title', 'SEO title configuration', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(48, 'seo_keywords', '[\"crypto\",\"trade\",\"pre\\u00e7o do bitcoin\",\"pre\\u00e7o do solana\"]', 'json', 'seo', 'SEO Keywords', 'SEO keywords configuration', '2025-09-16 12:32:12', '2025-09-17 22:53:46'),
(49, 'seo_description', 'Nextboker Online - Corretora de Criptoativos Disrruptiva', 'text', 'seo', 'SEO Description', 'SEO description configuration', '2025-09-16 12:32:12', '2025-09-17 22:53:46'),
(50, 'version', '5.0', 'text', 'general', 'Application Version', 'Application Version configuration', '2025-09-16 12:32:12', '2025-09-23 11:56:59'),
(51, 'height', '0', 'text', 'matrix_parameters', 'Matrix Height', 'Set the height dimension for matrix calculations', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(52, 'width', '0', 'text', 'matrix_parameters', 'Matrix Width', 'Set the width dimension for matrix calculations', '2025-09-16 12:32:12', '2025-09-16 12:32:12'),
(53, 'investment_setting', '{\"investment_matrix\":0,\"investment_ico_token\":0,\"investment_investment\":0,\"investment_trade_prediction\":1,\"investment_staking_investment\":1}', 'json', 'investment_setting', 'Investment Settings', NULL, '2025-09-18 12:31:34', '2025-09-18 12:31:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sms_gateways`
--

CREATE TABLE `sms_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `credential` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Active : 1, Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sms_gateways`
--

INSERT INTO `sms_gateways` (`id`, `code`, `name`, `credential`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TWILIO102', 'Twilio SMS Gateway', '{\"account_sid\":\"demo\",\"auth_token\":\"demo\",\"from_number\":\"demo\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(2, 'IMESSAGE103', 'Message Bird SMS Gateway', '{\"access_key\":\"demo\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(3, 'MAGIC104', 'Text Magic SMS Gateway', '{\"api_key\":\"demo\",\"text_magic_username\":\"demo\"}', 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `staking_investments`
--

CREATE TABLE `staking_investments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `staking_plan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `interest` decimal(8,2) NOT NULL DEFAULT 0.00,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `staking_plans`
--

CREATE TABLE `staking_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 0,
  `interest_rate` decimal(8,2) NOT NULL DEFAULT 0.00,
  `minimum_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maximum_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `staking_plans`
--

INSERT INTO `staking_plans` (`id`, `duration`, `interest_rate`, `minimum_amount`, `maximum_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 30, 95.00, 3.00000000, 100.00000000, 1, '2025-09-16 12:39:16', '2025-09-18 15:16:10'),
(2, 45, 210.00, 190.00000000, 10000.00000000, 1, '2025-09-16 12:39:16', '2025-09-18 15:16:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `time_tables`
--

CREATE TABLE `time_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `time_tables`
--

INSERT INTO `time_tables` (`id`, `name`, `time`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hours', 1, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(2, 'Days', 24, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(3, 'Weeks', 168, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(4, 'Months', 720, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16'),
(5, 'Years', 8760, 1, '2025-09-16 12:39:16', '2025-09-16 12:39:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `total_supply` decimal(30,18) NOT NULL,
  `price` decimal(30,18) NOT NULL,
  `current_price` decimal(30,18) NOT NULL DEFAULT 0.000000000000000000,
  `status` enum('active','paused','completed','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price_updated_at` timestamp NULL DEFAULT NULL,
  `tokens_sold` bigint(20) NOT NULL DEFAULT 0,
  `sale_start_date` date NOT NULL,
  `sale_end_date` date NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `token_sales`
--

CREATE TABLE `token_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ico_token_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` varchar(255) NOT NULL,
  `tokens_sold` int(11) NOT NULL,
  `sale_price` decimal(15,4) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'completed',
  `sold_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `trade_logs`
--

CREATE TABLE `trade_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `status` enum('active','won','lost','draw','cancelled','expired') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `winning_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trade_id` varchar(255) DEFAULT NULL,
  `trade_setting_id` bigint(20) UNSIGNED DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `direction` enum('up','down') DEFAULT NULL,
  `open_price` decimal(15,8) DEFAULT NULL,
  `close_price` decimal(15,8) DEFAULT NULL,
  `duration_seconds` int(11) DEFAULT NULL,
  `payout_rate` decimal(5,2) DEFAULT NULL,
  `open_time` timestamp NULL DEFAULT NULL,
  `expiry_time` timestamp NULL DEFAULT NULL,
  `close_time` timestamp NULL DEFAULT NULL,
  `profit_loss` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `trade_settings`
--

CREATE TABLE `trade_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `min_amount` decimal(15,2) NOT NULL DEFAULT 1.00,
  `max_amount` decimal(15,2) NOT NULL DEFAULT 10000.00,
  `payout_rate` decimal(5,2) NOT NULL DEFAULT 85.00,
  `durations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`durations`)),
  `trading_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`trading_hours`)),
  `spread` decimal(8,5) NOT NULL DEFAULT 0.00001,
  `max_trades_per_user` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `trade_settings`
--

INSERT INTO `trade_settings` (`id`, `currency_id`, `symbol`, `is_active`, `min_amount`, `max_amount`, `payout_rate`, `durations`, `trading_hours`, `spread`, `max_trades_per_user`, `created_at`, `updated_at`) VALUES
(1, 1, 'BTC', 0, 10.00, 5000.00, 90.00, '[\"300\",\"600\",\"900\",\"1800\"]', '{\"monday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":\"1\",\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00007, 12, '2025-09-16 12:32:12', '2025-09-17 23:55:47'),
(2, 2, 'ETH', 1, 10.00, 5000.00, 87.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00015, 15, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(3, 3, 'USDT', 1, 10.00, 5000.00, 89.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00007, 14, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(4, 4, 'BNB', 1, 10.00, 5000.00, 87.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00005, 6, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(5, 5, 'SOL', 1, 10.00, 5000.00, 88.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 7, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(6, 6, 'USDC', 0, 10.00, 5000.00, 80.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00010, 11, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(7, 7, 'STETH', 1, 10.00, 5000.00, 85.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00008, 20, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(8, 8, 'DOGE', 0, 10.00, 5000.00, 85.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00006, 6, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(9, 9, 'ADA', 0, 10.00, 5000.00, 89.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00010, 14, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(10, 10, 'TRX', 1, 10.00, 5000.00, 82.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00010, 8, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(11, 11, 'AVAX', 0, 10.00, 5000.00, 81.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00015, 19, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(12, 12, 'LINK', 1, 10.00, 5000.00, 86.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00013, 6, '2025-09-16 12:32:12', '2025-09-16 12:39:16'),
(13, 13, 'SHIB', 1, 10.00, 5000.00, 81.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00007, 8, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(14, 14, 'BCH', 0, 10.00, 5000.00, 85.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00008, 13, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(15, 15, 'DOT', 1, 10.00, 5000.00, 90.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00008, 14, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(16, 16, 'NEAR', 0, 10.00, 5000.00, 90.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00005, 15, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(17, 17, 'LTC', 1, 10.00, 5000.00, 86.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 20, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(18, 18, 'ICP', 0, 10.00, 5000.00, 80.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 14, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(19, 19, 'DAI', 1, 10.00, 5000.00, 84.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00014, 16, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(20, 20, 'UNI', 1, 10.00, 5000.00, 82.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00005, 11, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(21, 21, 'LEO', 1, 10.00, 5000.00, 82.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00010, 6, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(22, 22, 'ETC', 0, 10.00, 5000.00, 86.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00008, 12, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(23, 23, 'RNDR', 1, 10.00, 5000.00, 86.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00006, 18, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(24, 24, 'HBAR', 1, 10.00, 5000.00, 85.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 9, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(25, 25, 'KAS', 0, 10.00, 5000.00, 89.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00005, 20, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(26, 26, 'TAO', 0, 10.00, 5000.00, 80.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00011, 14, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(27, 27, 'ARB', 1, 10.00, 5000.00, 80.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 16, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(28, 28, 'XLM', 1, 10.00, 5000.00, 83.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00010, 18, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(29, 29, 'OKB', 1, 10.00, 5000.00, 85.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 12, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(30, 30, 'MNT', 1, 10.00, 5000.00, 80.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00012, 6, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(31, 31, 'FIL', 1, 10.00, 5000.00, 82.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00007, 18, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(32, 32, 'ATOM', 0, 10.00, 5000.00, 84.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00014, 8, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(33, 33, 'VET', 1, 10.00, 5000.00, 89.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00005, 13, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(34, 34, 'XMR', 1, 10.00, 5000.00, 88.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00011, 20, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(35, 35, 'INJ', 1, 10.00, 5000.00, 86.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00009, 7, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(36, 36, 'TON', 1, 10.00, 5000.00, 80.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00014, 10, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(37, 37, 'SUI', 1, 10.00, 5000.00, 90.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00014, 9, '2025-09-16 12:32:12', '2025-09-16 12:39:17'),
(38, 38, 'AAVE', 1, 10.00, 5000.00, 90.00, '[30,60,300,900]', '{\"monday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"tuesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"wednesday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"thursday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"friday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"saturday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"},\"sunday\":{\"enabled\":true,\"start\":\"00:00\",\"end\":\"23:59\"}}', 0.00014, 15, '2025-09-16 12:32:12', '2025-09-16 12:39:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(60) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `wallet_type` tinyint(4) NOT NULL DEFAULT 1,
  `source` tinyint(4) NOT NULL DEFAULT 1,
  `details` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `first_name` varchar(90) DEFAULT NULL,
  `last_name` varchar(90) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `referral_by` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `email` varchar(90) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `kyc_status` enum('pending','reviewing','approved','rejected') DEFAULT 'pending',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Active : 1, Banned : 0',
  `password` varchar(255) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `aggregate_investment` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `collective_investment` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `last_reward_update` timestamp NULL DEFAULT NULL,
  `reward_identifier` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `uuid`, `first_name`, `last_name`, `cpf`, `google_id`, `facebook_id`, `referral_by`, `position_id`, `position`, `email`, `phone`, `whatsapp`, `email_verified_at`, `last_login_at`, `image`, `kyc_status`, `status`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `meta`, `created_at`, `updated_at`, `aggregate_investment`, `collective_investment`, `last_reward_update`, `reward_identifier`) VALUES
(1, 'IUktIATTCuS9zwoM', 'Renato Gomes da Conceição Júnior', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'contato@meucontohot.com.br', NULL, NULL, NULL, NULL, NULL, 'pending', 0, '$2y$10$8BSiqkuODUDcS7bMPkgCu.7eRWwpv2M.MyjC7U7DVUwpCltp0LxPG', NULL, NULL, NULL, NULL, NULL, '2025-09-18 01:35:38', '2025-09-18 01:35:38', 0.00000000, 0.00000000, NULL, 0),
(2, 'ASbFAriEINZrjatF', 'RENATO GOMES DA CONCEICAO JUNIOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'r3nato90@hotmail.com', NULL, NULL, NULL, NULL, NULL, 'pending', 0, '$2y$10$PRozE9LF103EI3lXX46u.ebSxdROagj6VPcGgYcw0z/X4BDvYez0a', NULL, NULL, NULL, NULL, NULL, '2025-09-18 02:00:01', '2025-09-18 02:00:01', 0.00000000, 0.00000000, NULL, 0),
(3, 'D3cORQQLXyeZ2ZZ1', 'Renato Gomes da Conceição Júnior', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'contato@renatolegendfx.com', NULL, NULL, NULL, NULL, NULL, 'pending', 0, '$2y$10$xOHZSeyk2gK/dNLIBnAtKe5Gf.RbumbhSPvtkcyny2DkSW4aZ/rbq', NULL, NULL, NULL, NULL, NULL, '2025-09-20 01:05:11', '2025-09-20 01:05:11', 0.00000000, 0.00000000, NULL, 0),
(4, 'mJaSOItJlACMTezX', 'Renato Gomes da Conceição Júnior', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'contato@criattus.digital', NULL, NULL, NULL, NULL, NULL, 'pending', 0, '$2y$10$nF6ytu00j.efGMxUDcGkeuGcbp/yf0jjfgd.Rk7.U45rlBgbx7BSy', NULL, NULL, NULL, NULL, NULL, '2025-09-20 01:13:41', '2025-09-20 01:13:41', 0.00000000, 0.00000000, NULL, 0),
(5, 'FeIMXBVgM1E8wNmd', 'Renato Gomes da Conceição Júnior', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'contato.roneimotta@gmail.com', NULL, NULL, NULL, NULL, NULL, 'pending', 0, '$2y$10$/c7QyWMyZuUyK/O6kQAu4.CxrdNHSRAjaQuGAH4JkLySRj1F8aFvG', NULL, NULL, NULL, NULL, NULL, '2025-09-20 01:25:16', '2025-09-20 01:25:16', 0.00000000, 0.00000000, NULL, 0),
(6, 'ebwRBoq4BxBJ4ktK', 'RENATO GOMES DA CONCEICAO JUNIOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'contato@autobotbrasil.com', '84999032426', NULL, NULL, NULL, NULL, 'pending', 0, '$2y$10$iiQxQ2XVDj9GTJkyqTsVduNqBGIg8jjlW3H82CJGSR34k5fbMy2/y', NULL, NULL, NULL, NULL, NULL, '2025-09-20 01:34:46', '2025-09-20 01:34:46', 0.00000000, 0.00000000, NULL, 0),
(7, 'NqpnahZDpXrLpaN9', 'sloga nathi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fowycixo@forexnews.bg', NULL, NULL, '2025-09-24 08:52:05', NULL, NULL, 'pending', 1, '$2y$10$qr47v28tVqLd5yIrUOLYGuuLQ1B.jp9Z0CuUyvm.XZcX85WNWiMKm', NULL, NULL, NULL, NULL, NULL, '2025-09-24 08:52:05', '2025-09-24 08:52:05', 0.00000000, 0.00000000, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `primary_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `investment_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trade_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `practice_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `primary_balance`, `investment_balance`, `trade_balance`, `practice_balance`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-18 01:35:38', '2025-09-18 01:35:38'),
(2, 2, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-18 02:00:01', '2025-09-18 02:00:01'),
(3, 3, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-20 01:05:11', '2025-09-20 01:05:11'),
(4, 4, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-20 01:13:41', '2025-09-20 01:13:41'),
(5, 5, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-20 01:25:16', '2025-09-20 01:25:16'),
(6, 6, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-20 01:34:46', '2025-09-20 01:34:46'),
(7, 7, 0.00000000, 0.00000000, 0.00000000, 100.00000000, '2025-09-24 08:52:05', '2025-09-24 08:52:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `withdraw_logs`
--

CREATE TABLE `withdraw_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `withdraw_method_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `details` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `currency_name` varchar(20) DEFAULT NULL,
  `min_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `file` varchar(255) DEFAULT NULL,
  `parameter` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameter`)),
  `instruction` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `withdraw_methods`
--

INSERT INTO `withdraw_methods` (`id`, `name`, `currency_name`, `min_limit`, `max_limit`, `fixed_charge`, `percent_charge`, `rate`, `file`, `parameter`, `instruction`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USDT', 'USDT TRC-20', 25.00000000, 100000.00000000, 5.00000000, 5.00000000, 1.00000000, '62e7b2507c25f1659351632.png', '{\"wallet_usdt_trc-20\":{\"field_label\":\"Wallet USDT TRC-20\",\"field_name\":\"wallet_usdt_trc-20\",\"field_type\":\"text\"}}', NULL, 1, '2025-09-16 12:39:16', '2025-09-18 23:48:08');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Índices de tabela `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_password_resets_email_unique` (`email`);

--
-- Índices de tabela `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commissions_user_id_index` (`user_id`),
  ADD KEY `commissions_from_user_id_index` (`from_user_id`);

--
-- Índices de tabela `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `crons`
--
ALTER TABLE `crons`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `crypto_currencies`
--
ALTER TABLE `crypto_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_sms_templates_code_unique` (`code`),
  ADD UNIQUE KEY `email_sms_templates_name_unique` (`name`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `firewall_ips`
--
ALTER TABLE `firewall_ips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `firewall_ips_ip_index` (`ip`);

--
-- Índices de tabela `firewall_logs`
--
ALTER TABLE `firewall_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `firewall_logs_ip_index` (`ip`);

--
-- Índices de tabela `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ico_purchases`
--
ALTER TABLE `ico_purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ico_purchases_purchase_id_unique` (`purchase_id`),
  ADD KEY `ico_purchases_user_id_foreign` (`user_id`);

--
-- Índices de tabela `investment_logs`
--
ALTER TABLE `investment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_logs_uid_index` (`uid`),
  ADD KEY `investment_logs_user_id_index` (`user_id`);

--
-- Índices de tabela `investment_plans`
--
ALTER TABLE `investment_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_plans_uid_index` (`uid`);

--
-- Índices de tabela `investment_user_rewards`
--
ALTER TABLE `investment_user_rewards`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kyc_verifications_user_id_foreign` (`user_id`);

--
-- Índices de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_attempts_user_id_index` (`user_id`);

--
-- Índices de tabela `ltu_languages`
--
ALTER TABLE `ltu_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ltu_languages_code_index` (`code`);

--
-- Índices de tabela `matrix`
--
ALTER TABLE `matrix`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matrix_uid_index` (`uid`);

--
-- Índices de tabela `matrix_investments`
--
ALTER TABLE `matrix_investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matrix_investments_uid_index` (`uid`);

--
-- Índices de tabela `matrix_levels`
--
ALTER TABLE `matrix_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matrix_levels_plan_id_index` (`plan_id`);

--
-- Índices de tabela `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notifications`
--
ALTER TABLE `notifications`
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices de tabela `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `payment_methods_2`
--
ALTER TABLE `payment_methods_2`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `pin_generates`
--
ALTER TABLE `pin_generates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pin_generates_uid_index` (`uid`),
  ADD KEY `pin_generates_user_id_index` (`user_id`),
  ADD KEY `pin_generates_set_user_id_index` (`set_user_id`);

--
-- Índices de tabela `plugin_configurations`
--
ALTER TABLE `plugin_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD KEY `settings_group_key_index` (`group`,`key`);

--
-- Índices de tabela `sms_gateways`
--
ALTER TABLE `sms_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sms_gateways_code_unique` (`code`);

--
-- Índices de tabela `staking_investments`
--
ALTER TABLE `staking_investments`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `staking_plans`
--
ALTER TABLE `staking_plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscribers_email_index` (`email`);

--
-- Índices de tabela `time_tables`
--
ALTER TABLE `time_tables`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `token_sales`
--
ALTER TABLE `token_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_sales_sale_id_unique` (`sale_id`),
  ADD KEY `token_sales_user_id_foreign` (`user_id`);

--
-- Índices de tabela `trade_logs`
--
ALTER TABLE `trade_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_logs_trade_setting_id_foreign` (`trade_setting_id`);

--
-- Índices de tabela `trade_settings`
--
ALTER TABLE `trade_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_settings_currency_id_foreign` (`currency_id`);

--
-- Índices de tabela `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_index` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Índices de tabela `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `withdraw_logs`
--
ALTER TABLE `withdraw_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdraw_logs_uid_index` (`uid`),
  ADD KEY `withdraw_logs_user_id_index` (`user_id`);

--
-- Índices de tabela `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `crons`
--
ALTER TABLE `crons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `crypto_currencies`
--
ALTER TABLE `crypto_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `firewall_ips`
--
ALTER TABLE `firewall_ips`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `firewall_logs`
--
ALTER TABLE `firewall_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ico_purchases`
--
ALTER TABLE `ico_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investment_logs`
--
ALTER TABLE `investment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investment_plans`
--
ALTER TABLE `investment_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `investment_user_rewards`
--
ALTER TABLE `investment_user_rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ltu_languages`
--
ALTER TABLE `ltu_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `matrix`
--
ALTER TABLE `matrix`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `matrix_investments`
--
ALTER TABLE `matrix_investments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `matrix_levels`
--
ALTER TABLE `matrix_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `payment_methods_2`
--
ALTER TABLE `payment_methods_2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pin_generates`
--
ALTER TABLE `pin_generates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `plugin_configurations`
--
ALTER TABLE `plugin_configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `sms_gateways`
--
ALTER TABLE `sms_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `staking_investments`
--
ALTER TABLE `staking_investments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `staking_plans`
--
ALTER TABLE `staking_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `time_tables`
--
ALTER TABLE `time_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `token_sales`
--
ALTER TABLE `token_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `trade_logs`
--
ALTER TABLE `trade_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `trade_settings`
--
ALTER TABLE `trade_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `withdraw_logs`
--
ALTER TABLE `withdraw_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ico_purchases`
--
ALTER TABLE `ico_purchases`
  ADD CONSTRAINT `ico_purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  ADD CONSTRAINT `kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`);

--
-- Restrições para tabelas `token_sales`
--
ALTER TABLE `token_sales`
  ADD CONSTRAINT `token_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `trade_logs`
--
ALTER TABLE `trade_logs`
  ADD CONSTRAINT `trade_logs_trade_setting_id_foreign` FOREIGN KEY (`trade_setting_id`) REFERENCES `trade_settings` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `trade_settings`
--
ALTER TABLE `trade_settings`
  ADD CONSTRAINT `trade_settings_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `crypto_currencies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
