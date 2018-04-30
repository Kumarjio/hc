<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>15 Step process completed job seeker(s)</h1>
                <div class="tab-row-container">
                    <p>Listed are all order refunded in your Career Portal</p>
                    <button name="print" id="print" type="button" class="btn btn-default btn-md export-btn" onclick="window.print();return false;" >Print</button>
                    <button name="export" id="export" type="button" class="btn btn-default btn-md export-btn" onclick="fn15ProcessCompletedExport()" >Export</button>
                </div>
                <div class="tab-row-container">
                    <div class="panel panel-default hidden-xs hidden-sm">
                        <div class="panel-heading emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th>&nbsp; ID &nbsp;</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Portal Name</th>
                                    <th>Phone Number</th>
                                    <th>Portal Creation Date</th>
                                    <th>Portal Cancellation Date</th>
                                </tr>
                            </table>
                        </div>
                        <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <?php
                                if (is_array($arrPortalOwnerList) && (count($arrPortalOwnerList) > 0)) {
                                    $intForI = 0;
                                    $class = null;
                                    foreach ($arrPortalOwnerList as $arrPortalOwner) {
                                        if ($intForI++ % 2 == 0) {
                                            $class = ' class="altrow"';
                                        }
                                        ?>
                                        <tr >
                                            <td>
                                                <?php
                                                echo $intForI;
                                                ?>
                                            </td>
                                            <td>
                                                <div class="user-title">
                                                    <?php echo $arrPortalOwner['user']['email']; ?>
                                                </div>
                                            </td>
                                            <td><?php echo $arrPortalOwner['employer_detail']['employer_user_fname']; ?></td>
                                            <td><?php echo $arrPortalOwner['employer_detail']['employer_user_lname']; ?></td>
                                            <td><?php echo $arrPortalOwner['career_portal']['career_portal_name']; ?></td>
                                            <td><?php echo $arrPortalOwner['employer_detail']['employer_contact_number']; ?></td>
                                            <td><?php echo date($productdateformat, strtotime($arrPortalOwner['career_portal']['career_portal_created_datetime'])); ?></td>
                                            <td><?php echo date($productdateformat, strtotime($arrPortalOwner['user']['user_inactivation_date'])); ?></td>

                                        </tr>
                                        <?php }
                                    ?>
                                </table>
                            </div>
                        <?php } else {
                            ?>
                            <table>
                                <tr>
                                    <td colspan='8' class="altrow">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan='8'><span style="margin-left:40%;">No Step process completed  job seeker</span></td>
                                </tr>
                            </table>
                        <?php } ?>

                    </div>
                </div>

                <div class="tab-row-container">
                    <div class="tab-controls-pagination">
                        <div class="pagination pagination-large">
                            <ul class="pagination">
                                <?php
                                if ($this->Paginator->hasPrev()) {
                                    echo $this->Paginator->prev(' << ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                }
                                ?>
                                &nbsp;
                                <?php
                                echo $this->Paginator->numbers(array('last' => 'Last page'));
                                ?>
                                &nbsp;
                                <?php
                                if ($this->Paginator->hasNext()) {
                                    echo $this->Paginator->next(__('next') . ' >> ', array(), null, array('class' => 'next disabled'));
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- del -->

            </div>
        </div>
    </div>
</div>
<style>
    .export-btn {
        float: right;
        margin-bottom: 13px;
        margin-top: -37px;
    }
</style>

<script src="<?php echo Router::url('/', true); ?>app/webroot/js/jquery.tablesorter.js" type="text/javascript"></script>
<script type="text/javascript">
                        $(document).ready(function ()
                        {
                            $("#product_list").tablesorter({
                                headers: {4: {sorter: false}}
                            });
                            $('.action').removeClass('header');
                        }
                        );
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.leftnavi').removeClass('active');
        $('#candnavi').addClass('active');

        //TABS - CLICKING ON THE USERS
        $(".panel-body.emp-dashboard-jobs .user-title a").click(function (event) {

            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
            event.preventDefault();
        });
    });

    function fn15ProcessCompletedExport()
    {
        var PortalId = '<?php echo $portalId; ?>';
        var strStartDate = '<?php echo $strStartDate; ?>';
        var strEndDate = '<?php echo $strEndDate; ?>';

        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: appBaseU + "privatelabelsiteanalytics/registered15ProcessCompletedExport",
            data: 'StartDate=' + strStartDate + "&EndDate=" + strEndDate + "&portalId=" + PortalId,
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