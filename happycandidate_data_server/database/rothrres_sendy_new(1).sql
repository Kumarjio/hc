-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2018 at 11:34 AM
-- Server version: 5.5.40-36.1-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rothrres_sendy_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE IF NOT EXISTS `apps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `app_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_to` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fee` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_per_recipient` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_host` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_ssl` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bounce_setup` int(11) DEFAULT '0',
  `complaint_setup` int(11) DEFAULT '0',
  `app_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocated_quota` int(11) DEFAULT '-1',
  `current_quota` int(11) DEFAULT '0',
  `day_of_reset` int(11) DEFAULT '1',
  `month_of_next_reset` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_of_next_reset` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_logo_filename` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowed_attachments` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'jpeg,jpg,gif,png,pdf,zip',
  `reports_only` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `userID`, `app_name`, `from_name`, `from_email`, `reply_to`, `currency`, `delivery_fee`, `cost_per_recipient`, `smtp_host`, `smtp_port`, `smtp_ssl`, `smtp_username`, `smtp_password`, `bounce_setup`, `complaint_setup`, `app_key`, `allocated_quota`, `current_quota`, `day_of_reset`, `month_of_next_reset`, `year_of_next_reset`, `test_email`, `brand_logo_filename`, `allowed_attachments`, `reports_only`) VALUES
(1, 1, 'Sendy', 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'USD', '', '', '', '', 'ssl', '', '', 0, 0, 'o94bBnwt2D4Mzi0fGCkIIXAc5sgMQX', 10000, 0, 20, 'Mar', '2018', 'support@careersupportnetwork.com', NULL, 'jpeg,jpg,gif,png,pdf,zip', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ares`
--

CREATE TABLE IF NOT EXISTS `ares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `list` int(11) DEFAULT NULL,
  `custom_field` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ares`
--

INSERT INTO `ares` (`id`, `name`, `type`, `list`, `custom_field`) VALUES
(3, 'Happy Birthday', 1, 25, '');

-- --------------------------------------------------------

--
-- Table structure for table `ares_emails`
--

CREATE TABLE IF NOT EXISTS `ares_emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ares_id` int(11) DEFAULT NULL,
  `from_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_to` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plain_text` longtext COLLATE utf8mb4_unicode_ci,
  `html_text` longtext COLLATE utf8mb4_unicode_ci,
  `query_string` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_condition` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `recipients` int(100) DEFAULT '0',
  `opens` longtext COLLATE utf8mb4_unicode_ci,
  `wysiwyg` int(11) DEFAULT '0',
  `opens_tracking` int(1) DEFAULT '1',
  `links_tracking` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ares_emails`
--

INSERT INTO `ares_emails` (`id`, `ares_id`, `from_name`, `from_email`, `reply_to`, `title`, `plain_text`, `html_text`, `query_string`, `time_condition`, `timezone`, `created`, `recipients`, `opens`, `wysiwyg`, `opens_tracking`, `links_tracking`) VALUES
(2, 3, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Happy Birthday', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]&nbsp;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', 'immediately', NULL, 1499146071, 0, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `app` int(11) DEFAULT NULL,
  `from_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_to` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plain_text` longtext COLLATE utf8mb4_unicode_ci,
  `html_text` longtext COLLATE utf8mb4_unicode_ci,
  `query_string` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `to_send` int(100) DEFAULT NULL,
  `to_send_lists` mediumtext COLLATE utf8mb4_unicode_ci,
  `recipients` int(100) DEFAULT '0',
  `timeout_check` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opens` longtext COLLATE utf8mb4_unicode_ci,
  `wysiwyg` int(11) DEFAULT '0',
  `quota_deducted` int(11) DEFAULT NULL,
  `send_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lists` mediumtext COLLATE utf8mb4_unicode_ci,
  `timezone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `errors` longtext COLLATE utf8mb4_unicode_ci,
  `bounce_setup` int(11) DEFAULT '0',
  `complaint_setup` int(11) DEFAULT '0',
  `opens_tracking` int(1) DEFAULT '1',
  `links_tracking` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=155 ;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `userID`, `app`, `from_name`, `from_email`, `reply_to`, `title`, `label`, `plain_text`, `html_text`, `query_string`, `sent`, `to_send`, `to_send_lists`, `recipients`, `timeout_check`, `opens`, `wysiwyg`, `quota_deducted`, `send_date`, `lists`, `timezone`, `errors`, `bounce_setup`, `complaint_setup`, `opens_tracking`, `links_tracking`) VALUES
(2, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div align="center">\r\n<table border="0" cellpadding="0" cellspacing="0" class="m_6520727708735460969m_-309030046278418085MsoNormalTable" style="width:562.5pt" width="750">\r\n	<tbody>\r\n		<tr>\r\n			<td style="width:100.0%;background:white;padding:0in 0in 0in 0in" valign="top" width="100%">\r\n			<div align="center">\r\n			<table border="0" cellpadding="0" cellspacing="0" class="m_6520727708735460969m_-309030046278418085MsoNormalTable" style="width:562.5pt" width="750">\r\n				<tbody>\r\n					<tr>\r\n						<td style="width:562.5pt;padding:0in 0in 0in 0in" valign="top" width="750">\r\n						<table align="right" border="0" cellpadding="0" cellspacing="0" class="m_6520727708735460969m_-309030046278418085MsoNormalTable" style="width:7.5in;border-collapse:collapse" width="720">\r\n							<tbody>\r\n								<tr>\r\n									<td style="width:100.0%;padding:0in 0in 0in 0in" width="100%">\r\n									<div align="center">\r\n									<table border="0" cellpadding="0" cellspacing="0" class="m_6520727708735460969m_-309030046278418085MsoNormalTable" style="width:7.5in" width="720">\r\n										<tbody>\r\n											<tr>\r\n												<td style="width:100.0%;padding:0in 0in 0in 0in" valign="top" width="100%">\r\n												<table align="left" border="0" cellpadding="0" cellspacing="0" class="m_6520727708735460969m_-309030046278418085MsoNormalTable" style="width:100.0%" width="100%">\r\n													<tbody>\r\n														<tr>\r\n															<td style="padding:0in 15.0pt 0in 15.0pt" valign="top">\r\n															<table border="0" cellpadding="0" cellspacing="0" class="m_6520727708735460969m_-309030046278418085MsoNormalTable" style="width:100.0%" width="100%">\r\n																<tbody>\r\n																	<tr>\r\n																		<td style="width:100.0%;padding:0in 0in 15.0pt 0in" valign="top" width="100%">\r\n																		<p class="MsoNormal"><img border="0" class="CToWUd" id="m_6520727708735460969m_-309030046278418085_x0000_i1027" src="https://ci5.googleusercontent.com/proxy/YOgr_J4Dq8FoVtA0W30r5qMubUKUXJLsWT3XeADA0aM39Bs4NLEghwDzJNEGnNhTBf13tCZ62U2rt1TOMFU=s0-d-e1-ft#https://sendy.co/images/receipt-hero.jpg" /><br />\r\n																		<br />\r\n																		<span class="m_6520727708735460969m_-309030046278418085bannerfontsize"><span arial="" style="font-size:24.0pt;font-family:">Thank you for Using Sendy!</span></span></p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style="width:100.0%;padding:0in 0in 30.0pt 0in" width="100%">\r\n																		<p>Hello Dear,</p>\r\n\r\n																		<p>This is test mail</p>\r\n\r\n																		<p>&nbsp;</p>\r\n\r\n																		<p>Regards,</p>\r\n\r\n																		<p>Sendy</p>\r\n																		</td>\r\n																	</tr>\r\n																	<tr>\r\n																		<td style="width:100.0%;padding:0in 0in 0in 0in" width="100%">&nbsp;</td>\r\n																	</tr>\r\n																	<tr style="height:15.0pt">\r\n																		<td style="width:100.0%;padding:0in 0in 0in 0in;height:15.0pt" valign="top" width="100%">\r\n																		<p align="center" class="MsoNormal" style="text-align:center">&nbsp;</p>\r\n																		</td>\r\n																	</tr>\r\n																</tbody>\r\n															</table>\r\n															</td>\r\n														</tr>\r\n													</tbody>\r\n												</table>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</div>\r\n									</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1498818228', 2, '1', 2, NULL, '2:AP,1:AP,2:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(3, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1498819427', 2, '1', 2, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(70, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]&nbsp;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499174033', 1, '1', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(71, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]&nbsp;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;">&nbsp;</p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499174225', 1, '1', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(78, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Testing new one', NULL, NULL, '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>abc</p>\r\n</body>\r\n</html>\r\n', NULL, '', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(97, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', 'Mickey Invite', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499698026', 0, '13', 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(98, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499698375', 1, '13', 1, NULL, '782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(99, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [lastname]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Name]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [Email]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [phonenumber]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [zipcode]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [state]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [city]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [country]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [portal_url]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [owner_company_name]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [username]<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [forgot_password_link]&#39;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499698647', 1, '13', 1, NULL, '782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(100, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499748974', 17, '1', 17, NULL, '630:AP,629:AP,631:AP,635:AP,780:AP,632:AP,634:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(101, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]&nbsp;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499749329', 17, '1', 17, NULL, '630:AP,628:AP,629:AP,631:AP,635:AP,780:AP,632:AP,634:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(102, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]&nbsp;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499749652', 1, '13', 1, NULL, '782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(118, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]&nbsp;</p>\r\n\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1499755224', 1, '13', 1, NULL, '782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(122, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'HC Communicator', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<table border="0" cellpadding="0" cellspacing="0" width="688">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="" height="108" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-header.jpg" width="688" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td align="center" style="border-left: #f4f4f4 1px solid; border-right: #f4f4f4 1px solid" valign="middle">\r\n			<div>&nbsp;\r\n			<center>\r\n			<table align="center" border="0" cellpadding="2" cellspacing="0" style="z-index: 2" width="95%">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<p>Hello.</p>\r\n\r\n						<p>This is our test message. &nbsp;The Summer is warm. &nbsp;The Winter is hot.</p>\r\n\r\n						<p>We like pizza.&nbsp;<img alt="wink" height="23" src="http://www.rothrsolutions.com/sendy_new/js/ckeditor/plugins/smiley/images/wink_smile.png" title="wink" width="23" /></p>\r\n\r\n						<p>&nbsp;</p>\r\n\r\n						<p><img alt="Our fearless leader - We follow her anywhere!" src="http://www.rothrsolutions.com/sendy_new/uploads/1499972979.jpg" style="width: 371px; height: 365px;" /></p>\r\n\r\n						<p>&nbsp;</p>\r\n\r\n						<p>&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</center>\r\n			<br />\r\n			<br />\r\n			<br />\r\n			&nbsp;</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td height="56" width="688"><img alt="" height="56" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-footer.jpg" width="688" /></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</body>\r\n</html>\r\n', '', '1499973301', 4, '18', 4, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(123, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'HC Communicator', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<table border="0" cellpadding="0" cellspacing="0" width="688">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="" height="108" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-header.jpg" width="688" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td align="center" style="border-left: #f4f4f4 1px solid; border-right: #f4f4f4 1px solid" valign="middle">\r\n			<div>&nbsp;\r\n			<center>\r\n			<table align="center" border="0" cellpadding="2" cellspacing="0" style="z-index: 2" width="95%">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<p>TEXT &nbsp;</p>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</center>\r\n			<br />\r\n			<br />\r\n			<br />\r\n			&nbsp;</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td height="56" width="688"><img alt="" height="56" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-footer.jpg" width="688" /></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</body>\r\n</html>\r\n', '', '1500031717', 4, '18', 4, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(124, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1500357361', 1, '13', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(125, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(126, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'Sendy Test', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n', '', '1500358202', 1, '13', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(150, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'New Test Template', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]<br />\r\n<strong><code>[Everything_DiSC_Management_-_Assessment_Tool_purchase_link]</code> </strong></p>\r\n</body>\r\n</html>\r\n', '', '', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(151, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'New Test Template', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]<br />\r\n[CV_|_Resume_Review_purchase_link]<strong> </strong></p>\r\n</body>\r\n</html>\r\n', '', '1501164177', 1, '13', 1, NULL, '782:AP,782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(152, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'New Test Template', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]<br />\r\n[CV_|_Resume_Review_purchase_link]</p>\r\n</body>\r\n</html>\r\n', '', '1501164980', 1, '13', 1, NULL, '782:AP,782:AP,782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(153, 1, 1, 'Career Support Network Team', 'support@careersupportnetwork.com', 'support@careersupportnetwork.com', 'HC Communicator - Test Message', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<table border="0" cellpadding="0" cellspacing="0" width="688">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="" height="108" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-header.jpg" width="688" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td align="center" style="border-left: #f4f4f4 1px solid; border-right: #f4f4f4 1px solid" valign="middle">\r\n			<center style="text-align: left;"><img alt="devil" height="23" src="http://www.rothrsolutions.com/sendy_new/js/ckeditor/plugins/smiley/images/devil_smile.png" title="devil" width="23" />&nbsp;Test</center>\r\n\r\n			<center style="text-align: left;">&nbsp;</center>\r\n\r\n			<center style="text-align: left;">[CV_|_Resume_Review_purchase_link]</center>\r\n\r\n			<center>&nbsp;</center>\r\n			<br />\r\n			<br />\r\n			<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td height="56" width="688"><img alt="" height="56" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-footer.jpg" width="688" /></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</body>\r\n</html>\r\n', '', '1501252202', 1, '9', 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1),
(154, 1, 1, 'Arjun', 'arjun.gunjal@redorangetechnologies.com', 'arjun.gunjal@redorangetechnologies.com', 'New Test Template', '', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]<br />\r\n[CV_|_Resume_Review_purchase_link]</p>\r\n</body>\r\n</html>\r\n', '', '1501309523', 1, '13', 1, NULL, '782:AP,782:US,782:AP,782:AP', 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `ares_emails_id` int(11) DEFAULT NULL,
  `link` varchar(1500) DEFAULT NULL,
  `clicks` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opt_in` int(11) DEFAULT '0',
  `confirm_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscribed_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unsubscribed_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thankyou` int(11) DEFAULT '0',
  `thankyou_subject` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thankyou_message` longtext COLLATE utf8mb4_unicode_ci,
  `goodbye` int(11) DEFAULT '0',
  `goodbye_subject` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goodbye_message` longtext COLLATE utf8mb4_unicode_ci,
  `confirmation_subject` longtext COLLATE utf8mb4_unicode_ci,
  `confirmation_email` longtext COLLATE utf8mb4_unicode_ci,
  `unsubscribe_all_list` int(11) DEFAULT '1',
  `custom_fields` longtext COLLATE utf8mb4_unicode_ci,
  `prev_count` int(100) DEFAULT '0',
  `currently_processing` int(100) DEFAULT '0',
  `total_records` int(100) DEFAULT '0',
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portal_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `skillsofts_id` int(11) DEFAULT NULL,
  `subscribe_status` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `app`, `userID`, `name`, `opt_in`, `confirm_url`, `subscribed_url`, `unsubscribed_url`, `thankyou`, `thankyou_subject`, `thankyou_message`, `goodbye`, `goodbye_subject`, `goodbye_message`, `confirmation_subject`, `confirmation_email`, `unsubscribe_all_list`, `custom_fields`, `prev_count`, `currently_processing`, `total_records`, `user_type`, `portal_id`, `product_type`, `service_id`, `course_id`, `product_id`, `skillsofts_id`, `subscribe_status`) VALUES
(1, 1, 1, 'Active Owners', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 'firstname:Text%s%lastname:Text%s%phonenumber:Text%s%zipcode:Text%s%state:Text%s%city:Text%s%country:Text%s%portal_url:Text%s%owner_company_name:Text%s%username:Text%s%forgot_password_link:Text', 0, 0, 0, 'owner', '', NULL, NULL, NULL, NULL, NULL, '1'),
(2, 1, 1, 'Active Vendor', 0, '', '', '', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 1, 'firstname:Text%s%lastname:Text%s%username:Text%s%phonenumber:Text%s%zipcode:Text%s%city:Text%s%state:Text%s%country:Text%s%owner_company_name:Text%s%forgot_password_link:Text%s%portal_url:Text', 0, 0, 0, 'vendor', '', NULL, NULL, NULL, NULL, NULL, '1'),
(3, 1, 1, 'Active Candidate', 0, '', '', '', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 1, 'firstname:Text%s%lastname:Text%s%phonenumber:Text%s%zipcode:Text%s%state:Text%s%city:Text%s%country:Text%s%portal_url:Text%s%owner_company_name:Text%s%username:Text%s%forgot_password_link:Text', 0, 0, 0, 'candidate', '', NULL, NULL, NULL, NULL, NULL, '1'),
(4, 1, 1, 'Inactive Owners', 0, '', '', '', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>&nbsp;</body>\r\n</html>\r\n', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>&nbsp;</body>\r\n</html>\r\n', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>&nbsp;</body>\r\n</html>\r\n', 1, NULL, 0, 0, 0, 'owner', '', NULL, NULL, NULL, NULL, NULL, '0'),
(5, 1, 1, 'Inactive Vendors', 0, '', '', '', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 1, NULL, 0, 0, 0, 'vendor', '', NULL, NULL, NULL, NULL, NULL, '0'),
(6, 1, 1, 'Inactive Candidates', 0, '', '', '', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body></body>\r\n</html>\r\n', 1, 'firstname:Text%s%lastname:Text%s%username:Text%s%owner_company_name:Text%s%phonenumber:Text%s%portal_url:Text%s%city:Text%s%state:Text%s%country:Text%s%zipcode:Text%s%forgot_password_link:Text', 0, 0, 0, 'candidate', '', NULL, NULL, NULL, NULL, NULL, '0'),
(7, 1, 1, 'Services Purchase Candidate', 0, '', '', '', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>&nbsp;</body>\r\n</html>\r\n', 0, '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>&nbsp;</body>\r\n</html>\r\n', '', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>&nbsp;</body>\r\n</html>\r\n', 1, NULL, 0, 0, 0, 'candidate', '', 'services', 19, 0, NULL, NULL, '1'),
(8, 1, 1, 'Product Purchase Candidate', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'products', 0, 0, 66, 0, '1'),
(9, 1, 1, 'All Owners', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 'firstname:Text%s%lastname:Text%s%phonenumber:Text%s%zipcode:Text%s%city:Text%s%state:Text%s%country:Text%s%portal_url:Text%s%username:Text%s%owner_company_name:Text%s%forgot_password_link:Text', 0, 0, 0, 'owner', '', '', 0, 0, 0, 0, 'all'),
(10, 1, 1, 'All Vendors', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 'firstname:Text%s%lastname:Text%s%phonenumber:Text%s%zipcode:Text%s%city:Text%s%state:Text%s%country:Text%s%portal_url:Text%s%owner_company_name:Text%s%username:Text%s%forgot_password_link:Text', 0, 0, 0, 'vendor', '', '', 0, 0, 0, 0, 'all'),
(12, 1, 1, 'All Candidates', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 'firstname:Text%s%lastname:Text%s%phonenumber:Text%s%city:Text%s%state:Text%s%zipcode:Text%s%portal_url:Text%s%username:Text%s%owner_company_name:Text%s%country:Text%s%forgot_password_link:Text', 0, 0, 0, 'candidate', '', '', 0, 0, 0, 0, 'all'),
(13, 1, 1, 'Test Mail Users', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 'firstname:Text%s%lastname:Text%s%phonenumber:Text%s%zipcode:Text%s%state:Text%s%city:Text%s%country:Text%s%portal_url:Text%s%owner_company_name:Text%s%username:Text%s%forgot_password_link:Text', 0, 0, 0, 'owner', '', NULL, 0, 0, 0, 0, 'all'),
(15, 1, 1, 'Test Mail Users1', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'owner', '', '', 0, 0, 0, 0, 'all'),
(18, 1, 1, 'GAG Test List Owner', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'owner', '', '', 0, 0, 0, 0, 'all'),
(19, 1, 1, 'CV or Resume Review', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'products', 0, 0, 66, 0, 'all'),
(20, 1, 1, 'Entry Level CV or Resume Rewrite', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 15, 0, 0, 0, 'all'),
(21, 1, 1, 'Advanced CV or Resume Rewrite', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 16, 0, 0, 0, 'all'),
(22, 1, 1, 'Senior Executive CV or Resume Rewrite', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'course', 0, 78, 0, 0, 'all'),
(23, 1, 1, 'Cover letter', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 18, 0, 0, 0, 'all'),
(24, 1, 1, 'Thank You Note', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 19, 0, 0, 0, 'all'),
(25, 1, 1, 'LinkedIn CV or Resume Upload', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 37, 0, 0, 0, 'all'),
(26, 1, 1, 'Color Career Indicator 4.0', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'course', 0, 77, 0, 0, 'all'),
(27, 1, 1, 'Color Leadership Evaluation 5.0', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 39, 0, 0, 0, 'all'),
(28, 1, 1, 'Rethink Job Search Program', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 40, 0, 0, 0, 'all'),
(29, 1, 1, 'ReThinkCoaching Calls', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 28, 0, 0, 0, 'all'),
(30, 1, 1, 'Everything DiSC Workplace Assessment', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'products', 0, 0, 43, 0, 'all'),
(31, 1, 1, 'Everything DiSC Sales Assessment', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'products', 0, 0, 42, 0, 'all'),
(32, 1, 1, 'Everything DiSC Management Assessment', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'products', 0, 0, 41, 0, 'all'),
(33, 1, 1, 'Don’t Interview Audition ebook', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'products', 0, 0, 67, 0, 'all'),
(34, 1, 1, 'InterviewBest', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 69, 0, 0, 0, 'all'),
(35, 1, 1, 'Access Review', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 51, 'all'),
(36, 1, 1, 'Access Intermediate', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 80, 'all'),
(37, 1, 1, 'Access Advanced', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 81, 'all'),
(38, 1, 1, 'Excel Review', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 49, 'all'),
(39, 1, 1, 'Excel Basic', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 50, 'all'),
(40, 1, 1, 'Excel Intermediate', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 82, 'all'),
(41, 1, 1, 'Excel Advanced', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 83, 'all'),
(42, 1, 1, 'Outlook Review', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 55, 'all'),
(43, 1, 1, 'Outlook Basic', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 56, 'all'),
(44, 1, 1, 'Outlook Intermediate', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 84, 'all'),
(45, 1, 1, 'Outlook Advanced', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 85, 'all'),
(46, 1, 1, 'PowerPoint Review', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 53, 'all'),
(47, 1, 1, 'PowerPoint Basic', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 54, 'all'),
(48, 1, 1, 'PowerPoint Advanced', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 86, 'all'),
(49, 1, 1, 'Windows Review', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 45, 'all'),
(50, 1, 1, 'Windows Introduction', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 87, 'all'),
(51, 1, 1, 'Word Basic', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 48, 'all'),
(52, 1, 1, 'Word Intermediate', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 88, 'all'),
(53, 1, 1, 'Computerized Accounting', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 59, 'all'),
(54, 1, 1, 'QuickBooks Basic', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 57, 0, 0, 0, 'all'),
(55, 1, 1, 'Word Advanced', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 90, 'all'),
(56, 1, 1, 'Access Basic', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'skillsoftco', 0, 0, 0, 91, 'all'),
(57, 1, 1, 'QuickBooks Advanced', 0, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 'candidate', '', 'services', 89, 0, 0, 0, 'all');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s3_key` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s3_secret` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_key` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tied_to` int(11) DEFAULT NULL,
  `app` int(11) DEFAULT NULL,
  `paypal` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron` int(11) DEFAULT '0',
  `cron_ares` int(11) DEFAULT '0',
  `send_rate` int(100) DEFAULT '0',
  `language` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'en_US',
  `cron_csv` int(11) DEFAULT '0',
  `ses_endpoint` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_enabled` int(11) DEFAULT '0',
  `auth_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `company`, `username`, `password`, `s3_key`, `s3_secret`, `api_key`, `license`, `timezone`, `tied_to`, `app`, `paypal`, `cron`, `cron_ares`, `send_rate`, `language`, `cron_csv`, `ses_endpoint`, `auth_enabled`, `auth_key`) VALUES
(1, 'Admin', 'HC', 'arjun.gunjal@redorangetechnologies.com', '809b3aaf26ccdbecc359c248350299397d289ec0fb88a1f8614f61ce0237d10425c626af6115f38b9b9e47150f5c4eb3881b36d92baae9b29afa2464150783ed', 'AKIAJ6KRSJVFPDEXNXCA', '58KKMXEN7LPCAyFRzgOWlRylnJVQgzgK2T9nsFUQ', 'EXMnUcDcp43wyXC9r2AX', 'RNRbJz2iTNTPsIUAkG115OTjVmwxuclr', 'America/New_York', NULL, NULL, '', 1, 1, 1, 'en_US', 0, 'email.us-east-1.amazonaws.com', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `query_str` longtext,
  `campaign_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `sent` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `s_id` (`subscriber_id`),
  KEY `st_id` (`sent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `query_str`, `campaign_id`, `subscriber_id`, `sent`) VALUES
(1, NULL, 127, 782, 1),
(2, NULL, 128, 782, 1),
(4, NULL, 132, 782, 1),
(5, NULL, 133, 782, 1),
(8, NULL, 136, 782, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_fields` longtext COLLATE utf8mb4_unicode_ci,
  `list` int(11) DEFAULT NULL,
  `unsubscribed` int(11) DEFAULT '0',
  `bounced` int(11) DEFAULT '0',
  `bounce_soft` int(11) DEFAULT '0',
  `complaint` int(11) DEFAULT '0',
  `last_campaign` int(11) DEFAULT NULL,
  `last_ares` int(11) DEFAULT NULL,
  `timestamp` int(100) DEFAULT NULL,
  `join_date` int(100) DEFAULT NULL,
  `confirmed` int(11) DEFAULT '1',
  `messageID` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `s_list` (`list`),
  KEY `s_unsubscribed` (`unsubscribed`),
  KEY `s_bounced` (`bounced`),
  KEY `s_bounce_soft` (`bounce_soft`),
  KEY `s_complaint` (`complaint`),
  KEY `s_confirmed` (`confirmed`),
  KEY `s_timestamp` (`timestamp`),
  KEY `s_email` (`email`),
  KEY `s_last_campaign` (`last_campaign`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1014 ;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `userID`, `name`, `email`, `custom_fields`, `list`, `unsubscribed`, `bounced`, `bounce_soft`, `complaint`, `last_campaign`, `last_ares`, `timestamp`, `join_date`, `confirmed`, `messageID`) VALUES
(621, 1, 'Rajendra Kandpal', 'rajendrakumar.kandpal@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d3006b9c7-e619f42d-d791-4455-a72d-005883679f92-000000'),
(622, 1, 'Shailesh ', 'shailesh.ghule@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(623, 1, 'Akash ', 'akash.adsul@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(624, 1, 'Teju ', 'tejswini.kamble@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(625, 1, 'vaishali ', 'vaishali.kharole@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(626, 1, 'vaishali26 ', 'vaishali.kharole@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(627, 1, 'smile.sp ', 'smile.sp28@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(628, 1, 'Harry Jerry', 'arjun.gunjal@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d30073622-23aa6cfa-742f-4171-863c-8d7fa2e23dee-000000'),
(629, 1, 'Arjun Gunjal', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d30073e10-b64ed753-28c2-48cc-9f8a-cf5bc3ee9a09-000000'),
(630, 1, 'harry ', 'prasanna.rapate@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d300745cc-8a74c4bb-90b6-45e3-a865-7abbbd2931ca-000000'),
(631, 1, 'harry ', 'ambarish.kattoli@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d30074de6-d8f2b86f-d58b-4a17-bd7d-9d23b333f103-000000'),
(632, 1, 'pranay ', 'pranay.aher@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d300755ba-b1462b51-69f6-482c-81a4-0485fa9bc1a1-000000'),
(633, 1, 'ambrish ', 'ambarish.kattoli@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(634, 1, 'gunjalarjun005 ', 'gunjalarjun005@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d30075db5-5da30f1a-f720-48da-b092-75a86c332f1a-000000'),
(635, 1, 'rohitshauns ', 'rohit44shauns@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, '0100015d30076937-8ceeaac5-879a-412e-8c61-20d0ed30043d-000000'),
(636, 1, 'bmatthews@hrsearchinc.com ', 'bmatthews@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499411634, NULL, 1, ''),
(637, 1, 'Course Vendor', 'rohit44shauns@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(638, 1, 'Amanda Clark', 'amanda.clark@grammarchic.net', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(639, 1, 'Pawan Patil', 'pawan.patil@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(640, 1, 'Beth Matthews', 'bmatthews@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(641, 1, 'Jack Brown', 'jsvetich@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(642, 1, 'Joe Brown', 'bbruno@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(643, 1, 'Shrikant B', 'tejswini.kamble@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(644, 1, 'Donna Fedor', 'donna@donnafedor.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(645, 1, 'Rajendra Course Vendor', 'rajendra4uaty@yahoo.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(646, 1, 'Jan Brady', 'jbrady@grammchi.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(647, 1, 'Dewey Sadka', 'dewey@deweycolorsystems.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(648, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(649, 1, 'Herb Cogliano', 'hcogliano@sullivancogliano.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(650, 1, 'Eric Kramer', 'epkramer@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(651, 1, 'Bobbi Ellison', 'bellison@adams-inc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(652, 1, 'Kathy Barron', 'kbarron@accurateresourcegroup.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(653, 1, 'Darla Torkelsen', 'darla@ahceducation.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(654, 1, 'Carrie Harper', 'carrie@advantage-inc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(655, 1, 'Kelly Hawker', 'khawker@allenresourcesllc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(656, 1, 'Michael McLain', 'mike@altusrecruiting.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(657, 1, 'Celeste Christ', 'celeste@ambersystemsgroup.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(658, 1, 'Colette Woelki', 'colette@amr4jobs.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(659, 1, 'Vince Militello', 'vmilitello@anngrogan.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(660, 1, 'Thomas Denton', 'tdenton@apexmedicalplacements.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(661, 1, 'Jamie Gallegos', 'jgallegos@aps-careerzone.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(662, 1, 'Bejan Douraghy', 'bejan@artisantalent.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(663, 1, 'Ingrid Childress', 'ichildress@artizen.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(664, 1, 'Reza Vakili', 'reza@atcsearch.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(665, 1, 'Dominique Milton', 'dfmilton@a10clinical.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(666, 1, 'Don’t Don’t', 'test@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(667, 1, 'test test''t', 'testv@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(668, 1, 'test''t test''t', 'vardhaman.bhore@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(669, 1, 'Stacy Pursell', 'stacy@thevetrecruiter.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(670, 1, 'Teddi Remer', 'teddi@dtrexecutivesolutions.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(671, 1, 'Honapa Bee', 'honapa@nationalmedicalsearch.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(672, 1, 'Vic Perkins', 'vic@perkinsinc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(673, 1, 'Michael Stuck', 'mstuck@gabelssearch.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(674, 1, 'David White', 'dwhite@scpaloalto.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(675, 1, 'Paul Kilman', 'pkilman@kilman.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(676, 1, 'Zag Dutton', 'zag@careerconnectionsinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(677, 1, 'Kimberly Lucas', 'kimberly@goldstonepartners.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(678, 1, 'Lorena Stanley', 'lorena@lorenaslist.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(679, 1, 'Jimminie Cricket', 'jcricket@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(680, 1, 'Employee One', 'eone@lkll.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(681, 1, 'Arjun G', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(682, 1, 'arjun gunjal', 'arjun@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 2, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(683, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 3, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(684, 1, 'Matt Connelly', 'matt@matt-connelly.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 3, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(685, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 3, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(686, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 3, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(687, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 3, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(688, 1, 'bmatthews710 ', 'nitin.redorange@redorangetechnologies.com', NULL, 4, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(689, 1, 'bmatthews710 ', 'bmatthews@goodasgoldtraining.com', NULL, 4, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(690, 1, 'nitin ', 'nitin.redorange@redorangetechnologies.com', NULL, 4, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(691, 1, 'rohitshauns ', 'rohitshauns@gmail.com', NULL, 4, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(692, 1, 'Matt Connelly', 'matt@digitalmavericks.se', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 6, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(693, 1, 'Jhon Rola', 'johnrola36@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 6, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(694, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 6, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(695, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 6, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(696, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 6, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(697, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 7, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(698, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 7, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(699, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 7, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(700, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 7, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(701, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 7, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(702, 1, 'Rajendra Kandpal', 'rajendrakumar.kandpal@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, 153, NULL, 1499411634, NULL, 1, ''),
(703, 1, 'Shailesh ', 'shailesh.ghule@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(704, 1, 'Akash ', 'akash.adsul@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(705, 1, 'Teju ', 'tejswini.kamble@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(706, 1, 'vaishali ', 'vaishali.kharole@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(707, 1, 'vaishali26 ', 'vaishali.kharole@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(708, 1, 'smile.sp ', 'smile.sp28@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(709, 1, 'Harry Jerry', 'arjun.gunjal@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(710, 1, 'Arjun Gunjal', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(711, 1, 'harry ', 'prasanna.rapate@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(712, 1, 'harry ', 'ambarish.kattoli@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(713, 1, 'pranay ', 'pranay.aher@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(714, 1, 'ambrish ', 'ambarish.kattoli@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(715, 1, 'gunjalarjun005 ', 'gunjalarjun005@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(716, 1, 'bmatthews710 ', 'nitin.redorange@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(717, 1, 'bmatthews710 ', 'bmatthews@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(718, 1, 'nitin ', 'nitin.redorange@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(719, 1, 'rohitshauns ', 'rohitshauns@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(720, 1, 'rohitshauns ', 'rohit44shauns@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(721, 1, 'bmatthews@hrsearchinc.com ', 'bmatthews@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 9, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(722, 1, 'Course Vendor', 'rohit44shauns@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(723, 1, 'Amanda Clark', 'amanda.clark@grammarchic.net', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(724, 1, 'Pawan Patil', 'pawan.patil@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(725, 1, 'Beth Matthews', 'bmatthews@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(726, 1, 'Jack Brown', 'jsvetich@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(727, 1, 'Joe Brown', 'bbruno@hrsearchinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(728, 1, 'Shrikant B', 'tejswini.kamble@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(729, 1, 'Donna Fedor', 'donna@donnafedor.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(730, 1, 'Rajendra Course Vendor', 'rajendra4uaty@yahoo.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(731, 1, 'Jan Brady', 'jbrady@grammchi.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(732, 1, 'Dewey Sadka', 'dewey@deweycolorsystems.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(733, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(734, 1, 'Herb Cogliano', 'hcogliano@sullivancogliano.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(735, 1, 'Eric Kramer', 'epkramer@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(736, 1, 'Bobbi Ellison', 'bellison@adams-inc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(737, 1, 'Kathy Barron', 'kbarron@accurateresourcegroup.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(738, 1, 'Darla Torkelsen', 'darla@ahceducation.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(739, 1, 'Carrie Harper', 'carrie@advantage-inc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(740, 1, 'Kelly Hawker', 'khawker@allenresourcesllc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(741, 1, 'Michael McLain', 'mike@altusrecruiting.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(742, 1, 'Celeste Christ', 'celeste@ambersystemsgroup.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(743, 1, 'Colette Woelki', 'colette@amr4jobs.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(744, 1, 'Vince Militello', 'vmilitello@anngrogan.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(745, 1, 'Thomas Denton', 'tdenton@apexmedicalplacements.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(746, 1, 'Jamie Gallegos', 'jgallegos@aps-careerzone.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(747, 1, 'Bejan Douraghy', 'bejan@artisantalent.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(748, 1, 'Ingrid Childress', 'ichildress@artizen.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(749, 1, 'Reza Vakili', 'reza@atcsearch.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(750, 1, 'Dominique Milton', 'dfmilton@a10clinical.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(751, 1, 'Don’t Don’t', 'test@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(752, 1, 'test test''t', 'testv@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(753, 1, 'test''t test''t', 'vardhaman.bhore@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(754, 1, 'Stacy Pursell', 'stacy@thevetrecruiter.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(755, 1, 'Teddi Remer', 'teddi@dtrexecutivesolutions.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(756, 1, 'Honapa Bee', 'honapa@nationalmedicalsearch.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(757, 1, 'Vic Perkins', 'vic@perkinsinc.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(758, 1, 'Michael Stuck', 'mstuck@gabelssearch.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(759, 1, 'David White', 'dwhite@scpaloalto.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(760, 1, 'Paul Kilman', 'pkilman@kilman.co', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(761, 1, 'Zag Dutton', 'zag@careerconnectionsinc.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(762, 1, 'Kimberly Lucas', 'kimberly@goldstonepartners.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(763, 1, 'Lorena Stanley', 'lorena@lorenaslist.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(764, 1, 'Jimminie Cricket', 'jcricket@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(765, 1, 'Employee One', 'eone@lkll.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(766, 1, 'Arjun G', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(767, 1, 'arjun gunjal', 'arjun@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 10, 0, 0, 0, 0, NULL, NULL, 1499411634, NULL, 1, NULL),
(768, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(769, 1, 'Matt Connelly', 'matt@matt-connelly.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(770, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(771, 1, 'Matt Connelly', 'matt@digitalmavericks.se', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(772, 1, 'Jhon Rola', 'johnrola36@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(773, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(774, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(775, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(776, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(777, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(778, 1, 'test pipl', 'test@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 12, 0, 0, 0, 0, NULL, NULL, 1499411857, NULL, 1, NULL),
(779, 1, '', 'abc@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 3, 1, 0, 0, 0, NULL, NULL, 1499437800, NULL, 1, NULL),
(780, 1, 'Emma Watson', 'watsonemma227@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499691607, NULL, 1, '0100015d300784c6-f1bc2a70-a04c-4edc-8708-6cb49ba4d48b-000000'),
(781, 1, 'ambrish K', 'ambrish@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 1, 0, 0, 0, 0, 101, NULL, 1499691656, NULL, 1, ''),
(782, 1, 'Arjun G', 'gunjalarjun05@gmail.com', '%s%%s%%s%%s%%s%%s%%s%%s%%s%%s%', 13, 0, 0, 0, 0, 154, NULL, 1499692311, NULL, 1, '0100015d8d055ea6-2c44cd85-5c10-4873-8a0e-906d0be446b4-000000'),
(804, 1, 'Rajendra Kandpal', 'rajendrakumar.kandpal@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(805, 1, 'Shailesh ', 'shailesh.ghule@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(806, 1, 'Akash ', 'akash.adsul@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(807, 1, 'Teju ', 'tejswini.kamble@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(808, 1, 'vaishali ', 'vaishali.kharole@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(809, 1, 'vaishali26 ', 'vaishali.kharole@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(810, 1, 'smile.sp ', 'smile.sp28@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(811, 1, 'Harry Jerry', 'arjun.gunjal@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(812, 1, 'Arjun Gunjal', 'gunjalarjun05@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(813, 1, 'harry ', 'prasanna.rapate@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(814, 1, 'harry ', 'ambarish.kattoli@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(815, 1, 'pranay ', 'pranay.aher@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(816, 1, 'gunjalarjun005 ', 'gunjalarjun005@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(817, 1, 'bmatthews710 ', 'bmatthews@goodasgoldtraining.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(818, 1, 'rohitshauns ', 'rohitshauns@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(819, 1, 'rohitshauns ', 'rohit44shauns@gmail.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(820, 1, 'bmatthews@hrsearchinc.com ', 'bmatthews@hrsearchinc.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(821, 1, 'bbruno ', 'barb@hrsearchinc.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(822, 1, 'Nitin Mane', 'nitin.mane@redorangetechnologies.com', NULL, 15, 0, 0, 0, 0, NULL, NULL, 1499756612, NULL, 1, NULL),
(874, 1, 'Rajendra Kandpal', 'rajendrakumar.kandpal@gmail.com', NULL, 18, 0, 0, 0, 0, 123, NULL, 1499968132, NULL, 1, '0100015d40dba291-8ba57dee-077a-46d1-9fb0-e75390ca6ca9-000000'),
(887, 1, 'bmatthews710 ', 'bmatthews@goodasgoldtraining.com', NULL, 18, 0, 0, 0, 0, 123, NULL, 1499968132, NULL, 1, ''),
(890, 1, 'bmatthews@hrsearchinc.com ', 'bmatthews@hrsearchinc.com', NULL, 18, 0, 0, 0, 0, 123, NULL, 1499968132, NULL, 1, ''),
(891, 1, 'bbruno ', 'barb@hrsearchinc.com', NULL, 18, 0, 0, 0, 0, 123, NULL, 1499968132, NULL, 1, ''),
(893, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(894, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(895, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(896, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(897, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(898, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(899, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(900, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(901, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(902, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(903, 1, 'test pipl', 'test@gmail.com', NULL, 22, 0, 0, 0, 0, NULL, NULL, 1500286252, NULL, 1, NULL),
(904, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(905, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(906, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(907, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(908, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(909, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(910, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(911, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(912, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(913, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(914, 1, 'test pipl', 'test@gmail.com', NULL, 24, 0, 0, 0, 0, NULL, NULL, 1500286323, NULL, 1, NULL),
(915, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(916, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(917, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(918, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(919, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(920, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(921, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(922, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(923, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(924, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(925, 1, 'test pipl', 'test@gmail.com', NULL, 33, 0, 0, 0, 0, NULL, NULL, 1500286700, NULL, 1, NULL),
(926, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(927, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(928, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(929, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(930, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(931, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(932, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(933, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(934, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(935, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(936, 1, 'test pipl', 'test@gmail.com', NULL, 34, 0, 0, 0, 0, NULL, NULL, 1500286738, NULL, 1, NULL),
(937, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(938, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(939, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(940, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(941, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(942, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(943, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(944, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(945, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(946, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(947, 1, 'test pipl', 'test@gmail.com', NULL, 35, 0, 0, 0, 0, NULL, NULL, 1500286810, NULL, 1, NULL),
(948, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(949, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(950, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(951, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(952, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(953, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(954, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(955, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(956, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(957, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(958, 1, 'test pipl', 'test@gmail.com', NULL, 42, 0, 0, 0, 0, NULL, NULL, 1500287054, NULL, 1, NULL),
(959, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(960, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(961, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(962, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(963, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(964, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(965, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(966, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(967, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(968, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(969, 1, 'test pipl', 'test@gmail.com', NULL, 45, 0, 0, 0, 0, NULL, NULL, 1500287114, NULL, 1, NULL),
(970, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(971, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(972, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(973, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(974, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(975, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(976, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(977, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(978, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(979, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(980, 1, 'test pipl', 'test@gmail.com', NULL, 46, 0, 0, 0, 0, NULL, NULL, 1500287134, NULL, 1, NULL),
(981, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(982, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(983, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(984, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(985, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(986, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(987, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(988, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(989, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(990, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(991, 1, 'test pipl', 'test@gmail.com', NULL, 47, 0, 0, 0, 0, NULL, NULL, 1500287163, NULL, 1, NULL),
(992, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(993, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(994, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(995, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(996, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(997, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(998, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(999, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(1000, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(1001, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(1002, 1, 'test pipl', 'test@gmail.com', NULL, 54, 0, 0, 0, 0, NULL, NULL, 1500287372, NULL, 1, NULL),
(1003, 1, 'Rajendra Kandpal', 'raj20084u@gmail.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1004, 1, 'Matt Connelly', 'matt@matt-connelly.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1005, 1, 'Barb Bruno', 'bbruno@goodasgoldtraining.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1006, 1, 'Matt Connelly', 'matt@digitalmavericks.se', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1007, 1, 'Jhon Rola', 'johnrola36@gmail.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1008, 1, 'Susie Sunshine', 'bmatthews@goodasgoldtraining.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1009, 1, 'Vaishali Kharole', 'vaishali.kharole@gmail.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1010, 1, 'AJ Arjun', 'gunjalarjun05@gmail.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1011, 1, 'nitin mane', 'nitin.mane@redorangetechnologies.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1012, 1, 'Smita Patil-Kadam', 'smile.sp28@gmail.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL),
(1013, 1, 'test pipl', 'test@gmail.com', NULL, 56, 0, 0, 0, 0, NULL, NULL, 1500287772, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `app` int(11) DEFAULT NULL,
  `template_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `html_text` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `userID`, `app`, `template_name`, `html_text`) VALUES
(1, 1, 1, 'Sendy Test', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<div class="image-wrapper">\r\n<div id="listing-image"><!-- Main Image -->\r\n<div id="image-main">\r\n<p style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img alt="MICKEY MOUSE INVITATION, Mickey Birthday Card, Mickey Mouse Party Invitation, Boys Invitation, Polka Dot" src="https://img0.etsystatic.com/052/0/8245346/il_570xN.679502574_o5fi.jpg" width="570" /></p>\r\n\r\n<p style="text-align: center;"><span style="color:#FF0000;"><span style="font-size: 36px;"><span style="font-family: comic sans ms;"><em><strong><span style="background-color:#000000;">&nbsp;Happy Birthday!!!!!&nbsp;</span></strong></em></span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n'),
(2, 1, 1, 'Testing new one', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>abc</p>\r\n</body>\r\n</html>\r\n'),
(3, 1, 1, 'HC Communicator', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<table border="0" cellpadding="0" cellspacing="0" width="688">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt="" height="108" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-header.jpg" width="688" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td align="center" style="border-left: #f4f4f4 1px solid; border-right: #f4f4f4 1px solid" valign="middle">\r\n			<div>&nbsp;\r\n			<center>\r\n			<table align="center" border="0" cellpadding="2" cellspacing="0" style="z-index: 2" width="95%">\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<p>TEXT &nbsp;</p>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</center>\r\n			<br />\r\n			<br />\r\n			<br />\r\n			&nbsp;</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td height="56" width="688"><img alt="" height="56" src="http://www.candidatenextstep.com/userfiles/_content/hc-email-o-footer.jpg" width="688" /></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</body>\r\n</html>\r\n'),
(4, 1, 1, 'New Test Template', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>[firstname]<br />\r\n[lastname]<br />\r\n[Name]<br />\r\n[Email]<br />\r\n[phonenumber]<br />\r\n[zipcode]<br />\r\n[state]<br />\r\n[city]<br />\r\n[country]<br />\r\n[portal_url]<br />\r\n[owner_company_name]<br />\r\n[username]<br />\r\n[forgot_password_link]<br />\r\n[CV_|_Resume_Review_purchase_link]</p>\r\n</body>\r\n</html>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `zapier`
--

CREATE TABLE IF NOT EXISTS `zapier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subscribe_endpoint` varchar(100) DEFAULT NULL,
  `event` varchar(100) DEFAULT NULL,
  `list` int(11) DEFAULT NULL,
  `app` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
