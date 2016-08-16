ALTER TABLE `redirect`.`translation` ADD owner int;
ALTER TABLE `redirect`.`translation` ADD FOREIGN KEY (owner) REFERENCES `redirect`.`users` (id);

CREATE TABLE `redirect`.`roles` (
    user_id int NOT NULL,
    role_id int NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX user_role_idx USING HASH ON `redirect`.`roles`(user_id);

CREATE TABLE `redirect`.`action_log` (
    ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user int NOT NULL,
    action varchar(255) NOT NULL,
    old_value varchar(255),
    new_value varchar(255),
    FOREIGN KEY (user) REFERENCES users (id)
);
