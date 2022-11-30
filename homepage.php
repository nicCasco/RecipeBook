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
    $recipe_to_like = NULL;
    $recipe_to_update = NULL;
?>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
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

  else if(!empty($_POST['btnAction'] && $_POST['btnAction']=='Like'))
  {
    likeRecipe($_SESSION['id'], $_POST['recipe_to_like']);
  }

  else{
    $list_of_recipes = getAllRecipes();
  }
  
}
?>

<?php 
    function totalRecipes(){
        global $db;
        $query = "CALL countRecipes(@p1)";
        
        try{
            $statement = $db->prepare($query);
            $statement->execute();
            $row = $db->query("SELECT @p1 AS total_recipes")->fetch();
            return $row;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
?>


<body>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<center>
<p>&nbsp</p>
<h1> Homepage </h1>
<p>Total Recipes: <?php $total_r = totalRecipes(); 
    echo $total_r['total_recipes'];?></p>
</center>

<p></p>
<link rel="stylesheet" href="margin.css">



<!-- SOURCE dropdown: https://blog.hubspot.com/website/html-dropdown -->

<br>

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


<p>&nbsp</p>



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


<div class='row'>
    

        <?php 
        foreach ($list_of_recipes as $recipe_info):  ?>
        <!-- /* Display contents of recipes here */ -->
        
            <div class='col-sm-3'>
                <tr>
           
                    <!-- I stole the contents of recipecard.php bc I didn't know how to bring the content from there to here lol
                            if you know how to do that feel free to change this. -->
                    <div class="card" style="width: 18rem;">
                    <!--
                        <img class="card-img-top" src="..." alt="Card image cap">
        -->
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
                            <a href="evaluations.php?recipeID=<?php echo $recipe_info['recipeID']?>&title=<?php echo $recipe_info['title']?>&ownerID=<?php echo $recipe_info['userID']?>" class="btn btn-primary">Evaluation</a>
                            <p></p>
                            <form action="homepage.php" method="post">
                            <input type="submit" value="Like" name="btnAction" class="btn btn-primary" 
                                title="Click to like recipe" />
                            <input type="hidden" name="recipe_to_like" 
                                value="<?php echo $recipe_info['recipeID']; ?>"
                            />
                        </form>
                        <?php 
                            if ( getRecipeInstructions( $recipe_info['recipeID'])!= null ){
                                ?>
                                <center>
                                <p>INSTRUCTIONS</p>
                            </center>
                                <?php $instructions = getRecipeInstructions( $recipe_info['recipeID']); ?>
                                <?php foreach($instructions as $one_instruct) ?>
                                    <?php echo $one_instruct?>
                                <?php
                            }
                            ?>

                                </br>
                                </br> 

                            <?php
                            if ( getRecipeIngredients( $recipe_info['recipeID'])!= null ){
                            ?>
                            <center>
                                <p>INGREDIENTS</p>
                            </center>
                                <?php $ingredients = getRecipeIngredients( $recipe_info['recipeID']); ?>
                                <?php foreach($ingredients as $one_ingred) ?>
                                <?php echo $one_ingred?>
                                    <p></p>
                                <?php
                            }
                        ?>
                            
                            
                        </div>
                        <div>
                        
                        
                        <!-- THIS IS THE UNIMPLEMENTED MORE INFO BUTTON 
                        <form method="" action="">
                            <input type="submit" name="submit" value="More Info">
                            
                        </form>
                        -->
                        
                        
                        
                        </div>
                    </div>
                    <p></p>
                    
                </tr>
            </div>
            
        <?php endforeach; ?>
        
        
    </div>

</body>
                        


</html>
