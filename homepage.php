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
    require("recipebook-db.php");
    require("evaluations-db.php");
    $list_of_recipes = getAllRecipes();
?>

<!DOCTYPE html>
<html>

<div>
    <?php
        include("navbar.html")
    ?>
</div>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="Nicole Casco">
    <meta name="description" content="Homepage that displays all recipe cards that are available from the database"> 
    
    <title>Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</head>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && (($_POST['btnAction'] =='Title') || ($_POST['btnAction'] =='Author') || ($_POST['btnAction'] =='Category') || ($_POST['btnAction'] =='Time')))
  {
      $list_of_recipes = filterDaRecipes($_POST['btnAction'], $list_of_recipes);
  }
  
  else{
    $list_of_recipes = getAllRecipes();
  }
  
}
?>


<body>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<center>
<p></p>
<h1> Homepage </h1>
</center>
<p></p>



<!-- SOURCE dropdown: https://blog.hubspot.com/website/html-dropdown -->

<div class="dropdown" method="post">
<link rel="stylesheet" href="dropped.css">
    <button class="dropbtn">Filter</button>
  
  <div class="dropdown-content">



    <!-- <button  >Title</button> -->

    <form action="homepage.php" method="post" >
        <input type="submit" value="Title" name="btnAction"> 
    </form>



    <!-- <button $filtered = "author">Author</button> -->

    <form action="homepage.php" method="post">
        <input type="submit" value="Author" name="btnAction">   
    </form>


    <!-- <button $filtered = "category">Category</button> -->

    <form action="homepage.php" method="post">
        <input type="submit" value="Category" name="btnAction">  
    </form>


    <!-- <button $filtered = "time">Time to Prepare</button> -->

    <form action="homepage.php" method="post">
        <input type="submit" value="Time" name="btnAction">
    </form>

    
  </div>
</link>
</div>



<?php
function filterDaRecipes( $filtered, $list_of_recipes )
{
    //$sorted_list = "SELECT id, firstname, lastname FROM MyGuests ORDER BY lastname";
    //$sorted_list = "SELECT ( recipe_id, author, title, category, time, image ) FROM recipes ORDER BY title";
    global $db;
    if ($filtered == null) {
        $query = "SELECT * FROM recipes";
    }
    else{
        $query = "SELECT * FROM recipes ORDER BY $filtered";
    }
    
    $statement = $db->prepare($query);
    $statement->execute();
    $list_of_recipes = $statement->fetchAll();
    $statement->closeCursor();
    return $list_of_recipes;

} 
?>

<?php 
function getRecipeSession($recipe_info){
    $_SESSION['recipeID'] = $recipe_info['recipeID'];
    return $_SESSION['recipeID'];
}
?>



<div class='row'>
    
    
        <?php 
        foreach ($list_of_recipes as $recipe_info):  ?>
        <!-- /* Display contents of recipes here */ -->
            <div class='col-sm-3'>
                <tr>
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $recipe_info['title']?></h5>
                            <p class="card-text"><?php echo $recipe_info['author']; ?></p>
                            <p class="card-text"> Rating:
                                <?php $list_of_ratings = getEvalRating($recipe_info['recipeID']); ?>
                                <?php foreach($list_of_ratings as $ratings) ?>
                                <?php echo $ratings['AVG(rating)'] ?>
                                </p>
                            <p class="card-text"> Difficulty:
                                <?php $list_of_diffs = getEvalDifficulty($recipe_info['recipeID']); ?>
                                <?php foreach($list_of_diffs as $diffs) ?>
                                <?php echo $diffs['AVG(difficulty)'] ?>
                                </p>
                                <form action="evaluations.php" method="get">
                                    <input type="hidden" name="recipeID" value="<?php echo $recipe_info['recipeID'];?>" />
                                    <input type="hidden" name="title" value="<?php echo $recipe_info['title'];?>" />
                                    <button>Evaluations</button>
                                </form>
                            <a href="evaluations.php?recipeID=<?php echo $recipe_info['recipeID']?>&title=<?php echo $recipe_info['title']?>" class="btn btn-primary">Evaluation</a>
                            <?php //$_SESSION[$recipe_info['recipeID']] = $recipe_info['title'];?>
                            <?php $recipe_str = strval($recipe_info['recipeID']);
                            $_SESSION["h".$recipe_str] = $recipe_info['title'];?>
                        </div>
                    </div>
                    <p></p>
                </tr>
            </div>
        <?php endforeach; ?>
    </div>

</body>


</html>
