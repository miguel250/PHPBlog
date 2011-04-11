<?php

require_once 'config.php';
/**
 * Create handler object
 */
$handler = new Handler();



$post = new Post($handler->setUrl());



if ($handler->setUrl() == '/') {

    $posts = $post->getallpost();
    $count = count($posts);

    for ($i = 0, $size = sizeof($posts); $i < $size; ++$i) {
        /**
         * @todo move html out of here
         */
        echo '<a href="' . $posts[$i]['url'] . '"><h1>' . $posts[$i]['title'] . '</h1></a>';
        echo "<p>" . $posts[$i]['body'] . '</p>';
        echo "<p>" . $posts[$i]['tags'] . '</p>';
        echo "<p>" . $posts[$i]['postdate'] . '</p>';
    }
} else {
    /**
     * use try to see if post is in database if not show 404 page
     */
    try {

        $postid = $post->getid($handler->setUrl());
        $posts = $post->getpost($postid);
        /**
         * @todo move html out of here
         */
        echo '<h1>' . $posts['title'] . '</h1>';
        echo "<p>" . $posts['body'] . '</p>';
        echo "<p>" . $posts['tags'] . '</p>';
        echo "<p>" . $posts['postdate'] . '</p>';
        echo '<a href="http://'.$_SERVER['HTTP_HOST'].'/posts.php?edit=' . $posts['url'] . '">Edit</a>';
        
    } catch (Exception $exc) {
        echo 'not found';
        header("HTTP/1.0 404 Not Found");
    }
}
?>
