<?php
class Flickr {
    private $apiKey = '627b8993383f19cc641f156d56143df2';
    
    public function __construct() {
    }
    
    public function search($query = null) {
        $search = 'http://flickr.com/services/rest/?method=flickr.photos.search&api_key=' . $this->apiKey . '&text=' . urlencode($query) . '&per_page=50&format=php_serial';
        $result = file_get_contents($search);
        $result = unserialize($result);
        return $result;
    }
}
?>
