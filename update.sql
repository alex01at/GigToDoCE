UPDATE `app_info` SET `version` = '1.5.3', `r_date` = '20 November 2020';


ALTER TABLE `general_settings` ADD `enable_google_translate` INT(10) NOT NULL AFTER `language_switcher`;

ALTER TABLE `general_settings` ADD `make_phone_number_required` INT(10) NOT NULL AFTER `enable_maintenance_mode`;

ALTER TABLE `general_settings` ADD `enable_websocket` INT(10) NOT NULL AFTER `payouts_anyday`, ADD `websocket_address` VARCHAR(255) NOT NULL AFTER `enable_websocket`;


ALTER TABLE `notifications` ADD `fcm_notification_status` TINYINT(1) NULL AFTER status;


ALTER TABLE `sellers` ADD `seller_phone` VARCHAR(255) NOT NULL AFTER `seller_wallet`;

ALTER TABLE `sellers` ADD `device_type` VARCHAR(15) NOT NULL AFTER `seller_status`, ADD `device_token` INT(10) NOT NULL AFTER `device_type`;

ALTER TABLE `sellers` ADD `inbox_push_notification_status` TINYINT(1) NOT NULL AFTER `device_token`, ADD
`order_message_push_notification_status` TINYINT(1) NOT NULL AFTER `inbox_push_notification_status`, ADD
`order_update_push_notification_status` TINYINT(1) NOT NULL AFTER `order_message_push_notification_status`,
ADD `buyer_req_push_notification_status` TINYINT(1) NOT NULL AFTER `order_update_push_notification_status`,
ADD `myproposal_push_notification_status` TINYINT(1) NOT NULL AFTER `buyer_req_push_notification_status`,
ADD `myaccount_push_notification_status` INT NOT NULL AFTER `myproposal_push_notification_status`;


ALTER TABLE `languages` ADD `template_folder` VARCHAR(255) NOT NULL AFTER `direction`;

UPDATE `languages` SET `template_folder` = 'en' WHERE `languages`.`id` = 1;

ALTER TABLE `support_tickets` ADD `number` INT(11) NOT NULL AFTER `enquiry_id`;


CREATE TABLE `app_license` (
 `id` int(100) NOT NULL AUTO_INCREMENT,
 `purchase_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `license_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_license` (`purchase_code`, `license_type`, `website`) VALUES ('', '', '');

DROP TABLE `countries`;

CREATE TABLE `support_conversations` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `ticket_id` int(11) NOT NULL,
 `admin_id` int(11) NOT NULL,
 `sender_id` int(11) NOT NULL,
 `message` text NOT NULL,
 `date` text NOT NULL,
 `attachment` text DEFAULT NULL,
 `isS3` int(10) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `pages_meta` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `page_id` int(11) NOT NULL,
 `language_id` int(11) NOT NULL,
 `title` text NOT NULL,
 `content` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

INSERT INTO `pages_meta`(`page_id`, `title`, `content`) SELECT `id`, `title`, `content` FROM `pages`;

UPDATE `pages_meta` SET `language_id` = '1';

ALTER TABLE `pages` DROP `title`, DROP `content`, DROP `language_id`;


CREATE TABLE `posts_meta` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `post_id` int(11) NOT NULL,
 `title` text NOT NULL,
 `author` varchar(255) NOT NULL,
 `content` text NOT NULL,
 `language_id` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

INSERT INTO `posts_meta`(`post_id`, `title`, `author`,`content`) SELECT `id`, `title`, `author`, `content` FROM `posts`;

UPDATE `posts_meta` SET `language_id` = '1';

ALTER TABLE `posts` DROP `title`, DROP `author`, DROP `content`, DROP `language_id`;


CREATE TABLE `post_categories_meta` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `cat_id` int(11) NOT NULL,
 `language_id` int(11) NOT NULL,
 `cat_name` varchar(255) DEFAULT NULL,
 `cat_creator` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

INSERT INTO `post_categories_meta`(`cat_id`, `cat_name`, `cat_creator`) SELECT `id`, `cat_name`, `cat_creator` FROM `post_categories`;

UPDATE `post_categories_meta` SET `language_id` = '1';

ALTER TABLE `post_categories` DROP `cat_name`, DROP `cat_creator`;



CREATE TABLE `countries` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
 `code` int(10) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`) VALUES
(1, 'Afghanistan', 93),
(2, 'Aland Islands', 0),
(3, 'Albania', 355),
(4, 'Algeria', 213),
(5, 'American Samoa', 1684),
(6, 'Andorra', 376),
(7, 'Angola', 244),
(8, 'Anguilla', 1264),
(9, 'Antarctica', 0),
(10, 'Antigua And Barbuda', 1268),
(11, 'Argentina', 54),
(12, 'Armenia', 374),
(13, 'Aruba', 297),
(14, 'Australia', 61),
(15, 'Austria', 43),
(16, 'Azerbaijan', 994),
(17, 'Bahamas', 1242),
(18, 'Bahrain', 973),
(19, 'Bangladesh', 880),
(20, 'Barbados', 1246),
(21, 'Belarus', 375),
(22, 'Belgium', 32),
(23, 'Belize', 501),
(24, 'Benin', 229),
(25, 'Bermuda', 1441),
(26, 'Bhutan', 975),
(27, 'Bolivia', 591),
(28, 'Bosnia And Herzegovina', 387),
(29, 'Botswana', 267),
(30, 'Bouvet Island', 0),
(31, 'Brazil', 55),
(32, 'British Indian Ocean Territory', 246),
(33, 'Brunei Darussalam', 673),
(34, 'Bulgaria', 359),
(35, 'Burkina Faso', 226),
(36, 'Burundi', 257),
(37, 'Cambodia', 855),
(38, 'Cameroon', 237),
(39, 'Canada', 1),
(40, 'Cape Verde', 238),
(41, 'Cayman Islands', 1345),
(42, 'Central African Republic', 236),
(43, 'Chad', 235),
(44, 'Chile', 56),
(45, 'China', 86),
(46, 'Christmas Island', 61),
(47, 'Cocos (keeling) Islands', 672),
(48, 'Colombia', 57),
(49, 'Comoros', 269),
(50, 'Congo', 242),
(51, 'Congo, The Democratic Republic Of', 0),
(52, 'Cook Islands', 682),
(53, 'Costa Rica', 506),
(54, 'Cote D\'ivoire', 225),
(55, 'Croatia', 385),
(56, 'Cuba', 53),
(57, 'Cyprus', 357),
(58, 'Czech Republic', 420),
(59, 'Denmark', 45),
(60, 'Djibouti', 253),
(61, 'Dominica', 1767),
(62, 'Dominican Republic', 1809),
(63, 'Ecuador', 593),
(64, 'Egypt', 20),
(65, 'El Salvador', 503),
(66, 'Equatorial Guinea', 240),
(67, 'Eritrea', 291),
(68, 'Estonia', 372),
(69, 'Ethiopia', 251),
(70, 'Falkland Islands (malvinas)', 500),
(71, 'Faroe Islands', 298),
(72, 'Fiji', 679),
(73, 'Finland', 358),
(74, 'France', 33),
(75, 'French Guiana', 594),
(76, 'French Polynesia', 689),
(77, 'French Southern Territories', 0),
(78, 'Gabon', 241),
(79, 'Gambia', 220),
(80, 'Georgia', 995),
(81, 'Germany', 49),
(82, 'Ghana', 233),
(83, 'Gibraltar', 350),
(84, 'Greece', 30),
(85, 'Greenland', 299),
(86, 'Grenada', 1473),
(87, 'Guadeloupe', 590),
(88, 'Guam', 1671),
(89, 'Guatemala', 502),
(90, 'Guernsey', 0),
(91, 'Guinea', 224),
(92, 'Guinea-bissau', 245),
(93, 'Guyana', 592),
(94, 'Haiti', 509),
(95, 'Heard Island And Mcdonald Islands', 0),
(96, 'Holy See (vatican City State)', 39),
(97, 'Honduras', 504),
(98, 'Hong Kong', 852),
(99, 'Hungary', 36),
(100, 'Iceland', 354),
(101, 'India', 91),
(102, 'Indonesia', 62),
(103, 'Iran, Islamic Republic Of', 98),
(104, 'Iraq', 964),
(105, 'Ireland', 353),
(106, 'Isle Of Man', 0),
(107, 'Israel', 972),
(108, 'Italy', 39),
(109, 'Jamaica', 1876),
(110, 'Japan', 81),
(111, 'Jersey', 0),
(112, 'Jordan', 962),
(113, 'Kazakhstan', 7),
(114, 'Kenya', 254),
(115, 'Kiribati', 686),
(116, 'Korea, Democratic People\'s Republic Of', 850),
(117, 'Korea, Republic Of', 82),
(118, 'Kuwait', 965),
(119, 'Kyrgyzstan', 996),
(120, 'Lao People\'s Democratic Republic', 856),
(121, 'Latvia', 371),
(122, 'Lebanon', 961),
(123, 'Lesotho', 266),
(124, 'Liberia', 231),
(125, 'Libyan Arab Jamahiriya', 218),
(126, 'Liechtenstein', 423),
(127, 'Lithuania', 370),
(128, 'Luxembourg', 352),
(129, 'Macao', 853),
(130, 'North Macedonia', 0),
(131, 'Madagascar', 261),
(132, 'Malawi', 265),
(133, 'Malaysia', 60),
(134, 'Maldives', 960),
(135, 'Mali', 223),
(136, 'Malta', 356),
(137, 'Marshall Islands', 692),
(138, 'Martinique', 596),
(139, 'Mauritania', 222),
(140, 'Mauritius', 230),
(141, 'Mayotte', 269),
(142, 'Mexico', 52),
(143, 'Micronesia, Federated States Of', 691),
(144, 'Moldova, Republic Of', 373),
(145, 'Monaco', 377),
(146, 'Mongolia', 976),
(147, 'Montserrat', 1664),
(148, 'Morocco', 212),
(149, 'Mozambique', 258),
(150, 'Myanmar', 95),
(151, 'Namibia', 264),
(152, 'Nauru', 674),
(153, 'Nepal', 977),
(154, 'Netherlands', 31),
(155, 'Netherlands Antilles', 599),
(156, 'New Caledonia', 687),
(157, 'New Zealand', 64),
(158, 'Nicaragua', 505),
(159, 'Niger', 227),
(160, 'Nigeria', 234),
(161, 'Niue', 683),
(162, 'Norfolk Island', 672),
(163, 'Northern Mariana Islands', 1670),
(164, 'Norway', 47),
(165, 'Oman', 968),
(166, 'Pakistan', 92),
(167, 'Palau', 680),
(168, 'Palestinian Territory, Occupied', 970),
(169, 'Panama', 507),
(170, 'Papua New Guinea', 675),
(171, 'Paraguay', 595),
(172, 'Peru', 51),
(173, 'Philippines', 63),
(174, 'Pitcairn', 0),
(175, 'Poland', 48),
(176, 'Portugal', 351),
(177, 'Puerto Rico', 1787),
(178, 'Qatar', 974),
(179, 'Reunion', 262),
(180, 'Romania', 40),
(181, 'Russian Federation', 70),
(182, 'Rwanda', 250),
(183, 'Saint Helena', 290),
(184, 'Saint Kitts And Nevis', 1869),
(185, 'Saint Lucia', 1758),
(186, 'Saint Pierre And Miquelon', 508),
(187, 'Saint Vincent And The Grenadines', 1784),
(188, 'Samoa', 684),
(189, 'San Marino', 378),
(190, 'Sao Tome And Principe', 239),
(191, 'Saudi Arabia', 966),
(192, 'Senegal', 221),
(193, 'Serbia And Montenegro', 381),
(194, 'Seychelles', 248),
(195, 'Sierra Leone', 232),
(196, 'Singapore', 65),
(197, 'Slovakia', 421),
(198, 'Slovenia', 386),
(199, 'Solomon Islands', 677),
(200, 'Somalia', 252),
(201, 'South Africa', 27),
(202, 'South Georgia And The South Sandwich Islands', 0),
(203, 'Spain', 34),
(204, 'Sri Lanka', 94),
(205, 'Sudan', 249),
(206, 'Suriname', 597),
(207, 'Svalbard And Jan Mayen', 47),
(208, 'Swaziland', 268),
(209, 'Sweden', 46),
(210, 'Switzerland', 41),
(211, 'Syrian Arab Republic', 963),
(212, 'Taiwan, Province Of China', 886),
(213, 'Tajikistan', 992),
(214, 'Tanzania, United Republic Of', 255),
(215, 'Thailand', 66),
(216, 'Timor-leste', 670),
(217, 'Togo', 228),
(218, 'Tokelau', 690),
(219, 'Tonga', 676),
(220, 'Trinidad And Tobago', 1868),
(221, 'Tunisia', 216),
(222, 'Turkey', 90),
(223, 'Turkmenistan', 7370),
(224, 'Turks And Caicos Islands', 1649),
(225, 'Tuvalu', 688),
(226, 'Uganda', 256),
(227, 'Ukraine', 380),
(228, 'United Arab Emirates', 971),
(229, 'United Kingdom', 44),
(230, 'United States', 1),
(231, 'United States Minor Outlying Islands', 1),
(232, 'Uruguay', 598),
(233, 'Uzbekistan', 998),
(234, 'Vanuatu', 678),
(235, 'Venezuela', 58),
(236, 'Viet Nam', 84),
(237, 'Virgin Islands, British', 1284),
(238, 'Virgin Islands, U.S.', 1340),
(239, 'Wallis And Futuna', 681),
(240, 'Western Sahara', 212),
(241, 'Yemen', 967),
(242, 'Zambia', 260),
(243, 'Zimbabwe', 263),
(245, 'Myanmar (Burma)', 0);
