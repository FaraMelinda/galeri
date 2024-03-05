-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Mar 2024 pada 19.57
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galeri`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `albums`
--

INSERT INTO `albums` (`album_id`, `user_id`, `title`, `description`, `created_at`) VALUES
(50, 15, 'Lorem ipsum', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', '2024-02-04 14:59:26'),
(51, 15, 'Dolor sit', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', '2024-02-04 14:59:44'),
(52, 15, 'Amet consectetur', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', '2024-02-04 14:59:56'),
(53, 15, 'Adipisicing elit', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', '2024-02-04 15:00:09'),
(54, 15, 'Rerum nam', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', '2024-02-04 15:00:22'),
(55, 16, 'culpa quae', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, atque et repellat fugiat magni recusandae commodi autem aspernatur, accusantium fugit ea eum ipsum quia exercitationem, culpa quae totam accusamus numquam.', '2024-02-04 15:12:07'),
(56, 14, 'consectetur', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus sit suscipit iste eaque debitis mollitia officiis architecto aut velit saepe natus sunt neque, adipisci accusantium eum quam maxime tempore praesentium!', '2024-03-03 18:23:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `photo_id`, `comment_text`, `created_at`) VALUES
(7, 16, 47, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Error ipsum minus eveniet rerum optio quod itaque laborum molestiae! At, accusantium magnam. Praesentium eaque minus ab.', '2024-02-04 15:17:42'),
(8, 16, 49, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio alias nemo aliquam repellendus repellat adipisci amet odit. Odio, quae ex.', '2024-02-04 15:17:57'),
(9, 15, 47, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis, sequi.', '2024-02-04 15:18:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `photo_id`, `created_at`) VALUES
(9, 16, 47, '2024-02-04 15:17:05'),
(10, 16, 49, '2024-02-04 15:17:13'),
(11, 15, 47, '2024-02-04 15:18:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `photos`
--

INSERT INTO `photos` (`photo_id`, `user_id`, `album_id`, `title`, `description`, `image_path`, `created_at`) VALUES
(47, 15, 50, 'Exercitationem dignissimos', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/50/65bfa6a9651d8.jpg', '2024-02-04 15:00:57'),
(48, 15, 51, 'Accusamus ratione', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/51/65bfa6c2a973b.jpg', '2024-02-04 15:05:29'),
(49, 15, 52, 'Laboriosam amet', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/52/65bfa70696496.jpg', '2024-02-04 15:02:30'),
(50, 15, 53, 'Voluptate ullam', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/53/65bfa71d45428.jpg', '2024-02-04 15:02:53'),
(51, 15, 54, 'Veniam odio', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/54/65bfa73d4ff9b.jpg', '2024-02-04 15:05:40'),
(52, 15, 50, 'Similique sapiente', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/50/65bfa808b8f33.jpg', '2024-02-04 15:06:48'),
(53, 15, 51, 'Impedit pariatur', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/51/65bfa82ac9310.jpg', '2024-02-04 15:07:22'),
(54, 15, 51, 'Placeat totam', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/51/65bfa858022c8.jpg', '2024-02-04 15:08:08'),
(55, 15, 50, 'Corrupti aliquam', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nam exercitationem dignissimos debitis, accusamus ratione laboriosam amet voluptate ullam veniam odio similique sapiente, impedit pariatur placeat totam corrupti aliquam labore!', 'uploads/50/65bfa8779094d.jpg', '2024-02-04 15:08:39'),
(56, 16, 55, 'Fugiat magni', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, atque et repellat fugiat magni recusandae commodi autem aspernatur, accusantium fugit ea eum ipsum quia exercitationem, culpa quae totam accusamus numquam.', 'uploads/55/65bfa95f7ea01.jpg', '2024-02-04 15:12:31'),
(57, 16, 55, 'Sit amet', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, atque et repellat fugiat magni recusandae commodi autem aspernatur, accusantium fugit ea eum ipsum quia exercitationem, culpa quae totam accusamus numquam.', 'uploads/55/65bfa99720b4b.jpg', '2024-02-04 15:13:27'),
(58, 14, 56, 'adipisci accusantium', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus sit suscipit iste eaque debitis mollitia officiis architecto aut velit saepe natus sunt neque, adipisci accusantium eum quam maxime tempore praesentium!', 'uploads/56/65e4c0378799b.jpg', '2024-03-03 18:23:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `access_level` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `email`, `access_level`, `created_at`) VALUES
(14, 'Admin', 'admin', '$2y$10$JXl/lz.xsE.LI/EJsvjhmu5Kpl6aK7amqtr5opdSA0pYPM30z9wxa', 'admin@coba.com', 'admin', '2024-02-04 13:38:31'),
(15, 'User 1', 'user1', '$2y$10$huQ.aW6zgSQgAkLOgrWIfuD0WEKdmE2HcYowZkKMQLaJqmp3cmgwi', 'user1@coba.com', 'user', '2024-02-04 13:38:09'),
(16, 'User 2', 'user2', '$2y$10$D4BXyXTQEyWYxnyMo.CTteH3n4CwaZpAuGp6Q.27bK8NKcVus2jom', 'user2@coba.com', 'user', '2024-02-04 15:16:51'),
(17, 'faramelinda', 'faracntiqq', '$2y$10$VMGgbgruo6y7VB5SIW.nmuKyvrESuzXZckGDtI6CVY4GWV3HwI/hm', 'faracntiqq22@gmail.com', 'user', '2024-02-21 01:13:05');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indeks untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indeks untuk tabel `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
