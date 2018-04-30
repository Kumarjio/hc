<div class="container-fluid orderslist">
    <div class="row">
        <!--<div class="col-md-1"></div>-->
        <div class="col-md-12">
            <div class="resource-blocks-container">   


                <div class="resource-block-column col-md-3">                    
                    <div class="resource-block">
                        <div class="resources-header">
                            <?php echo $arrParentService[0]['Resourceorderdetail']['product_name'] ?>
                        </div>
                        <ul>
                            <?php
                            foreach ($arrChildServiceDetail as $childServices) {
                                $strContactDetailUrl = Router::url(array('controller' => 'myorders', 'action' => 'serviceorderdetail', ($intPortalId), ($childServices['Resources']['productd_id']), ($intOrderMId)), true);
                                ?>
                                <li><a href="<?php echo $strContactDetailUrl; ?>"><?php echo stripcslashes($childServices['Resources']['product_name']); ?></a></li>
                            <?php } ?>
                        </ul> 
                    </div>
                </div><!--resource-block-column-ends-->

            </div>

        </div>

        <!--<div class="col-md-1"></div>-->
    </div>
</div>


<style>
    .orderslist {
  height: 800px !important;
}
    .col-md-10.bg-lightest-grey {
        margin-bottom: 246px;
    }

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