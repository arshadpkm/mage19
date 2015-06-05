<?php

class Retailon_Storeconf_Adminhtml_StoreconfController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("storeconf/storeconf")->_addBreadcrumb(Mage::helper("adminhtml")->__("Storeconf  Manager"),Mage::helper("adminhtml")->__("Storeconf Manager"));
				return $this;
		}
		public function indexAction()
		{
			    $this->_title($this->__("Storeconf"));
			    $this->_title($this->__("Manager Storeconf"));

				$this->_initAction();
				$this->renderLayout();

		}
		public function editAction()
		{
			    $this->_title($this->__("Storeconf"));
				$this->_title($this->__("Storeconf"));
			    $this->_title($this->__("Edit Item"));

				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("storeconf/storeconf")->load($id);
				if ($model->getId()) {
					Mage::register("storeconf_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("storeconf/storeconf");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storeconf Manager"), Mage::helper("adminhtml")->__("Storeconf Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storeconf Description"), Mage::helper("adminhtml")->__("Storeconf Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("storeconf/adminhtml_storeconf_edit"))->_addLeft($this->getLayout()->createBlock("storeconf/adminhtml_storeconf_edit_tabs"));
					$this->renderLayout();
				}
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("storeconf")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Storeconf"));
		$this->_title($this->__("Storeconf"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("storeconf/storeconf")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("storeconf_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("storeconf/storeconf");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storeconf Manager"), Mage::helper("adminhtml")->__("Storeconf Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Storeconf Description"), Mage::helper("adminhtml")->__("Storeconf Description"));


		$this->_addContent($this->getLayout()->createBlock("storeconf/adminhtml_storeconf_edit"))->_addLeft($this->getLayout()->createBlock("storeconf/adminhtml_storeconf_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {


					//$post_data['store_open_time']=implode(':',$post_data['store_open_time']);
					//$post_data['store_close_time']=implode(':',$post_data['store_close_time']);
					$post_data['store_closing_day']=implode(',',$post_data['store_closing_day']);
					$post_data['home_sliding_image']=$post_data['home_sliding_image'];

				 //save image
		try{

if((bool)$post_data['store_small_image']['delete']==1) {

	        $post_data['store_small_image']='';

}
else {

	unset($post_data['store_small_image']);

	if (isset($_FILES)){

		if ($_FILES['store_small_image']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("storeconf/storeconf")->load($this->getRequest()->getParam("id"));
				if($model->getData('store_small_image')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('store_small_image'))));
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'storeconf' . DS .'storeconf'.DS;
						$uploader = new Varien_File_Uploader('store_small_image');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['store_small_image']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);


						$post_data['store_small_image']='storeconf/storeconf/'.$filename;
						/*
						$_imageUrl = $destFile;
						$imageResized = Mage::getBaseDir('media') . DS . 'storeconf' . DS .'storeconf'.DS.$filename;
						if (!file_exists($imageResized)&&file_exists($_imageUrl)) :
						$imageObj = new Varien_Image($_imageUrl);
						$imageObj->constrainOnly(TRUE);
						$imageObj->keepAspectRatio(TRUE);
						$imageObj->keepFrame(FALSE);
						$imageObj->resize(278);
						$imageObj->save($imageResized);
						endif;
									*/


		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image

				 //save image
		try{

if((bool)$post_data['store_sliding_image']['delete']==1) {

	        $post_data['store_sliding_image']='';

}
else {

	unset($post_data['store_sliding_image']);

	if (isset($_FILES)){

		if ($_FILES['store_sliding_image']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("storeconf/storeconf")->load($this->getRequest()->getParam("id"));
				if($model->getData('store_sliding_image')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('store_sliding_image'))));
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'storeconf' . DS .'storeconf'.DS;

						$uploader = new Varien_File_Uploader('store_sliding_image');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['store_sliding_image']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['store_sliding_image']='storeconf/storeconf/'.$filename;


						$_imageUrl = $destFile;
						$imageResized = Mage::getBaseDir('media') . DS . 'storeconf' . DS .'storeconf'.DS.$filename;
						if (!file_exists($imageResized)&&file_exists($_imageUrl)) :
						$imageObj = new Varien_Image($_imageUrl);
						$imageObj->constrainOnly(TRUE);
						$imageObj->keepAspectRatio(TRUE);
						$imageObj->keepFrame(FALSE);
						$imageObj->resize(1100);
						$imageObj->save($imageResized);
						endif;

		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


				$model = Mage::getModel("storeconf/storeconf")->load($this->getRequest()->getParam("id"));
				if($model->getData('created_date')){
					$post_data['created_date']=$model->getData('created_date');
				}else{
					$post_data['created_date']=date('Y-m-d');
				}

						$post_data['modified_date']=date('Y-m-d');
						$model = Mage::getModel("storeconf/storeconf")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Storeconf was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setStoreconfData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					}
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setStoreconfData($this->getRequest()->getPost());
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
						$model = Mage::getModel("storeconf/storeconf");
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
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("storeconf/storeconf");
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
			$fileName   = 'storeconf.csv';
			$grid       = $this->getLayout()->createBlock('storeconf/adminhtml_storeconf_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		}
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'storeconf.xml';
			$grid       = $this->getLayout()->createBlock('storeconf/adminhtml_storeconf_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}

/* retailon 42*/
    public function statusAction()
    {
        $storeid = $this->getRequest()->getParam('enable_id');

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');

        $write = Mage::getSingleton('core/resource')->getConnection('core_write');

        $result = $read->fetchAll("select is_active from core_store where Store_id = ".$storeid);

        $seller_id = $read->fetchAll("select seller_id from retailon_seller_settings where store_name = ".$storeid);

        if($result[0]['is_active'] > 0)
        {
            $data = array("is_active" => 0);
            $where = "store_id = ".$storeid;
            $write->update("core_store", $data, $where);

            $data = array("is_active" => 0);
            $where = "entity_id = ".$seller_id[0]['seller_id'];
            $write->update("customer_entity", $data, $where);

            $url = $this->getUrl("admin_storeconf/adminhtml_storeconf");
            $this->_redirectUrl($url);
        }
        else
        {
            $data = array("is_active" => 1);
            $where = "store_id = ".$storeid;
            $write->update("core_store", $data, $where);

            $data = array("is_active" => 1);
            $where = "entity_id = ".$seller_id[0]['seller_id'];
            $write->update("customer_entity", $data, $where);

            $url = $this->getUrl("admin_storeconf/adminhtml_storeconf");
            $this->_redirectUrl($url);
        }
    }
    /* retailon 42 ends here */
}
