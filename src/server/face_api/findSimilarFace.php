<?php
  header('Access-Control-Allow-Origin: *');
  include_once("../db/dbconnection.php");

  // HTTP variable(s) received from the client
  $imageData = $_POST["imageData"];
  $faceFile = md5(uniqid(rand(), true)) . ".jpg"; // random face file

  // make sure to give directory permissions using chmod 777
  file_put_contents($faceFile, base64_decode($imageData)); // store image file

  // set values for use with the azure API
  $serverURL = "http://" . $_SERVER[HTTP_HOST];
  $imageURL = $serverURL . "/face_api/" . $faceFile;
  $requestBody = json_encode(array("url" => $imageURL));

  // send an HTTP Request to azure cloud to receive the face information
  $chFaceId = curl_init("https://eastus.api.cognitive.microsoft.com/face/v1.0/detect");
  curl_setopt($chFaceId, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($chFaceId, CURLOPT_POST, true); // POST method
  curl_setopt($chFaceId, CURLOPT_POSTFIELDS, $requestBody); // send raw JSON as body
  curl_setopt($chFaceId, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: fa67c5459bdc42b2ad14247fda796366'
  )); // Headers

  $response = curl_exec($chFaceId); // execute the HTTP Request
  curl_close($chFaceId); // close the HTTP Request
  unlink($faceFile); // delete the face file

  // grab the face id
  $response = json_decode($response, true);
  $faceId = $response[0]["faceId"];

  // grab the most similar face persisent id from the face list
  $requestBody = json_encode(array(
    "faceId" => $faceId,
    "faceListId" => "customer_face_list",
    "maxNumOfCandidatesReturned" => 1,
    "mode" => "matchFace"
  ));
  $chSimilarity = curl_init("https://eastus.api.cognitive.microsoft.com/face/v1.0/findsimilars");
  curl_setopt($chSimilarity, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($chSimilarity, CURLOPT_POST, true); // POST method
  curl_setopt($chSimilarity, CURLOPT_POSTFIELDS, $requestBody); // send raw JSON as body
  curl_setopt($chSimilarity, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: fa67c5459bdc42b2ad14247fda796366'
  )); // Headers

  $response = curl_exec($chSimilarity); // execute the HTTP Request
  curl_close($chSimilarity); // close the HTTP Request

  // grab the face id
  $response = json_decode($response, true);
  $persistedFaceId = $response[0]["persistedFaceId"];
  $confidence = $response[0]["confidence"];

  // grab customer and boarding pass info of the persistedFaceId
  $query = "SELECT * FROM customers WHERE faceId='$persistedFaceId' ORDER BY id DESC";
  if ($result = mysqli_query($link, $query)) {
      $row = mysqli_fetch_array($result);
      $email = $row["email"];
      $aadvantageId = $row["aadvantageId"];
      $firstName = $row["firstName"];
      $lastName = $row["lastName"];
      $gender = $row["gender"];
      $faceId = $row["faceId"];
      $boardingPassId = $row["boardingPassId"];

      // query for boarding pass information
      $query = "SELECT * FROM boarding_pass WHERE id='$boardingPassId' ORDER BY id DESC";
      if ($result = mysqli_query($link, $query)) {
          $row = mysqli_fetch_array($result);
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

          // HTTP Response as JSON
          $response = json_encode(array(
        "email" => $email,
        "aadvantageId" => $aadvantageId,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "gender" => $gender,
        "faceId" => $faceId,
        "confidence" => $confidence,
        "flightNumber" => $flightNumber,
        "aircraftType" => $aircraftType,
        "origin" => $origin,
        "destination" => $destination,
        "boardingTime" => $boardingTime,
        "departureTime" => $departureTime,
        "arrivalTime" => $arrivalTime,
        "gate" => $gate,
        "seat" => $seat,
        "cost" => $cost
      ));
          exit($response);
      }
  }
