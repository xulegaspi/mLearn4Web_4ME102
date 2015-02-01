<?php

require_once __DIR__ . '/google-api-php-client-master/autoload.php';

// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
    // Call set_include_path() as needed to point to your client library.

    /*
     * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
     * Google Developers Console <https://console.developers.google.com/>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
    $DEVELOPER_KEY = 'AIzaSyCxu7xgDur3ukx7XoTAo17urCbzCVKRNls';

    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);

    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);

    // Geolocation
    $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    $url = "http://freegeoip.net/json/$ip";
    $ch  = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);

    if ($data) {
        $location = json_decode($data);

        $city = $location->city;
        $region = $location->region_name;
        $lat = $location->latitude;
        $lon = $location->longitude;
    }

    try {
        // Call the search.list method to retrieve results matching the specified
        // query term.
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
        #$searchResponse = $youtube->videos->listVideos('id,snippet', array(
            #'q' => $_GET['q'],
            #'maxResults' => $_GET['maxResults'],
            #'chart' => 'mostPopular',
            'type' => 'video',
            #'q' => 'Vaxjo',
            #'regionCode' => 'SE',
            'maxResults' => '30',
            'location' => $lat . ', ' . $lon,
            'locationRadius' => '5km'
        ));

        $videos = '';
        $channels = '';
        $playlists = '';

        // Add each result to the appropriate list, and then display the lists of
        // matching videos, channels, and playlists.
        foreach ($searchResponse['items'] as $searchResult) {
            switch ($searchResult['id']['kind']) {
                case 'youtube#video':
                    $videos .= sprintf('<li>%s %s (%s) %s</li>',
                        '<a target="_blank" href="https://www.youtube.com/watch?v=' . $searchResult['id']['videoId'] . '">',
                        $searchResult['snippet']['title'], $searchResult['id']['videoId'], '</a>');
                    break;
                case 'youtube#channel':
                    $channels .= sprintf('<li>%s (%s)</li>',
                        $searchResult['snippet']['title'], $searchResult['id']['channelId']);
                    break;
                case 'youtube#playlist':
                    $playlists .= sprintf('<li>%s (%s)</li>',
                        $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
                    break;
            }
        }

        $htmlBody .= <<<END
			
            <h3>Videos bases on your current location: </h3>
            
            <ul>$videos</ul>

END;
    } catch (Google_ServiceException $e) {
        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    }
#}
#<h3>Channels</h3>
#<ul>$channels</ul>
#<h3>Playlists</h3>
#<ul>$playlists</ul>

?>

<!doctype html>
<html>
<head>
<style>ul{list-style:none;} li{width:auto;height:auto;margin:10px auto;background-color:#47ae47;padding:15px;border:solid 5px #fff ;box-shadow:2px 0px 25px #000;border-radius:40px;}</style>
    <title>YouTube Search</title>
</head>
<body>
<?=$htmlBody?>
</body>
</html>