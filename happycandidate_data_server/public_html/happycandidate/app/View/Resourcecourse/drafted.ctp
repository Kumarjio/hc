<?php
$columnName = $_SESSION['column'];
$sort = $_SESSION['sort'];
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#productlistfilterform').validationEngine();
	});

</script>
<?php
	echo $this->element('delete_confirmation');
?>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="tab-header">
                <h1>Draft Courses</h1>
                <div style="margin-top:5px;" id="product_notification"></div>
            </div>
            <div class="tab-row-container ">			
                <div class="tab-search">
                    <?php
                    $strProductSearchUrl = Router::url(array('controller' => 'resourcecourse', 'action' => 'drafted'), true);
                    ?>
                    <form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl; ?>" method="post" role="form">
                        <input type="hidden" name="filter_on" id="filter_on" value="1" />
                        <input type="text" name="product_keyword" id="product_keyword" placeholder="Course title"  value="">
                        <button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
                    </form>
                </div>
            </div>
            <!-- USER RESUME TOP CONTROLS -->
            <div class="tab-row-container resourcetab">
                <div class="panel panel-default hidden-xs hidden-sm">
                     <table id="product_list" class="tablesorter panel-heading admin-content">
                         <input type="hidden" id="sort" value="desc">
                    <!--<div class="panel-heading admin-content">-->
                        <thead>
                            <tr>
                                <th style="width:5%!important;">ID</th>
                                <th class="header headerSortDown" onclick="sortTable('product_name');" style="width:28%!important;">Name<span></span></th>
                                <th class="header" onclick="sortTable('product_type');" style="width:10%!important;">Type</th>
                                <th class="header"  style="width:10%!important;">Status</th>
                                <th class="header" onclick="sortTable('product_creation_date');" style="width:18%!important;">Date Created</th>
                                <th class="action" style="width:40%!important;">Action</th>
                            </tr>
                        </thead>
                    <!--</div>-->
                    <tbody class="panel-body admin-content" id="sortRecords">
<!--                    <div class="panel-body admin-content">
                        <table>-->
                            <?php
                            if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                                $intContentCount = 0;
                                foreach ($arrProductList as $arrContent) {
                                    $intContentCount++;
                                    $strProductEditUrl = Router::url(array('controller' => 'resourcecourse', 'action' => 'edit', $arrContent['products']['productd_id']), true);
                                    $strPreviewUrl = Router::url(array('controller' => 'resourcecourse', 'action' => 'preview', "5", $arrContent['products']['productd_id']), true);
                                    $strProductManageUrl = Router::url(array('controller' => 'mylms', 'action' => 'manage', $arrContent['products']['productd_id']), true);
                                    ?>
                                    <tr>
                                    <!--<tr id="product_list_<?php echo $arrContent['products']['productd_id']; ?>">-->
                                        <td style="width:5%!important;"><?php echo $intContentCount; ?></td>
                                        <td style="width:28%!important;">
                                            <div class="user-title">
                                                <a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['products']['product_name']); ?></a>
                                            </div>
                                        </td>
                                        <td style="width:10%!important;">
                                            <?php
                                            echo $arrContent['products']['product_type'];
                                            ?>
                                        </td>
                                        <td style="width:10%!important;">
                                            <?php
                                            if ($arrContent['products']['product_draft_status'] == '1') {
                                                echo "Drafted";
                                            }
                                            ?>
                                        </td>
                                        <td style="width:18%!important;"><?php echo date($productdateformat, strtotime($arrContent['products']['product_creation_date'])) ?></td>
                                        <td style="width:40%!important;"><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a>&nbsp;|&nbsp;<a href="<?php echo $strProductManageUrl; ?>">Manage</a>&nbsp;|&nbsp;<a class="link-warning" onclick="fnConfirmInquiryDelete('<?php echo $arrContent['products']['productd_id']; ?>')" href="javascript:void(0);">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination pagination-large" id="sort_pagi">
                <ul class="pagination">
                    <?php
                        if($columnName !='' && $sort !=''){
                           $this->Paginator->options['url'] = array('controller' => 'resourcecourse', 'action' => 'drafted',"?Sort=".($sort)."&Column=".($columnName).""); 
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
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#product_list").tablesorter({
            sortList: [[0,0]],
            headers: {0: {sorter: false},5: {sorter: false}},
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
     url:strBaseUrl+"resourcecourse/drafted",
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