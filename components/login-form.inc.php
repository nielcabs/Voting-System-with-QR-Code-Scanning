<?php
  $url='../';
  include_once($url.'connection/mysql_connect.php');

?>

<section class="login-form gradient-overlay" style="background: url('<?php echo $url; ?>img/maingate-dhvtsu.jpg') no-repeat center; background-size: cover;">
    <div class="container">
        <div class="content-wrapper d-flex justify-content-center align-items-center vh-100">
            <div class="card" style="width: 20rem;">
                <div class="card-body p-4 text-black">
                    <form method="POST">
                        <div class="text-center mb-2">
                          <div class="mx-auto" style="margin-top: -5rem; width: 6rem;">
                            <img
                              src="<?php echo $url; ?>img/dhvsu-logo.png"
                              alt=""
                              class="img-fluid"
                            />
                          </div>
                          <h4 class="fw-bold mt-3 mb-1 text-uppercase">LOGIN</h4>
                          <p>Please login to your account</p>
                        </div>
                        <div class="form-outline">
                          <div style="display:none" class="alert alert-danger alert-dismissible fw-normal small py-1 text-center" id="error_msg"></div>
                          <label for="formGroupExampleInput" class="col-form-label form-label-md">ID Number</label>
                          <input type="text" id="username" class="form-control form-control-md" />
                        </div>
                        <div class="form-outline">
                          <label for="formGroupExampleInput2" class="col-form-label form-label-md">Password</label>
                          <input type="password" id="password" class="form-control form-control-md" />
                        </div>
                        <div class="mt-3 mb-3">
                          <button id="btn_login" class="btn btn-dark btn-md btn-block w-100" type="button">Login</button>
                        </div>
                        <a class="text-maroon" role="button" href="../forgot-password">Forgot password?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
