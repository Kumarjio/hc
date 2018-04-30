<?php
if (is_array($arrPhaseStep) && (count($arrPhaseStep) > 0)) {
    //print("<pre>");
    //print_r($arrPhaseStep);
    ?>
    <?php
    //print("<pre>");
    //print_r($arrPhaseStep);
    //exit;
    $intStepCnt = 0;
    foreach ($arrPhaseStep as $arrPStep) {

        $stepcountshow = $PhaseCnt > 1 ? ++$stepCount : ++$intStepCnt;


        $strClassElement = "class = 'stepshead'";
        if ($arrPStep['Categories']['iscompleted']) {
            $strClassElement = "class = 'wizard-step-done'";
            $strStepNameContainerClass = "class = 'wizard-step-leftside-10'";
            $strStepNameTextClass = "class = 'osr16 text-middle-dark-grey'";
        } else {
            $strClassElement = "class = 'wizard-step-inactive white'";
            $strStepNameContainerClass = "class = 'wizard-step-centerside-65'";
            $strStepNameTextClass = "class = 'osb16 text-dark-grey'";
        }

        $strClass = $arrPStep['Categories']['job_process_type'];
        $strStepUrl = Router::url(array('controller' => 'jsprocess', 'action' => 'step', $intPortalId, $arrPStep['Categories']['content_category_id'], $strAccordId), true);
        ?>
        <div <?php echo $strClassElement; ?>>
            <div class="wizard-step-leftside-10">
                <h3>Step <?php echo $stepcountshow; ?></h3>
            </div>
            <div class="wizard-step-centerside-65">
                <h3><a href="<?php echo $strStepUrl; ?>">
                        <?php
                        if ($arrPStep['Categories']['iscompleted']) {
                            ?>
                            <s><?php echo $arrPStep['Categories']['content_category_name']; ?></s>
                            <?php
                        } else {
                            ?>
                            <?php echo $arrPStep['Categories']['content_category_name']; ?>
                            <?php
                        }
                        ?>
                    </a></h3>
                    <!--<p>duration in minutes here</p>-->
                <p>&nbsp;</p>
            </div>
            <?php
            if ($arrPStep['Categories']['iscompleted']) {
                ?>
                <div class="wizard-step-rightside-25">
                    <p class="icon-step-completed"><span>COMPLETED</span></p>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
?>