<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php
            echo "Find a Job of Your Dream";
            ?>
        </title>
        <link rel="stylesheet" href="http://www.rothrsolutions.com/css/shr.css">

        <!-- Docs styles -->
        <link rel="stylesheet" href="http://www.rothrsolutions.com/css/docs.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <?php
        echo $this->Html->script('editor');
        ?>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
        <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">

        <?php //echo $this->Html->css('bootstrap_datetimepicker'); ?>
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <?php
        echo $this->Html->css('editor');
        echo $this->Html->css('stylesheet');
        echo $this->Html->css('website');


        //echo $this->Html->script('jquery/jquery');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/languages/jquery.validationEngine-en');
        echo $this->Html->script('jquery/validationplugin/validationengine/js/jquery.validationEngine');
        echo $this->Html->script('jquery/jquery.form');
        echo $this->Html->script('common');
        echo $this->Html->script('add_product');
        echo $this->Html->script('cart');
        echo $this->Html->script('worksheet');

        echo $this->Html->css('jqueryvalidationplugin/validationEngine.jquery');
        //echo $this->Html->css('jqueryui/themes/base/jquery.ui.all');
        //echo $this->Html->css('jqueryui/themes/base/jquery.ui.datepicker');
        echo $this->Html->css('jqueryui/themes/base/jquery-ui');
        ?>
        <?php
        echo $this->Html->script('jquery/jquery-ui.min');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.core');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.widget');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.tabs');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.mouse');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.button');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.draggable');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.position');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.resizable');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.dialog');
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.slider');
        //echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.effect');	
        echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.sortable');
        //echo $this->Html->script('jquery/jqueryui/development-bundle/ui/jquery.ui.datepicker');
        //echo $this->Html->script('jquery/jqueryui/development-bundle/ui/timepicker');
        ?>
        <script type="text/javascript">
            function setCookie(key, value) {
                var expires = new Date();
                expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
                document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
            }

            function getCookie(key) {
                var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
                return keyValue ? keyValue[2] : null;
            }
            $(document).ready(function () {
                //GET OFFSETS
                function getOffset(el) {
                    var _x = 0;
                    var _y = 0;
                    while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
                        _x += el.offsetLeft - el.scrollLeft;
                        _y += el.offsetTop - el.scrollTop;
                        el = el.offsetParent;

                    }
                    return {top: _y, left: _x};
                }
            });
        </script>

    </head>
    <body class="login-layout">
        <div class="container-fluid top-menu-container-index">
            <?php
            $strsuccessmessage = $this->Session->flash('success');
            $strdangermessage = $this->Session->flash('danger');
            ?>
            <?php if ($strsuccessmessage != '') { ?>
                <div class='alert alert-success'><img alt='image description' src='<?php echo Router::url('/', true); ?>images/icon-alert-success.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> <?php echo strip_tags($strmessage); ?></div>
            <?php } ?>

            <?php if ($strdangermessage != '') { ?>
                <div class='alert alert-danger'><img alt='image description' src='<?php echo Router::url('/', true); ?>images/icon-alert-error.png'><a aria-label='close' data-dismiss='alert' class='close' href='#'>×</a> <?php echo strip_tags($strdangermessage); ?></div>
            <?php } ?>
            <div class="text-center">
                <img class="not-found" alt="logo description" src="<?php echo Router::url('/', true); ?>images/portalnotfound.jpg">
            </div>
            <a href="<?php echo Router::url('/', true); ?>"><button class="btn btn-info home-button">Return To Home</button></a>
        </div>
        <style>
            .container-fluid {
                margin-top: -38px !important;
            }
            button.btn {
                border-radius: 5px;
                display: inline-block;
                font-family: OpenSansRegular,Georgia,serif;
                font-size: 15px;
                font-weight: normal;
                height: 40px;
                margin: 0 0 0 44%;
                outline: medium none;
                padding-left: 15px;
                padding-right: 15px;
            }
            .not-found {
                width: 80%;
            }
        </style>