--
-- Database: `pariwisata`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` char(20) NOT NULL,
  `jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `jenis`) VALUES
('K1', 'Perkotaan'),
('L1', 'Laut');

-- --------------------------------------------------------

--
-- Table structure for table `pariwisata`
--

CREATE TABLE `pariwisata` (
  `id` char(20) NOT NULL,
  `id_kategori` char(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `tiket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pariwisata`
--

INSERT INTO `pariwisata` (`id`, `id_kategori`, `nama`, `lokasi`, `deskripsi`, `tiket`) VALUES
('P1', 'L1', 'Tanjung Kodok', 'Lamongan', 'Good', '120000'),
('P2', 'L1', 'Taman Nasional Bunaken', 'Sulawesi Utara', 'Pemandangan yang indah', '50000'),
('P3', 'L1', 'Kepulauan Wakatobi', 'Sulawesi Tengah', 'Fantastic', '120000'),
('P4', 'K1', 'Gunung Arjuno', 'Jawa Timur', 'Pemandangan yang indah', '5000'),
('P5', 'K1', 'Puncak Wijaya', 'Papua', 'Has the best sunrise', '500000'),
('P8', 'K1', 'Tanjung Kodok', 'Lamongan', 'Good', '120000'),
('PA1', 'L1', 'Busan Beach', 'Lamongan', 'Pengen kesini', '120000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` char(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status_user` varchar(20) NOT NULL,
  `photo_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `nama`, `password`, `status_user`, `photo_id`) VALUES
('US1', 'trieendah', 'Trie Endah', 'coba', 'admin', 'upload/US1.png'),
('US10', 'rose', 'Chaeyoung', 'user', 'user', 'upload/US10.png'),
('US11', 'jennie', 'Jennie', 'user', 'user', 'upload/US11.png'),
('US12', 'lisa', 'Lalise', 'user', 'user', 'upload/US12.png'),
('US13', 'jisoo', 'Jisoo', 'user', 'user', 'upload/US13.png'),
('US14', 'wendy', 'Seungwan', 'admin', 'admin', 'upload/US14.png'),
('US15', 'gom', 'Seulgi', 'admin', 'admin', 'upload/US15.png'),
('US16', 'irene', 'Joohyun', 'admin', 'admin', 'upload/US16.png'),
('US17', 'joy', 'Sooyoung', 'user', 'user', 'upload/US17.png'),
('US18', 'yeri', 'Yerim', 'user', 'user', 'upload/US18.png'),
('US19', 'jennie', 'Jennie', 'admin', 'admin', 'upload/US19.png'),
('US2', 'akbar', 'Akbar Barokah', 'coba', 'user', ''),
('US20', 'wendy', 'Seungwan', 'admin', 'admin', ''),
('US21', 'yeri', 'Yerim', 'admin', 'admin', 'upload/US21.png'),
('US22', 'yeri', 'Yerim', 'admin', 'admin', 'upload/US22.png'),
('US23', 'gom', 'Seulgi', 'user', 'user', 'upload/US23.png'),
('US24', 'eh', 'wh', 'user', 'user', 'upload/US24.png'),
('US26', 'GH', 'VBH', 'user', 'user', 'upload/US26.png'),
('US3', 'faza', 'Istaghna Faza', 'coba', 'user', ''),
('US4', 'wendy', 'Seungwan', 'user', 'user', ''),
('US5', 'wendy', 'Seungwan', 'user', 'user', 'upload/US5.png'),
('US6', 'joy', 'Sooyoung', 'user', 'user', ''),
('US7', 'gom', 'Seulgi', 'user', 'user', 'upload/US7.png'),
('US8', 'irene', 'Joohyun', 'user', 'user', 'upload/US8.png'),
('US9', 'yeri', 'Yerim', 'user', 'user', 'upload/US9.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pariwisata`
--
ALTER TABLE `pariwisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pariwisata`
--
ALTER TABLE `pariwisata`
  ADD CONSTRAINT `pariwisata_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
