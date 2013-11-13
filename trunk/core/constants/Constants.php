<?php
//ADMIN DAO Constants
define("DROP_TEMP_TABLE", "DROP TEMPORARY TABLE IF EXISTS temp_video_detail;\n", true);
define("CREATE_TEMP_TABLE", "CREATE TEMPORARY TABLE temp_video_detail (file_name varchar(100));\n", true);
define("INSERT_TEMP_TABLE", "insert into temp_video_detail values('%s');\n", true);
define("GET_NEW_FILES_QUERY", "select file_name from temp_video_detail tvd where tvd.file_name not in (select file_name FROM video_detail);\n", true);
define("SET_VIDEO_GENRE", "update video_detail set genre_id=%d where id=%d;", true);

define("INSERT_VIDEO", "INSERT INTO video_detail (description, length, name, genre_id, file_name, added_date) VALUES ('%s', '%s', '%s', %d, '%s', CURDATE());", true);
define("UPDATE_VIDEO", "UPDATE video_detail SET description = '%s', name = '%s' , genre_id = %d WHERE id=%d;", true);
define("DELETE_VIDEO", "DELETE FROM video_detail WHERE id = %d;", true);

define("INSERT_GENRE", "INSERT INTO genre (name) VALUES ('%s');", true);
define("DELETE_GENRE", "DELETE FROM genre WHERE id = %d;", true);
define("UPDATE_GENRE", "UPDATE genre SET name = '%s'  WHERE id=%d;", true);

define("FILE_NAME", "file_name", true);

//USER DAO Constantes
define("VIDEO_COUNT", "select count(*) as total_videos from video_detail;", true);
define("VIDEO_COUNT_BY_GENRE", "select count(*) as total_videos from video_detail where genre_id = %d;", true);

define("INSERT_UPDATE_VIDEO_VIEWS", "INSERT INTO video_views (id,views) VALUES (%d, %d) ON DUPLICATE KEY UPDATE views=%d;", true);

define("GET_GENRES", "select id, name from genre  ORDER BY name", true);
define("GET_VIDEO_VIEWS", "select id, views FROM video_views where id=%d;", true);

define("GET_MOST_VIEWED_VIDEOS", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id ORDER BY views DESC limit %d, %d", true);
define("GET_MOST_VIEWED_VIDEOS_BY_GENRE", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id where vd.genre_id=%d ORDER BY views DESC limit %d, %d", true);

define("GET_RECENT_VIDEOS", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id ORDER BY added_date DESC LIMIT %d, %d", true);
define("GET_RECENT_VIDEOS_BY_GENRE", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id where vd.genre_id=%d ORDER BY added_date DESC LIMIT %d, %d", true); 

define("GET_VIDEO_DETAILS", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id where vd.id=%d", true);

//Search
define("SEARCH_NAMES_SIZE", "SELECT count(*) as total_videos FROM video_detail vd where vd.name%s'%s'", true);
define("SEARCH_NAMES_SIZE_GENRE", "SELECT count(*) as total_videos FROM video_detail vd where vd.genre_id=%d and vd.name%s'%s'", true);
define("SEARCH_NAMES", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id where vd.name%s'%s' ORDER BY views DESC limit %d, %d", true);
define("SEARCH_NAMES_GENRE", "SELECT vd.id, vd.description, vd.length, vd.name, vd.genre_id, vd.file_name, vd.added_date, vv.views FROM video_detail vd LEFT JOIN video_views vv ON vd.id = vv.id where vd.genre_id=%d and vd.name%s'%s' ORDER BY views DESC limit %d, %d", true);

//COMMENTS
define("INSERT_COMMENT", "INSERT INTO comments(name, email, comment, video_id, date) VALUES ('%s', '%s', '%s', %d, now())", true);
define("SELECT_COMMENTS", "SELECT id, name, email, comment, video_id, date FROM comments WHERE video_id=%d order by date desc", true);
define("DELETE_COMMENT", "DELETE FROM comments WHERE id=%d", true);

//RATING
define("SELECT_RATING", "SELECT id, total_voted, average_rating FROM rating WHERE id=%d", true);
define("INSERT_RATING", "INSERT INTO rating(id, total_voted, average_rating) VALUES (%d, %d, %f) ON DUPLICATE KEY UPDATE total_voted=%d, average_rating=%f", true);
?>

