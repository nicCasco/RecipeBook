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
    $list_of_favorites = getLikeRecipes($_SESSION['id']);
   
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="author" content="Nicole Casco">
    <meta name="description" content="Homepage that displays all recipe cards that are available from the database"> 
    
    <title>Favorites</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</head>

<div>
    <?php
        include("navbar.html")
    ?>
</div>


<div>
<link rel="stylesheet" href="margin.css">

<div class="row justify-content-center">
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%"><b>Name</b></th>
    <th width="30%"><b>Follow</b></th>
    <th width="30%"><b>Unfollow</b></th> 
    <!-- <th><b>Follow?</b></th> -->
  </tr>
  </thead>
<?php foreach ($list_of_favorites as $favorites_info): ?>
  <tr>
     <td><?php echo $favorites_info["favoriteRecipe"]; ?></td>
     <!-- <td><?php echo $friend_info['major']; ?></td> -->
     <!-- <td><?php echo $friend_info['year']; ?></td> -->
     <!-- <td>
        <form action="favorites.php" method="post">
          <input type="submit" value="Follow" name="btnAction" class="btn btn-primary" 
                title="Click to follow this friend" />
          <input type="hidden" name="friend_to_follow" 
                value="<?php echo $friend_info['id']; ?>"
          />
        </form>
     </td> -->
     <!-- <td>
      <form action="profile.php" method="post">
        <input type="submit" value="Unfollow" name="btnAction" class="btn btn-danger" />
        <input type="hidden" name="friend_to_unfollow" value="<?php echo $friend_info["id"]?>" />
      </form>
     </td> -->
  </tr>
<?php endforeach; ?>
</table>
</div>


</div>
