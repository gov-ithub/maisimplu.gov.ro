# maisimplu.gov.ro
Maisimplu are o baza de date cu peste 3700 de propuneri. Ne dorim ca această platformă să interacționeze mai mult cu cetățenii, să putem identifica pattern-uri la subiecte de interes, ca cetățenii să fie informați de rezultatul propunerii lor. 


# Add administrator
INSERT INTO `maisiwp_users` (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_status`)
VALUES ('admin_dev', MD5('pass123'), 'Firstname lastname', 'sample@mailinator.com', '0');

INSERT INTO `maisiwp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
VALUES (0, (Select max(id) FROM maisiwp_users), 'wp_capabilities', 'a:1:{s:13:"administrator";s:1:"1";}');

INSERT INTO `maisiwp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
VALUES (1, (Select max(id) FROM maisiwp_users), 'wp_user_level', '10');

# Create wp-config.external.php file
Create a new file wp-config.external.php
Copy contents from wp-config-external-sample.php
Paste them in wp-config.external.php
Update the keys with your local values
