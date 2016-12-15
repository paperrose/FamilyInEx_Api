CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password_hash` varchar(100) DEFAULT NULL,
  `small_password_hash` varchar(100) DEFAULT NULL,
  `device_id` varchar(100) DEFAULT NULL,
  `surname_eng` varchar(100) DEFAULT NULL,
  `first_name_eng` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `icons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `finance_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `group_password_hash` varchar(100) DEFAULT NULL,
  `has_exchanges` tinyint(1) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finance_groups_creator_id_a4534023_fk_users_id` (`creator_id`),
  CONSTRAINT `finance_groups_creator_id_a4534023_fk_users_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pay_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `pay_name` varchar(100) NOT NULL,
  `pay_eng` varchar(100) DEFAULT NULL,
  `icon_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pay_types_icon_id_806dad2e_fk_icons_id` (`icon_id`),
  KEY `pay_types_image_id_47d44ef9_fk_images_id` (`image_id`),
  CONSTRAINT `pay_types_icon_id_806dad2e_fk_icons_id` FOREIGN KEY (`icon_id`) REFERENCES `icons` (`id`),
  CONSTRAINT `pay_types_image_id_47d44ef9_fk_images_id` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `expense_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `expense_name` varchar(100) NOT NULL,
  `expense_name_eng` varchar(100) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `icon_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_types_icon_id_51c79dbf_fk_icons_id` (`icon_id`),
  KEY `expense_types_image_id_1b065ab3_fk_images_id` (`image_id`),
  KEY `expense_types_creator_id_666a2d62_fk_users_id` (`creator_id`),
  CONSTRAINT `expense_types_creator_id_666a2d62_fk_users_id` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `expense_types_icon_id_51c79dbf_fk_icons_id` FOREIGN KEY (`icon_id`) REFERENCES `icons` (`id`),
  CONSTRAINT `expense_types_image_id_1b065ab3_fk_images_id` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `finance_groups_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apifinancegroups_id` int(11) NOT NULL,
  `apiusers_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `finance_groups_participants_apifinancegroups_id_e3d9c016_uniq` (`apifinancegroups_id`,`apiusers_id`),
  KEY `finance_groups_participants_apiusers_id_da3badcf_fk_users_id` (`apiusers_id`),
  CONSTRAINT `finance_groups_apifinancegroups_id_52e14a3a_fk_finance_groups_id` FOREIGN KEY (`apifinancegroups_id`) REFERENCES `finance_groups` (`id`),
  CONSTRAINT `finance_groups_participants_apiusers_id_da3badcf_fk_users_id` FOREIGN KEY (`apiusers_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `finance_groups_expense_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apifinancegroups_id` int(11) NOT NULL,
  `apiexpensetypes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `finance_groups_expense_types_apifinancegroups_id_1ee1b18c_uniq` (`apifinancegroups_id`,`apiexpensetypes_id`),
  KEY `finance_groups_e_apiexpensetypes_id_d25c669c_fk_expense_types_id` (`apiexpensetypes_id`),
  CONSTRAINT `finance_groups_apifinancegroups_id_2c770787_fk_finance_groups_id` FOREIGN KEY (`apifinancegroups_id`) REFERENCES `finance_groups` (`id`),
  CONSTRAINT `finance_groups_e_apiexpensetypes_id_d25c669c_fk_expense_types_id` FOREIGN KEY (`apiexpensetypes_id`) REFERENCES `expense_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `planned_incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `sum` double DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planned_incomes_pay_type_id_3a9e4371_fk_pay_types_id` (`pay_type_id`),
  KEY `planned_incomes_user_id_413ebf3d_fk_users_id` (`user_id`),
  CONSTRAINT `planned_incomes_pay_type_id_3a9e4371_fk_pay_types_id` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_types` (`id`),
  CONSTRAINT `planned_incomes_user_id_413ebf3d_fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `planned_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `sum` double DEFAULT NULL,
  `expense_type_id` int(11) DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `planned_expenses_expense_type_id_d94f0d06_fk_expense_types_id` (`expense_type_id`),
  KEY `planned_expenses_pay_type_id_3edef08a_fk_pay_types_id` (`pay_type_id`),
  KEY `planned_expenses_user_id_41225b9e_fk_users_id` (`user_id`),
  CONSTRAINT `planned_expenses_expense_type_id_d94f0d06_fk_expense_types_id` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`),
  CONSTRAINT `planned_expenses_pay_type_id_3edef08a_fk_pay_types_id` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_types` (`id`),
  CONSTRAINT `planned_expenses_user_id_41225b9e_fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `sum` double DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incomes_pay_type_id_da9592bb_fk_pay_types_id` (`pay_type_id`),
  KEY `incomes_user_id_2b7e6490_fk_users_id` (`user_id`),
  CONSTRAINT `incomes_pay_type_id_da9592bb_fk_pay_types_id` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_types` (`id`),
  CONSTRAINT `incomes_user_id_2b7e6490_fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `sum` double DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `background_id` int(11) DEFAULT NULL,
  `expense_type_id` int(11) DEFAULT NULL,
  `icon_id` int(11) DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_background_id_810731c8_fk_images_id` (`background_id`),
  KEY `expenses_expense_type_id_30c2fd05_fk_expense_types_id` (`expense_type_id`),
  KEY `expenses_icon_id_48a81b93_fk_icons_id` (`icon_id`),
  KEY `expenses_pay_type_id_5ed61f61_fk_pay_types_id` (`pay_type_id`),
  KEY `expenses_user_id_2cf87662_fk_users_id` (`user_id`),
  CONSTRAINT `expenses_background_id_810731c8_fk_images_id` FOREIGN KEY (`background_id`) REFERENCES `images` (`id`),
  CONSTRAINT `expenses_expense_type_id_30c2fd05_fk_expense_types_id` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`),
  CONSTRAINT `expenses_icon_id_48a81b93_fk_icons_id` FOREIGN KEY (`icon_id`) REFERENCES `icons` (`id`),
  CONSTRAINT `expenses_pay_type_id_5ed61f61_fk_pay_types_id` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_types` (`id`),
  CONSTRAINT `expenses_user_id_2cf87662_fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime(6) NOT NULL,
  `sum` double DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `destination_user_id` int(11) DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exchanges_destination_id_38b9b389_fk_pay_types_id` (`destination_id`),
  KEY `exchanges_destination_user_id_020acf78_fk_users_id` (`destination_user_id`),
  KEY `exchanges_pay_type_id_147b0760_fk_pay_types_id` (`pay_type_id`),
  KEY `exchanges_user_id_f20a1038_fk_users_id` (`user_id`),
  CONSTRAINT `exchanges_destination_id_38b9b389_fk_pay_types_id` FOREIGN KEY (`destination_id`) REFERENCES `pay_types` (`id`),
  CONSTRAINT `exchanges_destination_user_id_020acf78_fk_users_id` FOREIGN KEY (`destination_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `exchanges_pay_type_id_147b0760_fk_pay_types_id` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_types` (`id`),
  CONSTRAINT `exchanges_user_id_f20a1038_fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

