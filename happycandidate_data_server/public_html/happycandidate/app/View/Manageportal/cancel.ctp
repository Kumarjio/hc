<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="tab-header">
                <h1>Cancelled Career Portals</h1>
            </div>
            <div class="tab-search">
                <?php
                $strProductSearchUrl = Router::url(array('controller' => 'manageportal', 'action' => 'cancel'), true);
                ?>
                <form id="productlistfilterform" name="productlistfilterform" action="<?php echo $strProductSearchUrl; ?>/" method="post" role="form">
                    From Date:
                    <input type="text" id="from_date" name="product_keyword" id="product_keyword" value="" name="from_date"><input id="from_date_hid" type="hidden" class="form-control validate[required]" name="from_date_hid">&nbsp;
                    To Date
                    <input type="text" id="to_date" name="product_keyword" id="product_keyword" value="" name="to_date"><input id="to_date_hid" type="hidden" class="form-control validate[required]" name="to_date_hid">&nbsp;
                    <input type="hidden" class="form-control" name="filter_on" id="filter_on" value="1" />
                    <script type="text/javascript">
                        $(function () {
                            $('#from_date').datetimepicker({
                                format: 'MM/DD/YYYY',
                                useCurrent: false
                            });

                            $('#from_date_hid').datetimepicker({
                                format: 'YYYY-MM-DD'
                            });

                            $('#to_date').datetimepicker({
                                format: 'MM/DD/YYYY',
                                useCurrent: false
                            });

                            $('#to_date_hid').datetimepicker({
                                format: 'YYYY-MM-DD'
                            });

                            $("#from_date").on("dp.change", function (e) {
                                $('#to_date').data("DateTimePicker").minDate(e.date);
                                $('#from_date_hid').data("DateTimePicker").date(e.date);
                            });

                            $("#to_date").on("dp.change", function (e) {
                                $('#from_date').data("DateTimePicker").maxDate(e.date);
                                $('#to_date_hid').data("DateTimePicker").date(e.date);
                            });
                        });
                    </script>
                    <button name="product_search" id="product_search" type="submit" class="btn btn-default btn-md">Search</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md" onclick="fnExportPortals()">Export</button>
                </form>
            </div>
            <!-- USER RESUME TOP CONTROLS -->
            <div class="tab-row-container resourcetab">
                <table class="tablesorter panel-heading admin-content" id="sort_list">
                    <thead>
                        <tr>
                            <th style="width:7%!important;">SR.ID#</th>
                            <th style="width:15%!important;">Company Name<span></span></th>
                            <th style="width:10%!important;">First Name<span></span></th>
                            <th style="width:10%!important;">Last Name<span></span></th>
                            <th style="width:20%!important;">Career Portal URL</th>
                            <th style="width:15%!important;">Date Created</th>
                            <!--<th style="width:10%!important; height: 30px !important;">Action</th>-->
                        </tr>
                    </thead>
                    <tbody class="panel-body admin-content">
                    <input type="hidden" id="contentName" value="cancel" />
                    <?php
                    if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                        $intContentCount = 0;
                        foreach ($arrProductList as $arrContent) {
                            $intContentCount++;
                            $strProductEditUrl = Router::url(array('controller' => 'manageportal', 'action' => 'edit', $arrContent['career_portal']['career_portal_id']), true);
                            $strPreviewUrl = Router::url('/', true) . "portal/home/" . $arrContent['career_portal']['career_portal_name'];
                            ?>
                            <tr id="product_list_<?php echo $arrContent['career_portal']['career_portal_id']; ?>">
                                <td style="width:7%!important;"><?php echo $intContentCount; ?></td>
                                <td style="width:15%!important;"><?php echo isset($arrContent['employer_detail']['employer_company_name']) ? stripslashes($arrContent['employer_detail']['employer_company_name']) : "-"; ?></td>
                                <td style="width:10%!important;"><?php echo isset($arrContent['employer_detail']['employer_user_fname']) ? stripslashes($arrContent['employer_detail']['employer_user_fname']) : '-'; ?></td>
                                <td style="width:10%!important;"><?php echo isset($arrContent['employer_detail']['employer_user_lname']) ? stripslashes($arrContent['employer_detail']['employer_user_lname']) : '-'; ?></td>
                                <td style="width:20%!important;"><a href="http://www.<?php echo $arrContent['career_portal_domain']['career_portal_domain_name']; ?>" target="_blank" class="link-primary"><?php echo $arrContent['career_portal_domain']['career_portal_domain_name']; ?></a></td>
                                <td style="width:15%!important;height: 30px !important;"><?php echo date($productdateformat, strtotime($arrContent['career_portal']['career_portal_created_datetime'])) ?></td>
                                <!--<td style="width:10%!important; height: 30px !important;"><a href="<?php echo $strPreviewUrl ?>" target="_blank" class="link-primary">Preview</a></td>-->
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='7' class="altrow">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan='7'><span style="margin-left:40%;">No Cancel Career Portal</span></td>
                        </tr>
                        <tr>
                            <td colspan='7' class="altrow">&nbsp;</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pagination-large">
                <ul class="pagination">
                    <?php
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
<style>
    <?php  if (is_array($arrProductList) && (count($arrProductList) > 0)) { ?>
    .admin-content tr {
        border: 1px solid #ccc !important;
    }
   <?php  }else{ ?>
    .admin-content{
        border: 1px solid #ccc !important;
    }
    .admin-content tr{
        border: medium none !important;
    }
   <?php  } ?>
    
    .tab-row-container{
        overflow: unset !important;
    }
    .page-content-wrapper {
        height: 682px;
        overflow-x: unset;
    }
    .page-content-wrapper .form-group {
        margin-bottom: 15px;
        overflow: unset;
    }
</style>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#sort_list").tablesorter({
            headers: {5: {sorter: false}}
        });
        $('.action').removeClass('header');

        $(".panel-body.admin-content .user-title a").click(function (event) {

            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
            event.preventDefault();
        });
    });
    
    function fnExportPortals()
    {

        var strStartDate = '<?php echo $strStartDate; ?>';
        var strEndDate = '<?php echo $strEndDate; ?>';
        var strType = '<?php echo $strType; ?>';

        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: appBaseU + "manageportal/portalExport",
            data: 'startDate=' + strStartDate + "&endDate=" + strEndDate + "&Type=" + strType,
            cache: false,
            dataType: "json",
            success: function (data)
            {
                if (data.status == "success")
                {
                    if (data.file != "")
                    {
                        $('.cms-bgloader-mask').hide();//show loader mask
                        $('.cms-bgloader').hide(); //show loading image
                        var strFileUrl = appBaseU + data.filepath + "/" + data.file;
                        window.open(strFileUrl);
                    }
                } else
                {
                    alert(data.message);
                }
                $('.cms-bgloader-mask').hide();//show loader mask
                $('.cms-bgloader').hide(); //show loading image
            }
        });
    }
</script>