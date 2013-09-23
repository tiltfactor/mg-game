<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

// ------------------------------------------------------------------------
//	HybridAuth End Point
// ------------------------------------------------------------------------

$path = Yii::getPathOfAlias('ext.HybridAuth');
require_once $path . '/hybridauth-2.1.2/hybridauth/Auth.php';  //path to the Auth php file within HybridAuth folder

require_once( $path . "/hybridauth-2.1.2/hybridauth/Endpoint.php" );

Hybrid_Endpoint::process();
