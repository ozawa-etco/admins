CREATE TABLE admins(
    id int primary key auto_increment,
    name varchar(255) not null,
    password varchar(255) not null, 
    password_hash varchar(255) not null,
    created datetime,
    updated datetime);