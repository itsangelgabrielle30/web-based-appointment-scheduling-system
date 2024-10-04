<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
$isUser = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DocAppointments</title>
  <link rel="icon" href="logo.jpg" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }

    .navbar-brand {
      font-weight: 300;
      font-size: 1rem;
    }

    .nav-link {
      font-size: 1rem;
      font-weight: 500;
      margin-right: 15px;
      color: #fff;
      padding: 10px 15px;
      border-radius: 5px; 
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
      background-color: gray;
      color: #fff;
      text-decoration: none; 
    }

    .navbar-toggler {
      border: none;
      box-shadow: none;
    }

    .navbar-custom {
      background-color: #343a40; 
    }

    @media (max-width: 767.98px) {
      .navbar-nav {
        margin-top: 10px;
      }

      .nav-item {
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">DocAppointments</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="Base.php">Home</a>
          </li>
          
          <?php if ($isLoggedIn) { ?>
            <?php if ($isAdmin) { ?>
              <li class="nav-item">
                <a class="nav-link" href="Register_Doctor.php">Register Doctor</a>
              </li>
            <?php } ?>

            <?php if ($isUser) { ?>
              <li class="nav-item">
                <a class="nav-link" href="Register_Patient.php">Register Patient</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Appointment
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="Bookappointment.php">Book Appointment</a></li>
                  <li><a class="dropdown-item" href="Viewappointment.php">View Appointment</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Report.php">Report</a>
              </li>
            <?php } ?>

            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="Login.php">Login</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
