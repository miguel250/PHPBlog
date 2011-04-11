<?php

require_once 'config.php';

/**
 * edit is use to edit or add post 
 *
 * @package PHPBlog
 * @author miguel
 */
class edit {

    function __construct() {
        $url = new Handler();
        $this->post = new Post($url->setUrl());
        /**
         * Show submit form if get is empty
         */
        if (empty($_GET)) {

            $this->submitform();
            /**
             * Look for url value. If value is equal to add the post will be added to the database
             */
        } elseif (isset($_GET['submit'])) {

            if ($_GET['submit'] == 'add') {
                $this->addpost();
            }
            /**
             * Look for url value. If value is equal to edit the post will get post infomation 
             */
        } elseif (isset($_GET['edit'])) {

            $postid = $this->post->getid($_GET['edit']);
            $posts = $this->post->getpost($postid);
            /**
             * @todo move html out of here
             */
            echo '<html>
<body>

<form action="posts.php?submit=add" method="post">
<h1>Edit Post</h2>
Title:<br \>
<input type="text" name="title" value="' . $posts['title'] . '"/><br \>
Body:<br \>
<textarea name="body" cols="50" rows="4" id="detail">' . $posts['body'] . '</textarea><br \>
Tags:<br \>
<input type="text" name="tags"value="' . $posts['tags'] . '" /><br \>
<input type="submit" />
</form>

</body>
</html>';
        }
    }

    /**
     * Function to add post to database using post values
     */
    function addpost() {

        $title = $_POST['title'];
        $body = $_POST['body'];
        $tags = $_POST['tags'];
        $add = $this->post->addpost($title, $body, $tags);
        header('Location:' . $add);
    }

    /**
     * create submit form
     * @todo move html out of here
     */
    function submitform() {
        echo '<html>
<body>

<form action="posts.php?submit=add" method="post">
<h1>Add Post</h2>
Title:<br \>
<input type="text" name="title" /><br \>
Body:<br \>
<textarea name="body" cols="50" rows="4" id="detail"></textarea><br \>
Tags:<br \>
<input type="text" name="tags" /><br \>
<input type="submit" />
</form>

</body>
</html>';
    }

}

$edit = new edit();
?>
