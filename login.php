<?php include("inc_header.php")?>
<h3>Login Tamu Hotel</h3>
<?php 
// Kalau tamu sudah login, arahkan balik ke beranda
if(isset($_SESSION['user_email']) && $_SESSION['user_email'] != ''){
    header("location:index.php");
    exit();
}

$email      = "";
$password   = "";
$err        = "";

if(isset($_POST['login'])){
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    if($email == '' or $password == ''){
        $err .= "<li>Silakan masukkan email dan password</li>";
    }else{
        $sql1   = "select * from user where email = '$email'";
        $q1     = mysqli_query($koneksi,$sql1);
        $r1     = mysqli_fetch_array($q1);
        $n1     = mysqli_num_rows($q1);

        if($n1 < 1){
            $err .= "<li>Akun tidak ditemukan</li>";
        }elseif($r1['password'] != md5($password)){
            $err .= "<li>Password tidak sesuai</li>";
        }

        if(empty($err)){
            // Set session untuk tamu yang berhasil login
            $_SESSION['user_email'] = $email;
            $_SESSION['user_nama']  = $r1['nama'];
            
            // Arahkan ke halaman utama
            header("location:index.php");
            exit();
        }
    }
}
?>
<?php if($err){ echo "<div class='error'><ul class='pesan'>$err</ul></div>";}?>

<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td><input type="text" name="email" class="input" value="<?php echo $email?>"/></td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td><input type="password" name="password" class="input" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="login" value="Login" class="tbl-biru"/>
                <br><br>
                <small>Lupa password? <a href="lupa_password.php">Klik di sini</a></small>
            </td>
        </tr>
    </table>
</form>

<?php include("inc_footer.php")?>