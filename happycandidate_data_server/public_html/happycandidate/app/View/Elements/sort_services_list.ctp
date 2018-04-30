<?php session_start();
if (is_array($arrProductList) && (count($arrProductList) > 0)) {
    $intContentCount = 0;
    foreach ($arrProductList as $arrContent) {
        $intContentCount++;
        $strProductEditUrl = Router::url(array('controller' => 'resource', 'action' => 'edit', $arrContent['products']['productd_id']), true);
        $strPreviewUrl = Router::url(array('controller' => 'resource', 'action' => 'preview', "5", $arrContent['products']['productd_id']), true);
        $strProductManageUrl = Router::url(array('controller' => 'mylms', 'action' => 'manage', $arrContent['products']['productd_id']), true);
        ?>
        <tr>
            <td style="width:10%!important;"><?php echo $intContentCount; ?></td>

            <td style="width:40%!important;">
                <div class="user-title">
                    <?php echo stripslashes($arrContent['products']['product_name']); ?>
                </div>
            </td>
            <td style="width:10%!important;"><?php echo $arrContent['products']['product_type']; ?></td>
            <td style="width:20%!important;"><?php echo date($productdateformat, strtotime($arrContent['products']['product_creation_date'])) ?></td>
            <td style="width:40%!important;">
                <a href="<?php echo $strProductEditUrl; ?>" class="link-primary">Edit</a> |
                <a href="<?php echo $strPreviewUrl ?>" class="link-primary">Preview</a> |
                <a href="#" id="resource_del_<?php echo $arrContent['products']['productd_id']; ?>" onClick="return fnDeleteResource(this);" class="link-warning">Delete</a>
            </td>
            <td style="width:10%!important;"></td>
        </tr>
        <?php
    }
}
?>