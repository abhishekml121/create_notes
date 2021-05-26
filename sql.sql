CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255),
  `email` varchar(255),
  `hashed_password` varchar(255) NOT NULL,
  `user_avator` varchar(2000) NOT NULL,
  `avator_type` VARCHAR(10) DEFAULT 'monsterid',
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `quick_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_id` VARCHAR(25) NOT NULL UNIQUE,
  `is_private` tinyint(1) DEFAULT 0,
  `is_editable` tinyint(1) DEFAULT 0,
  `note_markdown` TEXT NOT NULL,
  `note_html` TEXT NOT NULL,
  `note_html_others` TEXT DEFAULT NULL,
  `note_markdown_others` TEXT DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `views` VARCHAR(255) DEFAULT 1,
  `ip_address` VARCHAR(255) NOT NULL,
  `date_others` VARCHAR(15) DEFAULT NULL,
  `time_others` VARCHAR(15) DEFAULT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `award_to_developer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` tinyint(1)  NOT NULL,
  `number_of_time` varchar(2)  NOT NULL DEFAULT 0,
  `ip_address` varchar(255)  NOT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `forget_password_otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255)  NOT NULL,
  `otp` varchar(6)  NOT NULL,
  `ip_address` varchar(255)  NOT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `subscribed_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) UNIQUE,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `message_from_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255),
  `message` TEXT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_id` VARCHAR(25) NOT NULL UNIQUE,
  `topic` text NOT NULL,
  `note_html` TEXT NOT NULL,
  `note_markdown` TEXT NOT NULL,
  `access_type` varchar(25) NOT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `self_views` VARCHAR(255) DEFAULT '0',
  `watch_later` tinyint(1) DEFAULT 0,
  `imp_note` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

/*
SELECT subject_name, COUNT(subject_name) FROM notes_subject where user_id=2 GROUP BY subject_name;
*/

CREATE TABLE `notes_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_id` VARCHAR(25) NOT NULL,
  `subject_name` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (note_id) REFERENCES notes(note_id) ON DELETE CASCADE
);

CREATE TABLE `notes_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_id` VARCHAR(25) NOT NULL,
  `tag_name` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (note_id) REFERENCES notes(note_id) 
  ON DELETE CASCADE
);

'SELECT * from notes AS N JOIN notes_subject AS S ON N.user_id = 2 AND N.user_id = S.user_id AND N.note_id = S.note_id JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id = T.note_id'

'select * from notes AS N JOIN notes_subject AS S ON N.user_id 2 AND N.user_id = S.user_id AND N.note_id = 2 AND N.note_id = S.note_id  JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id = T.note_id';

// FIND NOTES by user_id
`
SELECT N.id,N.user_id,N.note_id ,S.subject_name,T.tag_name,N.date, N.time from notes AS N JOIN notes_subject AS S ON N.user_id = 2 AND N.user_id = S.user_id AND N.note_id = S.note_id JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id =
T.note_id ORDER BY N.date DESC
`


// FIND NOTES by subject_name and user_id
`
SELECT N.id,N.user_id,N.note_id ,S.subject_name,T.tag_name,N.date, N.time from notes AS N JOIN notes_subject AS S ON N.user_id = 2 AND N.note_id = S.note_id JOIN notes_tag AS T ON  N.note_id = T.note_id  WHERE BINARY S.subject_name = 'DLD' ORDER BY N.date DESC 
`


// run when you want duplicate rows
'SELECT N.id, N.user_id, N.note_id, S.subject_name, T.tag_name, N.date, N.time 
from (SELECT *
      FROM notes
      ORDER BY date DESC
      LIMIT 3) AS N 
JOIN notes_subject AS S ON N.user_id = 2 
AND N.user_id = S.user_id 
AND N.note_id = S.note_id 
JOIN notes_tag AS T ON N.user_id = T.user_id 
AND N.note_id = T.note_id;
'

// run when you want only a row of duplicate rows
'
WITH cte AS (
    SELECT N.id, N.user_id, S.subject_name, T.tag_name, N.date, N.time,
           ROW_NUMBER() OVER (PARTITION BY N.id ORDER BY N.date DESC) rn
    FROM notes AS N
    INNER JOIN notes_subject AS S
        ON N.user_id = 2 AND N.user_id = S.user_id AND N.note_id = S.note_id
    INNER JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id = T.note_id
)

SELECT id, user_id, subject_name, tag_name, date, time
FROM cte
WHERE rn = 2
ORDER BY id;
'

/*<><><><><><><><><><><><><><><><><><>*/
/* below css is a copy of my facebook_duplicate project*/

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `dob` VARCHAR(255) NOT NULL,
  `gender` VARCHAR(10) NOT NULL,
  `online` tinyint(1) DEFAULT 0,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  PRIMARY KEY (`id`)
);

-----------
ALTER TABLE table_name ADD INDEX index_name (column);
-----------

CREATE TABLE `users_personal_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profession` varchar(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `college_name` VARCHAR(255) NOT NULL,
  `college_start_year` YEAR NOT NULL,
  `permanent_address` TEXT DEFAULT NULL,
  `country` VARCHAR(25) NOT NULL,
  `zipcode` VARCHAR(10) DEFAULT NULL,
  `alternate_mob_number` VARCHAR(10) DEFAULT NULL,
  `website` VARCHAR(255) DEFAULT NULL,
  `instagram` VARCHAR(255) DEFAULT NULL,
  `linkedin` VARCHAR(255) DEFAULT NULL,
  `youtube` VARCHAR(255) DEFAULT NULL,
  `about_you` TEXT DEFAULT NULL,
  `fk_id` int(11) NOT NULL UNIQUE,
  `date_of_creation` DATE NOT NULL,
  `time_of_creation` TIME NOT NULL,
  PRIMARY KEY (`id`)
);
ALTER TABLE users_personal_details ADD INDEX user_id (fk_id);




select N.id, N.user_id, N.note_id, S.subject_name, T.tag_name, N.date, N.time
from (select N.*
      from notes N
      where N.user_id = 2
      order by N.date desc, N.time DESC
      limit 3
     ) N join
     notes_subject S  
     on N.user_id = S.user_id and
        N.note_id = S.note_id join
     notes_tag T 
     on N.user_id = T.user_id and
        N.note_id = T.note_id 
order by N.date DESC, N.time DESC;

