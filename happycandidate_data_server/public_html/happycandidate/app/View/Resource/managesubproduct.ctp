<?php
$columnName = $_SESSION['productcolumn'];
$sort = $_SESSION['productsort'];
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#productlistfilterform').validationEngine();
    });

</script>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="tab-header">
                <h3>Sub Product List</h3>
                <?php
                $strProductaddUrl = Router::url(array('controller' => 'resource', 'action' => 'add'), true);
                ?>
                <!--<button onclick="javascript:location.href = '<?php echo $strProductaddUrl; ?>'" href="" class="btn btn-primary btn-sm">Add New</button>-->
            </div>

            <div class="tab-row-container ">

                <div class="tab-search">
                    <?php
                    $strProductSearchUrl = Router::url(array('controller' => 'resource', 'action' => 'managesubproduct'), true);
                    ?>
                    <form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl; ?>" method="post" role="form">
                        <input type="text" name="product_keyword" id="product_keyword" value="" name="search" placeholder="Search">
                        <input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
                        <button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
                    </form>
                </div>
            </div>
            <!-- USER RESUME TOP CONTROLS -->
            <div class="tab-row-container resourcetab">
                <table class="tablesorter panel-heading admin-content" id="sort_list">
                    <input type="hidden" id="sort" value="desc">
                    <thead>
                        <tr>
                            <th style="width:10%!important;">ID #</th>
                            <th class="header headerSortDown" style="width:40%!important;" onclick="sortTable('product_name');">Name<span></span></th>
                            <th class="header" style="width:10%!important;" onclick="sortTable('product_type');">Type</th>
                            <th class="header" style="width:20%!important;" onclick="sortTable('product_creation_date');">Date Created</th>
                            <th style="width:40%!important;" class="action">Action</th>
                            <th style="width:10%!important;" class="action">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody class="panel-body admin-content" id="sortRecords">
                        <?php // echo "<pre>";print_r($arrProductList);
                        if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                            $intContentCount = 0;
                            foreach ($arrProductList as $arrContent) {
                                $intContentCount++;
                                $strProductEditUrl = Router::url(array('controller' => 'resource', 'action' => 'edit', $arrContent['products']['productd_id']), true);
                                $strPreviewUrl = Router::url(array('controller' => 'resource', 'action' => 'preview', "5", $arrContent['products']['productd_id']), true);
                                $strProductManageUrl = Router::url(array('controller' => 'mylms', 'action' => 'manage', $arrContent['products']['productd_id']), true);
                                $strSubProductListUrl = Router::url(array('controller' => 'resource', 'action' => 'managesubproduct', $arrContent['products']['productd_id']), true);
                                ?>
                                <tr id="product_list_<?php echo $arrContent['products']['productd_id']; ?>">
                                    <td style="width:5%!important;"><?php echo $intContentCount; ?></td>

                                    <td style="width:30%!important;">
                                        <div class="user-title">
                                            <?php echo stripslashes($arrContent['products']['product_name']); ?>
                                        </div>
                                    </td>

                                    <td style="width:10%!important;"><?php echo $arrContent['products']['product_type'];
                                ?></td>
                                    <td style="width:20%!important;"><?php echo date($productdateformat, strtotime($arrContent['products']['product_creation_date'])) ?></td>
                                    <td style="width:35%!important;">
                                        <a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
                                        <a href="<?php echo $strPreviewUrl ?>" class="link-primary">Preview</a> |
                                        <a href="#" id="resource_del_<?php echo $arrContent['products']['productd_id']; ?>" onClick="return fnDeleteResource(this);" class="link-warning">Delete</a> 
                                    </td>
                                </tr>
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
                                $this->Paginator->options['url'] = array('controller' => 'resource', 'action' => 'index',"?Sort=".$sort."&Column=".($columnName).""); 
                            }
                            echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                            echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 12));
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
    $(document).ready(function ()
    {
        $("#sort_list").tablesorter({
            headers: {0: {sorter: false},4: {sorter: false},5: {sorter: false}},
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
        }else if(sort == "desc"){
          $("#sort").val("asc");
        }
    });
    
    function sortTable(columnName){
    var sort = $("#sort").val();
    $.ajax({
     url:strBaseUrl+"resource/managesubproduct",
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