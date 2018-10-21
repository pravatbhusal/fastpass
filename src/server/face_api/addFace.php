<?php
  include_once("../db/dbconnection.php");

  // HTTP variables from the client
  $faceImageId = $_POST["faceId"];
  $email = $_POST["email"];
  $aadvantageId = $_POST["aadvantageId"];
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $gender = $_POST["inlineRadioOptions"];

  // create media folder if it hasn't been created
  if (!file_exists("../media/")) {
      mkdir("../media/", 0777, true);
  }

  // create faces folder if it hasn't been created
  if (!file_exists("../media/faces")) {
      mkdir("../media/faces", 0777, true);
  }

  // upload image file
  $fileName = "";
  $uploadedFile = "";
  if (isset($_FILES['faceImageId'])) {
      $uploadDir = '../media/faces/'; // path to store uploaded files
      $fileName = basename($_FILES['faceImageId']['name']); // file name
      $uploadedFile = $uploadDir . $fileName;
      if(move_uploaded_file($_FILES['faceImageId']['tmp_name'], $uploadedFile)) {
        // do nothing
      } else {
          die("There was a problem saving the uploaded file.");
      }
  }

  // send an HTTP Request to azure cloud to add the face information
  $serverURL = "http://" . $_SERVER[HTTP_HOST];
  $imageURL = $serverURL . "/media/faces/" . $fileName;
  $requestBody = json_encode(array("url" => $imageURL));
  $chFaceId = curl_init("https://eastus.api.cognitive.microsoft.com/face/v1.0/facelists/customer_face_list/persistedFaces");
  curl_setopt($chFaceId, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($chFaceId, CURLOPT_POST, true); // POST method
  curl_setopt($chFaceId, CURLOPT_POSTFIELDS, $requestBody); // send raw JSON as body
  curl_setopt($chFaceId, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: fa67c5459bdc42b2ad14247fda796366'
  )); // Headers

  $response = curl_exec($chFaceId); // execute the HTTP Request
  curl_close($chFaceId); // close the HTTP Request
  $response = json_decode($response);
  $persistedFaceId = $response->persistedFaceId;

  // change file's name to the persisitedFaceId
  $newFileName = "../media/faces/" . $persistedFaceId . ".jpg";
  rename($uploadedFile, $newFileName);

  // insert customer info into the database
  $query = "INSERT INTO customers (email, aadvantageId,
    firstName, lastName, gender, faceId) VALUES('$email', '$aadvantageId',
    '$firstName', '$lastName', '$gender', '$persistedFaceId')";
  mysqli_query($link, $query);
?>
