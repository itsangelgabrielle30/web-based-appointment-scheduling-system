<?php 
include("Sub_Bar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Google Font -->
    <style>
        body {
            font-family: 'Roboto', sans-serif; /* Apply the Google Font */
        }

        .contact-us {
            padding: 30px; /* Increased overall padding */
            background-color: #f8f9fa; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            margin: 20px;
        }

        .contact-us h2,
        .contact-us h3 {
            color: #343a40; 
            margin-bottom: 15px; /* Spacing below headings */
        }

        .contact-us p, 
        .contact-us ul {
            margin-bottom: 15px; /* Spacing below paragraphs and lists */
            line-height: 1.6; /* Increased line height for readability */
        }

        .contact-us ul {
            list-style-type: none; 
            padding: 0; 
        }

        .contact-us a {
            color: #007bff; 
            text-decoration: none;
        }

        .contact-us a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: #343a40;
            text-align: center;
            padding: 20px;
            width: 100%;
            color: white; /* Ensure footer text is white */
            border-top: 1px solid #ddd;
        }

        .footer a {
            margin-left: 10px;
            margin-right: 10px;
            color: white; /* Ensure footer links are white */
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="contact-us">
            <h2>Contact Us</h2>
            <hr style = "Backgroundcolor: black;";><br>
            <p>Have questions or need more information? Get in touch with us through the following channels:</p>
            <ul>
                <li>Email: <a href="mailto:contact@hospital.com">contact@hospital.com</a></li>
                <li>Phone: <a href="tel:+1234567890">+1 234 567 890</a></li>
                <li>Address: 123 Medical Lane, Health City, HC 12345</li>
            </ul>
                <br>
            <h3>Office Hours</h3>
            <hr style = "Backgroundcolor: black;";>
            <p>We are open during the following hours:</p>
            <ul>
                <li>Monday to Friday: 8 AM - 6 PM</li>
                <li>Saturday: 9 AM - 2 PM</li>
                <li>Sunday: Closed</li>
            </ul>
                <br>
            <h3>Directions</h3>
            <hr style = "Backgroundcolor: black;";>
            <p>Our facility is conveniently located in the heart of Health City. You can reach us via public transport or by car. Here are some nearby landmarks:</p>
            <ul>
                <li>Next to Health Plaza Mall</li>
                <li>Across from City Park</li>
                <li>5 minutes from Main Train Station</li>
            </ul>
            <br>
            <h3>Frequently Asked Questions (FAQs)</h3>
            <hr style = "Backgroundcolor: black;";>
            <ul>
                <li><strong>What insurance plans do you accept?</strong> <br> We accept a variety of insurance plans. Please contact us for more details.</li>
                <br>
                <li><strong>Can I schedule an appointment online?</strong> <br> Yes, you can schedule an appointment through our online booking system.</li>
                <br>
                <li><strong>Do you offer telemedicine services?</strong> <br> Yes, we provide telemedicine consultations for your convenience.</li>
            </ul>
            <br>
            <h3>Follow Us on Social Media</h3>
            <hr style = "Backgroundcolor: black;";>
            <p>Stay updated with our latest news and promotions:</p>
            <ul>
                <li><a href="https://facebook.com/hospital" target="_blank">Facebook</a></li>
                <li><a href="https://twitter.com/hospital" target="_blank">Twitter</a></li>
                <li><a href="https://instagram.com/hospital" target="_blank">Instagram</a></li>
            </ul>
        </section>
    </div>
    <footer class="footer">
        <a href="Aboutus.php">About us</a>
        <span>|</span>
        <a href="Contactus.php">Contact us</a>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
