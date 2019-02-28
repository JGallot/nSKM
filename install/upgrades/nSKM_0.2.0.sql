SET @@autocommit = OFF ;
BEGIN;

UPDATE `config` SET `val`='0.2.0' WHERE `key`='version';

COMMIT;
SET @@autocommit = ON ;
