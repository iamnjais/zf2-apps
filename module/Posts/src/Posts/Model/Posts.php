<?php

namespace Posts\Model;

use Demoapplication\Mvc\Model\DemoapplicationAbstractModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categories
 *
 * @author naveen.jaiswal
 */
class Posts extends DemoapplicationAbstractModel {

    /**
     * 
     * @return type
     */
    public function getAllPosts() {
        $data = null;
        $dbAdapter = $this->getDBAdapter();

        $sql = 'SELECT p.post_title,p.summary,p.id,p.category_id,c.category_name FROM posts p inner join categories c on c.id = p.category_id';

        $result = $dbAdapter->query($sql)->execute();
        if ($result->count() > 0) {
            $results = new ResultSet();
            $data = $results->initialize($result)->toArray();
        }

        return $data;
    }

    /**
     * 
     * @return type
     */
    public function getPostById($postId) {
        $data = null;
        $dbAdapter = $this->getDBAdapter();

        $sql = 'SELECT * FROM posts where id = ' . $postId;

        $result = $dbAdapter->query($sql)->execute();
        if ($result->count() > 0) {
            $results = new ResultSet();
            $data = $results->initialize($result)->toArray();
        }

        return $data[0];
    }

    /**
     * 
     * @param type $data
     */
    public function addPost($data) {

        $dbAdapter = $this->getDBAdapter();
        $sql = new Sql($dbAdapter);

        $insert = $sql->insert('posts');

        $newData = array(
            'post_title' => $data['postTitle'],
            'category_id' => $data['category'],
            'summary' => $data['summary'],
        );
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    /**
     * 
     * @param type $postId
     */
    public function delete($postId) {
        
        $dbAdapter = $this->getDBAdapter();

        $sql = 'delete FROM posts where id = ' . $postId;

        $result = $dbAdapter->query($sql)->execute();
    }

    /**
     * 
     * @param array $data
     */
    public function update($data, $postId) {
        
        $sql = new Sql($this->getDBAdapter());

        $updateData = array();
        $updateData['post_title'] = $data['postTitle'];
        $updateData['category_id'] = $data['category'];
        $updateData['summary'] = $data['summary'];
        $update = $sql->update('posts')->set($updateData)->where(array('id' => $postId));
        
        $selectString = $sql->getSqlStringForSqlObject($update);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        
        return $results;
    }

}
