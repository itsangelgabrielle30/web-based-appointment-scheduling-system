<?php

include("Databaseconnection/Databasecon.php");
include("Sub_Bar.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit();
}

$accountno = isset($_SESSION['Account_ID']) ? $_SESSION['Account_ID'] : '';

$appointments = [];
$databasecon = new DatabaseConnection();
$conn = $databasecon->connect();

if (!$conn) {
    die('Database connection failed: ' . $conn->connect_error);
}

$sql = 'SELECT * FROM scheduling WHERE AccountNo = ? AND Status != ?';
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}
$statusToExclude = 'Awaiting Doctor Assignment';
$stmt->bind_param('is', $accountno, $statusToExclude);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="logo.jpg" type="image/x-icon">
    <title>View Appointments</title>
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
        .custom-textarea {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .custom-textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
            outline: none;
        }
        .animated-textarea {
        transition: all 0.3s ease;
        background-color: #f8f9fa; 
        border: 1px solid #ced4da; 
        border-radius: 0.25rem; 
        box-shadow: inset 0 0 0 rgba(0,0,0,.125); 
    }

    .animated-textarea:focus {
        background-color: #fff; 
        border-color: #80bdff; 
        box-shadow: 0 0 0 0.2rem rgba(38,143,255,.25); 
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
        .success-modal-content {
            background-color: #28a745; 
            color: white;
        }

        .success-modal-header {
            border-bottom: 1px solid #fff;
        }

        .success-modal-body {
            font-weight: bold;
        }
        .fade-out {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    </style>
</head>
<body>

<div class="container">
    <br><br>
    <h2>Appointments</h2>
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
                                        </td>

                                     </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No appointments found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>



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
                    <div class="mb-3">
                        <label for="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" class="form-label">Treatment</label>
                        <textarea class="form-control custom-textarea" id="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="Treatment" rows="4" placeholder="Treatment" required><?php echo htmlspecialchars($appointment['Treatment']); ?></textarea>
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
                <form action="Viewappointment.php" method="post">
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
                        <textarea class="form-control custom-textarea" id="medicalissue-<?php echo htmlspecialchars($appointment['ScheduleNo']); ?>" name="medicalissue" rows="4" placeholder="Describe the medical issue" required><?php echo htmlspecialchars($appointment['MedicalIssue']); ?></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Appointment</button>
                    </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.alert-show').forEach(alert => {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 500); 
            });
        }, 2000);
    });
</script>
</body>
</html>
