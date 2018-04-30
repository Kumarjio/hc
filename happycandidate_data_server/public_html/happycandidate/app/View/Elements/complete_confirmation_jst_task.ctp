<!-- Modal -->
<div id="confirm_complete_jst_task" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog delete_confirmation">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Confirmation</h3>
			</div>
			<input type="hidden" name="complete_for" id="complete_for" value="" />
			<input type="hidden" name="action_for" id="action_for" value="" />
			<div class="modal-body delete_modal">
				<!--<p class="tabloader"></p>-->
				<span id="complete_confirmation_text"> Are you sure, you want to mark this task as completed? </sapn>
				
			</div>
			<div class="modal-footer">
				<button id="confirm_complete_no" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
				<button class="btn btn-primary" id="complete_confirm_new_task">Yes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$('#complete_confirm_new_task').click(function () {
		var completeFor = $('#complete_for').val();
		if(completeFor != "")
		{
			$("#confirm_complete_jst_task").modal('hide');
			fnCompleteTasks(completeFor)
		}
		return false;
	});
	$('#confirm_complete_no').click(function () {
				$("#confirm_complete_jst_task").modal('hide');
				
			});

	function fnCompleteTasks(intProductId)
	{
		$('.cms-bgloader-mask').show();//show loader mask
		$('.cms-bgloader').show(); //show loading image
		$('#contacts_container').hide();
		$.ajax({ 
				type: "POST",
				url: strBaseUrl+"jsttasks/completetask/"+$('#portal_id').val()+'/'+intProductId+'/'+$('#action_for').val(),
				dataType: 'json',
				data:"",
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						//alert(data.content)
						
						//$('.message').remove();
						//$('#contacts_container').prepend('<div class="message" style="float:left;width:100%;color:green;">'+data.message+'</div>');
						$('#task_status_'+intProductId).text($('#action_for').val());
						if($('#action_for').val() == "Completed")
						{
							$('#task_comp_'+intProductId).text('Incomplete Task');
						}
						else
						{
							$('#task_comp_'+intProductId).text('Complete Task');
						}
						
						alert(data.message);
					}
					else
					{
						//$('#contacts_container').prepend('<div style="float:left;width:100%;color:red;">'+data.message+'</div>');
						//$('#contacts_container').show();
						
						alert(data.message);
					}
					
					$('.cms-bgloader-mask').hide();//show loader mask
					$('.cms-bgloader').hide(); //show loading image
				}
		});
	}
</script>