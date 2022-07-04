UPDATE `app_info` SET `version` = '1.5.4', `r_date` = '25 December 2020';

ALTER TABLE `general_settings` ADD `google_app_link` VARCHAR(255) NOT NULL AFTER `recaptcha_secret_key`, ADD `apple_app_link` VARCHAR(255) NOT NULL AFTER `google_app_link`;

ALTER TABLE `general_settings` ADD `mobileApp_apiKey` VARCHAR(255) NOT NULL AFTER `websocket_address`;

UPDATE `general_settings` SET `mobileApp_apiKey` = '514895106';

ALTER TABLE `general_settings` ADD `enable_google_translate` INT(10) NOT NULL AFTER `language_switcher`;
