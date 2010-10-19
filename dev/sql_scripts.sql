ALTER TABLE `players` ADD `order_int` INT NOT NULL AFTER `game_id` ;

ALTER TABLE `players` ADD `modifier` VARCHAR( 1 ) NULL DEFAULT NULL AFTER `order_int` ;

/***************************************/

ALTER TABLE `games` ADD `gets` INT NOT NULL DEFAULT '0',
ADD `guess_num` INT NOT NULL DEFAULT '1';

ALTER TABLE `games` ADD `player_id` INT NULL DEFAULT NULL ,
ADD `dealer_id` INT NULL DEFAULT NULL;

 ALTER TABLE `players` DROP `modifier` ;
 
 
 /*****************************************/
 //turns
 
 ALTER TABLE `games` ADD `turn_id` INT NOT NULL DEFAULT '0';
 
  CREATE TABLE `playdrink`.`turns` (
`id` INT NOT NULL AUTO_INCREMENT ,
`game_id` INT NOT NULL ,
`player_id` INT NOT NULL ,
`dealer_id` INT NOT NULL ,
`first_guess_num` INT NULL ,
`first_guess_result` VARCHAR( 255 ) NULL ,
`second_guess_num` INT NULL ,
`drinker_id` INT NULL ,
`drinks` INT NULL ,
`gets` INT NOT NULL ,
`card` VARCHAR( 255 ) NULL ,
PRIMARY KEY ( `id` ) ,
INDEX ( `player_id` , `dealer_id` )
) ENGINE = InnoDB ;
 