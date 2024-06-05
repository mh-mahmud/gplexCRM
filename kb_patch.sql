ALTER TABLE `permissions` CHANGE `permission_group_id` `permission_group_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `permissions` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `roles` CHANGE `details` `permision_details` JSON NULL DEFAULT NULL;
ALTER TABLE `roles` ADD `permission_ids` JSON NULL DEFAULT NULL AFTER `permission_details`;