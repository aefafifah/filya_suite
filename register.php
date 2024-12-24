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
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      body {
         background-image: url('assets/login-register.jpg');
         background-size: cover;
         background-repeat: no-repeat;
         height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0;
      }

      .card {
         background-color: rgba(255, 255, 255, 0.9);
         border-radius: 8px;
         box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
         padding: 20px;
         width: 550px;
         height:800px;
         position: absolute;
         top: 90px; 
         left: 70%; 
         transform: translateX(-20%);
      }

      .card-header {
            display: flex;
            justify-content: space-around;
            background-color: transparent;
            padding: 0;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
        }
        .card-header div {
            flex: 1;
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
            color: #ffa500;
            background-color: #ffedcc;
            cursor: pointer;
        }
        .card-header .active {
            background-color: #ff8c00;
            color: white;
        }
      h2, h3 {
         color: #ff8c00;;
         font-family: 'Arial', sans-serif;
         font-weight: bold;
      }


      h3 {
         font-size: 24px;
      }

      .form-label {
         font-weight: bold;
         color: #333;
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
            background-color: #ff8c00;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }

      .btn-primary:hover {
         
            background-color: #e67e22;
     
        
      }

      .text-center a {
         color: #007bff;
         text-decoration: none;
      }

      .text-center a:hover {
         text-decoration: underline;
      }

      .alert {
         margin-top: 10px;
      }

      p {
         color: #333;
         font-size: 14px;
      }
   </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <div onclick="window.location.href='index.php'">LOGIN</div>
        <div class="active">REGISTER</div>
    </div>
    <div class="card-body">
        <h2 class="text-center mt-3">Pantau Laporanmu?</h2>
        <h3 class="text-center mt-2">FilyaSuite Siap Membantu</h3>
        <form action="" method="post">
            <?php if (isset($error)) {
                foreach ($error as $errors) {
                    echo '<div class="alert alert-danger">'.$errors.'</div>';
                }
            } ?>
            <div class="mb-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" required placeholder="Masukkan Nama Anda">
            </div>
            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required placeholder="Masukkan Email Anda">
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required placeholder="Masukkan Password Anda">
            </div>
            <div class="mb-2">
                <label for="cpassword" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="cpassword" id="cpassword" required placeholder="Konfirmasi Password Anda">
            </div>
            <div class="mb-2">
                <label for="nomor_telpon" class="form-label">Nomor Telpon</label>
                <input type="text" class="form-control" name="nomor_telpon" id="nomor_telpon" required placeholder="Masukkan Nomor Telpon Anda">
            </div>
            <div class="mb-2">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" required placeholder="Masukkan Alamat Anda">
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary" name="submit">Registrasi Sekarang</button>
            </div>
            <p class="text-center mt-3">Apakah Anda Sudah Mempunyai Akun? <a href="index.php">Login Sekarang</a></p>
        </form>
    </div>
</div>
   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
