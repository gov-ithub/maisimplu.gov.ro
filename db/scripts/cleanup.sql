update maisiwp_comments
	set comment_author = CONCAT(LEFT(comment_author, 3), ' Test'),
		comment_author_email = CONCAT(LEFT(comment_author_email, 1), comment_ID, '@mailinator.com'),
        comment_author_url = '',
        comment_author_IP = '',
        user_id = 0;
    
update maisiwp_ratings
	set rating_ip = '',
		rating_host = '',
        rating_username = CONCAT(LEFT(rating_username, 3), ' Test'),
        rating_userid = 0;
        
truncate table maisiwp_iwp_backup_status;

delete from maisiwp_postmeta where meta_key in ('nume_prenume', 'adresa_de_email', 'e_mail__', 'telefon_', 'nume__prenume');

delete from maisiwp_options where length(option_value) > 100 and LEFT(option_name, 1) = '_';

