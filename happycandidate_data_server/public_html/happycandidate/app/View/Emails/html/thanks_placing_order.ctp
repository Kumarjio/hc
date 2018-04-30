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
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>


<div style="font-family:georgia;font-size:12pt;">

<table style="background-color:rgb(255,255,255);width:100%;height:100%;font-family:georgia;font-size:12pt;" cellpadding="10" cellspacing="0">
          <tbody>
            <tr>
              <td valign="top">
                <table align="center" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td>
                        <table style="width:600px" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td style="text-align:left;margin:0;padding:10px 0;border:none;white-space:normal;line-height:normal;font-family:georgia;font-size:12pt;">
                                <div>
                                  <div>
                                    <div style="margin:0;padding:0;background:none;border:none;white-space:normal;line-height:normal;overflow:visible;color:rgb(26,36,46);font-size:11px;font-family:arial;text-align:center;font-family:georgia;font-size:12pt;">
                                      <div style="margin:0;padding:0;background:none;border:none;white-space:normal;line-height:normal;overflow:visible;color:rgb(26,36,46);font-size:11px;font-family:arial;text-align:center;font-family:georgia;font-size:12pt;">
                                        <div>
                                         
                                        </div>
                                        
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="text-align:left;margin:0;padding:0;border:none;white-space:normal;line-height:normal;height:30px;background-color:rgb(255,255,255)">
                                <div>
                                  <div>
                                    <div>
                                      <div style="text-align:center;font-family:georgia;font-size:12pt;">
                                        
										<span style="text-align:center;font-size:22px;font-family:georgia;">HR Search</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table style="width:600px;background-color:rgb(255,255,255);font-family:georgia;font-size:12pt;" bgcolor="#FFFFFF" cellpadding="20" cellspacing="0">
                          <tbody>
                          
                            <tr>
                              <td style="text-align:left;margin:0;padding:20px;border:none;white-space:normal;line-height:normal;background-color:rgb(255,255,255);font-family:georgia;font-size:13pt;" valign="top">
                               
                                <div>
                                  <div style="margin:0;padding:0;background:none;border:none;white-space:normal;line-height:normal;overflow:visible;color:rgb(0,0,0);font-family:georgia;font-size:13pt;">
								  <p> Dear <?php echo $first_name;?>,</p>
								  
                                   <?php echo $email_text;?>
								   
								   <p > You have just placed a new order from portal <?php echo $portal_name;?>.</p>
<p>Thanks for placing the order, we will get back to you soon with updates.</p>
<p><b>Thanks</b></p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
</div>

