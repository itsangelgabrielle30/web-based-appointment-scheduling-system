<?php
include 'Databaseconnection/getandsetter.php';
include 'Databaseconnection/Databasecon.php';
include 'Sub_Bar.php';

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$successMessage = '';
$errorMessage = '';
$status = "Awaiting Doctor Assignment";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientID = $_POST['patientid'];
    $serviceType = $_POST['service'];
    $dateTime = $_POST['datetime'];

    $databasecon = new DatabaseConnection();
    $conn = $databasecon->connect();

    if (!$conn) {
        die('Database connection failed: ' . $conn->connect_error);
    }
    $appointmentCheckQuery = 'SELECT * FROM scheduling WHERE PatientNo = ? and DateTimeSchedule = ?';
    $appointmentCheckStmt = $conn->prepare($appointmentCheckQuery);
    if ($appointmentCheckStmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    $appointmentCheckStmt->bind_param('is', $patientID , $dateTime);
    $appointmentCheckStmt->execute();
    $appointmentCheckResult = $appointmentCheckStmt->get_result();

    if ($appointmentCheckResult->num_rows > 0) {
        $errorMessage = "The patient already has an appointment scheduled at this time.";
    } else {
       
        $patientQuery = 'SELECT Fullname, ContactNo, Email, Address FROM patients WHERE PatientNo = ?';
        $patientStmt = $conn->prepare($patientQuery);
        if ($patientStmt === false) {
            die('Error preparing the statement: ' . $conn->error);
        }
        $patientStmt->bind_param('i', $patientID);
        $patientStmt->execute();
        $patientResult = $patientStmt->get_result()->fetch_assoc();

        if ($patientResult) {
            $fullname = $patientResult['Fullname'];
            $contactNo = $patientResult['ContactNo'];
            $email = $patientResult['Email'];
            $address = $patientResult['Address'];
            $schedulNo = generateRandomString(); 
            $accountno = isset($_SESSION['Account_ID']) ? $_SESSION['Account_ID'] : '';
            $medicalIssue = $_POST['medicalissue'];
            $sql = 'INSERT INTO scheduling (Fullname, ContactNo, Email, Address, DateTimeSchedule, PatientNo, ScheduleNo, ServiceType, MedicalIssue, Status, AccountNo) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error preparing the statement: ' . $conn->error);
            }

            $stmt->bind_param('sssssssssss', $fullname, $contactNo, $email, $address, $dateTime, $patientID, $schedulNo, $serviceType, $medicalIssue, $status, $accountno);
        
            if ($stmt->execute()) {
                $successMessage = "Appointment scheduled successfully for " . htmlspecialchars($fullname);
            } else {
                $errorMessage = "Error scheduling appointment: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errorMessage = "Patient not found.";
        }

        $patientStmt->close();
    }

    $appointmentCheckStmt->close();
    $conn->close();
}

$accountno = isset($_SESSION['Account_ID']) ? $_SESSION['Account_ID'] : '';

$databasecon = new DatabaseConnection();
$conn = $databasecon->connect();

if (!$conn) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = 'SELECT * FROM patients WHERE AccountNo = ?';
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing the statement: ' . $conn->error);
}
$stmt->bind_param('i', $accountno);
$stmt->execute();
$result = $stmt->get_result();
$patients = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
      
        .table-bordered {
            border: 1px solid #ddd !important;
        }
        table caption {
            padding: .5em 0;
        }
        @media screen and (max-width: 767px) {
            table caption {
                display: none;
            }
        }
        .Button-td {
            width: 100px;
        }
        .alert {
            display: none;
        }
        .alert-show {
            display: block;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container">
    <br><br>
    <h2>Patient Records</h2>
        <?php if ($successMessage || $errorMessage): ?>
            <div class="alert <?php echo $successMessage ? 'alert-success alert-show' : 'alert-danger alert-show'; ?>">
                <?php echo htmlspecialchars($successMessage ?: $errorMessage); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table summary="This table shows patient information and scheduling options" class="table table-bordered table-hover">
                        <caption class="text-center">List of Patients and Scheduling Options for Medical Services</caption>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th data-priority="1">PatientNo</th>
                                <th data-priority="2">Patient</th>
                                <th data-priority="4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($patients): ?>
                                <?php foreach ($patients as $index => $patient): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($patient['PatientNo']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['Fullname']); ?></td>
                                        <td class="Button-td">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#appointmentModal-<?php echo $patient['PatientNo']; ?>">
                                                Schedule Appointment
                                            </button>
                                        </td>
                                    </tr>
<div class="modal fade" id="appointmentModal-<?php echo $patient['PatientNo']; ?>" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Schedule Appointment for <?php echo htmlspecialchars($patient['Fullname']); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="Bookappointment.php">
                <div class="modal-body">
                    <input type="hidden" name="patientid" value="<?php echo htmlspecialchars($patient['PatientNo']); ?>">
                    <div class="form-group">
                        <label for="service">Service Type</label>
                        <select class="form-control" id="service-<?php echo $patient['PatientNo']; ?>" name="service" required>
                            <option value="" disabled selected>Select a service</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Routine Checkup">Routine Checkup</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Follow-up">Follow-up</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="datetime-<?php echo $patient['PatientNo']; ?>">Date and Time</label>
                        <input type="text" class="form-control" id="datetime-<?php echo $patient['PatientNo']; ?>" name="datetime" required>
                    </div>
                    <div class="form-group">
                        <label for="medicalissue-<?php echo $patient['PatientNo']; ?>">Medical Issue</label>
                        <textarea class="form-control" id="medicalissue-<?php echo $patient['PatientNo']; ?>" name="medicalissue" rows="4" placeholder="Describe the medical issue" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No patients found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
    <a href="Aboutus.php" style="color: white;">About us</a>
    <span>|</span>
    <a href="Contactus.php" style="color: white;">Contact us</a>
</footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.querySelectorAll('[id^="datetime-"]').forEach(input => {
            flatpickr(input, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today"
            });
        });

        setTimeout(() => {
            document.querySelectorAll('.alert-show').forEach(alert => {
                alert.classList.remove('alert-show');
            });
        }, 2000);
        
                
                document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const dateTimeInput = form.querySelector('[name="datetime"]');
                const selectedDate = new Date(dateTimeInput.value);
                const now = new Date();

                if (selectedDate < now) {
                    e.preventDefault(); 
                    alert('Please select a date and time that is not in the past.');
                }
            });
        });

    </script>
</body>
</html>
