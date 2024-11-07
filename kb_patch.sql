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

ALTER TABLE `sms_queue` ADD `user_id` BIGINT NULL AFTER `delete_request`;

ALTER TABLE `products` CHANGE `product_cost` `product_cost` DOUBLE(20,2) NULL DEFAULT NULL;

ALTER TABLE `products` CHANGE `product_value` `product_value` DOUBLE(20,2) NULL DEFAULT NULL;

ALTER TABLE `sms_queue` ADD `lead_id` BIGINT NULL AFTER `send_status`;



ALTER TABLE `email_templates` ADD `created_by` BIGINT NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `email_templates` ADD `updated_by` BIGINT NULL DEFAULT NULL AFTER `created_by`;

ALTER TABLE `sms_templates` ADD `created_by` BIGINT NULL DEFAULT NULL AFTER `status`, ADD `updated_by` BIGINT NULL DEFAULT NULL AFTER `created_by`;
ALTER TABLE `products` ADD `created_by` BIGINT NULL DEFAULT NULL AFTER `status`, ADD `updated_by` BIGINT NULL DEFAULT NULL AFTER `created_by`;

-- 06/11/24
ALTER TABLE `email_queue` ADD `user_id` BIGINT NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `email_queue` CHANGE `user_id` `user_id` INT NULL DEFAULT NULL;

ALTER TABLE `email_queue` CHANGE `campaign_id` `campaign_id` BIGINT NULL DEFAULT NULL, CHANGE `meeting_id` `meeting_id` BIGINT NULL DEFAULT NULL;

ALTER TABLE `email_log` ADD `meeting_id` BIGINT NULL DEFAULT NULL AFTER `user_id`, ADD `csv_id` BIGINT NULL DEFAULT NULL AFTER `meeting_id`;

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

CREATE TABLE `meetings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) unsigned DEFAULT NULL,
  `recipients` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `meeting_subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_date` datetime NOT NULL,
  `meeting_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachments` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_email` tinyint(4) DEFAULT NULL,
  `send_sms` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `meeting_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint(3) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)

ALTER TABLE `leads` ADD COLUMN `created_by` INT(11) UNSIGNED NULL AFTER `lead_notes`;

ALTER TABLE `roles` ADD `menu_details` LONGTEXT NULL DEFAULT NULL AFTER `slug`;

ALTER TABLE `menus` CHANGE `sub_name` `sub_name` CHAR(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `email_queue` ADD COLUMN `meeting_id` CHAR(20) NULL AFTER `customer_id`;
ALTER TABLE `sms_queue` ADD COLUMN `meeting_id` CHAR(20) NULL AFTER `customer_id`;
ALTER TABLE `sms_queue` CHANGE `sms_text` `sms_text` TEXT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;



CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci DEFAULT 'BDT',
  `sub_total` decimal(15,2) DEFAULT 0.00,
  `discount` decimal(15,2) DEFAULT 0.00,
  `discount_type` enum('No discount','Before tax','After tax') COLLATE utf8mb4_unicode_ci DEFAULT 'No discount',
  `adjustment` decimal(15,2) DEFAULT 0.00,
  `total_amount` decimal(15,2) DEFAULT 0.00,
  `total_tax` decimal(15,2) DEFAULT 0.00,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_conditions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prevent_reminders` tinyint(4) DEFAULT NULL,
  `is_recurring` tinyint(4) DEFAULT NULL,
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_agent_id` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_number` (`invoice_number`),
  KEY `fk_customer_id` (`customer_id`),
  CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


ALTER TABLE `campaigns` CHANGE `start_date` `start_date` DATETIME NULL,CHANGE `end_date` `end_date` DATETIME NULL;
ALTER TABLE `proposals` CHANGE `currency` `currency` CHAR(10) NULL DEFAULT NULL;

ALTER TABLE `proposals` ADD `first_name` VARCHAR(50) NULL DEFAULT NULL AFTER `assigned_agent_id`; 
ALTER TABLE `proposals` CHANGE `country_id` `country_name` VARCHAR(50) NULL DEFAULT NULL;
ALTER TABLE `proposals` ADD `item_name` VARCHAR(255) NULL DEFAULT NULL AFTER `country_name`, ADD `item_description` TEXT NULL DEFAULT NULL AFTER `item_name`;
ALTER TABLE `proposals` CHANGE `adjustment` `price` DECIMAL(10,0) NULL DEFAULT NULL;
ALTER TABLE `proposals` CHANGE `sub_total` `offer_price` DECIMAL(10,0) NULL DEFAULT NULL;
ALTER TABLE `proposals` CHANGE `discount` `discount` DECIMAL(10,2) NULL DEFAULT NULL; 
ALTER TABLE `proposals` CHANGE `price` `price` DECIMAL(10,2) NULL DEFAULT NULL; 
ALTER TABLE `proposals` CHANGE `offer_price` `offer_price` DECIMAL(10,2) NULL DEFAULT NULL; 
ALTER TABLE `proposals` CHANGE `total` `total_price` DECIMAL(10,2) NULL DEFAULT NULL;
ALTER TABLE `proposals` ADD `tax_percent` DECIMAL(3,1) NULL DEFAULT NULL AFTER `discount`, ADD `tax_amount` DECIMAL(10,2) NULL DEFAULT NULL AFTER `tax_percent`;
ALTER TABLE `proposals` ADD `proposal_file_name` VARCHAR(255) NULL DEFAULT NULL AFTER `country_name`;
ALTER TABLE `proposals` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `status`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;


-- 10-10-2024
ALTER TABLE `proposals` CHANGE `status` `status` CHAR(15) NULL DEFAULT NULL;
ALTER TABLE `proposals` CHANGE `assigned_agent_id` `assigned_agent_id` INT NULL DEFAULT NULL;
ALTER TABLE `proposals` ADD `company_name` VARCHAR(50) NULL DEFAULT NULL AFTER `lead_id`;
ALTER TABLE `proposals` CHANGE `send_to_phone` `phone` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
  -- delete send_to_email column

  CREATE TABLE `countries` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `currencies` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `logs` ADD `lead_id` INT NULL DEFAULT NULL AFTER `user_id`;


--not update in live server
CREATE TABLE invoice_custom_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_name VARCHAR(255) NOT NULL,
    field_details TEXT,
    footer_details TEXT,
    total_in_word VARCHAR(255),
    bank_details TEXT,
    issued_by TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE `invoices` ADD COLUMN `payment_details` TEXT NULL AFTER `item_description`;

-- 31-10-2024
ALTER TABLE `email_queue` CHANGE `customer_id` `lead_id` BIGINT NULL DEFAULT NULL;

--05-11-2024
ALTER TABLE `campaigns` ADD COLUMN `created_by` INT(11) UNSIGNED NULL AFTER `promotion_id`;