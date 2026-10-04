<?php

function getConn1()

{

    $setvetype = "local";

    //  $setvetype = "infinityfree";



    if ($setvetype == "local") {

        $setvername = "localhost";

        $username = "root";

        $password = "";

        $dbname = "ranjith_personal";

    } else {

        $setvername = "sql312.infinityfree.com";

        $username = "if0_34821597";

        $password = "q6CJCIvgPj9zjh5";

        $dbname = "if0_34821597_ranjith_personal";

    }

  $conn = mysqli_connect($setvername, $username, $password, $dbname);

  if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

  }

  // echo "Connected successfully";

  return $conn;

}





?> 