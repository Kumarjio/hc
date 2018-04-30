<div class="library-container">
    <?php
    if (is_array($arrContentListArticle) && (count($arrContentListArticle) > 0)) {

        foreach ($arrContentListArticle as $arrArticle) {
            $intArticleId = $arrArticle['content']['content_id'];
            $strTarget = "";
            if ($intContentonNewtab) {
                $strTarget = "target='_blank'";
            }
            $arrArticleUrl = $strArticleDetailUrl . "/" . $arrArticle['content']['content_id'];
            ?>
            <div class="library-element" id="article_list_block_<?php echo $strTypeBlock; ?>_<?php echo $catid; ?>">
                <div class="library-element-head">
<!--                    <div class="webinar-left">
                            <a href="<?php echo $strwebinarDetailUrl; ?>"><div class="webinar-image"></div></a>
                    </div>-->
                    <h3>
                        <?php
                        if ($arrArticle['content']['content_type'] == "1") {
                            ?>
                            <a  href="<?php echo $arrArticleUrl; ?>"><?php
                                echo stripslashes($arrArticle['content']['content_title']);
                                ?></a>
                            <?php
                        } else {
                            ?>
                            <a <?php echo $strTarget; ?> href="<?php echo $arrArticleUrl; ?>"><?php
                                echo stripslashes($arrArticle['content']['content_title']);
                                ?></a>
                            <?php
                        }
                        ?>
                    </h3>

                </div>
                <p class="library-element-description">
                    <?php
                    echo htmlspecialchars_decode($arrArticle['content']['content_intro_text']);
                    ?></p>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="library-element" id="article_list_block_<?php echo $strTypeBlock; ?>">
            <div class="library-element-head">
                <h3>There are no Content to List.</h3>
            </div>
        </div>
        <?php
    }
    ?>
</div>