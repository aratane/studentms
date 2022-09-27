<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  // Code Untuk Menghapus
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "delete from tblstudent where ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Data Dihapus.');</script>";
    echo "<script>window.location.href = 'manage-students.php'</script>";
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Pencarian Data Siswa</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="./css/style.css">
  </head>

  <body>
    <div class="container-scroller">
      <?php include_once('includes/header.php'); ?>
      <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Pencarian Siswa </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Pencarian Siswa</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form method="post">
                      <div class="form-group">
                        <strong>Cari Siswa :</strong>
                        <br><br>
                        <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Cari Menggunakan NIS">
                      </div>
                      <button type="submit" class="btn btn-primary" name="search" id="submit">Cari</button>
                      <br><br>
                    </form>
                    <div class="d-sm-flex align-items-center mb-4">
                      <?php
                      if (isset($_POST['search'])) {
                        $sdata = $_POST['searchdata'];
                      ?>
                        <h4 align="center">Hasil Pencarian Dengan NIS "<?php echo $sdata; ?>"</h4>
                    </div>
                    <div class="table-responsive border rounded p-1">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">NO</th>
                            <th class="font-weight-bold">NIS</th>
                            <th class="font-weight-bold">Kelas</th>
                            <th class="font-weight-bold">Nama Siswa</th>
                            <th class="font-weight-bold">Email Siswa</th>
                            <th class="font-weight-bold">Tanggal Masuk</th>
                            <th class="font-weight-bold">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['pageno'])) {
                            $pageno = $_GET['pageno'];
                          } else {
                            $pageno = 1;
                          }
                          // Code Untuk Navigasi Halaman
                          $no_of_records_per_page = 5;
                          $offset = ($pageno - 1) * $no_of_records_per_page;
                          $ret = "SELECT ID FROM tblstudent";
                          $query1 = $dbh->prepare($ret);
                          $query1->execute();
                          $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                          $total_rows = $query1->rowCount();
                          $total_pages = ceil($total_rows / $no_of_records_per_page);
                          $sql = "SELECT tblstudent.StuID,tblstudent.ID as sid,tblstudent.StudentName,tblstudent.StudentEmail,tblstudent.DateofAdmission,tblclass.ClassName,tblclass.Section from tblstudent join tblclass on tblclass.ID=tblstudent.StudentClass where tblstudent.StuID like '$sdata%' LIMIT $offset, $no_of_records_per_page";
                          $query = $dbh->prepare($sql);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);

                          $cnt = 1;
                          if ($query->rowCount() > 0) {
                            foreach ($results as $row) {               ?>
                              <tr>
                                <td><?php echo htmlentities($cnt); ?></td>
                                <td><?php echo htmlentities($row->StuID); ?></td>
                                <td><?php echo htmlentities($row->ClassName); ?> <?php echo htmlentities($row->Section); ?></td>
                                <td><?php echo htmlentities($row->StudentName); ?></td>
                                <td><?php echo htmlentities($row->StudentEmail); ?></td>
                                <td><?php echo htmlentities($row->DateofAdmission); ?></td>
                                <td>
                                  <div><a href="edit-student-detail.php?editid=<?php echo htmlentities($row->sid); ?>"><i class="icon-eye"></i></a>
                                    || <a href="manage-students.php?delid=<?php echo ($row->sid); ?>" onclick="return confirm('Apakah Kamu Yakin Ingin Menghapus ?');"> <i class="icon-trash"></i></a></div>
                                </td>
                              </tr><?php
                                    $cnt = $cnt + 1;
                                  }
                                } else { ?>
                            <tr>
                              <td colspan="8">Tidak ada catatan yang ditemukan terhadap pencarian ini.</td>
                            </tr>
                        <?php }
                              } ?>
                        </tbody>
                      </table>
                    </div>
                    <div align="left">
                      <ul class="pagination">
                        <li><a href="?pageno=1"><strong>Pertama></strong></a></li>
                        <li class="<?php if ($pageno <= 1) {
                                      echo 'disabled';
                                    } ?>">
                          <a href="<?php if ($pageno <= 1) {
                                      echo '#';
                                    } else {
                                      echo "?pageno=" . ($pageno - 1);
                                    } ?>"><strong style="padding-left: 10px">Sebelumnya></strong></a>
                        </li>
                        <li class="<?php if ($pageno >= $total_pages) {
                                      echo 'disabled';
                                    } ?>">
                          <a href="<?php if ($pageno >= $total_pages) {
                                      echo '#';
                                    } else {
                                      echo "?pageno=" . ($pageno + 1);
                                    } ?>"><strong style="padding-left: 10px">Selanjutnya></strong></a>
                        </li>
                        <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Terakhir></strong></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php include_once('includes/footer.php'); ?>
        </div>
      </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="./js/dashboard.js"></script>
  </body>

  </html><?php }  ?>