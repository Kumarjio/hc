<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="page-header">
                <h2>Edit Service</h2>
            </div>
            <!--message display here-->
            <div id="product_notification"></div> 
            <!--message display here-->
            <input type="hidden" name="content_added" id="content_added" value="<?php echo $arrProductContent[0]['Resources']['productd_id'];?>" />
            <ul class="nav nav-pills tab-list">
                <li class="active">
                    <a href="#js-vendor-panel" data-toggle="pill" id="js-vendor-panel">Vendors Panel</a>
                </li>
                <li>
                    <a id="cat-tab" data-toggle="pill" href="#tab_cat">Resources Categories</a>
                </li>
            </ul>
            <div style="padding-top: 20px;" class="tab-content">
                <div class="tab-pane fade in active" id="tab-vendor-panel">
                    <?php
                    echo $this->element("services");
                    ?>
                </div>
            </div>
            
            <div id="tab_cat" class="tab-pane fade">
		<div id="content_cat_form"></div>
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
        $("a[data-toggle='pill']").click(function() {
		   var strNewTab = $(this).attr('id');
		   if(strNewTab == "cat-tab")
		   {
                        $("#tab_cat").show();
                        $("#edit-contact").hide();
                        fnGetResourcesCategoryForm('0');
		   }else{
                       $("#tab_cat").hide();
                       $("#edit-contact").show();
                   }
	   });
        
        
        function fnGetResourcesCategoryForm(strCategoryTypes)
        {
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
	var strProductId = $('#content_added').val();
	var strProductUserId = '3';
	var strCategoryTypes = '0';
	if(strProductId == "")
	{
		strProductId = 0;
	}
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"resource/resourcecategoryassform/"+strProductId+"/"+strProductUserId+"/"+strCategoryTypes,
			dataType: 'json',
			data:"",
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
                                    $('.cms-bgloader-mask').hide();//show loader mask
                                    $('.cms-bgloader').hide(); //show loading image
                                    $('.tabloader').hide();
                                    $('#content_cat_form').html(data.content);
                                    $('#cont_cat_loaded').val('1');
				}
				else
				{
                                    $('.cms-bgloader-mask').hide();//show loader mask
                                    $('.cms-bgloader').hide(); //show loading image
                                    alert("fail");
				}
			}
	});
}
</script>