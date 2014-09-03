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

	public function setPointsAction()
	{
		$data = $this->getRequest()->getParams();

		if ($this->getRequest()->isPost() && (Mage::getSingleton('core/session')->getFormKey() == $data['form_key']))
		{
			$pointsModel = Mage::getModel('points/points')->load($data['id'], 'customer_id');
			// Set Points in Entity Table
			$pointsModel->setCustomerId($data['id']);
			$pointsModel->setBalance($pointsModel->getBalance() + $data['balance']);
			$pointsModel->save();
			$this->_redirect('/customer/edit' , array('id' => $data['id'], 'back' => 'edit', 'tab' => 'customer_info_tabs_points_history'));
		}
		else
		{
			Mage::getSingleton( 'core/session' )->addError('Invalid Request');
			$this->_redirect('/customer/index');
		}
	}
}