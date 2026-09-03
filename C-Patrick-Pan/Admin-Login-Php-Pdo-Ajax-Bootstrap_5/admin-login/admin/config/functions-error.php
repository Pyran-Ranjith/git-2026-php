<php?>
  $host = "localhost";
  $dbname = "patrick_pan_admin_login";
  $username = "root";
  $password = "";

  try{
  $dsn = "mysql:host=$host;dbname=$dbname;chrset=utf8mb4";
  $con=new PDO($dsn, $username, $password);

  $con=setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $con=setAttribute(PDO::ATTR_DEFAULT, PDO::FETCH_ASSOC);
  $con=setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  echo "Connected successfully";

  } catch(PDOException $e){
  echo "Connection failed: " . $e->getMessage();
  }


  </php>