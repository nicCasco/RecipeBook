<?php
function getAllMyEntries($userID)
{
    global $db;
    $query = "SELECT * FROM journals WHERE userID=:userID";
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

function addJournalEntry($userID, $date, $entry)
{
    global $db;
    $queryJournal = "SELECT COUNT(*) FROM journals WHERE userID=:userID";
    $queryJournal = $db->prepare($queryJournal);
    $queryJournal->bindValue(':userID', $userID);
    $queryJournal->execute();
    $retJournalID = $queryJournal->fetch();
    $id = $retJournalID[0]+1;

    $query = "INSERT INTO journals VALUES(:userID, :journalID, :journalDate, :journalEntry)";

    try
    {
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':journalID', $id);
        $statement->bindValue(':journalDate', $date);
        $statement->bindValue(':journalEntry', $entry);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}
?>