/* creating a new database */
CREATE DATABASE IF NOT EXISTS m3webshopping;

USE m3webshopping;

/* creating a new user */
CREATE USER IF NOT EXISTS m3webshopping@localhost
    IDENTIFIED BY 'wshm3';

/* granting the necessary privileges */
GRANT ALL PRIVILEGES ON m3webshopping.*
    TO 'm3webshopping'@'localhost'
    IDENTIFIED BY 'wshm3';
    
GRANT SELECT ON mysql.*
    TO 'm3webshopping'@'localhost'
    IDENTIFIED BY 'wshm3';

