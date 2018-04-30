<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
	Configure::write('debug',2);

/**
 * Configure the Error handler used to handle errors for your application. By default
 * ErrorHandler::handleError() is used. It will display errors using Debugger, when debug > 0
 * and log errors with CakeLog when debug = 0.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors. You can set this to any callable type,
 *   including anonymous functions.
 *   Make sure you add App::uses('MyHandler', 'Error'); when using a custom handler class
 * - `level` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
	Configure::write('Error', array(
		'handler' => 'ErrorHandler::handleError',
		'level' => E_ALL & ~E_DEPRECATED & ~E_NOTICE,
		'trace' => true
	));

/**
 * Configure the Exception handler used for uncaught exceptions. By default,
 * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
 * while debug > 0, framework errors like Missing Controller will be displayed. When debug = 0,
 * framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
 *   including anonymous functions.
 *   Make sure you add App::uses('MyHandler', 'Error'); when using a custom handler class
 * - `renderer` - string - The class responsible for rendering uncaught exceptions. If you choose a custom class you
 *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
 * - `log` - boolean - Should Exceptions be logged?
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
	Configure::write('Exception', array(
		'handler' => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	));

	
/**
	Default Date Format For application

*/
	//Configure::write('Productdate.format', 'm/d/Y');
	Configure::write('Productdate.format', 'F d, Y');
	Configure::write('HC.dateformat','F d, Y');
	Configure::write('HC.dateformatJs','MMMM DD, YYYY');

/**
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below. But keep in mind
 * that plugin assets such as images, CSS and Javascript files
 * will not work without url rewriting!
 * To work around this issue you should either symlink or copy
 * the plugin assets into you app's webroot directory. This is
 * recommended even when you are using mod_rewrite. Handling static
 * assets through the Dispatcher is incredibly inefficient and
 * included primarily as a development convenience - and
 * thus not recommended for production applications.
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 *	`admin_index()` and `/admin/controller/index`
 *	`manager_index()` and `/manager/controller/index`
 *
 */
	//Configure::write('Routing.prefixes', array('admin'));

/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	//Configure::write('Cache.check', true);

/**
 * Enable cache view prefixes.
 *
 * If set it will be prepended to the cache name for view file caching. This is
 * helpful if you deploy the same application via multiple subdomains and languages,
 * for instance. Each version can then have its own view cache namespace.
 * Note: The final cache file name will then be `prefix_cachefilename`.
 */
	//Configure::write('Cache.viewPrefix', 'prefix');

/**
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The defaults key is
 * used to define a default preset to use for sessions, any settings declared here will override
 * the settings of the default config.
 *
 * ## Options
 *
 * - `Session.cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'
 * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
 *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 *    There are four builtins: php, cake, cache, database.
 * - `Session.handler` - Can be used to enable a custom session handler. Expects an array of callables,
 *    that can be used with `session_save_handler`. Using this option will automatically add `session.save_handler`
 *    to the ini array.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
 * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
 *
 * To use database sessions, run the app/Config/Schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
	Configure::write('Session', array(
		'defaults' => 'php'
	));

/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', 'ABCD93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '768593096574535424967496836451921987');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a query string parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
	//Configure::write('Asset.timestamp', true);

/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The class name and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

/**
 * Uncomment this line and correct your server timezone to fix
 * any date & time related errors.
 */
	//date_default_timezone_set('UTC');
	date_default_timezone_set('Asia/Kolkata');
	
	if($_SERVER['SERVER_NAME'] == "localhost")
	{
		Configure::write('Lms.loginurl', 'http://localhost/moodle/login/moodlerevert.php');
		Configure::write('Lms.logouturl', 'http://localhost/moodle/login/logoutlms.php');
		Configure::write('Lms.session', 'http://localhost/moodle/spywork.php');
		Configure::write('Lms.loginafterpath', 'http://localhost/moodle/index.php');
		Configure::write('Lms.categoryrolepath', 'http://localhost/moodle/setupemployercatrole.php');
		Configure::write('Lms.categorygetcoursespath', 'http://localhost/moodle/courses.php');
		Configure::write('Lms.candidatebadgespath', 'http://localhost/moodle/candidatesbadges.php');
		Configure::write('Lms.searchcoursepath', 'http://localhost/moodle/searchcourse.php');
		Configure::write('Lms.searchwebinarpath', 'http://localhost/moodle/searchwebinar.php');
		Configure::write('Lms.categorygetwebinarspath', 'http://localhost/moodle/webinars.php');
		Configure::write('Lms.categorygetallmaterialpath', 'http://localhost/moodle/alltrainingmaterial.php');
		Configure::write('Lms.newmaterialnotificationseekersurl', 'http://localhost/moodle/newmaterialnotification.php');
		Configure::write('Lms.paypalenrolledcoursepath', 'http://localhost/moodle/paidcourses.php');
		Configure::write('Lms.setupseeker', 'http://localhost/moodle/setupSeeker.php');
		Configure::write('Lms.courseview', 'http://localhost/moodle/course/view.php');
		Configure::write('Lms.coursecreate', 'http://localhost/moodle/createcourse.php');
		Configure::write('Lms.coursedelete', 'http://localhost/moodle/deletecourse.php');
		Configure::write('Lms.courseupdate', 'http://localhost/moodle/updatecourse.php');
		Configure::write('Lms.syncuserspath', 'http://localhost/moodle/sync_users_cusotm.php');
		Configure::write('Lms.setupvendorrole', 'http://localhost/moodle/setupvendorcatrole.php');
		
		Configure::write('Jobber.baseurl', 'http://localhost/happycandidate/jobberland/');
		
		Configure::write('Jobber.adminloginurl', 'http://localhost/happycandidate/jobberland/admin/log_admin_in.php');
		Configure::write('Jobber.adminlogouturl', 'http://localhost/happycandidate/jobberland/admin/admin_logout.php');
		Configure::write('Jobber.adminjoblistingurl', 'http://localhost/happycandidate/jobberland/admin/manage_listings.php');
		Configure::write('Jobber.adminmanageusersurl', 'http://localhost/happycandidate/jobberland/admin/manage_employee_active.php');
		Configure::write('Jobber.adminmanageseekersurl', 'http://localhost/happycandidate/jobberland/admin/manage_seeker.php');
		Configure::write('Jobber.adminmanageownersurl', 'http://localhost/happycandidate/jobberland/admin/manage_owner.php');
		Configure::write('Jobber.adminmanagejobinputssurl', 'http://localhost/happycandidate/jobberland/admin/view_category.php');
		Configure::write('Jobber.adminjobboardurl', 'http://localhost/happycandidate/jobberland/admin/cpanel.php');
		
		Configure::write('Jobber.seekerloginurl', 'http://localhost/happycandidate/jobberland/log_seeker_in.php');
		Configure::write('Jobber.seekerlogouturl', 'http://localhost/happycandidate/jobberland/seeker_logout.php');
		Configure::write('Jobber.seekerprofileurl', 'http://localhost/happycandidate/jobberland/account/');
		Configure::write('Jobber.seekercvurl', 'http://localhost/happycandidate/jobberland/curriculum_vitae/');
		Configure::write('Jobber.seekerdefaultcvurl', 'http://localhost/happycandidate/jobberland/curriculum_vitae/resume/');
		Configure::write('Jobber.seekercletterurl', 'http://localhost/happycandidate/jobberland/covering_letter/');
		Configure::write('Jobber.seekerprofileloginurl', 'http://localhost/happycandidate/jobberland/account/change_password/');
		Configure::write('Jobber.seekerhomeurl', 'http://localhost/happycandidate/jobberland/');
		Configure::write('Jobber.seekerjobsurl', 'http://localhost/happycandidate/jobberland/applications/');
		Configure::write('Jobber.seekerlatestjobsurl', 'http://localhost/happycandidate/jobberland/latestjob/');
		Configure::write('Jobber.seekersavejobsurl', 'http://localhost/happycandidate/jobberland/save_job/');
		Configure::write('Jobber.seekersavesearchsurl', 'http://localhost/happycandidate/jobberland/save_search/');
		Configure::write('Jobber.seekerjobdetailurl', 'http://localhost/happycandidate/jobberland/job/');
		Configure::write('Jobber.seekerjobsearchurl', 'http://localhost/happycandidate/jobberland/search_result/');
		Configure::write('Jobber.seekerprofileperformanceurl', 'http://localhost/happycandidate/jobberland/getSeekerProfilePerformace.php');
		Configure::write('Jobber.newjobnotificationseekersurl', 'http://localhost/happycandidate/jobberland/employer/getNewJobNotificationCandidates.php');
		
		Configure::write('Jobber.employerloginurl', 'http://localhost/happycandidate/jobberland/employer/log_employer_in.php');
		Configure::write('Jobber.employerlogouturl', 'http://localhost/happycandidate/jobberland/employer/employer_logout.php');
		Configure::write('Jobber.employersetportalurl', 'http://localhost/happycandidate/jobberland/employer/set_portal.php');
		Configure::write('Jobber.employeraddjoburl', 'http://localhost/happycandidate/jobberland/employer/addjob/');
		Configure::write('Jobber.employerjobindexurl', 'http://localhost/happycandidate/jobberland/employer/myjobs/');
		Configure::write('Jobber.employerprofileurl', 'http://localhost/happycandidate/jobberland/employer/account/');
		
		/*Configure::write('Social.FbApkey','213601475483889');
		Configure::write('Social.FbSecretkey','f4f1ad2b4ffd45cf3dfa939a7d843228');*/

		/* Configure::write('Social.FbApkey','1658215281141105');
		Configure::write('Social.FbSecretkey','d7c18864344fb67538d2d2962ec78746'); */
		
		Configure::write('Social.FbApkey','440280512983664');
		Configure::write('Social.FbSecretkey','beee305b606290d22beadba9bcf6db04');
		
		Configure::write('Social.LinkedInApkey','jg1nraaupiah');
		Configure::write('Social.LinkedInSecretkey','TAzjfmkkfnaSGSfd');
		
		Configure::write('Social.TwitterApkey','gvN7mYC8VFhD4YaFk8nw');
		Configure::write('Social.TwitterSecretkey','XNiMclm61m4mIGo60QYB86lbquMf0GEnuS5SCx8');
	}
	else
	{
		Configure::write('Lms.loginurl', 'http://hc.local/moodle/login/moodlerevert.php');
		Configure::write('Lms.logouturl', 'http:/www.fillcontacts.com/moodle/login/logoutlms.php');
		Configure::write('Lms.session', 'http://hc.local/moodle/spywork.php');
		Configure::write('Lms.loginafterpath', 'http://hc.local/moodle/index.php');
		Configure::write('Lms.categoryrolepath', 'http://hc.local/moodle/setupemployercatrole.php');
		Configure::write('Lms.categorygetcoursespath', 'http://hc.local/moodle/courses.php');
		Configure::write('Lms.candidatebadgespath', 'http://hc.local/moodle/candidatesbadges.php');
		Configure::write('Lms.searchcoursepath', 'http://hc.local/moodle/searchcourse.php');
		Configure::write('Lms.searchwebinarpath', 'http://hc.local/moodle/searchwebinar.php');
		Configure::write('Lms.categorygetwebinarspath', 'http://hc.local/moodle/webinars.php');
		Configure::write('Lms.categorygetallmaterialpath', 'http://hc.local/moodle/alltrainingmaterial.php');
		Configure::write('Lms.newmaterialnotificationseekersurl', 'http://hc.local/moodle/newmaterialnotification.php');
		Configure::write('Lms.paypalenrolledcoursepath', 'http://hc.local/moodle/paidcourses.php');
		Configure::write('Lms.setupseeker', 'http://hc.local/moodle/setupSeeker.php');
		Configure::write('Lms.courseview', 'http://hc.local/moodle/course/view.php');
		Configure::write('Lms.coursecreate', 'http://hc.local/moodle/createcourse.php');
		Configure::write('Lms.coursedelete', 'http://hc.local/moodle/deletecourse.php');
		Configure::write('Lms.courseupdate', 'http://hc.local/moodle/updatecourse.php');
		Configure::write('Lms.syncuserspath', 'http://hc.local/moodle/sync_users_cusotm.php');
		Configure::write('Lms.setupvendorrole', 'http://hc.local/moodle/setupvendorcatrole.php');
		
		Configure::write('Jobber.baseurl', 'http://hc.local/happycandidate/jobberland/');
		Configure::write('Jobber.employerloginurl', 'http://hc.local/happycandidate/jobberland/employer/log_employer_in.php');
		
		Configure::write('Jobber.adminloginurl', 'http://hc.local/happycandidate/jobberland/admin/log_admin_in.php');
		Configure::write('Jobber.adminlogouturl', 'http://hc.local/happycandidate/jobberland/admin/admin_logout.php');
		Configure::write('Jobber.adminjoblistingurl', 'http://hc.local/happycandidate/jobberland/admin/manage_listings.php');
		Configure::write('Jobber.adminmanageusersurl', 'http://hc.local/happycandidate/jobberland/admin/manage_employee_active.php');
		Configure::write('Jobber.adminmanageseekersurl', 'http://hc.local/happycandidate/jobberland/admin/manage_seeker.php');
		Configure::write('Jobber.adminmanageownersurl', 'http://hc.local/happycandidate/jobberland/admin/manage_owner.php');
		Configure::write('Jobber.adminmanagejobinputssurl', 'http://hc.local/happycandidate/jobberland/admin/view_category.php');
		Configure::write('Jobber.adminjobboardurl', 'http://hc.local/happycandidate/jobberland/admin/cpanel.php');
		
		Configure::write('Jobber.seekerloginurl', 'http://hc.local/happycandidate/jobberland/log_seeker_in.php');
		Configure::write('Jobber.seekerlogouturl', 'http://hc.local/happycandidate/jobberland/seeker_logout.php');
		Configure::write('Jobber.seekerprofileurl', 'http://hc.local/happycandidate/jobberland/account/');
		Configure::write('Jobber.seekerprofileloginurl', 'http://hc.local/happycandidate/jobberland/account/change_password/');
		Configure::write('Jobber.seekercvurl', 'http://hc.local/happycandidate/jobberland/curriculum_vitae/');
		Configure::write('Jobber.seekercvviewurl', 'http://hc.local/happycandidate/jobberland/employer/review_cv/');
		Configure::write('Jobber.seekerdefaultcvurl', 'http://hc.local/happycandidate/jobberland/curriculum_vitae/resume/');
		Configure::write('Jobber.seekercletterurl', 'http://hc.local/happycandidate/jobberland/covering_letter/');
		Configure::write('Jobber.seekerhomeurl', 'http://hc.local/happycandidate/jobberland/');
		Configure::write('Jobber.seekerjobsurl', 'http://hc.local/happycandidate/jobberland/applications/');
		Configure::write('Jobber.seekerlatestjobsurl', 'http://hc.local/happycandidate/jobberland/latestjob/');
		Configure::write('Jobber.seekersavejobsurl', 'http://hc.local/happycandidate/jobberland/save_job/');
		Configure::write('Jobber.seekersavesearchsurl', 'http://hc.local/happycandidate/jobberland/save_search/');
		Configure::write('Jobber.seekerjobdetailurl', 'http://hc.local/happycandidate/jobberland/job/');
		Configure::write('Jobber.seekerjobsearchurl', 'http://hc.local/happycandidate/jobberland/search_result/');
		Configure::write('Jobber.seekerprofileperformanceurl', 'http://hc.local/happycandidate/jobberland/getSeekerProfilePerformace.php');
		Configure::write('Jobber.newjobnotificationseekersurl', 'http://hc.local/happycandidate/jobberland/employer/getNewJobNotificationCandidates.php');
		
		Configure::write('Jobber.employerlogouturl', 'http://hc.local/happycandidate/jobberland/employer/employer_logout.php');
		Configure::write('Jobber.employersetportalurl', 'http://hc.local/happycandidate/jobberland/employer/set_portal.php');
		Configure::write('Jobber.employeraddjoburl', 'http://hc.local/happycandidate/jobberland/employer/addjob/');
		Configure::write('Jobber.employerjobindexurl', 'http://hc.local/happycandidate/jobberland/employer/myjobs/');
		Configure::write('Jobber.employerprofileurl', 'http://hc.local/happycandidate/jobberland/employer/account/');
		
		/*Configure::write('Social.FbApkey','459600480819579');
		Configure::write('Social.FbSecretkey','5e31f21f34f53939af025039879c09b6');*/

		/* Configure::write('Social.FbApkey','1877502289193161');
		Configure::write('Social.FbSecretkey','69a6b5277dcd92c637588d76786e729d');  */
		
		/* Configure::write('Social.FbApkey','440280512983664');
		Configure::write('Social.FbSecretkey','beee305b606290d22beadba9bcf6db04'); */
		
		Configure::write('Social.FbApkey','2039225979637950');
		Configure::write('Social.FbSecretkey','9b07ab5a26e45786eb43b94a570c8418');
		
		Configure::write('Social.LinkedInApkey','jg1nraaupiah');
		Configure::write('Social.LinkedInSecretkey','TAzjfmkkfnaSGSfd');
		
		Configure::write('Social.TwitterApkey','gvN7mYC8VFhD4YaFk8nw');
		Configure::write('Social.TwitterSecretkey','XNiMclm61m4mIGo60QYB86lbquMf0GEnuS5SCx8');

		
	}
	 
	Configure::write('Portal.monthsubscription',array('slink'=>'https://vh118.infusionsoft.com/app/orderForms/HC-Monthly-Test-Order','sprice'=>'$99.00'));
	Configure::write('Portal.yearsubscription',array('slink'=>'https://vh118.infusionsoft.com/app/orderForms/HC-Yearly-Test-Order','sprice'=>'$999.00'));
	
        /** Support mail **/
	if($_SERVER['SERVER_NAME'] == "localhost")
	{
		Configure::write('HC.SupportAddress','raj20084u@gmail.com');
                Configure::write('HC.OwnerSupportAddress','raj20084u@gmail.com');
                Configure::write('HC.VendorSupportAddress','raj20084u@gmail.com');
	}
	else
	{
		Configure::write('HC.SupportAddress','arjun.gunjal@redorangetechnologies.com');
		Configure::write('HC.OwnerSupportAddress','arjun.gunjal@redorangetechnologies.com');
		Configure::write('HC.VendorSupportAddress','arjun.gunjal@redorangetechnologies.com');
//		Configure::write('HC.SupportAddress','support@careersupportnetwork.com');
//                Configure::write('HC.OwnerSupportAddress','support@happycandidates.com');
//                Configure::write('HC.VendorSupportAddress','support@happycandidates.com');
		
	}
        
	Configure::write('nameServers', array("ns1.cp-in-4.webhostbox.net", "ns2.cp-in-4.webhostbox.net"));
	
	
	
	

/**
 *
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'File', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 * 		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 		'lock' => false, //[optional]  use file locking
 * 		'serialize' => true, [optional]
 *	));
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Apc', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Xcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *		'user' => 'user', //user from xcache.admin.user settings
 *		'password' => 'password', //plaintext password (xcache.admin.pass)
 *	));
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Memcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'persistent' => true, // [optional] set this to false for non-persistent connections
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *	));
 *
 *  Wincache (http://php.net/wincache)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Wincache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 */

/**
 * Configure the cache handlers that CakePHP will use for internal
 * metadata like class maps, and model schema.
 *
 * By default File is used, but for improved performance you should use APC.
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in bootstrap.php for more info on the cache engines available
 *       and their settings.
 */
$engine = 'File';

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') > 0) {
	$duration = '+10 seconds';
}

// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'myapp_';

/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

/**
 * Configure the cache for model and datasource caches. This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_model_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));
