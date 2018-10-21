<?php
include_once("../db/dbconnection.php");

// get the json file for airports and decode it
$jsonFile = "data/customers.json";
$jsondata = file_get_contents($jsonFile);
$data = json_decode($jsondata, true);

// iterate through each data in the airports JSON file
foreach ($data as $row) {
  $email = $row["email"];
  $aadvantageId = $row["aadvantageId"];
  $firstName = $row["firstName"];
  $lastName = $row["lastName"];
  $gender = $row["gender"];

  // set a query to insert the data
  $query = "INSERT INTO customers (email, aadvantageId,
    firstName, lastName, gender) VALUES('$email', '$aadvantageId',
    '$firstName', '$lastName', '$gender')";

  // query it
  mysqli_query($link, $query);
}
?>
