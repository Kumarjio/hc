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
class PrivatelabelsitespagesController extends AppController 
{

	var $helpers = array ('Html','Form');
	
	public $components = array('Paginator');

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Privatelabelsitespages';

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
			$this->loadModel('PortalPages');
			/* $arrPortalPages = $this->PortalPages->find('all',array("conditions"=>array('career_portal_id'=>$intPortalId),
														  "order"=>array('career_portal_page_createddatetime'=>'DESC'))); */
			$this->Paginator->settings = array(
				'conditions' => array('career_portal_id' => $intPortalId),
				'order' => array('career_portal_page_createddatetime' => 'DESC'),
				'limit' => 10
			);
			
			$arrPortalPages = $this->Paginator->paginate('PortalPages');
			
			$this->set('arrPortalPages',$arrPortalPages);
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
			if($this->request->is('post'))
			{
				/* print("<pre>");
				print_r($this->request->data['PortalPages']);exit; */
				
				$compPortalPage = $this->Components->load('PortalPages');
				$arrPageCreated = $compPortalPage->fnCreatePortalPages($this->request->data['PortalPages']);
				if(is_array($arrPageCreated) && (count($arrPageCreated)>0))
				{
					if($arrPageCreated['status'] == "success")
					{
						$this->Session->setFlash($arrPageCreated['message'],'default',array('class'=>'success'));
						if($arrPageCreated['redirect'] == "1")
						{
							$this->redirect($arrPageCreated['redirecturl']);
						}
					}
					else
					{
						$this->Session->setFlash($arrPageCreated['message']);
					}
				}
			}	
			$this->set('portal_id',$intPortalId);
		}
		else
		{
			$this->Session->setFlash('This Portal does not exists, Please try with other Portal');
		}
	}
	
	public function delete($intPageId = "")
	{
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		if(is_array($arrPageDetail))
		{			
			$this->loadModel('PortalPages');
			$intPortalPageExists = $this->PortalPages->find('count', array(
									'conditions' => array('career_portal_id' => $arrPageDetail['1'],'career_portal_page_id' => $arrPageDetail['0'])
								));
			
			if($intPortalPageExists)
			{
				$intPortalPageDeleted = $this->PortalPages->deleteAll(array('PortalPages.career_portal_page_id' => $arrPageDetail['0']),false);
				if($intPortalPageDeleted)
				{
					$this->Session->setFlash('Page deleted successfully','default',array('class' => 'success'));
					$this->redirect(array('action'=>'index',$arrPageDetail['1']));
				}
			}
			else
			{
				$this->redirect(array('action'=>'index',$arrPageDetail['1']));
			}
		}
		else
		{
			$this->redirect(array('action'=>'index',$arrPageDetail['1']));
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
		$this->set('strPortalNotFoundMessage',"");
		$this->set("strKeywords","");
		$this->set("strlocation","");
		
		$strId = base64_decode($intPageId);
		$arrPageDetail = explode("_",$strId);
		
		$arrLoggedUserDetails = $this->Auth->user();
		if(is_array($arrPageDetail))
		{
			$this->loadModel('Portal');
			$arrPortalDetail = $this->Portal->find('all', array(
									'conditions' => array('career_portal_id'=> $arrPageDetail['1'])
								));
			/* print("<pre>");
			print_r($arrPortalDetail); */
			
			if(is_array($arrPortalDetail) && (count($arrPortalDetail)>0))
			{
				$this->set('arrPortalDetail',$arrPortalDetail);
				$this->set('strPortalName',strtolower($arrPortalDetail[0]['Portal']['career_portal_name']));
				$this->set('intPortalId',$arrPortalDetail[0]['Portal']['career_portal_id']);
				
				// load portal theme and its details
				$this->loadModel('PortalTheme');
				$arrPortalThemeDetail = $this->PortalTheme->fnLoadPortalThemeDetail($arrPageDetail['1']);
				
				if(is_array($arrPortalThemeDetail) && (count($arrPortalThemeDetail)>0))
				{
					$this->set('arrPortalThemeDetail',$arrPortalThemeDetail);
				}
				
				// load portal theme widgets
				$intPortalThemeId = $arrPortalThemeDetail[0]['career_portal_theme']['career_portal_theme_id'];
				$this->loadModel('PortalThemeWidgets');
				//$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalId,$intPortalThemeId);
				$arrPortalThemeWidgets = $this->PortalThemeWidgets->fnLoadPortalThemeWidgetDetail($intPortalThemeId);
				/* print("<pre>");
				print_r($arrPortalThemeWidgets);
				exit; */
				if(is_array($arrPortalThemeWidgets) && (count($arrPortalThemeWidgets)>0))
				{
					$this->set('arrPortalWidgets',$arrPortalThemeWidgets);
				}
				
				$this->loadModel('TopMenu');
				$arrMenuDetail = $this->TopMenu->find('all',array('conditions'=>array('career_portal_id'=>$arrPageDetail['1'])));
				/* print("<pre>");
				print_r($arrMenuDetail); */
				if(is_array($arrMenuDetail) && (count($arrMenuDetail)>0))
				{
					$this->set('arrPortalMenuDetail',$arrMenuDetail);
				}
				$this->loadModel('PortalPages');
				$arrPortalPageDetail = $this->PortalPages->find('all', array(
										'conditions' => array('career_portal_id' => $arrPageDetail['1'],'career_portal_page_id' => $arrPageDetail['0'])
									));
									

				$this->set('arrPortalPageDetail',$arrPortalPageDetail);
				
				$this->loadModel('JCountry');
				$arrJCountries = $this->JCountry->find('list',array('fields'=>array('JCountry.code', 'JCountry.name')));
				asort($arrJCountries);
				$this->set('arrJcountry',$arrJCountries);
				
				
				$this->loadModel('JobCategory');
				$arrJCategories = $this->JobCategory->find('list',array('fields'=>array('JobCategory.id', 'JobCategory.cat_name')));
				$arrJCategories["0"] = "Choose Category";
				ksort($arrJCategories);
				$this->set('arrJcategories',$arrJCategories);
				
				
				$this->loadModel('JobExperience');
				$arrJobExperience = $this->JobExperience->find('list',array('fields'=>array('JobExperience.var_name', 'JobExperience.experience_name')));
				$arrJobInitialVal["0"] = "Choose Experience";
				//ksort($arrJobExperience);
				$arrNewMergedJobExp = array_merge($arrJobInitialVal,$arrJobExperience);
				$this->set('arrJobExperience',$arrNewMergedJobExp);

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