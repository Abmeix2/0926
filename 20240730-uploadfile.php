<?php
    // echo $_FILES['file']['name']."<br>";
    // echo $_FILES['file']['type']."<br>";
    // echo $_FILES['file']['size']."<br>";
    // echo $_FILES['file']['tmp_name']."<br>";

    if($_FILES['file']['type'] == 'image/jpeg' || $_FILES['file']['type'] == 'image/png'){
        // 產生檔案名稱
        $filename = date("YmdHis"). "_" . $_FILES['file']['name'];
        $location = "upload/" . $filename;
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
            // 上傳成功
            $datainfo = array();
            $datainfo["原始檔案名稱"] = $_FILES['file']['name'];
            $datainfo["儲存檔案名稱"] = $filename;
            $datainfo["檔案格式"]     = $_FILES['file']['type'];
            $datainfo["檔案大小"]     = $_FILES['file']['size'];

            echo'{"state" : true, "datainfo" : '. json_encode($datainfo) .', "message": "上傳成功"}';
        }else{
            // 上傳失敗
            echo '{"state" : false, "message" : "上傳失敗"}';
        }
    }else{
        echo '{"state" : false, "message" : "檔案格式不符合規定!"}';

    }
    
    
?>