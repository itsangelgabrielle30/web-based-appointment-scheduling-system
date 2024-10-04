<?php 
include 'Sub_Bar.php';

function random_string($length = 10) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $firstname = $_POST['FirstName'] ?? throw new Exception("FirstName not provided");
        $lastname = $_POST['LastName'] ?? throw new Exception("LastName not provided");
        $middlename = $_POST['MiddleName'] ?? '';
        $suffix = $_POST['Suffix'] ?? '';
        $age = $_POST['Age'] ?? throw new Exception("Age not provided");
        $gender = $_POST['Gender'] ?? throw new Exception("Gender not provided");
        $address = $_POST['Address'] ?? throw new Exception("Address not provided");
        $email = $_POST['Email'] ?? throw new Exception("Email not provided");
        $contact = $_POST['ContactNo'] ?? throw new Exception("ContactNo not provided");
        $accountID = random_string();
      
        $_SESSION["AccountID"] = $accountID;
        $_SESSION["firstname"] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['middlename'] = $middlename;
        $_SESSION['suffix'] = $suffix;
        $_SESSION['age'] = $age;
        $_SESSION['gender'] = $gender;
        $_SESSION['address'] = $address;
        $_SESSION['email'] = $email;
        $_SESSION['contact'] = $contact;

        

        header("Location: Account.php");
        exit();

    } catch (Exception $e) {
        echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f4f7f6;
        }
        .container {
            margin-top: 50px;
        }
        .header-name {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #004494;
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
        .text-label{

            color:darkgray;
            font-size: 0.7rem;
            letter-spacing: 1px;
        }
        .btn-colors
        {
            background-color: black;
            color:white;
        }
        .btn-colors:hover{
            background-color: silver;
            
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 form-container">
                <h2 class="header-name text-center">Registration Form</h2>
                <hr>
                <form action="Register.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="FirstName" class="text-label">First Name</label>
                            <input type="text" id="FirstName" name="FirstName" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="LastName" class="text-label">Last Name</label>
                            <input type="text" id="LastName" name="LastName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="MiddleName" class="text-label">Middle Name</label>
                            <input type="text" id="MiddleName" name="MiddleName" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Suffix" class="text-label">Suffix</label>
                            <input type="text" id="Suffix" name="Suffix" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="Age" class="text-label">Age</label>
                            <input type="number" id="Age" name="Age" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Gender" class="text-label">Gender</label>
                            <select id="Gender" name="Gender" class="form-control" required>
                                <option disabled selected>Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Address" class="text-label" > Address</label>
                        <input type="text" id="Address" name="Address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="text-label">Email</label>
                        <input type="email" id="Email" name="Email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ContactNo" class="text-label">Contact No</label>
                        <input type="text" id="ContactNo" name="ContactNo" class="form-control" required>
                    </div>
                    <input type="submit" value="Submit" class="btn  btn-block btn-colors">
                </form>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <footer class="footer">
    <a href="Aboutus.php" style="color: white;">About us</a>
    <span>|</span>
    <a href="Contactus.ph" style="color: white;">Contact us</a>
</footer>

</body>
</html>
