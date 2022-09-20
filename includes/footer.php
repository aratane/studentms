<!--footer-->
<footer class="footer text-center">
  <div class="container">
    <div class="row">
      <?php
      $sql = "SELECT * from tblpage where PageType='contactus'";
      $query = $dbh->prepare($sql);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);

      $cnt = 1;
      if ($query->rowCount() > 0) {
        foreach ($results as $row) {               ?>
      <?php $cnt = $cnt + 1;
        }
      } ?>
      <!-- Footer Location-->
      <div class="col-lg-4 mb-1 mb-lg-0">
        <h4 class="text-uppercase mb-4">Lokasi</h4>
        <p class="lead mb-0">
        <p><?php echo htmlentities($row->PageDescription); ?>
        </p>
        </p>
      </div>
      <!-- Footer Social Icons-->
      <div class="col-lg-4 mb-1 mb-lg-0">
        <h4 class="text-uppercase mb-4">Kontak</h4>
        <p class="lead mb-0">
        <p><?php echo htmlentities($row->MobileNumber); ?>
        </p>
        </p>
      </div>
      <div class="col-lg-4 mb-1 mb-lg-0">
        <h4 class="text-uppercase mb-4">Email</h4>
        <p class="lead mb-0">
        <p><?php echo htmlentities($row->Email); ?>
        </p>
        </p>
      </div>
    </div>
  </div>
</footer>
<!-- Copyright Section-->
<div class="copyright py-4 text-center text-white">
  <div class="container"><small>Copyright &copy; ISM <script>
        document.write(new Date().getFullYear())
      </script></small></div>
</div>