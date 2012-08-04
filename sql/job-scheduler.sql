CREATE TABLE `job_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` tinytext NOT NULL,
  `data` text,
  `error_label` varchar(45) DEFAULT NULL,
  `error` varchar(45) DEFAULT NULL,
  `server_id` int(11) NOT NULL DEFAULT '1',
  `status_id` int(11) DEFAULT '1',
  `memory_usage` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_schedule_status`
--

CREATE TABLE `job_schedule_status` (
  `id` int(11) NOT NULL,
  `api_name` varchar(45) DEFAULT NULL,
  `live` tinyint(4) DEFAULT '0',
  `start_time` int(11) DEFAULT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  `limit` int(11) DEFAULT NULL,
  `sleep_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `job_schedule_status` VALUES(1, 'NAME', 1, 1332596579, 30, 10000, 3600);