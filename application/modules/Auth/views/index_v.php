<?php
// var_dump(encrypt("Ari"));
// var_dump(decrypt(encrypt("Ari")));
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pandurasa Kharisma | Log in</title>
  <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/animate.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <span class="logo-lg"><img src="<?= base_url() ?>assets/dist/img/pandurasa_kharisma_pt.png" style="border-radius:20%; max-width:50px;" alt=""></span>

      <a style="font-size: 28px;" href="<?= base_url() ?>"><b>Pandurasa</b> Kharisma </a>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div class="form-group has-feedback">
        <?php
        $page = "";
        if (isset($_GET['page'])) {
          $page = $_GET['page'];
        }
        ?>
        <input id="page" type="hidden" value="<?= $page ?>">
        <input id="username" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
          <button onclick="prosesLogin()" type="button" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>
    $("#username").keypress(function(event) {
      if (event.which === 13) { // Tombol Enter memiliki kode 13
        event.preventDefault(); // Mencegah tindakan bawaan tombol Enter
        $("#password").focus(); // Pindah fokus ke input password
      }
    });

    $("#password").keypress(function(event) {
      if (event.which === 13) { // Tombol Enter memiliki kode 13
        event.preventDefault(); // Mencegah tindakan bawaan tombol Enter
        prosesLogin()
      }
    });

    function prosesLogin() {
      let username = $('#username').val()
      let password = $('#password').val()
      let page = $('#page').val()

      if (username.trim() != "" && password.trim() != "") {
        $.ajax({
          url: "<?= site_url('auth/auth/process') ?>",
          method: "POST",
          data: {
            username,
            password,
            page
          },
          dataType: "JSON",
          success: function(response) {
            if (response.success == true) {
              Swal.fire({
                icon: 'success',
                title: 'Login Success',
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                window.location.href = "<?= base_url() ?>" + response.page
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                showConfirmButton: false,
                timer: 1500
              })
            }
          }
        })
      }
    }
  </script>
</body>
</html>