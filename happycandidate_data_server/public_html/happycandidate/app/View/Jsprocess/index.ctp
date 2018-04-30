<?php
$strVendorServiceUrl = Router::url(array('controller' => 'vendorservicehoster', 'action' => 'index', $intPortalId, "interviewbest"), true);
$strProfileStepUrl = Router::url(array('controller' => 'jsprocess', 'action' => 'step', $intPortalId, $arrfirstStepdata['content_category_parent_id'], $phaseIncompleteid), true);
?>
<div class="container-fluid bg-lightest-grey">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 offset-top-15">
            <div class="progress-well">

                <h3 class="col-xs-12 col-sm-12 col-md-6 col-lg-3">Process completeness:</h3>
                <div class="meter-indicator-big col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="meter-value-before">
                        <span><?php echo round($current_user['jprocess_completeion_per']); ?>%</span>
                    </div>
                    <div class="meter-progress-after">
                        <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $current_user['jprocess_completeion_per']; ?>%">
                            <span class="sr-only"><?php echo $current_user['jprocess_completeion_per']; ?>% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="meter-well-right col-xs-12 col-sm-12 col-md-12 col-lg-3"><button class="btn btn-primary btn-md" onclick="javascript:location.href = '<?php echo $strProfileStepUrl; ?>'">Complete Your Process Now<span class="glyphicon glyphicon-chevron-right"></span></button></div>
            </div>
            <div class="page-header">
                <h2>Welcome To The 15 Step Job Search Process!</h2>
                <p>The 15 Step Job Search Process will help you stand out from job seekers competing for the same opportunity.</p>
            </div>
            <?php
            if (is_array($arrJobSearchProcessPhases) && (count($arrJobSearchProcessPhases) > 0)) {
                $intPhaseCnt = 0;

                foreach ($arrJobSearchProcessPhases as $arrJProcess) {
                    $intPhaseCnt++;
                    $strPhaseUrl = Router::url(array('controller' => 'jsprocess', 'action' => 'phase', $intPortalId, $arrJProcess['Categories']['content_category_id']), true);
                    ?>
                    <?php
                    $strCompleteClass = "";
                    if ($arrJProcess['Categories']['step_completion_class']) {
                        $strCompleteClass = $arrJProcess['Categories']['step_completion_class'];
                    }

                    $strMainClass = $arrJProcess['Categories']['job_process_type'];
                    ?>
                    <div class="phase-header-container">
                        <div class="header-leftside-10">
                            <h3>Phase <?php echo $intPhaseCnt; ?></h3>
                        </div>
                        <div>
                            <h3 id="phase_<?php echo $arrJProcess['Categories']['content_category_id']; ?>"><?php echo $arrJProcess['Categories']['content_category_name']; ?></h3>
                        </div>
                    </div>
                    <?php
                    if ($arrJProcess['Categories']['content_category_has_child']) {
                        ?>
                        <div id="<?php echo strtolower($arrJProcess['Categories']['job_process_type']); ?>container_<?php echo $arrJProcess['Categories']['content_category_id']; ?>">
                            <?php
                            $strAccordType = "steps";
                            $strAccordTypeId = $arrJProcess['Categories']['content_category_id'];
                            if ($intPhaseCnt > 1) {
                                $stepcount = $stepcount + count($arrJProcess['Categories']['Steps']);
                            } else {
                                $stepcount = 0;
                            }

                            echo $this->element('phasestepsnew', array("strAccord" => $strAccordType, "strAccordId" => $strAccordTypeId, "arrPhaseStep" => $arrJProcess['Categories']['Steps'], 'stepCount' => $stepcount, 'PhaseCnt' => $intPhaseCnt));
                            ?>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        <div class="col-md-1"></div>
    </div>
    <style>
        .offset-top-15 {
            margin-top: 100px;
        }
    </style>