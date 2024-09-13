<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "login";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if(isset($_POST['book'])){
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $doctor = $_POST['doctor'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $message = $_POST['message'];
    
    // Prepare and execute SQL statement to insert data into database
    $stmt = $conn->prepare("INSERT INTO applicants (name, email, doctor, phone, date, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $doctor, $phone, $date, $message);
    
    if ($stmt->execute()) {
        echo "<script>alert('Appointment booked successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>