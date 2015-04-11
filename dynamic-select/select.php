@SELECT `pagetitle` AS `name`,`id` FROM `[[+PREFIX]]site_content` WHERE `published` = 1 AND `deleted` = 0 AND (`template` = 4 OR `template` = 3)
