<?php include('includes/header.php');?>
<?php include('includes/login/auth.php');?>
<?php include('includes/templates/main.php');?>
<?php 
	//IDs
	$aid = isset($_GET['i']) && is_numeric($_GET['i']) ? mysqli_real_escape_string($mysqli, $_GET['i']) : exit;
	
	if(get_app_info('is_sub_user')) 
	{
		if(get_app_info('app')!=get_app_info('restricted_to_app'))
		{
			echo '<script type="text/javascript">window.location="'.addslashes(get_app_info('path')).'/templates?i='.get_app_info('restricted_to_app').'"</script>';
			exit;
		}
	}

    /** HC Database connection **/
    $conn = mysqli_connect($HCdbhost, $HCdbuser, $HCdbpass, $HCdbname);

//    $servicesq = 'SELECT productd_id,product_name FROM products WHERE product_type="Services" and product_publish_status =1 ORDER BY product_name ASC';
    $servicesq = "SELECT Resources.productd_id,product_name FROM products AS Resources,vendor_service AS Vendorservice WHERE Resources.product_publish_status = '1' AND Resources.productd_id = Vendorservice.service_id AND Vendorservice.status = 'Active' AND product_type = 'Services' ORDER BY product_name ASC";
    $services = mysqli_query($conn, $servicesq);

//    $coursesq = 'SELECT productd_id,product_name FROM products WHERE product_type="Course" and product_publish_status =1 ORDER BY product_name ASC';
    $coursesq = "SELECT Resources.productd_id,product_name FROM products AS Resources,vendor_service AS Vendorservice WHERE Resources.product_publish_status = '1' AND Resources.productd_id = Vendorservice.service_id AND Vendorservice.status = 'Active' AND product_type = 'Course' ORDER BY product_name ASC";
    $courses = mysqli_query($conn, $coursesq);

//    $productsq = 'SELECT productd_id,product_name FROM products WHERE product_type="Product" and product_publish_status =1 ORDER BY product_name ASC';
    $productsq = "SELECT Resources.productd_id,product_name FROM products AS Resources,vendor_service AS Vendorservice WHERE Resources.product_publish_status = '1' AND Resources.productd_id = Vendorservice.service_id AND Vendorservice.status = 'Active' AND product_type = 'Product' ORDER BY product_name ASC";
    $products = mysqli_query($conn, $productsq);

//    $skillsoftq = 'SELECT productd_id,product_name FROM products WHERE product_type="SkillSoftcourse" and product_publish_status =1 ORDER BY product_name ASC';
    $skillsoftq = "SELECT Resources.productd_id,product_name FROM products AS Resources,vendor_service AS Vendorservice WHERE Resources.product_publish_status = '1' AND Resources.productd_id = Vendorservice.service_id AND Vendorservice.status = 'Active' AND product_type = 'SkillSoftcourse' ORDER BY product_name ASC";
    $skillsofts = mysqli_query($conn, $skillsoftq);
    
    

?>

<script src="<?php echo get_app_info('path');?>/js/ckeditor/ckeditor.js?7"></script>
<script src="<?php echo get_app_info('path');?>/js/create/editor.js?7"></script>

<!-- Validation -->
<script type="text/javascript" src="<?php echo get_app_info('path');?>/js/validate.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#edit-form").validate({
			rules: {
				template_name: {
					required: true	
				},
				html: {
					required: true
				}
			},
			messages: {
				template_name: "<?php echo addslashes(_('The name of this template is required'));?>",
				html: "<?php echo addslashes(_('Your HTML code is required'));?>"
			}
		});
	});
</script>

<div class="row-fluid">
    <div class="span2">
        <?php include('includes/sidebar.php'); ?>
    </div> 
    <div class="span10">
        <div class="row-fluid">
            <div class="span10">
                <div>
                    <p class="lead"><?php echo get_app_data('app_name'); ?></p>
                </div>
                <h2><?php echo _('Create template'); ?></h2><br/>
            </div>
        </div>

        <div class="row-fluid">
            <form action="<?php echo get_app_info('path') ?>/includes/templates/save-template.php?i=<?php echo get_app_info('app') ?>" method="POST" accept-charset="utf-8" class="form-vertical" id="edit-form">
                <div class="span3">
                    <label class="control-label" for="template_name"><?php echo _('Template name'); ?></label>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="template_name" name="template_name" placeholder="<?php echo _('Name of this template'); ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-inverse" id="save-button"><i class="icon-ok icon-white"></i> <?php echo _('Save template'); ?></button>
                </div>

                <div class="span9">
                    <p>
                        <label class="control-label" for="html"><?php echo _('HTML code'); ?></label>
                    <div class="control-group">
                        <div class="controls">
                            <textarea class="input-xlarge" id="html" name="html" rows="10" placeholder="<?php echo _('Email content'); ?>"></textarea>
                        </div>
                    </div>
                    <p><?php echo _('Use the following tags in your subject, plain text or HTML code and they\'ll automatically be formatted when your campaign is sent. For web version and unsubscribe tags, you can style them with inline CSS.'); ?></p><br/>

                    <div class="control-group">
                        <div class="controls">
                            <div class="radio-inline">
                                <label> <input type="radio" name="optradio" value="productCode" onclick="changeType('productCode');" checked=""> Product</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="optradio" value="servicesCode" onclick="changeType('servicesCode');"> Services</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="optradio" value="courseCode" onclick="changeType('courseCode');"> Course</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="optradio" value="skillsoftCode" onclick="changeType('skillsoftCode');"> Skillsoft Course</label>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row-fluid" id="productCode" style="display: none">
                        <div class="span12">
                            <h3><?php echo _('Product tags (HTML only)'); ?></h3>
                            <?php echo _('The following tags can only be used on the HTML version'); ?><br/><br/>
                            <p><strong><?php echo _('Product link'); ?>: </strong><br/>
                            <?php
                            if ($products) {
                                while ($productsList = mysqli_fetch_array($products)) {
                                    $product_id = $productsList['productd_id'];
                                    $product_name = ($productsList['product_name']);
                                    ?>
                                    <code>[<?php echo str_replace(" ", "_", $product_name)."_purchase_link";?>]</code><br/><br/>
                                     <?php
                                }
                            }
                            ?>
                            </p>
                            <br/>
                        </div>
                    </div>
                    <div class="row-fluid" id="servicesCode">
                        <div class="span12">
                            <h3><?php echo _('Services tags (HTML only)'); ?></h3>
                            <?php echo _('The following tags can only be used on the HTML version'); ?><br/><br/>
                            <p><strong><?php echo _('Services link'); ?>: </strong><br/>
                            <?php
                            if ($services) {
                                while ($servicesList = mysqli_fetch_array($services)) {
                                    $services_name = ($servicesList['product_name']);
                                    ?>
                                    <code>[<?php echo str_replace(" ", "_", $services_name)."_purchase_link";?>]</code><br/><br/>
                                     <?php
                                }
                            }
                            ?>
                            </p>
                            <br/>
                        </div>
                    </div>
                    <div class="row-fluid" id="courseCode">
                        <div class="span12">
                            <h3><?php echo _('Course tags (HTML only)'); ?></h3>
                            <?php echo _('The following tags can only be used on the HTML version'); ?><br/><br/>
                            <p><strong><?php echo _('Course link'); ?>: </strong><br/>
                            <?php
                            if ($courses) {
                                while ($coursesList = mysqli_fetch_array($courses)) {
                                    $course_name = ($coursesList['product_name']);
                                    ?>
                                    <code>[<?php echo str_replace(" ", "_", $course_name)."_purchase_link";?>]</code><br/><br/>
                                     <?php
                                }
                            }
                            ?>
                            </p>
                            <br/>
                        </div>
                    </div>
                    <div class="row-fluid" id="skillsoftcourseCode">
                        <div class="span12">
                            <h3><?php echo _('Skillsoft course tags (HTML only)'); ?></h3>
                            <?php echo _('The following tags can only be used on the HTML version'); ?><br/><br/>
                            <p><strong><?php echo _('Skillsoft link'); ?>: </strong><br/>
                            <?php
                            if ($skillsofts){
                                while ($skillsoftList = mysqli_fetch_array($skillsofts)) {
                                    $skillsoft_name = ($skillsoftList['product_name']);
                                    ?>
                                    <code>[<?php echo str_replace(" ", "_", $skillsoft_name)."_purchase_link";?>]</code><br/><br/>
                                     <?php
                                }
                            }
                            ?>
                            </p>
                            <br/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <?php include('includes/helpers/personalization.tags.php'); ?>
                    </div>
                    </p>
                </div>

            </form>

        </div>
    </div>
</div>
<?php include('includes/footer.php');?>

<script>
    $(document).ready(function(){
    
    changeType('productCode')
    });
    
    function changeType(type){
       if(type == 'productCode'){
          $("#productCode").show();
          $("#servicesCode").hide();
          $("#courseCode").hide();
          $("#skillsoftcourseCode").hide();
      }else if(type == 'servicesCode'){
          $("#servicesCode").show();
          $("#productCode").hide();
          $("#courseCode").hide();
          $("#skillsoftcourseCode").hide();
      }else if(type == 'courseCode'){
          $("#courseCode").show();
          $("#productCode").hide();
          $("#servicesCode").hide();
          $("#skillsoftcourseCode").hide();
      }else if(type == 'skillsoftCode'){
          $("#skillsoftcourseCode").show();
          $("#productCode").hide();
          $("#servicesCode").hide();
          $("#courseCode").hide();
      }else{
          $("#productCode").show();
          $("#servicesCode").hide();
          $("#courseCode").hide();
          $("#skillsoftcourseCode").hide(); 
      }
    }
</script>

<style>
    .radio-inline {
  float: left;
  padding: 5px;
}
</style>