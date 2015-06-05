<?php

class Retailon_Storeconf_StoreconfController extends Mage_Core_Controller_Front_Action
{
		/*protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("storeconf/storeconf")->_addBreadcrumb(Mage::helper("adminhtml")->__("Storeconf  Manager"),Mage::helper("adminhtml")->__("Storeconf Manager"));
				return $this;
		}*/
		public function indexAction() 
		{

			    //$this->_title($this->__("Storeconf"));
			    //$this->_title($this->__("Manager Storeconf"));

				//$this->_initAction();
				//$this->renderLayout();
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
            echo "<script>alert('new')</script>";
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
	//print_r($post_data);
	//$post_data=$this->getRequest()->getPost();
	$store_id = $this->getRequest()->getParam("id");	
	$store_name = Mage::getSingleton('core/session')->getStorename();
	$seller_name = $post_data['seller_id'];
	$store_sub_category = $post_data['store_sub_category'];
	$store_contact = $post_data['store_contact'];
	$store_address = $post_data['store_address'];
	$store_eamil = $post_data['store_email'];
	$country = $post_data['country'];
	$state = $post_data['state'];
	$pin = $post_data['pin_code'];
	$vat_cst_numt = $post_data['vat_cst_num'];
	$pan_num= $post_data['pan_num'];
	$benificeary= $post_data['benificeary'];
	$acc_num= $post_data['acc_num'];
	$account_type = $post_data['account_type'];
	$ifsc = $post_data['ifsc'];
	$current_date_time = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
	//create duplicate category and assign product 
	$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $store_name);
	$cat_det=$category->getData();
	$category_id=$cat_det[0][entity_id];
	
	//get subcategory name
 	$_category = Mage::getModel('catalog/category')->load($store_sub_category);
	$categoryName = $_category->getName();
	
	
	//create subcategory to the parent category
 	$category = new Mage_Catalog_Model_Category();
	$category->setName($categoryName);
	$category->setUrlKey('new-category');
	$category->setIsActive(1);
	$category->setDisplayMode('PRODUCTS');
	$category->setIsAnchor(0);
	$parentCategory = Mage::getModel('catalog/category')->load($category_id);
	$category->setPath($parentCategory->getPath());                
	$category->save();
	//$sub_catId = $category->getId();
	
	//assign porduct to the duplicate category
	/*$category = Mage::getModel('catalog/category')->load($store_sub_category);
	$productCollection = $category->setStoreId(1)->getProductCollection();
  	foreach($productCollection as $_product) 
  	{
  		$product = Mage::getModel('catalog/product')->load($_product->getId());
  		$newCategories = $origCats = $product->getCategoryIds();
  		if(!in_array($to, $origCats)) 
  		{
    			$newCategories = array_merge($origCats, array($sub_catId));
   			$product->setCategoryIds($newCategories)->save();
		}
	}*/

	
	/*$customer = Mage::getModel("customer/customer");
	$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
	$customer->loadByEmail($seller_name);
	echo $customer->getId();*/
	/*My Code*/
	$seller_email=Mage::getSingleton('core/session')->getEmail($email);
	$customer = Mage::getModel("customer/customer");
	$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
	$customer->loadByEmail($seller_email);
	$address = Mage::getModel("customer/address");
$address->setCustomerId($customer->getId())
        ->setFirstname($customer->getFirstname())
        ->setMiddleName($customer->getMiddlename())
        ->setLastname($customer->getLastname())
        ->setCountryId($country)
	->setRegionId($state) //state/province, only needed if the country is USA
        ->setPostcode($pin)
        ->setCity($store_address)
        ->setTelephone($store_contact)
        ->setFax('')
        ->setCompany('')
        ->setStreet($store_address)
        ->setIsDefaultBilling('1')
        ->setIsDefaultShipping('1')
        ->setSaveInAddressBook('1');
 
try{
    $address->save();
}
catch (Exception $e) {
    Zend_Debug::dump($e->getMessage());
}
	/*My Code*/
	
	//echo "id = ".$store_id." contact = ".$store_contact." country = ".$country." pin =".$pin." state =".$state;
	
	$storeId=Mage::getSingleton('core/session')->getStoreid();
	
	if($store_contact != null && $store_address != null && $store_eamil != null && $store_id != null)
	{
	
		if ($post_data)
            	{ // if start
			try
                	{
                		$post_data['store_closing_day']=implode(',',$post_data['store_closing_day']);
				$post_data['home_sliding_image']=$post_data['home_sliding_image'];
    				 
	            		try
                    		{
		                        if((bool)$post_data['store_small_image']['delete']==1)
                	        	{
		                	        $post_data['store_small_image']='';

                		        }
		                        else
                		        {
	
        		                	unset($post_data['store_small_image']);
                        			if (isset($_FILES))
			                        {
		                        		if ($_FILES['store_small_image']['name'])
                			                {
                        					if($storeId)
                        					{
				                        		$model = Mage::getModel("storeconf/storeconf")->load($storeId);
				                        		if($model->getData('store_small_image'))
                                        				{
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
			            					    
                        		}
                            }
                        }
                    }
                    catch (Exception $e)
                    {
				        Mage::getSingleton('core/session')->addError($e->getMessage());
				        //$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				        return;
                    }
                    //save image
    				//save image
		            try
                    {

                        if((bool)$post_data['store_sliding_image']['delete']==1)
                        {
                	        $post_data['store_sliding_image']='';
                        }
                        else
                        {

                        	unset($post_data['store_sliding_image']);
                        	if (isset($_FILES))
                            {
                        		if ($_FILES['store_sliding_image']['name'])
                                {
                        			if($storeId)
                                    {
				                        $model = Mage::getModel("storeconf/storeconf")->load($storeId);
				                        if($model->getData('store_sliding_image'))
                                        {
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
                    }
                    catch (Exception $e)
                    {
				        Mage::getSingleton('core/session')->addError($e->getMessage());
				        //$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				        return;
                    }

                    //save image
    				$model = Mage::getModel("storeconf/storeconf")->load($storeId);
	    			if($model->getData('created_date'))
                    {
					    $post_data['created_date']=$model->getData('created_date');
				    }
                    else
                    {
					    //$post_data['created_date']=date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
					    $post_data['created_date'] = Mage::getModel('core/date')->timestamp(time());
				    }
				    //$post_data['created_date']=date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
				    //$post_data['modified_date']=date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
				    $post_data['created_date'] = Mage::getModel('core/date')->timestamp(time());
				    $post_data['modified_date'] = Mage::getModel('core/date')->timestamp(time());
					$model = Mage::getModel("storeconf/storeconf")
						     ->addData($post_data)
						     ->setId($this->getRequest()->getParam("id"))
						     ->save();
					Mage::getSingleton("core/session")->addSuccess(Mage::helper("seller")->__("Storeconf was successfully saved"));
					Mage::getSingleton("core/session")->setStoreconfData(false);
					
					$fromEmail = Mage::getStoreConfig('trans_email/ident_general/email');
					$toEmail = Mage::getSingleton('core/session')->getEmail();
					$body = "Your Request has been sent to admin. After approval you are able to login to your seller account.";
					$subject = "create store check";
					$mail = Mage::getModel('core/email');
					$mail->setToEmail($toEmail);
					$mail->setBody($body);
					$mail->setSubject('Seller acoount create');
					$mail->setFromEmail($fromEmail);
					$mail->setFromName('Seller acoount create ');
					$mail->setType('html');
					//print_r($mail);
					//die();
					
					try 
					{
    						$mail->send();
    						Mage::getSingleton('core/session')->addSuccess('Check Your email for more dettails'); 
    						//echo "done" ;
    						//die();
					}
					catch (Exception $e) 
					{
    							Mage::getSingleton('core/session')->addError('Unable to send.');
    							//echo "not done";
    							//die();
   					}

					if ($this->getRequest()->getParam("back"))
                    {
						//$this->_redirect("*/*/edit", array("id" => $model->getId()));
						//return;
					}
					//$this->_redirect("*/*/");
					//return;
				}
				catch (Exception $e)
                {
					Mage::getSingleton("core/session")->addError($e->getMessage());
					Mage::getSingleton("core/session")->setStoreconfData($this->getRequest()->getPost());
					//$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
				}
            }
           
            $url=Mage::getBaseUrl()."seller/login/";

			$this->_redirectUrl($url);
			}
			else
			{
			$new_id = Mage::getModel("storeconf/storeconf")->getId(($this->getRequest()->getParam("id")));
			$this->_redirect('seller/editstore/index/id/'.$new_id);
			}
			
		
		
}
//save action end



		public function deleteAction()
		{
            echo "<script>alert('delete')</script>";
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
            echo "<script>alert('massremove')</script>";
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
            echo "<script>alert('exportCsvAction')</script>";
			$fileName   = 'storeconf.csv';
			$grid       = $this->getLayout()->createBlock('storeconf/adminhtml_storeconf_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
            echo "<script>alert('exportExcelAction')</script>";
			$fileName   = 'storeconf.xml';
			$grid       = $this->getLayout()->createBlock('storeconf/adminhtml_storeconf_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}