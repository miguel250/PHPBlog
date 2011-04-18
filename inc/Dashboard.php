<?php

/**
 * Dashboard is the backend 
 *
 * @package PHPBlog
 * @author Miguel
 */
class Dashboard {

    private $url;
    private $post;
    public $templatevalues;

    function __construct($url) {
        $this->url = $url;
        $post = new Post();
        $this->post = $post;
        $this->editposturl = str_replace('/dashboard/post/edit/', '/', $this->url);
        if ($this->url == '/dashboard/') {
            $this->dashboardindex();
        } elseif ($this->url == '/dashboard/post/') {
            $this->posts();
        } elseif ($this->url == '/dashboard/post/add/') {
            $this->templatevalues['addpost'] = TRUE;
        } elseif ($this->url == '/dashboard/post/edit' . $this->editposturl . '') {
            if ($this->editposturl == '/') {
                $this->templatevalues['notfound'] = TRUE;
            } else {
                /**
                 * get post url to edit and return post data
                 */
                $postid = $post->getid($this->editposturl);
                $post = $post->getpost($postid);

                $this->templatevalues['post'] = $post;
                $this->templatevalues['editpost'] = TRUE;
            }
        } elseif ($this->url == '/dashboard/addpost/') {
            $this->addpost();
        } elseif ($this->url == '/dashboard/editpost/') {
            $this->editpost();
        } elseif ($this->url == '/dashboard/deletepost/') {
            $this->deletepost();
        } else {

            $this->templatevalues['notfound'] = TRUE;
        }
    }

    /**
     * create post and redirect user to new post
     */
    function addpost() {
        $this->templatevalues['add'] = True;
        $title = $_POST['title'];
        $body = $_POST['body'];
        $tags = $_POST['tags'];
        $add = $this->post->addpost($title, $body, $tags);
        header('Location:' . $add);
    }

    /**
     * delete post using url
     */
    function deletepost() {
        $this->templatevalues['delete'] = TRUE;
    }

    /**
     * edit post using url
     */
    function editpost() {
        $this->templatevalues['edit'] = true;

        $title = $_POST['title'];
        $body = $_POST['body'];
        $tags = $_POST['tags'];
        $url = $_POST['url'];
        $id = $_POST['id'];
        $this->post->deleteurl($url);
        $edit = $this->post->editpost($title, $body, $tags, $id, $url);
        header('Location:' . '/dashboard/post/edit' . $edit);
    }

    /**
     * uses for post index
     */
    function posts() {
        $this->templatevalues['postindex'] = TRUE;
    }

    /**
     * uses for dashboard index
     */
    function dashboardindex() {
        $this->templatevalues['dashboardindex'] = true;
    }

    /**
     * use to send data to twig
     */
    function dashtemplate() {
        return $this->templatevalues;
    }

}

?>
