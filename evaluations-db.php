<?php
function getSubmittedEvals($userID)
{
    global $db;
    $query = "SELECT * FROM userSubmittedEvals WHERE userID=:userID";
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
    
}

function getRecipes($recipeID){
    global $db;
    $query = "SELECT title FROM recipes WHERE recipeID=:recipeID";
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

function getEvalRating($recipeID)
{
    global $db;
    $query = "SELECT AVG(rating) FROM evaluations WHERE recipeID=:recipeID";
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    
}


function getEvalDifficulty($recipeID)
{
    global $db;
    $query = "SELECT AVG(difficulty) FROM evaluations WHERE recipeID=:recipeID";
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    
}

function getMyEvalRating($recipeID)
{
    global $db;
    $query = "SELECT AVG(rating) FROM evaluations WHERE recipeID=:recipeID";
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    
}


function getMyEvalDifficulty($recipeID)
{
    global $db;
    $query = "SELECT AVG(difficulty) FROM evaluations WHERE recipeID=:recipeID";
    try{
        $statement=$db->prepare($query);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    
}

function addEval($userID, $recipeID, $rating, $difficulty)
{
    global $db;
    $query = "INSERT INTO recipes VALUES(:userID, :recipeID, :evalID, :rating, :difficulty)";
    
    $queryCount = "SELECT MAX(evalID) from evaluations";
    $queryCount = $db->prepare($queryCount);
    $queryCount->execute();
    $returnQueryCount = $queryCount->fetch();
    $count = $returnQueryCount[0] + 1;
    try{
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':recipeID', $recipeID);
        $statement->bindValue('evalID', $count);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':difficulty', $difficulty);    
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
}


?>

