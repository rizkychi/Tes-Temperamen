CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
 `oauth_token` text COLLATE utf8_unicode_ci NOT NULL,
 `oauth_secret` text COLLATE utf8_unicode_ci NOT NULL,
 `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `created` datetime NOT NULL,
 `modified` datetime NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `personality` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `users_id` int(11) NOT NULL,
 `traits` varchar (255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `sanguine` int DEFAULT 0,
 `choleric` int DEFAULT 0,
 `melancholy` int DEFAULT 0,
 `phlegmatic` int DEFAULT 0,
 `primary_result` int DEFAULT 0,
 `secondary_result` int DEFAULT 0,
 `timer` int DEFAULT 0,
 `tweet` int DEFAULT 0,
 `protected` boolean DEFAULT NULL,
 `created` datetime NOT NULL,
 `modified` datetime NOT NULL,
 PRIMARY KEY (id),
 FOREIGN KEY (users_id) REFERENCES users(id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create TABLE `valid_users`
(
    `id` int(11) not null AUTO_INCREMENT,
    `users_id` int(11) not null,
    `username` varchar(255) COLLATE utf8_unicode_ci not null,
    `primary_result` int not null,
    `status` int not null default 0,
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users(id)
) ENGINE=INNODB DEFAULT charset=utf8 COLLATE=utf8_unicode_ci;

create TABLE `tweets`
(
    `id` int(11) not null AUTO_INCREMENT,
    `users_id` int(11) not null,
    `username` varchar(255) COLLATE utf8_unicode_ci not null,
    `tweet` TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users(id)
) ENGINE=INNODB DEFAULT charset=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create TABLE `filter_users`
(
    `users_id` int(11) not null,
    `result` int not null,
    `tweet_count` int not null,
    FOREIGN KEY (users_id) REFERENCES users(id)
) ENGINE=INNODB DEFAULT charset=utf8 COLLATE=utf8_unicode_ci;

create TABLE `prediction_results`
(
    `users_id` int(11) not null,
    `data` TEXT default null,
    `result` int default null,
    `predict_date` datetime default null,
    FOREIGN KEY (users_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create TABLE `prediction_type`
(
    `users_id` int(11) not null,
    `type` varchar(4) default null,
    FOREIGN KEY (users_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;