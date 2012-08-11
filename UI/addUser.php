
<!-- this is the from to add new user --> 

<?php
include "chekSession.php"; 
if(!chekSession())
	exit("permission denied");
?>

<!-- script to prevent moving to other page --> 
<script type="text/javascript">
  /* attach a submit handler to the form */
  $("#addUserform").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
	var $form = $( this ),
         term = $form.find( 'input[name="s"]' ).val(),
         url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post( url, $(this).serialize(),
      function( data ) {
       
		  alert("new user created");
         }
    );
  });
</script>

<!-- the form  --> 
<div class="span4">
	<form method="post" id="addUserform"  action="setNewUser.php" class="well">
			userName: <input type="text" name="userName" /><br />
			Password: <input type="password" name="password" /> <br /> 
			<input type="submit" value="Submit" />				
	</form>
</div> 