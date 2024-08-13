DROP TABLE IF EXISTS `tbl_appconfig`;
CREATE TABLE `tbl_appconfig` (
  `id` int(11) NOT NULL,
  `setting` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_bandwidth`;
CREATE TABLE `tbl_bandwidth` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_bw` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rate_down` int(10) UNSIGNED NOT NULL,
  `rate_down_unit` enum('Kbps','Mbps') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rate_up` int(10) UNSIGNED NOT NULL,
  `rate_up_unit` enum('Kbps','Mbps') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_customers`;
CREATE TABLE `tbl_customers` (
  `id` int(10) NOT NULL,
  `username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pppoe_password` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1' COMMENT 'For PPPOE Login',
  `fullname` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `phonenumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `email` varchar(128) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `coordinates` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Latitude and Longitude coordinates',
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'For Money Deposit',
  `service_type` ENUM('Hotspot','PPPoE','Static','Others') DEFAULT 'Others' COMMENT 'For selecting user type',
  `auto_renewal` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Auto renewall using balance',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `router_id` int(10) DEFAULT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



DROP TABLE IF EXISTS `tbl_logs`;
CREATE TABLE `tbl_logs` (
  `id` int(10) NOT NULL,
  `date` datetime DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userid` int(10) NOT NULL,
  `ip` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_message`;
CREATE TABLE `tbl_message` (
  `id` int(10) NOT NULL,
  `from_user` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `to_user` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_payment_gateway`;
CREATE TABLE `tbl_payment_gateway` (
  `id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `gateway` varchar(32) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'xendit | midtrans',
  `gateway_trx_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
 `checkout` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'n/a',
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `routers_id` int(11) NOT NULL,
  `routers` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `pg_url_payment` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `payment_method` varchar(32) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `payment_channel` varchar(32) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `pg_request` text COLLATE utf8mb4_general_ci,
  `pg_paid_response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `expired_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 unpaid 2 paid 3 failed 4 canceled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_plans`;
CREATE TABLE `tbl_plans` (
  `id` int(10) NOT NULL,
  `name_plan` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_bw` int(10) NOT NULL,
  `price` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('Hotspot','PPPOE','Balance','Static') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `typebp` enum('Unlimited','Limited') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `limit_type` enum('Time_Limit','Data_Limit','Both_Limit') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time_limit` int(10) UNSIGNED DEFAULT NULL,
  `time_unit` enum('Mins','Hrs') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_limit` int(10) UNSIGNED DEFAULT NULL,
  `data_unit` enum('MB','GB') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `validity` int(10) NOT NULL,
  `validity_unit` enum('Mins','Hrs','Days','Months') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `shared_users` int(10) DEFAULT NULL,
  `routers` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_radius` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 is radius',
  `pool` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pool_expired` varchar(40) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 disabled',
  `allow_purchase` enum('yes','no') DEFAULT 'yes' COMMENT 'allow to show package in buy package page'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_pool`;
CREATE TABLE `tbl_pool` (
  `id` int(10) NOT NULL,
  `pool_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `range_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `routers` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_routers`;
CREATE TABLE `tbl_routers` (
  `id` int(10) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 disabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `tbl_static`
--
DROP TABLE IF EXISTS `tbl_static`;
CREATE TABLE `tbl_static` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `ip_range` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
DROP TABLE IF EXISTS `tbl_banks`;
CREATE TABLE `tbl_banks` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `paybill` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS `tbl_transactions`;
CREATE TABLE `tbl_transactions` (
  `id` int(10) NOT NULL,
  `invoice` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `plan_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recharged_on` date NOT NULL,
  `recharged_time` time NOT NULL DEFAULT '00:00:00',
  `expiration` date NOT NULL,
  `time` time NOT NULL,
  `method` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `routers` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('Hotspot','PPPOE','Balance','Static') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `fullname` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_type` enum('SuperAdmin','Admin','Report','Agent','Sales') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Active',
  `last_login` datetime DEFAULT NULL,
  `creationdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_user_recharges`;
CREATE TABLE `tbl_user_recharges` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `plan_id` int(10) NOT NULL,
  `namebp` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recharged_on` date NOT NULL,
  `recharged_time` time NOT NULL DEFAULT '00:00:00',
  `expiration` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `method` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `routers` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_router_cache`;
CREATE TABLE `tbl_router_cache` (
  `router_id` VARCHAR(20),
  `state` VARCHAR(10),
  `uptime` VARCHAR(20),
  `model` VARCHAR(20),
  `prev_state` VARCHAR(10),
  `last_seen` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS `tbl_voucher`;
CREATE TABLE `tbl_voucher` (
  `id` int(10) NOT NULL,
  `type` enum('Hotspot','PPPOE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `routers` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_plan` int(10) NOT NULL,
  `code` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tb_languages`;
CREATE TABLE `tb_languages` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_appconfig`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_bandwidth`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_payment_gateway`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_plans`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_pool`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_routers`
  ADD PRIMARY KEY (`id`);

  -- Indexes for table `tbl_static`
--
ALTER TABLE `tbl_static`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_user_recharges`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_voucher`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tbl_appconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_bandwidth`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_customers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_payment_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_plans`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `tbl_static`
--
ALTER TABLE `tbl_static`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `tbl_pool`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_routers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_transactions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_user_recharges`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_voucher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--

-- BHHV data untuk tabel `tbl_appconfig`

--

INSERT INTO `tbl_appconfig` (`id`, `setting`, `value`)
VALUES 
(1, 'CompanyName', 'FreeIspRadius'), 
(2, 'currency_code', 'Ksh.'), 
(3, 'language', 'english'), 
(4, 'show-logo', '1'), 
(5, 'nstyle', 'blue'), 
(6, 'timezone', 'Africa/Nairobi'), 
(7, 'dec_point', '.'), 
(8, 'thousands_sep', ','), 
(9, 'rtl', '0'), 
(10, 'address', ''), 
(11, 'phone', ''), 
(12, 'date_format', 'd M Y'), 
(13, 'note', 'Thank you...'),
(14, 'mpesa_consumer_key', '6bxegKBnBDsJZisbZRYYuyezs5dcqpgYyFMSgnvRhGU6031h'),
(15, 'mpesa_consumer_secret', 'nRzAnfRy9CBK43eciwLWoc3GsMsZsJ2tWbhsyWhtkMVj94cIkCD3oFSR1Cr86A3M'),
(16, 'mpesa_business_code', ''),
(17, 'mpesa_pass_key', '3a45e88faa037b86fbd0c494676d71c3c23574203b2bf721066f90598bbd8bb8'),
(18, 'mpesa_env', 'live'),
(19, 'mpesa_till_consumer_key', '6bxegKBnBDsJZisbZRYYuyezs5dcqpgYyFMSgnvRhGU6031h'),
(20, 'mpesa_till_consumer_secret', 'nRzAnfRy9CBK43eciwLWoc3GsMsZsJ2tWbhsyWhtkMVj94cIkCD3oFSR1Cr86A3M'),
(21, 'mpesa_till_shortcode_code', '4137989'),
(23, 'mpesa_till_pass_key', '3a45e88faa037b86fbd0c494676d71c3c23574203b2bf721066f90598bbd8bb8'),
(24, 'tillmanualtext', 'After payment, kindly give the system upto 30 secs to activate your account.'),
(25, 'tillmanualshow', 'Show'),
(26, 'frequently_asked_questions_headline1', 'What is your contact number and how can I reach you?'),
(27, 'frequently_asked_questions_headline2', 'What happens if I travel outside your coverage area?'),
(28, 'frequently_asked_questions_headline3', 'How secure is your hotspot network?'),
(29, 'frequently_asked_questions_answer1', 'Our main line is [insert main phone number here]. You can also reach us through email at [insert customer service email address here]. We are available 24/7 via live chat on our website'),
(30, 'frequently_asked_questions_answer2', 'Your internet access will be limited while outside our coverage zones. However, some plans offer limited data roaming or add-on packages for occasional use in uncovered areas.'),
(31, 'frequently_asked_questions_answer3', 'We prioritize your security with advanced encryption protocols and secure authentication methods. Additionally, our private network is separate from the public internet, minimizing the risk of unauthorized access.'),
(32, 'description', 'We Provide Fast,Cheap and Reliable Wifi Connection Near You. Get connected today'),
(33, 'router_id', '4'),
(34, 'router_name', 'Delete and insert the right router name'),
(35, 'hotspot_title', 'Delete and Insert the right Title'),
(36, 'disable_registration', 'no'),
(37, 'user_notification_expired', 'sms'),
(38, 'user_notification_payment', 'sms'),
(39, 'country_code_phone', '254'),
(40, 'user_notification_reminder', 'wa'),
(41, 'minimum_transfer', '10'),
(42, 'allow_balance_transfer', 'yes'),
(43, 'enable_balance', 'yes'),
(44, 'disable_voucher', 'no'),
(45, 'disable_registration', 'yes'),
(46, 'theme', 'nova');
--

-- Dumping data untuk tabel `tbl_users`

--

INSERT INTO
    `tbl_users` (
        `id`,
        `username`,
        `fullname`,
        `password`,
        `user_type`,
        `status`,
        `last_login`,
        `creationdate`
    )
VALUES (
        1,
        'admin',
        'Administrator',
        'd033e22ae348aeb5660fc2140aec35850c4da997',
        'SuperAdmin',
        'Active',
        '2022-09-06 16:09:50',
        '2014-06-23 01:43:07'
    );

DROP TABLE IF EXISTS `tbl_customers_fields`;
CREATE TABLE tbl_customers_fields (
  id INT PRIMARY KEY AUTO_INCREMENT,
  customer_id INT NOT NULL,
  field_name VARCHAR(255) NOT NULL,
  field_value VARCHAR(255) NOT NULL,
  FOREIGN KEY (customer_id) REFERENCES tbl_customers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;    

ALTER TABLE `tbl_voucher` ADD `generated_by` INT NOT NULL DEFAULT '0' COMMENT 'id admin' AFTER `status`;
ALTER TABLE `tbl_users` ADD `root` INT NOT NULL DEFAULT '0' COMMENT 'for sub account' AFTER `id`;
ALTER TABLE `tbl_users` CHANGE `password` `password` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `tbl_users` ADD `phone` VARCHAR(32) NOT NULL DEFAULT '' AFTER `password`, ADD `email` VARCHAR(128) NOT NULL DEFAULT '' AFTER `phone`, ADD `city` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'kota' AFTER `email`, ADD `subdistrict` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'kecamatan' AFTER `city`, ADD `ward` VARCHAR(64) NOT NULL DEFAULT '' COMMENT 'kelurahan' AFTER `subdistrict`;
ALTER TABLE `tbl_customers` ADD `created_by` INT NOT NULL DEFAULT '0' AFTER `auto_renewal`;
ALTER TABLE `tbl_plans` ADD `list_expired` VARCHAR(32) NOT NULL DEFAULT '' COMMENT 'address list' AFTER `pool_expired`;
ALTER TABLE `tbl_bandwidth` ADD `burst` VARCHAR(128) NOT NULL DEFAULT '' AFTER `rate_up_unit`;
ALTER TABLE `tbl_transactions` ADD `admin_id` INT NOT NULL DEFAULT '1' AFTER `type`;
ALTER TABLE `tbl_user_recharges` ADD `admin_id` INT NOT NULL DEFAULT '1' AFTER `type`;


-- Dumping data for table `tbl_banks`
--

INSERT INTO `tbl_banks` (`id`, `name`, `paybill`) VALUES
(1, 'Equity', 247247),
(2, 'KCB', 522522),
(3, 'Coop', 400200),
(4, 'DTB', 516600),
(5, 'NCBA', 880100),
(6, 'Absa', 303030);

-- --------------------------------------------------------

--


-- New SQL statements
CREATE TABLE `tbl_data_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `old_upload` bigint(20) NOT NULL DEFAULT '0',
  `old_download` bigint(20) NOT NULL DEFAULT '0',
  `prev_upload` bigint(20) NOT NULL DEFAULT '0',
  `prev_download` bigint(20) NOT NULL DEFAULT '0',
  `new_upload` bigint(20) NOT NULL DEFAULT '0',
  `new_download` bigint(20) NOT NULL DEFAULT '0',
  `upload` bigint(20) NOT NULL DEFAULT '0',
  `download` bigint(20) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tbl_daily_data_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `upload` bigint(20) NOT NULL DEFAULT '0',
  `download` bigint(20) NOT NULL DEFAULT '0',
  `yesterday_total_upload` bigint(20) NOT NULL DEFAULT '0',
  `yesterday_total_download` bigint(20) NOT NULL DEFAULT '0',
  `today_total_upload` bigint(20) NOT NULL DEFAULT '0',
  `today_total_download` bigint(20) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tbl_weekly_data_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `monday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `monday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `tuesday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `tuesday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `wednesday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `wednesday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `thursday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `thursday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `friday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `friday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `saturday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `saturday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `sunday_upload` BIGINT(20) NOT NULL DEFAULT '0',
  `sunday_download` BIGINT(20) NOT NULL DEFAULT '0',
  `week_start_date` date NOT NULL,
  `week_end_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tbl_monthly_data_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `january_upload` bigint(20) NOT NULL DEFAULT '0',
  `january_download` bigint(20) NOT NULL DEFAULT '0',
  `february_upload` bigint(20) NOT NULL DEFAULT '0',
  `february_download` bigint(20) NOT NULL DEFAULT '0',
  `march_upload` bigint(20) NOT NULL DEFAULT '0',
  `march_download` bigint(20) NOT NULL DEFAULT '0',
  `april_upload` bigint(20) NOT NULL DEFAULT '0',
  `april_download` bigint(20) NOT NULL DEFAULT '0',
  `may_upload` bigint(20) NOT NULL DEFAULT '0',
  `may_download` bigint(20) NOT NULL DEFAULT '0',
  `june_upload` bigint(20) NOT NULL DEFAULT '0',
  `june_download` bigint(20) NOT NULL DEFAULT '0',
  `july_upload` bigint(20) NOT NULL DEFAULT '0',
  `july_download` bigint(20) NOT NULL DEFAULT '0',
  `august_upload` bigint(20) NOT NULL DEFAULT '0',
  `august_download` bigint(20) NOT NULL DEFAULT '0',
  `september_upload` bigint(20) NOT NULL DEFAULT '0',
  `september_download` bigint(20) NOT NULL DEFAULT '0',
  `october_upload` bigint(20) NOT NULL DEFAULT '0',
  `october_download` bigint(20) NOT NULL DEFAULT '0',
  `november_upload` bigint(20) NOT NULL DEFAULT '0',
  `november_download` bigint(20) NOT NULL DEFAULT '0',
  `december_upload` bigint(20) NOT NULL DEFAULT '0',
  `december_download` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tbl_reset_counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `tbl_users` MODIFY COLUMN `status` VARCHAR(50);

DROP TABLE IF EXISTS `tbl_sms_groups`;
CREATE TABLE `tbl_sms_groups` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `group_name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_sms_group_customers`;
CREATE TABLE `tbl_sms_group_customers` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `group_id` INT NOT NULL,
    `customer_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`group_id`) REFERENCES `tbl_sms_groups`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`customer_id`) REFERENCES `tbl_customers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
