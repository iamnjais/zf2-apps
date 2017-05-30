<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Posts\Controller;

use Demoapplication\Mvc\Controller\DemoapplicationAbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends DemoapplicationAbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    /**
     * 
     * @return ViewModel
     */
    public function addpostAction() {
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $postModel = $this->getServiceLocator()->get('postModel');

            try {
                $this->validateCategories($post['category']);
                $products = $postModel->addPost($post);
            } catch (\Exception $ex) {
                return new ViewModel(array('errMsg' => $ex->getMessage()));
            }
            if ($products->count() > 0) {
                $this->redirect()->toRoute('posts');
            }
        }
        $categoryModel = $this->getServiceLocator()->get('categoryModel');

        $categories = $categoryModel->getAllCategories();
        return new ViewModel(array('categoryList' => $categories));
    }

    /**
     * 
     */
    public function postlistAction() {
        $postModel = $this->getServiceLocator()->get('postModel');
        $availablePosts = $postModel->getAllPosts();
        $allPosts = array('data' => array());
        if (count($availablePosts) > 0) {
            foreach ($availablePosts as $key => $post) {
                $postId = $post['pid'];
                $allPosts['data'][$key] = array($post['post_title'], $post['category_name'], $post['summary'],
                    "<a href='/deletepost?id=$postId'>Delete</a>",
                    "<a href='/updatepost/$postId'>Update</a>");
            }
        }

        exit(json_encode($allPosts));
    }

    /**
     * 
     */
    public function deletepostAction() {
        $postId = $_REQUEST['id'];

        $postModel = $this->getServiceLocator()->get('postModel');
        $postModel->delete($postId);
        $this->redirect()->toRoute('posts');
    }

    /**
     * 
     */
    public function updatepostAction() {

        $categoryModel = $this->getServiceLocator()->get('categoryModel');
        $postModel = $this->getServiceLocator()->get('postModel');
        $postId = $this->params()->fromRoute('id', 0);
        $errMsg = '';
        $categories = $categoryModel->getAllCategories();
        $postData = $postModel->getPostById($postId);
        $selectedCategories = explode(',', $postData['category_id']);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $selectedCategories = empty($post['category']) ? array() : $post['category'];
            try {
                $this->validateCategories($post['category']);
                $response = $postModel->update($post, $postId);
                $this->redirect()->toRoute('posts');
            } catch (\Exception $ex) {
                $errMsg = $ex->getMessage();
            }
        }
        return new ViewModel(array('errMsg' => $errMsg, 'postData' => $postData, 'categoryList' => $categories, 'selectedCategories' => $selectedCategories));
    }
    
    /**
     * 
     * @param type $data
     * @throws \Exception
     */
    protected function validateCategories($data){
        if(empty($data))
            throw new \Exception('Please select at least one category');
    }

}
