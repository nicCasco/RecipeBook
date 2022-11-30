<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php
    require("context-db.php");
    require("evaluations-db.php");
    
    $list_of_my_entries = getSubmittedEvals($_SESSION["id"]);
    $recipeID = $_GET['recipeID'];

    $title = $_GET['title'];
    $ownerID = $_GET['ownerID'];
?>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Add Evaluation')
        {
            addEval($_POST['ownerID'], $_POST['recipeID'], $_POST['rating'], $_POST['difficulty']);
            $evalID = getEval();
            addMyEval($_SESSION['id'], $evalID);
            //header("location: homepage.php");
            //echo "Evaluation has been submitted";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="Nicole Casco">
    <meta name="description" content="Homepage that displays all recipe cards that are available from the database"> 
    
    <title>Evaluation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</head>

<body>

<div>

    <?php
        include("navbar.html")
    ?>
</div>
<div>
<link rel="stylesheet" href="margin.css">
<p>&nbsp</p>
<center>
    <h1>Evaluation for
    
    <?php
        //var_dump($_SESSION);
          //echo $_SESSION["h".$recipeID]
          echo $title;
          //echo $recipeID;
          //echo $ownerID;?>
    </h1>
</center>
    <p>&nbsp</p>

    <form name="addEvaluation" action="evaluations.php" method="post">
        <div class ="row">
            Rating (1 = Bad, 3 = Ok, 5 = Amazing):
            <input type="rating" class="form-control" name="rating" required/>
        </div>
        <p></p>
        <div class ="row">
            Difficulty (1 = Beginner, 3 = Intermediate, 5 = Expert):
            <input type="difficulty" class="form-control" name="difficulty" required/>
        </div>
        <div >
        <p></p>
        <form action="evaluations.php" method="post">
            <input type="submit" value="Add Evaluation" name="btnAction" class="btn btn-dark" />
            
            <input type="hidden" name="recipeID" value="<?php echo $recipeID;?>" />
            <input type="hidden" name="title" value="<?php echo $title;?>" />
            <input type="hidden" name="ownerID" value="<?php echo $ownerID;?>" />
        </form>
        </div>
    </form>
</div>
</body>
</html>