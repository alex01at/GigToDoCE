UPDATE `app_info` SET `version` = '1.5.2', `r_date` = '20 August 2020';

ALTER TABLE `payment_settings` ADD `stripe_webhook_key` VARCHAR(255) NOT NULL AFTER `stripe_publishable_key`;

ALTER TABLE `instant_deliveries` ADD `watermark` INT(10) NOT NULL AFTER `message`, ADD `watermark_file` VARCHAR(255) NOT NULL AFTER `watermark`;