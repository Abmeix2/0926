<?php

// {"state" : true, "data" : "會員資訊", "message" : "讀取會員資料成功!"}
// {"state" : false, "message" : "讀取會員資料失敗!"}


        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();
        // 遞增ASC 遞減DESC
        // 給sql指令: 按ID遞減，撈出(select)資料庫中的ID, 帳號、Email、及Uid01等欄位資料。
        $sql = "SELECT ID, Username, Email, Uid01, State, Level, Created_at FROM member ORDER BY ID DESC";
        // 執行上方sql指令，並將結果設給$result
        $result = execute_sql($link, "if0_37421127_testdb", $sql);
       
        // 將result，一筆一筆列出來，直到沒有資料可撈。因為很多筆，所以要用陣列array()呈現
        $mydata = array();
        while($row = mysqli_fetch_assoc($result)){
            $mydata[] = $row;
        }

        echo '{"state" : true, "data" : ' .json_encode($mydata) . ', "message" : "讀取會員資料成功!"}';

        // 記得關閉資料庫
        mysqli_close($link);
?>
