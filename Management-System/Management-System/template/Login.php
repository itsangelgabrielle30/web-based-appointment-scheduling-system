<?php

include 'Sub_bar.php';
include 'databaseconnection/insertdata.php';


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Check CSRF token
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid CSRF token');
        }

        $Email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $Password = $_POST['password'];

        // Validate email
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        // Authenticate user
        logindataAuth($Email, $Password);

    } catch (Exception $e) {
        $error = htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Login and Registration Form</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');



.container {
    position: relative;
    max-width: 850px;
    width: 100%;
    background: #fff;
    padding: 40px 30px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    perspective: 2700px;
}

.container .cover {
    position: absolute;
    top: 0;
    left: 50%;
    height: 100%;
    width: 50%;
    z-index: 98;
    transition: all 1s ease;
    transform-origin: left;
    transform-style: preserve-3d;
    backface-visibility: hidden;
}

.container #flip:checked ~ .cover {
    transform: rotateY(-180deg);
}

.container #flip:checked ~ .forms .login-form {
    pointer-events: none;
}

.container .cover .front,
.container .cover .back {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}

.cover .back {
    transform: rotateY(180deg);
}

.container .cover img {
    position: absolute;
    height: 100%;
    width: 100%;
    object-fit: cover;
    z-index: 10;
}

.container .cover .text {
    position: absolute;
    z-index: 10;
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.container .cover .text::before {
    content: '';
    position: absolute;
    height: 100%;
    width: 100%;
    opacity: 0.5;
    background: black;
}

.cover .text .text-1,
.cover .text .text-2 {
    z-index: 20;
    font-size: 26px;
    font-weight: 600;
    color: #fff;
    text-align: center;
}

.cover .text .text-2 {
    font-size: 15px;
    font-weight: 500;
}

.container .forms {
    height: 100%;
    width: 100%;
    background: #fff;
}

.container .form-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.form-content .login-form,
.form-content .signup-form {
    width: calc(100% / 2 - 25px);
}

.forms .form-content .title {
    position: relative;
    font-size: 24px;
    font-weight: 500;
    color: #333;
}

.forms .form-content .title:before {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    height: 3px;
    width: 25px;
    background: black;
}

.forms .signup-form .title:before {
    width: 20px;
}

.forms .form-content .input-boxes {
    margin-top: 30px;
}

.forms .form-content .input-box {
    display: flex;
    align-items: center;
    height: 50px;
    width: 100%;
    margin: 10px 0;
    position: relative;
}

.form-content .input-box input {
    height: 100%;
    width: 100%;
    outline: none;
    border: none;
    padding: 0 30px;
    font-size: 16px;
    font-weight: 500;
    border-bottom: 2px solid rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}


.form-content .input-box i {
    position: absolute;
    color: black;
    font-size: 17px;
    padding: 10px;

}

.forms .form-content .text {
    font-size: 14px;
    color: #333;
}

.forms .form-content .text a {
    text-decoration: none;
}

.forms .form-content .text a:hover {
    text-decoration: underline;
}

.forms .form-content .button {
    color: #fff;
    margin-top: 40px;
}

.forms .form-content .button input {
    color: #fff;
    background: black;
    border-radius: 6px;
    padding: 0;
    cursor: pointer;
    transition: all 0.4s ease;
    padding:10px;
}

.forms .form-content .button input:hover {
    background: #5b13b9;
}

.forms .form-content label {
    color: black;
    cursor: pointer;
}

.forms .form-content label:hover {
    text-decoration: underline;
}

.forms .form-content .login-text,
.forms .form-content .sign-up-text {
    text-align: center;
    margin-top: 25px;
}

.container #flip {
    display: none;
}

.footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }



    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <br><br><br><br>
    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="https://www.valant.io/wp-content/uploads/2023/04/blog_hero_patient_self-scheduling_2042700596_4.21.23_1500x1001.png" alt="Front Cover">
                <div class="text">
                    <span class="text-1">Streamline Your Healthcare Tasks</span>
                    <span class="text-2">Sign in to access hospital scheduling</span>
                </div>

            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <?php if (isset($_SESSION['login_error'])) { ?>
                    <div class="alert alert-danger mt-3">
                        <?php
                        echo htmlspecialchars($_SESSION['login_error']);
                        unset($_SESSION['login_error']); 
                        ?>
                    </div>
                <?php } ?>

                    <form method="POST" action="Login.php">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
    
                            <div class="button input-box">
                                <input type="submit" value="Submit">
                            </div>
                            <div class="text sign-up-text">Don't have an account? <a href="Register.php">Sign up now</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>


    <footer class="footer">
    <a href="Aboutus.php" style="color: white;">About us</a>
    <span>|</span>
    <a href="Contactus.php" style="color: white;">Contact us</a>
</footer>

</body>
</html>
