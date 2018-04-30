<?php
if (is_array($arrProductList) && (count($arrProductList) > 0)) {
    $intContentCount = 0;
    foreach ($arrProductList as $arrContent) {
        $intContentCount++;
        $strProductEditUrl = Router::url(array('controller' => 'vendorservices', 'action' => 'edit', $arrContent['vendor_service']['vendor_service_id']), true);
        $strPreviewUrl = Router::url(array('controller' => 'vendorservice', 'action' => 'preview', "5", $arrContent['vendor_service']['vendor_service_id']), true);
        $strStatus = "Activate";
        if ($arrContent['vendor_service']['status'] == "Active") {
            $strStatus = "Inactivate";
        }
        ?>
        <tr id="product_list_<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>">
            <td style="width:5%!important;"><?php echo $intContentCount; ?></td>
            <td style="width:15%!important;"><div class="user-title"><?php echo stripslashes($arrContent['vendors']['vendor_name']); ?></div></td>
            <td style="width:25%!important;"><?php echo $arrContent['Resources']['product_name']; ?></td>
            <td style="width:7%!important;" id="status_col_<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>"><?php echo ucfirst($arrContent['vendor_service']['status']); ?></td>
            <td style="width:15%!important;"><?php echo date($productdateformat, strtotime($arrContent['vendor_service']['vendor_service_creation_date'])) ?></td>
            <td style="width:32%!important;"><a  href="<?php echo $strProductEditUrl; ?>">Edit</a> |<a onClick="return fnDeletevendorServiceProduct('<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>')" href="javascript:void(0);">Delete</a> | <a id="status_<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>" onClick="return fnChangevendorServiceProductStatus('<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>')" href="javascript:void(0);"><?php echo $strStatus; ?></a> | <a onClick="return fnReassignServiceProduct('<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>')" href="javascript:void(0);" >Reassign Step</a></td>
        </tr>
        <div id="myModal<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reassign Step</h4>
                    </div>
                    <div class="modal-body">
                        <p id="model<?php echo $arrContent['vendor_service']['vendor_service_id']; ?>">Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>