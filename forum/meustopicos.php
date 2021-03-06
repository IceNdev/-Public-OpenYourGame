<?php
ob_start();
session_start();


include_once("../includes/database.php");
include_once("../includes/classes.php");
$functions = new functions();
$db = new DatabaseIcen();
$functions->isLoggedAndAdmin($_SESSION["userId"]);
if(isset($_SESSION["userId"]))$functions->manutencao($_SESSION["userId"]);
else $functions->manutencao(null);
$idUser = null;
if(isset($_SESSION['userId'])){
    $idUser = $_SESSION['userId'];
}
$pagina = 1;
if (isset($_GET["p"])) {
    if($_GET["p"] == 0){
        $pagina = 1;
    }else{
        $pagina = $db->quote($_GET["p"]);
    }

}

?>
<!DOCTYPE html>

<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <title>OYG - Meus Topicos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="icon" href="../images/icon.png" type="image/x-icon" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/second.css">


    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
</head>
<body>
<?php
include_once("menu.php");
$titulo = "Meus Topicos";
include_once("../includes/banner.php");
?>
<div class="container-fluid containerSpace">
    <div class="page-header" id="banner">


        <div class="row">
            <?php
            $db->getTopicosUser($idUser,$pagina);
            ?>

        </div>
        <div class="row">
            <?php
            $numToShow = 20;
            $sugestoes = $db->query("SELECT * FROM topicos WHERE ID_Utilizador = $idUser");
            $total_records = $sugestoes->num_rows;
            $total_pages = ceil($total_records / $numToShow);
            echo "<ul class='pager'>";
            $paginaTraz = $pagina - 1;
            $paginaFrente = $pagina + 1;
            echo "<li class='previous_'> <a href='meustopicos?p={$paginaTraz}'><span aria-hidden='true'>&larr;</span>Anterior</a> </li>";
            for ($i=1; $i<=$total_pages; $i++) {
                echo "
                    
                  <li class='next_'><a href='meustopicos?p=".$i."'><span aria-hidden='true'></span>$i</a></li>

                ";

            };
            echo "<li class='next_'> <a href='meustopicos?p={$paginaFrente}'><span aria-hidden='true'>&rarr;</span>Proxima</a> </li></ul>";
            ?>
        </div>
        <?php include_once("../includes/footer.php"); ?>
    </div>
</body>
</html>
