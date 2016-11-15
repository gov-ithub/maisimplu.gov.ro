
# Add administrator
INSERT INTO `maisiwp_users` (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_status`)
VALUES ('admin_dev', MD5('pass123'), 'Firstname lastname', 'sample@mailinator.com', '0');

INSERT INTO `maisiwp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
VALUES (0, (Select max(id) FROM maisiwp_users), 'wp_capabilities', 'a:1:{s:13:"administrator";s:1:"1";}');

INSERT INTO `maisiwp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
VALUES (1, (Select max(id) FROM maisiwp_users), 'wp_user_level', '10');