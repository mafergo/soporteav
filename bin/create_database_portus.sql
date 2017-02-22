USE `portus`;
CREATE USER 'portus'@'localhost' IDENTIFIED BY 'secretitosenreunionsonfaltadeeducacion';
GRANT ALL ON `portus`.* TO 'portus'@'localhost';
REVOKE GRANT OPTION ON `portus`.* FROM 'portus'@'localhost';
FLUSH PRIVILEGES;
