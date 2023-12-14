-- God please work

DROP TABLE IF EXISTS 'tblTelemetry';

GRANT SELECT, INSERT, UPDATE, DELETE, DROP, ON p2599966db.* TO user@localhost IDENTIFIED BY'password';

CREATE TABLE 'tblTelemetry' (
    'id' int(10) unsigned NOT NULL AUTO_INCREMENT,
    'switch_01' BOOLEAN,
    'switch_02' BOOLEAN,
    'switch_03' BOOLEAN,
    'switch_04' BOOLEAN,
    'fan' varchar(32),
    'heater' VARCHAR(64),
    'keypad' VARCHAR(64)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8mb4_unicode_ci;

-- Create User Table for account creation

DROP TABLE IF EXISTS 'tblUsers';
CREATE TABLE tblUsers(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT true,
    PRIMARY_KEY('id')  
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8mb4_unicode_ci;

-- Suppossedly now another table is created with data? tblTelemetry_Data?? Values (ID, MSISDN, TargetMSISDN?, MESSAGE, DATE?)

DROP TABLE IF EXISTS 'tblTelemetry_Data';
CREATE TABLE tblTelemetry_Data(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    msisdn VARCHAR(64) NOT NULL,
    target_msisdn VARCHAR(64) NOT NULL,
    date VARCHAR(64) NOT NULL,
    message VARCHAR(248) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;