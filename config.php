 <?php

 define('DB_SERVER', 'localhost');
 define('DB_USERNAME', 'root');
 define('DB_PASSWORD', '');
 define('DB_NAME', 'travel_guide');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysqli));

/*
  $sql = "CREATE TABLE IF NOT EXISTS users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(30) NOT NULL UNIQUE,
      email VARCHAR(100) NOT NULL UNIQUE,
      first_name VARCHAR(150),
      last_name VARCHAR(150),
      address VARCHAR(50),
      phone VARCHAR(20),
      sex VARCHAR(10) NOT NULL,
      password VARCHAR(16) NOT NULL,
      is_active BOOLEAN NOT NULL DEFAULT 1,
      is_admin BOOLEAN NOT NULL DEFAULT 0,
      is_superuser BOOLEAN NOT NULL DEFAULT 0,
      user_type VARCHAR(50) NOT NULL,
      date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      last_login TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

  */
if ($mysqli == false) {
    echo "Error creating table: " . $mysqli->error;
  }
?> 


