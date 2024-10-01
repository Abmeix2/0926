<?php
// {"id":"xxx", "level": "100"}

// {"state" : true,"message" : "更新成功"}
// {"state" : false, "message" : "會員更新失敗和錯誤代碼等'"}
// {"state" : false, "message" : "欄位不得為空白"}
// {"state" : false, "message" : "欄位命名錯誤"}
$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);

if (isset($mydata["id"]) && isset($mydata["level"])) {
    if ($mydata["id"] != "" && $mydata["level"] != "") {
        $p_id = $mydata["id"];
        $p_level = $mydata["level"];

        // 呼叫連線
        require_once("dbtools.php");
        $link = create_connection();

        // 給sql指令: 將網頁會員等級選單的狀態$p_level傳送給後端(透過此api傳遞給資料庫->從網頁的$p_level可直接變更資料庫的Level欄位)
        $sql = "UPDATE member SET Level = '$p_level' WHERE ID = '$p_id'";
        
        // 執行上方sql指令
        if(execute_sql($link, "if0_37421127_testdb", $sql)){
            echo '{"state": true, "message" : "會員等級更新成功"}';
        }else{
            echo '{"state": true, "message" : "會員等級更新失敗和錯誤代碼等"}';
        }
        // 記得關閉資料庫
        mysqli_close($link);
    }else{
        echo '{"state": false, "message" : "欄位不得為空白"}';
    }

} else {
    echo '{"state": false, "message" : "欄位命名錯誤"}';
}

// <?php
// // {"id":"xxx", "level": "100"}

// // {"state" : true,"message" : "更新成功"}
// // {"state" : false, "message" : "會員更新失敗和錯誤代碼等'"}
// // {"state" : false, "message" : "欄位不得為空白"}
// // {"state" : false, "message" : "欄位命名錯誤"}
// $data = file_get_contents("php://input", "r");
// $mydata = array();
// $mydata = json_decode($data, true);

// if (isset($mydata["id"]) && isset($mydata["level"])) {
//     if ($mydata["id"] != "" && $mydata["level"] != "") {
//         $p_id = $mydata["id"];
//         $p_level = $mydata["level"];

//         // 呼叫連線
//         require_once("dbtools.php");
//         $link = create_connection();

//         // 使用參數化查詢以防止 SQL 注入
//         $stmt = mysqli_prepare($link, "UPDATE member SET Level = ? WHERE ID = ?");
//         mysqli_stmt_bind_param($stmt, 'si', $p_level, $p_id);

//         // 執行 SQL 指令
//         if (mysqli_stmt_execute($stmt)) {
//             echo '{"state": true, "message" : "會員等級更新成功"}';
//         } else {
//             echo '{"state": false, "message" : "會員等級更新失敗: ' . mysqli_error($link) . '"}';
//         }

//         // 關閉資料庫
//         mysqli_stmt_close($stmt);
//         mysqli_close($link);
//     } else {
//         echo '{"state": false, "message" : "欄位不得為空白"}';
//     }
// } else {
//     echo '{"state": false, "message" : "欄位命名錯誤"}';
// }
