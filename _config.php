<?php
/* this file is needed for the widget to be included in db/build */

/* copy & edit this in your _config if you want to influence the BadLoginUrl */
#LoginWidget::setBadLoginURL('Security/login');
function blockBuilder_dir() {
	return trim(str_replace(BASE_PATH, "", dirname(__FILE__)), DIRECTORY_SEPARATOR);
}



/**
 * Returns the absolute  path of the current module path
 *
 * @return string
**/
function blockBuilder_path() {
	return BASE_PATH . '/' . blockBuilder_dir();
}