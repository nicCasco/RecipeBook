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

    $list_of_my_recipes = getAllMyRecipes($_SESSION["id"]);
    $recipe_to_update = NULL;
    $instructions_update = NULL;
?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(!empty($_POST['btnAction']) && $_POST['btnAction'] =='Add')
    {
        addRecipe($_SESSION['id'], $_POST['author'], $_POST['title'], $_POST['category'], $_POST['time'], $_POST['instructions']);
        $list_of_my_recipes = getAllMyRecipes($_SESSION["id"]);
    }

    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
    { 
        deleteRecipe($_SESSION['id'], $_POST['recipe_to_delete']);
        $list_of_my_recipes = getAllMyRecipes($_SESSION["id"]);

    }

    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {
        $recipe_to_update = getRecipeForUpdate($_SESSION['id'], $_POST['recipe_to_update']);
        $instructions_update = getRecipeInstructionsForUpdate($_SESSION['id'], $_POST['recipe_to_update']); 
        
    }

    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update")
    {
        echo "this shit goes through";
        updateRecipe($_SESSION['id'], $_POST['recipe_to_update'], $_POST['author'], $_POST['title'],
            $_POST['category'], $_POST['time']);
        $list_of_my_recipes = getAllMyRecipes($_SESSION["id"]);
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
    
    <title>Homepage</title>

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
    <center><h1> My Recipes </h1></center>

    <form name="addRecipeForm" action="recipespage.php" method="post">
        <div class="row">
            Author:
            <input type="text" class="form-control" name="author" required
                value="<?php if ($recipe_to_update!=null) echo $recipe_to_update['author'] ?>"
            />

        </div>
        <div class="row">
            Title:
            <input type="text" class="form-control" name="title" required
                value="<?php if ($recipe_to_update!=null) echo $recipe_to_update['title'] ?>"
            />
            
        </div>
       
        <div class="row">
            Category:
            <input type="text" class="form-control" name="category" required
                value="<?php if ($recipe_to_update!=null) echo $recipe_to_update['category'] ?>"
            />
            
        </div>
        <div class="row">
        Time:
            <input type="text" class="form-control" name="time" required
                value="<?php if ($recipe_to_update!=null) echo $recipe_to_update['time'] ?>"
            />
            
        </div>
         <div class="row">
        Instructions:
            <input type="text" class="form-control" name="instructions" required
            value="<?php if ($instructions_update!=null) echo $instructions_update['instructions'] ?>"/>
            
        </div>
        <!-- <div class="row">
        Ingredients:
            <input type="text" class="form-control" name="ingredients" required/>
            
        </div> -->
        <!--/*change to be able to upload image */
        <div class="row">
            Image
            <input type="text" class="form-control" name="image" required/>
            
        </div>
        /*change to be able to upload image */
        <div class="row">
            Video:
            <input type="text" class="form-control" name="video" required/>
            
        </div> -->
        <div>
            <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
                title="Insert a recipe" />
            <input type="hidden" name="recipe_to_update" value="<?php echo $recipe_to_update['recipeID'];?>" />
            <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-primary"
                title="Update a recipe" />                        
        </div>  
    </form>

    <!-- //the delete button is displayed next to every one of the recipes in my recipe -->
    <div class='row'>
        <?php foreach ($list_of_my_recipes as $recipe_info): ?>
        <!-- /* Display contents of recipes here */ -->
            <div class='col-sm-3'>
                <tr>
                    <!-- I stole the contents of recipecard.php bc I didn't know how  to bring the content from there to here lol
                            if you know how to do that feel free to change this. -->
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $recipe_info['submittedRecipe']?></h5>
                            <form action = "recipespage.php" method="post">
                                <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
                                <input type="hidden" name="recipe_to_delete" value="<?php echo $recipe_info['recipeID']?>" />
                                <input type="submit" value="Update" name="btnAction" class="btn btn-primary" />
                                <input type="hidden" name="recipe_to_update" value="<?php echo $recipe_info['recipeID'];?>" />
                            </form>
                        </div>
                    </div>
                    <p></p>
                </tr>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>

</html>
