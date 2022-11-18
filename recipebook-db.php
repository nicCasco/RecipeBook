<?php
//TODO: pass values to functions

//function that gets the recipes of the current logged in user
function getAllMyRecipes($userID)
{
    global $db;
    $query = "SELECT * FROM userSubmittedRecipes WHERE userID=:userID";
    //figure out how to get userID from login
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    
};

function updateRecipe($userID, $recipeID, $author, $title, $category, $time) {

	global $db;
	$query = "UPDATE recipes SET author=:author, title=:title, category=:category, time=:time WHERE userID=:userID AND recipeID=:recipeID";
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':time', $time);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }

    // global $db;

    // foreach ( $ingredientsList as $ingredient):
    //     $queryIngredients = "UPDATE recipeIngredients SET ingredients=$ingredient WHERE userID=:userID AND recipeID=:recipID";
    //     try{
    //         $statement = $db->prepare($queryInsgredients);
    //         $statement->bindValue(':userID', $userID);
    //         $statement->bindValue(':recipeID', $recipeID);
    //         $statement->bindValue($ingredient, $ingredients);
    //         $statement->execute();
    //         $statement->closeCursor();
    //     }
    //     catch (Exception $e)
    //     {
    //         echo $e->getMessage();
    //     }
    // endforeach;
}

function getRecipeForUpdate($userID, $recipeID)
{
    global $db;
    $query = "SELECT * FROM recipes WHERE userID = :userID AND recipeID = :recipeID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':recipeID', $recipeID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function getRecipeInstructionsForUpdate($userID, $recipeID)
{
    global $db;
    $query = "SELECT * FROM recipeInstructions WHERE userID = :userID AND recipeID = :recipeID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':recipeID', $recipeID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

// //create hidden input. type hidden input for user id and recipe id that will not be displayed on the id. 
// //function that will add a recipe 
function addRecipe($userID, $author, $title, $category, $time, $instructions)
{
    global $db;
    $query = "INSERT INTO recipes VALUES(:userID, :recipeID, :author, :title, :category, :time, :image, :video)";
    
    $queryCount = "SELECT MAX(recipeID) from recipes";
    $queryCount = $db->prepare($queryCount);
    $queryCount->execute();
    $returnQueryCount = $queryCount->fetch();
    $count = $returnQueryCount[0] + 1;
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue('recipeID', $count);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':time', $time);
        $statement->bindValue(':image', null);
        $statement->bindValue(':video', null);     
        $statement->execute();
        $statement->closeCursor();
        if ($statement->rowCount() == 0){
            echo "Failed to add a friend <br/>";
        }
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
   
//    foreach ( $instructionsList as $ingredient):
//         $addIngredients = "INSERT INTO recipeIngredients VALUES ( :userID, :recipeID, :ingredients)";
//         try{
//             $statement = $db->prepare($addIngredients);
//             $statement->bindValue(':userID', $userID);
//             $statement->bindValue($count, $recipeID);
//             $statement->bindValue($ingredient, $ingredients);
//         }
//         catch (Exception $e)
//         {
//             echo $e->getMessage();
//         }
//     endforeach;
        $addInstructions = "INSERT INTO recipeInstructions VALUES ( :userID, :recipeID, :instructions)";
        try{
            $statement = $db->prepare($addInstructions);
            $statement->bindValue(':userID', $userID);
            $statement->bindValue(':recipeID', $count);
            $statement->bindValue(':instructions', $instructions);
            $statement->execute();
            $statement->closeCursor();
        }
    

        catch (Exception $e)
        {
            echo $e->getMessage();
        }

    $userSubmitted = "INSERT INTO userSubmittedRecipes VALUES (:userID, :submittedRecipe, :recipeID)";
    try{
        $statement = $db->prepare($userSubmitted);
        $statement -> bindValue(':userID', $userID);
        $statement -> bindValue(':submittedRecipe', $title);
        $statement -> bindValue(':recipeID', $count);
        $statement -> execute();
        $statement -> closeCursor();
    }     
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

// //function that will delete a selected recipe
// //Question: How to I connect through the tables to grab what I need. 
function deleteRecipe($userID, $recipeID)
{
    global $db;

    $query1 = "DELETE FROM recipeIngredients WHERE userID=:userID AND recipeID=:recipeID";
    $query2 = "DELETE FROM recipeInstructions WHERE userID=:userID AND recipeID=:recipeID";
    $query3 = "DELETE FROM recipes WHERE userID=:userID AND recipeID=:recipeID";
    $query4 = "DELETE FROM userSubmittedRecipes WHERE userID=:userID AND recipeID=:recipeID";

    try{
        $statement = $db->prepare($query1);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $statement->closeCursor();

        $statement = $db->prepare($query2);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $statement->closeCursor();

        $statement = $db->prepare($query3);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $statement->closeCursor();

        $statement = $db->prepare($query4);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $statement->closeCursor();
    } 
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

//function to get all the info for homepage recipe cards
function getAllRecipes()
{

    global $db;
    $query = "SELECT * FROM recipes";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}
?>