<h6>welcome dashbord



  <?php echo $_SESSION['user']; ?>
</h6>
<div id="logout" style="
    display: flex;
    align-content: flex-start;
    justify-content: flex-end" ;>
  <!-- <button >logout</button> -->

  <a href="logout.php" class="btn btn-primary">Logout</a>

</div>
<div class="input-group rounded" style="    max-width: 25%;">
  <input type="search" class="form-control rounded" name="search" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
 
</div>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">id</th>
      <th scope="col">firstname</th>
      <th scope="col">lastname</th>
      <th scope="col">email</th>
      <th scope="col">gender</th>
      <th scope="col">phonenumber</th>
      <th colspan="2">Action</th>
    </tr>
  </thead>
  <tbody> 
  <?php 
  
  if ($paginate->success == true) {
    $fetch_rows = $paginate->resultset->fetchAll();
    $total_rows = count($fetch_rows);

    // print_r('this   '. $total_rows .'coutn');
    // exit;
  }
  
  ?>
    <?php foreach ($fetch_rows as $data): ?>
      <tr>
        <th scope="row"><?php echo $data['id']; ?></th>
        <td><?php echo $data['firstname']; ?></td>
        <td><?php echo $data['lastname']; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['gender']; ?></td>
        <td><?php echo $data['phonenumber']; ?></td>
        <td><a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-info"><i
        class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a></td>
        

        <td><a href="#deleteEmployeeModal" class="delete btn btn-danger" data-toggle="modal" 
        data-id=<?php echo $data['id'];?>><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a></a></td>
      </tr>
    <?php endforeach; ?>

  </tbody>
  <?php if ($total_rows > 0) { ?>
		<tfoot>
			<tr>
				<td colspan="7">
				<?php echo $paginate->links_html; ?>
        
				</td>
			</tr>
		</tfoot>
		<?php } ?>
</table>

<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteForm" action="delete.php" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Delete Company</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
          <!-- Hidden input field to store the ID of the record -->
          <input type="hidden" name="id" id="deleteId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <!-- Delete button within the form -->
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>




<script>
  // Check if there's a success message stored in sessionStorage
  var successMessage = sessionStorage.getItem('successMessage');
  if (successMessage) {
    // Display the success message using Toastr
    toastr.success(successMessage);

    // Clear the stored success message from sessionStorage
    sessionStorage.removeItem('successMessage');
  }
</script>

<script>

$(document).ready(function() {
    $('.delete').click(function() {
        var deleteid = $(this).data('id');
        // Set the value of deleteId input field in the modal
        $('#deleteId').val(deleteid);
        // Show the modal
        $('#deleteEmployeeModal').modal('show');
    });

    // AJAX form submission
    $('#deleteForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var data = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'ajax_delete.php',
            data: data, // Use the serialized form data
            dataType: 'json',
            cache: false,
            success: function(dataResult) {
                if (dataResult && dataResult.statusCode == 200) {
                    sessionStorage.setItem('successMessage', dataResult.message);
                    // Clear form fields
                    window.location.reload();
                } else {
                    $('.error-message').text('');
                    $.each(dataResult, function(fieldName, errorMessage) {
                        var errorElement = $('#' + fieldName + '-error');
                        if (errorElement.length) {
                            errorElement.text(errorMessage);
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                if (xhr.status === 400) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    alert("Bad Request: " + errorMessage[0]);
                } else {
                    toastr.error(error);
                    console.error("An error occurred: ", error);
                }
            }
        });
    });
});
</script>

<script>
  $(document).ready(function(){

    $serachword = $('#search').val();
    console.log($serachword);
  });
</script>