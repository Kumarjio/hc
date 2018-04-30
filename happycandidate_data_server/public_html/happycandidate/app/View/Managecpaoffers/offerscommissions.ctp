<div class="page-content-wrapper">
    <div class="container-fluid">
        <div id="product_notification"></div> 
        <div class="row">
            <div class="tab-header">
                <h3>Offer Commissions</h3>
            </div>
            <div class="tab-row-container ">			
            </div>
            <!-- USER RESUME TOP CONTROLS -->
            <div class="tab-row-container resourcetab">
                <div class="panel panel-default hidden-xs hidden-sm">
                    <div class="panel-heading admin-content">
                        <table>
                            <tr>
                                <th style="width:10%!important;">SR.ID</th>
                                <th style="width:30%!important;" class="selected">Offer Name<span></span></th>
                                <th style="width:20%!important;">Portal</th>
                                <th style="width:10%!important;">Total</th>
                                <th style="width:15%!important;">HC Share</th>
                                <th style="width:15%!important;">Owner Share</th>
                                <th style="width:18%!important;">Transaction Date</th>
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
                                    ?>
                                    <tr id="product_list_<?php echo $arroffers['cpa_offers_commissions']['offer_commission_id']; ?>">
                                        <td style="width:10%!important;height:40px!important;"><?php echo $intOfferCount; ?></td>
                                        <td style="width:30%!important;height:40px!important;">
                                            <div class="user-title">
                                                <a href="javascript:void();"><?php echo isset($arroffers['offers'][0]['Cpaoffers']['offer_name']) ? stripslashes($arroffers['offers'][0]['Cpaoffers']['offer_name']) : ''; ?></a>
                                            </div>
                                        </td>
                                        <td style="width:20%!important;height:40px!important;"><?php echo stripslashes($arroffers['portal'][0]['Portal']['career_portal_name']); ?></td>
                                        <!--<td style="width:20%!important;height:40px!important;"><?php echo stripslashes($arroffers['employer_detail']['employer_user_fname']." ".$arroffers['employer_detail']['employer_user_lname']); ?></td>-->
                                        <td style="width:10%!important;height:40px!important;"><?php echo stripslashes($arroffers['cpa_offers_commissions']['total_amount']); ?></td>
                                        <td style="width:15%!important;height:40px!important;"><?php echo stripslashes($arroffers['cpa_offers_commissions']['hc_cost']); ?></td>
                                        <td style="width:15%!important;height:40px!important;"><?php echo stripslashes($arroffers['cpa_offers_commissions']['portal_cost']); ?></td>
                                        <td style="width:18%!important;height:40px!important;"><?php echo date($productdateformat, strtotime($arroffers['cpa_offers_commissions']['added_date'])) ?></td>
                                        <td style="width:15%!important;height:40px!important;"><a onclick="fnshoweditform('<?php echo $arroffers['cpa_offers_commissions']['offer_commission_id']; ?>','<?php echo $arroffers['cpa_offers_commissions']['hc_cost']; ?>','<?php echo $arroffers['cpa_offers_commissions']['portal_cost']; ?>')" class="link-primary">Edit</a>&nbsp;|&nbsp;<a href="javascript:void(0);" onclick="fnDeleteOffer('<?php echo $arroffers['cpa_offers_commissions']['offer_commission_id'];?>');" class="link-primary">Delete</a></td>
                                    </tr>
                                    <tr id="str<?php echo $arroffers['cpa_offers_commissions']['offer_commission_id']; ?>" class="hide-str">
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

 <!-- Modal forword Candidate -->
        <div class="modal fade" id="editOfferComission" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form id="editOfferComissionForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Offer Comission</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label" for="category_name"> HC Share :</label>
                                <div class="app">
                                    <div class="appl" style="width:100%;margin-bottom:15px;">
                                        <input id="hc_cost" name="hc_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter HC share here"> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label" for="category_name">Owner Share :</label>
                                <div class="app">
                                    <div class="appl" style="width:100%;margin-bottom:15px;">
                                        <input id="portal_cost" name="portal_cost" type="text" class="form-control validate[required] col-xs-12 col-sm-12 col-md-8" placeholder="Enter Owner share here"> 
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary full-btn" onclick="fnEditOfferComission();">Save</button>
                            <input id="offer_comission_id" name="offer_comission_id" type="hidden"> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closePopup();">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Modal forword Candidate -->

<script type="text/javascript">
    function fnDeleteOffer(intOfferId)
    {
	$.ajax({ 
            type: "GET",
            url: strBaseUrl+"managecpaoffers/offercomissiondelete/"+intOfferId,
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

//    editOfferComission
    
    function fnshoweditform(comissionId,hcCost,portalCost){
        $('#editOfferComission').modal('show');
        $('#hc_cost').val(hcCost);
        $('#portal_cost').val(portalCost);
        $('#offer_comission_id').val(comissionId);
    }
    
    function fnEditOfferComission()
    {
        var hc_cost = $('#hc_cost').val();
        var portalCost = $('#portal_cost').val();
        var comissionId = $('#offer_comission_id').val();
        
	$.ajax({ 
            type: 'POST',
            url: strBaseUrl+"managecpaoffers/editcomissionAction",
            data: "hc_cost=" + hc_cost +"&portal_cost="+portalCost+"&offer_comission_id="+comissionId,
            dataType: 'json',
            success: function(data)
            {
                    if(data.status == "success")
                    {
                        $("#editOfferComission").hide();
                        $(".modal-backdrop").css('display','none');
                        var msg = data.message.replace("\\", "");
                        $('#product_notification').html(msg);
                        setTimeout(function(){ 
                            window.location.reload();
                        }, 2000);
                    }
                    else
                    {
                        $("#editOfferComission").hide();
                        $(".modal-backdrop").css('display','none');
                            
                        var msg = data.message.replace("\\", "");
                        $('#product_notification').html(msg);
                        
                        setTimeout(function(){ 
                            window.location.reload();
                        }, 2000);
                        
                        
                    }
            }
        });
    }
    

</script>

