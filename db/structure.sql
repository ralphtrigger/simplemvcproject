/* 
 * Copyright 2016 trigger.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * Author:  trigger
 * Created: Dec 16, 2016
 */

DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS t_user;
DROP TABLE IF EXISTS article;

create table article (
    art_id integer not null primary key auto_increment,
    art_title varchar(100) not null,
    art_content varchar(1000) not null
)engine=innodb character set utf8 collate utf8_unicode_ci;

CREATE TABLE t_user (
    usr_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usr_name VARCHAR(50) NOT NULL,
    usr_password VARCHAR(88) NOT NULL,
    usr_salt VARCHAR(23) NOT NULL,
    usr_role VARCHAR(50) NOT NULL
)engine=innodb character set utf8 collate utf8_unicode_ci;

CREATE TABLE comment (
    com_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    com_content VARCHAR(500) NOT NULL,
    art_id INTEGER NOT NULL,
    usr_id INTEGER NOT NULL,
    CONSTRAINT fk_com_art FOREIGN KEY(art_id) REFERENCES article(art_id),
    CONSTRAINT fk_com_usr FOREIGN KEY(usr_id) REFERENCES t_user(usr_id)
)engine=innodb character set utf8 collate utf8_unicode_ci;
