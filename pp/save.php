<?php
    $str_data = json_encode($postData);
    $serviceHost = "http://celtest1.lnu.se:3030";
    $baseUrlAPI = $serviceHost . "/mlearn4web";
    $datasetPost = $baseUrlAPI . "/getdata";
    //TODO get Id data from picture;
    //picture AND name;
    $idData="5447cb65f70096dc6064567a";
    $idElement="ci3";
    $url = $datasetPost."/".$idData;
    //$headers= array('Accept: application/json','Content-Type: application/json');
    
    //TODO get data structure
    
    $image = "R0lGODlhDwAPAKECAAAAzMzM/////wAAACwAAAAADwAPAAACIISPeQHsrZ5ModrLlN48CXF8m2iQ3YmmKqVlRtW4MLwWACH+H09wdGltaXplZCBieSBVbGVhZCBTbWFydFNhdmVyIQAAOw==";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    echo($result."<br><br>");
    $result="{".substr($result,strpos($result,"\"data\":"));
    echo($result."<br><br>");
    $data = json_decode($result,true);
    foreach($data["data"] as $key1=>$value1){
        foreach($value1 as $key=>$value){
            echo "<br>findER<br><br>";
            var_dump($value);
                 if((string)$value->elementId==$idElement){
                    echo("<br>find: ".$sElement["value"]."<br><br>");
                    $sElement["value"]=$image;
                    echo"<br><br>$image<br><br>";
                    break;
                    }
        }
    }
    $getMlearn=json_encode($getMlearn);
    var_dump($getMlearn);
    exit();
    // The data to send to the API
    $postData = array(
        "data" =>
            array(
                "screen1" =>
                    array(
                        array(
                            "elementId" => "tf1",
                            "type" => "text",
                            "value" => "This is a test"
                        ),array(
                            "elementId" => "ci2",
                            "type" => "image",
                            "value" => $image
                        )
                    )
            )
    );

    $str_data = json_encode($postData);
    $serviceHost = "http://celtest1.lnu.se:3030";
    $baseUrlAPI = $serviceHost . "/mlearn4web";
    $datasetPost = $baseUrlAPI . "/updatedata";
    $url = $datasetPost . '/5449b1bef70096dc60645689';
    $headers= array('Accept: application/json','Content-Type: application/json');
    
    var_dump($url);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
?>