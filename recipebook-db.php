<? php


//function that gets the recipes of the current logged in user
function getAllMyRecipes()
{
    global $db;
    $query = "SELECT * FROM userSubmittedRecipes WHERE userID = :userID";
    //figure out how to get userID from login
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    
};


//create hidden input. type hidden input for user id and recipe id that will not be displayed on the id. 
//function that will add a recipe 
function addRecipe()
{
    global $db;
    $query = "INSERT INTO recipes VALUES(:userID, :author, :title, :category, :time, :instructions, :image, :video)";
    $queryCount = "SELECT COUNT(*) from recipes";
    
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue($queryCount + 1, $recipeID)
        $statement->bindValue(':author', $author);
        //TODO: figure out how to connect the instructions to the recipeInstructions. Might need to make a separate query to be able to send instructions 
        //and attach the user and recipe id to it?
        


        $statement->bindValue(':title', $title);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':time', $time);
        $statement->bindValue(':instructions', $instructions)
        $statement->bindValue(':image', $image);
        $statement->bindValue(':video', $video);
        
        $statement->execute();
        $statement->closeCursor();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

//function that will delete a selected recipe
//Question: How to I connect through the tables to grab what I need. 
function deleteRecipe()
{
    global $db;
    $query = "DELETE FROM recipes WHERE userID=:userID AND recipeID=:recipeID"
    try{
        $statement = $db->prepary($query);
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
    $query = $db->prepare($query);
    $statement->execute;
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}
?>