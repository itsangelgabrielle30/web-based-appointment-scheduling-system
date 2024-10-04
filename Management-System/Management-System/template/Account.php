<?php

include 'databaseconnection/insertdata.php';

session_start();

$errorMessages = [];

try {
    $accountID = $_SESSION["AccountID"] ?? throw new Exception("AccountID not set");
    $firstname = $_SESSION["firstname"] ?? throw new Exception("Firstname not set");
    $lastname = $_SESSION['lastname'] ?? throw new Exception("Lastname not set");
    $middleName = $_SESSION['middlename'] ?? throw new Exception("Middlename not set");
    $suffix = $_SESSION['suffix'] ?? throw new Exception("Suffix not set");
    $age = $_SESSION['age'] ?? throw new Exception("Age not set");
    $gender = $_SESSION['gender'] ?? throw new Exception("Gender not set");
    $address = $_SESSION['address'] ?? throw new Exception("Address not set");
    $email = $_SESSION['email'] ?? throw new Exception("Email not set");
    $contact = $_SESSION['contact'] ?? throw new Exception("Contact not set");

    if (empty($accountID) || empty($firstname) || empty($lastname) || empty($middleName) || empty($suffix) || empty($age) || empty($gender) || empty($address) || empty($email) || empty($contact)) {
        throw new Exception("One or more fields are empty");
    }
} catch (Exception $e) {
    $errorMessages[] = htmlspecialchars($e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["Password"] ?? '';
    $confirmPassword = $_POST["ConfirmPassword"] ?? '';

    if (empty($password) || empty($confirmPassword)) {
        $errorMessages[] = 'Password fields are empty';
    }

    if ($password !== $confirmPassword) {
        $errorMessages[] = 'Passwords do not match';
    }

    if (strlen($password) < 8) {
        $errorMessages[] = 'Password must be at least 8 characters long';
    }

    if (empty($errorMessages)) {
        try {
            $insertingdata = new GetAccountData($accountID, $email, $password);
            $insertingdatainfo = new AccountData(
                $accountID, 
                $firstname, 
                $lastname, 
                $middleName, 
                $suffix, 
                $age, 
                $gender, 
                $address, 
                $email, 
                $contact
            );

            try {
                insertData($insertingdatainfo);
                insertAccountData($insertingdata);

           
                $_SESSION["success_message"] = "Account created successfully. You may log in.";

                header("Location: Base.php");
                exit();
            } catch (Exception $e) {
                $errorMessages[] = 'An error occurred: ' . htmlspecialchars($e->getMessage());
            }
        } catch (Exception $e) {
            $errorMessages[] = 'An error occurred: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <title>Registration Form</title>
    <style>
        .modal-content {
            background-color: white; 
            color: black;
        }
        .center-form {
            min-height: 100vh;
            width: 200vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="header-name text-center">Setup Password</h2>
                <br>
                <hr>
                <?php if (!empty($errorMessages)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errorMessages as $message): ?>
                            <p><?php echo htmlspecialchars($message); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="Account.php" method="POST">
                    <div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="password" id="Password" name="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ConfirmPassword">Confirm Password:</label>
                        <input type="password" id="ConfirmPassword" name="ConfirmPassword" class="form-control" required>
                    </div>
                    <input type="submit" value="Register" class="btn btn-primary btn-block">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
