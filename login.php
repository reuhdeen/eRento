<?php 
include 'db.php';
?>
<!doctype html>
<html>
 <head>
  <!-- CSS -->
  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <!-- Script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
 </head>
 <body >
  <div class="container" >
   <!-- Modal -->
   <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
 
     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">User Info</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
 
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
   </div>

   <br/>
   <table class='table' border='1' style='border-collapse: collapse;'>
    <tr>
     <th>Name</th>
     <th>Email</th>
     <th>&nbsp;</th>
    </tr>
   <?php 
   $query = "select * from erento.room";
   $result = mysqli_query($db,$query);
   while($row = mysqli_fetch_array($result)){
     $id = $row['room_id'];
     $name = $row['room_name'];
     $email = $row['capacity'];

     echo "<tr>";
     echo "<td>".$name."</td>";
     echo "<td>".$email."</td>";
     echo "<td><button data-id='".$id."' class='userinfo'>Info</button></td>";
     echo "</tr>";
   }
   ?>
   </table>
 
  </div>
  <script type="text/javascript">
      
         $(document).ready(function(){

               $('.userinfo').click(function(){
               
                   var userid = $(this).data('id');

                   // AJAX request
                   $.ajax({
                       url: 'ajaxfile.php',
                       type: 'post',
                       data: {userid: userid},
                       success: function(response){ 
                           // Add response in Modal body
                           $('.modal-body').html(response);

                           // Display Modal
                           $('#empModal').modal('show'); 
                       }
                   });
               });
            });
  </script>
 </body>
</html>