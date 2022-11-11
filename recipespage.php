<?php
    require("connect-db.php");
    require("recipebook-db.php");

    $list_of_my_recipes = getAllMyRecipes();
?>

<?php
if($_SERVER['REQUEST_METHOD']==POST)
(
    if(!empty($_POST['btnAction']) && $_POST['btnAction'] =='Add')
    {
        addRecipe($_POST['userID'], $_POST['recipeID'], $_POST['author'], $_POST['title'], $_POST['category'], $_POST['time'],
        $_POST['instructions'], $_POST['image'], $_POST['video']);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
  { 
    deleteFriend($_POST['recipe_to_delete']);
    $list_of_my_recipes = getAllMyRecipes();
  }
)
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
<!-- <?php
        include("recipecard.html")
    ?> -->

    <form name="addRecipeForm" action="recipespage.php" method="post">
        <div class="row">
            Author:
            <input type="text" class="form-control" name="author" required/>

        </div>
        <div class="row">
            Title:
            <input type="text" class="form-control" name="title" required/>
            
        </div>
        /*Change so that it is cchoosen from a drop down list */
        <div class="row">
            Category:
            <input type="text" class="form-control" name="category" required/>
            
        </div>
        <div class="row">
           Time:
            <input type="text" class="form-control" name="time" required/>
            
        </div>
        <div class="row">
           Instructions:
            <input type="text" class="form-control" name="instructions" required/>
            
        </div>
        /*change to be able to upload image */
        <div class="row">
            Image
            <input type="text" class="form-control" name="image" required/>
            
        </div>
        /*change to be able to upload image */
        <div class="row">
            Video:
            <input type="text" class="form-control" name="video" required/>
            
        </div>
        <div>
            <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
                title="Insert a recipe" />                          
        </div>  
    </form>

    //the delete button is displayed next to every one of the recipes in my recipe
    <?php foreach ($list_of_my_recipes as $recipes): ?>
    /* Display contents of recipes here */

        <form action = "recipespage.php" method="post">
            <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" />
            <input type="hidden" name="recipe_to_delete" value="<?php echo $recipes['name']?>" />
            
        </form>
    <?php endforeach; ?>

</div>
</div>
</body>

</html>
