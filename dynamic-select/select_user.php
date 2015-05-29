@SELECT '' AS `name` ,'' AS `id` FROM `[[+PREFIX]]users` UNION SELECT `username` AS `name`,`id` FROM `[[+PREFIX]]users` WHERE `active` = 1
