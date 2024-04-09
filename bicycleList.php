<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 
$bicycle = $conn->query("SELECT * FROM bicycle");
$bicycle->execute();

$allBicycles = $bicycle->fetchAll(PDO::FETCH_OBJ);

// for updating echo
if (isset($_SESSION['success_update_message'])) {
  echo "<script>alert('{$_SESSION['success_update_message']}');</script>";
  unset($_SESSION['success_update_message']);
}

if (isset($_SESSION['error_update_message'])) {
  echo "<script>alert('{$_SESSION['error_update_message']}');</script>";
  unset($_SESSION['error_update_message']);
}

// for inserting echo
if (isset($_SESSION['success_insert_message'])) {
  echo "<script>alert('{$_SESSION['success_insert_message']}');</script>";
  unset($_SESSION['success_insert_message']);
}

if (isset($_SESSION['error_insert_message'])) {
  echo "<script>alert('{$_SESSION['error_insert_message']}');</script>";
  unset($_SESSION['error_insert_message']);
}

// for deleting echo
if (isset($_SESSION['success_delete_message'])) {
  echo "<script>alert('{$_SESSION['success_delete_message']}');</script>";
  unset($_SESSION['success_delete_message']);
}

if (isset($_SESSION['error_delete_message'])) {
  echo "<script>alert('{$_SESSION['error_delete_message']}');</script>";
  unset($_SESSION['error_delete_message']);
}

?>

<div class="container-fluid">
    <div class="row mt-5 mb-5">
        <div class="col mt-5">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title mb-4 d-inline fw-bold">Bicycle List</h3>
							<!-- <form action="bicycleSearch.php" method="POST">
								<input type="text" name="query" placeholder="Search..." />
								<button type="submit">Search</button>
							</form> -->
			  <br>
             	<a  href="bicycleInsert.php" class="btn btn-success ms-3 mt-4 p-2 px-4 text-center float-right">Create</a>
              <table class="table table-striped ms-auto">
                <thead>
                  <tr>
                    <th scope="col" class="fw-bold">#</th>
                    <th scope="col" class="fw-bold">id</th>
                    <th scope="col" class="fw-bold">Type</th>
                    <th scope="col" class="fw-bold">Status</th>
                    <th scope="col" class="fw-bold">Price</th>
                    <th scope="col" class="fw-bold">Update</th>
                    <th scope="col" class="fw-bold">Delete</th>
                  </tr>
                </thead>
                <tbody>
                <?php if (empty($allBicycles)): ?>
                <tr>
                  <td colspan="7">No data found.</td>
                </tr>
              <?php else: ?>
								<?php $rowNumber = 1; ?>
								<?php foreach($allBicycles as $bicycle) : ?>
										<tr>
										<th scope="row"><?php echo $rowNumber++; ?></th>
                    <td><?php echo $bicycle->id; ?></th>
                    <td><?php echo $bicycle->type; ?></td>
                    <td><?php echo $bicycle->status; ?></td>
                    <td><?php echo $bicycle->price; ?></td>
                    <td><a  href="bicycleUpdate.php?id=<?php echo $bicycle->id; ?>" class="btn btn-warning text-white text-center ">Update </a></td>
                    <td><a href="bicycleDelete.php?id=<?php echo $bicycle->id; ?>" class="btn btn-danger  text-center ">Delete </a></td>
                  </tr>
								<?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table> 
          </div>
         </div>
    </div>
</div>

<?php 
require_once "./footer.php";
?>