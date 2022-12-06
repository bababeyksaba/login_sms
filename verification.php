<?php

session_start();

if(!isset($_SESSION['confirm-code']) || !isset($_SESSION['confirm'])){
    echo "متاسفانه زمان مجاز برای احراز گذشته است. لطفا مجدد ثبت نام کنید.";
    // header('location: ../operations/error.php?id=expire');
    exit();
}

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

if(isset($_POST['submit'])){

    $code_user = convert($_POST['code']);
    $code = $_SESSION['confirm-code'];
    $phone = $_SESSION['confirm'];

    // اگر از کاربر شماره موبایل میگیرید :
    $sql = "SELECT * FROM users WHERE phone='$phone';";
    // اگر از کاربر شماره موبایل نمیگیرید : 
    // $sql = "SELECT * FROM users WHERE email='$phone';";
    $res = mysqli_query($con, $sql);

    if(mysqli_num_rows($res)<1){
        echo "کاربری با این اطلاعات وجود ندارد. لطفا ثبت نام کنید.";
        // header('location: ../operations/error.php?id=no-user');
        exit();
    }

    if($code_user==$code){

        // اگر از کاربر شماره موبایل میگیرید :
        $sql1 = "UPDATE users SET action=1 WHERE phone='$phone';";
        // اگر از کاربر شماره موبایل نمیگیرید :
        // $sql1 = "UPDATE users SET action=1 WHERE email='$phone';";
        $res1 = mysqli_query($con, $sql1);

        if($res1){
            $_SESSION['user'] = $phone;
            header('location: ../profile');
        }else{
            echo "متاسفانه خطایی در ثبت نام شما ره داده است. لطفا دوباره تلاش کنید.";
            // header('location: ../operations/error.php?id=update-act');
            exit();
        }

    }else{
        echo "کد وارد شده نادرست است. لطفا دوباره تلاش کنید. اگر کد برای شما ارسال نشد مجدد ثبت نام کنید.";
        // header('location: ../operations/error.php?id=wrong-code');
        exit();
    }

}


?>