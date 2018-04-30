                <?php  session_start();
                $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
                $last_segment = $segments[count($segments) - 1];
                $second_segment = $segments[count($segments) - 2];
                $third_segment = $segments[count($segments) - 3];
    
                if (is_array($arrProductList) && (count($arrProductList) > 0)) {
                    $intContentCount = 0;
                    foreach ($arrProductList as $arrContent) {
                        $intContentCount++;
                        $strProductEditUrl = Router::url(array('controller' => 'resourcecourse', 'action' => 'edit', $arrContent['products']['productd_id']), true);
                        $strPreviewUrl = Router::url(array('controller' => 'resourcecourse', 'action' => 'preview', "5", $arrContent['products']['productd_id']), true);
                        $strProductManageUrl = Router::url(array('controller' => 'mylms', 'action' => 'manage', $arrContent['products']['productd_id']), true);
                        ?>
                                                                                            <!--<tr id="product_list_<?php echo $arrContent['products']['productd_id']; ?>">-->
                        <tr>
                            <td style="width:5%!important;"><?php echo $intContentCount; ?></td>
                            <td style="width:28%!important;">
                                <div class="user-title">
                                    <a href="<?php echo $strProductEditUrl; ?>"><?php echo stripslashes($arrContent['products']['product_name']); ?></a>
                                </div>
                            </td>
                            <td style="width:10%!important;">
                                <?php
                                echo $arrContent['products']['product_type'];
                                ?>
                            </td>
                             <?php
                            if($last_segment != 'moderation'){ ?>
                            <td style="width:10%!important;">
                                <?php
                                if($last_segment == 'index' || $second_segment == 'search' || $third_segment == 'resourcecourse'){
                                    if ($arrContent['products']['product_publish_status'] == '1') {
                                        echo "Published";
                                    }
                                }else{
                                    if ($arrContent['products']['product_draft_status'] == '1') {
                                        echo "Drafted";
                                    }
                                }
                                ?>
                            </td>
                                <?php } ?>
                            <td style="width:18%!important;"><?php echo date($productdateformat, strtotime($arrContent['products']['product_creation_date'])) ?></td>
                            <td style="width:40%!important;"><a href="<?php echo $strProductEditUrl; ?>">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $strPreviewUrl; ?>" target="_blank">Preview</a>&nbsp;|&nbsp;<a href="<?php echo $strProductManageUrl; ?>">Manage</a>&nbsp;|&nbsp;<a class="link-warning" onclick="fnConfirmInquiryDelete('<?php echo $arrContent['products']['productd_id']; ?>')" href="javascript:void(0);">Delete</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>