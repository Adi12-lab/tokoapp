-- MariaDB dump 10.19  Distrib 10.10.2-MariaDB, for Android (aarch64)
--
-- Host: localhost    Database: toko
-- ------------------------------------------------------
-- Server version	10.10.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(5,'2014_10_12_000000_create_users_table',1),
(6,'2014_10_12_100000_create_password_resets_table',1),
(7,'2019_08_19_000000_create_failed_jobs_table',1),
(8,'2019_12_14_000001_create_personal_access_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_gallery`
--

DROP TABLE IF EXISTS `product_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `jenis` varchar(55) NOT NULL,
  `gambar` varchar(225) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_gallery`
--

LOCK TABLES `product_gallery` WRITE;
/*!40000 ALTER TABLE `product_gallery` DISABLE KEYS */;
INSERT INTO `product_gallery` VALUES
(1,1,'carousel','alquranBiru.jpg','Biru'),
(2,1,'carousel','alquranUngu.jpg','Ungu'),
(3,1,'carousel','alquranCokelat.jpg','Cokelat'),
(4,1,'carousel','alquranMerah.jpg','Merah'),
(5,1,'carousel','alquranTosca.jpg','Tosca'),
(6,1,'carousel','alquranHitam.jpg','Hitam'),
(7,1,'carousel','alquranPutih.jpg','Putih'),
(8,1,'carousel','alquranHijau.jpg','Hijau'),
(9,1,'carousel','alquranPink.jpg','Pink'),
(10,1,'carousel','alquranKuning.jpg','Kuning');
/*!40000 ALTER TABLE `product_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kelompok` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `slug` varchar(50) NOT NULL,
  `gambar` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(3) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,'alquran','Al-Quran Terjemah Per-kata','alquran-perkata','Ahai','<div>Merupakan Mushaf yang dilengkapi dengan fitur terjemah per-kata yang memudahkan pengguna untuk lebih memahami makna kata yang terkandung dalam setiap ayat.</div>',200,'<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis hic amet saepe, iste voluptate fugiat in odit illo ullam, quod sint alias ex quidem dolorem provident facere sit aut soluta tempora, dolor ipsum sapiente aspernatur. Distinctio, nobis, ex. Ex accusantium ipsa vitae asperiores libero. Quam praesentium, similique quia consectetur reprehenderit dolor velit. Atque repudiandae dolor, molestias veritatis! Quisquam nisi iure nobis dolorem quod ad inventore harum quae, numquam vel.&nbsp;<br><br>Autem quam ea expedita placeat officia obcaecati deleniti nobis ipsa asperiores, et nemo, mollitia odio dicta voluptatem explicabo. Sequi non cupiditate quod id iste, consequatur rem eos vel beatae corrupti? Praesentium dicta unde odio sunt. Doloribus facere quis repellat quia ad, nihil ex delectus. Porro non quos, quidem necessitatibus cupiditate officiis magnam hic, voluptatem numquam officia ex laudantium incidunt fuga, quia eius id possimus quod. Eligendi quod in odio illum ea illo dolorum omnis nulla libero, necessitatibus laborum quaerat eos possimus natus quo quidem, nostrum atque architecto. Vel laudantium ipsum nisi fugit cupiditate fuga suscipit est, vitae tempora dolore cumque facilis minus ut hic quaerat corrupti iure commodi reiciendis magnam illo non. Ab pariatur optio praesentium sint ratione illo delectus aliquam eius eaque animi dolorem cum accusantium error quibusdam corporis earum a ducimus veritatis libero dolor, numquam aperiam minima aut illum. Saepe amet nihil laborum porro illo aliquam ex nesciunt excepturi, ipsam, iusto cupiditate vero, fugit aut consectetur labore sit cum velit voluptatem cumque! Dolor.</div>','2023-02-11 10:31:43','2023-02-14 05:02:32'),
(2,'alquran','Al-Quran Hafazan Reguler','alquran-hafazan','63ad6f6254ee6.jpg','Merupakan Mushaf dengan desain tampilan\r\nlembaran ayat yang lebih simple &amp; fokus\r\npada bacaan Al-Quran, yang akan membuat\r\npengguna lebih nyaman &amp; mudah dalam\r\nmenghafal Al-Quran.',300,NULL,'2023-02-11 10:31:43','2023-02-11 17:33:56'),
(3,'alquran','Al-Quran Junior Edition','alquran-junior','63ad638a1ae06.jpg','Merupakan Mushaf dengan desain Full Color bertema anak-anak, sehingga terlihat lebih menarik &amp; membuat anak menjadi lebih bersemangat dalam mempelajari &amp; membaca Al-Qurï¿½an.',240,NULL,'2023-02-11 10:31:43','2023-02-11 17:33:56'),
(4,'alquran','Al-Quran Nature Edition','alquran-nature','Ahai','&lt;div&gt;Merupakan Mushaf dengan desain ekslusif bertema alam. Desain Alam yang terdapat pada Mushaf Al-Quran King Salman - Nature Edition ini, juga terdapat pada Produk Premium Pocket Sajadah King Salman - Nature Edition, sehingga Anda pun dapat melakukan pemesanan kedua produk ini dengan desain yang sama.&lt;/div&gt;',120,'&lt;div&gt;&amp;lt;h1&amp;gt;Test&amp;lt;/h1&amp;gt;&lt;/div&gt;','2023-02-11 10:31:43','2023-02-11 15:14:16'),
(5,'alquran','Al-Quran Hafazan Per-Juz','alquran-perjuz','63ad63bd07c5b.jpg','Merupakan Mushaf dengan fitur terjemah per kata dan bacaan transliterasi latin yang terdiri dari 30 jilid juz Al-Qurï¿½an yang Setiap Juznya terdapat masing-masing 1 jilid.',97,NULL,'2023-02-11 10:31:43','2023-02-11 17:33:56'),
(7,'alquran','Al-Quran Transliterasi Latin','alquran-transliterasi','63ad7353c0704.jpg','Al-Qur&#039;an Transliterasi King Salman didesain khusus, dilengkapi bacaan transliterasi latin untuk memudahkan penggunanya dalam membaca Al-Quran',365,NULL,'2023-02-11 10:31:43','2023-02-11 17:33:56'),
(23,'Jajaaj','Hdhdjdj','Test-adi','Ahai','&lt;div&gt;Dbsjmdmdmdd&lt;br&gt;Dkdkdmd&lt;br&gt;Udjsjsj&lt;/div&gt;',8283,'&lt;div&gt;Hdhdneneddd&lt;br&gt;Jdjdjeen&lt;/div&gt;','2023-02-13 06:55:40','2023-02-13 13:55:40'),
(24,'Nznzns','Kwksksksllssl','Test-adihh','Ahai','&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio amet delectus provident ullam impedit, ipsa inventore ab sed, consequatur recusandae neque repellat fuga aspernatur beatae necessitatibus quia maxime officiis aliquid labore non sit? Excepturi provident non similique quo quisquam eos, a aperiam architecto. Labore necessitatibus, harum maxime soluta commodi veritatis ut similique blanditiis quaerat molestias magnam, sequi, nobis iusto. Fuga sint quibusdam facilis ipsam vel nostrum hic, aliquid suscipit.&amp;nbsp;&lt;/div&gt;',727227,'&lt;div&gt;Quo dolorem autem, sit quasi numquam adipisci tenetur delectus assumenda architecto debitis impedit commodi nisi fugiat saepe eum maxime ipsa voluptatum, ex quos molestias culpa! Enim iste magni inventore rerum, voluptates debitis blanditiis exercitationem officia laudantium qui quod doloribus nisi numquam eum atque saepe repellat quaerat veritatis ipsum tenetur officiis. Accusamus voluptas deserunt possimus voluptates eos sequi quas cum quidem ipsum, id similique praesentium, ipsam iste itaque magni dicta. Repellat modi rerum similique earum vitae dolores, pariatur in nostrum deserunt, suscipit quo possimus facere delectus incidunt error! Perferendis sapiente molestiae eum molestias nostrum ea, earum non veritatis eligendi animi voluptatum aliquid beatae sequi veniam, in, rem quaerat vitae ut similique voluptate.&amp;nbsp;&lt;br&gt;Ullam minus accusantium eius aspernatur voluptates aliquam cupiditate, facilis ea saepe libero corrupti nesciunt iste dolore reiciendis sunt? Sed aspernatur, inventore, tempora aliquam nihil eveniet perferendis voluptate ab aperiam voluptas pariatur quibusdam iusto eligendi reprehenderit perspiciatis facilis quia hic at nesciunt eum in corporis, error temporibus! A minima est excepturi odit non, incidunt, facere alias ratione nisi delectus reiciendis expedita, aliquid cumque magnam quidem ex numquam, animi eius quam? Doloribus reprehenderit dolorem possimus iure culpa dolor ab rerum, eius illum nesciunt adipisci minus, ratione est facilis natus aperiam totam inventore velit nobis quo. Quis, libero, expedita! Nisi odio vel fugiat excepturi repudiandae, error consequuntur hic? Officiis voluptas expedita perspiciatis quo, saepe, fuga aperiam ex enim ratione veritatis, qui. Cum saepe distinctio obcaecati, quia provident placeat magnam veniam corporis culpa eos. Consequatur, nulla perferendis minima laudantium, error non expedita quaerat totam, provident esse et nostrum perspiciatis. Explicabo id itaque saepe maxime officia voluptatem at, odio dicta, quis delectus accusamus expedita rem suscipit distinctio alias repellat! Soluta doloribus, quis natus, animi mollitia cumque repellat qui quibusdam non reprehenderit eligendi ab maiores. Adipisci qui, quo voluptatem tempore sit veritatis amet ea sunt provident ex aut perferendis voluptatum fuga blanditiis. Ullam quia libero fugit ducimus impedit temporibus, voluptatum quidem consequatur. Natus repellat quidem, vero nobis veritatis, aut, a rerum, aspernatur ea tempore placeat velit?&lt;/div&gt;','2023-02-17 23:16:54','2023-02-18 06:16:54');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `old_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizes`
--

LOCK TABLES `sizes` WRITE;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` VALUES
(1,1,'A5',120000,125000),
(2,1,'A4',174000,178000),
(4,7,'A5',2000,NULL),
(5,2,'A5',120000,125000),
(8,23,'sjjssnsn',1500,3000),
(9,23,'Jdjdjd',20000,80000),
(10,23,'Andaii',25,125),
(11,24,NULL,19202100,NULL);
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'grimjow','$2y$10$P7k1iERdMuxx4butacA1QeZ.pSWLE17fUX5vgX8D/RHN5R/VkIEFe',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variants`
--

LOCK TABLES `variants` WRITE;
/*!40000 ALTER TABLE `variants` DISABLE KEYS */;
INSERT INTO `variants` VALUES
(1,1,'Biru'),
(2,1,'Ungu'),
(3,1,'Cokelat'),
(4,1,'Merah'),
(5,1,'Tosca'),
(6,1,'Hitam'),
(7,1,'Putih'),
(8,1,'Hijau'),
(9,1,'Pink'),
(10,1,'Kuning');
/*!40000 ALTER TABLE `variants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-20 10:59:33
