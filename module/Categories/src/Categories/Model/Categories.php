<?php

namespace Categories\Model;

use Demoapplication\Mvc\Model\DemoapplicationAbstractModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

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
class Categories extends DemoapplicationAbstractModel {

    /**
     * 
     * @return type
     */
    public function getAllCategories() {
        $data = null;
        $dbAdapter = $this->getDBAdapter();

        $sql = 'SELECT * FROM categories';

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
    public function getCategoryById($categoryId) {
        $data = null;
        $dbAdapter = $this->getDBAdapter();

        $sql = 'SELECT * FROM categories where id = ' . $categoryId;

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
    public function addCategory($data) {

        $dbAdapter = $this->getDBAdapter();
        $sql = new Sql($dbAdapter);

        $insert = $sql->insert('categories');

        $newData = array(
            'category_name' => $data['categoryName'],
            'description' => $data['description'],
        );
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        return $results;
    }

    /**
     * 
     * @param type $categoryId
     */
    public function delete($categoryId) {
        
        $dbAdapter = $this->getDBAdapter();

        $sql = 'delete FROM categories where id = ' . $categoryId;

        $result = $dbAdapter->query($sql)->execute();
    }

    /**
     * 
     * @param array $data
     */
    public function update($data, $categoryId) {
        
        $sql = new Sql($this->getDBAdapter());

        $updateData = array();
        $updateData['category_name'] = $data['categoryName'];
        $updateData['description'] = $data['description'];
        $update = $sql->update('categories')->set($updateData)->where(array('id' => $categoryId));
        
        $selectString = $sql->getSqlStringForSqlObject($update);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        
        return $results;
    }

}
