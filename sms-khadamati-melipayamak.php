<?php

// ارسال پیامک ملی پیامک با خط خدماتی




session_start();

// فایل دیتا بیس در مسیر اصلی سایت است
include "../db.php";


$phone = $_GET['phone'];
$code1 = $_GET['code'];
$code = json_encode($code1);

$_SESSION['confirm'] = $phone;
$_SESSION['confirm-code'] = $code;


// API-ADDRESS خط زیر باید کد مختص مشتری رو بذارید به جای
$url = 'https://console.melipayamak.com/api/send/shared/API-ADDRESS';
// khate zir be jaye 524 bodyid panel payamaki moshtari ro mizarim, tooye text ham matnesh ro mitonim harchi mikhaym bezarim.
$data = array('bodyId' => 524, 'to' => $phone, 'args' => [$code]);
$data_string = json_encode($data);
$ch = curl_init($url);                          
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                      
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

// Next line makes the request absolute insecure
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Use it when you have trouble installing local issuer certificate
// See https://stackoverflow.com/a/31830614/1743997

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER,
  array('Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
  );
$result = curl_exec($ch);
curl_close($ch);

if (strpos($result, 'ارسال موفق بود') !== false) {
    header("Location: ver.php");
}else{
    echo "متاسفانه پیامک ارسال نشد. از درستی شماره همراه خود مطمئن شوید.";
    // header('Location: ../operations/error.php?id=no-sms');
    exit();
}


?>