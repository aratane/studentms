<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $nottitle = $_POST['nottitle'];
    $classid = $_POST['classid'];
    $notmsg = $_POST['notmsg'];
    $notby = $_POST['notby'];
    $sql = "insert into tblnotice(NoticeTitle,ClassId,NoticeMsg,NoticeBy)values(:nottitle,:classid,:notmsg,:notby)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
    $query->bindParam(':classid', $classid, PDO::PARAM_STR);
    $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);
    $query->bindParam(':notby', $notby, PDO::PARAM_STR);
    $query->execute();
    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {
      echo '<script>alert("Pengumuman Ditambahkan.")</script>';
      echo "<script>window.location.href ='add-notice.php'</script>";
    } else {
      echo '<script>alert("Ada yang salah, Tolong coba lagi.")</script>';
    }
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Tambah Pengumuman</title>
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
              <h3 class="page-title">Tambah Pengumuman </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Tambah Pengumuman</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Pengumuman</h4>

                    <form class="forms-sample" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label for="exampleInputName1">Judul Pengumuman</label>
                        <input type="text" name="nottitle" value="" class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail3">Pengumuman Untuk</label>
                        <select name="classid" class="form-control" required='true'>
                          <option value="">Pilih Kelas</option>
                          <?php

                          $sql2 = "SELECT * from tblclass";
                          $query2 = $dbh->prepare($sql2);
                          $query2->execute();
                          $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                          foreach ($result2 as $row1) {
                          ?>
                            <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->ClassName); ?> <?php echo htmlentities($row1->Section); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <?php
                        $sid = $_SESSION['sturecmsstuid'];
                        $sql3 = "SELECT tblteacher.TeacherName from tblteacher where tblteacher.StuID=:sid";
                        $query3 = $dbh->prepare($sql3);
                        $query3->bindParam(':sid', $sid, PDO::PARAM_STR);
                        $query3->execute();
                        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results3 as $row3) {               ?>
                            <label for="exampleInputName1">Diumumkan Oleh :</label>
                            <select name="notby" class="form-control" required='true'>
                              <option value="<?php echo htmlentities($row3->TeacherName); ?>"><?php echo htmlentities($row3->TeacherName); ?></option>
                            </select>
                        <?php $cnt = $cnt + 1;
                          }
                        } ?>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Pesan Pengumuman</label>
                        <textarea name="notmsg" value="" class="form-control" required='true'></textarea>
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