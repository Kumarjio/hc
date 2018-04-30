<div class="page-content-wrapper employers-type" style="min-height:500px;">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-12">
                <h1><?php 
                echo strip_tags($arrLibCatDetail[0]['Categories']['content_category_name']); ?></h1>
                <div class="tab-row-container">
                    <p>&nbsp;</p>
                </div>
            </div>
            
            <div class="col-lg-1"></div>
                <div class="col-lg-10">
                <div class="tab-row-container">
                    <?php echo $this->element('article_list_new'); ?>

                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
</div>

<style>
    .library-element {
  border-bottom: 1px solid #ddd;
  margin-bottom: 0 !important;
  margin-top: 10px;
  overflow: auto;
  padding-left: 15px;
  padding-right: 15px;
}
.library-container {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: auto;
  padding: 10px 12px 0;
  width: 100%;
}
</style>