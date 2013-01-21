<?php

/**
 * Cloud Dir - Copy files from the web to your own personal cloud directory
 * Copyright (C) 2012  Andrew Womersley - aw1.me
 * 
 * Cloud Dir is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/* set error handling */
error_reporting(E_ALL); //& ~E_NOTICE
ini_set('display_errors','Off');

/* start session */
session_start();

/* start output buffer */
ob_start();

/* define base paths */
define('BASE',				dirname(dirname(__FILE__)).'/');
define('PATH_APP',			BASE.'app/');
define('PATH_CLD',			BASE.'lib/cld/');
define('PATH_LIB',			BASE.'lib/');
define('PATH_CONFIG',		BASE.'config/');
define('PATH_CACHE',		BASE.'tmp/cache/');
define('PATH_LOG',			BASE.'tmp/logs/');
define('PATH_THEME',		BASE.'theme/');

/* load and start the autoloader */
include(PATH_CLD.'class.autoload.php');
Cld_Autoload::Init();

/* install factory and cld classes */
Cld::InstallFactory('Cld','Cld_Factory');
Cld::Install(PATH_CONFIG.'cld.factory.php');

/* load config */
Cld::Config()->Add(PATH_CONFIG.'cld.config.php');
Cld::Config()->Add(PATH_CONFIG.'cld.settings.json');

/* run main app init */
Cld::App()->Router();

/* dispatch app */
Cld::App()->Dispatch();