<?php $strOfferAddUrl = Router::url(array('controller' => 'managecpaoffers', 'action' => 'add'), true);?>
<div class="page-content-wrapper">
    <div class="container-fluid">
         
        <div class="row">
            <div class="tab-header">
                <h3>Manage CPA Offers</h3>
                <button onclick="javascript:location.href = '<?php echo $strOfferAddUrl;?>'" type="button" class="btn btn-primary btn-sm">Add New</button>
            </div>
            <div class="tab-row-container ">			
                <div id="product_notification"></div>
            </div>
            <!-- USER RESUME TOP CONTROLS -->
            <div class="tab-row-container resourcetab">
                <div class="panel panel-default hidden-xs hidden-sm">
                    <div class="panel-heading admin-content">
                        <table>
                            <tr>
                                <th style="width:7%!important;">SR. ID #</th>
                                <th style="width:40%!important;" class="selected">Offer Name<span></span></th>
                                <th style="width:20%!important;">Offer Image</th>
                                <th style="width:15%!important;">Offer Status</th>
                                <th style="width:20%!important;">Date Created</th>
                                <th style="width:15%!important;">Action</th>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-body admin-content">
                        <input type="hidden" id="contentName" value="approve" />
                        <table>
                            <?php
                            if (is_array($arrCpaOfferList) && (count($arrCpaOfferList) > 0)) {
                                $intContentCount = 0;
                                foreach ($arrCpaOfferList as $arroffers) {
                                    $intOfferCount++;
                                    $strOfferEditUrl = Router::url(array('controller' => 'managecpaoffers', 'action' => 'edit', $arroffers['cpa_offers']['offer_id']), true);
                                    $strPreviewUrl = Router::url(array('controller' => 'managecpaoffers', 'action' => 'preview', $arroffers['cpa_offers']['offer_id']), true);
                                    $strStatus = "Activate";
                                    if ($arroffers['cpa_offers']['offer_status'] == "Active") {
                                        $strStatus = "Inactivate";
                                        $strInactiveClass = "link-warning";
                                    }
                                    ?>
                                    <tr id="product_list_<?php echo $arroffers['cpa_offers']['offer_id']; ?>">
                                        <td style="width:7%!important;height:40px!important;"><?php echo $intOfferCount; ?></td>
                                        <td style="width:40%!important;height:40px!important;">
                                            <div class="user-title">
                                                <a href="<?php echo $strOfferEditUrl; ?>"><?php echo stripslashes($arroffers['cpa_offers']['offer_name']); ?></a>
                                            </div>
                                        </td>
                                        <td style="width:20%!important;height:40px!important;"><img src="<?php echo Router::url('/', true); ?>offer-images/<?php echo $arroffers['cpa_offers']['offer_image']; ?>" height="80px" width="80px"></td>
                                        <td style="width:15%!important;height:40px!important;"><a class="<?php echo $strInactiveClass;?>" id="status_<?php echo $arroffers['cpa_offers']['offer_id'];?>" onClick="return fnChangeOfferStatus('<?php echo $arroffers['cpa_offers']['offer_id'];?>')" href="javascript:void(0);"><?php echo $strStatus; ?></a></td>
                                        <td style="width:20%!important;height:40px!important;"><?php echo date($productdateformat, strtotime($arroffers['cpa_offers']['offer_date'])) ?></td>
                                        <td style="width:15%!important;height:40px!important;"><a href="<?php echo $strOfferEditUrl ?>" class="link-primary">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="fnDeleteOffer('<?php echo $arroffers['cpa_offers']['offer_id'];?>');" class="link-primary">Delete</a></td>
                                    </tr>
                                    <tr id="str<?php echo $arroffers['cpa_offers']['offer_id']; ?>" class="hide-str">
                                        <td></td>
                                        <td colspan="4">

                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
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

<script type="text/javascript">
    function fnDeleteOffer(intOfferId)
    {
	$.ajax({ 
			type: "GET",
			url: strBaseUrl+"managecpaoffers/offerdelete/"+intOfferId,
			dataType: 'json',
			cache:false,
			success: function(data)
			{
				if(data.status == "success")
				{
                                    var msg = data.message.replace("\\", "");
                                    $('#product_notification').html(msg);
                                    $('#product_list_'+intOfferId).remove();
                                    $('#str'+intOfferId).remove();
				}
				else
				{
                                    var msg = data.message.replace("\\", "");
                                    $('#product_notification').html(msg);
				}
			}
    });
}

    function fnChangeOfferStatus(intOfferId)
    {
	
	$('.cms-bgloader-mask').show();//show loader mask
	$('.cms-bgloader').show(); //show loading image
	$.ajax({ 
            type: "GET",
            url: strBaseUrl+"managecpaoffers/changeOfferStatus/"+intOfferId,
            dataType: 'json',
            data:"",
            cache:false,
            success: function(data)
            {
                    if(data.status == "success")
                    {
                            $('#status_'+intOfferId).html(data.newactstatus);
                            $('#status_col_'+intOfferId).html(data.newstatus);
                            $('#product_notification').html(data.message);
                    }
                    else
                    {
                        $('#product_notification').html(data.message);
                    }
                    $('.cms-bgloader-mask').hide();//show loader mask
                    $('.cms-bgloader').hide(); //show loading image
            }
	});

}
</script>

