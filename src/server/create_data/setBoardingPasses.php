<?php
include_once("../db/dbconnection.php");

// get the json file for airports and decode it
$jsonFile = "data/boardingPass.json";
$jsondata = file_get_contents($jsonFile);
$data = json_decode($jsondata, true);

// iterate through each data in the airports JSON file
foreach ($data as $row) {
  $flightNumber = $row["flightNumber"];
  $aircraftType = $row["aircraftType"];
  $origin = $row["origin"];
  $destination = $row["destination"];
  $boardingTime = $row["boardingTime"];
  $departureTime = $row["departureTime"];
  $arrivalTime = $row["arrivalTime"];
  $gate = $row["gate"];
  $seat = $row["seat"];
  $cost = $row["cost"];

  // set a query to insert the data
  $query = "INSERT INTO boarding_pass (flightNumber, aircraftType, origin, destination, boardingTime,
    departureTime, arrivalTime, gate, seat, cost) VALUES(
    '$flightNumber', '$aircraftType', '$origin', '$destination', '$boardingTime',
    '$departureTime', '$arrivalTime', '$gate', '$seat','$cost')";

  // query it
  mysqli_query($link, $query);
}
?>
