<?php
	class Serviceupdates extends AppModel 
	{
		public $name = 'Serviceupdates';
		public $useTable = 'order_service_updates';
		
		public $validate = array(
								'content_title' => array(
													'Not Empty' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Please provide the content title'
																		   )
												   ),
								/*'content' => array(
													'Not Empty' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Please provide content'
													)
												),*/
								'content_parent_id' => array(
													'Not Empty' => array(
																				'rule' => 'notEmpty',
																				'message' => 'Please provide parent content'
													)
												)
							 );
							 
		public function fnGetPublishedResources()
		{
			$strProductListQuery = "SELECT Resources.*,Vendorservice.* FROM products AS Resources,vendor_service AS Vendorservice WHERE Resources.product_publish_status = '1' AND Resources.productd_id = Vendorservice.service_id";
			//echo $strProductListQuery;exit;
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}
							 
		public function paginate($conditions, $fields, $order, $limit, $page = 1,$recursive = null, $extra = array()) 
		{
			// method content
			$recursive = -1;
			$this->useTable = false;
			/*print("<pre>");
			print_r($conditions);exit;*/
			$strProductListQueryStart = "SELECT *";
			$strProductListQueryFromcClause = " FROM vendor_service,vendors,products";
			$strProductListQuery = $strProductListQueryStart.$strProductListQueryFromcClause;
			if(is_array($conditions) && (count($conditions)>0))
			{
				$strProductListQueryWhereClause = " WHERE vendor_service.vendor_id = vendors.vendor_id AND products.productd_id = vendor_service.service_id";
				//$strProductListQueryWhereClause1 = " content.content_id=content_category_assignment.content_id";
				//$strProductListQueryWhereClause2 = " content.content_parent_id IS NULL";
				$strProductListQuery .= $strProductListQueryWhereClause;
				if(isset($conditions['category']))
				{
					if($conditions['No'])
					{
						if($conditions['No'] == "1")
						{
							$strProductListQueryWhereClause4 = " content.content_default_category != '".$conditions['category']."' AND job_search_process_content = '0'";
						}
						else
						{
							$strProductListQueryWhereClause4 = " content.content_default_category != '".$conditions['category']."' AND job_search_process_content = '1'";
						}
						
						
					}
					else
					{
						$strProductListQueryWhereClause4 = " content.content_default_category = '".$conditions['category']."'";
					}
					$strProductListQuery = $strProductListQuery.$strProductListQueryWhereClause4;
				}
				
				if($conditions['vendor_name'])
				{
					$strProductListQueryWhereClause3 = " AND vendors.vendor_name LIKE '%".$conditions['vendor_name']."%'";
					$strProductListQuery = $strProductListQuery.$strProductListQueryWhereClause3;
				}
			}
			$strProductListQuery .= " ORDER BY vendor_service_id ASC";
			$strProductListQuery .= " LIMIT ".(($page - 1) * $limit) . ', ' . $limit;
			//echo $strProductListQuery;exit;
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}

		public function paginateCount($conditions = null, $recursive = 0,$extra = array()) 
		{
			// method body
			$strProductListQueryStart = "SELECT *";
			$strProductListQueryFromcClause = " FROM vendor_service,vendors,products";
			$strProductListQuery = $strProductListQueryStart.$strProductListQueryFromcClause;
			if(is_array($conditions) && (count($conditions)>0))
			{
				$strProductListQueryWhereClause = " WHERE vendor_service.vendor_id = vendors.vendor_id AND products.productd_id = vendor_service.service_id";
				//$strProductListQueryWhereClause1 = " content.content_id=content_category_assignment.content_id";
				//$strProductListQueryWhereClause2 = " content.content_parent_id IS NULL";
				$strProductListQuery .= $strProductListQueryWhereClause;
				if(isset($conditions['category']))
				{
					if($conditions['No'])
					{
						if($conditions['No'] == "1")
						{
							$strProductListQueryWhereClause4 = " content.content_default_category != '".$conditions['category']."' AND job_search_process_content = '0'";
						}
						else
						{
							$strProductListQueryWhereClause4 = " content.content_default_category != '".$conditions['category']."' AND job_search_process_content = '1'";
						}
					}
					else
					{
						$strProductListQueryWhereClause4 = " content.content_default_category = '".$conditions['category']."'";
					}
					
					$strProductListQuery = $strProductListQuery.$strProductListQueryWhereClause4;
				}
				
				if($conditions['vendor_name'])
				{
					$strProductListQueryWhereClause3 = " AND vendors.vendor_name LIKE '%".$conditions['vendor_name']."%'";
					$strProductListQuery = $strProductListQuery.$strProductListQueryWhereClause3;
				}
				
				
			}
			$this->recursive = $recursive;
			//echo $strProductListQuery;exit;
			$arrProductContentArray = $this->query($strProductListQuery);
			return count($arrProductContentArray);
		}
		
		public function fnGetBrandedProductDetailsByNameO($strBrandName = "")
		{
			if($strBrandName)
			{
				$strProductListQuery = "SELECT content.content_id,content.content_title,content.content_name, content.content_intro_text,content_product_other_details.content_brand_title,content_product_other_details.content_brand_description FROM content, content_product_other_details WHERE content.content_status = 'published' AND content.content_title LIKE '".$strBrandName."%' AND content.content_is_branded = '1' AND content.content_default_category = '4' AND content.content_id = content_product_other_details.content_id ORDER BY content.content_title ASC";
				
				//echo $strProductListQuery;exit;
				$arrProductContentArray = $this->query($strProductListQuery);
				return $arrProductContentArray;
			}
			else
			{
				return false;
			}
		}
		
		public function fnGetBrandedProductDetailsByNameT($strBrandName = "")
		{
			if($strBrandName)
			{
				$strProductListQuery = "SELECT content.content_id,content.content_title,content.content_name, content.content_intro_text,content_product_other_details.content_brand_title,content_product_other_details.content_brand_description FROM content, content_product_other_details WHERE content.content_status = 'published' AND content.content_title LIKE '".$strBrandName."%' AND content.content_is_branded = '1' AND content.content_default_category = '4' AND content.content_id = content_product_other_details.content_id ORDER BY content.content_title ASC";
				
				//echo $strProductListQuery;exit;
				$arrProductContentArray = $this->query($strProductListQuery);
				return $arrProductContentArray;
			}
			else
			{
				return false;
			}
		}
		
		public function fnGetBrandedProductDetailsByName($strBrandName = "")
		{
			if($strBrandName)
			{
				$strProductListQuery = "SELECT content.content_id,content.content_title,content.content_name, content.content_intro_text,content_product_other_details.content_brand_title,content_product_other_details.content_brand_description FROM content, content_product_other_details WHERE content.content_status = 'published' AND content.content_title LIKE '".$strBrandName."%' AND content.content_is_branded = '1' AND content.content_default_category = '4' AND content.content_id = content_product_other_details.content_id ORDER BY content.content_title ASC";
				
				//echo $strProductListQuery;exit;
				$arrProductContentArray = $this->query($strProductListQuery);
				return $arrProductContentArray;
			}
			else
			{
				return false;
			}
		}
		
		public function fnGetBasicContactDetails($intProductId)
		{
			$strProductListQuery = "SELECT content.content_id,content.content_contact_form_title,content.content_contact_form_name, content.cont_contact_to,content.cont_contact_cc,cont_contact_bcc,content.cont_contact_subject,contact_address FROM content WHERE content.content_id='".$intProductId."'";
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}
		
		public function fnGetContentParentData($intProductId,$intCatuser)
		{
			$strProductListQuery = "SELECT content.content_id,content.content_parent_id FROM content WHERE content.content_id='".$intProductId."' AND content_for_user='".$intCatuser."'";
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}
		
		public function fnGetNewsContentForYear($strNewsYear = "")
		{
			if($strNewsYear)
			{
				$strContentAsPerDateQuery = "SELECT Content.content_id, Content.content_name, Content.content_intro_text, Content.content, Content.content_published_date FROM content AS Content, content_category,content_category_assignment WHERE Content.content_published_date >='".$strNewsYear."-01-01 00:00:00' AND Content.content_published_date <= '".$strNewsYear."-12-31 23:59:59' AND content_category_assignment.content_id = Content.content_id AND content_category.content_category_id = '3' AND content_category_assignment.category_id = content_category.content_category_id";
				$arrContentAsPerDate = $this->query($strContentAsPerDateQuery);
				return $arrContentAsPerDate;
			}
		}

		public function fnGetProductsFeaturedDetails($intProductId)
		{
			$strProductListQuery = "SELECT content.content_id,content.content_is_featured,content.content_featured_image,content_media.content_media_title FROM content LEFT JOIN content_media ON content_media.content_media_id = content.content_featured_image WHERE content.content_id='".$intProductId."'";
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}				 
							 
		public function fnGetBrandedProductDetails($intProductId)
		{
			$strProductListQuery = "SELECT content.content_id,content.content_is_branded FROM content WHERE content.content_id='".$intProductId."'";
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}
							 
							 
		public function fnGetProduct($intProductId)
		{
			$strProductListQuery = "SELECT content.content_id,content.content_title,content.content_type,content.content_for_user,content.content_name,content.content_intro_text,content.content_title_alias,content.content_status,content.content_layout,content.content_banner_image,content.content_intro_text,content.content,content.content_meta_title,content.content_meta_keyword,content.content_meta_description,content.content_meta_other,content.content_left_content,content.content_right_content,content.content_widget_assignment,content.content_left_widget_assignment,content.content_right_widget_assignment,content.content_related_products_assign,content.content_published_date,content_media.content_media_title FROM content LEFT JOIN content_media ON content_media.content_media_id = content.content_banner_image WHERE content.content_id='".$intProductId."'";
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}
		
		public function fnGetProductList()
		{
			$strProductListQuery = "SELECT content.content_id,content.content_title,content.content_status,content.created_date,content.modified_date FROM content,content_category_assignment WHERE content.content_id=content_category_assignment.content_id AND content_category_assignment.category_id = '4'";
			
			$arrProductContentArray = $this->query($strProductListQuery);
			return $arrProductContentArray;
		}
		
		
		public function fnFormatArray($arrToFormat = array(), $arrTobeFormattedFrom = array())
		{
			if(is_array($arrTobeFormattedFrom) && (count($arrTobeFormattedFrom)>0))
			{
				foreach($arrTobeFormattedFrom as $key=>$val)
				{
					$arrToFormat[0][$key] = $val;
				}
				
				return $arrToFormat;
			}
			else
			{
				return false;
			}
		
		}
							 
		public function fnGetContents()
		{
			$arrContentArray = $this->query("SELECT * FROM content WHERE content_type='Content'");
			return $arrContentArray;
	
		}
		public function fnGetPages()
		{
			$arrContentArray = $this->query("SELECT * FROM content WHERE content_type='Pages'");
			return $arrContentArray;
		}
		public function fnGetProductListForHomePage($cat="")
		{
				$strContentAsPerCatQuery = "SELECT DISTINCT content.content_id, content.content_name, content.content_title, content_category_assignment.category_id";
				if($cat=='')
				{
					$strContentAsPerCatQuery .=" FROM content_category_assignment INNER JOIN content ON content_category_assignment.content_id = content.content_id  AND content_category_assignment.category_id !=  '201' AND content_status='published' AND content_default_category='4' AND content_parent_id IS NULL";
				}
				else
				{
					$strContentAsPerCatQuery .=" FROM content
				INNER JOIN content_category_assignment ON content_category_assignment.content_id = content.content_id  AND content_category_assignment.category_id =  '201' AND content_status='published' AND content_default_category='4' AND content_parent_id IS NULL";
				}
				$strContentAsPerCatQuery .=" ORDER BY content.content_title";
				$strContentAsPerCat = $this->query($strContentAsPerCatQuery);
				return $strContentAsPerCat;
			
		}
		
		public function fnGetDistinctContentType($intCatId,$intContForUser = "3")
		{
			
			if($intCatId)
			{
				$strContentQuery =" SELECT DISTINCT(content.content_type) FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_category.content_category_id = '".$intCatId."' AND content_status = 'published' AND content_for_user = '".$intContForUser."' ORDER BY content.content_id ASC";
				//echo $strContentQuery;exit;
				$strContentAsPerCat = $this->query($strContentQuery);
				return $strContentAsPerCat;
				
			}
			else
			{
				$strContentQuery =" SELECT DISTINCT(content.content_type) FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_status = 'published' AND content_for_user = '".$intContForUser."' ORDER BY content.content_id ASC";
				//echo $strContentQuery;exit;
				$strContentAsPerCat = $this->query($strContentQuery);
				return $strContentAsPerCat;
			}
		}
		
		
		public function fnGetContentList($intCatId,$intContentType = "",$intContForUser = "3")
		{
			
			if($intCatId)
			{
				$strContentQuery =" SELECT content.*,content_category.* FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_category.content_category_id = '".$intCatId."'";
				if($intContentType)
				{
					$strContentQuery = $strContentQuery." "."AND content.content_type = '".$intContentType."'";
				}
				$strContentQuery = $strContentQuery." "."AND content_status = 'published' AND content_for_user = '".$intContForUser."' ORDER BY content.content_id ASC";
				//echo $strContentQuery;exit;
				$strContentAsPerCat = $this->query($strContentQuery);
				return $strContentAsPerCat;
				
			}
			else
			{
				$strContentQuery =" SELECT content.*,content_category.* FROM content,content_category,content_category_assignment WHERE content.content_id = content_category_assignment.content_id AND content_category.content_category_id = content_category_assignment.category_id AND content_status = 'published' AND content_for_user = '".$intContForUser."' ORDER BY content.content_id ASC";
				$strContentAsPerCat = $this->query($strContentQuery);
				return $strContentAsPerCat;
			}
		}
	}
?>