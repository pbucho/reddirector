ALTER TABLE `redirect`.`translation` ADD owner int;
ALTER TABLE `redirect`.`translation` ADD FOREIGN KEY (owner) REFERENCES `redirect`.`users` (id);
ALTER TABLE `redirect`.`translation` ADD private_url TINYINT(1) NOT NULL DEFAULT '0';

CREATE TABLE `redirect`.`roles` (
    user_id int NOT NULL,
    role_id int NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX user_role_idx USING HASH ON `redirect`.`roles`(user_id);

CREATE TABLE `redirect`.`action_log` (
    ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user int,
    anon_ip varchar(42),
    action varchar(255) NOT NULL,
    old_value varchar(255),
    new_value varchar(255),
    FOREIGN KEY (user) REFERENCES users (id)
);

delimiter $$
DROP TRIGGER IF EXISTS trg_col_xor$$

CREATE TRIGGER trg_col_xor BEFORE INSERT ON `redirect`.`action_log`
FOR EACH ROW
BEGIN
	IF (
		(NEW.user IS NULL AND NEW.anon_ip IS NULL) ||
		(NEW.anon_ip IS NOT NULL AND NEW.user IS NOT NULL)
	)
	THEN
		SIGNAL SQLSTATE '44000'
			SET MESSAGE_TEXT = 'user and anon_ip are mutually exclusive';
	END IF;
END$$
delimiter ;
