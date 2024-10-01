<?php
// {"username":"owner01"}

// {"state" : true, "data" : "會員資訊", "message" : "驗證成功，已登入"}
// {"state" : false, "message" : "驗證失敗，未登入'"}
// {"state" : false, "message" : "欄位不得為空白"}
// {"state" : false, "message" : "欄位命名錯誤"}
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["uid01"])) {       //欄位命名正確
    if ($mydata["uid01"] != "") {    //欄位內容不為空白
        $p_uid01 = $mydata["uid01"];    //將值設給變數

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令: 當 橘色Uid01為資料庫資料 = $p_uid01為前端使用者輸入後產生的cookie?時-->則撈出(select)資料庫中的帳號、Email、Uid01、Level，及State欄位資料。
        $sql = "SELECT Username, Email, Uid01, Level, State FROM member WHERE Uid01 = '$p_uid01'";
        // 執行上方sql指令，並將結果設給$result
        $result = execute_sql($link, "testdb", $sql);
             // 若資料庫搜尋結果筆數為1，代表cookie驗證成功
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);  //將json格式排成陣列?我們比較好看懂
            echo '{"state": true, "data": '. json_encode($row) .', "message" : "驗證成功，已登入!"}';
        } else {
            // 驗證失敗，未登入
            echo '{"state": false, "message" : "驗證失敗，未登入"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        echo '{"state": false, "message" : "欄位不得為空白"}';
    }

} else {
    echo '{"state": false, "message" : "欄位命名錯誤"}';
}
