CREATE TABLE tx_membershipext_domain_model_membership (
	street varchar(255) NOT NULL DEFAULT '',
	zip varchar(255) NOT NULL DEFAULT '',
	city varchar(255) NOT NULL DEFAULT '',
	phone varchar(255) NOT NULL DEFAULT '',
	email varchar(255) NOT NULL DEFAULT '',
	www varchar(255) NOT NULL DEFAULT '',
	tags int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_membershipext_domain_model_tag (
	nametag varchar(255) NOT NULL DEFAULT '',
	descriptiontag varchar(255) NOT NULL DEFAULT ''
);
