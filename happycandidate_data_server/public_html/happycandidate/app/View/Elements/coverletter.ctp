
						<div class="tab-header">
							<h3>Cover Letter</h3>
							<button class="btn btn-primary btn-sm" type="button"  onclick="return fnaddCoverForm(0);">Add New</button>
							<div id="alertcvMessage"></div>
						</div>

						
						
						<div class="tab-row-container">
							<div class="panel panel-default hidden-xs hidden-sm">
							  	<div class="panel-heading user-resume">
								<table>
										<tr>
											<th>Sr No.</th>
											<th>Name</th>
										<!--<th>Default</th>-->
											<th>Created</th>
											<th>Last Modified</th>
										
											
											
											
										</tr>
									</table>
							  	</div>
							 	<div class="panel-body user-references">
							 		<table>
									<?php
									
									if(count($arrCovervDetail)>0)
									{
									$count=0;
								foreach($arrCovervDetail as $coverDetail)
									{	$count++;
											$cover_id = $coverDetail['CandidateCoverDetail']['id'];	
											$cl_title = $coverDetail['CandidateCoverDetail']['cover_title'];		
											$cl_text = $coverDetail['CandidateCoverDetail']['cl_text'];	
												
											$created_at = $coverDetail['CandidateCoverDetail']['created_at'];	
											$modified_at = $coverDetail['CandidateCoverDetail']['modified_at'];
											$modified_at = date($productdateformatnew,strtotime($modified_at));
											//$created_at = date('Y-m-d',strtotime($created_at));
											$created_at = date($productdateformatnew,strtotime($coverDetail['CandidateCoverDetail']['created_at']));
											
											 $is_defult = $coverDetail['CandidateCoverDetail']['is_defult'];	
											
											
									?>
									
    <tr id="coverletter<?php echo $cover_id;?>">
	<td><?php echo $count;?></td>
	
		<td>
												<div class="user-title">
													<a href="#reference1-options<?php echo $count;?>" id="reference1" class="username-clickable"><?php echo $cl_title;?></a>
												</div>
												<div id="reference1-options<?php echo $count;?>" class="user-options">
													<a href="javascript:void(0);" onclick="return fnaddCoverForm('<?php echo $cover_id;?>');" >Edit</a> 
													
												<!--	<a href="{$BASE_URL}curriculum_vitae/copy/{$i.id}/?portid={$intPortId}" target="_self" 
                     onclick="return confirm_message('{lang mkey="copy_cv"}');">{lang mkey='account' skey='link_copy'}</a> |-->

					
					<?php if ($is_defult == "N") {?>
					| <a href="javascript:void(0);" onclick="return fnmakeDefaultCover('<?php echo $intPortalId;?>','<?php echo $cover_id;?>')" >Set as default</a> 
					<?php }?>
					
				
		| <a href="javascript:void(0);"
                    onclick="return deletecandidateCover('<?php echo $cover_id?>','<?php echo $intPortalId?>');">Delete</a>
					
					| <a href="javascript:void(0);"
                    onclick="return fnGetCoverletterView('<?php echo $cover_id?>');">Template</a>
		
				 
												</div>
											</td>
		
       <!--<td><?php if ($is_defult == "Y") {?> <img src="<?php echo Router::url('/', true);?>images/tick.gif" alt="" /><?php }?></td>-->
        <td><?php echo $created_at;?></td>
        <td><?php echo $modified_at;?></td>
        
      
		
										<tr>
										<?php
										}
									}?>
										
											
										
										
									
										
									</table>
								
							 	</div>
							
							</div>

					</div>
						

				

<script language="JavaScript" type="text/javascript">

$(".panel-body .user-title a").click(function(event) {
				$(this.getAttribute("href")).css('display', 'inline-block');
			});
			
		function fnaddCoverForm(id)
		{
			$('.cms-bgloader-mask').show();//show loader mask
	 	   $('.cms-bgloader').show(); //show loading image
			
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"candidates/getAddCoverform/"+intPortalId+"/"+id,
				dataType: 'json',
				data:"id="+id,
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#tab-coverletters').html(data.contactshtml);
					}
					else
					{
						alert("fail");
					}
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
			
				}
		});
	}
	
	function fnGetCoverletterView(intCoverId)
	{
		/*var favorite = [];
		var isChecked = "0";
		var intCheckedCnt = 0;
		$.each($("input[name='sport']:checked"), function(){            
			//alert($(this).val());
			favorite.push($(this).val());
			isChecked = "1";
			intCheckedCnt++;

		});*/
		isChecked = "1";
		if(isChecked == "1")
		{
			var intPortalId = "<?php echo $intPortalId; ?>";
			$('.cms-bgloader-mask').show();//show loader mask
			$('.cms-bgloader').show(); //show loading image
			$.ajax({ 
					type: "GET",
					url: strBaseUrl+"candidates/getreferencetemp/"+intPortalId+"/"+intCoverId,
					dataType: 'json',
					data:"",
					async:false,
					cache:false,
					success: function(data)
					{
						if(data.status == "success")
						{
							var strFname = data.filename;
							var strUrlTOpen = appBaseU+"candidate_cover_letter/"+strFname;
							window.open(strUrlTOpen);
						}
						else
						{
							alert(data.message);
						}
						
						$('.cms-bgloader-mask').hide();//show loader mask
						$('.cms-bgloader').hide(); //show loading image
					}
			});
		}
		else
		{
			alert("Please choose one of the cover letters from the list.");
		}
	}

</script>