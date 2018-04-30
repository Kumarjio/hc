<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PrivatelabelsitesmenuController extends AppController 
{

	var $helpers = array ('Html','Form');

	public $components = array('Paginator');
	
/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Privatelabelsitesmenu';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	
	public function index($intPortalId)
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
		if($intPortalExists)
		{
			$this->loadModel('TopMenu');
			/* $arrPortalTopeMenu = $this->TopMenu->find('all',array("conditions"=>array('career_portal_id'=>$intPortalId),
													  "order"=>array('career_portal_menu_createddatetime'=>'DESC'))); */
			
			$this->Paginator->settings = array(
				'conditions' => array('career_portal_id' => $intPortalId),
				'order' => array('career_portal_menu_createddatetime' => 'DESC'),
				'limit' => 10
			);
			$arrPortalTopeMenu = $this->Paginator->paginate('TopMenu');
			
			$this->set('arrPortalTopMenu',$arrPortalTopeMenu);
			$this->set('portal_id',$intPortalId);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}
		
		
	}
	
	public function add($intPortalId)
	{
		$arrLoggedUserDetails = $this->Auth->user();
		$this->loadModel('Portal');
		$intPortalExists = $this->Portal->find('count', array(
									'conditions' => array('career_portal_provider_id' => $arrLoggedUserDetails['id'],'career_portal_id'=> $intPortalId)
								));
		
		if($intPortalExists)
		{
			$this->loadModel('TopMenu');
			if($this->request->is('post'))
			{
				$this->request->data['TopMenu']['career_portal_menu_page_id'] = addslashes(trim($this->request->data['TopMenu']['menu_page']));
				$this->request->data['TopMenu']['career_portal_id'] = addslashes(trim($this->request->data['TopMenu']['portal_id']));
				$this->request->data['TopMenu']['career_portal_menu_createdby'] =  $arrLoggedUserDetails['id'];
				$intPostedPortalId = addslashes(trim($this->request->data['TopMenu']['portal_id']));
				if($this->request->data['TopMenu']['career_portal_menu_page_id'])
				{
					$this->loadModel('PortalPages');
					$arrPageDetail = $this->PortalPages->find('list',array('fields'=>array('PortalPages.career_portal_page_id', 'PortalPages.career_portal_page_tittle')),array("conditions"=>array('career_portal_id'=>$intPortalId,'career_portal_menu_page_id'=>$this->request->data['TopMenu']['career_portal_menu_page_id'])));
					$strMenuName =  $arrPageDetail[$this->request->data['TopMenu']['career_portal_menu_page_id']];
					$strMenuUrl = Router::url(array('controller' => 'privatelabelsitespages', 'action' => 'preview',base64_encode($this->request->data['TopMenu']['career_portal_menu_page_id']."_".$intPostedPortalId)),true);
					$this->request->data['TopMenu']['career_portal_menu_name'] = $strMenuName;
					$this->request->data['TopMenu']['career_portal_menu_link'] = base64_encode($strMenuUrl);
				}

				$intPortalTopMenuExists = $this->TopMenu->find('count', array(
									'conditions' => array('career_portal_id' => $intPostedPortalId,'career_portal_menu_page_id'=> $this->request->data['TopMenu']['menu_page'])
								));
				if($intPortalTopMenuExists)
				{
					$this->Session->setFlash('This Menu is already create');
				}
				else
				{
					$this->TopMenu->set($this->request->data);
					if($this->TopMenu->validates())
					{
						$boolPortalMenuCreated = $this->TopMenu->save($this->request->data);
						if($boolPortalMenuCreated)
						{
							$this->Session->setFlash('Menu created successfully','default',array('class' => 'success'));
							$this->redirect(array('action'=>'index',$intPostedPortalId));
						}
					}
					else
					{
						$strMenuCreationErrorMessage = "";
						$arrMenuCreationErrors = $this->TopMenu->invalidFields();
						if(is_array($arrMenuCreationErrors) && (count($arrMenuCreationErrors)>0))
						{
							$intForIterateCount = 0;
							foreach($arrMenuCreationErrors as $errorVal)
							{
								$intForIterateCount++;
								if($intForIterateCount == 1)
								{
									$strMenuCreationErrorMessage .= "Error: ".$errorVal['0'];
								}
								else
								{
									$strMenuCreationErrorMessage .= "<br> Error: ".$errorVal['0'];
								}
							}
						}
						$this->Session->setFlash($strMenuCreationErrorMessage);
					}
					
				}
			}
			$this->loadModel('PortalPages');
			$arrPageList = $this->PortalPages->find('list',array('fields'=>array('PortalPages.career_portal_page_id', 'PortalPages.career_portal_page_tittle')),array("conditions"=>array('career_portal_id'=>$intPortalId),
														  "order"=>array('career_portal_page_createddatetime'=>'DESC')));
			$arrPageList[""] = "--Select Page--";
			ksort($arrPageList);
			$this->set('arrPageList',$arrPageList);
			$this->set('portal_id',$intPortalId);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}
	}
	
	public function delete($intMenuId = "")
	{
		$strId = base64_decode($intMenuId);
		$arrMenuDetail = explode("_",$strId);
		if(is_array($arrMenuDetail))
		{			
			$this->loadModel('TopMenu');
			$intPortalMenuDeleted = $this->TopMenu->deleteAll(array('TopMenu.career_portal_menu_alloc_id' => $arrMenuDetail['0']),false);
			if($intPortalMenuDeleted)
			{
				$this->Session->setFlash('Menu deleted successfully','default',array('class' => 'success'));
				$this->redirect(array('action'=>'index',$arrMenuDetail['1']));
			}
		}
		else
		{
			$this->redirect(array('action'=>'index',$arrMenuDetail['1']));
		}
	}
	
	public function edit($intPageId = "")
	{
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		
		if(is_array($arrPageDetail))
		{
			
			$this->loadModel('PortalPages');
			
			if($this->request->is('post'))
			{
				$this->request->data['PortalPages']['career_portal_page_tittle'] = addslashes(trim($this->request->data['PortalPages']['portal_page_title']));
				$this->request->data['PortalPages']['career_portal_page_content'] = $this->request->data['PortalPages']['portal_page_content'];

				$arrPostedPortalPageId = explode("_",base64_decode($this->request->data['PortalPages']['portal_page_id']));
				
				$this->PortalPages->set($this->request->data);
				if($this->PortalPages->validates(array('fieldList' => array('career_portal_page_tittle'))))
				{					
					$boolUpdated = $this->PortalPages->updateAll(
								array('PortalPages.career_portal_page_tittle' => "'".$this->request->data['PortalPages']['career_portal_page_tittle']."'",'PortalPages.career_portal_page_content'=>"'".$this->request->data['PortalPages']['career_portal_page_content']."'"),
								array('PortalPages.career_portal_page_id =' => $arrPostedPortalPageId['0'])
							);			
					if($boolUpdated)
					{
						$this->Session->setFlash('Page Updated successfully','default',array('class' => 'success'));
						$this->redirect(array('action'=>'index',$arrPostedPortalPageId['1']));
					}
				}
				else
				{
					$strPortalUpdationErrorMessage = "";
					$arrPortalUpdationErrors = $this->PortalPages->invalidFields();
					if(is_array($arrPortalUpdationErrors) && (count($arrPortalUpdationErrors)>0))
					{
						$intForIterateCount = 0;
						foreach($arrPortalUpdationErrors as $errorVal)
						{
							$intForIterateCount++;
							if($intForIterateCount == 1)
							{
								$strPortalUpdationErrorMessage .= "Error: ".$errorVal['0'];
							}
							else
							{
								$strPortalUpdationErrorMessage .= "<br> Error: ".$errorVal['0'];
							}
						}
					}
					$this->Session->setFlash($strPortalUpdationErrorMessage);
				}
				
			}
			
			$intPortalPageExists = $this->PortalPages->find('count', array(
									'conditions' => array('career_portal_id' => $arrPageDetail['1'],'career_portal_page_id' => $arrPageDetail['0'])
								));
			if($intPortalPageExists)
			{
				$arrPortalPageDetail = $this->PortalPages->find('all',array('conditions'=>array('career_portal_page_id'=>$arrPageDetail['0'])));
				$this->set('arrPortalsPage',$arrPortalPageDetail);
				$this->set('portal_page_id',base64_encode(implode("_",$arrPageDetail)));
				$this->set('portal_id',$arrPageDetail['1']);
			}
			
		}
		else
		{
			$this->redirect(array('action'=>'index',$arrPageDetail['1']));
		}
	}
	
	public function preview($intPageId)
	{
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrPageDetail))
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $arrPageDetail['1'])
								));
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->loadModel('PortalPages');
				$arrPortalPageDetail = $this->PortalPages->find('all', array(
										'conditions' => array('career_portal_id' => $arrPageDetail['1'],'career_portal_page_id' => $arrPageDetail['0'])
									));
									
				if(is_array($arrPortalPageDetail) && (count($arrPortalPageDetail)>0))
				{
					$this->set('arrPortalPageDetail',$arrPortalPageDetail);
				}
			}
		}
	}
	
	public function sethomepage($intPageId)
	{
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		$arrLoggedUserDetails = $this->Auth->user();
		
		if(is_array($arrPageDetail))
		{
			$boolUpdated = $this->fnSetPageAsHomePage($arrPageDetail['1'],$arrPageDetail['0']);
			if($boolUpdated)
			{
				$this->Session->setFlash('Home Page Set successfully','default',array('class' => 'success'));
				$this->redirect(array('action'=>'index',$arrPageDetail['1']));
			}
			
		}
	}
	
	public function fnSetPageAsHomePage($intPortalId = "", $intPageId = "")
	{
		$this->loadModel('PortalPages');
		$boolUpdated = $this->PortalPages->updateAll(
							array('PortalPages.is_career_portal_home_page' => "'1'"),
							array('PortalPages.career_portal_page_id =' => $intPageId)
						);			
			if($boolUpdated)
			{
				$boolUpdated = $this->PortalPages->updateAll(
							array('PortalPages.is_career_portal_home_page' => "'0'"),
							array('PortalPages.career_portal_page_id !=' => $intPageId,'PortalPages.career_portal_id =' => $intPortalId)
						);
				
				if($boolUpdated)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
	}
}