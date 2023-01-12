<?php
session_start();
if(!isset($_SESSION["id"])) {
  header("Location:login.php");
}
$APP_URL = "http://localhost/Tathastu/";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tathastu";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM countries";
$countries_result = $conn->query($sql);

$id = trim($_GET['client_id']);
$sql = "SELECT * FROM clients where id=$id";
$result  = $conn->query($sql);
$client = $result->fetch_assoc();
$name = $client['name'];
$email = $client['email']; 
$phone = $client['phone'];
$country_id = $client['country_id'];
$gender = $client['gender'];
$skype_id = $client['skype_id'];
$address = $client['address'];
$city = $client['city'];
$notes = $client['notes'];
$profile_pic = $client['profile_pic'];
$success_msg = $error_msg = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tathastu | Edit Client</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $APP_URL;?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $APP_URL;?>assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">

<?php

$target_dir = "../uploads/";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $name = test_input($_POST["name"]);
    $phone = test_input($_POST["phone"]);
    $country_id = test_input($_POST["country"]);
    $gender = test_input($_POST["gender"]);
    $skype_id = test_input($_POST["skype_id"]);
    $address = test_input($_POST["address"]);
    $city = test_input($_POST["city"]);
    $notes = test_input($_POST["notes"]);

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $profile_pic_msg = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
      $profile_pic_msg = "Sorry, there was an error uploading your file.";
    }
  }

    $sql = "Update clients set name='$name' , phone='$phone', country_id='$country_id', gender='$gender', skype_id='$skype_id', address='$address', city='$city', notes='$notes', profile_pic='$target_file'  where id={$id}";

    if ($conn->query($sql) === TRUE) {
      $success_msg = "Client has beed updated successfully";
    } else {
      $error_msg = "Error: " . $sql . "<br>" . $conn->error;
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}?>
<div class="wrapper">
<?php 
    require_once "../layouts/topbar.php";
    require_once "../layouts/left-sidebar.php";
    
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Client</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Client</li>
            </ol>
          </div>
        </div>
        <?php if(isset($error_msg) && !empty($error_msg)) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?php echo $error_msg;?>
        </div>
        <?php } ?>
        <?php if(isset($success_msg) && !empty($success_msg)) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
           <?php echo $success_msg;?>
        </div>
        <?php } ?>

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <!-- /.card -->
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Edit Client Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?client_id='.$id;?>" class="form-horizontal">
              <input type="hidden" name="id" id="client_id" value="<?php echo $id;?>" >
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="<?php echo $name;?>" id="name" placeholder="Name" name="name" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" value="<?php echo $email;?>" placeholder="Email" name="email" readOnly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $phone;?>" id="phone" placeholder="Phone" name="phone" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $city;?>" id="city" placeholder="City" name="city" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="country" required>
                           <?php if ($countries_result->num_rows > 0) {
                            while($row = $countries_result->fetch_assoc()) { ?>
                            <option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>         
                          <?php } 
                        } ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="gender" required>
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                            <option value="OTHER">Other</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Skype ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $skype_id;?>" id="skype_id" placeholder="Skype ID" name="skype_id">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $address;?>" id="address" placeholder="Adress" name="address">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Profile Picture</label>
                    <div class="col-sm-10">
                        <img height="60" src="<?php echo $profile_pic;?>" alt="Not found">
                        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
                    </div>
                  </div>
                  <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Notes</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="notes" placeholder="Notes" name="notes"><?php echo $notes;?></textarea>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Update</button>
                  <button type="submit" class="btn btn-secondary">Cancel</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once "../layouts/footer.php" ;?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="<?php echo $APP_URL;?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $APP_URL;?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo $APP_URL;?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $APP_URL;?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $APP_URL;?>assets/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<?php
 $conn->close(); 
?>
</body>
</html>