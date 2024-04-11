<?php
include_once __DIR__ . '/include/connect.php'; 

session_start();

if(!isset($_SESSION["user"])){
    header('Location: login.php');
    exit();
}
// $sqlQry="SELECT * FROM users WHERE is_deleted IS NULL ORDER BY ID DESC";
$sqlQry="SELECT * FROM users";
$datastore= $pdo->select($sqlQry);
// $smt = $conn->prepare($sqlQry);
// $smt->execute();
// $datastore = $smt->fetchAll(PDO::FETCH_ASSOC);
// $datastore[] = $rs;

// $sqlQry="SELECT * FROM users";
// $datastore= $pdo->select($sqlQry); 



$page = isset($_GET['page']) ? $_GET['page'] : 1;
// try{
        $host ="localhost";
    $dbname = "structure_task_project";
    $username ="root";
    $password = "";

    $dbh = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);

// $sel_sql ="SELECT * FROM users WHERE is_deleted IS NULL ORDER BY ID DESC";
$sel_sql ="SELECT * FROM users";

$options = array(
    'results_per_page' => 10,
    'url'        => 'http://localhost/company_pagination_search_noofrecode\home.php?page=*VAR*', // Update the URL accordingly
    'db_handle'  => $dbh,
    'text_prev' => '&laquo; Prev',
    'text_next' => 'Next &raquo;',
    'text_first' => '&laquo; First',
    'text_last' => 'Last &raquo;',
    'text_ellipses' => '...',
    'class_ellipses' => 'ellipses',
    'class_dead_links' => 'dead-link',
    'class_live_links' => 'live-link',
    'class_current_page' => 'current-link',
  );


  $paginate = new pagination($page, $sel_sql, $options);



// include_once 'tmpl/home.inc.php';
// exit;


$template = 'home.inc.php';
$layout = 'main.layout.php';
include_once ('layout/end.inc.php')

?>