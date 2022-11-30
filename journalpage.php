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
    require("journal-db.php");

    $list_of_my_entries = getAllMyEntries($_SESSION["id"]);
?>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == 'Add Journal')
        {
            echo "journalDate";
            addJournalEntry($_SESSION['id'], $_POST['journalDate'], $_POST['journalEntry']);
            $list_of_my_entries = getAllMyEntries($_SESSION['id']);
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
    
    <title>Journal</title>

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
<link rel="stylesheet" href="margin.css">
<div>
    <h1> My Journal </h1>
    <p>&nbsp</p>
    <form name="addJournalEntryForm" action="journalpage.php" method="post">
        <div class ="row">
            Date:
            <input type="date" class="form-control" name="journalDate" required/>
        </div>
        <p>&nbsp</p>
        <div class ="row">
            Entry:
            <input type="text" class="form-control" name="journalEntry"/>
        </div>
        <br>
        <div >
            <input type="submit" value="Add Journal" name="btnAction" class="btn btn-dark" 
                title="Insert a journal entry" />
        </div>
    </form>
    <p>&nbsp</p>
    <div class='row'>
        <?php foreach ($list_of_my_entries as $entry_info): ?>
        <!-- /* Display contents of recipes here */ -->
            <div class='col-sm-3'>
                <tr>
                    <!-- I stole the contents of recipecard.php bc I didn't know how  to bring the content from there to here lol
                            if you know how to do that feel free to change this. -->
                    <div class="card" style="width: 18rem;">
                    <!--
                        <img class="card-img-top" src="..." alt="Card image cap">
        -->
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $entry_info['journalDate']?></h5>
                            <text><?php echo $entry_info['journalEntry']?></text>
                        </div>
                    </div>
                </tr>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>