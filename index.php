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
$templatevalues['home'] = '/';
$templatevalues ['url'] = $handler->setUrl();
if ($handler->setUrl() == '/') {
    $templatevalues ['post'] = $post->getallpost();
    
} else {
    try {
        $postid = $post->getid($templatevalues ['url']);
        $templatevalues ['post'] = $post->getpost($postid);
    } catch (Exception $exc) {
        $template = $twig->loadTemplate('404.twig');
        header("HTTP/1.0 404 Not Found");
    }
}


/**
 *  render template
 */
echo $template->render($templatevalues);
?>