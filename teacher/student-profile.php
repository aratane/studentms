<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
  header('location:logout.php');
} else {

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Profil Guru</title>
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
              <h3 class="page-title"> Profil Guru</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Lihat Profil Guru</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

                    <table border="1" class="table table-bordered mg-b-0">
                      <?php
                      $sid = $_SESSION['sturecmsstuid'];
                      $sql = "SELECT tblteacher.TeacherName,tblteacher.TeacherEmail,tblteacher.TeacherClass,tblteacher.Gender,tblteacher.DOB,tblteacher.StuID,tblteacher.FatherName,tblteacher.MotherName,tblteacher.ContactNumber,tblteacher.AltenateNumber,tblteacher.Address,tblteacher.UserName,tblteacher.Password,tblteacher.Image,tblteacher.DateofAdmission,tblclass.ClassName,tblclass.Section from tblteacher join tblclass on tblclass.ID=tblteacher.TeacherClass where tblteacher.StuID=:sid";
                      $query = $dbh->prepare($sql);
                      $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) {               ?>
                          <tr align="center" class="table-warning">
                            <td colspan="4" style="font-size:20px;color:blue">
                              Detail Guru</td>
                          </tr>

                          <tr class="table-info">
                            <th>Nama Guru</th>
                            <td><?php echo $row->TeacherName; ?></td>
                            <th>Email Guru</th>
                            <td><?php echo $row->TeacherEmail; ?></td>
                          </tr>
                          <tr class="table-warning">
                            <th>Jenis Kelamin</th>
                            <td><?php echo $row->Gender; ?></td>
                            <th>Nomor Telepon</th>
                            <td><?php echo $row->ContactNumber; ?></td>
                          </tr>
                          <tr class="table-danger">
                            <th>Tanggal Lahir</th>
                            <td><?php echo $row->DOB; ?></td>
                            <th>NIG</th>
                            <td><?php echo $row->StuID; ?></td>
                          </tr>
                          <tr class="table-progress">
                            <th>Alamat</th>
                            <td><?php echo $row->Address; ?></td>
                            <th>Username</th>
                            <td><?php echo $row->UserName; ?></td>
                          </tr>
                      <?php $cnt = $cnt + 1;
                        }
                      } ?>
                    </table>
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