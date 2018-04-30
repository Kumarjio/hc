<?php include('includes/header.php'); ?>
<?php include('includes/login/auth.php'); ?>
<?php include('includes/create/main.php'); ?>

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
<!-- Validation -->
<script type="text/javascript" src="<?php echo get_app_info('path'); ?>/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#list-form").validate({
            rules: {
                list_name: {
                    required: true
                }
            },
            messages: {
                list_name: "<?php echo addslashes(_('List name is required')); ?>"
            }
        });
    });
</script>

<div class="row-fluid">
    <div class="span2">
        <?php include('includes/sidebar.php'); ?>
    </div> 
    <div class="span10">
        <div>
            <p class="lead"><?php echo get_app_data('app_name'); ?></p>
        </div>
        <h2><?php echo _('Add a new list'); ?></h2><br/>
        <form action="<?php echo get_app_info('path') ?>/includes/subscribers/import-add.php" method="POST" accept-charset="utf-8" class="form-vertical" enctype="multipart/form-data" id="list-form">
            <label class="control-label" for="list_name"><?php echo _('List name'); ?></label>
            <div class="control-group">
                <div class="controls">
                    <input type="text" class="input-xlarge" id="list_name" name="list_name" placeholder="<?php echo _('The name of your new list'); ?>">
                </div>
            </div>
            <label class="control-label" for="list_name"><?php echo _('User type'); ?></label>
            <div class="control-group">
                <div class="controls">
                    <select class="input-xlarge" id="user_type" name="user_type">
                        <option value="">Choose User Type</option>
                        <option value="owner">Owner</option>
                        <option value="vendor">Vendor</option>
                        <option value="candidate">Candidate</option>
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
                                <option value="<?php echo $career_portal_id; ?>"><?php echo stripslashes($career_portal_name); ?></option>       
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
                        <select class="input-xlarge" id="subscribe_type" name="subscribe_type" onchange="changeStatusValue(this.value);">
                            <option value="">Choose Subscribe Type</option>
                            <option value="all">All</option>
                            <option value="1">Active Portal Owners</option>
                            <option value="0">Inactive Portal Owners</option>
                        </select>
                    </div>
                </div>
            </div>
            <div  id="VendorStatus">
                <label class="control-label" for="subscribe_type"><?php echo _('Subscribe type'); ?></label>
                <div class="control-group">    
                    <div class="controls">
                        <select class="input-xlarge" id="subscribe_type" name="subscribe_type"  onchange="changeStatusValue(this.value)";>
                            <option value="">Choose Subscribe Type</option>
                            <option value="all">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div  id="CandidateStatus">
                <label class="control-label" for="subscribe_type"><?php echo _('Subscribe type'); ?></label>
                <div class="control-group">    
                    <div class="controls">
                            <select class="input-xlarge" id="subscribe_type" name="subscribe_type" onchange="changeStatusValue(this.value)";>
                            <option value="">Choose Subscribe Type</option>
                            <option value="all">All</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
                            <option value="products">Products</option>
                            <option value="services">Services</option>
                            <option value="course">Course</option>
                            <option value="skillsoftcourse">Skill Soft Course</option>
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
                                <option value="<?php echo $services_id; ?>"><?php echo stripslashes($service_name); ?></option>       
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
                                <option value="<?php echo $course_id; ?>"><?php echo stripslashes($course_name); ?></option>       
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
                                <option value="<?php echo $product_id; ?>"><?php echo stripslashes($product_name); ?></option>       
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
                                <option value="<?php echo $skillsofts_id; ?>"><?php echo stripslashes($skillsofts_name); ?></option>       
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="app" value="<?php echo get_app_info('app'); ?>">
            <input type="hidden" name="subscribe_status" id="subscribe_status" value="">

            <button type="submit" class="btn btn-inverse"><i class="icon icon-plus"></i> <?php echo _('Add'); ?></button>
        </form>
    </div>   
</div>
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
            $('#VendorStatus').hide();
            $('#OwnerStatus').hide();
            $('#ProductTypes').show();
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
            $("#subscribe_status").val('');
            $('#OwnerStatus').show();
            $('#VendorStatus').hide();
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();

        } else if (user_type == "vendor")
        {
            $("#subscribe_status").val('');
            $('#VendorStatus').show();
            $('#OwnerStatus').hide();
            $('#CandidateStatus').hide();
            $('#ProductTypes').hide();
        } else if (user_type == "candidate"){
            $("#subscribe_status").val('');
            $('#CandidateStatus').show();
            $('#ProductTypes').show();
            $('#VendorStatus').hide();
            $('#OwnerStatus').hide();
        } else {
            $("#subscribe_status").val('');
            $('#CandidateStatus').hide();
            $('#VendorStatus').hide();
            $('#OwnerStatus').hide();
            $('#ProductTypes').hide();
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
    
    function changeStatusValue(subscribeStatus){
        $("#subscribe_status").val(subscribeStatus);
    }
    
</script>
