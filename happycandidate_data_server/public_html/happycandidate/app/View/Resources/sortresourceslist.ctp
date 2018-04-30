<input type="hidden" name="portal_id" id="portal_id" value="<?php echo $intPortalId; ?>" />
<?php
if (is_array($arrResourcesDetail) && (count($arrResourcesDetail) > 0)) {
    echo $this->element('resource_sort_list');
} else {
    ?>
<?php $strJobResourceAllUrl = Router::url(array('controller' => 'resources', 'action' => 'index', $intPortalId), true);?>
<div class="container-fluid job-search-submenu">
    <div class="row">

        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php foreach($productCategoryTop as $catMenu){ 
                $strJobResourceUrl = Router::url(array('controller' => 'resources', 'action' => 'sortresourceslist', $intPortalId), true). "?CatId=".$catMenu['content_category']['content_category_id']."";
                ?>
                <a class="active"  href="<?php echo $strJobResourceUrl; ?>"><?php echo $catMenu['content_category']['content_category_name'];?></a>
            <?php } ?>
            <a href="<?php echo $strJobResourceAllUrl;?>">All </a>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<div class="container-fluid  resources">
    <div class="row">
        <div class="col-md-12">     
            <div class="page-header">
                <p>
                    The Career Portal Resources provide you with products, services and courses that will assist you during your job search.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-lightest-grey">
    <div class="container-fluid  no-record">
    <div class="row">
        <div class="col-md-12">     
            <div class="page-header">
                 <h2>No Record Found</h2>
            </div>
        </div>
    </div>
</div>
</div>
    <?php
}
?>

<script type="text/javascript">
	function fnLoadConatctAdder()
	{
		$("#add_contact").dialog("open");
		if($('#contact_add_form').length>0)
		{
			$('#contact_add_form')[0].reset();
		}
	}
	
	function fnShowContactFilter()
	{
		$('#contact_filteration_strip').slideToggle('slow');
	}
</script>
<style>
    .no-record{
        margin-bottom: 70px;
        text-align: center;
     }
     .page-header {
    margin: 8px 0 -31px !important;
}
</style>