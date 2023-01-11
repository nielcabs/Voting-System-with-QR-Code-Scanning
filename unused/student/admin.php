<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
    rel="stylesheet"
  />
  <link rel="icon" type="image/x-icon" href="../img/dhvsu-logo.png" />
</head>

<body>

  <!-- header -->

  <main class="dashboard">
    <?php require('../components/admin-student-sidebar.inc.php'); ?>
    <div class="tab-content p-4 h-100 w-100" id="pills-tabContentStudent">
      <div class="tab-pane fade show active h-100" id="pills-dashboard" role="tabpanel" aria-labelledby="pills-dashboard-tab">
        <?php require('../components/admin-student-dashboard.inc.php'); ?>
      </div>
      <div class="tab-pane fade" id="pills-voter-accounts" role="tabpanel" aria-labelledby="pills-voter-accounts-tab">
        <?php require('../components/admin-student-voter-accounts.inc.php'); ?>
      </div>
      <div class="tab-pane fade" id="pills-candidates" role="tabpanel" aria-labelledby="pills-candidates-tab">
        <?php require('../components/admin-student-candidates.inc.php'); ?>
      </div>
    </div>
    <?php require('../components/admin-student-add-candidates-account.inc.php'); ?>
    <?php require('../components/admin-student-edit-voters-account.inc.php'); ?>
    <?php require('../components/delete-alert-message.inc.php'); ?>
  </main>

  <!-- footer -->

  <!-- build:js scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/functions.js"></script>
  <!-- endbuild -->

</body>

</html>


