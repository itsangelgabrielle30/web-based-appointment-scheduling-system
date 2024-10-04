<?php 
include("Sub_Bar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .section {
            padding: 40px 0; 
        }
        .about-us {
            padding: 30px;
            background-color: #f8f9fa; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            margin: 20px;
            text-align: left; 
        }
        h2, h3 {
            color: #343a40; 
            margin-bottom: 15px;
        }
        p, ul {
            margin-bottom: 15px; 
            line-height: 1.6;
        }
        ul {
            list-style-type: none; 
            padding: 0; 
        }
        a {
            color: #007bff; 
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            background-color: #343a40;
            text-align: center;
            padding: 20px;
            width: 100%;
            color: white; 
            border-top: 1px solid #ddd;
        }
        .footer a {
            margin-left: 10px;
            margin-right: 10px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="about" class="section section-light">
            <div class="container about-us">
                <h2>About Us</h2>
                <hr>
                <p class="lead">We are dedicated to providing high-quality healthcare services to our community. Our team of professionals is committed to excellence and compassionate care.</p>
                <p>Established in 1995, our hospital has been a cornerstone of medical care in the region, with state-of-the-art facilities and a wide range of medical specialties. Our mission is to offer comprehensive healthcare services with a patient-centered approach.</p>
                <br>
                <h3>Our Vision</h3>
                <hr>
                <p>To be the leading healthcare provider in the region, known for innovative practices and exceptional patient care.</p>
                <br>
                <h3>Our Values</h3>
                <hr><br>
                <ul>
                    <li><strong>Compassion:</strong> We treat our patients and their families with kindness and empathy.</li>
                    <li><strong>Integrity:</strong> We uphold the highest standards of ethics and honesty in all our interactions.</li>
                    <li><strong>Excellence:</strong> We strive for excellence in everything we do, from patient care to service delivery.</li>
                    <li><strong>Collaboration:</strong> We work together with patients, families, and colleagues to achieve the best outcomes.</li>
                </ul>
                <br>
                <h3>Our Services</h3>
                <hr>
                <p>We offer a wide range of services, including:</p>
                <ul>
                    <li>Emergency Care</li>
                    <li>Surgery</li>
                    <li>Maternity Services</li>
                    <li>Pediatrics</li>
                    <li>Diagnostic Imaging</li>
                    <li>Rehabilitation Services</li>
                    <li>Wellness Programs</li>
                </ul>
                <br>

                <h3>Community Involvement</h3>
                <p>We believe in giving back to the community. Our hospital is actively involved in health education programs, free health screenings, and community outreach initiatives to promote wellness and prevent disease.</p>
                
                <h3>Meet Our Team</h3>
                <p>Our healthcare team consists of highly skilled professionals, including doctors, nurses, and specialists who are dedicated to providing the best possible care for our patients. We are proud of our diverse and experienced team that reflects the community we serve.</p>
            </div>
        </div>
    </div>
    <footer class="footer">
        <a href="aboutus.php">About us</a>
        <span>|</span>
        <a href="Contactus.php">Contact us</a>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
