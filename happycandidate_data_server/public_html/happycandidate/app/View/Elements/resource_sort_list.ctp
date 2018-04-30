<?php $strJobResourceAllUrl = Router::url(array('controller' => 'resources', 'action' => 'index', $intPortalId), true);?>
<div class="container-fluid job-search-submenu">
    <div class="row">

        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php foreach($productCategoryTop as $catMenu){ 
                $strJobResourceUrl = Router::url(array('controller' => 'resources', 'action' => 'sortresourceslist', $intPortalId), true). "?CatId=".$catMenu['content_category']['content_category_id']."";
                ?>
                <a <?php if($catMenu['content_category']['content_category_id'] == $_GET['CatId']){ ?> class="active" <?php } ?>  href="<?php echo $strJobResourceUrl; ?>"><?php echo $catMenu['content_category']['content_category_name'];?></a>
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
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 bg-lightest-grey">
            <div class="resource-blocks-container">
                <?php
                    foreach ($arrResourcesDetail as $arrResources) {
                    $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $arrResources['Vendorservice']['vendor_service_id']), true);
                    ?>
                <div class="resource-block">
                    <div class="resources-header">
                        <a onClick="location.href = '<?php echo $strContactDetailUrl; ?>'" class="goto-resource">
                            <div class="resources-image-bg">
                               <?php
                                    if ($arrResources['Resources']['images'][0]['ResourcesImages']['product_image_path']) {
                                        ?>
                                        <img width="100%" height="135" alt="Resource Image"  src="<?php echo Router::url('/', true) . $arrResources['Resources']['images'][0]['ResourcesImages']['product_image_path']; ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <img width="100%" height="135" alt="Contact Pic"  src="<?php echo Router::url('/', true) . "img/noimage.jpg"; ?>">
                                        <?php
                                    }
                                    ?> 
                            </div>
                        </a>
                        <a onClick="location.href = '<?php echo $strContactDetailUrl; ?>'" class="goto-resource">
                            <h3 class="favourite-title"><?php echo stripcslashes(strlen($arrResources['Resources']['product_name']) > 55) ? stripcslashes(substr($arrResources['Resources']['product_name'], 0, 55) . "...") : stripcslashes($arrResources['Resources']['product_name']); ?></h3>
                        </a>
                        <!--<p><span>Type</span> - <?php echo $arrResources['Resources']['product_type']; ?></p>-->
                    </div>
                    <div class="resources-footer">
                         <?php if($arrResources['Resources']['discount_cost'] !=''){?>
                            <p class="resources-price">Regular Price <s>$<?php echo $arrResources['Resources']['product_cost']; ?></s></p>
                        <?php }else{?>
                            <p class="resources-price">Regular Price $<?php echo $arrResources['Resources']['product_cost']; ?></p>
                        <?php } ?>
                        <?php if($arrResources['Resources']['discount_cost'] !='' && $arrResources['Resources']['discount_cost'] !='0.00'){?>
                            <p class="resources-today">Today $<?php echo $arrResources['Resources']['discount_cost']; ?></p>
                        <?php } ?>
                        <button class="btn-custom-small" onClick="location.href = '<?php echo $strContactDetailUrl; ?>'">Learn More</button>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="page-pagination-container">
                <ul class="pagination tab-controls-pagination">
                    <?php
                    echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                    echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
                    echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<style>
    .page-header {
        margin: 8px 0 -31px !important;
    }
.resources-today {
  padding-right : 0px !important;
}
</style>