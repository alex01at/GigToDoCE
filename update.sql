UPDATE `app_info` SET `version` = '1.5.1', `r_date` = '9 May 2020';


ALTER TABLE `general_settings` ADD `enable_mobile_logo` INT(10) NOT NULL AFTER `site_logo_image`, ADD `site_mobile_logo` VARCHAR(255) NOT NULL AFTER `enable_mobile_logo`, ADD `site_mobile_logo_s3` INT(10) NOT NULL AFTER `site_logo_image_s3`;

ALTER TABLE `seller_accounts` CHANGE `withdrawn` `withdrawn` VARCHAR(255) NOT NULL DEFAULT '0', CHANGE `current_balance` `current_balance` VARCHAR(255) NOT NULL DEFAULT '0', CHANGE `used_purchases` `used_purchases` VARCHAR(255) NOT NULL DEFAULT '0', CHANGE `pending_clearance` `pending_clearance` VARCHAR(255) NOT NULL DEFAULT '0', CHANGE `month_earnings` `month_earnings` VARCHAR(255) NOT NULL DEFAULT '0';

ALTER TABLE `purchases` ADD `reason` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL AFTER `order_id`;


ALTER TABLE `home_section` CHANGE `section_heading` `section_heading` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `payment_settings` ADD `dusupay_webhook_hash` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL AFTER `dusupay_secret_key`;

ALTER TABLE `payment_settings` ADD `coinpayments_ipn_secret` VARCHAR(255) NOT NULL AFTER `coinpayments_private_key`;


UPDATE `purchases` SET `reason` = 'order';

UPDATE `general_settings` SET `enable_mobile_logo` = '1', `site_mobile_logo` = 'mobile-logo.png';

UPDATE `general_settings` SET `site_watermark` = 'watermark.png';

UPDATE `footer_links` SET `icon_class` = 'fa fa-life-ring' WHERE `link_title` = 'Customer Support';

UPDATE `footer_links` SET `icon_class` = 'fa fa-comments-o',`link_url` = '/feedback/' WHERE `link_title` = 'Feedback';

UPDATE `footer_links` SET `link_url` = '/blog/' WHERE `link_title` = 'Blog';



CREATE TABLE `dusupay_orders` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `buyer_id` int(10) NOT NULL,
 `content_id` int(10) NOT NULL,
 `qty` int(10) NOT NULL,
 `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `delivery_id` int(10) NOT NULL,
 `revisions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `minutes` int(10) NOT NULL,
 `extras` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `temp_extras` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `buyer_id` int(10) NOT NULL,
 `item_id` int(10) NOT NULL,
 `proposal_id` int(10) NOT NULL,
 `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `price` text COLLATE utf8mb4_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `temp_orders` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `buyer_id` int(10) NOT NULL,
 `content_id` int(10) NOT NULL,
 `qty` int(10) NOT NULL,
 `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `delivery_id` int(10) NOT NULL,
 `revisions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `minutes` int(10) NOT NULL,
 `video` int(10) NOT NULL,
 `extras` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `categories` CHANGE `cat_url` `cat_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `categories_children` CHANGE `child_url` `child_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `knowledge_bank` CHANGE `article_heading` `article_heading` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `knowledge_bank` CHANGE `article_url` `article_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;


ALTER TABLE `announcement_bar` CHANGE `bg_color` `bg_color` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `text_color` `text_color` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `bar_text` `bar_text` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `last_updated` `last_updated` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

ALTER TABLE `api_settings` CHANGE `s3_access_key` `s3_access_key` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `s3_access_sceret` `s3_access_sceret` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `s3_bucket` `s3_bucket` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `s3_region` `s3_region` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `s3_domain` `s3_domain` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `instant_deliveries` CHANGE `message` `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `file` `file` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `order_tips` CHANGE `message` `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `comments` CHANGE `comment` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `ideas` CHANGE `title` `title` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `content` `content` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `date` `date` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `pages` CHANGE `title` `title` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `url` `url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `content` `content` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `posts` CHANGE `title` `title` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `cat_id` `cat_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `author` `author` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `image` `image` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `content` `content` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `date_time` `date_time` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `post_categories` CHANGE `cat_name` `cat_name` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `cat_image` `cat_image` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `cat_creator` `cat_creator` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `date_time` `date_time` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `post_comments` CHANGE `comment` `comment` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, CHANGE `date` `date` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;


ALTER TABLE `package_attributes` CHANGE `attribute_id` `attribute_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pages` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `payment_settings` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `payouts` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `plugins` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `post_categories` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `post_comments` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `posts` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proposal_modifications` CHANGE `modification_id` `modification_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proposal_packages` CHANGE `package_id` `package_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proposal_referrals` CHANGE `referral_id` `referral_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proposals` CHANGE `proposal_id` `proposal_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proposals_extras` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proposals_faq` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchases` CHANGE `purchase_id` `purchase_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `recent_proposals` CHANGE `recent_id` `recent_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `referrals` CHANGE `referral_id` `referral_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `reports` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `revenues` CHANGE `revenue_id` `revenue_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sales` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `section_boxes` CHANGE `box_id` `box_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_accounts` CHANGE `account_id` `account_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_languages` CHANGE `language_id` `language_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_levels` CHANGE `level_id` `level_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_levels_meta` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_payment_settings` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_reviews` CHANGE `review_id` `review_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_skills` CHANGE `skill_id` `skill_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seller_type_status` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sellers` CHANGE `seller_id` `seller_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `send_offers` CHANGE `offer_id` `offer_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `site_currencies` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `skills_relation` CHANGE `relation_id` `relation_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `slider` CHANGE `slide_id` `slide_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `smtp_settings` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `spam_words` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `starred_messages` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `support_tickets` CHANGE `ticket_id` `ticket_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `terms` CHANGE `term_id` `term_id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `top_proposals` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `unread_messages` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `withdrawals` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;



ALTER TABLE `smtp_settings` ADD `library` VARCHAR(255) NOT NULL AFTER `id`;

UPDATE `smtp_settings` SET `library` = 'php_mailer';

ALTER TABLE `cart` ADD `delivery_id` INT(10) NOT NULL AFTER `proposal_qty`;

ALTER TABLE `payment_settings` ADD `dusupay_method` VARCHAR(255) NOT NULL AFTER `dusupay_secret_key`, ADD `dusupay_provider_id` VARCHAR(255) NOT NULL AFTER `dusupay_method`, ADD `dusupay_payout_method` VARCHAR(255) NOT NULL AFTER `dusupay_provider_id`, ADD `dusupay_payout_provider_id` VARCHAR(255) NOT NULL AFTER `dusupay_payout_method`;

TRUNCATE `cart`;

DROP TABLE `email_content`;
