<?php
$columnName = $_SESSION['vendorsearchcolumn'];
$sort = $_SESSION['vendorsearchsort'];
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#productlistfilterform').validationEngine();
    });

</script>
<?php
echo $this->Html->script('myorder_index');
?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="tab-header">
                <h3>Vendor Service List</h3>
                <?php
                $strVendoraddUrl = Router::url(array('controller' => 'vendorservices', 'action' => 'add'), true);
                ?>
                <button onclick="javascript:location.href = '<?php echo $strVendoraddUrl; ?>'" type="button" class="btn btn-primary btn-sm">Add New</button>
            </div>
            <div class="tab-row-container ">

                <div class="tab-search">
                    <?php
                    $strProductSearchUrl = Router::url(array('controller' => 'vendorservices', 'action' => 'index'), true);
                    ?>
                    <form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl; ?>/" method="post" role="form">
                        <input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
                        <input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
                        <button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
                    </form>
                </div>
            </div>
            <!-- USER RESUME TOP CONTROLS -->
            <div class="tab-row-container">
            </div>
            <div class="tab-row-container">
                <table class="tablesorter panel-heading admin-content" id="product_list">
                    <input type='hidden' id='sort' value='asc'>
                            <thead>
                            <tr>
                                <th style="width:5%!important;">ID</th>
                                <th class="header headerSortDown" style="width:15%!important;" onclick="sortTable('vendor_name');">Vendor Name<span></span></th>
                                <th class="header" style="width:25%!important;" onclick="sortTable('product_name');">Service Name</th>
                                <th class="action" style="width:7%!important;">Status</th>
                                <th class="header" style="width:15%!important;" onclick="sortTable('vendor_service_creation_date');">Created On</th>
                                <th style="width:32%!important;" class="action">Action</th>
                            </tr>
                            </thead>
                            <tbody class="panel-body admin-content" id="sortRecords">
                             <?php
                            if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                                $intContentCount = 0;
                                foreach ($arrProductList as $arrContent) {
                                    $intContentCount++;
                                    $strProductEditUrl = Router::url(array('controller' => 'vendorservices', 'action' => 'edit', $arrContent['vendor_service']['vendor_service_id']), true);
                                    $strPreviewUrl = Router::url(array('controller' => 'vendorservice', 'action' => 'preview', "5", $arrContent['vendor_service']['vendor_service_id']), true);
                                    $strStatus = "Activate";
                                    if ($arrContent['vendor_service']['status'] == "Active") {
                                        $strStatus = "Inactivate";
                                    }
                                    ?>
                                    <tr>
                                        <td style="width:5%!important;"><?php echo $intContentCount; ?></td>
                                        <td style="width:15%!important;"><div class="user-title"><?php echo stripslashes($arrContent['vendors']['vendor_name']); ?></div></td>
                                        <td style="width:25%!important;"><?php echo $arrContent['Resources']['product_name']; ?></td>
                                        <td style="width:7%!important;" id="status_col_<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>"><?php echo ucfirst($arrContent['vendor_service']['status']); ?></td>
                                        <td style="width:15%!important;"><?php echo date($productdateformat, strtotime($arrContent['vendor_service']['vendor_service_creation_date'])) ?></td>
                                        <td style="width:32%!important;"><a  href="<?php echo $strProductEditUrl; ?>">Edit</a> |<a onClick="return fnDeletevendorServiceProduct('<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>')" href="javascript:void(0);">Delete</a> | <a id="status_<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>" onClick="return fnChangevendorServiceProductStatus('<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>')" href="javascript:void(0);"><?php echo $strStatus; ?></a> | <a onClick="return fnReassignServiceProduct('<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>')" href="javascript:void(0);" >Reassign Step</a></td>
                                    </tr>
                                    <div id="myModal<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Reassign Step</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="model<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>">Some text in the modal.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                </table>
            </div>
            <div class="tab-row-container">
                <div class="tab-controls-actions">
                </div>
                <div class="tab-controls-pagination">
                    <div class="pagination pagination-large" id="sort_pagi">
                        <ul class="pagination">
                            <?php
                            if($columnName !='' && $sort !=''){
                                $this->Paginator->options['url'] = array('controller' => 'vendorservices', 'action' => 'search',$strKeywordSearch,"?Sort=".($sort)."&Column=".($columnName).""); 
                            }
                            
                            echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
                            echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script type="text/javascript">
    $(document).ready(function() 
    { 
        $("#product_list").tablesorter({
            headers : { 0 : { sorter: false },5 : { sorter: false } }
        });
        
        $('.action').removeClass('header');
        
        $(".panel-body.admin-content .user-title a").click(function (event) {
            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
            event.preventDefault();
        });
        
        var sort = '<?php echo $sort;?>';
        var columnName = '<?php echo $columnName;?>';
        if(sort == "asc"){
          $("#sort").val("desc");
        }else{
          $("#sort").val("asc");
        }
    }); 
    
    function sortTable(columnName){
    var sort = $("#sort").val();
    $.ajax({
     url:strBaseUrl+"vendorservices/search/<?php echo $strKeywordSearch;?>",
     type:'post',
     data:{columnName:columnName,sort:sort},
     dataType: 'json',
     success: function(response){
      if(response.count.length > 20){
        $(".pagination ul li").next().removeAttr("class");
        $(".pagination ul li:nth-child(2)").attr("class",'active');
      }
        $("#sortRecords").html('');
        $("#sortRecords").html(response.content);
        $("#sort_pagi").html('');
        $("#sort_pagi").html(response.pagidiv);
      if(sort == "asc"){
        $("#sort").val("desc");
      }else{
        $("#sort").val("asc");
      }

     }
    });
   }
   
</script>