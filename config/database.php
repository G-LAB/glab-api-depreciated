<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "cms";
$active_record = TRUE;

$db['cms']['hostname'] = "internal-db.s91576.gridserver.com";
$db['cms']['username'] = "db91576";
$db['cms']['password'] = "KsQXughkwjhZGqNIIqrbUzDnwyI9eQcnzZQLiqKQfC9HrvRxWr";
$db['cms']['database'] = "db91576_glab_cms";
$db['cms']['dbdriver'] = "mysql";
$db['cms']['dbprefix'] = "";
$db['cms']['pconnect'] = TRUE;
$db['cms']['db_debug'] = TRUE;
$db['cms']['cache_on'] = FALSE;
$db['cms']['cachedir'] = "";
$db['cms']['char_set'] = "utf8";
$db['cms']['dbcollat'] = "utf8_general_ci";

$db['api_glab']['hostname'] = "internal-db.s91576.gridserver.com";
$db['api_glab']['username'] = "db91576";
$db['api_glab']['password'] = "KsQXughkwjhZGqNIIqrbUzDnwyI9eQcnzZQLiqKQfC9HrvRxWr";
$db['api_glab']['database'] = "db91576_api_glab";
$db['api_glab']['dbdriver'] = "mysql";
$db['api_glab']['dbprefix'] = "";
$db['api_glab']['pconnect'] = TRUE;
$db['api_glab']['db_debug'] = TRUE;
$db['api_glab']['cache_on'] = FALSE;
$db['api_glab']['cachedir'] = "";
$db['api_glab']['char_set'] = "utf8";
$db['api_glab']['dbcollat'] = "utf8_general_ci";




/* End of file database.php */
/* Location: ./system/application/config/database.php */