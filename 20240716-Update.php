<?php

//將data轉回陣列，並decode
$data = file_get_contents("php://input", "r");
// 將$mydata設為陣列
$mydata = array();
// 將json解碼為陣列，將資料設給$mydata
$mydata = json_decode($data, true);

// Isset判斷存不存在，再!=""判斷為不為空白。存在且不為空白，可拿來用。
if(isset($mydata["ID"]) && isset($mydata["name"]) && isset($mydata["spec"]) && isset($mydata["price"]) && isset($mydata["num"]) && isset($mydata["remark"])){
    if ($mydata["ID"] != "" &&$mydata["name"] != "" && $mydata["spec"] != "" && $mydata["price"] != "" && $mydata["num"] != "" && $mydata["remark"] != "") {
        
        //上方已確認不為空，下方就可接收。另，因右邊較為複雜，不易放入27行中，故簡化，設左邊變數。(將右邊assign給左邊變數。27行就直接放入左邊變數名稱即可)
        $p_id = $mydata["ID"];
        $p_name = $mydata["name"];
        $p_spec = $mydata["spec"];
        $p_price = $mydata["price"];
        $p_num = $mydata["num"];
        $p_remark = $mydata["remark"];

    $servername = "https://sql100.infinityfree.com";
    $username = "if0_37421127";
    $password = "Ab202405730";
    $dbname = "if0_37421127_testdb";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        // Mysqli_connect¬_error() : Sql指令的 連線錯誤訊息
        die("連線失敗" . mysqli_connect_error());
    }
    // 將11~15設的變數名稱，一一放入下方指令中
    $sql = "UPDATE product SET Name = '$p_name', Spec = '$p_spec', Price = '$p_price', Num = '$p_num', Remark = '$p_remark' WHERE ID = '$p_id'";
    // 上面只有sql指令，沒有用。需要下面的 php才能執行它!
    if(mysqli_query($conn, $sql)){
        echo '{"state" : true , "message" : "更新成功"}';
    }else{
        // Mysqli_error($conn): 連線 sql指令的 錯誤訊息
        echo '{"state" : false, "message" : "更新失敗和錯誤代碼等' . $sql . mysqli_error($conn) . '"}';
    }

    //最後記得關閉連線
    mysqli_close($conn);

    } else {
    echo '{"state" : false, "message" : "欄位不得為空白"}';    
    }

}else{
echo '{"state" : false, "message" : "欄位命名錯誤"}';
}
?>


