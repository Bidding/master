<?php
class Bidding_Store_Adminhtml_StoreController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('report/store');
		$this->renderLayout();
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