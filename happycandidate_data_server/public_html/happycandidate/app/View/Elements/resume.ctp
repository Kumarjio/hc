<div class="tab-header">
    <h3>CV / Resume</h3>
    <button class="btn btn-primary btn-sm" type="button"  onclick="return fnaddCv();">Add New</button>
    <div id="alertcvMessage"></div>
</div>

<div class="tab-row-container">
    <div class="panel panel-default hidden-xs hidden-sm">
        <div class="panel-heading user-resume">
            <table>
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th class="selected">Advisor</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>CV / Resume View</th>
                    <th>Created</th>
                </tr>
            </table>
        </div>
        <div class="panel-body user-resume">
            <table>
                <?php
                if (count($arrCvDetail) > 0) {
                    $count = 0;
                    foreach ($arrCvDetail as $cvDetail) {
                        $strIntAdvisorUrl = Router::url(array('controller' => 'jsprocess', 'action' => 'advisor', $intPortalId, $seekerid, $cvDetail['Candidate_Cv']['candidatecv_id']), true);
                        $count++;
                        $cv_id = $cvDetail['Candidate_Cv']['candidatecv_id'];
                        $rtype = $cvDetail['Candidate_Cv']['mode'];
                        $cv_title = $cvDetail['Candidate_Cv']['resume_title'];
                        //$cv_description = $cvDetail['Candidate_Cv']['cv_description'];	
                        $cv_description = "asdad";
                        $cv_status = $cvDetail['Candidate_Cv']['status'];
                        $created_at = $cvDetail['Candidate_Cv']['created_at'];
                        //$created_at = "2016-04-05";	
                        $modified_at = $cvDetail['Candidate_Cv']['modified'];
                        $modified_at = "2016-04-05";
                        if ($modified_at != "") {
                            $modified_at = date('Y-m-d', strtotime($modified_at));
                        }
                        $created_at = date('Y-m-d', strtotime($created_at));
                        //$no_views = $cvDetail['Candidate_Cv']['no_views'];	
                        $no_views = $cvDetail['Candidate_Cv']['mode'];
                        //$default_cv = $cvDetail['Candidate_Cv']['default_cv'];	
                        $default_cv = "Y";
                        $cv_file_path = $cvDetail['Candidate_Cv']['cv_file_path'];
                        $cv_file_name = $cvDetail['Candidate_Cv']['cv_file_name'];
                        if (file_exists($cv_file_path)) {
                            $showdownload = 1;
                        } else {
                            $showdownload = 0;
                        }
                        ?>

                        <tr id="resume_<?php echo $cv_id; ?>">
                            <td>
                                <?php echo $count; ?>
                            </td>
                            <td>
                                <div class="user-title">
                                    <a href="#str<?php echo $count; ?>" id="task<?php echo $count; ?>" class="username-clickable"><?php echo $cv_title; ?></a>
                                </div>
                            </td>
                            <!--<td><?php if ($default_cv == "Y") { ?><span class="resume-icon-completed"></span><?php } ?></td>-->

                            <td>
                                <?php
                                if (ucfirst($cv_status) == "Complete") {
                                    ?>
                                                                                                                        <!--<a href="javascript:void(0);" onclick="getInterviewAdvisor('<?php echo $intPortalId ?>','<?php echo $seekerid ?>','<?php echo $cv_id; ?>')">Interview Advisor</a>-->

                                    <a href="<?php echo $strIntAdvisorUrl; ?>">Interview Advisor</a>
                                    <?php
                                } else {
                                    echo "N/A";
                                }
                                ?>

                            </td>

                            <td><?php echo ucfirst($cv_status); ?></td>
                            <td><?php echo ucfirst($no_views); ?></td>
                            <!--<td><?php echo $modified_at; ?></td>-->
                            <td><a onclick="submitToResumeViewList('<?php echo $intPortalId ?>', '<?php echo $seekerid ?>', '<?php echo $cv_id; ?>');" href="javascript:void(0);">View Cv / Resume</a></td>
                            <td><?php echo date("F d, Y", strtotime($created_at)); ?></td>

                        </tr>
                        <tr id="str<?php echo $count; ?>" class="hide-str">
                            <td></td>
                            <td colspan="7">
                                <div id="task<?php echo $count; ?>-options" class="user-options">
                                        <!--<a href="javascript:void(0);" onclick="return fnaddRenameCv('<?php echo $intPortalId; ?>','<?php echo $cv_id; ?>');" class="link-primary">Edit</a>--> 
                                    <?php
                                    if ($no_views == "functional") {
                                        ?>
                                        <a href="javascript:void(0);" onclick="return getContactInfof('<?php echo $intPortalId; ?>', '<?php echo $cv_id; ?>');" class="link-primary">Edit</a> |
                                        <?php
                                    } else {
                                        ?>
                                        <a href="javascript:void(0);" onclick="return getExpLevel('<?php echo $intPortalId; ?>', '<?php echo $cv_id; ?>');" class="link-primary">Edit</a> |															
                                        <?php
                                    }
                                    ?>

                                    <a href="javascript:void(0);" onclick="return fnConfirmInquiryDelete('<?php echo $cv_id ?>', '<?php echo $intPortalId ?>', '<?php echo $count; ?>');" class="link-warning">Delete</a> <?php
                                    if ($showdownload > 0) {
                                        ?>|
                                        <a href="<?php echo Router::url('/', true) . "" . $cv_file_path; ?>" download="<?php echo $cv_file_name; ?>" class="link-primary">Download</a><?php }
                                    ?> 	 |
                                    <!--<a href="#" class="link-primary">Dublicate</a> |-->
                                    <!--<a href="javascript:void(0);" onclick="return changecvstatus('<?php echo $cv_id; ?>','<?php echo $intPortalId; ?>');" class="link-primary">Change Status</a> |
                                    <a href="javascript:void(0);" onclick="return fnmakeDefaultCv('<?php echo $intPortalId; ?>','<?php echo $cv_id; ?>')"  class="link-primary">Set as Default</a>-->
                                </div>
                            </td>
                        </tr>


                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>						

<?php
	echo $this->element('font_modal_new');	
?>	
<?php
	echo $this->element('delete_confirmation_new');
?>			

<script language="JavaScript" type="text/javascript">

function fnConfirmInquiryDelete(intInquiryId,portalid,count)
{
	$("#confirm_delete_new").modal('show');
	$('#delete_for').val(intInquiryId);
	$('#cv_for').val(portalid);
	$('#cn_for').val(count);
}

$(".panel-body.user-resume .user-title a").click(function(event) {
				
				$(this.getAttribute("href")).css('display', 'table-row');
				$(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
			});
		function fnaddCv()
		{
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
			
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"candidates/getAddCvform/"+intPortalId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						
						$('#tab-resume').html(data.contactshtml);
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

</script>

