<?php
    $servername = "https://sql100.infinityfree.com";
    $username = "if0_37421127";
    $password = "Ab202405730";
    $dbname = "if0_37421127_testdb";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        die("連線失敗".mysqli_connect_error());
    }

    //從product這個table，選取全部欄位
    $sql = "SELECT * FROM product ORDER BY ID DESC";
    // 經由$conn這個連線，執行$sql這個指令
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){
    //     $row = mysqli_fetch_assoc($result);
    //     echo "ID:" . $row["ID"] . "Name" . $row["Name"];

    //     $row = mysqli_fetch_assoc($result);
    //     echo "ID:" . $row["ID"] . "Name" . $row["Name"];

    //     $row = mysqli_fetch_assoc($result);
    //     echo "ID:" . $row["ID"] . "Name" . $row["Name"];
        $mydata = array();
        while($row = mysqli_fetch_assoc($result)){
            // echo "ID:" . $row["ID"] . "Name" . $row["Name"];
            $mydata[] = $row;
        }
        echo '{"state" : true ,"data": '. json_encode($mydata) .', "message" : "讀取所有產品成功"}';
    }else{
        echo '{"state" : false, "message" : "讀取失敗和錯誤代碼等';
    }
    mysqli_close($conn);
?>
    
    
