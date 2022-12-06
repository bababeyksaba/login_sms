<?php

// تنظیم زمان روی تهران
date_default_timezone_set('Asia/Tehran');
$time = time();

// فایل دیتا بیس در مسیر اصلی سایت است
include "../db.php";

function convert($string) {
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

    return $englishNumbersOnly;
}


// اگر شماره موبایل و ایمیل میگرفتید :

if(isset($_POST['submit'])){

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = convert($_POST['phone']);
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql1 = "SELECT * FROM users WHERE phone='$phone';";
    $re1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($res1);

    if(mysqli_num_rows($res1)>0 && $row1['action']==1){
        echo "شما قبلا ثبت نام کرده اید. لطفا وارد شوید.";
        // header('location: ../operations/error.php?id=registered');
        exit();
    }

    if(mysqli_num_rows($res1)>0 && $row1['action']==0){
        $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email', password='$password', date='$time' WHERE phone='$phone';";
    }else{
        $sql = "INSERT INTO users (fname, lname, phone, email, password, date) VALUES ('$fname', '$lname', '$phone', '$email', '$password', '$time');";
    }
    
    $res = mysqli_query($con, $sql);

    $code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    if($res){
        header('location: sms.php?phone='.$phone.'&code='.$code);
    }else{
        echo "متاسفانه ثبت نام شما انجام نشد. لطفا دوباره تلاش کنید.";
        // header('location: ../operations/error.php?id=no-reg');
    }
}


// اگر شماره موبایل میگرفتید :

// if(isset($_POST['submit'])){

//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $phone = convert($_POST['phone']);
//     $password = $_POST['password'];

    // $sql1 = "SELECT * FROM users WHERE phone='$phone';";
    // $re1 = mysqli_query($con, $sql1);
    // $row1 = mysqli_fetch_assoc($res1);

    // if(mysqli_num_rows($res1)>0 && $row1['action']==1){
    //     echo "شما قبلا ثبت نام کرده اید. لطفا وارد شوید.";
    //     // header('location: ../operations/error.php?id=registered');
    //     exit();
    // }

    // if(mysqli_num_rows($res1)>0 && $row1['action']==0){
    //     $sql = "UPDATE users SET fname='$fname', lname='$lname', password='$password', date='$time';";
    // }else{
    //     $sql = "INSERT INTO users (fname, lname, phone, password, date) VALUES ('$fname', '$lname', '$phone', '$password', '$time');";
    // }

//     $res = mysqli_query($con, $sql);
    
//     $code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

//     if($res){
//         header('location: sms.php?phone='.$phone.'&code='.$code);
//     }else{
//         echo "متاسفانه ثبت نام شما انجام نشد. لطفا دوباره تلاش کنید.";
//         // header('location: ../operations/error.php?id=no-reg');
//     }
// }



// اگر ایمیل میگرفتید :

// if(isset($_POST['submit'])){

//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];

    // $sql1 = "SELECT * FROM users WHERE phone='$phone';";
    // $re1 = mysqli_query($con, $sql1);
    // $row1 = mysqli_fetch_assoc($res1);

    // if(mysqli_num_rows($res1)>0 && $row1['action']==1){
    //     echo "شما قبلا ثبت نام کرده اید. لطفا وارد شوید.";
    //     // header('location: ../operations/error.php?id=registered');
    //     exit();
    // }

    // if(mysqli_num_rows($res1)>0 && $row1['action']==0){
    //     $sql = "UPDATE users SET fname='$fname', lname='$lname', password='$password', date='$time';";
    // }else{
    //     $sql = "INSERT INTO users (fname, lname, email, password, date) VALUES ('$fname', '$lname', '$email', '$password', '$time');";
    // }

//     $res = mysqli_query($con, $sql);

//     $code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

//     if($res){
//         header('location: email.php?email='.$email.'&code='.$code);
//     }else{
//         echo "متاسفانه ثبت نام شما انجام نشد. لطفا دوباره تلاش کنید.";
//         // header('location: ../operations/error.php?id=no-reg');
//     }
// }
?>