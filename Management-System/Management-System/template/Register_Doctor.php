<?php
include("Databaseconnection/Databasecon.php");
include("Sub_Bar.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit();
}

$appointments = [];
$databasecon = new DatabaseConnection();
$conn = $databasecon->connect();

if (!$conn) {
    die('Database connection failed: ' . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ScheduleNo = $_POST['ScheduleNo'];
    $Treatment = $_POST['Treatment'];
    $DoctorAssign = $_POST['DoctorAssign']; 
    $status = $_POST['TreatmentStatus'];

    $sql = 'UPDATE scheduling SET Treatment = ?, DoctorAssign = ? , Status = ? WHERE ScheduleNo = ?'; 
    $stmt = $conn->prepare($sql);



    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('sssi', $Treatment, $DoctorAssign, $status, $ScheduleNo);


    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['successMessage'] = 'Patient Treatment updated successfully!';
        } else {
            $_SESSION['errorMessage'] = 'No changes made. Check if the ScheduleNo is correct.';
        }
    } else {
        
        $_SESSION['errorMessage'] = 'Failed to update Patient Treatment: ' . $stmt->error;
    }
    $stmt->close();
    $conn->close();


    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$sql = 'SELECT * FROM scheduling';
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

$stmt->close();


$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';




$sql = 'SELECT * FROM scheduling';
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

$stmt->close();
$conn->close();

$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Doctor</title>
    <link rel="icon" href="logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .alert-info {
            font-size: 1.125rem;
            font-weight: 500;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }

        .button-view {
            width: 32px;
            height: 32px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin: 2px;
        }

        .button-view:hover {
            background-color: #0056b3;
        }

        .button-view.view {
            background-color: #28a745;
        }

        .button-view.view:hover {
            background-color: #218838;
        }

        .button-view.edit {
            background-color: #ffc107;
        }

        .button-view.edit:hover {
            background-color: #e0a800;
        }

        .button-view.delete {
            background-color: #dc3545;
        }

        .button-view.delete:hover {
            background-color: #c82333;
        }

        .actions {
            display: flex;
            gap: 5px;
            justify-content: center;
            align-items: center;
        }

        thead th, tbody td {
            text-align: center;
        }

        .footer-icon {
            font-size: 1.25rem;
            margin-right: 5px;
        }

        .icon-view {
            color: #28a745;
        }

        .icon-edit {
            color: #ffc107;
        }

        .icon-delete {
            color: #dc3545;
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
    <br><br>
    <h2>Register a Doctor and Treatment</h2>
    <?php if (isset($_SESSION['successMessage']) || isset($_SESSION['errorMessage'])): ?>
        <div class="alert <?php echo isset($_SESSION['successMessage']) ? 'alert-success alert-show' : 'alert-danger alert-show'; ?>">
            <?php echo htmlspecialchars($_SESSION['successMessage'] ?? $_SESSION['errorMessage']); ?>
        </div>
        <?php
        unset($_SESSION['successMessage']);
        unset($_SESSION['errorMessage']);
        ?>
    <?php endif; ?>   

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table summary="This table shows appointments" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ScheduleNo</th>
                                <th>PatientNo</th>
                                <th>Fullname</th>
                                <th>Date and time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($appointments): ?>
                                <?php foreach ($appointments as $index => $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($index + 1); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['ScheduleNo']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['PatientNo']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['Fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['DateTimeSchedule']); ?></td>
                                        <td>
                                            <?php 
                                            $status = !empty($appointment['Status']) ? htmlspecialchars($appointment['Status']) : 'Doctor waiting';
                                            echo $status;
                                            ?>
                                        </td>
                                        <td class="actions">
                                                <button type="button" class="button-view view" data-bs-toggle="modal" data-bs-target="#appointmentModal-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>"><i class="fas fa-eye"></i></button>
                                                <button type="button" class="button-view edit" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                                               
                                            </td>

                                     </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No appointments found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p>
                                        To view more details about an appointment, click the <i class="fas fa-eye footer-icon icon-view"></i> <strong>View</strong> button in the <strong>Action</strong> column. This will open a modal with more information about the selected appointment.
                                    </p>
                                    <p>
                                        Use the <i class="fas fa-pencil-alt footer-icon icon-edit"></i> <strong>Edit</strong> button to modify appointment details 
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>

    <?php foreach ($appointments as $appointment): ?>
        <div class="modal fade" id="appointmentModal-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>">Appointment Details for <?php echo htmlspecialchars($appointment['Fullname']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Schedule Number:</strong> <?php echo htmlspecialchars($appointment['ScheduleNo']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Patient Number:</strong> <?php echo htmlspecialchars($appointment['PatientNo']); ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($appointment['Fullname']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date and Time:</strong> <?php echo htmlspecialchars($appointment['DateTimeSchedule']); ?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p><strong>Status:</strong> <?php echo htmlspecialchars(!empty($appointment['Status']) ? $appointment['Status'] : 'Doctor waiting'); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Medical Issue</label>
                            <textarea class="form-control animated-textarea" id="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" rows="4" readonly><?php echo htmlspecialchars($appointment['MedicalIssue']); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php endforeach; ?>

    <?php foreach ($appointments as $appointment): ?>
    <div class="modal fade" id="updateModal-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>">Modify Appointment for <?php echo htmlspecialchars($appointment['Fullname']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Register_Doctor.php" method="post">
                        <input type="hidden" name="ScheduleNo" value="<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>">
                        <div class="mb-3">
                            <label for="fullname-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="Fullname" value="<?php echo htmlspecialchars($appointment['Fullname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="dateTimeSchedule-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Date and Time</label>
                            <input type="datetime-local" class="form-control" id="dateTimeSchedule-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="DateTimeSchedule" value="<?php echo htmlspecialchars($appointment['DateTimeSchedule']); ?>" required>
                        </div>
                        <div class="mb-3">
                        <label for="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Medical Issue</label>
                        <textarea class="form-control custom-textarea" id="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="MedicalIssue" rows="4" placeholder="Describe the medical issue" required><?php echo htmlspecialchars($appointment['MedicalIssue']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="doctorAssign-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Doctor Assign</label>
                            <input type="text" class="form-control" id="doctorAssign-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="DoctorAssign" value="<?php echo htmlspecialchars($appointment['DoctorAssign']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="treatmentStatus" class="form-label">Treatment Status</label>
                            <select class="form-select" id="treatmentStatus" name="TreatmentStatus" required>
                                <option value="" disabled selected>Select Treatment Status</option>
                                <option value="Successfully Treated">Successfully Treated</option>
                                <option value="Improved">Improved</option>
                                <option value="Stable">Stable</option>
                                <option value="Referred">Referred</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Resolved with Complications">Resolved with Complications</option>
                                <option value="Treatment Adjusted">Treatment Adjusted</option>
                                <option value="Patient Not Compliant">Patient Not Compliant</option>
                                <option value="Further Evaluation Required">Further Evaluation Required</option>
                                <option value="Pending Confirmation">Pending Confirmation</option>
                                <option value="Deceased">Deceased</option>
                            </select>
                        </div>


                        <div class="mb-3">
                        <label for="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Assessment</label>
                        <textarea class="form-control custom-textarea" id="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="Treatment" rows="4" placeholder="Assessment" required><?php echo htmlspecialchars($appointment['Treatment']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>



</div>

<footer class="footer">
    <a href="Aboutus.php" style="color: white;">About us</a>
    <span>|</span>
    <a href="Contactus.php" style="color: white;">Contact us</a>
</footer>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>



