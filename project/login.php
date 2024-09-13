<?php
session_start(); // Start the session

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "login";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Register user
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO `users` (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    if ($stmt->execute()) {
        echo "<script>window.alert('Registration successful');</script>";
    } else {
        echo "<script>window.alert('Error: " . $conn->error . "');</script>";

    }
}

// Login user
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username`=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "<script>window.alert('Login sucessful');</script>";
      header("location: index.html");
      exit;
        } else {
            echo "<script>window.alert('Invalid password');</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link href="styles.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    /* Additional CSS for responsiveness */
    .wrapper {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
    }
    .input-box {
      position: relative;
      margin-bottom: 20px;
    }
    .input-box input {
      width: 100%;
      height: 50px;
      padding: 10px 20px;
      border-radius: 25px;
      border: 2px solid rgba(0, 0, 0, 0.1);
    }
    .btn {
      width: 100%;
      height: 50px;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Login Form -->
    <form id="loginForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off">
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required autocomplete="off">
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required autocomplete="off">
        <i class='bx bxs-lock-alt'></i>
      </div>
      <button type="submit" name="login" class="btn">Login</button>
      <div class="register-link">
        Don't have an account? <a href="#" id="showRegister">Register</a>
      </div>
    </form>

    <!-- Register Form -->
    <form id="registerForm" method="post" autocomplete="off" action="" style="display: none;">
      <h1>Register</h1>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required autocomplete="off">
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required autocomplete="off">
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="off">
        <i class='bx bxs-lock-alt'></i>
      </div>
      <button type="submit" name="register" class="btn">Register</button>
      <div class="register-link">
        <p>Already have an account? <a href="#" id="showLogin">Login</a></p>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('showRegister').addEventListener('click', function() {
      document.getElementById('loginForm').style.display = 'none';
      document.getElementById('registerForm').style.display = 'block';
    });

    document.getElementById('showLogin').addEventListener('click', function() {
      document.getElementById('registerForm').style.display = 'none';
      document.getElementById('loginForm').style.display = 'block';
    });
  </script>
</body>
</html>