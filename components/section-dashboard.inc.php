<section class="content-wrapper h-100">
  <div id="dashboard" class="row gx-5 h-100">
    <div class="col-sm-6 col-md-8">
      <h3 class="mb-4">Dashboard</h3>
      <div class="row gx-4">
        <div class="col-sm-12">
          <?php require('banner.inc.php'); ?>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-between align-items-center py-2 px-3 bg-light-orange">
            <img
              src="../img/candidate.png"
              alt=""
              class="img-fluid mr-3"
              style="height: 110px;"
            />
            <div>
            <button id="viewCandidates" data-bs-toggle="pill" data-bs-target="#pills-dashboard" type="button" role="tab" aria-controls="pills-dashboard" aria-selected="true" class="btn btn-outline-orange">view candidates</button>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="d-flex justify-content-between align-items-center py-2 px-3 bg-light-orange">
            <img
              src="../img/vote.png"
              alt=""
              class="img-fluid mr-3"
              style="height: 110px;"
            />
            <button id="voteNow" data-bs-toggle="pill" data-bs-target="#pills-dashboard" type="button" role="tab" aria-controls="pills-dashboard" aria-selected="true" class="btn btn-outline-orange">vote now</button>
          </div>
        </div>
        <div class="col-sm-12">
          <?php require('news.inc.php'); ?>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 d-flex flex-column h-100">
      <div>
        <h3>My Profile</h3>
        <small class="text-muted">Student ID 2020000001</small>
        <div class="text-center">
          <div class="avatar position-relative mx-auto my-4">
            <img src="https://placekitten.com/400/400" class="position-relative rounded-circle me-2 img-fluid">
          </div>
          <h5>Kayla Layug</h5>
          <p class="text-muted">kaylalayug@gmail.com</p>
        </div>
        <div class="my-5">
          <h5 class="mb-3">Student Information</h5>
          <ul class="list-unstyled">
            <li>
              <h6 class="mb-0">Last Name</h6>
              <p>Layug</p>
            </li>
            <li>
              <h6 class="mb-0">First Name</h6>
              <p>Kayla</p>
            </li>
            <li>
              <h6 class="mb-0">Middle Name</h6>
              <p>Bisda</p>
            </li>
            <li>
              <h6 class="mb-0">Department</h6>
              <p>College of Computing Studies</p>
            </li>
          </ul>
        </div>
      </div>
      <div class="position-relative btn-holder mt-auto">
        <div class="arrow"></div>
        <a class="btn btn-orange btn-lg w-100 mt-3" href="#" role="button">Vote now</a>
        <a class="btn btn-orange btn-lg w-100 disabled mt-3" tabindex="-1" aria-disabled="true" href="#" role="button">Voted</a>
      </div>
    </div>
  </div>
</section>
