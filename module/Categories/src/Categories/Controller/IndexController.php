<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Categories\Controller;

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
    public function addcategoryAction() {
        if ($this->request->isPost()) {
            $post = $this->request->getPost();

            $categoryModel = $this->getServiceLocator()->get('categoryModel');

            try {
                $products = $categoryModel->addCategory($post);
            } catch (\Exception $ex) {
                return new ViewModel(array('errMsg' => $ex->getMessage()));
            }
            if ($products->count() > 0) {
                $this->redirect()->toRoute('category');
            }
        }
    }

    /**
     * 
     */
    public function categorylistAction() {
        $categoryModel = $this->getServiceLocator()->get('categoryModel');
        $categoryData = $categoryModel->getAllCategories();
        $categoryList = array('data' => array());
        if (count($categoryData) > 0) {
            foreach ($categoryData as $key => $category) {
                $categoryId = $category['id'];
                $categoryList['data'][$key] = array($category['category_name'], $category['description'],
                    "<a href='/deletecategory?id=$categoryId'>Delete</a>",
                    "<a href='/updatecategory/$categoryId'>Update</a>");
            }
        }

        exit(json_encode($categoryList));
    }

    /**
     * 
     */
    public function deletecategoryAction() {
        $categoryId = $_REQUEST['id'];

        $categoryModel = $this->getServiceLocator()->get('categoryModel');
        $categoryModel->delete($categoryId);
        $this->redirect()->toRoute('category');
    }

    /**
     * 
     */
    public function updatecategoryAction() {

        $categoryModel = $this->getServiceLocator()->get('categoryModel');
        $categoryId = $this->params()->fromRoute('id', 0);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            try {
                $response = $categoryModel->update($post, $categoryId);
                $this->redirect()->toRoute('category');
            } catch (\Exception $ex) {
                return new ViewModel(array('errMsg' => $ex->getMessage()));
            }
        } else {

            if ($categoryId != 0) {

                $categoryData = $categoryModel->getCategoryById($categoryId);
                return new ViewModel(array('categoryData' => $categoryData));
            }
        }
    }

}
