CREATE TABLE IF NOT EXISTS `#__aameetinglist_aameeting` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`aameetingcode` VARCHAR(50) NOT NULL DEFAULT '',
	`aameetingcontact` VARCHAR(50) NULL DEFAULT '',
	`aameetingcontactphone` VARCHAR(50) NULL DEFAULT '',
	`aameetingecontactemail` VARCHAR(50) NULL DEFAULT '',
	`aameetingname` VARCHAR(1024) NOT NULL DEFAULT '',
	`aameetingnight` INT(1) NOT NULL DEFAULT 1,
	`aameetingpasscode` VARCHAR(50) NOT NULL DEFAULT '',
	`aameetingtime` VARCHAR(7) NOT NULL DEFAULT '20:00',
	`params` text NOT NULL,
	`published` TINYINT(3) NOT NULL DEFAULT 1,
	`created_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`checked_out` int(11) unsigned NOT NULL DEFAULT 0,
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`version` INT(10) unsigned NOT NULL DEFAULT 1,
	`hits` INT(10) unsigned NOT NULL DEFAULT 0,
	`access` INT(10) unsigned NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	`metakey` TEXT NOT NULL,
	`metadesc` TEXT NOT NULL,
	`metadata` TEXT NOT NULL,
	PRIMARY KEY  (`id`),
	KEY `idx_aameetingname` (`aameetingname`),
	KEY `idx_aameetingnight` (`aameetingnight`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;



--
-- Always insure this column rules is large enough for all the access control values.
--
ALTER TABLE `#__assets` CHANGE `rules` `rules` MEDIUMTEXT NOT NULL COMMENT 'JSON encoded access control.';

--
-- Always insure this column name is large enough for long component and view names.
--
ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';
