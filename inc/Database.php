<?php

/**
 * Database is use to handler all database functions
 *
 * @package PHPBlog
 * @author miguel
 */
class Database {

    /**
     * Start connection with database
     * 
     * @return array $conn
     */
    function connect() {
        return $conn = new ConnectionPool(Keyspace);
    }

    /**
     * Insert data into database
     * 
     * @param string $column
     * @param array $data
     * @param string $id 
     */
    function adddata($column, $data, $id) {

        $this->id = $id;
        $this->data = $data;
        $this->column = $column;
        $add = new ColumnFamily($this->connect(), $this->column);
        $add->insert($this->id, $this->data);
    }

    /**
     * Get data from database
     * 
     * @param string $column
     * @param string $id
     * @return array    post data
     */
    function getdata($column, $id) {
        $this->id = $id;

        $this->column = $column;
        $add = new ColumnFamily($this->connect(), $this->column);
        return $add->get($this->id);
    }

    /**
     * Get all data of a column
     * 
     * @param string $column
     * @return array  $allposts
     */
    function getall($column) {
        $this->column = $column;
        $id = new ColumnFamily($this->connect(), 'posturl');
        $add = new ColumnFamily($this->connect(), $this->column);
        $rows = $id->get_range();
        $get = array();
        /**
         * create array using the database key and columns
         */
        foreach ($rows as $key => $columns) {
            $postkey = array_keys($columns);
            $allpost = $add->get($columns[$postkey[0]]);
            $get[$columns[$postkey[0]]] = $allpost;
        }

        $this->allposts = $get;
        // print_r($this->allposts);
        return $this->allposts;
    }

    function delete($column, $id) {
        $this->id = $id;
        $this->column = $column;
        $add = new ColumnFamily($this->connect(), $this->column);
        $add->remove($this->id);
    }

}

?>
