<?php
    function create_connection()
    {
        // $conn = mysqli_connect("https://sql100.infinityfree.com", "owner", "123456")
        // if($conn){
        //     die("連線失敗:" . mysqli_connect_error())
        // }

        $conn = mysqli_connect("https://sql100.infinityfree.com", "if0_37421127", "Ab202405730")
            or die("連線失敗:" . mysqli_connect_error());
        
        return $conn;
    }


    function execute_sql($link, $database, $sql){
        mysqli_select_db($link, $database) 
            or die("連線資料庫失敗" . mysqli_error($link));
        
            $result = mysqli_query($link, $sql);

            return $result;
    }
?>