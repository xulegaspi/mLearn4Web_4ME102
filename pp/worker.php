<?
include_once("php-config/qwertyuio2354.php");
// we'll generate XML output
header('Content-Type: text/xml');
// generate XML header
$atxt="<?";
$btxt="?>";

$xml = new SimpleXMLElement($atxt."xml version=\"1.0\" encoding=\"utf-8\" ".$btxt."<xml/>");
// create the <response> element
$response=$xml->addChild("response");
//get data
$name = isset($_POST['name'])?$_POST['name']:$_GET['name'];
//verify
$handle = fopen("somefile.txt", "a");
foreach ($_POST as $key => $value)
{
	fwrite($handle,"<$key>{$_POST[$key]}</$key>\n");
//echo"<$key>{$_POST[$key]}</$key>";
}
fclose($handle);

// generate output 
$vars=explode("..", $name);
$command=$vars[0];
$action=$vars[1];
unset ($vars[0]);
unset ($vars[1]);
$vars = array_values($vars);

//test command recived by server
$query=$response->addChild("query") ;
if (!in_array($command, $commandList)) {
    
    $query->addChild("comand","unknown");
    print $xml->asXML();
    die();
    }
$query->addChild("comand","$command");
if (!in_array($action, $actionList[$command])) {
    $query->addChild("action","unknown");
    //$xml = new SimpleXMLElement($txt);
    echo $xml->asXML();
    die();
    }
$query->addChild("action","$action");
foreach($vars as $var)
    $query->addChild("var","$var");


switch ($command."_".$action){
    case "user_login":
         $txt.= user_login(array_filter($vars));
        break;
    case "user_signup":
         $txt.= user_signUp(array_filter($vars));
        break;
    case "file_get": 
        $txt.=  perfil_get(array_filter($vars));
        break;
    case "file_save": 
        $response->addChild("answer", file_save(array_filter($vars)));
        break;
    
}



//$xml = new SimpleXMLElement($txt);
    echo $xml->asXML();
?>