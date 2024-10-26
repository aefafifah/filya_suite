<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("connection error");
}


if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($data, $_POST['nama']);
    $email = mysqli_real_escape_string($data, $_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $cpass = password_hash($_POST['cpassword'], PASSWORD_DEFAULT); // Ini tidak perlu, lihat penjelasan di bawah
    $phone = mysqli_real_escape_string($data, $_POST['nomor_telpon']);
    $address = mysqli_real_escape_string($data, $_POST['alamat']);
    
    $user_type = 'user';
    $select = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($data, query: $select);

    if(mysqli_num_rows($result) > 0){
        $error[] = 'User already exists!';
    } else {
        // Cek kecocokan password
        if ($_POST['password'] != $_POST['cpassword']) {
            $error[] = 'Password not matched!';
        } else {
            // Hanya simpan hash password yang benar
            $insert = "INSERT INTO users(nama, email, password, usertype, nomor_telpon, alamat) VALUES('$name','$email','$pass','$user_type','$phone','$address')";
            mysqli_query($data, $insert);
            $_SESSION['nama'] = $name;
            $_SESSION['nomor_telpon'] = $phone;
            $_SESSION['user_id'] = mysqli_insert_id($data); // Mengambil ID pengguna terakhir yang dimasukkan
            $_SESSION['usertype'] = $user_type; // Atur tipe pengguna

            header('location:userhome.php');


        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
       <style>
         body {
    background-image: url('bglogin-register.jpg');
    background-size: cover;
    background-repeat: no-repeat; 
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    /* background-color: rgba(255, 255, 255, 0.9); */
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

h3.card-title {
    font-family: 'Arial', sans-serif;
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.form-label {
    font-weight: bold;
    color: white;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ced4da;
    transition: border-color 0.2s;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.alert {
    margin-top: 10px;
}

.text-center a {
    color:white;
    text-decoration: none;
}

.text-center a:hover {
    text-decoration: underline;
}
p {
    margin-top: 15px; 
    font-size: 14px;
    color : white;
}


       </style>
</head>

<body>
<div class="container mt-5">
   <div class="row justify-content-center">
      <div class="col-md-6">
         <!-- <div class="card shadow"> -->
            <!-- <div class="card-body"> -->
               <h2 class="card-title text-center">Pantau Laporanmu?</h2>
               <h3 class="card-title text-center mt-4">FilyaSuite Siap Membantu</h3>
               <br>
               <form action="" method="post">
                  <?php
                  if(isset($error)){
                     foreach($error as $errors){
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                     };
                  };
                  ?>
                  <div class="mb-3">
                     <label for="nama" class="form-label">Name</label>
                     <input type="text" class="form-control" name="nama" id="nama" required placeholder="Enter your name">
                  </div>

                  <div class="mb-3">
                     <label for="email" class="form-label">Email</label>
                     <input type="email" class="form-control" name="email" id="email" required placeholder="Enter your email">
                  </div>

                  <div class="mb-3">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" name="password" id="password" required placeholder="Enter your password">
                  </div>

                  <div class="mb-3">
                     <label for="cpassword" class="form-label">Confirm Password</label>
                     <input type="password" class="form-control" name="cpassword" id="cpassword" required placeholder="Confirm your password">
                  </div>

                  <div class="mb-3">
                     <label for="nomor_telpon" class="form-label">Phone Number</label>
                     <input type="text" class="form-control" name="nomor_telpon" id="nomor_telpon" required placeholder="Enter your phone number">
                  </div>

                  <div class="mb-3">
                     <label for="alamat" class="form-label">Address</label>
                     <input type="text" class="form-control" name="alamat" id="alamat" required placeholder="Enter your address">
                  </div>

                  <div class="d-grid">
                     <button type="submit" class="btn btn-primary form-btn" name="submit">Register Now</button>
                  </div>
               </form>

               <div class="text-center mt-3">
                  <p>Already have an account? <a href="login.php">Login now</a></p>
               </div>
            </div>
         <!-- </div> -->
      <!-- </div> -->
   </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
