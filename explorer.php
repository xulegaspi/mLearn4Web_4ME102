<?

function getSizeFile($url) { 
    if (substr($url,0,4)=='http') { 
        $x = array_change_key_case(get_headers($url, 1),CASE_LOWER); 
        if ( strcasecmp($x[0], 'HTTP/1.1 200 OK') != 0 ) { $x = $x['content-length'][1]; } 
        else { $x = $x['content-length']; } 
    } 
    else { $x = @filesize($url); } 

    return number_format ( $x/1024 , 2 , "," , "." )."Kb"; 
} 

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="UNI" />

	<title>Final Project</title>
    <script type="text/javascript"src="http://feather.aviary.com/js/feather.js"></script>
    <script type="text/javascript"src="ajax1-0.js"></script> 
    <script type="text/javascript">
<!--
    var actualTab=1;
	function changeTab(valor){
	   if(actualTab!=valor){
	       document.getElementById("mtab"+actualTab).classList.toggle("tabselected");
           document.getElementById("tab"+actualTab).classList.toggle("contentselected");
	       actualTab=valor;
           document.getElementById("mtab"+valor).classList.toggle("tabselected");
	       document.getElementById("tab"+valor).classList.toggle("contentselected");
	   }
	}
    var myData="";
    var actualFile="";
    var actuali=-1;
    function fileSelected(valor){
        var name=document.getElementById("file"+valor).firstChild.textContent;
        if(actualFile==name){
            myData=document.getElementById("scenarioId"+valor).value+".."+document.getElementById("elementId"+valor).value;
            //return launchEditor("infofoto",'http://celtest1.lnu.se:3030'+actualFile);
            alert(document.getElementById("infofoto").src);
            return launchEditor("infofoto","http://dspcommunity.com/pp/image.php?i="+actualFile);
            //return launchEditor("infofoto",'http%3A%2F%2Fceltest1.lnu.se%3A3030'+actualFile);
        }else{
            actualFile=name;
            actuali=valor;
            var my_image = new Image();
            my_image.onload = function() {
                document.getElementById("iDimensions").innerText=(this.width + ' x ' + this.height);
                document.getElementById("iName").innerText=this.src.split("/")[this.src.split("/").length-1];
                document.getElementById("iSize").innerText=document.getElementById("fsize"+valor).innerText;
            }
            my_image.src = 'http://celtest1.lnu.se:3030'+actualFile;
            
            document.getElementById("infofoto").src='http://celtest1.lnu.se:3030'+actualFile;
        }
        
    }
    
function afterprocess(valor){
    alert(valor);
}    
-->
</script>

<style type="text/css">
<!--
    a{
        text-decoration: none;
        color:#eee;
        
    }
    .tabbutton{
        background-color: #000;
        color: #000;
        display: inline-block;
        padding: 7px;
    }
    .tabselected{
        background-color: #099 !important;
        color: #fff !important;
    }
    .tabcontent{
        display:none;
        background-color: #099;
        width: calc(90% - 14px);
        height: 500px;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 7px;
    }
	.contentselected{
	   display: block !important;
	   
	}
    #tabMenu ul{
        display: inline-block;
        margin:0px;
        padding: 0px;
    }
    .butInvitations{
        float: right;
        margin-right: 10%;
        display: inline-block;
        width: 80px;
        background-color: bisque;
        padding: 7px;
        
    }
    .search{
        float: right;
        margin-right: 20px;
    }
    .search input[type="text"]{
        padding: 5px;
        width: 200px;
        
        
    }
    .search input[type="button"]{
        padding: 3px;
        
    }
 #nrInvitations{
    display: block;
    float: right;
    border-radius: 50%;
    background-color: red;
    color:white;
    text-align: center;
    margin-right: -17px;
    margin-top: -14px;
    padding: 1px 7px;
    font-size: 14px;
 }
 .infocontent{
    background-color: #099;
        width: 90%;
        height: 100px;
        border-top: solid 2px #eee;
 }
 
 .txtInfo{
	 align-self:auto;
 }
 
 .txtInfo, #infofoto{
    float:left;
 }
 #infofoto{
    width: 90px;
    height:90px;
    border: solid 1px #999;
    
 }
 li{
	 list-style:none;
 }
 
 li.file {
padding: 5px 20px;
color: rgb(255, 248, 220);
padding-bottom: 5px;
list-style: none;
cursor:pointer;
}

span.fname {
width: 50%;
display: inline-block;
}

li.groupname {
color: rgb(0, 255, 255);
background-image: linear-gradient(to bottom right, rgb(59, 107, 101), rgba(0, 0, 0, 0));
list-style: none;
padding: 5px;
}
span[id^="fsize"] {
float: right;
}
-->
</style>
    
</head>

<body>

<!-- Load Feather code --> 

<!-- Instantiate Feather --> 
<script type='text/javascript'> 
function mSave(){
    var retVal = confirm("Do you want to replce the old image?\n Press 'Cancel' to save as new file");
   if( retVal == true ){
        myData+="..replace";
      alert("User wants to replace!");
	  return true;
   }else{
        myData="..new";
      alert("User want to save as!");
	  return false;
   }
}
var featherEditor = new Aviary.Feather(
    {apiKey: '05325ff4ad2f451a', 
    apiVersion: 3, 
    theme: 'dark',
    tools: 'all', 
    appendTo: '', 
    onSave: function(imageID,newURL) {
        myData="file..save.."+newURL+".."+myData;
        mSave();
        process();
        var img = document.getElementById(imageID); 
        img.src = newURL;
        }, 
    //postUrl: 'http://dspcommunity.com/pp/img/file-name.php',
    onError: function(errorObj) { alert(errorObj.message); },
     }); 
function launchEditor(id, src) { featherEditor.launch({ image: id, url: src });
 return false; }
 //[1:32:02] Alexandru Zanfir: Aviary:
//Key: 05325ff4ad2f451a
//Secret: 014756058909e5fd



 </script>
 <!-- <div id='injection_site'></div> <img id='image1'src='http://images.aviary.com/imagesv5/feather_default.jpg'/> 
  <p><input type='image' src='http://images.aviary.com/images/edit-photo.png' value='Edit photo' onclick="return launchEditor('image1','http://images.aviary.com/imagesv5/feather_default.jpg');" /></p> 
-->





<div id="all-content">
    <div id="tabObj">
        <div id="tabMenu">
            <ul>
                <li id="mtab1" class="tabselected tabbutton"><a href="javascript:changeTab(1)">Public Groups</a></li>
                <li id="mtab2" class="tabbutton"><a href="javascript:changeTab(2)">Personal Groups</a></li>
                <li id="mtab3" class="tabbutton"><a href="javascript:changeTab(3)">My Groups</a></li>
            </ul>
            <div class="butInvitations">Invitations<div id="nrInvitations">3</div></div>
            <div class="search"><input type="text" id="toFind"/><input type="button" value="Search" onclick="mSearch()"/></div>
        </div>
        <div id="tab1" class="tabcontent contentselected">
            <ul>
            <?
                //cargar datos
        $req = 'http://celtest1.lnu.se:3030/mlearn4web/getalldata';
        $cMlearn = curl_init($req);
        curl_setopt($cMlearn,CURLOPT_RETURNTRANSFER, TRUE);
        $gMlearn = curl_exec($cMlearn);
        $getMlearn = json_decode($gMlearn,true);
        $Gname="";
        $i=0;
        foreach($getMlearn as $data){
            foreach($data["data"] as $screenData){
               foreach($screenData as $sElement){
                 if($sElement["type"]=="image" && strlen($sElement["value"])<150){
                    if($Gname!=$data["groupname"]){
                         echo("<li class=\"groupname\">".$data["groupname"]."</li>");
                        $Gname=$data["groupname"];
                    }
               
                    echo "<li id=\"file$i\" class=\"file\" onclick=\"fileSelected($i)\"><span class=\"fname\">".$sElement["value"]."</span>
                    <span class=\"fdate\">".$data["timestamp"]."</span><span id=\"fsize$i\">".(getSizeFile("http://celtest1.lnu.se:3030".$sElement["value"]))."</span>
                    <input type=\"hidden\" id=\"elementId$i\" value=\"".$sElement["elementId"]."\"><input type=\"hidden\" id=\"scenarioId$i\" value=\"".$data["scenarioId"]."\"></li>";
                    $i++;
                 }
               }
       
             }
        }
            
            ?>
            </ul>
        </div>
        
        <div id="tab2" class="tabcontent">
        
        </div>
        
        <div id="tab3" class="tabcontent">
        
        </div>
        <div id="info" class="infocontent">
            <img id="infofoto" src="" height="90px" />
            <div class="txtInfo">
                <ul>
                    <li><span class="ivalue" id="iName">value</span></li>
                    <li><span class="ititle">Size:</span><span class="ivalue" id="iSize">value</span></li>
                    <li><span class="ititle">Dimensions:</span><span class="ivalue" id="iDimensions">value</span></li>
                    <li><span class="ititle">Created:</span><span class="ivalue" id="iName">value</span></li>
                </ul>
            </div>
            <div class="txtInfo">
                <ul>
                    <li>Image info</li>
                    <li><span class="ititle">Location:</span><span class="ivalue" id="iName">value</span></li>
                    <li><span class="ititle">Temperature:</span><span class="ivalue" id="iName">value</span></li>
                    <li><span class="ititle">Humidity:</span><span class="ivalue" id="iName">value</span></li>
                </ul>
            </div>
            <div class="txtInfo">
                <ul>
                    <li>Image Tags</li>
                    <li><textarea class="ivalue" id="iTags">value</textarea></li>
                    
                </ul>
            </div>
            <div class="txtInfo"><ul><li>Access</li></ul><div id="permissions">
        <table>
            <tr>
                <td>Owner</td>
                <td>Group</td>
                <td>Annyone</td>
            </tr>
            <tr>
                <td><span>View</span></td>
                <td>Group</td>
                <td>Annyone</td>
            </tr>
        </table>
    </div></div>
        </div>
    </div>
    
    
  <!--  <div id="permissions">
        <table>
            <tr>
                <td>Owner</td>
                <td>Group</td>
                <td>Annyone</td>
            </tr>
            <tr>
                <td><span>View</span></td>
                <td>Group</td>
                <td>Annyone</td>
            </tr>
        </table>
    </div>
    -->
    
</div>


</body>
</html>