<? if(!session_id() ) {
	session_start();
}

$hostname     = "localhost";

$username     = "root";

$password     = "";

$databasename = "tbcprinter";

$visitorTimeout = 900; //=15 * 60

$MAXPAGE = 100;

$multiLanguage = 1;//0 : single  ;  1 : multi

$arrLanguage = array(

	array('vn','Việt Nam'),

);

?>



