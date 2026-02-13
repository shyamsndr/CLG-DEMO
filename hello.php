<?php
include("dbconnection/connect.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $home = isset($_POST['house']) ? $_POST['house'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $street = isset($_POST['street']) ? $_POST['street'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $pin = isset($_POST['pincode']) ? $_POST['pincode'] : '';
    $question = isset($_POST['security_question']) ? $_POST['security_question'] : '';
    $answer = isset($_POST['security_answer']) ? $_POST['security_answer'] : '';
    if (!empty($dob) && !empty($home) && !empty($street) && !empty($district) && !empty($pin)) {

        // Escape special characters for security
        $dob = mysqli_real_escape_string($conn, $dob);
        $gender = mysqli_real_escape_string($conn, $gender);
        $home = mysqli_real_escape_string($conn, $home);
        $street = mysqli_real_escape_string($conn, $street);
        $district = mysqli_real_escape_string($conn, $district);
        $pin = mysqli_real_escape_string($conn, $pin);
        $question = mysqli_real_escape_string($conn, $question);
        $answer = mysqli_real_escape_string($conn, $answer);
        $email=$_SESSION['emailid'];
        $sqli="SELECT reg_id FROM registration WHERE email='$email'";
        $result = $conn->query($sqli);
        $row = $result->fetch_assoc();
        $id = $row['reg_id'];
        $sql="UPDATE registration SET house='$home',street='$street',district='$district',pincode='$pin',gender='$gender',DOB='$dob' WHERE email='$email'";

            if (mysqli_query($conn, $sql)) {
                // Insert into login table
                $sql3 = "INSERT INTO customer(reg_id) VALUES('$id')";
                if (mysqli_query($conn, $sql3)) {
                $sql2 = "UPDATE login SET security_question='$question', security_answer='$answer' WHERE email='$email'";
                if (mysqli_query($conn, $sql2)) {
                    echo "<script>alert('Registration completed');</script>";
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "<script>alert('Error completing registration');</script>";
                }
            }else {
                echo "<script>alert('Error completing registration');</script>";
            }
            } else {
                echo "<script>alert('Error inserting into registration table');</script>";
            }
        }
    } else {
        echo "<script>alert('Please fill in all the required fields');</script>";
    }

// Close connection
mysqli_close($conn);
hehe sura
