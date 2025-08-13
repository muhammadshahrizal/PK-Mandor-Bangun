-- Menambahkan perintah untuk menghapus tabel lama secara otomatis
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `portfolio`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `settings`;

--
-- Struktur tabel baru untuk `admins`
--
CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--
INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$YBGuqj8hHmEdFp3V3Z5bWu/PaQIZaz/Jp5n2RZ3YHSUuoTmby251C');

--
-- Struktur tabel baru untuk `portfolio`
--
CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `order_num` int(11) DEFAULT 99,
  `service_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Memasukkan data awal portofolio dengan `service_id`
--
INSERT INTO `portfolio` (`id`, `title`, `image_path`, `order_num`, `service_id`) VALUES
(1, 'Rumah Modern Kontemporer', 'assets/images/Img1.png', 10, 1),
(2, 'Rumah Modern Minimalist', 'assets/images/Img2.jpg', 20, 1),
(3, 'Rumah Model Tropical', 'assets/images/Img3.png', 30, 2),
(4, 'Interior Kitchen', 'assets/images/Img4.jpg', 40, 3),
(5, 'Interior Living Room', 'assets/images/Img5.jpg', 50, 3),
(6, 'Area Tangga', 'assets/images/Img6.png', 60, 2);

--
-- Struktur tabel baru untuk `services`
--
CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(50) NOT NULL,
  `order_num` int(11) DEFAULT 99
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--
INSERT INTO `services` (`id`, `title`, `description`, `icon_class`, `order_num`) VALUES
(1, 'Pembangunan Baru', 'Membangun rumah, ruko, dan gedung dari nol...', 'fa-solid fa-building', 10),
(2, 'Renovasi & Perbaikan', 'Memperbarui dan meningkatkan kualitas bangunan...', 'fa-solid fa-house-chimney-window', 20),
(3, 'Desain Arsitektur', 'Menyediakan jasa desain arsitektur dan interior...', 'fa-solid fa-compass-drafting', 30);

--
-- Struktur tabel baru untuk `settings`
--
CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('contact_address', 'Ruko Bukit Emerald Jaya, Blok C No. 50...'),
('contact_email', 'mandorbangun.id23@gmail.com'),
('contact_phone', '08152318805');

--
-- Struktur tabel baru untuk `gallery`
--
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `order_num` int(11) NOT NULL DEFAULT 99
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery` (contoh data awal)
--
INSERT INTO `gallery` (`id`, `image_path`, `title`, `order_num`) VALUES
(1, 'assets/images/gallery/story 01.png', 'Konsultasi', 10),
(2, 'assets/images/gallery/story 02.png', 'Survei', 20),
(3, 'assets/images/gallery/story 03.png', 'Perancanaan', 30),
(4, 'assets/images/gallery/story 04.png', 'Akad Pelaksanaan', 40),
(5, 'assets/images/gallery/story 05.png', 'Suervei Pra Pelaksanaan', 50),
(6, 'assets/images/gallery/story 06.png', 'Pelaksanaan', 60),
(7, 'assets/images/gallery/story 07.png', 'Cek List B.A.S.T', 70),
(8, 'assets/images/gallery/story 08.png', 'BAST (Berita Acara Serah Terima)', 80);

--
-- Indexes for dumped tables
--
ALTER TABLE `admins` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);
ALTER TABLE `portfolio` ADD PRIMARY KEY (`id`);
ALTER TABLE `services` ADD PRIMARY KEY (`id`);
ALTER TABLE `settings` ADD PRIMARY KEY (`setting_key`);
ALTER TABLE `gallery` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
ALTER TABLE `admins` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `portfolio` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `services` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `gallery` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;
