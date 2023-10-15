<?php
include_once("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "success"; // Send a success response to JavaScript
  } else {
    echo "error"; // Send an error response to JavaScript
  }

  $conn->close();
}
?>