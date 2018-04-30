<?php
echo $this->Html->script('myorder_index');
?>

<?php
echo $this->element('close_confirmation_new');
$strProductDownloadUrl = Router::url(array('controller' => 'myorders', 'action' => 'downloadproductfile', $intPortalId, $intOrderMId,$intServiceId), true);
?>
<?php // echo '<pre>';print_r($arrChildServiceDetail[0]);die;?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 bg-lightest-grey">
            <?php
            $resourceurl = Router::url('/', true) . "resources/index/" . $intPortalId;
            ?>
            <div class="page-header">
                <a href="<?php echo $resourceurl;?>" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span>Back to Resources</a>
                <!--<a style="cursor: pointer" onclick="goBack()" class="link-default"><span class="glyphicon glyphicon-chevron-left"></span>Back to Resources</a>-->
            </div>
            <div class="resource-detail-container">
                     <div class="resource-detail-info-container">
                    <h3><?php echo stripslashes($arrChildServiceDetail[0]['Resources']['product_name']); ?></h3>
                    <?php echo htmlspecialchars_decode(stripslashes($arrChildServiceDetail[0]['Content']['content'])); ?>
                    
                    <!--<div class="resources-footer">-->
                        <!--[product_file]-->
                        <?php if ($arrParentService[0]['Resourceorderdetail']['order_detail_id'] != '') { ?>
                            <!--<div class="group-container">-->
                                <!--<p class="my-order-option-title">Download:</p>-->
                            <!--<a href="javascript:void(0);" onclick="fndownloadFile()" download="" id="fileDown">-->
                            <a href="<?php echo Router::url('/', true) . 'productfiles/'.$arrChildServiceDetail[0]['Resources']['product_file']; ?>" onclick="fndownloadFile()" download="" id="fileDown">
                               <img src="<?php echo Router::url('/', true) . 'img/pdf_icon.jpg'; ?>" width="100px" height="100px" class="img-responsive"> 
                            </a>
                            <!--</div>-->
                        <?php } ?>
                        
                    <!--</div>-->
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function fndownloadFile()
    {
        $('.cms-bgloader-mask').show();//show loader mask
        $('.cms-bgloader').show(); //show loading image
        $.ajax({
            type: "GET",
            url: '<?php echo $strProductDownloadUrl; ?>',
            dataType: 'json',
            data: "",
            cache: false,
            success: function (data)
            {
                if(data.status == 'success'){
                
                  var strFileUrl = appBaseU + data.filepath + "/" + data.filename;
                   
//                window.open(strFileUrl);
//                window.location.href = window.location.href;
//                window.open(strFileUrl, 'download');
                
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image
                }else{
                    return false;
                }
            }
        });
    }
    
</script>
<script>
    $(document).ready(function(){
        $('.resource-detail-info-container p').addClass('resource-detail-description');
     
        $('p span').each(function() {
            var $this = $(this);
            if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
        });
      
        $('p').each(function() {
            var $this = $(this);
            if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
        });

    });
    
    function goBack() {
        window.history.back();
    }
    
</script>

<style>
.pro-img {
    background-color: #f9f9f9;
    display: inline-block;
  height: 200px;
  max-width: 200px;
    vertical-align: top;
    width: 37%;
}
.prices-container {
    width: 290px !important;
}
/*.resource-detail-info-container p {
  min-height: 45px !important;
}*/
.examples{
    margin-bottom:250px !important;
}
.resource-detail-info-container p{
    margin-bottom:10px !important;
}
.resources-footer{
    background: none !important;
}
.resource-detail-info-container {
  width: 75% !important;
}
.examples, body {
     vertical-align: unset !important; 
}
.resource-detail-info-container{
    width:100% !important;
}
.img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
  float: right !important;
}
</style>