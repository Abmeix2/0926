<?php
    $servername = "https://sql100.infinityfree.com";
    $username = "if0_37421127";
    $password = "Ab202405730";

    //建立連線
    $conn = mysqli_connect($servername, $username, $password);
    if(!$conn){
        die("連線失敗!".mysqli_connect_error());
    }
    
    
    echo "連線成功"
?>