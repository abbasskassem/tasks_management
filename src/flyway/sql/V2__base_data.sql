use `project`;

INSERT INTO `roles` (`role_id`, `role`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES ('admin.view_user', 'View User Details', 'View all the user necessary info', 1, 1, '2023-12-16 20:18:14', NULL, NULL);
INSERT INTO `roles` (`role_id`, `role`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES ('admin.reset_user_password', 'Reset User Password', 'Ability to reset password for users', 1, 1, '2023-12-16 20:18:12', NULL, NULL);
INSERT INTO `roles` (`role_id`, `role`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES ('admin.create_user', 'Create User', 'Create new User', 1, 1, '2023-12-16 20:17:17', NULL, NULL);


INSERT INTO `users` (`user_id`, `public_user_id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`, `system_timestamp`) VALUES (1, 'USR202312CKhbV', 'abbass', 'ali', 'kassem', 'abbass.kassem@gmail.com', '$2y$12$N9gbQn4li0h/zO3WzbIIPeEz0pwbLBSDU/M8jVKheBvXa2pyq0vMi', 1, '2023-12-16 17:46:14', 1, NULL, NULL, NULL);


INSERT INTO `groups` (`group_id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES (1, 'super admin', 'Root Group', 1, 1, '2023-12-16 19:49:21', NULL, NULL);
INSERT INTO `groups` (`group_id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES (2, 'admin', 'admin', 1, 1, '2023-12-16 19:49:35', NULL, NULL);
INSERT INTO `groups` (`group_id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES (3, 'viewer', 'viewer mode', 1, 1, '2023-12-16 19:49:56', NULL, NULL);


INSERT INTO `user_groups` (`user_group_id`, `user_id`, `group_id`, `created_by`, `created_at`, `deleted_by`, `deleted_at`) VALUES (1, 1, 1, 1, '2023-12-16 19:50:13', NULL, NULL);
INSERT INTO `user_groups` (`user_group_id`, `user_id`, `group_id`, `created_by`, `created_at`, `deleted_by`, `deleted_at`) VALUES (2, 1, 2, 1, '2023-12-16 19:50:24', NULL, NULL);
INSERT INTO `user_groups` (`user_group_id`, `user_id`, `group_id`, `created_by`, `created_at`, `deleted_by`, `deleted_at`) VALUES (3, 1, 2, 1, '2023-12-16 19:50:34', NULL, NULL);


INSERT INTO `group_roles` (`group_role_id`, `group_id`, `role_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES (1, 1, 'admin.create_user', '2023-12-16 20:18:32', 1, NULL, NULL, NULL, NULL);
INSERT INTO `group_roles` (`group_role_id`, `group_id`, `role_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES (2, 1, 'admin.reset_user_password', '2023-12-16 20:18:43', 1, NULL, NULL, NULL, NULL);
INSERT INTO `group_roles` (`group_role_id`, `group_id`, `role_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES (3, 1, 'admin.view_user', '2023-12-16 20:18:59', 1, NULL, NULL, NULL, NULL);
INSERT INTO `group_roles` (`group_role_id`, `group_id`, `role_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES (4, 2, 'admin.create_user', '2023-12-16 20:19:07', 1, NULL, NULL, NULL, NULL);
INSERT INTO `group_roles` (`group_role_id`, `group_id`, `role_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES (5, 2, 'admin.view_user', '2023-12-16 20:19:07', 1, NULL, NULL, NULL, NULL);

