use project;



CREATE TABLE IF NOT EXISTS `categories` (
                                            `category_id` smallint unsigned NOT NULL AUTO_INCREMENT,
                                            `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                            `description` tinytext COLLATE utf8mb4_general_ci,
                                            `is_active` tinyint unsigned DEFAULT '1',
                                            `created_by` smallint unsigned DEFAULT NULL,
                                            `created_at` datetime DEFAULT NULL,
                                            `updated_by` smallint unsigned DEFAULT NULL,
                                            `updated_at` datetime DEFAULT NULL,
                                            PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table project.categories: ~0 rows (approximately)
INSERT INTO `categories` (`category_id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
    (1, 'generic', 'generic', 1, 1, '2023-12-17 14:20:58', NULL, NULL);

-- Dumping structure for table project.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
                                       `task_id` int unsigned NOT NULL AUTO_INCREMENT,
                                       `parent_task_id` int unsigned DEFAULT NULL COMMENT 'in case we want to get more deep ( sub-tasks ..etc ..)',
                                       `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
                                       `public_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'for easy tracking between users..',
                                       `description` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                                       `created_by` smallint unsigned DEFAULT NULL,
                                       `created_at` datetime DEFAULT NULL,
                                       `updated_by` smallint unsigned DEFAULT NULL,
                                       `updated_at` datetime DEFAULT NULL,
                                       `deleted_by` smallint unsigned DEFAULT NULL,
                                       `deleted_at` datetime DEFAULT NULL,
                                       PRIMARY KEY (`task_id`) USING BTREE,
                                       KEY `deleted_at` (`deleted_at`),
                                       KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table project.tasks: ~0 rows (approximately)
INSERT INTO `tasks` (`task_id`, `parent_task_id`, `title`, `public_id`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
                                                                                                                                                                               (1, NULL, 'test', NULL, 'test', 1, '2023-12-17 14:21:24', NULL, NULL, NULL, NULL),
                                                                                                                                                                               (2, NULL, 'test task creation', NULL, 'here is the description', 1, '2023-12-17 13:11:29', NULL, NULL, NULL, NULL),
                                                                                                                                                                               (3, NULL, 'test task creation1', NULL, 'here is the description1', 1, '2023-12-17 13:12:04', 1, '2023-12-17 13:17:09', 1, '2023-12-17 13:28:44');

-- Dumping structure for table project.task_categories
CREATE TABLE IF NOT EXISTS `task_categories` (
                                                 `task_category_id` int unsigned NOT NULL AUTO_INCREMENT,
                                                 `task_id` int unsigned NOT NULL,
                                                 `category_id` smallint unsigned NOT NULL,
                                                 `created_by` smallint unsigned DEFAULT NULL,
                                                 `created_at` datetime DEFAULT NULL,
                                                 `deleted_by` smallint unsigned DEFAULT NULL,
                                                 `deleted_at` datetime DEFAULT NULL,
                                                 PRIMARY KEY (`task_category_id`),
                                                 KEY `deleted_at` (`deleted_at`),
                                                 KEY `FK_task_categories_tasks` (`task_id`),
                                                 KEY `FK_task_categories_categories` (`category_id`),
                                                 CONSTRAINT `FK_task_categories_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                                                 CONSTRAINT `FK_task_categories_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table project.task_categories: ~0 rows (approximately)
INSERT INTO `task_categories` (`task_category_id`, `task_id`, `category_id`, `created_by`, `created_at`, `deleted_by`, `deleted_at`) VALUES
                                                                                                                                         (1, 3, 1, NULL, NULL, NULL, '2023-12-17 13:25:48'),
                                                                                                                                         (2, 3, 1, 1, '2023-12-17 13:25:59', NULL, '2023-12-17 13:26:15'),
                                                                                                                                         (3, 3, 1, 1, '2023-12-17 13:26:15', NULL, '2023-12-17 13:26:31'),
                                                                                                                                         (4, 3, 1, 1, '2023-12-17 13:26:31', NULL, '2023-12-17 13:26:39'),
                                                                                                                                         (5, 3, 1, 1, '2023-12-17 13:26:39', NULL, '2023-12-17 13:26:55'),
                                                                                                                                         (6, 3, 1, 1, '2023-12-17 13:26:55', NULL, '2023-12-17 13:28:11'),
                                                                                                                                         (7, 3, 1, 1, '2023-12-17 13:28:11', NULL, '2023-12-17 13:28:44');

-- Dumping structure for table project.users
CREATE TABLE IF NOT EXISTS `users` (
                                       `user_id` smallint unsigned NOT NULL AUTO_INCREMENT,
                                       `public_user_id` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `middle_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `password` char(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `date_of_birth` date DEFAULT NULL,
                                       `nationality_id` char(2) COLLATE utf8mb4_general_ci DEFAULT 'LB' COMMENT 'country iso2 code ..',
                                       `is_active` tinyint unsigned DEFAULT '1',
                                       `created_at` datetime DEFAULT NULL,
                                       `created_by` smallint unsigned DEFAULT NULL,
                                       `updated_at` datetime DEFAULT NULL,
                                       `updated_by` smallint unsigned DEFAULT NULL,
                                       `system_timestamp` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                       PRIMARY KEY (`user_id`) USING BTREE,
                                       UNIQUE KEY `public_user_id` (`public_user_id`) USING BTREE,
                                       UNIQUE KEY `email` (`email`) USING BTREE,
                                       KEY `email_password` (`email`,`password`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table project.users: ~0 rows (approximately)
INSERT INTO `users` (`user_id`, `public_user_id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `date_of_birth`, `nationality_id`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`, `system_timestamp`) VALUES
                                                                                                                                                                                                                                                 (1, 'USR202312CYvCu', 'abbass', 'ali', 'kassem', 'abbass.kassem@gmail.com', '$2y$12$6WnXZJUCIhOYPcGNvXSzMeOHDIoWkA0dglSV49EEg8etttc5YHb/m', '1985-10-09', 'LB', 1, '2023-12-17 12:06:38', NULL, NULL, NULL, '2023-12-17 12:06:38'),
                                                                                                                                                                                                                                                 (2, 'USR202312CBKlb', 'abbass', 'ali', 'kassem', 'abbass.kassem1@gmail.com', '$2y$12$4txzAsRtKUBYF/IpZn68x.MOw.RobWw1dMBAZ8xFK6ySpG.PKFhgm', '1985-10-09', 'LB', 1, '2023-12-17 12:07:58', NULL, NULL, NULL, '2023-12-17 12:07:58');

-- Dumping structure for table project.user_tickets
CREATE TABLE IF NOT EXISTS `user_tickets` (
                                              `user_ticket_id` int unsigned NOT NULL AUTO_INCREMENT,
                                              `parent_user_ticket_id` int unsigned DEFAULT NULL COMMENT 'in case of reassigning for example ..',
                                              `user_id` smallint unsigned DEFAULT NULL,
                                              `public_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
                                              `task_id` int unsigned DEFAULT NULL,
                                              `assigner_user_id` smallint unsigned NOT NULL,
                                              `status` enum('pending','inprogress','snoozed','done','cancelled','reassigned') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending',
                                              `assignment_datetime` datetime DEFAULT NULL,
                                              `due_date` date DEFAULT NULL,
                                              `done_datetime` datetime DEFAULT NULL,
                                              `cancellation_datetime` datetime DEFAULT NULL,
                                              `snooze_datetime` datetime DEFAULT NULL,
                                              `snooze_reason_id` datetime DEFAULT NULL COMMENT 'we can have a separate table for reason of snoozing tasks.or even more generic one for all statuses ..',
                                              `created_by` smallint unsigned DEFAULT NULL,
                                              `created_at` datetime DEFAULT NULL,
                                              `updated_by` datetime DEFAULT NULL,
                                              `updated_at` smallint unsigned DEFAULT NULL,
                                              PRIMARY KEY (`user_ticket_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table project.user_tickets: ~0 rows (approximately)
INSERT INTO `user_tickets` (`user_ticket_id`, `parent_user_ticket_id`, `user_id`, `public_id`, `task_id`, `assigner_user_id`, `status`, `assignment_datetime`, `due_date`, `done_datetime`, `cancellation_datetime`, `snooze_datetime`, `snooze_reason_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
                                                                                                                                                                                                                                                                                                                        (1, NULL, 2, NULL, 1, 1, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-12-17 13:48:49', NULL, NULL),
                                                                                                                                                                                                                                                                                                                        (2, NULL, 2, NULL, 1, 1, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-12-17 13:49:25', NULL, NULL),
                                                                                                                                                                                                                                                                                                                        (3, NULL, 2, NULL, 1, 1, 'pending', NULL, '2023-12-20', NULL, NULL, NULL, NULL, 1, '2023-12-17 13:50:27', NULL, NULL),
                                                                                                                                                                                                                                                                                                                        (4, NULL, 2, NULL, 1, 1, 'pending', '2023-12-17 13:51:29', '2023-12-20', NULL, NULL, NULL, NULL, 1, '2023-12-17 13:51:29', NULL, NULL),
                                                                                                                                                                                                                                                                                                                        (5, NULL, 1, NULL, 1, 1, 'pending', '2023-12-17 13:51:44', '2023-12-20', NULL, NULL, NULL, NULL, 1, '2023-12-17 13:51:44', NULL, NULL),
                                                                                                                                                                                                                                                                                                                        (6, NULL, 1, NULL, 1, 1, 'pending', '2023-12-17 14:05:40', '2023-12-20', NULL, NULL, NULL, NULL, 1, '2023-12-17 14:05:40', NULL, NULL);

-- Dumping structure for table project.user_ticket_comments
CREATE TABLE IF NOT EXISTS `user_ticket_comments` (
                                                      `user_ticket_comment_id` int unsigned NOT NULL AUTO_INCREMENT,
                                                      `user_ticket_id` int unsigned DEFAULT NULL,
                                                      `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                                                      `created_by` smallint unsigned DEFAULT NULL,
                                                      `created_at` datetime DEFAULT NULL,
                                                      PRIMARY KEY (`user_ticket_comment_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



