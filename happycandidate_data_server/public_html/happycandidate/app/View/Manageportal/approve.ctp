
 <div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="tab-header">
				<h1> Portal For  Approval</h1
			</div>
			<div class="tab-row-container ">			
			
			</div>
			<!-- USER RESUME TOP CONTROLS -->
			<div class="tab-row-container resourcetab">
				<div class="panel panel-default hidden-xs hidden-sm">
					<div class="panel-heading admin-content">
						<table>
							<tr>
								<th>SR. ID #</th>
								<th class="selected">Portal Name<span></span></th>
								<th>status</th>
								<th>Date Created</th>
								<th>Action</th>
							</tr>
						</table>
					</div>
					<div class="panel-body admin-content">
					<input type="hidden" id="contentName" value="approve" />
						<table>
							<?php
								if(is_array($arrProductList) && (count($arrProductList)>0))
								{
									$intContentCount = 0;
									foreach($arrProductList as $arrContent)
									{
										$intContentCount++;
										$strProductEditUrl = Router::url(array('controller'=>'manageportal','action'=>'edit',$arrContent['career_portal']['career_portal_id']),true);
										$strPreviewUrl =  Router::url('/', true)."portal/home/".$arrContent['career_portal']['career_portal_name'];

										
										
										?>
											<tr id="product_list_<?php echo $arrContent['career_portal']['career_portal_id'];?>">
											  <td><?php echo $intContentCount; ?></td>
											  <td>
												<div class="user-title">
													<a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['career_portal']['career_portal_name']); ?></a>
												</div>
											  </td>
												
											  <td id="status_<?php echo $arrContent['career_portal']['career_portal_id'];?>" data-attr="<?php echo $arrContent['career_portal']['career_portal_approved'];?>">

											  <?php 

											  if(($arrContent['career_portal']['career_portal_approved'])=="1")
											  {
											  	echo "Approved";
											  }
											  if(($arrContent['career_portal']['career_portal_approved'])=="2")
											  {
											  	echo "Rejected";
											  }

											  if(($arrContent['career_portal']['career_portal_approved'])=="0")
											  { 
													if(($arrContent['career_portal']['career_portal_published'])=="1"){
															echo "Published";
													   }else{
															echo "Unpublished";
													   }
													   
											  	
											  }
											  ?></td>

											  <td><?php echo date($productdateformat,strtotime($arrContent['career_portal']['career_portal_created_datetime'])) ?></td>
											  <td><a href="<?php echo $strPreviewUrl ?>" target="_blank" class="link-primary">Preview</a>&nbsp;|&nbsp;<a href="javascript:void(0);" id="content_status_<?php echo $arrContent['career_portal']['career_portal_id'];?>" onclick="return fnChangePortalStatus(this);" class="link-primary">Change Status</a> 
											  </td>
											</tr>
											<tr id="str<?php echo $arrContent['career_portal']['productd_id'];?>" class="hide-str">
												<td></td>
												<td colspan="4">
													
												</td>
											</tr>
										<?php
									}
								}
							?>
						</table>
					</div>
				</div>
				<div class="pagination pagination-large">
					<ul class="pagination">
							<?php
								echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
								echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
								echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
							?>
						</ul>
					</div>
				<!--<table class="table table-striped">
					<tr>
						<td colspan='6' align='left'>
							<?php
								//if($this->Paginator->hasPrev())
								//{
								//	echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));
								//}
							?>
							&nbsp;
							<?php 
							//	echo $this->Paginator->numbers(array('last' => 'Last page'));
							?>
							&nbsp;
							<?php
							//	if($this->Paginator->hasNext())
							//	{
							//		echo $this->Paginator->next(__('next').' >> ' , array(), null, array('class' => 'next disabled'));
							//	}
							?>
						</td>
					</tr>
				</table>-->
			</div>
		</div>
	</div>
</div>
