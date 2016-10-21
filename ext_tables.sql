CREATE TABLE tx_t3stores_store (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description tinytext,
	address varchar(150) DEFAULT '' NOT NULL,
	zip varchar(10) DEFAULT '' NOT NULL,
	city varchar(150) DEFAULT '' NOT NULL,
	countrycode varchar(20) DEFAULT '' NOT NULL,
	phone varchar(120) DEFAULT '' NOT NULL,
	email varchar(150) DEFAULT '' NOT NULL,
 	contactperson varchar(150) DEFAULT '' NOT NULL,
	lng tinytext,
	lat tinytext,
	openingtime tinytext,
	pictures int(11) DEFAULT '0' NOT NULL,
	hasreport tinyint(4) DEFAULT '0' NOT NULL,

	items int(11) DEFAULT '0' NOT NULL,
	categories int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_t3stores_store2promo_mm'
# uid_local used for store
#
CREATE TABLE tx_t3stores_stores_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	tablenames varchar(50) DEFAULT '' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_t3stores_promotion (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	discount tinyint(4) unsigned DEFAULT '0' NOT NULL,
	pickupdates mediumtext,
	startdate int(11) unsigned DEFAULT '0' NOT NULL,
	stores int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_t3stores_offergroup (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	internalname varchar(255) DEFAULT '' NOT NULL,
	promotion int(11) DEFAULT '0' NOT NULL,
	description tinytext,
	offers int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# 17|3|Kaninchenkeulen|ca. 260 g|19.95|kg 19,95|
#
CREATE TABLE tx_t3stores_offer (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	offertype tinyint(4) unsigned DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	offergroup int(11) DEFAULT '0' NOT NULL,
	teaser varchar(255) DEFAULT '' NOT NULL,
	hint varchar(255) DEFAULT '' NOT NULL,
	unit tinyint(4) unsigned DEFAULT '0' NOT NULL,
	price int(11) unsigned DEFAULT '0' NOT NULL,
	pricelabel varchar(255) DEFAULT '' NOT NULL,
	weight int(11) DEFAULT '0' NOT NULL,
	images int(11) DEFAULT '0' NOT NULL,

	product int(11) unsigned DEFAULT '0' NOT NULL,
	available int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_t3stores_order (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	promotion int(11) DEFAULT '0' NOT NULL,
	customername varchar(100) DEFAULT '' NOT NULL,
	customeraddress varchar(100) DEFAULT '' NOT NULL,
	customerzip varchar(10) DEFAULT '' NOT NULL,
	customercity varchar(100) DEFAULT '' NOT NULL,
	customerphone varchar(100) DEFAULT '' NOT NULL,
	customeremail varchar(255) DEFAULT '' NOT NULL,
	customernote text,
	mailtext text,
	store int(11) DEFAULT '0' NOT NULL,
	pickup date DEFAULT '0000-00-00',
	positionprice int(11) unsigned DEFAULT '0' NOT NULL,
	totalprice int(11) unsigned DEFAULT '0' NOT NULL,
	positions int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_t3stores_orderposition (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,

	orderuid int(11) unsigned DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	price int(11) unsigned DEFAULT '0' NOT NULL,
	total int(11) unsigned DEFAULT '0' NOT NULL,
	amount float(10,2) DEFAULT '0.00' NOT NULL,
	unit tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);


CREATE TABLE tx_t3stores_product (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	shortname varchar(255) DEFAULT '' NOT NULL,
	categories int(11) DEFAULT '0' NOT NULL,
	description text,
	images int(11) DEFAULT '0' NOT NULL,
	weight int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_t3stores_job (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	categories int(11) DEFAULT '0' NOT NULL,
	description text,
	images int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);
