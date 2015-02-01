<?php
        session_start();
        include('config.php');
        include('hybridauth/Hybrid/Auth.php');
        if(isset($_GET['provider']))
        {
        	$provider = $_GET['provider'];
        	
        	try{
        	
        	$hybridauth = new Hybrid_Auth( $config );
        	
        	$authProvider = $hybridauth->authenticate($provider);

	        $user_profile = $authProvider->getUserProfile();
	        
                if($user_profile && isset($user_profile->identifier))
                {
					 if($provider == 'Twitter'){
						header('Location: http://www.dspcommunity.com/pp/explorer.php?provide=twitter'); 
						exit;
                    
                        echo"<div class='todo'><iframe src='http://www.dspcommunity.com/tip/twitter/tweets_json.php?q=Vaxjo&count=120' style='width:700px; height:400px; '></iframe></div>";
                    }
			/*		echo " <style>
    body{background:url(fondo.jpg) top center no-repeat;background-attachment:fixed;background-color:rgba(215, 129, 255, 1);}
    .todo{width:700px;height:auto;margin:60px auto;background-color:rgb(255, 255,255 );opacity:.85;padding:30px;border:solid 1px #fff ;box-shadow:2px 0px 25px #000;border-radius:40px;} h1 {color: white;text-align:center;}h3 {color: black;text-align:center;}
    ul{list-style:none;} li{width:auto;height:auto;margin:10px auto;background-color:#47ae47;padding:15px;border:solid 5px #fff ;box-shadow:2px 0px 25px #000;border-radius:40px;} input[type='button']{ width:150px; height:auto; border-radius:20px; box-shadow:10px; cursor: pointer; float:right; background-color:#47ae47;padding:5px;border:solid 3px #eee ;} 
    </style>";
					echo"<div class='todo'>";
					echo"<ul>";
                    echo "<li>Name: ".$user_profile->displayName."</li>";
                    echo "<li>Profile URL:".$user_profile->profileURL."</li>";
					echo "<li>Email :".$user_profile->email."</li>";
                 //   echo "<li>Image:".$user_profile->photoURL."</li><br> ";
                    echo "<li><img src='".$user_profile->photoURL."'/></li>";
                //    echo "<li>Email:".$user_profile->email."</li><br>";
                    echo " <a href='logout.php'><input type='button' value='Logout'></input></a>";
					echo"</ul>";
					echo"</div>";
                 */  
                }
                if($provider == 'Google'){
					header('Location: http://www.dspcommunity.com/pp/explorer.php?provide=google');
					exit;
                    
					
					echo"<div class='todo'><iframe src='http://www.dspcommunity.com/citroen/pruebas_linneus/youtube.php' style='width:700px; height:400px; '></iframe></div>";
                    
                   
                }
                
            

			}
			catch( Exception $e )
			{ 
			
				 switch( $e->getCode() )
				 {
                        case 0 : echo "Unspecified error."; break;
                        case 1 : echo "Hybridauth configuration error."; break;
                        case 2 : echo "Provider not properly configured."; break;
                        case 3 : echo "Unknown or disabled provider."; break;
                        case 4 : echo "Missing provider application credentials."; break;
                        case 5 : echo "Authentication failed. "
                                         . "The user has canceled the authentication or the provider refused the connection.";
                                 break;
                        case 6 : echo "User profile request failed. Most likely the user is not connected "
                                         . "to the provider and he should to authenticate again.";
                                 $twitter->logout();
                                 break;
                        case 7 : echo "User not connected to the provider.";
                                 $twitter->logout();
                                 break;
                        case 8 : echo "Provider does not support this feature."; break;
                }

                // well, basically your should not display this to the end user, just give him a hint and move on..
                echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();

                echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";

			}
        
        }
?>