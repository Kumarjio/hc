
<?php 
	echo $this->element('delete_confirmation_jst_contact');
	$strRouter = Router::url('/',true);
?>
<input type='hidden' name='portal_id' id='portal_id' value='<?php echo $intPortalId; ?>' />	
<!-- CONTENT -->

<div class="tab-header">
    <h3>Contacts</h3><!--
    --><button type="button" onclick="fnLoadConatctAdder()" class="btn btn-primary btn-sm">Add New</button>
</div>
<?php echo $this->Session->flash(); ?>
<div id="delete_notification"></div>
<!--<div class="tab-row-container">
        <div class="tab-filters">
                <a href="#" class="active">All <span>(5)</span></a> |
                <a href="#" class="link-warning">Trashed <span>(4)</span></a> |
                <a href="#" class="link-primary">Drafted <span>(1)</span></a>
        </div>
        <div class="tab-search">
                <input type="text" value="" name="search" placeholder="Search">
                <button type="button" class="btn btn-default btn-md">Search</button>
        </div>
</div>-->
<!-- CONTACTS TOP CONTROLS -->
<!--Extra add button here-->
<div class="tab-row-container">
    <div class="tab-contacts-controls"> 
        <div class="tab-controls-actions">
            <div class="form-group">
                <button type="button" class="btn btn-default btn-md" onclick="fnDeleteAllConatcts();">Delete</button>
            </div>
        </div>
    </div> 
</div>
<!-- CONTACTS CONTENT -->
<div class="tab-row-container">
    <div class="panel panel-default hidden-xs hidden-sm">
        <div class="panel-heading">
            <table class="tablesorter" id="product_list">
                <thead>
                <tr>
                    <th><input type="checkbox" id="selectall"></th>
                    <th>Name</th>
                    <th>Company<span></span></th>
                    <th>Job Title</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="action">Action</th>
                </tr>
            </thead>
        </div>
        <tbody class="panel-body">
                <?php
                if (is_array($arrContactDetail) && (count($arrContactDetail) > 0)) {
                    $strContactDetailUrl = Router::url(array('controller' => 'jstcontacts', 'action' => 'contactdetail', $intPortalId, $arrContact['JstContacts']['jstcontacts_id']), true);
                    $strAddAppointmentUrl = Router::url(array('controller' => 'jstappointments', 'action' => 'add', $intPortalId, $arrContact['JstContacts']['jstcontacts_id']), true);

                    $strAddTaskUrl = Router::url(array('controller' => 'jsttasks', 'action' => 'add', $intPortalId, $arrContact['JstContacts']['jstcontacts_id']), true);

                    $strAddNoteUrl = Router::url(array('controller' => 'jstnote', 'action' => 'add', $intPortalId, $arrContact['JstContacts']['jstcontacts_id']), true);
                    foreach ($arrContactDetail as $arrContact) {
                        $intContactId = $arrContact['JstContacts']['jstcontacts_id'];
                        ?>
                        <tr id="contact_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>">
                            <td><input type="checkbox" class="case" name="check[]" value="<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" ></td>
                            <td>
                                <div class="user-title">
                                    <a href="#user1-options" id="user1" class="username-clickable"><?php echo $arrContact['JstContacts']['jstcontacts_fname'] . " " . $arrContact['JstContacts']['jstcontacts_lname']; ?></a>
                                </div>
<!--                                <div id="user1-options" class="user-options">
                                    <a href="#" id="contact_edit_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" onclick="fnGetContactDetail(this,'0')" class="link-primary">Edit / View</a> |
                                    <a href="#" onClick="fnDeleteContactPop('<?php echo $intContactId; ?>')" id="contact_del_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" class="link-warning">Delete</a> |
                                    <a href="<?php echo $strContactDetailUrl; ?>" class="link-primary">View</a>
                                </div>-->
                            </td>
                            <td><?php echo $arrContact['JstContacts']['jstcontacts_cname']; ?></td>
                            <td><?php echo $arrContact['JstContacts']['jstcontacts_jtitle']; ?></td>
                            <td>
                                    <!--<a href="#" class="link-primary editable"><?php echo $arrContact['JstContacts']['jstcontacts_emailaddress']; ?></a>-->

                                <?php echo $arrContact['JstContacts']['jstcontacts_emailaddress']; ?>
                            </td>
                            <td>
                                <!--<a href="#" class="link-primary editable"><?php
                                if ($arrContact['JstContacts']['jstcontacts_phone1']) {
                                    echo $arrContact['JstContacts']['jstcontacts_phone1'];
                                } else {
                                    if ($arrContact['JstContacts']['jstcontacts_phone2']) {
                                        echo $arrContact['JstContacts']['jstcontacts_phone2'];
                                    }
                                }
                                ?></a>-->

                                <?php
                                if ($arrContact['JstContacts']['jstcontacts_phone1']) {
                                    echo $arrContact['JstContacts']['jstcontacts_phone1'];
                                } else {
                                    if ($arrContact['JstContacts']['jstcontacts_phone2']) {
                                        echo $arrContact['JstContacts']['jstcontacts_phone2'];
                                    }
                                }
                                ?>
                            </td>
                            <td><a href="#" id="contact_edit_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" onclick="fnGetContactDetail(this,'0')" class="link-primary">Edit / View</a> |<a href="#" onClick="fnDeleteContactPop('<?php echo $intContactId; ?>')" id="contact_del_<?php echo $arrContact['JstContacts']['jstcontacts_id']; ?>" class="link-warning">Delete</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr style="height:50px;">
                        <td colspan="7">There are no contacts added</td>
                    </tr>
                    <?php
                }
                ?>
                     </tbody>
            </table>

            <input type="hidden" name="deleteContactIds" id="deleteContactIds" value="">

            <!--<div class="panel-footer">
             <table>
                            <tr>
                                    <th><input type="checkbox" value=""></th><?php /*
                  $params = $this->Paginator->params();
                  if ($params['pageCount'] > 1) {
                  ?>
                  <div class="pagination">
                  <ul>
                  <?php
                  echo $this->Paginator->prev('&larr; Previous', array(
                  'class' => 'prev',
                  'tag' => 'li',
                  'escape' => false
                  ), '<a onclick="javascript:alert("hi");">&larr; Previous</a>', array(
                  'class' => 'prev disabled',
                  'tag' => 'li',
                  'escape' => false
                  ));
                  echo $this->Paginator->numbers(array(
                  'separator' => '',
                  'tag' => 'li',
                  'currentClass' => 'active',
                  'currentTag' => 'a'
                  ));
                  echo $this->Paginator->next('Next &rarr;', array(
                  'class' => 'next',
                  'tag' => 'li',
                  'escape' => false
                  ), '<a onclick="javascript:alert("hi");">Next &rarr;</a>', array(
                  'class' => 'next disabled',
                  'tag' => 'li',
                  'escape' => false
                  )); ?>
                  </ul>
                  </div>
                  <?php } */ ?>
                                    <th>Name</th>
                                    <th class="selected">Company<span></span></th>
                                    <th>Job Title</th>
                                    <th class="disabled">Country</th>
                                    <th class="disabled">City</th>
                            </tr>
                    </table>
            </div>
    </div>-->

            <div class="panel panel-default hidden-md hidden-lg">
                <div class="panel-heading">
                    <table>
                        <tr>
                            <th><input type="checkbox" value=""></th>
                            <th>Name</th>
                            <th class="disabled">Options</th>
                        </tr>
                    </table>

                </div>

            </div>
        </div>

        <?php
        echo $this->element('delete_confirmation_vendor');
        ?>
        <!-- CONTACTS BOTTOM CONTROLS -->
        <?php /* <div class="tab-row-container">
          <!-- <div class="tab-contacts-controls"> -->
          <!--<div class="tab-controls-actions">
          <div class="form-group">
          <select name="bulk-actions" title="Bulk Actions">
          <option value="value1">Bulk Action1</option>
          <option value="value2">Bulk Action2</option>
          <option value="value3">Bulk Action3</option>
          <option value="value4">Bulk Action4</option>
          </select>
          <button type="button" class="btn btn-default btn-md">Apply</button>
          </div>
          <div class="form-group">
          <select name="date-filter" title="Date Filter">
          <option value="value1">Date Filter1</option>
          <option value="value2">Date Filter2</option>
          <option value="value3">Date Filter3</option>
          <option value="value4">Date Filter4</option>
          </select>
          <button type="button" class="btn btn-default btn-md">Filter</button>
          </div>
          </div>-->
          <div class="tab-controls-pagination">
          <button type="button" class="btn btn-default disabled items-counter"><span>5 items</span></button>
          <button type="button" class="btn btn-default goto-beginning-active"><span></span></button>
          <button type="button" class="btn btn-default goto-previous-active"><span></span></button>
          <input type="text" value="" name="input-page-number" placeholder="1">
          <button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
          <button type="button" class="btn btn-default disabled goto-next"><span></span></button>
          <button type="button" class="btn btn-default disabled goto-end"><span></span></button>
          </div> */ ?>
        <!-- </div> -->
    </div>
</div>
		
<!-- END OF CONTENT -->
<script type="text/javascript">
	$(document).ready(function () {
		$('.username-clickable').click(function () {
			var strDestLoc = $(this).attr('href');
			$(strDestLoc).toggle();
		});
                
                $("#product_list").tablesorter({
            headers : { 0 : { sorter: false },1 : { sorter: false },3 : { sorter: false },4 : { sorter: false },5 : { sorter: false },6 : { sorter: false } }
        });
        
        $('.action').removeClass('header');
	});
	
	
	function fnLoadConatctAdder()
	{
		$('.cms-bgloader-mask').show();//show loader mask
	 	  $('.cms-bgloader').show(); //show loading image
		var intPortalId = "<?php echo $intPortalId; ?>";
		$.ajax({ 
				type: "GET",
				url: strBaseUrl+"jstcontacts/getcontactform/"+intPortalId,
				dataType: 'json',
				data:"",
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('.tabloader').hide();
						$('#tab-contacts').html(data.contactshtml);
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
	
	function fnShowContactFilter()
	{
		$('#contact_filteration_strip').slideToggle('slow');
	}
	
	function fnDeleteContactPop(intContactId)
	{
		$('#delete_for').val(intContactId);
		$('#confirm_delete_jst').modal('show');
	}
        
        $(function(){
	$("#selectall").click(function () {
//		  $('.case').attr('checked', this.checked);
            $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
	});

	$(".case").click(function(){

		if($(".case").length == $(".case:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}

	});
        });
        
        function fnDeleteAllConatcts()
	{
		$('.cms-bgloader-mask').show();//show loader mask
                $('.cms-bgloader').show(); //show loading image
		
                var favorite = [];
                $.each($("input[name='check[]']:checked"), function(){            
                    favorite.push($(this).val());
                });
                $('#deleteContactIds').val(favorite.join(","));
                var intPortalId = "<?php echo $intPortalId; ?>";
                var intContactId = $('#deleteContactIds').val();
		$.ajax({ 
				type: "POST",
				url: strBaseUrl+"jstcontacts/deleteallcontacts",
				dataType: 'json',
				data:'contactId=' + intContactId + "&PortalId=" + intPortalId,
				async:false,
				cache:false,
				success: function(data)
				{
					if(data.status == "success")
					{
						$('.tabloader').hide();
						$('#tab-contacts').html(data.contactshtml);
                                                $('#delete_notification').html(data.message);
                                                var Ids = data.intContactId.split(",");
                                                jQuery.each(Ids, function( i, val ) {
                                                    $( "#contact_" + val ).remove();
                                                });
                                                $("#selectall").removeAttr("checked");
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

<style>
    .tab-row-container .panel-heading, .tab-row-container .panel-body, .tab-row-container .panel-footer {
  background-color: white;
  border: 1px solid #ccc;
  padding: 0;
}
.admin-content tr {
  border: 1px solid #ccc !important;
}
</style>