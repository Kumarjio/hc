
		<div class="container-fluid bg-lightest-grey">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10 bg-lightest-grey">
				<div class="page-header">
				<?php $strReturnUrl = Router::url(array('controller'=>'candidates','action'=>'library',$intPortalId),true);?>
					<a class="link-default" href="<?php echo $strReturnUrl;?>"><span class="glyphicon glyphicon-chevron-left"></span> Back to <?php echo $arrContentDetail[0]['content_category']['content_category_name'];?></a>
				</div>
                            <div class="library-article-body" id="library_article_body">
					<div class="col-md-12">
					<?php
						if($arrContentDetail[0]['Content']['content_type'] == "6")
						{
							$intContId = $arrContentDetail[0]['Content']['content_id'];
							$strId = "id='portal_registration'";
						}
						else
						{
							$strId = "";
						}
					?>
						<div class="library-container" <?php echo $strId; ?>>
                                                    <h3 style="text-align:center"><?php echo stripslashes($arrContentDetail[0]['Content']['content_title']); ?></h3>
                                                    <p><?php echo htmlspecialchars_decode(stripslashes($arrContentDetail[0]['Content']['content']));?></p>
                                                    <div id="entButton"><input onclick="fnOneClickAcceptInput('<?php echo $intContId;?>');" class='worksheet_edit_elements hidden-print' type='button' name='strEleInfobut' id='strEleInfo' value='Enter' /></div>            
						</div>
                                                
						<?php
							if($arrContentDetail[0]['Content']['content_type'] == "6")
							{
								$strContentTitle = $arrContentDetail[0]['Content']['content_title'];
								?>
									<input type="hidden" name="portid" id="portid" value="<?php echo $intPortalId;?>" />
									<input type="hidden" name="artid" id="artid" value="<?php echo $intContId;?>" />
                                                                        <a id="printButton" href="javascript:void(0);" onclick="divPrint('<?php echo $intContId;?>');" style="float:right;display: none" class="button_class hidden-print">Print</a>
									<!--<a href="javascript:void(0);" onclick="window.print();return false;" style="float:right;" class="button_class">Print</a>-->
									
									<a id="downloadButton" href="javascript:void(0);" onclick="fnDownloadWorkSheet('<?php echo $intPortalId;?>','<?php echo $strContentTitle;?>','<?php echo $intContId;?>')" style="float:right;;margin-right:5px;" class="button_class hidden-print">Download Worksheet</a>
								<?php
							}
						?>
					</div>

					
				</div>
				
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

            <?php

	if($arrContentDetail[0]['Content']['content_type'] == "6")
	{
		?>
			<script type="text/javascript">
				$(document).ready(function () {
					fnLoadWorksheetData('<?php echo $intPortalId;?>','<?php echo $intContId; ?>');
					
				});
			</script>
		<?php
	}
?>
					
                        <script  type="text/javascript">
                            $(document).ready(function(){
                                $('#pdfLnk').attr('onclick',"fnDownloadWorkSheet('<?php echo $intPortalId;?>','<?php echo $strContentTitle;?>')");
                                
                                var intContId = '<?php echo $intContId;?>';
                                if(intContId == '1162'){
                                 
                                fnAddEditableField('#interview_date_date_1');
                                fnAddEditableField('#company_name_text_2');
                                fnAddEditableField('#position_title_text_3');
                                fnAddEditableField('#normal_title_text_4');
                                fnAddEditableField('#normal_contact_text_5');
                                fnAddEditableField('#phone_number_text_6');
                                fnAddEditableField('#contact_notes_para_1');
                                fnAddEditableField('#conversation_summary_para_2');
                                fnAddEditableField('#time_frame_text_7');
                                fnAddEditableField('#job_ability_select110_1');
                                fnAddEditableField('#int_positives_para_3');
                                fnAddEditableField('#areaof_concerns_para_4');
                                fnAddEditableField('#interest_level_select110_2');
                               }else if(intContId == '168'){
                                fnAddEditableField('#company_targets_text_1');
                                fnAddEditableField('#company_targets_text_2');
                                fnAddEditableField('#company_targets_text_3');
                                fnAddEditableField('#company_targets_text_4');
                                fnAddEditableField('#company_targets_text_5');
                                for(var a = 1; a <= 24; a++) {
                                    fnAddEditableField('#seeker_activity_selectyesno_'+a);
                                }
                                fnAddEditableField('#target_date_date_1');
                                fnAddEditableField('#monthly_review_para_1');
                                fnAddEditableField('#monthly_review_para_2');
                                fnAddEditableField('#monthly_review_para_3');
                            }else if(intContId == '169'){
                                fnAddEditableField('#attitudesheet_date_date_1');
                                fnAddEditableField('#attitudesheet_location_text_1');
                                fnAddEditableField('#attitudesheet_location_text_2');
                                fnAddEditableField('#attitudesheet_eventdesc_para_1');
                                fnAddEditableField('#attitudesheet_eventdesc_para_1');
                                fnAddEditableField('#attitudesheet_howyoufelt_para_2');
                                fnAddEditableField('#attitudesheet_howyoufelt_para_3');
                            }else if(intContId == '84'){
                                for(var i = 1; i <= 60; i++) {
                                    fnAddEditableField('#networkingsheet_activity_selectcontacttype_'+i);
                                    fnAddEditableField('#networkingsheet_activity_selectcontactclassi_'+i);
                                }
                                
                                for(var x = 1; x <= 143; x++) {
                                    fnAddEditableField('#networkingsheet_activity_text_'+x);
                                }
                                
                                for(var y = 145; y <= 180; y++) {
                                    fnAddEditableField('#networkingsheet_activity_text_'+y);
                                }
                            }else if(intContId == '170'){
                                for(var c = 1; c <= 11; c++) {
                                    fnAddEditableField('#monthly_review_para_'+c);
                                }
                                for(var ja = 1; ja <= 12; ja++) {
                                    fnAddEditableField('#job_review_para_'+ja);
                                }
                            }else if(intContId == '870'){
                                for(var b = 1; b <= 12; b++) {
                                    fnAddEditableField('#company_targets_text_'+b);
                                }
                            }else if(intContId == '871'){
                                for(var d = 1; d <= 12; d++) {
                                    fnAddEditableField('#seeker_activity_selectyesno_'+d);
                                }
                            }else if(intContId == '872'){
                                fnAddEditableField('#dateof_birth_date_1');
                                fnAddEditableField('#target_date_date_2');
                            }
                             });
                             
                            function fnOneClickAcceptInput(worksheetId,rowId)
                            {
                                $("#printButton").show();
                                $("#entButton").html('');
                                if(worksheetId =='170'){
                                    for(var x = 1; x <= 11; x++) {
                                        
                                        if($("#monthly_review_para_"+x+"_field").val() === "")
                                        {
                                            $('#monthly_review_para_'+x).html("&nbsp;");
                                        }else
                                        {
                                            $('#monthly_review_para_'+x).text($("#monthly_review_para_"+x+"_field").val());
                                        } 
                                        $("#monthly_review_para_"+x+"_elements").remove();
                                        $('#monthly_review_para_'+x).show();
                                    }
                                    
                                    for(var ja = 1; ja <= 12; ja++) {
                                        if($("#job_review_para_"+ja+"_field").val() === "")
                                        {
                                            $('#job_review_para_'+ja).html("&nbsp;");
                                        }else
                                        {
                                            $('#job_review_para_'+ja).text($("#job_review_para_"+ja+"_field").val());
                                        } 
                                        $("#job_review_para_"+ja+"_elements").remove();
                                        $('#job_review_para_'+ja).show();
                                    }
                                    
                                }
                                if(worksheetId == '169'){
                                    if($("#attitudesheet_date_date_1_field").val() === "" || $("#attitudesheet_location_text_1_field").val() === "" || $("#attitudesheet_location_text_2_field").val() === "" || $("#attitudesheet_eventdesc_para_1_field").val() === "" || $("#attitudesheet_howyoufelt_para_2_field").val() === "" || $("#attitudesheet_eventdesc_para_3_field").val() === "")
                                    {
                                            $('#attitudesheet_date_date_1').html("&nbsp;");
                                            $('#attitudesheet_location_text_1').html("&nbsp;");
                                            $('#attitudesheet_location_text_2').html("&nbsp;");
                                            $('#attitudesheet_eventdesc_para_1').html("&nbsp;");
                                            $('#attitudesheet_howyoufelt_para_2').html("&nbsp;");
                                            $('#attitudesheet_howyoufelt_para_3').html("&nbsp;");
                                    }else
                                    {
                                            $('#attitudesheet_date_date_1').text($("#attitudesheet_date_date_1_field").val());
                                            $('#attitudesheet_location_text_1').text($("#attitudesheet_location_text_1_field").val());
                                            $('#attitudesheet_location_text_2').text($("#attitudesheet_location_text_2_field").val());
                                            $('#attitudesheet_eventdesc_para_1').text($("#attitudesheet_eventdesc_para_1_field").val());
                                            $('#attitudesheet_howyoufelt_para_2').text($("#attitudesheet_howyoufelt_para_2_field").val());
                                            $('#attitudesheet_howyoufelt_para_3').text($("#attitudesheet_howyoufelt_para_3_field").val());
                                    }
                                    $('#attitudesheet_date_date_1_elements').remove();
                                    $('#attitudesheet_date_date_1').show();
                                    
                                    $('#attitudesheet_location_text_1_elements').remove();
                                    $('#attitudesheet_location_text_1').show();
                                    
                                    $('#attitudesheet_location_text_2_elements').remove();
                                    $('#attitudesheet_location_text_2').show();
                                    
                                    $('#attitudesheet_eventdesc_para_1_elements').remove();
                                    $('#attitudesheet_eventdesc_para_1').show();
                                    
                                    $('#attitudesheet_howyoufelt_para_2_elements').remove();
                                    $('#attitudesheet_howyoufelt_para_2').show();
                                    
                                    $('#attitudesheet_howyoufelt_para_3_elements').remove();
                                    $('#attitudesheet_howyoufelt_para_3').show();

                                }
                                if(worksheetId == '84'){
                                   
                                    for(var i = 1; i <= 60; i++) {
                                        if($("#networkingsheet_activity_selectcontacttype_"+i+"_field").val() == "" || $("#networkingsheet_activity_selectcontactclassi_"+i+"_field").val() == "" )
                                        {
                                            $('#networkingsheet_activity_selectcontacttype_'+i).html("&nbsp;");
                                            $('#networkingsheet_activity_selectcontactclassi_'+i).html("&nbsp;");
                                            
                                        }else
                                        {
                                            var ContactTypeVal = $("#networkingsheet_activity_selectcontacttype_"+i+"_field").val();
                                            
                                            if(ContactTypeVal == null){
                                                $('#networkingsheet_activity_selectcontacttype_'+i).text('-');
                                            }else{
                                                $('#networkingsheet_activity_selectcontacttype_'+i).text($("#networkingsheet_activity_selectcontacttype_"+i+"_field").val());
                                            }
                                            
                                            var ContactTypeVal = $("#networkingsheet_activity_selectcontactclassi_"+i+"_field").val();
                                            if(ContactTypeVal == null){
                                                $('#networkingsheet_activity_selectcontactclassi_'+i).text('-');
                                            }else{
                                                $('#networkingsheet_activity_selectcontactclassi_'+i).text($("#networkingsheet_activity_selectcontactclassi_"+i+"_field").val());
                                            }
                                        } 
                                    
                                        $("#networkingsheet_activity_selectcontacttype_"+i+"_elements").remove();
                                        $('#networkingsheet_activity_selectcontacttype_'+i).show();
                                    
                                        $("#networkingsheet_activity_selectcontactclassi_"+i+"_elements").remove();
                                        $('#networkingsheet_activity_selectcontactclassi_'+i).show();
                                    }
                                
                                    for(var y = 1; y <= 143; y++) {
                                        if($("#networkingsheet_activity_text_"+y+"_field").val() == "")
                                        {
                                            $('#networkingsheet_activity_text_'+y).html("&nbsp;");
                                        }else
                                        {
                                            $('#networkingsheet_activity_text_'+y).text($("#networkingsheet_activity_text_"+y+"_field").val());
                                        }
                                        
                                        $("#networkingsheet_activity_text_"+y+"_elements").remove();
                                        $('#networkingsheet_activity_text_'+y).show();
                                    }
                                    
                                    for(var a = 145; a <= 180; a++) {
                                        if($("#networkingsheet_activity_text_"+a+"_field").val() == "")
                                        {
                                            $('#networkingsheet_activity_text_'+a).html("&nbsp;");
                                        }else
                                        {
                                            $('#networkingsheet_activity_text_'+a).text($("#networkingsheet_activity_text_"+a+"_field").val());
                                        }
                                        
                                        $("#networkingsheet_activity_text_"+a+"_elements").remove();
                                        $('#networkingsheet_activity_text_'+a).show();
                                    }
                                }
                                if(worksheetId == '870'){
                                    for(var b = 1; b <= 12; b++) {
                                        if($("#company_targets_text_"+b+"_field").val() == "")
                                            {
                                                $('#company_targets_text_'+b).html("&nbsp;");
                                            }else
                                            {
                                                $('#company_targets_text_'+b).text($("#company_targets_text_"+b+"_field").val());
                                            } 
                                            $("#company_targets_text_"+b+"_elements").remove();
                                            $('#company_targets_text_'+b).show();
                                    }
                                }
                                if(worksheetId == '871'){
                                    for(var d = 1; d <= 12; d++) {
                                        if($("#seeker_activity_selectyesno_"+d+"_field").val() == "")
                                            {
                                                $('#seeker_activity_selectyesno_'+d).html("&nbsp;");
                                            }else
                                            {
                                                var ContactTypeVal = $("#seeker_activity_selectyesno_"+d+"_field").val();
                                                if(ContactTypeVal == null){
                                                    $('#seeker_activity_selectyesno_'+d).text('');
                                                }else{
                                                    $('#seeker_activity_selectyesno_'+d).text($("#seeker_activity_selectyesno_"+d+"_field").val());
                                                }
                                            } 
                                            $("#seeker_activity_selectyesno_"+d+"_elements").remove();
                                            $('#seeker_activity_selectyesno_'+d).show();
                                    }
                                }
                                if(worksheetId == '872'){
                                    if($("#dateof_birth_date_1_field").val() == "" || $("#target_date_date_2_field").val() == "")
                                    {
                                        $('#dateof_birth_date_1').html("&nbsp;");
                                        $('#target_date_date_2').html("&nbsp;");
                                    }else
                                    {
                                       $('#dateof_birth_date_1').text($("#dateof_birth_date_1_field").val());
                                       $('#target_date_date_2').text($("#target_date_date_2_field").val());
                                    } 
                                    $("#dateof_birth_date_1_elements").remove();
                                    $('#dateof_birth_date_1').show();
                                    $("#target_date_date_2_elements").remove();
                                    $('#target_date_date_2').show();
                                }
                                if(worksheetId == '168'){
                                    for(var e = 1; e <= 5; e++) {
                                        if($("#company_targets_text_"+e+"_field").val() == "")
                                        {
                                            $('#company_targets_text_'+e).html("&nbsp;");
                                        }else
                                        {
                                            $('#company_targets_text_'+e).text($("#company_targets_text_"+e+"_field").val());
                                        } 
                                        $("#company_targets_text_"+e+"_elements").remove();
                                        $('#company_targets_text_'+e).show();
                                    }
                                    
                                    for(var a = 1; a <= 24; a++) {
                                        if($("#seeker_activity_selectyesno_"+a+"_field").val() == "")
                                        {
                                            $('#seeker_activity_selectyesno_'+a).html("&nbsp;");
                                        }else
                                        {
                                            var ContactTypeVal = $("#seeker_activity_selectyesno_"+a+"_field").val();
                                            if(ContactTypeVal == null){
                                                $('#seeker_activity_selectyesno_'+a).text('-');
                                            }else{
                                                $('#seeker_activity_selectyesno_'+a).text($("#seeker_activity_selectyesno_"+a+"_field").val());
                                            }
                                        } 
                                        $("#seeker_activity_selectyesno_"+a+"_elements").remove();
                                        $('#seeker_activity_selectyesno_'+a).show();
                                    }
                                    
                                    for(var f = 1; f <= 3; f++) {
                                        if($("#monthly_review_para_"+f+"_field").val() == "" || $("#target_date_date_"+f+"_field").val() == "")
                                        {
                                            $('#monthly_review_para_'+f).html("&nbsp;");
                                            $('#target_date_date_'+f).html("&nbsp;");
                                        }else
                                        {
                                            var ContactTypeVal = $("#monthly_review_para_"+a+"_field").text();
                                            if(ContactTypeVal == null){
                                                $('#monthly_review_para_'+f).text('-');
                                            }else{
                                                $('#monthly_review_para_'+f).text($("#monthly_review_para_"+f+"_field").val());
                                            }
                                            
                                            var ContactTypeVal1 = $("#target_date_date_"+a+"_field").text();
                                            if(ContactTypeVal1 == null){
                                                $('#target_date_date_'+f).text('-');
                                            }else{
                                                $('#target_date_date_'+f).text($("#target_date_date_"+f+"_field").val());
                                            }
                                            
                                        } 
                                        $("#monthly_review_para_"+f+"_elements").remove();
                                        $('#monthly_review_para_'+f).show();
                                        
                                        $("#target_date_date_"+f+"_elements").remove();
                                        $('#target_date_date_'+f).show();
                                    }
                                    
//                                    fnAddEditableField('#target_date_date_1');
                                    
                            }
                                if(worksheetId == '1162'){
                                    
                                    if($("#interview_date_date_1_field").val() == "" || $("#company_name_text_2_field").val() == "" || $("#position_title_text_3_field").val() == "" || $("#normal_title_text_4_field").val() == "")
                                    {
                                        $('#interview_date_date_1').html("&nbsp;");
                                        $('#company_name_text_2').html("&nbsp;");
                                        $('#position_title_text_3').html("&nbsp;");
                                        $('#normal_title_text_4').html("&nbsp;");
                                        $('#normal_contact_text_5').html("&nbsp;");
                                        $('#phone_number_text_6').html("&nbsp;");
                                        $('#contact_notes_para_1').html("&nbsp;");
                                        $('#conversation_summary_para_2').html("&nbsp;");
                                        $('#time_frame_text_7').html("&nbsp;");
                                        $('#job_ability_select110_1').html("&nbsp;");
                                        $('#int_positives_para_3').html("&nbsp;");
                                        $('#areaof_concerns_para_4').html("&nbsp;");
                                        $('#interest_level_select110_2').html("&nbsp;");
                                    }else
                                    {
                                        $('#interview_date_date_1').text($("#interview_date_date_1_field").val());
                                        $('#company_name_text_2').text($("#company_name_text_2_field").val());
                                        $('#position_title_text_3').text($("#position_title_text_3_field").val());
                                        $('#normal_title_text_4').text($('#normal_title_text_4_field').val());
                                        $('#normal_contact_text_5').text($('#normal_contact_text_5_field').val());
                                        $('#phone_number_text_6').text($('#phone_number_text_6_field').val());
                                        $('#contact_notes_para_1').text($('#contact_notes_para_1_field').val());
                                        $('#conversation_summary_para_2').text($('#conversation_summary_para_2_field').val());
                                        $('#time_frame_text_7').text($('#time_frame_text_7_field').val());
                                        var ContactTypeVal10 = $("#job_ability_select110_1_field").val();
                                        if(ContactTypeVal10 == null){
                                            $('#job_ability_select110_1').text('-');
                                        }else{
                                            $('#job_ability_select110_1').text($("#job_ability_select110_1_field").val());
                                        }
                                        $('#int_positives_para_3').text('');
                                        $('#areaof_concerns_para_4').text('');

                                        
                                        var ContactTypeVal12 = $("#interest_level_select110_2_field").val();
                                        if(ContactTypeVal12 == null){
                                            $('#interest_level_select110_2').text('-');
                                        }else{
                                            $('#interest_level_select110_2').text($("#interest_level_select110_2_field").val());
                                        }
                                    }
                                    
                                    $("#interview_date_date_1_elements").remove();
                                    $('#interview_date_date_1').show();
                                    
                                    $("#company_name_text_2_elements").remove();
                                    $('#company_name_text_2').show();
                                    
                                    $("#position_title_text_3_elements").remove();
                                    $('#position_title_text_3').show();
                                    
                                    $("#normal_title_text_4_elements").remove();
                                    $('#normal_title_text_4').show();
                                    
                                    $("#normal_contact_text_5_elements").remove();
                                    $('#normal_contact_text_5').show();
                                    
                                    $("#phone_number_text_6_elements").remove();
                                    $('#phone_number_text_6').show();
                                    
                                    $("#contact_notes_para_1_elements").remove();
                                    $('#contact_notes_para_1').show();
                                    
                                    $("#conversation_summary_para_2_elements").remove();
                                    $('#conversation_summary_para_2').show();
                                    
                                    $("#time_frame_text_7_elements").remove();
                                    $('#time_frame_text_7').show();
                                    
                                    $("#job_ability_select110_1_elements").remove();
                                    $('#job_ability_select110_1').show();
                                    
                                    $("#int_positives_para_3_elements").remove();
                                    $('#int_positives_para_3').show();
                                    
                                    $("#areaof_concerns_para_4_elements").remove();
                                    $('#areaof_concerns_para_4').show();
                                    
                                    $("#interest_level_select110_2_elements").remove();
                                    $('#interest_level_select110_2').show();
                                    
                               }
                            }
                            
                        </script>
                        
                        <script>
                            function divPrint(contentId){
                                $("#entButton").html('');
                                $("#printButton").css('display','none');
                                $("#downloadButton").css('display','none');
                                $("#worksheet_save").css('display','none');
                                var divContents = $("#library_article_body").html();
                                var printWindow = window.open("", "PrintWindow","width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
                                printWindow.document.write('<html><head>');
                                printWindow.document.write('</head><body >');
                                printWindow.document.write(divContents);
                                printWindow.document.write('</body></html>');
                                printWindow.document.close();
                                printWindow.print();
                                
                                $("#entButton").html("<input onclick='fnOneClickAcceptInput('"+contentId+"')' class='worksheet_edit_elements hidden-print' type='button' name='strEleInfobut' id='strEleInfo' value='Enter' />");
                                $("#printButton").css('display','');
                                $("#downloadButton").css('display','');
                                $("#worksheet_save").css('display','');
                            }
                        </script>
                        
                        <style>
                            .worksheet_table{
                                width:100%
                            }
                            .section-title{
                                text-align: center;
                            }
                            @media print {
                                .hidden-print {
                                  display: none !important;
                                }
                            }
                        </style>