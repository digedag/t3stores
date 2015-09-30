CREATE TABLE tx_t3stores_store (
	uid int(11) DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description tinytext,
	address varchar(150) NOT NULL,
	zip varchar(10) NOT NULL,
	city varchar(150) NOT NULL,
	countrycode varchar(20) DEFAULT '' NOT NULL,
	phone varchar(120) NOT NULL,
 	contactperson varchar(150) NOT NULL,
	lng tinytext,
	lat tinytext,
	openingtime tinytext,
	pictures int(11) DEFAULT '0' NOT NULL,
	hasreport tinyint(4) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);
