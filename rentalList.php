<?php 
session_start();
require_once "./header.php";
require_once "./config/config.php";
?>

<?php 
$customer = $conn->query("SELECT * FROM rental_info");
$customer->execute();

$allCustomer = $customer->fetchAll(PDO::FETCH_OBJ);

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
    <div class="row mt-5">
        <div class="col mt-5">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title mb-4 d-inline fw-bold">Rental List</h3>
				<!-- <form action="customerSearch.php" method="GET">
					<input type="text" name="query" placeholder="Search..." />
					<button type="submit">Search</button>
				</form> -->
			  <br>
             	<a  href="rentalInsert.php" class="btn btn-success ms-3 mt-4 p-2 px-4 text-center float-right">Create</a>
              <table class="table table-striped ms-auto">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Matric No</th>
                    <th scope="col">Phone No</th>
                    <th scope="col">Bicycle Id</th>
                    <th scope="col">Damage</th>
                    <th scope="col">Fine</th>
                    <th scope="col">Rental Fee</th>
                    <th scope="col">Rent Start Date</th>
                    <th scope="col">Rent End Date</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>

				<?php $rowNumber = 1; ?>
				<?php foreach($allCustomer as $customer) : ?>
				<tr>
					<th scope="row"><?php echo $rowNumber++; ?></th>
                    <td><?php echo $customer->name; ?></th>
                    <td><?php echo $customer->matric_no; ?></th>
                    <td><?php echo $customer->phoneNo; ?></td>
                    <td><?php echo $customer->bicycle_id; ?></td>
                    <td><?php echo $customer->damage; ?></td>
                    <td><?php echo $customer->fine; ?></td>
                    <td><?php echo $customer->rental_fee; ?></td>
                    <td><?php echo $customer->rental_start_day; ?></td>
                    <td><?php echo $customer->rental_end_day; ?></td>
                    <td><a  href="rentalUpdate.php?id=<?php echo $customer->id; ?>" class="btn btn-warning text-white text-center ">Update </a></td>
                    <td><a href="rentalDelete.php?id=<?php echo $customer->id; ?>" class="btn btn-danger  text-center ">Delete </a></td>
                </tr>
				<?php endforeach; ?>
                </tbody>
            </table> 
          </div>
         </div>
    </div>
</div>

<?php 
require_once "./footer.php";
?>