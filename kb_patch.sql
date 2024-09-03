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

CREATE TABLE `countries` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;


CREATE TABLE `currencies` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `currencies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

CREATE TABLE `proposals` (
  `id` bigint(20) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `lead_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `currency` tinyint(4) DEFAULT NULL,
  `assigned_agent_id` bigint(20) NOT NULL,
  `send_to` varchar(250) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `country_id` bigint(20) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `send_to_email` varchar(250) DEFAULT NULL,
  `send_to_phone` varchar(20) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `adjustment` decimal(10,0) DEFAULT NULL,
  `sub_total` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `status` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `proposals`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

CREATE TABLE `proposal_products` (
  `id` bigint(20) NOT NULL,
  `proposal_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `proposal_products`
  ADD PRIMARY KEY (`id`);

  CREATE TABLE `email_queue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` char(20) DEFAULT NULL,
  `user_id` char(20) NOT NULL,
  `email_from` char(20) DEFAULT NULL,
  `email_to` char(180) NOT NULL,
  `email_subject` varchar(191) NOT NULL,
  `email_content` text NOT NULL,
  `send_status` varchar(30) DEFAULT NULL,
  `priority_level` tinyint(4) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `email_queue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;


ALTER TABLE `email_log` CHANGE `send_status` `send_status` VARCHAR(30) NULL DEFAULT NULL;

ALTER TABLE `email_queue` CHANGE `user_id` `customer_id` BIGINT(20) NULL;

ALTER TABLE `sms_queue` CHANGE `user_id` `customer_id` BIGINT(20) NULL;

ALTER TABLE `logs` ADD `module` VARCHAR(180) NULL AFTER `user_id`;

ALTER TABLE `logs` ADD `sub_module` VARCHAR(180) NULL AFTER `module`;

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


ALTER TABLE `campaign_data` ADD COLUMN `csv_id` CHAR(10) NULL AFTER `sms_template_id`;

ALTER TABLE `sms_queue` CHANGE `send_status` `send_status` VARCHAR(30) NULL;

ALTER TABLE `email_queue` ADD COLUMN `csv_id` CHAR(10) NULL AFTER `send_status`;

ALTER TABLE `sms_queue` ADD COLUMN `csv_id` CHAR(10) NULL AFTER `send_status`;

ALTER TABLE lead_form_details CHANGE character_length character_length VARCHAR(191) NULL;

ALTER TABLE `lead_form_details` ADD COLUMN `view_type` VARCHAR(100) NULL AFTER `is_unique`;

ALTER TABLE `lead_form_details` ADD COLUMN `form_size` VARCHAR(100) NULL AFTER `view_type`;

ALTER TABLE `leads` ADD `profile_image` VARCHAR(191) NULL DEFAULT NULL AFTER `phone`;


