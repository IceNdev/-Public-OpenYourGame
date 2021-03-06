<?php
ob_start();
session_start();
include_once ("../includes/classes.php");
$functions = new functions();
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
$pagina = 1;
if(isset($_GET["jogo"])) {
    include_once("../forum/forum_database.php");
    $db = new DatabaseIcen();
    if(!$db->jogoExist($_GET["jogo"])){
        header("Location: index");
    }


    if (isset($_GET["p"])) {
        if($_GET["p"] == 0){
            $pagina = 1;
        }else{
            $pagina = $db->quote($_GET["p"]);
        }   
    }

    $idJogo = $db->getGamesIDWithNome($_GET["jogo"]);
}

?>

<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Forum <?= $_GET["jogo"] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link rel='stylesheet prefetch' href='https://cdn.jsdelivr.net/foundation/5.0.2/css/foundation.css'>

    <style>
        .pager li > a, .pager li > span {
            display: inline-block;
            padding: 5px 14px;
            background-color: #ffa700;
            border: 0px solid #ddd;
            border-radius: 15px;
        }

        .row {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 0;
            margin-bottom: 0;
            *zoom: 1;
        }

        h2,h3,h1,h4{
            color: #edecee !important;
            font-family: 'Play', Arial, Helvetica Neue, Helvetica, Verdana, sans-serif; !important;
        }
        body{
            font-family: 'Play', Arial, Helvetica Neue, Helvetica, Verdana, sans-serif;
        }
        /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
        header {
            background-image: url('http://subtlepatterns.com/patterns/use_your_illusion.png');
            margin: 0;
            border-bottom: 3px solid hsl(195, 73%, 58%);
        }
        a {
            display: inline-block;

            color: inherit;
            text-decoration: none;
        }
        .row.mt { margin-top: 1.25em; }
        .row.mb { margin-bottom: 1.25em; }
        .pad { padding: 15px; }
        .spad { padding: 5px; }
        .lpad { padding: 20px;}
        .ar { text-align: right; }
        .logo {
            color: hsl(0, 0%, 100%);
            font-size: 18px;
            text-transform: lowercase;
        }
        .logo span:first-child {
            font-weight: 400;
        }
        .logo span:last-child {
            color: hsl(0, 0%, 70%);
            font-weight: 300;
        }
        nav.menu a {
            margin: 0 7px;
            color: hsl(0, 0%, 70%);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }
        nav.menu a:last-child {
            margin: 7px 0 7px 7px;
        }
        nav.menu a.current {
            color: hsl(0, 0%, 100%);
        }
        .top-msg {
            border-bottom: 5px solid hsla(0, 0%, 90%, .3);

            color: hsl(0, 0%, 40%);
            font-size: 13px;
            font-weight: 300;
        }
        .breadcrumb a {
            transition: color .5s;
        }
        .breadcrumb a:hover {
            color: hsl(0, 0%, 20%);
        }
        .breadcrumb a:after {
            content: '\00a0\00a0\002F\00a0\00a0';
            color: hsl(0, 0%, 70%);
        }
        .breadcrumb a:last-child:after {
            content: '\00a0\00a0\002F\00a0\00a0 now you\0027re here';
            color: hsl(0, 0%, 70%);
        }
        a.primary {
            color: hsl(0, 0%, 70%);
            transition: color .5s;
        }
        a.primary:hover {
            color: hsl(195, 73%, 58%);
        }
        a.underline {
            color: hsl(0, 0%, 70%);
        }
        a.underline:hover:after {
            content: '';
            display: block;
            width: inherit;
            height: 2px;
            background-color: hsl(195, 73%, 58%);
            margin-bottom: -2px;
            animation: link .9s ease;
        }
        @keyframes link {
            from { width: 0; }
            to   { width: 100%;}
        }
        /* Topic */

        .rounded {
            overflow: hidden;
        }
        .rounded.top {
            border-radius: 4px 4px 0 0;
        }
        .rounded.all {
            border-radius: 4px;
        }
        .forum-category {
            background-color: hsl(195, 73%, 58%);

            color: hsl(0, 0%, 100%);
            font-weight: 600;
            font-size: 13px;
            text-shadow: 0 1px 1px hsl(195, 73%, 40%);
        }
        .forum-head > .column {
            background-color: hsl(206, 35%, 13%);
            border-right: 1px solid hsl(212, 35%, 15%);
            border-left: 1px solid hsl(212, 28%, 12%);

            color: hsl(0, 0%, 100%);
            font-weight: 300;
            font-size: 12px;
            text-shadow: 0 1px 1px hsl(0, 0%, 0%);
            text-align: center;
        }
        .forum-head > .column:first-child {
            text-align: left;
            border-left: none;
        }
        .forum-head > .column:last-child {
            border-right: none;
        }
        .forum-topic > .column {
            min-height: 71px;
            max-height: 71px;
            background-color: hsl(180, 5.9%, 6.7%);
            border-bottom: 1px solid hsl(39.3, 100%, 50%);
            color: hsl(0, 0%, 50%);
            font-size: 12px;
        }

        .forum-topic > .column:first-child {
            color: hsl(0, 0%, 60%);
            font-size: 30px;
            text-align: center;
        }
        .forum-topic > .column:nth-child(n+3) {
            text-align: center;
        }
        .forum-topic > .column:last-child {
            text-align: left;
        }
        .forum-topic a {
            transition: color .5s;

            color: hsl(195, 73%, 58%);
            font-weight: 600;
        }
        .forum-topic a:hover {
            color: hsl(195, 73%, 48%);
        }
        .forum-topic span {
            display: block;
            margin: 0 0 2px 0;
        }
        .overflow-control {
            white-space: nowrap;
            overflow: hidden;
            text-overflow:ellipsis;
        }
        .forum-topic .column:nth-child(2) span.overflow-control {
            width: 70%;
            height: 15px;
        }
        .forum-topic span.center {
            padding-top: 10px;
        }
        .normal {
            background-color: hsl(0, 0%, 96%);

            color: hsl(0, 0%, 50%);
            font-size: 12px;
        }
        .normal h1.inset {
            background-color: hsl(206, 35%, 13%);
            margin: -20px -20px 20px -20px;

            color: hsl(0, 0%, 100%);
            padding: 15px 20px 15px 20px;
            font-size: 12px;
            font-weight: 300;
        }
        .normal p {
            margin: 0 0 40px 0;
            line-height: 20px;
        }
        .normal p:last-child {
            margin: 0;
        }
        #top-button {
            display: none;
            width: 27px;
            background-color: hsl(206, 35%, 13%);
            position: fixed;
            right: 60px;
            bottom: 20px;
            border-radius: 3px;
            cursor: pointer;

            padding: 5px;
            text-align: center;
            color: hsl(0, 0%, 100%);
        }
        #top-button.show {
            display: block;
        }
        @media only screen and (max-width: 768px) {
            header {
                fz
            }
            .logo,
            nav {
                text-align: center;
            }
            nav.menu a {
                margin: 7px;
            }
            .breadcrumb,
            .forum-head > .column:nth-child(2),
            .forum-head > .column:nth-child(3),
            .forum-topic > .column:first-child,
            .forum-topic > .column:nth-child(3),
            .forum-topic > .column:nth-child(4),
            #top-button {
                display: none;
            }
            .forum-category > span,
            .forum-category > .column:first-child,
            .forum-head > .column,
            .forum-topic > .column,
            .normal,
            .normal h1.inset {
                font-size: 10px;
                text-align: left;
            }
            .forum-head > .column {
                color: hsl(0, 0%, 100%);
                border: none;
                font-weight: 600;
            }
            .rounded,
            .rounded.top,
            .rounded.all {
                border-radius: 0;
            }
            .overflow-control > a,
            .overflow-control {
                display: block;
                width: 290px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .breadcrumb a:nth-child(2) { margin: 3px 0 3px 10px; }
            .breadcrumb a:nth-child(3) { margin: 3px 0 3px 20px; }
            .breadcrumb a:nth-child(4) { margin: 3px 0 3px 30px; }
            .breadcrumb a:after {
                display: none;
            }
        }

    </style>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/second.css">


    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
</head>


<body id="all">
<?php
include_once("menu.php");
$titulo = null;
if($_GET['jogo'] == "CS:GO")
    $titulo = "A Wikipedia do CS:GO";
else
    $titulo="Topicos";
include_once("../includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">
        <a href="adicionarTopico?jogo=<?= $_GET["jogo"] ?>" class="pull-right"><h3 style="color: #ffa700 !important;" >Novo Tópico <span class="glyphicon glyphicon-plus" ></span></h3></a>
        <h2>Forum <?= $_GET["jogo"] ?></h2>

        <?php


        ?>
        <div class="row" style="max-width: 100%;">
        <?php
        $db->getTopicos($idJogo,$pagina);
        ?>
        </div>

            <div class="row">
                <?php
                $numToShow = 20;
                $topicos = $db->query("SELECT * FROM topicos WHERE ID_Jogo = $idJogo");
                $total_records = $topicos->num_rows;
                $total_pages = ceil($total_records / $numToShow);
                echo "<ul class='pager'>";
                $paginaTraz = $pagina - 1;
                $paginaFrente = $pagina + 1;
                echo "<li class='previous_'> <a href='forum?jogo={$_GET["jogo"]}&p={$paginaTraz}'><span aria-hidden='true'>&larr;</span>Anterior</a> </li>";
                for ($i=1; $i<=$total_pages; $i++) {
                    echo "
                    
                  <li class='next_'><a href='forum?jogo={$_GET["jogo"]}&p=".$i."'><span aria-hidden='true'></span>$i</a></li>

                ";

                };
                echo "<li class='next_'> <a href='forum?jogo={$_GET["jogo"]}&p={$paginaFrente}'><span aria-hidden='true'>&rarr;</span>Proxima</a> </li></ul>";
                ?>
            </div>

        <?php include_once("../includes/footer.php"); ?>
    </div>
</body>
</html>