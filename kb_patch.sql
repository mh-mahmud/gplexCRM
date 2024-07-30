ALTER TABLE `permissions` CHANGE `permission_group_id` `permission_group_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `permissions` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `roles` CHANGE `details` `permision_details` JSON NULL DEFAULT NULL;
ALTER TABLE `roles` ADD `permission_ids` JSON NULL DEFAULT NULL AFTER `permission_details`;
ALTER TABLE users ADD COLUMN username VARCHAR(191) UNIQUE AFTER user_id;



---Ishtiak SQL start 

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` char(180) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime NOT NULL,
  `assigned_to` bigint(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

ALTER TABLE `products` CHANGE `product_type` `product_type` TINYINT(1) NOT NULL, CHANGE `status` `status` TINYINT(1) NOT NULL;

ALTER TABLE `products` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `products` CHANGE `product_cost` `product_cost` DECIMAL(8,2) NULL, CHANGE `product_value` `product_value` DECIMAL(8,2) NULL;
---Ishtiak SQL end

ALTER TABLE `products` ADD `img_path` VARCHAR(180) NULL AFTER `product_code`;

CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `log_message` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;
---Ishtiak SQL end

CREATE TABLE customers LIKE leads;


CREATE TABLE `campaign_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint(20) DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_template_id` int(11) DEFAULT NULL,
  `sms_template_id` int(11) DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campaign_data_email_unique` (`email`)
)


ALTER TABLE campaigns ADD COLUMN form_id CHAR(10) NULL AFTER id;

ALTER TABLE campaigns ADD COLUMN email_template_id INT(20) NULL AFTER form_id,
ADD COLUMN sms_template_id INT(20) NULL AFTER email_template_id;

ALTER TABLE campaigns ADD COLUMN template_type VARCHAR(192) NULL AFTER campaign_type;


