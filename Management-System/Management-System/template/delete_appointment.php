<?php
include("Databaseconnection/Databasecon.php");
include("Sub_Bar.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit();
}

$accountno = isset($_SESSION['Account_ID']) ? $_SESSION['Account_ID'] : '';

if (isset($_GET['id'])) {
    $scheduleNo = $_GET['id'];

    $databasecon = new DatabaseConnection();
    $conn = $databasecon->connect();

    if (!$conn) {
        die('Database connection failed: ' . $conn->connect_error);
    }


    $sql = 'DELETE FROM scheduling WHERE ScheduleNo = ?';
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('s', $scheduleNo);
    $stmt->execute();

    header('Location: Viewappointment.php');
    exit();
}
?>
