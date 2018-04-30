<?php
if (is_array($arrMessage) && (count($arrMessage) > 0)) {
    if ($arrMessage['status'] == "success") {
        $strStyle = "";
        $strMessage = $arrMessage['mssg'];
    } else {
        $strStyle = "style='display:none;'";
    }
} else {
    $strStyle = "style='display:none;'";
}
?>
<div <?php echo $strStyle; ?> id="alertcvMessage"><div class="alert alert-success">
        <img src="<?php echo Router::url('/', true); ?>images/icon-alert-success.png" alt="image description">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <?php echo $strMessage; ?>
    </div></div>
<?php
//print("<pre>");
//print_r($strCurrentUser);
//exit;
?>
<div class="page-content-wrapper employers-type">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" style="min-height: 500px;">
                <h1>Jobs</h1>
                <a href="<?php echo Router::url(array('controller' => 'Privatelabelsitejobboard', 'action' => 'addjob', $strCurrentUser['portal_id']), true); ?>"><button type="button" class="btn btn-primary emp-dashboard-jobs btn-sm">Add New</button></a>
                <p>Your Career Portal allows you to enter your open job orders.  They will be visible on your Job Seeker’s Home Page above the Job Boards.  Anyone registered in your Career Portal will be able to apply for those jobs.</p>
                <!--<div class="tab-row-container">
                        <div class="tab-filters">
                                <a href="#" class="active">All <span>(7)</span></a> |
                                <a href="#" class="link-primary">Published <span>(4)</span></a> |
                                <a href="#" class="link-primary">Draft <span>(1)</span></a> |
                                <a href="#" class="link-primary">Trash<span>(1)</span></a>									
                        </div>
                        <div class="tab-search">
                                <input type="text" value="" name="search" placeholder="Search">
                                <button type="button" class="btn btn-default btn-md">Search</button>
                        </div>
                </div>-->
                <!--<div class="tab-row-container">
                        <div class="tab-controls-actions">
                                <div class="form-group">
                                        <select name="bulk-actions" title="Bulk Actions">
                                                <option value="value1">Bulk Actions</option>
                                                <option value="value2">Bulk Action2</option>
                                                <option value="value3">Bulk Action3</option>
                                                <option value="value4">Bulk Action4</option>
                                        </select>
                                        <button type="button" class="btn btn-default btn-md">Apply</button>
                                </div>
                                <div class="form-group">
                                        <select name="date-filter" title="All Dates">
                                                <option value="value1">All Dates</option>
                                                <option value="value2">All Dates2</option>
                                                <option value="value3">All Dates3</option>
                                                <option value="value4">All Dates4</option>
                                        </select>
                                        <button type="button" class="btn btn-default btn-md">Filter</button>
                                </div>
                        </div>
                        <div class="tab-controls-pagination">
                                <button type="button" class="btn btn-default disabled items-counter"><span>5 of 17 items</span></button>
                                <button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
                                <button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
                                <input type="text" value="" name="input-page-number" placeholder="1">
                                <button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
                                <button type="button" class="btn btn-default goto-next-active"><span></span></button>
                                <button type="button" class="btn btn-default goto-end-active"><span></span></button>
                        </div>
                </div>-->

                <?php
//print("<pre>");
//print_r($arrPortalJobs);
//exit;

                if (is_array($arrPortalJobs) && (count($arrPortalJobs) > 0)) {
                    ?>
                    <div class="tab-row-container">
                        <div class="panel panel-default hidden-xs hidden-sm">
                            <!--<div class="panel-heading emp-dashboard-jobs">
                                    <table>
                                            <tr>
                                                    <th><input type="checkbox" value=""></th>
                                                    <th id="trigger-link">Title</th>
                                                    <th class="selected">Views<span></span></th>
                                                    <th>Applications</th>
                                                    <th>Author</th>
                                                    <th>Last update</th>
                                                    <th>Date added</th>
                                            </tr>
                                    </table>
                            </div>-->
                            <div class="panel-heading emp-dashboard-jobs">
                                <table id="product_list" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" value=""></th>
                                            <th>Title</th>
                                            <th>Views<span></span></th>
                                            <th>Applications</th>
                                            <th>Author</th>
                                            <th>Last update</th>
                                            <th>Date added</th>
                                        </tr>
                                    <thead>
                                    <tbody class="panel-body emp-dashboard-jobs">
                                        <?php
                                        foreach ($arrPortalJobs as $arrJob) {

                                            $strEditLink = Router::url(array('controller' => 'privatelabelsitejobboard', 'action' => 'editjob', $strCurrentUser['portal_id'], $arrJob['Jobberlandjob']['id']), true);

                                            $intJId = $arrJob['Jobberlandjob']['id'];
                                            ?>
                                            <tr id="product_list_<?php echo $intJId; ?>">
                                                <td>
                                                    <input type="checkbox" value="">
                                                </td>
                                                <td>
                                                    <div class="user-title">
                                                        <a href="#str<?php echo $arrJob['Jobberlandjob']['id']; ?>" id="task1" class="username-clickable"><?php echo $arrJob['Jobberlandjob']['job_title']; ?></a>
                                                    </div>
                                                </td>
                                                <td><?php echo $arrJob['Jobberlandjob']['views_count']; ?></td>
                                                <td><a href="#str<?php echo $arrJob['Jobberlandjob']['id']; ?>" class="username-clickable"><?php echo $arrJob['Jobberlandjob']['apply_count']; ?></a></td>
                                                <td>Owner</td>
                                                <td>
                                                    <?php
                                                    if ($arrJob['Jobberlandjob']['modified']) {
                                                        echo date("M d, Y", strtotime($arrJob['Jobberlandjob']['modified']));
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?></td>
                                                <td><?php echo date("M d, Y", strtotime($arrJob['Jobberlandjob']['created_at'])); ?></td>
                                            </tr>
                                            <tr id="str<?php echo $arrJob['Jobberlandjob']['id']; ?>" class="hide-str">
                                                <td></td>
                                                <td colspan="7">
                                                    <div id="task1-options" class="user-options">
                                                        <a href="<?php echo $strEditLink; ?>" class="link-primary">Edit</a> |
                                                        <a href="#" class="link-primary">Deactivate</a> |
                                                        <a href="#" class="link-primary">Dublicate</a> |
                                                        <a href="javascript:void(0);" onclick="deleteJob('<?php echo $intJId; ?>')" class="link-warning">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- SMALL TABLE -->
                        <div class="panel panel-default hidden-md hidden-lg">
                            <div class="panel-body emp-category small-view emp-dashboard-app">
                                <table>
                                    <tr>
                                        <td>Title</td>
                                        <td>UX/UI Expert</td>
                                    </tr>
                                    <tr>
                                        <td>Views</td>
                                        <td>1,245</td>
                                    </tr>
                                    <tr>
                                        <td>Applications</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <td>Author</td>
                                        <td>John Doe</td>
                                    </tr>
                                    <tr>
                                        <td>Last update</td>
                                        <td>Aug 23, 2015</td>
                                    </tr>
                                    <tr>
                                        <td>Date added</td>
                                        <td>Aug 23, 2015</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-footer emp-category">
                                <a href="#" class="link-primary">Load More</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="tab-controls-pagination">
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

                <!--<div class="panel-footer emp-dashboard-jobs">
                        <table>
                                <tr>
                                        <th><input type="checkbox" value=""></th>
                                        <th>Title</th>
                                        <th class="selected">Views<span></span></th>
                                        <th>Applications</th>
                                        <th>Author</th>
                                        <th>Last update</th>
                                        <th>Date added</th>
                                </tr>
                        </table>
                </div>-->


            </div>
            <!-- SMALL TABLE -->
            <div class="panel panel-default hidden-md hidden-lg">
                <div class="panel-body emp-category small-view emp-dashboard-app">
                    <table>
                        <tr>
                            <td>Title</td>
                            <td>UX/UI Expert</td>
                        </tr>
                        <tr>
                            <td>Views</td>
                            <td>1,245</td>
                        </tr>
                        <tr>
                            <td>Applications</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>Author</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>Last update</td>
                            <td>Aug 23, 2015</td>
                        </tr>
                        <tr>
                            <td>Date added</td>
                            <td>Aug 23, 2015</td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer emp-category">
                    <a href="#" class="link-primary">Load More</a>
                </div>
            </div>
        </div>

        <!--<div class="tab-row-container">
                <div class="tab-controls-actions">
                        <div class="form-group">
                                <select name="bulk-actions" title="Bulk Actions">
                                        <option value="value1">Bulk Actions</option>
                                        <option value="value2">Bulk Action2</option>
                                        <option value="value3">Bulk Action3</option>
                                        <option value="value4">Bulk Action4</option>
                                </select>
                                <button type="button" class="btn btn-default btn-md">Apply</button>
                        </div>
                        <div class="form-group">
                                <select name="date-filter" title="All Dates">
                                        <option value="value1">All Dates</option>
                                        <option value="value2">All Dates2</option>
                                        <option value="value3">All Dates3</option>
                                        <option value="value4">All Dates4</option>
                                </select>
                                <button type="button" class="btn btn-default btn-md">Filter</button>
                        </div>
                </div>
                <div class="tab-controls-pagination">
                        <button type="button" class="btn btn-default disabled items-counter"><span>5 of 17 items</span></button>
                        <button type="button" class="btn btn-default disabled goto-beginning"><span></span></button>
                        <button type="button" class="btn btn-default disabled goto-previous"><span></span></button>
                        <input type="text" value="" name="input-page-number" placeholder="1">
                        <button type="button" class="btn btn-default disabled pages-counter"><span>of 3</span></button>
                        <button type="button" class="btn btn-default goto-next-active"><span></span></button>
                        <button type="button" class="btn btn-default goto-end-active"><span></span></button>
                </div>
        </div>-->
        <!-- del -->


    </div>
</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.leftnavi').removeClass('active');
        $('#jobnavi').addClass('active');

        //TABS - CLICKING ON THE USERS
        $(".panel-body.emp-dashboard-jobs .user-title a").click(function (event) {

            $(this.getAttribute("href")).css('display', 'table-row');
            $(this.getAttribute("href") + ' div.user-options').css('display', 'inline-block');
            event.preventDefault();
        });
    });

    function deleteJob(intProductId)
    {
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "POST",
            url: strBaseUrl + "privatelabelsitejobboard/deletejob/" + intProductId,
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if (data.status == "success")
                {
                    //alert(data.content)
                    $('#alertcvMessage').html('<div class="alert alert-success"><img alt="image description" src="<?php echo Router::url('/',true); ?>images/icon-alert-success.png"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>' + data.message + '</div>');
                    $('#alertcvMessage').show();
                    $('#product_list_' + intProductId).remove();
                    $('#str' + intProductId).remove();
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image
                } else
                {
                    $('.tabloader').hide();
                    $('#alertcvMessage').html('<div class="alert alert-success"><img alt="image description" src="<?php echo Router::url('/',true); ?>images/icon-alert-success.png"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>' + data.message + '</div>');
                    $('#alertcvMessage').show();
                }
            }
        });
    }

</script>

<!--<div class="users index container-layout">

        <div id="page-title">
                <h3>Portal Jobs</h3>
                </div>

                <iframe style="width:100%;height:1000px; border:none" src="<?php echo $strPostJobIndexUrl; ?>" ></iframe>

</div>-->
<!--<div class="actions">
        <h3>Actions</h3>
        <ul>
                <li><?php echo $this->Html->link('Post Jobs', array('action' => 'add', $portal_id)); ?></li>
        </ul>
</div>-->