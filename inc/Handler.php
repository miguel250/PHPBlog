<?php

/**
 * Controllers all blog request
 *
 * @package PHPBlog
 * @author miguel
 */
class Handler {

    private $url;
    public   $notfound;

    /*     * *
     * Constructor  if the $url variable is / then display home page else get post
     * 
     * @param String    $url  
     */

    function __construct() {
        $url = $_SERVER['REQUEST_URI'];
        $this->url = $url;
          $notfound = FALSE;
          $this->notfound = $notfound;
    }

    /**
     * check in user is in the home page
     * @return bool 
     */
    function home() {
        if ($this->url == '/') {
            return $this->home = TRUE;
        } else {
            $this->home = FALSE;
        }
    }
 function notfound(){ 
     header("HTTP/1.0 404 Not Found");;
      $this->notfound = True;
 }
   /**
    *Set url called
    * @return string url
    */

    function setUrl() {
        return $this->url;
    }

}

?>
