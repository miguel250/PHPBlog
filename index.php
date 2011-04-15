<?php

require_once 'config.php';
$handler = new Handler();
$post = new Post();
/**
 * register twig
 */
Twig_Autoloader::register();
/**
 * Create handler object
 */
$loader = new Twig_Loader_Filesystem('templates/default');

// initialize Twig environment
$twig = new Twig_Environment($loader);

// load template
$template = $twig->loadTemplate('default.twig');
/**
 * templatevalues is use to load data to render using twig
 */
$templatevalues = array();
$templatevalues ['home'] = $handler->home();
if ($templatevalues ['home'] ) {
    $templatevalues ['post'] = $post->getallpost();  
 
} else {
    try {
        $postid = $post->getid($handler->setUrl());
        $templatevalues ['post'] = $post->getpost($postid);
    } catch (Exception $exc) {
        /**
         * if post not found show 404 error
         */
         $handler->notfound();
        $templatevalues ['notfound'] = $handler->notfound;  
    }
}


/**
 *  render template
 */
echo $template->render($templatevalues);
?>