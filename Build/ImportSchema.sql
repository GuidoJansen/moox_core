INSERT INTO be_users (pid, tstamp, username, password, admin, usergroup, disable, starttime, endtime, lang, email) VALUES (0,1276860841,'_cli_lowlevel','5f4dcc3b5aa765d61d8327deb882cf99',0,'1',0,0,0,'','_cli_phpunit@example.com');
ALTER TABLE `tt_content` ADD content_options text;
ALTER TABLE `tt_content` ADD content_variant varchar(255) default NULL;
ALTER TABLE `tt_content` ADD content_version varchar(255) default NULL;
