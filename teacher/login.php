<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
  $stuid = $_POST['stuid'];
  $password = md5($_POST['password']);
  $sql = "SELECT StuID,ID,TeacherClass FROM tblteacher WHERE (UserName=:stuid || StuID=:stuid) and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $_SESSION['sturecmsaid'] = $result->ID;
      $_SESSION['sturecmsstuid'] = $result->StuID;
      $_SESSION['sturecmsuid'] = $result->ID;
      $_SESSION['stuclass'] = $result->TeacherClass;
    }

    if (!empty($_POST["remember"])) {
      //COOKIES for username
      setcookie("user_login", $_POST["stuid"], time() + (10 * 365 * 24 * 60 * 60));
      //COOKIES for password
      setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    } else {
      if (isset($_COOKIE["user_login"])) {
        setcookie("user_login", "");
        if (isset($_COOKIE["userpassword"])) {
          setcookie("userpassword", "");
        }
      }
    }
    $_SESSION['login'] = $_POST['stuid'];
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
  } else {
    echo "<script>alert('Username atau Password Yang Anda Masukkan Salah.');</script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Halaman Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <h4 style="text-align: center;">IGAPIN STUDENT MANAGEMENT</h4>
              </div>
              <h4>Hello! Selamat Datang di ISM</h4>
              <h6 class="font-weight-light">Silahkan Login Untuk Masuk.</h6>
              <form class="pt-3" id="login" method="post" name="login">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" placeholder="Masukkan NIG atau Username" required="true" name="stuid" value="
                  <?php if (isset($_COOKIE["user_login"])) {
                  echo $_COOKIE["user_login"];
                } ?>">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" placeholder="Masukkan Password" name="password" required="true" value="
                  <?php if (isset($_COOKIE["userpassword"])) {
                  echo $_COOKIE["userpassword"];
                  } ?>">
                </div>
                <div class="mt-3">
                  <button class="btn btn-success btn-block loginbtn" name="login" type="submit">Login</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" id="remember" class="form-check-input" name="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> /> Tetap Login </label>
                  </div>
                  <a href="forgot-password.php" class="auth-link text-black">Lupa password?</a>
                </div>
                <div class="mb-2">
                  <a href="../loginchoose.php" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="icon-social-home mr-2"></i>Pilih Role</a>
                </div>
                <div class="mb-2">
                  <a href="../index.php" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="icon-social-home mr-2"></i>Kembali Ke Website </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
</body>

</html>