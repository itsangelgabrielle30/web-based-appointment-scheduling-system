<?php 
include 'Databaseconnection/getandsetter.php'; 
include 'Databaseconnection/Databasecon.php';
include 'Sub_Bar.php';

$accountID = $_SESSION['user_id'];

function generatePatientID() {
    $randomNumber = mt_rand(1000, 9999);
    $patientID = 'PTID-' . $randomNumber;
    return $patientID;
}

$randomPatientID = generatePatientID();

$success = false;
$error = false;
$status = "Doctor waiting for assign";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientid = generatePatientID(); // Use the generated patient ID
    $fullname = $_POST["fullname"];
    $dob = $_POST["dob"];
    $contactno = $_POST["contactno"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];

    $databasecon = new DatabaseConnection();
    $conn = $databasecon->connect();

    $sql = 'INSERT INTO patients (PatientNo, AccountNo, Fullname, DateOfBirth, ContactNo, Email, Address, Age, Gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('sssssssss', $patientid, $accountID, $fullname, $dob, $contactno, $email, $address, $age, $gender);
    
    if ($stmt->execute()) {
        $_SESSION["success_message"] = "Patient registered successfully!";
    } else {
        $_SESSION["error_message"] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
    header('Location: Base.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Patient</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }

        .registration-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            padding: 40px;
            margin-top: 50px;
            position: relative;
            overflow: hidden;
        }

        .registration-container h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-shadow: none;
            transition: all 0.3s ease;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 registration-container">
                <h1>Register Patient</h1>
                <hr>
                <form id="register-patient-form" method="post" action="register_patient.php">
                    <div class="form-group">
                        <label for="patientid">Patient ID</label>
                        <input type="text" id="patientid" name="patientid" class="form-control" value="<?php echo $randomPatientID; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="accountno">Account Number</label>
                        <input type="text" id="accountno" name="accountno" class="form-control" value="<?php echo $accountID; ?>" readonly>
                        <input type="hidden" name="accountno" value="<?php echo $accountID; ?>">
                    </div>
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter Fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" id="age" name="age" class="form-control" placeholder="Enter Age">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contactno">Contact Number</label>
                        <input type="text" id="contactno" name="contactno" class="form-control" placeholder="Enter Contact Number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address">
                    </div>
                
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>
    <br><br><br><br>

    
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Patient registered successfully!</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
    <a href="Aboutus.php" style="color: white;">About us</a>
    <span>|</span>
    <a href="Contactus.php" style="color: white;">Contact us</a>
</footer>


    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'true') {
                $('#successModal').modal('show');
              
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 2000);
            } else if (urlParams.get('error')) {
                alert('Error: ' + decodeURIComponent(urlParams.get('error')));
            }
        });
    </script>
</body>
</html>
