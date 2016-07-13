CREATE TABLE `redirect`.`roles` (
    user_id int NOT NULL,
    role_id int NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX user_role_idx USING HASH ON `redirect`.`roles`(user_id);
