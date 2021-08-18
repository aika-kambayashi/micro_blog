drop database if exists micro_blog;
create database micro_blog default character set utf8;

use micro_blog;

drop table if exists user;
create table user(
    user_id int not null primary key auto_increment,
    mail varchar(255) not null unique,
    password varchar(255) not null default '',
    nickname varchar(255) not null default '',
    modified_at datetime not null default current_timestamp,
    created_at datetime not null default current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists tweet;
create table tweet(
    tweet_id int not null primary key auto_increment,
    user_id int not null,
    body varchar(255) not null default '',
    created_at datetime not null default current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists follow;
create table follow(
    follow_id int not null primary key auto_increment,
    user_id int not null,
    following_user_id int not null,
    unique (user_id, following_user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists favorite;
create table favorite(
    user_id int not null,
    tweet_id int not null,
    modified_at datetime not null default current_timestamp,
    primary key(user_id,tweet_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;