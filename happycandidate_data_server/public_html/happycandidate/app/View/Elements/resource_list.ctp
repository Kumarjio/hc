<?php $strJobResourceAllUrl = Router::url(array('controller' => 'resources', 'action' => 'index', $intPortalId), true);?>
<div class="container-fluid job-search-submenu">
    <div class="row">

        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php foreach($productCategoryTop as $catMenu){ 
                $strJobResourceUrl = Router::url(array('controller' => 'resources', 'action' => 'sortresourceslist', $intPortalId), true). "?CatId=".$catMenu['content_category']['content_category_id']."";
                ?>
                <a href="<?php echo $strJobResourceUrl; ?>"><?php echo $catMenu['content_category']['content_category_name'];?></a>
            <?php } ?>
            <a class="active" href="<?php echo $strJobResourceAllUrl;?>">All </a>
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
<?php // echo '<pre>'; print_r($productCategoryTop);?>
<?php // echo '<pre>'; print_r($arrProductsByCatId);?>
<div class="container-fluid">
    <div class="row">
        <!--<div class="col-md-1"></div>-->
        <div class="col-md-12">
            <div class="resource-blocks-container">   
                
                    
                    <div class="resource-block-column col-md-3">                    
                          <div class="resource-block">
                              <div class="resources-header">
                                  <?php echo $productCategoryTop[0]['content_category']['content_category_name']?>
                              </div>
                              <ul>
                                <?php 
                                    foreach($arrProductsByCatId['117'] as $catProducts){
                                            $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $catProducts['Vendorservice']['vendor_service_id']), true);
                                        ?>
                                        <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($catProducts['Resources']['product_name']);?></a></li>
                                <?php }?>
                              </ul> 
                          </div>

                          <div class="resource-block">
                              <div class="resources-header">
                                  <?php echo $productCategoryTop[1]['content_category']['content_category_name']?>
                              </div>
                              <ul>
                                  <?php 
                                    foreach($arrProductsByCatId['119'] as $catProducts){
                                            $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $catProducts['Vendorservice']['vendor_service_id']), true);
                                        ?>
                                        <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($catProducts['Resources']['product_name']);?></a></li>
                                <?php  }?>
                              </ul>
                          </div>   
                    </div><!--resource-block-column-ends-->
                    
                    <div class="resource-block-column col-md-3">                    
                          <div class="resource-block">
                              <div class="resources-header">
                                  <?php echo $productCategoryTop[2]['content_category']['content_category_name']?>
                              </div>
                              <ul>
                                <?php 
                                    foreach($arrProductsByCatId['116'] as $catProducts){
                                            $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $catProducts['Vendorservice']['vendor_service_id']), true);
                                        ?>
                                        <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($catProducts['Resources']['product_name']);?></a></li>
                                <?php }?>
                              </ul> 
                          </div>
                    </div><!--resource-block-column-ends-->
                    
                    <div class="resource-block-column col-md-3">                    
                          <div class="resource-block">
                              <div class="resources-header">
                                  <?php echo $productCategoryTop[3]['content_category']['content_category_name']?>
                              </div>
                              <ul>
                                <?php 
                                    foreach($arrProductsByCatId['115'] as $catProducts){
                                            $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $catProducts['Vendorservice']['vendor_service_id']), true);
                                        ?>
                                        <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($catProducts['Resources']['product_name']);?></a></li>
                                <?php }?>
                              </ul> 
                          </div>
                    </div><!--resource-block-column-ends-->
                    
                    <div class="resource-block-column col-md-3">                    
                          <div class="resource-block">
                              <div class="resources-header">
                                  <?php echo $productCategoryTop[4]['content_category']['content_category_name']?>
                              </div>
                              <ul>
                                <?php 
                                    foreach($arrProductsByCatId['118'] as $catProducts){
                                            $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $catProducts['Vendorservice']['vendor_service_id']), true);
                                        ?>
                                        <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($catProducts['Resources']['product_name']);?></a></li>
                                <?php }?>
                              </ul> 
                          </div>
                    </div><!--resource-block-column-ends-->
                      
                      
                    
                    
                    
                    
                <?php // foreach($productCategoryTop as $k=>$catMenu){
     
//                    $strJobResourceUrl = Router::url(array('controller' => 'resources', 'action' => 'sortresourceslist', $intPortalId), true). "?CatId=".$catMenu['content_category']['content_category_id']."";
                ?>
                
<!--                <div class="resource-block-column col-md-3">  
                <div class="resource-block">
                    <div class="resources-header">
                        <?php echo $catMenu['content_category']['content_category_name'];?>
                    </div>
                    <ul>
                        <?php 
                        foreach($arrProductsByCatId as $key=>$catProduct){
                            if($key == $catMenu['content_category']['content_category_id']){
                                foreach($catProduct as $catProducts){
                                $strContactDetailUrl = Router::url(array('controller' => 'resources', 'action' => 'detail', $intPortalId, $catProducts['Vendorservice']['vendor_service_id']), true);
                            ?>
                            <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($catProducts['Resources']['product_name']);?></a></li>
                        <?php } } }?>
                    </ul> 
                </div>
                </div>-->
                <?php // } ?>

            </div>

        </div>

        <!--<div class="col-md-1"></div>-->
    </div>
</div>


<style>
    .page-header {
    margin: 8px 0 -31px !important;
}
/*.resource-block {
    background-color: #fff;
    border: 1px solid #ededed;
    border-radius: 0;
    display: inline-block;
    margin: 0 46px 30px;
    min-width: 260px;
    width: 24%;
    vertical-align: top;
}*/
.resources-header {
    background: #f3f3f3 none repeat scroll 0 0;
    border-bottom: 1px solid #ededed;
    color: #009dde;
    font-size: 17px;
    font-weight: bold;
    padding: 12px;
    text-align: left;
}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.resource-block li {
    border-bottom: 1px solid #ededed;
    padding: 12px 15px;
}
.resource-block li a {
    color: #000;
    font-size: 14px;
    font-weight: bold;
}
</style>