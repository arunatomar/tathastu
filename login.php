<?php 
  session_start();
  if(isset($_SESSION["id"])) {
    header("Location:dashboard.php");
  }
  $email = $password = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
   
    $servername = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "tathastu";

    $conn = new mysqli($servername, $username, $pass, $dbname);
    if ($conn->connect_error){
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select * from user where email='$email' and password = '$password'";

    $result = $conn->query($sql);
    $row  = mysqli_fetch_array($result);
    if ($result->num_rows > 0) {
      $_SESSION["id"] = $row['id'];
      $_SESSION["name"] = $row['name'];
      $_SESSION["email"] = $row['email'];
    } else {
      $err = "Invalid email or password";
    }
    $conn->close();
  }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tathastu | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<?php if(!empty($err)){ ?> 
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Invalid email or password!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
  </div>
<?php } ?>

  
<div class="login-box">
  <div class="login-logo">
    <a href="dashboard.php"><b>Tathastu</b> Labs</a>
  </div>
<!-- /.login-logo -->
<div class="card">
 <div class="card-body login-card-body">
   <p class="login-box-msg">Sign in to start your session</p>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
     <div class="input-group mb-3">
      <input type="email" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Email" required>
      <div class="input-group-append">
        <div class="input-group-text">
        <span class="fas fa-envelope"></span>
</div>
</div>
</div>
<div class="input-group mb-3">
   <input type="password" class="form-control" name="password" placeholder="Password" required >
   <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-lock"></span>
</div>
 </div>
</div>
<div class="row">
  <div class="col-8">
   <div class="icheck-primary">
    <input type="checkbox" id="remember">
    <label for="remember">
     Remember Me
  </label>
  </div>
  </div>
    <!-- /.col -->
    <div class="col-4">
      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </div>
    <!-- /.col -->
  </div>
</form>

      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
