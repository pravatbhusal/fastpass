<?php
include_once("db/dbconnection.php");

// get the json file for airports and decode it
$jsonFile = "data/airports.json";
$jsondata = file_get_contents($jsonFile);
$data = json_decode($jsondata, true);

// iterate through each data in the airports JSON file
foreach ($data as $row) {
  $code = $row["code"];
  $name = $row["name"];
  $stateCode = $row["stateCode"];
  $city = $row["city"];
  $countryCode = $row["countryCode"];
  $countryName = $row["countryName"];
  $latitude = $row["latitude"];
  $longitude = $row["longitude"];
  $admiralsClubUrl = $row["admiralsClubUrl"];

  // set a query to insert the data
  $query = "INSERT INTO airports (code, name, stateCode, city, countryCode,
    countryName, latitude, longitude, admiralsClubUrl) VALUES(
    '$code', '$name', '$stateCode', '$city', '$countryCode',
    '$countryName', '$latitude', '$longitude', '$admiralsClubUrl')";

  // query it
  mysqli_query($link, $query);
}
?>
