<?php include('includes/header.php'); ?>
<?php include('includes/login/auth.php'); ?>
<?php include('includes/list/main.php'); ?>

<?php
$conn = mysqli_connect($HCdbhost, $HCdbuser, $HCdbpass, $HCdbname);

$q = 'SELECT career_portal_id,career_portal_name FROM career_portal WHERE career_portal_published =1';
$r = mysqli_query($conn, $q);

$servicesq = 'SELECT productd_id,product_name FROM products WHERE product_type="Services" and product_publish_status =1 ORDER BY product_name ASC';
$services = mysqli_query($conn, $servicesq);

$coursesq = 'SELECT productd_id,product_name FROM products WHERE product_type="Course" and product_publish_status =1 ORDER BY product_name ASC';
$courses = mysqli_query($conn, $coursesq);

$productsq = 'SELECT productd_id,product_name FROM products WHERE product_type="Product" and product_publish_status =1 ORDER BY product_name ASC';
$products = mysqli_query($conn, $productsq);

$skillsoftq = 'SELECT productd_id,product_name FROM products WHERE product_type="SkillSoftcourse" and product_publish_status =1 ORDER BY product_name ASC';
$skillsofts = mysqli_query($conn, $skillsoftq);

?>

<script src="<?php echo get_app_info('path'); ?>/js/ckeditor/ckeditor.js?7"></script>
<script src="<?php echo get_app_info('path'); ?>/js/lists/editor.js?7"></script>

<form action="<?php echo get_app_info('path') ?>/includes/list/edit.php" method="POST" accept-charset="utf-8" class="form-vertical">
    <div class="row-fluid">
        <div class="span2">
            <?php include('includes/sidebar.php'); ?>
        </div> 

        <div class="span10">
            <div class="row-fluid">
                <div class="span12">
                    <div>
                        <p class="lead"><?php echo get_app_data('app_name'); ?></p>
                    </div>
                    <h2><?php echo _('Edit list'); ?></h2><br/>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span12">
                    <label class="control-label" for="list_name"><?php echo _('List name'); ?></label>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="list_name" name="list_name" placeholder="<?php echo _('The list name'); ?>" value="<?php echo get_lists_data('name', $_GET['l']); ?>">
                        </div>
                    </div>
                    <label class="control-label" for="list_name"><?php echo _('User type'); ?></label>
                    <div class="control-group">
                        <div class="controls">
                            <select class="input-xlarge" id="user_type" name="user_type">
                                <option value="">Choose User Type</option>
                                <option <?php
                                if (get_lists_data('user_type', $_GET['l']) == 'owner') {
                                    echo 'selected=selected';
                                }
                                ?> value="owner">Owner</option>
                                <option <?php
                                if (get_lists_data('user_type', $_GET['l']) == 'vendor') {
                                    echo 'selected=selected';
                                }
                                ?> value="vendor">Vendor</option>
                                <option <?php
                                if (get_lists_data('user_type', $_GET['l']) == 'candidate') {
                                    echo 'selected=selected';
                                }
                                ?> value="candidate">Candidate</option>
                            </select>
                        </div>
                    </div>
                    <label class="control-label" for="portal_list"><?php echo _('Portal'); ?></label>
                    <div class="control-group">
                        <div class="controls">
                            <select class="input-xlarge" id="portal_list" name="portal_list">
                                <option value="">Choose Portal</option>       
                                <?php
                                if ($r) {
                                    while ($row1 = mysqli_fetch_array($r)) {
                                        $career_portal_id = $row1['career_portal_id'];
                                        $career_portal_name = $row1['career_portal_name'];
                                        ?>
                                        <option <?php
                                        if (get_lists_data('portal_id', $_GET['l']) == $career_portal_id) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $career_portal_id; ?>"><?php echo stripslashes($career_portal_name); ?></option>       
                                            <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div  id="OwnerStatus">
                        <label class="control-label" for="subscribe_type"><?php echo _('Subscribe type'); ?></label>
                        <div class="control-group">
                            <div class="controls">
                                <select class="input-xlarge" id="subscribe_type" name="subscribe_type">
                                    <option value="">Choose Subscribe Type</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == 'all') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="all">All</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == '1') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="1">Active Portal Owners</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == '0') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="0">Inactive Portal Owners</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div  id="VendorStatus">
                        <label class="control-label" for="subscribe_type"><?php echo _('Subscribe type'); ?></label>
                        <div class="control-group">    
                            <div class="controls">
                                <select class="input-xlarge" id="subscribe_type" name="subscribe_type">
                                    <option value="">Choose Subscribe Type</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == 'all') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="all">All</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == '1') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="1">Active</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == '0') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div  id="CandidateStatus">
                        <label class="control-label" for="subscribe_type"><?php echo _('Subscribe type'); ?></label>
                        <div class="control-group">    
                            <div class="controls">
                                <select class="input-xlarge" id="subscribe_type" name="subscribe_type">
                                    <option value="">Choose Subscribe Type</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == 'all') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="all">All</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == '1') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="1">Active</option>
                                    <option <?php
                                    if (get_lists_data('subscribe_status', $_GET['l']) == '0') {
                                        echo 'selected=selected';
                                    }
                                    ?> value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="ProductTypes">
                        <label class="control-label" for="product_type"><?php echo _('Product type'); ?></label>
                        <div class="control-group">    
                            <div class="controls">
                                <select class="input-xlarge" id="product_type" name="product_type">
                                    <option value="">Choose Product Type</option>
                                    <option <?php
                                        if (get_lists_data('product_type', $_GET['l']) == "products") {
                                            echo 'selected=selected';
                                        }
                                        ?> value="products">Products</option>
                                    <option <?php
                                        if (get_lists_data('product_type', $_GET['l']) == "services") {
                                            echo 'selected=selected';
                                        }
                                        ?> value="services">Services</option>
                                    <option <?php
                                        if (get_lists_data('product_type', $_GET['l']) == "course") {
                                            echo 'selected=selected';
                                        }
                                        ?> value="course">Course</option>
                                    <option <?php
                                        if (get_lists_data('product_type', $_GET['l']) == "skillsoftcourse") {
                                            echo 'selected=selected';
                                        }
                                        ?> value="skillsoftcourse">Skill Soft Course</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="servicesListDiv">
                        <label class="control-label" for="services"><?php echo _('Services'); ?></label>
                        <div class="control-group">    
                            <div class="controls">
                                <select class="input-xlarge" id="services" name="services">
                                    <option value="">Choose Service</option>
                                    <?php
                                    if ($services) {
                                        while ($servicesList = mysqli_fetch_array($services)) {
                                            $services_id = $servicesList['productd_id'];
                                            $service_name = $servicesList['product_name'];
                                            ?>
                                            <option <?php
                                        if (get_lists_data('service_id', $_GET['l']) == $services_id) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $services_id; ?>"><?php echo stripslashes($service_name); ?></option>       
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="courseListDiv">
                        <label class="control-label" for="course"><?php echo _('Course'); ?></label>
                        <div class="control-group">    
                            <div class="controls">
                                <select class="input-xlarge" id="course" name="course">
                                    <option value="">Choose Course</option>
                                    <?php
                                    if ($courses) {
                                        while ($coursesList = mysqli_fetch_array($courses)) {
                                            $course_id = $coursesList['productd_id'];
                                            $course_name = $coursesList['product_name'];
                                            ?>
                                            <option <?php
                                        if (get_lists_data('course_id', $_GET['l']) == $course_id) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $course_id; ?>"><?php echo stripslashes($course_name); ?></option>       
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="productsListDiv">
                <label class="control-label" for="Products"><?php echo _('Products'); ?></label>
                <div class="control-group">    
                    <div class="controls">
                            <select class="input-xlarge" id="products" name="products">
                            <option value="">Choose Product</option>
                            <?php
                        if ($products) {
                            while ($productsList = mysqli_fetch_array($products)) {
                                $product_id = $productsList['productd_id'];
                                $product_name = $productsList['product_name'];
                                ?>
                                <option <?php
                                        if (get_lists_data('product_id', $_GET['l']) == $product_id) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $product_id; ?>"><?php echo stripslashes($product_name); ?></option>       
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
                    <div id="skillsoftcourseListDiv">
                <label class="control-label" for="Skillsoftcourse"><?php echo _('Skillsoft Course'); ?></label>
                <div class="control-group">    
                    <div class="controls">
                            <select class="input-xlarge" id="skillsofts" name="skillsofts">
                            <option value="">Choose Skillsoft Course</option>
                            <?php
                        if ($skillsofts) {
                            while ($skillsoftsList = mysqli_fetch_array($skillsofts)) {
                               $skillsofts_id = $skillsoftsList['productd_id'];
                                $skillsofts_name = $skillsoftsList['product_name'];
                                ?>
                                <option <?php
                                        if (get_lists_data('skillsofts_id', $_GET['l']) == $skillsofts_id) {
                                            echo 'selected=selected';
                                        }
                                        ?> value="<?php echo $skillsofts_id; ?>"><?php echo stripslashes($skillsofts_name); ?></option>       
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
                </div>   
            </div>
            <hr/>

            <div class="row-fluid">
                <div class="span12">
                    <h2><?php echo _('Subscribe settings'); ?></h2><br/>
                </div>
            </div>

            <div class="row-fluid">

                <div class="span4">
                    <label class="control-label"><strong><?php echo _('List type'); ?></strong></label>
                    <div class="well">
                        <p><?php echo _('If you select double opt-in, users will be required to click a link in a confirmation email they\'ll receive when they sign up via the subscribe form or API.'); ?></p>
                        <p>
                        <div class="btn-group" data-toggle="buttons-radio">
                            <a href="javascript:void(0)" title="" class="btn" id="single"><i class="icon icon-angle-right"></i> <?php echo _('Single Opt-In'); ?></a>
                            <a href="javascript:void(0)" title="" class="btn" id="double"><i class="icon icon-double-angle-right"></i> <?php echo _('Double Opt-In'); ?></a>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {
                            <?php
                            $opt_in = get_lists_data('opt_in', $_GET['l']);
                            if ($opt_in == 0):
                                ?>
                                    $("#single").button('toggle');
                                    $("#opt_in").val("0");
                            <?php else: ?>
                                    $("#double").button('toggle');
                                    $("#opt_in").val("1");
                            <?php endif; ?>
                                $("#single").click(function () {
                                    $("#opt_in").val("0");
                                });
                                $("#double").click(function () {
                                    $("#opt_in").val("1");
                                });
                            });
                        </script>
                        </p>
                    </div>

                    <label class="control-label" for="subscribed_url"><strong><?php echo _('Subscribe success page'); ?></strong></label>
                    <div class="well">
                        <p><?php echo _('When users subscribe through the subscribe form, they\'ll be sent to a generic subscription confirmation page. To redirect users to a page of your preference, enter the link below. If you chose double opt-in as your List Type, this page will tell them a confirmation email has been sent to them.'); ?></p>
                        <label class="control-label" for="subscribed_url"><?php echo _('Page URL'); ?></label>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="subscribed_url" name="subscribed_url" placeholder="http://" style="width: 98%;" value="<?php echo get_lists_data('subscribed_url', $_GET['l']); ?>">
                            </div>
                        </div>
                        <div class="well" style="background: #FFFDEC;">
                            <p><?php echo _('You can also pass \'Email\' and \'listID\' data into the \'Subscribe success page\' like so'); ?>:</p>
                            <p><?php echo _('Example'); ?>:<br/><pre>http://domain.com/subscribed.php?name=%n&email=%e&listid=%l</pre></p>
                            <p><?php echo _('<code>%n</code> will be converted into the subscriber\'s name. <code>%e</code> will be converted into the \'email\' and <code>%l</code> will be converted into the \'listID\' that subscribed'); ?>.</p>
                        </div>
                    </div>

                    <label class="control-label" for="subscribed_url"><strong><?php echo _('Subscription confirmed page'); ?></strong> (<?php echo _('only applies for double opt-ins'); ?>)</label>
                    <div class="well">
                        <p><?php echo _('If your List Type is double opt-in, users who clicked the confirmation URL will be sent to a generic confirmation page. To redirect users to a page of your preference, enter the link below.'); ?></p>
                        <label class="control-label" for="confirm_url"><?php echo _('Page URL'); ?></label>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="confirm_url" name="confirm_url" placeholder="http://" style="width: 98%;" value="<?php echo get_lists_data('confirm_url', $_GET['l']); ?>">
                            </div>
                        </div>
                        <div class="well" style="background: #FFFDEC;">
                            <p><?php echo _('You can also pass \'Email\' and \'listID\' data into the \'Subscription confirmed page\' like so'); ?>:</p>
                            <p><?php echo _('Example'); ?>:<br/><pre>http://domain.com/confirmed.php?name=%n&email=%e&listid=%l</pre></p>
                            <p><?php echo _('<code>%n</code> will be converted into the subscriber\'s name. <code>%e</code> will be converted into the \'email\' and <code>%l</code> will be converted into the \'listID\' that subscribed'); ?>.</p>
                        </div>
                    </div>
                </div>

                <div class="span8">

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <?php $thankyou = get_lists_data('thankyou', $_GET['l']); ?>
                                <input type="checkbox" id="thankyou_email" name="thankyou_email" <?php
                                if ($thankyou == 1) {
                                    echo 'checked';
                                }
                                ?>>
                                       <?php echo _('Send user a thank you email after they subscribe through the subscribe form or API?'); ?>
                            </label>
                        </div>
                    </div>

                    <label class="control-label" for="thankyou_subject"><strong><?php echo _('Thank you email subject'); ?></strong></label>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="thankyou_subject" name="thankyou_subject" placeholder="<?php echo _('Email subject'); ?>" style="width: 98%;" value="<?php echo get_lists_data('thankyou_subject', $_GET['l']); ?>">
                        </div>
                    </div>

                    <label class="control-label" for="thankyou_message"><strong><?php echo _('Thank you email message'); ?></strong></label>
                    <div class="control-group">
                        <div class="controls">
                            <textarea class="input-xlarge" id="thankyou_message" name="thankyou_message" rows="10" placeholder="<?php echo _('Email message'); ?>">
                                <?php echo get_lists_data('thankyou_message', $_GET['l']); ?>
                            </textarea>
                        </div>
                    </div>

                    <br/>

                    <label class="control-label" for="confirmation_subject"><strong><?php echo _('Confirmation email subject'); ?></strong> (<?php echo _('only applies for double opt-ins'); ?>)<br/><em>* <?php echo _('A generic subject line will be used if you leave this field empty.'); ?></em></label>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="confirmation_subject" name="confirmation_subject" placeholder="<?php echo _('Subject of confirmation email'); ?>" style="width: 98%;" value="<?php echo get_lists_data('confirmation_subject', $_GET['l']); ?>">
                        </div>
                    </div>

                    <label class="control-label" for="confirmation_email"><strong><?php echo _('Double Opt-In confirmation message'); ?></strong> (<?php echo _('only applies for double opt-ins'); ?>)<br/><em>* <?php echo _('A generic email message will be used if you leave this field empty.'); ?></em><br/><em>* <?php echo _('Don\'t forget to include the confirmation link tag'); ?> </em><code id="confirmation_link_tag">[confirmation_link]</code><em> <?php echo _('somewhere in your message'); ?></em>.</label>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $("#confirmation_link_tag").click(function () {
                                $(this).selectText();
                            });
                        });
                    </script>
                    <div class="control-group">
                        <div class="controls">
                            <textarea class="input-xlarge" id="confirmation_email" name="confirmation_email" rows="10" placeholder="<?php echo _('Email message'); ?>">
                                <?php echo get_lists_data('confirmation_email', $_GET['l']); ?>
                            </textarea>
                        </div>
                    </div>

                </div> 
            </div>

            <br/>

            <hr/>

            <div class="row-fluid">
                <div class="span12">
                    <h2><?php echo _('Unsubscribe settings'); ?></h2><br/>
                </div>
            </div>

            <div class="row-fluid">

                <div class="span4">
                    <label class="control-label"><strong><?php echo _('Unsubscribe user'); ?></strong></label>
                    <div class="well">
                        <p><?php echo _('When a user unsubscribes from a newsletter or through the API, choose whether to unsubscribe them from this list only, or unsubscribe them from all lists in this brand.'); ?></p>
                        <p>
                        <div class="btn-group" data-toggle="buttons-radio">
                            <a href="javascript:void(0)" title="" class="btn" id="this-list"><i class="icon icon-minus"></i> <?php echo _('Only this list'); ?></a>
                            <a href="javascript:void(0)" title="" class="btn" id="all-list"><i class="icon icon-reorder"></i> <?php echo _('All lists'); ?></a>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function () {
<?php
$ual = get_lists_data('unsubscribe_all_list', $_GET['l']);
if ($ual == 0):
    ?>
                                    $("#this-list").button('toggle');
                                    $("#unsubscribe_all_list").val("0");
<?php else: ?>
                                    $("#all-list").button('toggle');
                                    $("#unsubscribe_all_list").val("1");
<?php endif; ?>

                                $("#this-list").click(function () {
                                    $("#unsubscribe_all_list").val("0");
                                });
                                $("#all-list").click(function () {
                                    $("#unsubscribe_all_list").val("1");
                                });
                            });
                        </script>
                        </p>
                    </div>

                    <label class="control-label" for="unsubscribed_url"><strong><?php echo _('Unsubscribe confirmation page'); ?></strong></label>
                    <div class="well">
                        <p><?php echo _('When users unsubscribe from a newsletter, they\'ll be sent to a generic unsubscription confirmation page. To redirect users to a page of your preference, enter the link below.'); ?></p>
                        <label class="control-label" for="subscribed_url"><?php echo _('Page URL'); ?></label>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="unsubscribed_url" name="unsubscribed_url" placeholder="http://" style="width: 98%;" value="<?php echo get_lists_data('unsubscribed_url', $_GET['l']); ?>">
                            </div>
                        </div>
                        <div class="well" style="background: #FFFDEC;">
                            <p><?php echo _('You can also pass \'Email\' and \'listID\' data into the \'Unsubscribe confirmation page\' like so'); ?>:</p>
                            <p><?php echo _('Example'); ?>:<br/><pre>http://domain.com/unsubscribed.php?email=%e&listid=%l</pre></p>
                            <p><?php echo _('<code>%e</code> will be converted into the \'email\' and <code>%l</code> will be converted into the \'listID\' that unsubscribed'); ?>.</p>
                        </div>
                    </div>
                </div>

                <div class="span8">

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <?php $goodbye = get_lists_data('goodbye', $_GET['l']); ?>
                                <input type="checkbox" id="goodbye_email" name="goodbye_email" <?php
                                if ($goodbye == 1) {
                                    echo 'checked';
                                }
                                ?>>
                                       <?php echo _('Send user a confirmation email after they unsubscribe from a newsletter or through the API?'); ?>
                            </label>
                        </div>
                    </div>

                    <label class="control-label" for="goodbye_subject"><strong><?php echo _('Goodbye email subject'); ?></strong></label>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="goodbye_subject" name="goodbye_subject" placeholder="<?php echo _('Email subject'); ?>" style="width: 98%;" value="<?php echo get_lists_data('goodbye_subject', $_GET['l']); ?>">
                        </div>
                    </div>

                    <label class="control-label" for="goodbye_message"><strong><?php echo _('Goodbye email message'); ?></strong></label>
                    <div class="control-group">
                        <div class="controls">
                            <textarea class="input-xlarge" id="goodbye_message" name="goodbye_message" rows="10" placeholder="<?php echo _('Email message'); ?>">
                                <?php echo get_lists_data('goodbye_message', $_GET['l']); ?>
                            </textarea>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_GET['i']; ?>">
                    <input type="hidden" name="list" value="<?php echo $_GET['l']; ?>">
                    <input type="hidden" name="opt_in" id="opt_in" value="">
                    <input type="hidden" name="unsubscribe_all_list" id="unsubscribe_all_list" value="">

                </div> 
            </div>
        </div>

    </div>

    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <button type="submit" class="btn btn-inverse" style="float:right;"><i class="icon-ok icon-white"></i> <?php echo _('Save'); ?></button>
        </div>
    </div>

</form>
<?php include('includes/footer.php'); ?>
<script>
    $(document).ready(function () {
        var user_type = $('#user_type option:selected').attr('value');
        if (user_type == "owner")
        {
            $('#OwnerStatus').show();
            $('#VendorStatus').hide();
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();

        } else if (user_type == "vendor")
        {
            $('#VendorStatus').show();
            $('#OwnerStatus').hide();
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();
        } else if (user_type == "candidate") {
            $('#CandidateStatus').show();
            $('#ProductTypes').show();
            $('#VendorStatus').hide();
            $('#OwnerStatus').hide();
        } else {
            $('#CandidateStatus').hide();
            $('#VendorStatus').hide();
            $('#OwnerStatus').hide();
            $('#ProductTypes').hide();
        }
        
        var product_type = $('#product_type option:selected').attr('value');
        if (product_type == "services")
        {
            $('#servicesListDiv').show();
            $('#courseListDiv').hide();
            $('#productsListDiv').hide();
            $('#skillsoftcourseListDiv').hide();
        }else if(product_type == "course") {
            $('#servicesListDiv').hide();
            $('#courseListDiv').show();
            $('#productsListDiv').hide();
            $('#skillsoftcourseListDiv').hide();
        }else if(product_type == "products") {
            $('#productsListDiv').show();
            $('#servicesListDiv').hide();
            $('#courseListDiv').hide();
            $('#skillsoftcourseListDiv').hide();
        }else if(product_type == "skillsoftcourse") {
            $('#skillsoftcourseListDiv').show();
            $('#servicesListDiv').hide();
            $('#courseListDiv').hide();
            $('#productsListDiv').hide();
        } else {
            $('#skillsoftcourseListDiv').hide();
            $('#servicesListDiv').hide();
            $('#courseListDiv').hide();
            $('#productsListDiv').hide();
        }
        
    });

    $('#user_type').change(function () {
        var user_type = $('#user_type option:selected').attr('value');
        if (user_type == "owner")
        {
            $('#OwnerStatus').show();
            $('#VendorStatus').hide();
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();

        } else if (user_type == "vendor")
        {
            $('#VendorStatus').show();
            $('#OwnerStatus').hide();
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();
        } else if (user_type == "candidate")
        {
            $('#VendorStatus').show();
            $('#ProductTypes').show();
            $('#OwnerStatus').hide();
            $('#CandidateStatus').hide();
        } else {
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();
            $('#VendorStatus').hide();
            $('#OwnerStatus').hide();
        }
    });
    
    $('#product_type').change(function () {
        var product_type = $('#product_type option:selected').attr('value');
        if (product_type == "services")
        {
            $('#servicesListDiv').show();
            $('#courseListDiv').hide();
            $('#productsListDiv').hide();
            $('#skillsoftcourseListDiv').hide();
        }else if(product_type == "course") {
            $('#servicesListDiv').hide();
            $('#courseListDiv').show();
            $('#productsListDiv').hide();
            $('#skillsoftcourseListDiv').hide();
        }else if(product_type == "products") {
            $('#productsListDiv').show();
            $('#servicesListDiv').hide();
            $('#courseListDiv').hide();
            $('#skillsoftcourseListDiv').hide();
        }else if(product_type == "skillsoftcourse") {
            $('#skillsoftcourseListDiv').show();
            $('#servicesListDiv').hide();
            $('#courseListDiv').hide();
            $('#productsListDiv').hide();
        } else {
            $('#skillsoftcourseListDiv').hide();
            $('#servicesListDiv').hide();
            $('#courseListDiv').hide();
            $('#productsListDiv').hide();
        }
    });
</script>