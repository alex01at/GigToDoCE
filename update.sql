UPDATE `app_info` SET `version` = '1.5.0', `r_date` = '2 May 2020';

ALTER TABLE `smtp_settings` ADD `library` VARCHAR(255) NOT NULL AFTER `id`;

UPDATE `smtp_settings` SET `library` = 'php_mailer';

ALTER TABLE `cart` ADD `delivery_id` INT(10) NOT NULL AFTER `proposal_qty`;

ALTER TABLE `payment_settings` ADD `dusupay_method` VARCHAR(255) NOT NULL AFTER `dusupay_secret_key`, ADD `dusupay_provider_id` VARCHAR(255) NOT NULL AFTER `dusupay_method`, ADD `dusupay_payout_method` VARCHAR(255) NOT NULL AFTER `dusupay_provider_id`, ADD `dusupay_payout_provider_id` VARCHAR(255) NOT NULL AFTER `dusupay_payout_method`;

TRUNCATE `cart`;

DROP TABLE `email_content`;