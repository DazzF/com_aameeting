ALTER TABLE `#__aameetinglist_aameeting` CHANGE `aameetingphone` `aameetingcontact` VARCHAR(50) NULL DEFAULT '';

ALTER TABLE `#__aameetinglist_aameeting` CHANGE `aaphone` `aameetingcontactphone` VARCHAR(50) NULL DEFAULT '';

ALTER TABLE `#__aameetinglist_aameeting` CHANGE `aameetingemail` `aameetingecontactmail` VARCHAR(50) NOT NULL DEFAULT '';
