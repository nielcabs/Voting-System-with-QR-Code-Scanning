

<main class="dashboard">

    <?php require('../components/admin-faculty-sidebar.inc.php'); ?>
    <div class="tab-content p-4 h-100 w-100" id="pills-tabContentFaculty">

      <div class="tab-pane fade show active h-100" id="pills-dashboard" role="tabpanel" aria-labelledby="pills-dashboard-tab">
        <?php require('../components/admin-faculty-dashboard.inc.php'); ?>
      </div>

      <div class="tab-pane fade show active h-100" id="create-election" role="tabpanel" aria-labelledby="create-election-tab">
        <?php require('create-election/index.php'); ?>
      </div>

      <div class="tab-pane fade show active h-100" id="usc" role="tabpanel" aria-labelledby="usc-tab">
        <?php require('usc-candidates/test.php'); ?>
      </div>

   
    </div>

</main>