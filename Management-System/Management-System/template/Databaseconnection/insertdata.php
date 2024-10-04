<?php
include 'databasecon.php';
include 'databaseconnection/getandsetter.php';
function insertData($data) {
    $database = new DatabaseConnection();
    $conn = $database->connect();

    $accountID = $data->getAccountID();
    $firstName = $data->getFirstName();
    $lastName = $data->getLastName();
    $middleName = $data->getMiddleName();
    $suffix = $data->getSuffix();
    $age = $data->getAge();
    $gender = $data->getGender();
    $address = $data->getAddress();
    $email = $data->getEmail();
    $contactNo = $data->getContactNo();

    $stmt = $conn->prepare("INSERT INTO account (AccountID, FirstName, LastName, MiddleName, Suffix, Age, Gender, Address, Email, ContactNo) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssiisss", 
        $accountID, 
        $firstName, 
        $lastName, 
        $middleName, 
        $suffix, 
        $age, 
        $gender, 
        $address, 
        $email, 
        $contactNo
    );

    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $database->closeConnection();
}

function insertAccountData($data) {
    $database = new DatabaseConnection();
    $conn = $database->connect();

    $usertype = "user";
    $accountID = $data->getAccountID();
    $email = $data->getEmail();
    $password = password_hash($data->getPassword(), PASSWORD_BCRYPT); 

    $stmt = $conn->prepare("INSERT INTO accountauth (AccountID, Email, Password, Usertype) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("ssss", $accountID, $email, $password, $usertype);

    if ($stmt->execute()) {
        echo "Account data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $database->closeConnection();
}


function logindataAuth($Email, $Password) {
    $database = new DatabaseConnection();
    $conn = $database->connect();

    if (!$conn) {
        die('Database connection failed: ' . $conn->connect_error);
    }

  
    $stmt = $conn->prepare('SELECT Email, Password, AccountID, Usertype FROM accountauth WHERE Email = ?');
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    $stmt->bind_param('s', $Email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($dbEmail, $dbPassword, $accountID, $usertype);
        $stmt->fetch();

        if (password_verify($Password, $dbPassword)) {
            session_start();
            $_SESSION['user_id'] = $accountID;
            $_SESSION['user_email'] = $dbEmail;
            $_SESSION['user_type'] = $usertype;

            $stsmt = $conn->prepare('SELECT * FROM account WHERE AccountID = ? AND Email = ?');
            if ($stsmt === false) {
                die('Error preparing the statement: ' . $conn->error);
            }
            $stsmt->bind_param('is', $accountID, $Email);
            $stsmt->execute();
            $result = $stsmt->get_result();

            if ($result->num_rows > 0) {
                $accountDetails = $result->fetch_assoc();
                $_SESSION['Account_ID'] = $accountDetails['AccountID'];
                $_SESSION['Firstname'] = $accountDetails['FirstName'];
                $_SESSION['Lastname'] = $accountDetails['Lastname'];
                $_SESSION['middlename'] = $accountDetails['MiddleName'];
                $_SESSION['suffix'] = $accountDetails['Suffix'];
                $_SESSION['contact'] = $accountDetails['ContactNo'];
                $_SESSION['user_role'] = $accountDetails['role'];   

                $stsmt->close();
                header("Location: Base.php");
                exit();
            } else {
                $_SESSION['login_error'] = 'Invalid account details.';
                header("Location: Login.php");
                exit();
            }
        } else {
            $_SESSION['login_error'] = 'Incorrect password.';
            header("Location: Login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Email not found.';
        header("Location: Login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}




function Scheduling($data) {
    $databasecon = new DatabaseConnection();
    $conn = $databasecon->connect();

    $sql = 'INSERT INTO scheduling (AccountNo, Fullname, ContactNo, Email, Address, DateTimeSchedule, PatientNo, DoctorAssign, ScheduleNo, ServiceType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $doctorAssign = randomdoctor();
    $scheduleNo = randomScheduleNo();

    $stmt->bind_param('ssssssssis', $accountNo, $fullname, $contactNo, $email, $address, $dateTimeSchedule, $patientNo, $doctorAssign, $scheduleNo, $serviceType);
    if ($stmt->execute()) {
        echo "Scheduling successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function randomdoctor() {
    $doctors = ['D001', 'D002', 'D003']; 
    return $doctors[array_rand($doctors)];
}

function randomScheduleNo() {
    return 'S' . mt_rand(1000, 9999);
}


