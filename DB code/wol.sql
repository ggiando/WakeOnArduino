CREATE TABLE wol (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(30)NOT NULL,
  mac varchar(30) NOT NULL,
  state INT DEFAULT '0',
  last_request timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);