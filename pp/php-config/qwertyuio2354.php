<?php 
session_start();
$miClave="";
$connexion=false;
$flagdbOpen=0;

define("sql_HOST","db536097457.db.1and1.com");
define("sql_USUARIO","dbo536097457");
define("sql_PASS","superman1");
define("sql_DB","db536097457");

$tablas=array("User", "File");
$commandList=array("user","file","invitation");
$actionList =array(
    "user" => array("signup","login","changepass","logout"),
    "file" => array("save","get","share","sendto","view","set"),
    "invitation" => array("get","set","ok","ko"),
    
);

function cbx_open(){
    global $flagdbOpen;
    if($flagdbOpen==0){
        global $connexion;
        $connexion=mysql_connect (sql_HOST, sql_USUARIO, sql_PASS) or die ("<center>No se puede conectar con la base de datos\n</center>\n".print_r(error_get_last()));
        @mysql_select_db(sql_DB,$connexion) or die( "Imposible seleccionar base de datos");
        $flagdbOpen=1;
    } 
}
 
function cbx($xx_msg){
    global $connexion;
    return mysql_query($xx_msg,$connexion);    
}

function cbx_close(){
    global $connexion;
    global $flagdbOpen;
    if($flagdbOpen>0) mysql_close($connexion);
    $flagdbOpen=0;
}

function RandomString($valor)
{
    $characters = '0123456789abc_-.defghijklmn_opqrs_-.tuvwxyzABCD_-.EFGHIJKLMNOP_-.QRSTUVWXYZ';
    $randstring = '';
    $valor=max($valor,10);
    for ($i = 0; $i < $valor; $i++) {
        $randstring.= $characters[rand(0, strlen($characters)-1)];
    }
    return $randstring;
}

function file_save($valor){
    try
    {
        
        $image_data = file_get_contents($valor[0]);
        file_put_contents("img/photo.jpg",$image_data);
        $base64 = base64_encode($image_data);
        //get json scenario
        $json = file_get_contents("http://celtest1.lnu.se:3030/mlearn4web/getscenariodata/".$valor[1]);
        $data = json_decode($json, true);
        $handle = fopen("somefile.txt", "a");
        fwrite($handle,json_encode($data,JSON_UNESCAPED_UNICODE)."\n");
        fclose($handle);
        
        //prepare new json
        foreach($data["data"] as $screenData){
               foreach($screenData as $sElement){
                 if($sElement["type"]=="image" && $sElement["elementId"]==$valor[2]){
                    if($valor[3]=="replace"){
                        $sElement["value"]=$base64;
                    }
                    else{
                        $auxElement=$sElement;
                        $auxElement["elementId"].="-";//.($valor[4])
                        $sElement["value"]=$base64;
                        $screenData[]=$auxElement;
                    }
                    break;
                 }
               }
        }
    
        //send new json
        //$url="http://celtest1.lnu.se:3030/mlearn4web/updatedata/".$valor[1];
        $url="http://celtest1.lnu.se:3030/mlearn4web/newdata/".$valor[1];
        /**
         * method1
         **/
         /*
        
        $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        */
        /**
         * method 2
         **/
        $data_string = json_encode($data);
        $handle = fopen("somefile1.txt", "a");
        fwrite($handle,json_encode($data,JSON_UNESCAPED_UNICODE)."\n");
        fclose($handle);                                                                                   
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
        $result = curl_exec($ch);

        return "ok- ".$result;

    }
    catch(exception $e)
    {
        return "error- ". $e->getMessage();
    }
}

function user_signUp($valor){
    //id,user_name,email, phone, pass, photo, location, profession, state, key
    $answer="<error>error</error>";
    $msg="INSERT INTO User VALUES (NULL, '$valor[0]','$valor[1]','$valor[2]','$valor[3]','default.jpg','City - State','unknown',0,0)";
    $handle = fopen("somefile.txt", "a");

	fwrite($handle,"$msg\r\n");
    fclose($handle);
    cbx_open();
    if(cbx($msg)){
        $answer="ok";
    }
    cbx_close();
    return $answer;
}

function redirect($lugar) {
        die("<script>location.href='$lugar'</script>\n");
        exit();
    }

?>