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
$id = trim($_GET['client_id']);
$sql = "SELECT * FROM clients where id=$id";
$result  = $conn->query($sql);
$client = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tathastu | Projects List</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $APP_URL;?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $APP_URL;?>assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
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
            <h1>Clients</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">List Projects</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Projects</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
        <table class="table table-striped projects">
                <tbody>
                    <tr>
                      <th>ID</th>
                      <td> <?php echo $client['id'];?> </td>
                    </tr>
                    <tr>
                      <th>Name</th>
                      <td> <?php echo $client['name'];?> </td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td> <?php echo $client['email'];?> </td>
                    </tr>
                    <tr>
                      <th>Phone</th>
                      <td> <?php echo $client['phone'];?> </td>
                    </tr>
                    <tr>
                      <th>SKype ID</th>
                      <td><?php echo $client['skype_id'];?> </td>
                    </tr>
                    <tr>
                      <th>City</th>
                      <td><?php echo $client['city'];?> </td>
                    </tr>
                    <tr>
                      <th>Country</th>
                      <td><?php echo $client['country_id'];?> </td>
                    </tr>
                    <tr>
                      <th>Address</th>
                      <td> <?php echo $client['address'];?> </td>
                    </tr>
                    <tr>
                      <th>Gender</th>
                      <td> <?php echo $client['gender'];?> </td>
                    </tr>
                    <tr>
                      <th>Profile Picture</th>
                      <td> Not Available </td>
                    </tr>
                    <tr>
                      <th>Notes</th>
                      <td> <?php echo $client['notes'];?> </td>
                    </tr>
                </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once "../layouts/footer.php" ;?>
  <?php require_once "view.php";?>
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
<!-- AdminLTE App -->
<script src="<?php echo $APP_URL;?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $APP_URL;?>assets/dist/js/demo.js"></script>
</body>
</html>