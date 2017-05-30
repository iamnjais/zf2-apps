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

        $sql = 'SELECT p.post_title,p.summary,p.id as pid,group_concat(c.category_name separator ", ") as category_name FROM posts p inner join category_post cp on p.id = cp.post_id inner join categories c on c.id = cp.category_id group by p.id';

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

        $sql = 'SELECT p.id, p.post_title, p.summary,group_concat(cp.category_id separator ", ") as category_id FROM posts p inner join category_post cp on p.id = cp.post_id where id = ' . $postId;

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
            'summary' => $data['summary'],
        );
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $postId = $results->getGeneratedValue();
        $this->createRelationship($postId,$data['category']);
        return $results;
    }
    
    /**
     * 
     * @param type $postId
     * @param type $categories
     */
    public function createRelationship($postId, $categories){
        $dbAdapter = $this->getDBAdapter();
        $sql = new Sql($dbAdapter);

        $insert = $sql->insert('category_post');
       
        foreach ($categories as $category_id){
            $newData = array(
                'category_id' => $category_id,
                'post_id' => $postId,
            );
            $insert->values($newData);
            $selectString = $sql->getSqlStringForSqlObject($insert);
            $dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        }
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
        
        $dbAdapter = $this->getDBAdapter();
        $sql = new Sql($dbAdapter);

        $updateData = array();
        $updateData['post_title'] = $data['postTitle'];
        $updateData['summary'] = $data['summary'];
        $update = $sql->update('posts')->set($updateData)->where(array('id' => $postId));
        
        $selectString = $sql->getSqlStringForSqlObject($update);
        $results = $dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $this->deleteCategoryPost($postId);
        $this->createRelationship($postId,$data['category']);
        return $results;
    }
    /**
     * 
     * @param type $postId
     */
    public function deleteCategoryPost($postId){
        $dbAdapter = $this->getDBAdapter();
        $sql = new Sql($dbAdapter);
        $delete = $sql->delete('category_post')->where(array('post_id' => $postId));
        $selectString = $sql->getSqlStringForSqlObject($delete);
        $results = $dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        //$sql = 'delete FROM category_post where post_id = ' . $postId;

        //$result = $dbAdapter->query($sql)->execute();
    }

}
