<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "login";

// Establishing connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT name, doctor, phone, date FROM applicants";

// Executing the query
$result = $conn->query($sql);

// Check if the query executed successfully
if ($result === false) {
    // If there's an error, print the error message
    echo "Error: " . $conn->error;
} else {
    // If the query was successful
    if ($result->num_rows > 0) {
        // Loop through the results and display them
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["doctor"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "</tr>";
        }
    } else {
        // If no results were found
        echo "<p>No appointments found.</p>";
    }
}

// Close the connection
$conn->close();

?>
