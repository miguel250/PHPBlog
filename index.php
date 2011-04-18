<?php

require_once 'config.php';
$handler = new Handler();
$post = new Post();
 $dashboard = new  Dashboard($handler->seturl());
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
/**
 * check if user is at the home page
 */
if ($handler->home()) {
    $templatevalues ['post'] = $post->getallpost();
    $templatevalues ['home'] = $handler->home();
    /**
     * check if not home or looking at a post the user is at the dashboard
     */
} elseif ($handler->dashboard()) {
   
    $template = $twig->loadTemplate('dashboard.twig');
    echo $template->render($dashboard->dashtemplate());
    /**
     * check if  not home or dashboard user is at a post
     */
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