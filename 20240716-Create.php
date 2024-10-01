<?php
    //直接丟等號右邊的到底下VALUES''的地方，太多引號，要簡化。故新增變數p_name(及post name的意思)=右邊。簡化
    $p_name = $_POST["name"];
    $p_price = $_POST["price"];
    $p_num = $_POST["num"];
    $p_remark = $_POST["remark"];

    $servername = "https://sql100.infinityfree.com";
    $username = "if0_37421127";
    $password = "Ab202405730";
    $dbname = "if0_37421127_testdb";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        die("連線失敗".mysqli_connect_error());
    }

    $sql = "INSERT INTO product(Name, Price, Num, Remark) VALUES('$p_name','$p_price','$p_num','$p_remark')";
    // 新增只有成功或失敗:布林值，用if else
    if(mysqli_query($conn, $sql)){
        echo '{"state" : true , "message" : "新增成功"}';
    }else{
        echo '{"state" : false , "message" : "新增失敗'.$sql.mysqli_error($conn).'"}';
    }
    //最後一定要記得關閉連線!
    mysqli_close($conn);
?>



