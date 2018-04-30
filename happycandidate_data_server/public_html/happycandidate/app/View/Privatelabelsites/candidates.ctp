<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Candidates</h1>
                <div class="tab-row-container">
                    <p>Listed are all registrants in your Career Portal</p>
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
                                    <th>Phone Number</th>
                                    <th>Date added</th>
                                </tr>
                            </table>
                        </div>
                        <?php if (is_array($arrCandidate) && (count($arrCandidate) > 0)) { ?>
                        <div class="panel-body emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <?php $count = 0; foreach ($arrCandidate as $arrJob) {
                                    $intJId = $arrJob['Candidate']['candidate_id'];
                                    $strViewDetail = Router::url(array('controller' => 'privatelabelsites', 'action' => 'candidatedetail', $intJId), true);
                                if($arrJob['Candidate']['candidate_first_name'] !=''){
                                ?>
                                <tr id="product_list_<?php echo $intJId; ?>">
                                    <td>
                                        <?php echo $count+1;?>
                                    </td>
                                    <td><div class="user-title"><a href="#str<?php echo $intJId; ?>" id="task1" class="username-clickable"><?php echo $arrJob['Candidate']['candidate_email']; ?></a></div></td>
                                    <td>
                                        <?php echo $arrJob['Candidate']['candidate_first_name']; ?>
                                    </td>
                                    <td><?php echo $arrJob['Candidate']['candidate_last_name']; ?></td>
                                    <td><?php echo $arrJob['Candidate']['cand_phone_number']; ?></td>
                                    <td><?php echo date("M d, Y", strtotime($arrJob['Candidate']['candidate_creation_date'])); ?></td>
                                </tr>
                                <tr id="str<?php echo $intJId; ?>" class="hide-str">
                                    <td></td>
                                    <td colspan="6">
                                        <div id="task1-options" class="user-options">
                                            <a href="<?php echo $strViewDetail; ?>" class="link-primary">View</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $count++; } }?>
                            </table>
                        </div>
                        <?php } ?>
<!--                        <div class="panel-footer emp-dashboard-jobs emp-dashboard-pages">
                            <table>
                                <tr>
                                    <th>&nbsp; ID &nbsp;</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Date added</th>
                                </tr>
                            </table>
                        </div>-->
                    </div>
                </div>

                <div class="tab-row-container">
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
                </div>
                <!-- del -->

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#product_list").tablesorter({
            // pass the headers argument and assing a object
            headers: {
                // assign the secound column (we start counting zero)
                0: {
                    // disable it by setting the property sorter to false
                    sorter: false
                },
                // assign the third column (we start counting zero)
                3: {
                    // disable it by setting the property sorter to false
                    sorter: false
                },
                // assign the third column (we start counting zero)
                4: {
                    // disable it by setting the property sorter to false
                    sorter: false
                },
                // assign the third column (we start counting zero)
                5: {
                    // disable it by setting the property sorter to false
                    sorter: false
                }

            }
        });
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
</script>