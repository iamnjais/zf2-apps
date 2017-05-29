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
                $postId = $post['id'];
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
        $categoryId = $_REQUEST['id'];

        $categoryModel = $this->getServiceLocator()->get('categoryModel');
        $categoryModel->delete($categoryId);
        $this->redirect()->toRoute('category');
    }

    /**
     * 
     */
    public function updatepostAction() {

        $categoryModel = $this->getServiceLocator()->get('categoryModel');
        $postModel = $this->getServiceLocator()->get('postModel');
        $postId = $this->params()->fromRoute('id', 0);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            try {
                $response = $postModel->update($post, $postId);
                $this->redirect()->toRoute('posts');
            } catch (\Exception $ex) {
                return new ViewModel(array('errMsg' => $ex->getMessage()));
            }
        } else {

            if ($postId != 0) {
                $categoryModel = $this->getServiceLocator()->get('categoryModel');

                $categories = $categoryModel->getAllCategories();
                $postData = $postModel->getPostById($postId);
                return new ViewModel(array('postData' => $postData, 'categoryList' => $categories));
            }
        }
    }

}
