<?php
/**
 * Created by PhpStorm.
 * User: arshad
 * Date: 6/1/2015
 * Time: 4:10 PM
 */

class Retailon_Marketplace_Adminhtml_MarketplaceController extends Mage_Adminhtml_Controller_Action {
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("marketplace/marketplace")->_addBreadcrumb(Mage::helper("adminhtml")->__("Marketplace  Manager"),Mage::helper("adminhtml")->__("Marketplace Manager"));
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__("Marketplace"));
        $this->_title($this->__("Manager Marketplace"));

        $this->_initAction();
        $this->renderLayout();
    }
    public function editAction()
    {
        $this->_title($this->__("Marketplace"));
        $this->_title($this->__("Marketplace"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("marketplace/marketplace")->load($id);
        if ($model->getId()) {
            $userID = $model->getMageUserId();
            $userModel = Mage::getModel("admin/user")->load($userID);
            $model->setUsername($userModel->getUsername());
            $model->setFirstname($userModel->getFirstname());
            $model->setLastname($userModel->getLastname());
            $model->setEmail($userModel->getEmail());
            Mage::register("marketplace_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("marketplace/marketplace");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Marketplace Manager"), Mage::helper("adminhtml")->__("Marketplace Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Marketplace Description"), Mage::helper("adminhtml")->__("Marketplace Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("marketplace/adminhtml_marketplace_edit"))->_addLeft($this->getLayout()->createBlock("marketplace/adminhtml_marketplace_edit_tabs"));
            $this->renderLayout();
        }
        else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("marketplace")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction()
    {

        $this->_title($this->__("Marketplace"));
        $this->_title($this->__("Marketplace"));
        $this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
        $model  = Mage::getModel("marketplace/marketplace")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("marketplace_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("marketplace/marketplace");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Marketplace Manager"), Mage::helper("adminhtml")->__("Marketplace Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Marketplace Description"), Mage::helper("adminhtml")->__("Marketplace Description"));


        $this->_addContent($this->getLayout()->createBlock("marketplace/adminhtml_marketplace_edit"))->_addLeft($this->getLayout()->createBlock("marketplace/adminhtml_marketplace_edit_tabs"));

        $this->renderLayout();

    }
    public function saveAction()
    {

        $post_data=$this->getRequest()->getPost();


        if ($post_data) {

            try {



                $model = Mage::getModel("marketplace/marketplace")
                    ->addData($post_data)
                    ->setId($this->getRequest()->getParam("id"))
                    ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Marketplace was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setMarketplaceData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setMarketplaceData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }

        }
        $this->_redirect("*/*/");
    }



    public function deleteAction()
    {
        if( $this->getRequest()->getParam("id") > 0 ) {
            try {
                $model = Mage::getModel("marketplace/marketplace");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            }
            catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }


    public function massRemoveAction()
    {
        try {
            $ids = $this->getRequest()->getPost('marketplace_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("marketplace/marketplace");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        }
        catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName   = 'marketplace.csv';
        $grid       = $this->getLayout()->createBlock('marketplace/adminhtml_marketplace_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName   = 'marketplace.xml';
        $grid       = $this->getLayout()->createBlock('marketplace/adminhtml_marketplace_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}