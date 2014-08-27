<?php
class Bidding_Store_Adminhtml_StoreController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('report/store');
		$this->renderLayout();
	}
	
	public function historyAction()
	{
		$this->loadLayout();
		$this->renderLayout();	
	}
	
	public function gridAction()
	{
		Mage::getSingleton('admin/session')->setCustomerId($this->getRequest()->getParam('id'));
		$this->loadLayout();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('store/adminhtml_customer_edit_listing')->toHtml()
		);
	}
	
	public function exportCsvAction()
	{
		$fileName = 'Bidding_Winner.csv';
		$grid = $this->getLayout()->createBlock('store/adminhtml_store_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
	}
	
	public function exportExcelAction()
	{
		$fileName   = 'Bidding_Winner.xml';
		$grid    = $this->getLayout()->createBlock('store/adminhtml_store_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
	}
}