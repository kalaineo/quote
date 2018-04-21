
create table quotation(
quote_id int(9) primary key AUTO_INCREMENT,
model varchar(300),
ram_size varchar(30),
ram_size_unit varchar(5),
ram_type varchar(30),
hard_disc_size varchar(30),
hard_disc_unit varchar(5),
hard_disc_type varchar(30),
location varchar(300),
price double(14,4),
currency char(2) CHARACTER SET utf8 COLLATE utf8_general_ci
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
