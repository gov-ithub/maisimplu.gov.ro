update maisiwp_ratings
    set rating_rating =
        case rating_rating
            when 4 then 1
            when 5 then 1
            when 3 then 0
            when 2 then -1
            when 1 then -1
        end;
delete from maisiwp_postmeta where meta_key = 'ratings_score';
insert into maisiwp_postmeta (`post_id`, `meta_key`, `meta_value`)
SELECT rating_postid, 'ratings_score', sum(rating_rating) as _sum
FROM maisiwp_ratings GROUP BY rating_postid;
