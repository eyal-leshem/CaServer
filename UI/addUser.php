<?php
include "chekSession.php"; 
if(!chekSession())
	exit("permission denied");
?>

<script>
  /* attach a submit handler to the form */
  $("#impfrom").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        

    /* Send the data using post and put the results in a div */
    $.post( url, $(this).serialize(),
      function( data ) {
       
		  alert("new user created");
         }
    );
  });
</script>

<form method="post" id="addUserform"  action="setNewUser.php" class="well">
		userName: <input type="text" name="userName" /><br />
		Password: <input type="password" name="password" /> <br /> 
		<input type="submit" value="Submit" />				
</form> 