<?
//connection vars
$dbhost = "localhost";
$dblogin = "";
$dbpassword = "";
$dbdatabase = "";

//set up the old connection
$connection = mysql_connect($dbhost, $dblogin, $dbpassword); 
        @mysql_select_db($dbdatabase);

if(!$connection)
    die ("Can not connect to the database: <br />".mysql_error());

//migration to pdo, set up new connection
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try { $db = new PDO("mysql:host={$dbhost};dbname={$dbdatabase};charset=utf8", $dblogin, $dbpassword, $options); }
catch(PDOException $ex){ die("Failed to connect to the database: " . $ex->getMessage());}
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
header('Content-Type: text/html; charset=utf-8');

// IP Proxy
if ($HTTP_X_FORWARDED_FOR) {
    echo "Proxy Name $HTTP_VIA";
    echo "Proxy IP $REMOTE_ADDR";
    echo gethostbyaddr();
    echo "Your Real IP $HTTP_X_FORWARDED_FOR";
} else {
    // if access direct to Internet, without Proxy
    echo "$REMOTE_ADDR";
}
	
?>