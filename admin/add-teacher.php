<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $stuname = $_POST['stuname'];
    $stuemail = $_POST['stuemail'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $stuid = $_POST['stuid'];
    $connum = $_POST['connum'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $password = md5($_POST['password']);
    $image = $_FILES["image"]["name"];
    $ret = "select UserName from tblteacher where UserName=:uname || StuID=:stuid";
    $query = $dbh->prepare($ret);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() == 0) {
      $extension = substr($image, strlen($image) - 4, strlen($image));
      $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
      if (!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Logo has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
      } else {
        $image = md5($image) . time() . $extension;
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
        $sql = "insert into tblteacher(TeacherName,TeacherEmail,Gender,DOB,StuID,ContactNumber,Address,UserName,Password,Image)values(:stuname,:stuemail,:gender,:dob,:stuid,:connum,:address,:uname,:password,:image)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
        $query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
        $query->bindParam(':connum', $connum, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':uname', $uname, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
          echo '<script>alert("Guru Telah Ditambahkan.")</script>';
          echo "<script>window.location.href ='add-teacher.php'</script>";
        } else {
          echo '<script>alert("Ada yang salah, Tolong coba lagi.")</script>';
        }
      }
    } else {

      echo "<script>alert('NIG Sudah Terpakai. Tolong Gunakan NIG yang lain.');</script>";
    }
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Tambah Guru</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />

  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include_once('includes/header.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Tambah Guru </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Tambah Guru</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Data Guru</h4>

                    <form class="forms-sample" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label for="exampleInputName1">Nama Guru</label>
                        <input type="text" name="stuname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email Guru</label>
                        <input type="text" name="stuemail" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Jenis Kelamin</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="Laki-Laki">Laki-Laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Tanggal Lahir</label>
                        <input type="date" name="dob" value="" class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">NIG</label>
                        <input type="text" name="stuid" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Foto Guru</label>
                        <input type="file" name="image" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Nomor Telepon</label>
                        <input type="text" name="connum" value="" class="form-control" required='true' maxlength="13" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Alamat</label>
                        <textarea name="address" class="form-control" required='true'></textarea>
                      </div>
                      <h3>Data Login</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">Username</label>
                        <input type="text" name="uname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Tambah</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php include_once('includes/footer.php'); ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>

  </html><?php }  ?>