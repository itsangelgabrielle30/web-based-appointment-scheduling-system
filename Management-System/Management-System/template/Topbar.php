<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DocAppointments</title>
  <link rel="icon" href="logo.jpg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .mega-menu {
      position: absolute;
      width: 100%;
      left: 0;
      background: #f8f9fa;
      padding: 15px;
      display: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    /* Display mega menu on hover */
    .navbar-nav .nav-item:hover .mega-menu {
      display: block;
    }

    /* Layout inside mega menu */
    .mega-menu .row {
      padding: 20px;
    }

    /* Styling for mega menu links */
    .mega-menu a {
      color: #343a40;
      text-decoration: none;
    }

    .mega-menu a:hover {
      color: #007bff;
    }

    .navbar-custom {
      background-color: #343a40;
    }

    .nav-link {
      color: #fff;
    }

    .nav-link:hover {
      color: #007bff;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Scheduling System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="appointmentDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Appointment
            </a>
            <!-- Mega Menu Content -->
            <div class="mega-menu">
              <div class="row">
                <div class="col-md-3">
                  <h5>Book Appointment</h5>
                  <ul class="list-unstyled">
                    <li><a href="template/Appointment.php">Book Now</a></li>
                    <li><a href="#">Manage Appointments</a></li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <h5>Doctors</h5>
                  <ul class="list-unstyled">
                    <li><a href="#">Available Doctors</a></li>
                    <li><a href="#">Specializations</a></li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <h5>Services</h5>
                  <ul class="list-unstyled">
                    <li><a href="#">General Checkup</a></li>
                    <li><a href="#">Special Procedures</a></li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <h5>Resources</h5>
                  <ul class="list-unstyled">
                    <li><a href="#">Patient Guidelines</a></li>
                    <li><a href="#">FAQs</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="template/Register.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="template/Login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
