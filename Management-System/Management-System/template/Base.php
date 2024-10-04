
<?php  // Make sure to start the session
include "Sub_Bar.php";

// Store the success or error message for display
$message = '';
if (isset($_SESSION["success_message"]) || isset($_SESSION["error_message"])) {
    $message = htmlspecialchars($_SESSION["success_message"] ?? $_SESSION["error_message"]);
    unset($_SESSION["success_message"], $_SESSION["error_message"]); // Clear the messages after use
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Scheduling</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .parallax {
            background-image: url('https://f.hubspotusercontent40.net/hubfs/5012494/5-reasons-to-use-patient-scheduling-software.jpg'); 
            height: 100vh; 
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        .parallax-content {
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
        }
        .btn-custom {
            margin-top: 20px;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 18px;
        }
        .section {
            padding: 60px 20px;
            opacity: 0; 
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out; 
        }
        .section-visible {
            opacity: 1;
            transform: translateY(0); 
        }
        .section-light {
            background-color: #f8f9fa;
            color: #333;
        }
        .section-dark {
            background-color: #343a40;
            color: #f8f9fa;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
            
            width: 100%;
            color: black;
            border-top: 1px solid #ddd;
        }
        .footer a
        {
            margin-left: 10px;
            margin-right: 10px;
        }
        .team-member {
            margin-bottom: 30px;
            padding: 15px;
        }
        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-bottom: 15px;
        }
        .testimonial {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .testimonial-author {
            font-weight: bold;
            color: #007bff;
        }
        .preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .preloader .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h2, h4 {
            font-family: 'Roboto', sans-serif;
            color: #007bff;
        }
        p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="preloader">
        <div class="spinner"></div>
    </div>
<!-- Modal HTML -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?php 
                        if ($message) {
                            echo $message;
                        }
                    ?>
                    </div>

        </div>
    </div>
</div>


    <div class="parallax">
        <div class="parallax-content">
            <h1>Welcome to Our Hospital</h1>
            <p>Providing quality healthcare services with compassion and excellence.</p>
            <?php 
                if ($isLoggedIn) {
                    echo '<a href="Bookappointment.php" class="btn btn-primary btn-custom">Schedule Now</a>';
                } else {
                    echo '<a href="Login.php" class="btn btn-primary btn-custom">Schedule Now</a>';
                }
            ?>
        </div>
    </div>



    <div id="mission-vision" class="section section-dark">
        <div class="container text-center">
            <h2>Mission and Vision</h2>
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h4>Our Mission</h4>
                    <p>Our mission is to deliver exceptional, compassionate healthcare services to our community. We strive to improve the health and well-being of every patient we serve.</p>
                </div>
                <div class="col-md-6">
                    <h4>Our Vision</h4>
                    <p>We envision being the leading provider of healthcare in the region, recognized for our commitment to quality, innovation, and patient-centered care.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="services" class="section section-light">
        <div class="container">
            <h2 class="text-center">Our Services</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4>Emergency Care</h4>
                    <p>24/7 emergency services to handle critical situations. Our emergency department is equipped with the latest technology and staffed by highly trained professionals.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4>Outpatient Services</h4>
                    <p>Comprehensive care without the need for hospital admission. From routine check-ups to minor procedures, we provide a full range of outpatient services.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4>Specialized Treatments</h4>
                    <p>Advanced treatments in various medical specialties including cardiology, oncology, orthopedics, and more. Our specialized teams offer personalized care tailored to your needs.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="testimonials" class="section section-dark">
        <div class="container">
            <h2 class="text-center">Patient Testimonials</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial">
                        <p style="color:black;">"The care and attention I received were exceptional. The staff was friendly and professional. I highly recommend this hospital to anyone in need of medical care."</p>
                        <p class="testimonial-author">- Sarah Thompson</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial">
                        <p style="color:black;">"From the moment I walked in, I felt like I was in good hands. The doctors and nurses were knowledgeable and caring. Thank you for making my treatment a positive experience."</p>
                        <p class="testimonial-author">- David Wilson</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial">
                        <p style="color:black;">"Excellent service and a caring team. The facilities are top-notch, and the staff goes above and beyond to ensure patient comfort. I would definitely come here again."</p>
                        <p class="testimonial-author">- Emily Clark</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

  

    <footer class="footer">
    <a href="Aboutus.php" style="color: black;">About us</a>
    <span>|</span>
    <a href="Contactus.php" style="color: black;">Contact us</a>
</footer>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            // Handle preloader
            const preloader = document.querySelector('.preloader');
            setTimeout(() => {
                preloader.style.opacity = 0;
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500); 
            }, 1000);

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                $('#alertModal').modal('show');
                setTimeout(() => {
                    $('#alertModal').modal('hide');
                }, 2000); // 2 seconds
            }
        });
        document.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                const viewportHeight = window.innerHeight;
                if (sectionTop < viewportHeight - 100) {
                    section.classList.add('section-visible');
                }
            });
        });



        cript>
        window.addEventListener('load', function() {
            
            const preloader = document.querySelector('.preloader');
            setTimeout(() => {
                preloader.style.opacity = 0;
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500); 
            }, 1000);
            <?php if ($message): ?>
                $('#alertModal').modal('show');
                setTimeout(() => {
                    $('#alertModal').modal('hide');
                }, 2000);
            <?php endif; ?>
        });


    </script>
</body>
</html>

