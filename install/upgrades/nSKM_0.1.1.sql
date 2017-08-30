SET @@autocommit = OFF ;
BEGIN;

ALTER TABLE `accounts` 
ADD COLUMN `expired` DATE NOT NULL AFTER `name`,
ADD COLUMN `creation` DATE NOT NULL AFTER `expired`;

ALTER TABLE `hosts`
ADD COLUMN `ssh_port` int(2) NOT NULL default 22 AFTER `ip`;


UPDATE `config` SET `val`='0.1.1' WHERE `key`='version';

COMMIT;
SET @@autocommit = ON ;
