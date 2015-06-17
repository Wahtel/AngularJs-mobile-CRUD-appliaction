<script>
	window.history.back();
</script>

<?php
define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "000000");
define("DB_NAME", "test_app");

mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());

$sql = 'CREATE DATABASE ' . DB_NAME;
mysql_query($sql) or die(mysql_error());

mysql_select_db(DB_NAME) or die(mysql_error());

$sql = "
CREATE TABLE customers (
	 id int(11) NOT NULL auto_increment,
	 name varchar(50) NOT NULL default '',
	 email varchar(50) NOT NULL default '',
	 telephone varchar(50) NOT NULL default '',
	 address varchar(50) NOT NULL default '',
	 street varchar(50) NOT NULL default '',
	 city varchar(50) NOT NULL default '',
	 state varchar(50) NOT NULL default '',
	 zip int(20),
	 PRIMARY KEY (id)
)ENGINE=InnoDB";
mysql_query($sql) or die(mysql_error());

mysql_close();
?>