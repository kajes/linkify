-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 17 jan 2017 kl 11:58
-- Serverversion: 10.1.16-MariaDB
-- PHP-version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `kajes_linkify`
--
CREATE DATABASE IF NOT EXISTS `kajes_linkify` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kajes_linkify`;

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE `posts` (
  `postID` int(10) UNSIGNED NOT NULL,
  `authorID` int(10) UNSIGNED NOT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `post_link` varchar(255) DEFAULT NULL,
  `post_content` text,
  `posted_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `voteCount` int(11) DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`postID`, `authorID`, `post_title`, `post_link`, `post_content`, `posted_on`, `updated_on`, `voteCount`, `parent_id`) VALUES
(22, 7, 'Dags att testa', 'http://nicolasgallagher.com/pure-css-speech-bubbles/', 'Här ska testas ordentligt. Vi får se om allt går som det borde.', '2017-01-16 20:10:43', '2017-01-16 20:10:43', 3, 0),
(23, 8, 'Jag vill också', '', 'Jag skriver en extra post här med, för att det är roligt.', '2017-01-16 20:11:39', '2017-01-16 20:11:39', -2, 0),
(24, 9, 'Här är en ball länk', 'https://thenounproject.com/ViconsDesign/uploads/', 'Måste ju länka någonting. Annars är det ju inget roligt här.', '2017-01-16 20:12:53', '2017-01-16 20:12:53', 0, 0),
(25, 10, 'Konstigt först', '', 'Vet ni att det inte går att skrolla ner när det inte finns några inlägg?', '2017-01-16 20:14:30', '2017-01-16 20:14:30', -1, 0),
(26, 11, 'Kommentarer?', '', 'Det verkar inte gå att kommentera. Det här måste undersökas nogrannt.', '2017-01-16 20:17:30', '2017-01-16 20:17:30', 2, 0),
(27, 12, 'Rösta?', '', 'Varför går det inte att rösta helt plötsligt?', '2017-01-16 20:18:42', '2017-01-16 20:18:42', 1, 0),
(29, 7, NULL, NULL, 'Let us see if commenting is working now!', '2017-01-16 20:42:36', '2017-01-16 20:42:36', 1, 27),
(30, 8, NULL, NULL, 'The bugs are squashed hard!!!', '2017-01-16 20:51:02', '2017-01-16 20:51:02', 1, 22),
(31, 8, NULL, NULL, 'Maybe I should migrate everything to doing fetch instead? At least I should fix the error messaging system.', '2017-01-16 20:51:57', '2017-01-16 20:51:57', 0, 24),
(32, 9, NULL, NULL, 'Det borde går att kommentera här också nu.', '2017-01-16 20:52:51', '2017-01-16 20:52:51', 0, 30),
(33, 10, NULL, NULL, 'Nu går det att kommentera igen!!!!', '2017-01-16 20:55:54', '2017-01-16 20:55:54', 1, 26);

-- --------------------------------------------------------

--
-- Tabellstruktur `tokens`
--

CREATE TABLE `tokens` (
  `cookieID` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `first` varchar(128) DEFAULT NULL,
  `second` varchar(256) DEFAULT NULL,
  `expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `tokens`
--

INSERT INTO `tokens` (`cookieID`, `uid`, `first`, `second`, `expire`) VALUES
(14, 7, '0a3c7586d98550134767518d1cf318e83b5e6effeccd231209751183707ccf87c01e58f29f2182a1d3d17607800dfb254dcca1762fea751544a14a1e5048c167', '351ae4efeabf4c795a2e7275888c0a97da8c4bb9dda4e030c423d6df2714a22c38b6153d0c8917b829a5662861bdf5e7c98d71d8bf0c7bd755dc2467e433c2673fafd39a9730f2c558c59fdd143aced024454d6f6244bd733a0d0e6a6ef7fbdd90c4cb3ea890883bce79242660fa224fe80c10400eba25b09210c8e7b3cbea26', '2017-02-15 20:24:56'),
(15, 8, '3095ccc914b0b07befe7f3ad8a685277598e48f625622eee8eff1bb1121b483b22c5e4c4c1b355aea9d7989607df67f39a5930690a171b3e71fc36be8532f25c', '313396eae81179ed65c57a10bf47ebba3341a7b7d298a3745fd41ec21fd78de94d85524952a121c927aa90c9cf87e5692f5a5f52f2e29e256646cbbdd090ddc23cb5ac57ab041f08a4bd866031e024553929f67a4884049ecb5ccecfd9efba603d15a55bbe1a50ee181042317f7865aeaf4ccff2e2bf4f41c90812337bdc3371', '2017-02-15 20:50:35'),
(16, 9, '6d7734fa4f5f881fd67e1dca3d6c469b6150603f1a8cdb26e830cf2db70fcbb31c82cf60e0014a1f0a71f6510388c8cae15fde0a49805446e31c03828cabc7be', '992d3e67f951ea82e7d477a6357efee4c46e0f1b3f7aad84362c451a6309e812c7e2d93fdc66347ba325a32d5903fd0e0ce736634cacdd6a92b4e6d8bae198b5267b9a9b07fa5ada2df8fb9407f91bedc37b62d279f08ca90e5ee45c25f8c6c2044204a23f5b1108a52e1db6ec7efb90f1ec47930a4d12bfda9d6b37c64011ba', '2017-02-15 20:52:26'),
(17, 10, 'ab767a9d20d758bfc7f2e117ee6515e2451afb28caf332b78410619ec01c791b9fb18c002101379920e6b55342d0232a4f1434bd937df859b2a780585b5d65a9', '30aa59be2052278f26b3054219c5922b29e33d1c86f76e419f6b45b20123eab63431dc41441c7686f46c14b1f51486524eaf86d62b09f54fe4d3796bbc84ea262eb743527e43ccccc41119422c18a39d884fda0cfd6148477cfd580ba7dfea9f932b0ed3b0dfd7f48023137f3b78e403ae825adab30758694768eff0b422988d', '2017-02-15 20:55:39'),
(18, 7, 'cdcbaf1497c46ab7c0b42c59a337b38810367fab00a67e6235a3345a7bab937befe16eef86c728645fce435297d3b1006a8e60f36d017304a8b20f9f37809055', '2a890a17bd22cf468266183229daab35cd370a9f99c5b4d58b14bc146f53343f56e303fa249e13140f28a7521324ceb159f7de7cf082ae895bc571b50c748fbce47f1c202f3b9cf0ac7e59dad55b87d24c346871d31684abe0ba8e60d9f5f8e49ff1c5572d20a8db0b38efecab5c5acba2207ac474064a8b1740cfb1b8479357', '2017-02-15 21:20:16'),
(19, 11, 'ec5bc71509222ec240e15436f9322a11564888dbc5b2909499f88cbbc2040f4fc1a67dac290c87b0f373eb05865e4fa13535a137828962d52a58d9709303ca71', 'f7d3cccb310a29d4590cb878999e8c0d9ffceba7ec492053b26f86cdabb74f6c3e3433ce1c97d628b94d328c5a9b8e33ed94b1c110442d5b5ee61ee56d0e70dc5f41e3c3f88f3623f811e368379a05fc6aef12deabef9ee81a9338ce91973b0accaaa583c4f8d9da24afcf35a0e1672040808e521152c82df9563d0049048dc1', '2017-02-16 08:56:24');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `uid` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `bio` mediumtext,
  `avatarID` varchar(100) DEFAULT NULL,
  `avatarImageType` varchar(4) DEFAULT NULL,
  `votedOn` varchar(1000) NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `bio`, `avatarID`, `avatarImageType`, `votedOn`) VALUES
(7, 'Lars Kajes', 'lars@kajes.se', '$2y$10$FunNZtoKnRNpWNUoRt.vA.pApvvjfBNR7eRxJlcOYgblYT6lYgl02', NULL, NULL, NULL, '[22,29]'),
(8, 'Rakel Karlsson', 'rakel@karlsson.se', '$2y$10$GrhvtJCOv9Nf3u9lfFAGD.x7zD4YI4vkcZQkMGONXsjQYxTqM6QD.', NULL, NULL, NULL, '[22]'),
(9, 'Emmali Jansson', 'emmali@jansson.se', '$2y$10$v6ewImMD2pK8MvzQ8fonmOoxB3NikGTsEwpnGyXTHRwjEJyqHRqsW', NULL, '9', 'jpg', '[22,30]'),
(10, 'Jeb Kerman', 'jeb@kerman.se', '$2y$10$MG0qpsBFBeXnFZWeWeqJCObgHmMKH9VDCu31E8WY/wrhVF4sftpmO', NULL, NULL, NULL, '[26,33,23]'),
(11, 'Bill Kerman', 'bill@kerman.se', '$2y$10$azydPgDmndS/F6M41BKy1.h999B5wwOpIfaJpDTQ3dgU0VBpjJVsC', NULL, NULL, NULL, '[25,23]'),
(12, 'Valentina Kerman', 'valentina@kerman.se', '$2y$10$PZfBxwMpm7wCl0py7CqHx.57r1FekaUKJoOgIjy9Ij3euJHwJgF/G', NULL, NULL, NULL, '[26]');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `authorID` (`authorID`);

--
-- Index för tabell `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`cookieID`),
  ADD KEY `uid` (`uid`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT för tabell `tokens`
--
ALTER TABLE `tokens`
  MODIFY `cookieID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`authorID`) REFERENCES `users` (`uid`);

--
-- Restriktioner för tabell `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
