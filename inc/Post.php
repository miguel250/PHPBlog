<?php

/**
 * Post is using to create, delete or update the blog posts
 * 
 * @package PHPBlog
 * @author miguel
 */
class Post {

    private $id;
    private $title;
    private $body;
    private $postdate;
    private $url;
    private $tags;
    public $database;

    /**
     * Constructor
     * 
     * @param array   $database  
     */
    function __construct() {


        $database = new Database();
        $this->database = $database;
    }

    function editpost($title, $body, $tags, $id,$url) {
       
        $this->title = $title;
        $this->body = $body;
        $this->tags = $tags;
        $this->id = $id;
        $this->postdate = $this->getdate();
        $this->url = '/' . $this->getdate() . '/' . str_replace(" ", "-"
                , $this->title) . '/';
         $basicurl = array();
        $basicurl[CassandraUtil::uuid1()] = $this->id;
        $record['title'] = $this->title;
        $record['body'] = $this->body;
        $record['tags'] = $this->tags;
        $record['postdate'] = $this->postdate;
        $record['url'] = $this->url;
        $record['id'] = $this->id;
        
        $this->database->adddata('posturl', $basicurl, $this->url);
        $this->database->adddata('post', $record, $id);
        return $this->url;
    }

    /**
     * Add or update post to the database
     * 
     * @param string $title
     * @param string $body
     * @param string $tags
     * @param string $authorid 
     */
     function addpost($title, $body, $tags) {
        $this->title = $title;
        $this->body = $body;
        $this->tags = $tags;
        $this->postdate = $this->getdate();
        $this->url = '/' . $this->getdate() . '/' . str_replace(" ", "-", $this->title) . '/';
        $basicurl = array();
        $basicurl[CassandraUtil::uuid1()] = $this->genuuid();
        /**
         * try the id variable if it fails it means that it not in the database
         * so the error will be catch and the id variable will be added
         */
        try {
            $this->id = $this->getid($this->url);
           
           
        } catch (Exception $exc) {
            $this->database->adddata('posturl', $basicurl, $this->url);
            $this->id = $this->getid($this->url);
            
        }

        $record = array();
        $record['title'] = $this->title;
        $record['body'] = $this->body;
        $record['tags'] = $this->tags;
       $record['postdate'] = $this->postdate;
        $record['url'] = $this->url;
        $record['id'] = $this->id;
       $this->database->adddata('post', $record, $this->id);
       return $this->url;
    }

    /**
     * return all posts in the database
     * 
     * @return array $this->posts
     */
    function getallpost() {

        $this->allposts = $this->database->getall('post');
        
        return $this->allposts;
    }

    /**
     * get post infomation using the post id
     * 
     * @param string $id
     * @return array   $this->post
     */
    function getpost($id) {
        $this->id = $id;
        $this->post = $this->database->getdata('post', $this->id);
        return $this->post;
    }

    /**
     * Get date
     * 
     * @return timestamp  $postdate 
     */
    private function getdate() {
        $this->postdate = date("m/d/Y");
        return $this->postdate;
    }

    /**
     * Get post id from database using post url
     * @param string $url
     * @return string $get['id'];
     */
     function getid($url) {
        $this->url = $url;
        $postid = $this->database->getdata('posturl', $this->url);
        $postkey = array_keys($postid);
        return $postid[$postkey[0]];
    }


    /**
     * create uuid using timestamp
     * @return interger $uuid
     */
    function genuuid() {
        $uuid = uniqid(time(), true);
        $uuid = str_replace(".", "", $uuid);
        $this->uuid = $uuid;
        return $this->uuid;
    }

    /**
     * Detele post from database
     * @param string $id 
     */
    function deletepost($id) {
        $this->id = $id;
        $this->database->delete('post', $this->id);
    }

    function deleteurl($url) {
        $this->url = $url;
        $this->database->delete('posturl', $this->url);
    }

}

?>
