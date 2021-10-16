<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel='preconnect' href='https://fonts.googleapis.com' />
  <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap' rel='stylesheet' />
  <title>Login</title>
</head>
<?php
session_start();
if (isset($_POST['username'], $_POST['password'])) {
  if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin123') {
    $_SESSION['username'] = $_POST['username'];
    header('Location: welcome.php');
  }
}

if (isset($_GET['error'])) {
  $error = 'Login: admin - Password: admin123';
}

?>

<body>

  <div class="container">
    <form action="" method="post">
      Username <input type='text' name='username' />
      Password <input type='password' name='password' />
      <button type='submit'>Submit</button>
    </form>
    <div class='error'>
      <?php
      echo $error ?? ''
      ?>
    </div>
  </div>
</body>

</html>