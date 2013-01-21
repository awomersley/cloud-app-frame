<?php

$CldClass=array(
	
	'App'=>array(
		'Alias'=>'App',
		'Class'=>'Cld_App',
		'Properties'=>array(
			'routes'=>array(
				array('alias'=>'/default', 'route'=>'/main/index'),
				array('alias'=>'/*$', 'route'=>'/main/*1'),
				array('alias'=>'/*/*$', 'route'=>'/*1/*2/index'),
				array('alias'=>'/theme/*/*', 'route'=>'/display/theme/*1/*2'),
				array('alias'=>'/lib/*/*', 'route'=>'/display/lib/*1/*2'),
				array('alias'=>'/res/*', 'route'=>'/display/cache/*1'),
				array('alias'=>'/download/get/*', 'route'=>'/cldfiles/download/get/*1')
			)
		)
	),
	
	'Auth'=>array(
		'Alias'=>'Auth',
		'Class'=>'Cld_Auth',
		'Properties'=>array('Auth')
	),
	
	'Cache'=>array(
		'Alias'=>'Cache',
		'Class'=>'Cld_Cache',
		'Properties'=>array(
			'path'=>PATH_CACHE,
			'files'=>array(
				array('file'=>'*ajax*.html',	'expires'=>0),
				array('file'=>'*edit*.html',	'expires'=>0),
				array('file'=>'*html',			'expires'=>6),
				array('file'=>'*template.php',	'expires'=>6),
				array('file'=>'*js',			'expires'=>1),
				array('file'=>'*css',			'expires'=>1)
			),
			'encoding'=>array(
				array('type'=>'gzip',		'ext'=>'.gzip',		'function'=>'gzencode'),
				array('type'=>'deflate',	'ext'=>'.deflate',	'function'=>'gzdeflate')
			)
		)
	),
	
	'Config'=>array(
		'Alias'=>'Config',
		'Class'=>'Cld_Config',
		'Properties'=>array()
	),
	
	'Device'=>array(
		'Alias'=>'Device',
		'Class'=>'Cld_Device',
		'Properties'=>array()
	),
	
	'FileManager'=>array(
		'Alias'=>'FileManager',
		'Class'=>'Cld_FileManager',
		'Properties'=>array()
	),
		
	'Hash'=>array(
		'Alias'=>'Hash',
		'Class'=>'Cld_Hash',
		'Properties'=>array(
			'key'=>'a1b2c3d4'
		)
	),
	
	'Head'=>array(
		'Alias'=>'Head',
		'Class'=>'Cld_Head',
		'Properties'=>array()
	),
	
	'Output'=>array(
		'Alias'=>'Output',
		'Class'=>'Cld_Output',
		'Properties'=>array()
	),
	
	
	'Resource'=>array(
		'Alias'=>'Resource',
		'Class'=>'Cld_Resource',
		'Properties'=>array()
	),
	
	'Request'=>array(
		'Alias'=>'Request',
		'Class'=>'Cld_Request',
		'Properties'=>array()
	)

);