<?php
class Bidding_Points_Adminhtml_PointsController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$this->_title($this->__('Points Managment'));
		$this->loadLayout();
		$this->_setActiveMenu('customer/points');
		$this->_addContent($this->getLayout()->createBlock('points/adminhtml_points'));
		$this->renderLayout();
	}

	public function gridAction() {
		$this->loadLayout();
		$this->getResponse()->setBody(
		$this->getLayout()->createBlock('points/adminhtml_points_grid')->toHtml()
		);
	}
	
	public function editAction() {
		$this->loadLayout();
		$block = $this->getLayout()->createBlock(
						'Mage_Core_Block_Template','points_block',
						array('template' => 'points/management.phtml')
						);
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	public function setPointsAction() {
		$data = $this->getRequest()->getParams();
		$points_model = Mage::getModel('points/points')->load($data['id'], 'customer_id');
		$balance = $points_model->getBalance() + (int)$data['balance'];
		$points_model->setBalance($balance);
		$points_model->save();
		Mage::getSingleton('core/session')->addSuccess('The Balance has been saved');
		Mage::app()->getResponse()->setRedirect(Mage::helper('adminhtml')->getUrl('/points/edit', array('id' => $data['id'])));
	}
}