# Create Config Table

CREATE TABLE IF NOT EXISTS `config` (
`key` varchar(30) NOT NULL,
`val` varchar(50) NOT NULL
) ENGINE=InnoDB;

# Add version
INSERT INTO config values ('version','O.1.0');

