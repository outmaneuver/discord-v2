-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Okt 2024 pada 02.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `discord`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `server_uuid` char(36) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `file` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `servers`
--

CREATE TABLE `servers` (
  `server_id` int(11) NOT NULL,
  `server_uuid` char(36) NOT NULL DEFAULT uuid(),
  `created_by` int(11) DEFAULT NULL,
  `server_name` varchar(100) DEFAULT NULL,
  `server_description` varchar(100) DEFAULT NULL,
  `server_visibility` varchar(10) DEFAULT NULL,
  `created_at` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `servers`
--

INSERT INTO `servers` (`server_id`, `server_uuid`, `created_by`, `server_name`, `server_description`, `server_visibility`, `created_at`) VALUES
(19, '611cdd04-4bd3-4129-b59d-a6286403b250', 11, 'maru', 'memebotak', 'private', '17/10/2024'),
(20, '87266718-c753-45e2-83fc-f73e09e7977b', 11, 'MASAK MASAK', '', 'public', '17/10/2024'),
(21, '039c25fc-fc77-4463-a56b-a6410320aa3c', 12, 'san anjay', '', 'private', '17/10/2024'),
(22, 'b0308653-9ff4-4073-8766-164b8f89f345', 12, 'gg', '', 'public', '17/10/2024'),
(24, 'e2055c4a-4073-420d-beb8-59774ecd8e51', NULL, 'testing\'s private server-8060', '', 'private', '22/10/2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `server_code`
--

CREATE TABLE `server_code` (
  `id` int(11) NOT NULL,
  `server_uuid` char(36) NOT NULL,
  `code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `server_code`
--

INSERT INTO `server_code` (`id`, `server_uuid`, `code`) VALUES
(32, '611cdd04-4bd3-4129-b59d-a6286403b250', 46871),
(33, '87266718-c753-45e2-83fc-f73e09e7977b', 14045),
(34, '039c25fc-fc77-4463-a56b-a6410320aa3c', 32432),
(35, 'b0308653-9ff4-4073-8766-164b8f89f345', 49776),
(37, 'e2055c4a-4073-420d-beb8-59774ecd8e51', 45080);

-- --------------------------------------------------------

--
-- Struktur dari tabel `server_join_requests`
--

CREATE TABLE `server_join_requests` (
  `id` int(11) NOT NULL,
  `server_uuid` char(36) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `server_link`
--

CREATE TABLE `server_link` (
  `id` int(11) NOT NULL,
  `server_uuid` char(36) NOT NULL,
  `link` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `server_link`
--

INSERT INTO `server_link` (`id`, `server_uuid`, `link`) VALUES
(117, '611cdd04-4bd3-4129-b59d-a6286403b250', '3EF2AEC0'),
(118, '87266718-c753-45e2-83fc-f73e09e7977b', '38E7ACCA'),
(119, '039c25fc-fc77-4463-a56b-a6410320aa3c', '61736D29'),
(120, 'b0308653-9ff4-4073-8766-164b8f89f345', 'E6EF7A47'),
(122, 'e2055c4a-4073-420d-beb8-59774ecd8e51', 'BB05403A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `server_members`
--

CREATE TABLE `server_members` (
  `id` int(11) NOT NULL,
  `server_uuid` char(36) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `server_members`
--

INSERT INTO `server_members` (`id`, `server_uuid`, `member_id`, `is_admin`) VALUES
(111, '611cdd04-4bd3-4129-b59d-a6286403b250', 11, 1),
(112, '87266718-c753-45e2-83fc-f73e09e7977b', 11, 1),
(113, '039c25fc-fc77-4463-a56b-a6410320aa3c', 12, 1),
(114, 'b0308653-9ff4-4073-8766-164b8f89f345', 12, 1),
(116, 'b0308653-9ff4-4073-8766-164b8f89f345', 13, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(11, 'memebotak', '$2y$10$XY.i7SGgbpx2EJql8HLL3OlpbeOkcHMidQjjoI1Z22q1HZBDw3Kjm'),
(12, 'san', '$2y$10$IFUkbKb1oq96J7qfBrgy9.eca0./ytkujJqJM6yCLRVeSiaO77seW'),
(13, 'Edward Snowden', '$2y$10$TD2rwgesxYwCvfnp6UJZR.y1g2LPqiB0BOWqHy02B8oZj8LHbk0va');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `server_uuid` (`server_uuid`);

--
-- Indeks untuk tabel `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`server_id`),
  ADD UNIQUE KEY `server_uuid` (`server_uuid`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `server_code`
--
ALTER TABLE `server_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_uuid` (`server_uuid`);

--
-- Indeks untuk tabel `server_join_requests`
--
ALTER TABLE `server_join_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `server_uuid` (`server_uuid`);

--
-- Indeks untuk tabel `server_link`
--
ALTER TABLE `server_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_uuid` (`server_uuid`);

--
-- Indeks untuk tabel `server_members`
--
ALTER TABLE `server_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`member_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `server_uuid` (`server_uuid`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `servers`
--
ALTER TABLE `servers`
  MODIFY `server_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `server_code`
--
ALTER TABLE `server_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `server_join_requests`
--
ALTER TABLE `server_join_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `server_link`
--
ALTER TABLE `server_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT untuk tabel `server_members`
--
ALTER TABLE `server_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`server_uuid`) REFERENCES `servers` (`server_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `servers`
--
ALTER TABLE `servers`
  ADD CONSTRAINT `servers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `server_code`
--
ALTER TABLE `server_code`
  ADD CONSTRAINT `server_code_ibfk_1` FOREIGN KEY (`server_uuid`) REFERENCES `servers` (`server_uuid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `server_join_requests`
--
ALTER TABLE `server_join_requests`
  ADD CONSTRAINT `server_join_requests_ibfk_1` FOREIGN KEY (`server_uuid`) REFERENCES `servers` (`server_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `server_join_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `server_link`
--
ALTER TABLE `server_link`
  ADD CONSTRAINT `server_link_ibfk_1` FOREIGN KEY (`server_uuid`) REFERENCES `servers` (`server_uuid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `server_members`
--
ALTER TABLE `server_members`
  ADD CONSTRAINT `server_members_ibfk_1` FOREIGN KEY (`server_uuid`) REFERENCES `servers` (`server_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `server_members_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
