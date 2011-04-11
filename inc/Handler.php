<?php

/**
 * Controllers all blog request
 *
 * @package PHPBlog
 * @author miguel
 */
class Handler {

    private $url;

    /*     * *
     * Constructor  if the $url variable is / then display home page else get post
     * 
     * @param String    $url  
     */

    function __construct() {
        $url = $_SERVER['REQUEST_URI'];
        $this->url = $url;
        
    }

    /*     * *
     * Set post url 
     * @return String $url
     */

    function setUrl() {
        return $this->url;
    }

}

?>
