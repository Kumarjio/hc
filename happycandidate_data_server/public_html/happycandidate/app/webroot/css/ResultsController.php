<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
class ResultsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $name = 'Results';
	
	public function beforeFilter()
	{
		//$this->Auth->autoRedirect = false;
		parent::beforeFilter();
		$this->Auth->allow('send','marksheetsend');
	}
	
	public function import()
	{
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
	}
	
	public function delete($intProductId)
	{
		$this->autoRender = False;
		$this->layout = NULL;
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrStudentDeleted =  $compStudents->fnDeleteStudent($intProductId);
		
		echo json_encode($arrStudentDeleted);
		exit;
	}
	
	public function deletefile($intProductId)
	{
		$this->autoRender = False;
		$this->layout = NULL;
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrStudentDeleted =  $compStudents->fnDeleteMarkSheetFile($intProductId);
		
		echo json_encode($arrStudentDeleted);
		exit;
	}
	
	public function searchfile($strFileName)
	{
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/marksheet_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$arrConditions = array();
		if($strFileName)
		{
			$arrConditions['file_name Like'] = $strFileName."%";
		}
		
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		if(is_array($arrConditions) && (count($arrConditions)>0))
		{
			$arrProcInq = $compStudents->fnGetMarksheetFile($arrConditions);
		}
		else
		{
			$arrProcInq = $compStudents->fnGetMarksheetFile();
		}
		
		//print("<pre>");
		//print_r($arrProcInq);
		//exit;
		$this->set("strFileName",$strFileName);
		$this->set("arrProcInq",$arrProcInq);
		$this->set("arrConditions",$arrConditions);
	}
	
	/*public function allexportlistingpdf()
	{
		
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		$arrConditions = array();
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		$arrProcInq = $compStudents->fnGetAllMarksheetData1();
		
		if(is_array($arrProcInq) && (count($arrProcInq)>0))
		{
			if($_GET['strExportType'] == "pdf")
			{
				$compPdf = $this->Components->load('Pdf'); //load it
				$arrHeader = array('First Name','Last Name','Class','Section','Exam','subject','Mark');
				$arrPdfCreated = $compPdf->fnResultsPreparePdf($arrHeader,$arrProcInq);
				//print("<pre>");
				//print_r($arrPdfCreated);
				//exit;
				
				if($arrPdfCreated['status'] == "success")
				{
					$arrResponse = $arrPdfCreated;
					$arrResponse['message'] = "File exported successfully ";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "Some error, Please try again";
				}
			}
			else
			{
				$compPdf = $this->Components->load('Excel'); //load it
				$arrHeader = array('First Name','Last Name','Class','Section','Exam','subject','Mark');
				$arrPdfCreated = $compPdf->fnResultsPreparePdf($arrHeader,$arrProcInq);
				//print("<pre>");
				//print_r($arrPdfCreated);
				//exit;
				
				if($arrPdfCreated['status'] == "success")
				{
					$arrResponse = $arrPdfCreated;
					$arrResponse['message'] = "File exported successfully ";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "Some error, Please try again";
				}
			}
		} else {
		  $arrResponse['status'] = "fail";
		  $arrResponse['message'] = "Some error, Please try again";
		}
		return json_encode($arrResponse);
		exit;
	}*/
	// student wise data
	public function allexportlistingpdf($examId,$studId)
	{
		//Configure::write('debug','2');
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		$arrConditions = array();
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		//$arrProcInq = $compStudents->fnGetStudentMarksheetData($examId,$studId);
		
		$this->paginate = array(
					'fields' => array('Result.exam_student_performance_id','Result.exam_id' ,'subjects.subject_name','Result.student_mark','Result.subject_mark','student.student_fname','student.student_lname','student.class','student.section','student.student_unique_id','exam.exam_name'),
				    'joins' => array(array('alias' => 'student','table' => 'student','type' => 'INNER','conditions' => '`Result`.`student_id` = `student`.`student_unique_id`'),array('alias' => 'exam','table' => 'exam','type' => 'INNER','conditions' => '`Result`.`exam_id` = `exam`.`exam_id`'),array('alias' => 'subjects','table' => 'subjects','type' => 'INNER','conditions' => '`Result`.`subject_id` = `subjects`.`subject_id`')),
					'conditions' => array('Result.exam_id' => $examId,'student.student_unique_id'=>$studId),
					'order' => array('exam_student_performance_id' =>'desc'));
					
		$arrProcInq = $this->paginate();
		//print("<pre>");
		//print_r($this->paginate());
		//exit;
		if(is_array($arrProcInq) && (count($arrProcInq)>0))
		{
			if($_GET['strExportType'] == "pdf")
			{
				$compPdf = $this->Components->load('Pdf'); //load it
				$arrHeader = array('First Name','Last Name','Class','Section','Exam','subject','Mark');
				$arrPdfCreated = $compPdf->fnStudentResultsPreparePdf($arrHeader,$arrProcInq);
				//print("<pre>");
				//print_r($arrPdfCreated);
				//exit;
				
				if($arrPdfCreated['status'] == "success")
				{
					$arrResponse = $arrPdfCreated;
					$arrResponse['message'] = "File exported successfully ";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "Some error, Please try again";
				}
			}
			else
			{
				$compPdf = $this->Components->load('Excel'); //load it
				$arrHeader = array('First Name','Last Name','Class','Section','Exam','subject','Mark');
				$arrPdfCreated = $compPdf->fnStudentResultsPreparePdf($arrHeader,$arrProcInq);
				//print("<pre>");
				//print_r($arrPdfCreated);
				//exit;
				
				if($arrPdfCreated['status'] == "success")
				{
					$arrResponse = $arrPdfCreated;
					$arrResponse['message'] = "File exported successfully ";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "Some error, Please try again";
				}
			}
		} else {
		  $arrResponse['status'] = "fail";
		  $arrResponse['message'] = "Some error, Please try again";
		}
		return json_encode($arrResponse);
		exit;
	}
	public function exportlistingpdf()
	{
		Configure::write('debug','2');
		//$arrLoggedUser = $this->Auth->user();
		$arrResponse = array();
		$this->layout = NULL;
		$this->autoRender = false;
		$arrConditions = array();
		$compStudents = $this->Components->load('Marksheet');
		/*$arrLoggedUser = $this->Auth->user();       
		$schoolcode = $arrLoggedUser['school_code'];*/
        if($_GET['exam'])
		{
			$arrConditions['Studentexamresult.exam_id'] = $_GET['exam'];
		}
		
		if($_GET['student_class'])
		{
			$arrConditions['class'] = $_GET['student_class'];
		}
		
		if($_GET['division'])
		{
			$arrConditions['section'] = $_GET['division'];
		}
		//$arrProcInq = $compStudents->fnGetAllMarksheetData1($arrConditions);
		$arrProcInq = $compStudents->fnGetMarksheetSearchData($arrConditions);
		//print("<pre>");
		//print_r($arrProcInq);
		//exit;
		if(is_array($arrProcInq) && (count($arrProcInq)>0))
		{
			if($_GET['strExportType'] == "pdf")
			{
				$compPdf = $this->Components->load('Pdf'); //load it
				$arrHeader = array('First Name','Last Name','Class','Section','Exam','Total Mark');
				$arrPdfCreated = $compPdf->fnResultsPreparePdf($arrHeader,$arrProcInq);
				//print("<pre>");
				//print_r($arrPdfCreated);
				//exit;
				
				if($arrPdfCreated['status'] == "success")
				{
					$arrResponse = $arrPdfCreated;
					$arrResponse['message'] = "File exported successfully ";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "Some error, Please try again";
				}
			}
			else
			{
				$compPdf = $this->Components->load('Excel'); //load it
				$arrHeader = array('First Name','Last Name','Class','Section','Exam','Total Mark');
				$arrPdfCreated = $compPdf->fnResultsPreparePdf($arrHeader,$arrProcInq);
				//print("<pre>");
				//print_r($arrPdfCreated);
				//exit;
				
				if($arrPdfCreated['status'] == "success")
				{
					$arrResponse = $arrPdfCreated;
					$arrResponse['message'] = "File exported successfully ";
				}
				else
				{
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = "Some error, Please try again";
				}
			}
		} else {
		  $arrResponse['status'] = "fail";
		  $arrResponse['message'] = "Some error, Please try again";
		}
		return json_encode($arrResponse);
		exit;
	}
	
	public function search($strExam = "",$strClass = "",$strDiv = "")
	{
		$this->layout = "newadmin";
		//Configure::write('debug',2);
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/marksheet_index.js').'"></script>';
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$arrConditions = array();
		if($this->request->is('Post'))
		{
			if($this->request->data['delete'])
			{
				$this->request->data['uniqueid'] = "";
				
				$arrStudentsToDelete = $this->request->data['vehicle'];
				//print("<pre>");
				//print_r($arrStudentsToDelete);
				//exit;
				
				if(is_array($arrStudentsToDelete) && (count($arrStudentsToDelete)>0))
				{
					$compStudents = $this->Components->load('Marksheet');
					$intDeleted = "";
					foreach($arrStudentsToDelete as $intDeleteVal)
					{
						//$arrDeleted = $compStudents->fnDeleteStudent($intDeleteVal);
						$intVal = explode(',',$intDeleteVal);
					
						$arrDeleted = $compStudents->fndeleteStudentSubjectMarks($intVal[0],$intVal[1]);
						if($arrDeleted['status'] == "success")
						{
							$intDeleted = "1";
						}
					}
					if($intDeleted)
					{
						$arrUpdateStudent['message'] = "Record Deleted Successfully.";
						$this->set("arrUpdateStudent",$arrUpdateStudent);
					}
				}
				else
				{
					$arrUpdateStudent['message'] = "Nothing provided to delete.";
					$this->set("arrUpdateStudent",$arrUpdateStudent);
				}
			}
			else
			{
				$strName = 0;
				$strExam = 0;
				$strClass = 0;
				$strDiv = 0;
				$strSubject = 0;
				/*if($this->request->data['name'])
				{
					$strName = $this->request->data['name'];
				}*/
				if($this->request->data['exam'])
				{
					$strExam = $this->request->data['exam'];
				}
				if($this->request->data['classes'])
				{
					$strClass = trim(urlencode($this->request->data['classes']));
				}
				if($this->request->data['division'])
				{
					$strDiv = trim(urlencode($this->request->data['division']));
				}
				/*if($this->request->data['subjects'])
				{
					$strSubject = $this->request->data['subjects'];
				}*/
				//echo "--".$strExam;
				//echo "--".$strClass;
				//echo "--".$strDiv;
				//echo "--".$strSubject;
			//	exit;
				if( $strExam =="0" && $strClass == "0" && $strDiv =="0" ){
					$this->redirect(array('controller'=>'results','action'=>'marksheets'));
				}
				else{
					$this->redirect(array('controller'=>'results','action'=>'search',$strExam,$strClass,$strDiv));
				}
			}
		}
		
		/*if($strName)
		{
			$arrConditions['student_fname'] = trim(urldecode($strName));
		}*/
		if($strExam)
		{
			$arrConditions['Studentexamresult.exam_id'] = $strExam;
		}
		
		if($strClass)
		{
			$arrConditions['class'] = trim(urldecode($strClass));
		}
		
		if($strDiv)
		{
			$arrConditions['section'] = trim(urldecode($strDiv));
		}
		
		/*if($strSubject)
		{
			$arrConditions['subject'] = $strSubject;
		}*/
		
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		$modelExamDetails = ClassRegistry::init('ExamDetails');
		$arrADetail = $modelExamDetails->find('all',array('fields'=>array('SUM(  exam_total_marks)','exam_id','class.class_name'),'joins' => array(array('alias' => 'class','table' => 'class','type' => 'INNER','conditions' => '`class`.`class_id` = `ExamDetails`.`class_id`')),'group' =>'exam_id'));
		
		if(is_array($arrConditions) && (count($arrConditions)>0))
		{
			$arrProcInq = $compStudents->fnGetMarksheetSearchData($arrConditions);
		}
		else
		{

			$arrProcInq = $compStudents->fnGetMarksheetData();
		}
		$this->set("exam_id",$strExam);
		$this->set("class_name",$strClass);
		$this->set("division_name",$strDiv);
		
						$result = $arrProcInq;
					
	foreach($arrADetail as $row)
		{	$i =0;			
			foreach($result as $val)
			{
				if($val['Studentexamresult']['exam_id'] == $row['ExamDetails']['exam_id'] && $val['student']['class'] == $row['class']['class_name'])
				{
					$result[$i]['exam'] ['exam_total'] = $row[0]['SUM(  exam_total_marks)'];
				}
				
				$i++;
			}			
		}	
		$this->set( 'arrProcInq',$result);
		
		//$this->set("arrProcInq",$arrProcInq);
		//echo '<pre>';print_r($result);exit();
		$this->loadModel('Exams');
		$arrExams = $this->Exams->find('all');

		$this->loadModel('Classes');
		$arrClasses = $this->Classes->find('all');
		
		$this->loadModel('Divisions');
		$arrDiv = $this->Divisions->find('all');

		$this->loadModel('Subjects');
		$arrSubjects = $this->Subjects->find('all');

		//print("<pre>");
		//print_r($arrDiv);
		//exit;
		$this->set("arrExams",$arrExams);
		$this->set("arrClasses",$arrClasses);
		$this->set("arrSubjects",$arrSubjects);
		$this->set("arrDiv",$arrDiv);
		$this->set("arrConditions",$arrConditions);
	}
	
	public function marksheetfile()
	{
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/marksheet_file_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		if($this->request->is('Post'))
		{
			if($this->request->data['delete'])
			{
				$this->request->data['uniqueid'] = "";
				
				$arrStudentsToDelete = $this->request->data['vehicle'];
				//print("<pre>");
				//print_r($arrStudentsToDelete);
				//exit;
				
				if(is_array($arrStudentsToDelete) && (count($arrStudentsToDelete)>0))
				{
					$compStudents = $this->Components->load('Marksheet');
					$intDeleted = "";
					foreach($arrStudentsToDelete as $intDeleteVal)
					{
						$arrDeleted = $compStudents->fnDeleteMarkSheetFile($intDeleteVal);
						if($arrDeleted['status'] == "success")
						{
							$intDeleted = "1";
						}
					}
					if($intDeleted)
					{
						$arrUpdateStudent['message'] = "Record Deleted Successfully.";
						$this->set("arrUpdateStudent",$arrUpdateStudent);
					}
				}
				else
				{
					$arrUpdateStudent['message'] = "Nothing provided to delete.";
					$this->set("arrUpdateStudent",$arrUpdateStudent);
				}
			}
			else
			{
				$strFileName = 0;
				
				if($this->request->data['file_name'])
				{
					$strFileName = $this->request->data['file_name'];
				}
				$this->redirect(array('controller'=>'results','action'=>'searchfile',$strFileName));
			}
		}
		
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		$arrProcInq = $compStudents->fnGetMarksheetFile();
		//print("<pre>");
		//print_r($arrProcInq);
		//exit;
		$this->set("arrProcInq",$arrProcInq);
	}
	
	public function marksheets()
	{
		//Configure::write('debug', 2);
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/marksheet_index.js').'"></script>';
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		if($this->request->is('Post'))
		{
			if($this->request->data['delete'])
			{
				$this->request->data['uniqueid'] = "";
				
				$arrStudentsToDelete = $this->request->data['vehicle'];
				//print("<pre>");
				//print_r($arrStudentsToDelete);
				//exit;
				
				if(is_array($arrStudentsToDelete) && (count($arrStudentsToDelete)>0))
				{
					$compStudents = $this->Components->load('Marksheet');
					$intDeleted = "";
					foreach($arrStudentsToDelete as $intDeleteVal)
					{
						//$arrDeleted = $compStudents->fnDeleteStudent($intDeleteVal);
						$intVal = explode(',',$intDeleteVal);
					
						$arrDeleted = $compStudents->fndeleteStudentSubjectMarks($intVal[0],$intVal[1]);
						if($arrDeleted['status'] == "success")
						{
							$intDeleted = "1";
						}
					}
					if($intDeleted)
					{
						$arrUpdateStudent['message'] = "Record Deleted Successfully.";
						$this->set("arrUpdateStudent",$arrUpdateStudent);
					}
				}
				else
				{
					$arrUpdateStudent['message'] = "Nothing provided to delete.";
					$this->set("arrUpdateStudent",$arrUpdateStudent);
				}
			}
			else
			{
				$strName  = 0;
				$strExam = 0;
				$strClass = 0;
				$strDiv = 0;
				$strSubject = 0;
				/*if($this->request->data['name'])
				{
					$strName = $this->request->data['name'];
				}*/
				if($this->request->data['exam'])
				{
					$strExam = $this->request->data['exam'];
				}
				if($this->request->data['classes'])
				{
					$strClass = trim(urlencode($this->request->data['classes']));
				}
				if($this->request->data['division'])
				{
					$strDiv = trim(urlencode($this->request->data['division']));
				}
				/*if($this->request->data['subjects'])
				{
					$strSubject = $this->request->data['subjects'];
				}*/
				/*echo "--".$strExam;
				echo "--".$strClass;
				echo "--".$strDiv;
				echo "--".$strSubject;exit;*/
				$this->redirect(array('controller'=>'results','action'=>'search',$strExam,$strClass,$strDiv));
			}
		}
		
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		//$arrProcInq = $compStudents->fnGetMarksheetData();
		//$arrProcInq = $compStudents->getresult();
		$modelExamDetails = ClassRegistry::init('ExamDetails');
		$arrADetail = $modelExamDetails->find('all',array('fields'=>array('SUM(  exam_total_marks)','exam_id','class.class_name'),'joins' => array(array('alias' => 'class','table' => 'class','type' => 'INNER','conditions' => '`class`.`class_id` = `ExamDetails`.`class_id`')),'group' =>'exam_id'));
		//print("<pre>");
		//print_r($arrADetail);//exit();
		//return $arrADetail;
		$this->paginate = array(
					'fields' => array('Result.exam_student_performance_id','Result.exam_id' ,'SUM(Result.student_mark)','student.student_fname','student.student_lname','student.class','student.section','student.student_unique_id','exam.exam_name'),
				    'joins' => array(array('alias' => 'student','table' => 'student','type' => 'INNER','conditions' => '`Result`.`student_id` = `student`.`student_unique_id`'),array('alias' => 'exam','table' => 'exam','type' => 'INNER','conditions' => '`Result`.`exam_id` = `exam`.`exam_id`')),
					'conditions' => '', 
					'group' =>'Result.student_id,Result.exam_id',
					'order' => array('exam_student_performance_id' =>'desc'),
					'limit' => 20);
					$result = $this->paginate();
					
	foreach($arrADetail as $row)
		{	$i =0;			
			foreach($result as $val)
			{
				if($val['Result']['exam_id'] == $row['ExamDetails']['exam_id'] && $val['student']['class'] == $row['class']['class_name'])
				{
					$result[$i]['exam'] ['exam_total'] = $row[0]['SUM(  exam_total_marks)'];
				}
				
				$i++;
			}			
		}	
		$this->set( 'arrProcInq',$result);
		
		//$this->set("arrProcInq",$arrProcInq);
		//print("<pre>");
		//print_r($result);
        //exit;
		$this->loadModel('Exams');
		$arrExams = $this->Exams->find('all');

		$this->loadModel('Classes');
		$arrClasses = $this->Classes->find('all');
		
		$this->loadModel('Divisions');
		$arrDiv = $this->Divisions->find('all');

		$this->loadModel('Subjects');
		$arrSubjects = $this->Subjects->find('all');

		//print("<pre>");
		//print_r($arrDiv);
		//exit;
		$this->set("arrExams",$arrExams);
		$this->set("arrClasses",$arrClasses);
		$this->set("arrSubjects",$arrSubjects);
		$this->set("arrDiv",$arrDiv);
	}
	//new functio for details about markesheet
	public function detailsmarksheets($examId,$studId)
	{
		//Configure::write('debug', 2);
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/marksheet_index.js').'"></script>';
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		//echo $examId;echo $studId;
		
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		//$conditions => array('Result.exam_id' => $examId,'Result.student_id' => $studId);
		$this->paginate = array(
					'fields' => array('Result.exam_student_performance_id','Result.exam_id' ,'subjects.subject_name','Result.student_mark','Result.subject_mark','student.student_fname','student.student_lname','student.class','student.section','student.student_unique_id','exam.exam_name'),
				    'joins' => array(array('alias' => 'student','table' => 'student','type' => 'INNER','conditions' => '`Result`.`student_id` = `student`.`student_unique_id`'),array('alias' => 'exam','table' => 'exam','type' => 'INNER','conditions' => '`Result`.`exam_id` = `exam`.`exam_id`'),array('alias' => 'subjects','table' => 'subjects','type' => 'INNER','conditions' => '`Result`.`subject_id` = `subjects`.`subject_id`')),
					'conditions' => array('Result.exam_id' => $examId,'student.student_unique_id'=>$studId),
					'order' => array('exam_student_performance_id' =>'desc'));
					
		$modelExamDetails = ClassRegistry::init('ExamDetails');
		$arrADetail = $modelExamDetails->find('all',array('fields'=>array('  exam_total_marks','subject_id','exam_student_performance.exam_id','exam_student_performance.student_id'),'joins' => array(array('alias' => 'exam_student_performance','table' => 'exam_student_performance','type' => 'INNER','conditions' => '`exam_student_performance`.`exam_id` = `ExamDetails`.`exam_id`')),'conditions' => array('exam_student_performance.exam_id' => $examId,'exam_student_performance.student_id'=>$studId)));	
		//echo '<pre>';print_r($arrADetail);exit();
		$this->set( 'arrProcInq', $this->paginate() );
		//echo '<pre>';print_r($this->paginate());exit();
		$this->loadModel('Exams');
		$arrExams = $this->Exams->find('all');

		$this->loadModel('Classes');
		$arrClasses = $this->Classes->find('all');
		
		$this->loadModel('Divisions');
		$arrDiv = $this->Divisions->find('all');

		$this->loadModel('Subjects');
		$arrSubjects = $this->Subjects->find('all');

		//print("<pre>");
		//print_r($arrDiv);
		//exit;
		$this->set("arrExams",$arrExams);
		$this->set("arrClasses",$arrClasses);
		$this->set("arrSubjects",$arrSubjects);
		$this->set("arrDiv",$arrDiv);
	}
	public function importer($intMarsheetId = "")
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		$compMarksheet = $this->Components->load('Marksheetimport'); //load it
		$arrReponse = $compMarksheet->fnImportMarkSheet($intMarsheetId);
		
		echo json_encode($arrReponse);
		exit;
		
		
	}
	
	public function logparser()
	{
		$this->layout = NULL;
		$this->autoRender = FALSE;
		
		//$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		//$this->set('strActionScript',$strActionScript);
		if($this->request->is('post'))
		{
			if(is_array($_FILES) && (count($_FILES)>0))
			{
				$arrImageAllowedExtension = array('jpg','exe','doc','docx','xls','xlsx','bmp','png','gif','txt');
				
				if($_FILES['portal_logo']['name'] != "")
				{
					//echo "File present";exit;
					$strFileExt = pathinfo($_FILES['portal_logo']['name'], PATHINFO_EXTENSION);
					if(in_array($strFileExt,$arrImageAllowedExtension))
					{
						
						$arrResponse = array();
						$arrResponse['status'] = "failure";
						$arrResponse['message'] = 'Incorrect File Format';
						
						echo json_encode($arrResponse);
					}
					else
					{
					
						
						$this->loadModel("Marksheetfile");
						$strFileName = $_FILES['portal_logo']['name'];
						$isImportFilePresent = $this->Marksheetfile->find('count',array('conditions'=>array('file_name'=>$strFileName)));
						
						if($isImportFilePresent)
						{
							// break saying the the file is already present
							$arrResponse = array();
							$arrResponse['status'] = "fail";
							$arrResponse['message'] = "This File has already been imported";
							echo json_encode($arrResponse);
						}
						else
						{
							//print("<pre>");
							//print_r($arrFileNameParts);
							//exit;

							$arrFileImportData['Marksheetfile']['file_name'] = $strFileName;
							$arrFileImportData['Marksheetfile']['created_date'] = date('Y-m-d h:i:s');
							//print("<pre>");
							//print_r($arrFileImportData);
							
							$isFileCreatedId = $this->Marksheetfile->save($arrFileImportData);
							if($isFileCreatedId)
							{
								$strFileCreatedId = $this->Marksheetfile->getLastInsertID();
								$intFileUploaded = move_uploaded_file($_FILES['portal_logo']['tmp_name'], WWW_ROOT . 'logfiletoimport/' .$_FILES['portal_logo']['name']);
								/*$boolUpdated = $this->Portal->updateAll(
										array('Portal.career_portal_name'=>"'".$strPortalName."'",'Portal.career_portal_thumb_logo'=>"'".$strPortalNewThumbLogoName."'",'Portal.career_portal_logo'=>"'".$strPortalNewLogoName."'"),
										array('Portal.career_portal_id =' => $intPortalId)
									);*/
								//if($intFileUploaded)
								//{
									//$this->set('strMessage',$strMessage);
									
									$arrResponse = array();
									$arrResponse['status'] = "success";
									$arrResponse['message'] = 'File Uploaded Successfully, you can go to the listing page and start import';
									$arrResponse['filecreatedid'] = $strFileCreatedId;
									echo json_encode($arrResponse);
							}
							else
							{
								$arrResponse = array();
								$arrResponse['status'] = "fail";
								$arrResponse['message'] = "Please try again, some technical issue";
								echo json_encode($arrResponse);
							}
						}
					}
				}
				else
				{
					//echo "File not present";exit;
					$arrResponse['status'] = "fail";
					$arrResponse['message'] = 'Please Provide the File to Import';
					echo json_encode($arrResponse);
				}
			}
			exit;
		}
		exit;
	}
	
	public function create()
	{
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/add_product.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js').'"></script>';

		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/tmpl.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/load-image.all.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/canvas-to-blob.min.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js').'"></script>';
		//$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/main.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/jquery.validationEngine.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		if($this->request->is('post'))
		{
			//print("<pre>");
			//print_r($this->request->data);
			//exit;
			$arrAlbumDetail = array();
			$arrAlbumDetail['Album']['album_title'] = $this->request->data['album_name'];
			$arrAlbumDetail['Album']['album_description'] = $this->request->data['album_description'];
			$arrAlbumDetail['Album']['album_cover_pic'] = $this->request->data['featured_image_id'];
			$compAlbums = $this->Components->load('Albums'); //load it
			$arrSavedAlbum = $compAlbums->fnCreateAlbum($arrAlbumDetail);
			$this->set("arrAddNotification",$arrSavedAlbum);
		}
	}
	
	public function mediauploader($isServiceImage = "")
	{
		$arrResponse = array();
		$this->autoRender = false;
		// code to get the html content
		$view = new View($this, false);
		if($isServiceImage)
		{
			$view->set('forService',$isServiceImage);
		}
		
		$strMediaUploaderHtml = $view->element('mediaselector', $params);
		//$view->render('testlogin');
		//echo $strLoginHtml;exit;
		if($strMediaUploaderHtml)
		{
			$arrResponse['status'] = "success";
			$arrResponse['content'] = $strMediaUploaderHtml;
		}
		else
		{
			$arrResponse['status'] = "fail";
		}
		echo json_encode($arrResponse);
		exit;
	}
	
	public function index()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/add_product.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/vendor/jquery.ui.widget.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/tmpl.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/load-image.all.min.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/canvas-to-blob.min.js').'"></script>';
		//$strActionScript .= '<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.iframe-transport.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-process.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-image.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-audio.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-video.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-validate.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-ui.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/fileuploaderjs/jquery.fileupload-jquery-ui.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$compAlbums = $this->Components->load('Albums'); //load it
		$arrProcInq = array();		
		$arrProcInq = $compAlbums->fnGetAlbum();
		//print("<pre>");
		//print_r($arrProcInq);
		//exit;
		
		$arrNotificationTypeListId = array();	
		$arrNotificationTypeListId=$arrProcInq;
		$this->set("arrProcInq",$arrProcInq);	
	}
	
	public function show()
	{
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$compNotifications = $this->Components->load('Notifications'); //load it
		$compNotification_types = $this->Components->load('Notification_types'); //load it
		$arrProcInq = array();		
		$arrProcInq = $compNotifications->fnGetNotifications();
		$arrNotificationTypeListId = array();	
		$arrNotificationTypeListId=$arrProcInq;
		$this->set("arrProcInq",$arrProcInq);	
		
	}
	
	public function test()
	{
		$compNotifications = $this->Components->load('Notifications'); //load it
		$arrProDetail['Notification']['NotificationSection'] = "All";
		$arrProDetail['Notification']['NotificationClass'] = "Jr Kg";
		$arrNotificationList = $compNotifications->fnSendNotifications("1");
		
		print("<pre>");
		print_r($arrNotificationList);
		exit;
	}
	public function marksheetsend($intFunId = "")
	{
		//Configure::write('debug','2');
		//$fh = fopen("text.txt","w");
		//fwrite($fh,"test ".$intNotificationId);
		//fclose($fh);
		
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$compNotifications = $this->Components->load('Marksheetimport'); //load it
		//$fh = fopen("check.txt","a");
		//fwrite($fh,"---".$intNotificationId);
		//fclose($fh);
		$arrNotificationsSent = $compNotifications->fnNotifyHomework($intFunId);
	}
	public function send($intNotificationId = "")
	{
		//$fh = fopen("text.txt","w");
		//fwrite($fh,"test ".$intNotificationId);
		//fclose($fh);
		
		$this->layout = NULL;
		$this->autoRender = false;
		$arrResponse = array();
		$compNotifications = $this->Components->load('Notifications'); //load it
		
		$arrNotificationsSent = $compNotifications->fnSendNotifications($intNotificationId);
		
		
	}
	
	//function  for delete album gallery images
	public function deleteImage($intAlbumId)
	{
		$this->autoRender = False;
		$this->layout = NULL;
		$compStudents = $this->Components->load('Albums'); //load it
		$arrAlbumPicDeleted =  $compStudents->fnDeleteAlbumPic($intAlbumId);		
		echo json_encode($arrAlbumPicDeleted);
		exit;
	}
	
	//function to add new 
	public function add()
	{
		$compNotifications = $this->Components->load('Notifications'); //load it
		$arrProcInq = array();
		if($this->request->is('post')) 
		{ 
			$arrProDetail= array();
			$arrProDetail['Notification']['notificationTitle'] = addslashes($this->request->data['Notification']['notificationTitle']);
			$arrProDetail['Notification']['notificationDesc'] = addslashes($this->request->data['Notification']['notificationDesc']);
			$arrProDetail['Notification']['notificationType'] = addslashes($this->request->data['Notification']['notificationType']);
			$arrProDetail['Notification']['notificationClass'] = addslashes($this->request->data['Notification']['NotificationClass']);
			$arrProDetail['Notification']['notificationSection'] = addslashes($this->request->data['Notification']['NotificationSection']);
			$arrAddNotification = $compNotifications->fnAddNotification($arrProDetail);
			$this->set("arrAddNotification",$arrAddNotification);
			//print_r($arrUpdateStudent);
		}
		$arrAddNotification = $compNotifications->fnGetNotificationType();
		$this->set("arrNotificationTypeListing",$arrAddNotification);
	}
	//function to view album
	public function detail($intAlbumId ="")
	{
		if($intAlbumId)
		{
			$compAlbum = $this->Components->load('Albums');
			$arrProcInq = $compAlbum->fnGetAlbum($intAlbumId);		
			$this->set("arrayAlbumdetail",$arrProcInq);	
			
			// load image
			$arrAlbumpicInq = $compAlbum->fnGetAlbumPic($intAlbumId);		
			$this->set("arrayAlbumPicdetail",$arrAlbumpicInq);	
		}
	}
	//function for edit album
	
	public function edit($intStudentPerId)
	{
		$this->layout = "newadmin";		
		//Configure::write('debug',2);
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/jquery.validationEngine.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		
		$compMarks = $this->Components->load('Marksheet'); //load it
		$arrProcInq = array();
		if($this->request->is('post'))
		{
			
			$arrResultDetail = array();
			$arrResultDetail['Studentexamperformance']['student_mark'] = $this->request->data['mark'];
			$arrProcInq = $compMarks->fnEditStudentExamMark($arrResultDetail,$intStudentPerId);
			//$this->set("arrayAlbumEdit",$arrProcInq);
			$_SESSION['message'] = $arrProcInq['message'];
			$this->redirect(array('controller'=>'results','action'=>'edit',$intStudentPerId));
		}
		$arrConditions = array();
		$arrConditions['exam_student_performance_id'] = $intStudentPerId;
		$arrProcInq = $compMarks->fnGetAllMarksheetData1($arrConditions);		
		$this->set("arrProcInq",$arrProcInq);
		//print("<pre>");
		//print_r($arrProcInq);
		//exit;
	}
	public function deleteStudentSubjectMarks($intStudId,$intExamId)
	{
		$this->autoRender = False;
		$this->layout = NULL;
		$compStudents = $this->Components->load('Marksheet'); //load it
		
		$arrStudentDeleted =  $compStudents->fndeleteStudentSubjectMarks($intStudId,$intExamId);
		
		echo json_encode($arrStudentDeleted);
		exit;
	}
		public function deleteIndiStudentSubjectMarks($intProductId)
	{
		$this->autoRender = False;
		$this->layout = NULL;
		$compStudents = $this->Components->load('Marksheet'); //load it
		$arrStudentDeleted =  $compStudents->fndeleteIndiStudentSubjectMarks($intProductId);
		
		echo json_encode($arrStudentDeleted);
		exit;
	}
	
	//add marks for particular exams classwise
	public function addmarks()
	{
		//Configure::write('debug', 2);
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/commonjs.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/call_commonfn.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/jquery.validationEngine.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		if($this->request->is('Post'))
		{
				
				$classId = $_POST['class'];
				$secId = $_POST['section'];
				$examId = $_POST['exam'];
				$this->autoRender = False;
				$this->layout = NULL;
				$compStudents = $this->Components->load('Marksheet'); //load it
				$arrExamClassList =  $compStudents->fngetExamClassList($classId,$secId,$examId);
				//echo '<pre>';print_r($arrExamClassList);exit();
				if($arrExamClassList['status'] =='fail')
				{
					$_SESSION['message'] = $arrExamClassList['message'];
					$this->redirect(array('controller'=>'results','action'=>'addmarks'));
				}
				else{
					
					$this->redirect(array('controller'=>'results','action'=>'addstudentmarks',$classId,$secId));
				}
													
			
		}
		$this->loadModel('Exams');
		$arrExams = $this->Exams->find('all');
		$this->set("arrExams",$arrExams);
	}
	public function getExamClassList()
	{
		//Configure::write('debug', 2);
		if($this->request->data)
			{
				$classId = $_POST['class'];
				$secId = $_POST['section'];
				$examId = $_POST['exam'];
				$this->autoRender = False;
				$this->layout = NULL;
				$compStudents = $this->Components->load('Marksheet'); //load it
				$arrExamClassList =  $compStudents->fngetExamClassList($classId,$secId,$examId);
				//echo '<pre>';print_r($arrExamClassList);exit();
				if($arrExamClassList['status'] =='fail')
				{
					$_SESSION['message'] = $arrExamClassList['message'];
					$this->redirect(array('controller'=>'results','action'=>'addmarks'));
				}
				else{
					
					$this->redirect(array('controller'=>'results','action'=>'addstudentmarks','?' =>array('class'=>$classId,'sec'=>$secId,'exam'=>$examId)));
				}
			}
			else{
				$_SESSION['message'] = "Some technical error...please try again";
			}
		
	}
	//add marks for particular exams classwise
	public function addstudentmarks()
	{
		//Configure::write('debug', 2);
		$this->layout = "newadmin";
		$strActionScript = '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.form.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/student_index.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/commonjs.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/call_commonfn.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/validationplugin/validationengine/js/jquery.validationEngine.js').'"></script>';
		$strActionScript .= '<script type="text/javascript" src="'.Router::url('/js/jquery/jquery.tablesorter.js').'"></script>';
		$this->set('strActionScript',$strActionScript);
		$classId = $_GET['class']; $secId = $_GET['sec'];
		$examId = $_GET['exam'];//exit();
		if($classId)
		{
			$arrConditionsArray['class'] = $classId;
		}
		if($secId)
		{
			$arrConditionsArray['section'] = $secId;
		}	
		$compStudents = $this->Components->load('Students'); //load it
		$arrProcInq = array();
		$arrProcInq = $compStudents->fnGetStudentsSearch($arrConditionsArray);
		$this->set('arrProcInq',$arrProcInq);
		$compCreateSchedule = $this->Components->load('Exams');
		
		//$arrSubjectInq = $compCreateSchedule->fnGetSubjectFromClass($classId);
		$arrSubjectInq = $compCreateSchedule->fnGetExamDetails($examId);		
		$this->set("array_subject_Detail",$arrSubjectInq);
		//echo '<pre>';print_r($arrProcInq);
		//echo '<pre>';print_r($arrSubjectInq);
		foreach($arrProcInq as $stud)
		{
			//echo $stud['Students']['student_unique_id'];
			$modelResult = ClassRegistry::init('Result'); //load it
			$isRecorde[] = $modelResult->find('all',array('conditions'=>array('exam_id'=>$examId,'student_id'=>$stud['Students']['student_unique_id'])));
			
		}
		$modelExam = ClassRegistry::init('Result');
		if($this->request->is('post'))
		{
			//echo '<pre>';print_r($_POST);
			foreach($_POST as $k=>$v){
				if($v != '' && $v != 'Save')
				{
					$values = explode("_",$k); 
					$isRecordeExist = $modelExam->find('count',array('conditions'=>array('exam_id'=>$examId,'student_id'=>$values[1],'subject_id'=>$values[2])));
					if($isRecordeExist)
					{
						$modelExam->updateAll(array('student_mark'=>"'".$v."'"),array('exam_id' => $examId,'student_id'=>$values[1],'subject_id'=>$values[2]));
						if($modelExam)
						{
							$_SESSION['message'] = "Students Marks Updated Successfully";
						}
						else
						{
							$_SESSION['message'] = "Some technical error...please try again";
						}
					}
					else
					{		
						
						$arrExam['Result']['exam_id'] = $examId;
						$arrExam['Result']['student_id'] = $values[1];
						$arrExam['Result']['subject_id'] = $values[2];
						$arrExam['Result']['student_mark'] = $v;
						$arrExam['Result']['subject_mark'] = $values[3];
						$arrExam['Result']['enter_by'] = 'Admin';
						$modelExam->create(false);
						$arrImported = $modelExam->save($arrExam);
						
						if($arrImported)
						{
							$_SESSION['message'] = "Students Marks Added Successfully";
						}
						else
						{
							$_SESSION['message'] = "Some technical error...please try again";
						}
					}
					$students[] = $values[1];
					
				}
			}
			
			//notification for parent
			$compStudents = $this->Components->load('Students'); 			
			$arrNotificationData = array();
			$arrNotificationData['Notifications']['notfication_title'] ="Student Marks Added";
				
			$arrNotificationData['Notifications']['notification_text'] ="Dear Parent, ".$arrSubjectInq[0][0]['exam']['exam_name']." marks has been published. Kindly check.";
			$arrNotificationData['Notifications']['notification_class'] = $classId;
			$arrNotificationData['Notifications']['notification_div'] = $secId;
			$arrNotificationData['Notifications']['push_notification_sent'] = '0';
			$arrNotificationData['Notifications']['notfication_type'] = '1';
			//echo '<pre>';	print_r($arrSubjectInq);print_r($arrNotificationData);exit();
			$arrHomeworkSaved = $compStudents->fnSaveNotification($arrNotificationData);
			$arrSavedNotification = $arrHomeworkSaved['data'];	
			//print_r(array_unique($students));exit();
			foreach(array_unique($students) as $stud)
			{
				
				$modelStudent = ClassRegistry::init('Parents');
				$student_id = $stud;
				$parent_detail = $modelStudent->find('all', array(
							'conditions' => array('student_id' => $student_id)
							));
					
				if($parent_detail)
				{
					$modelNotificationSend = ClassRegistry::init('Notificationsend');
					$arrNotificationSendDetails['Notificationsend']['notification_id'] =$arrSavedNotification['Notifications']['id'];
					$arrNotificationSendDetails['Notificationsend']['to_id'] = $parent_detail[0]['Parents']['parent_uname'];
					$arrNotificationSendDetails['Notificationsend']['to_type'] = 'parent';
					$modelNotificationSend->set($arrNotificationSendDetails);
					$modelNotificationSend->create(false);						
					$modelNotificationSend->save($arrNotificationSendDetails);
					
					$strDeviceToken = $parent_detail[0]['Parents']['device_token'];
					
					$strMessage = "Marks Notification: ".$arrSavedNotification['Notifications']['notfication_title']." was recently created";
				$modelPushnotification = $this->Components->load('Pushnotification'); 
					if($strDeviceToken)
						{
							$arrMessageSent = $modelPushnotification->fnSendPushNotification($strDeviceToken,$strMessage,'10');
							
						}
						$boolUpdated = $modelNotificationSend->updateAll(array('push_processed'=>"1"),array('notification_sent_id' => $modelNotificationSend->getLastInsertID()));	
				}
					
			}	
		}
		
	}
}