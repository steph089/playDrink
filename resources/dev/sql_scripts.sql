ALTER TABLE `players` ADD `order_int` INT NOT NULL AFTER `game_id` ;

ALTER TABLE `players` ADD `modifier` VARCHAR( 1 ) NULL DEFAULT NULL AFTER `order_int` ;