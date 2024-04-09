<?php
session_start();
require_once "./header.php";
require_once "./config/config.php";

// Get the filter parameters (year, month, day)
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';
$day = isset($_GET['day']) ? $_GET['day'] : '';

$stmt = $conn->prepare("SELECT DATE_FORMAT(rental_start_day,'%Y-%m') AS sales_date, COUNT(*) AS number_of_sales,
                        CASE 
                          WHEN e.name IS NOT NULL THEN e.name
                          ELSE a.name
                        END AS employee_name,
                        CASE
                          WHEN r.created_by_employee IS NOT NULL THEN 'Employee'
                          ELSE 'Admin'
                        END AS created_by_role,
                        SUM(rental_fee) AS total_sales
                        FROM rental_info r
                        LEFT JOIN employee e ON r.created_by_employee = e.id
                        LEFT JOIN admin a ON r.created_by_admin = a.id
                        WHERE YEAR(rental_start_day) = :year
                          AND MONTH(rental_start_day) = :month
                        -- AND DAY(rental_start_day) = :day
                        GROUP BY sales_date, employee_name, created_by_role");

$stmt->execute([
  ':year' => $year,
  ':month' => $month,
  // ':day' => $day,
]);

// Fetch the sales data
$salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt->execute([
  ':year' => $year,
  ':month' => $month,
  // ':day' => $day,
]);

// Fetch the sales data
$salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4 d-inline fw-bold">Sales Report</h3>
                    <form action="" method="GET">
                        <div class="mb-3">
                            <label for="year" class="form-label">Year:</label>
                            <input type="text" class="form-control" id="year" name="year" value="<?php echo $year; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Month:</label>
                            <input type="text" class="form-control" id="month" name="month" value="<?php echo $month; ?>">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="day" class="form-label">Day:</label>
                            <input type="text" class="form-control" id="day" name="day" value="<?php echo $day; ?>">
                        </div> -->
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </form>
                    <a href="dailySales.php" class="btn btn-info mt-3">Daily Report</a>

                    <div class="mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Number of Sales</th>
                                    <th>Created By</th>
                                    <th>Role</th>
                                    <th>Total Sales (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($salesData as $data): ?>
                                    <tr>
                                        <td><?php echo $data['sales_date']; ?></td>
                                        <td><?php echo $data['number_of_sales']; ?></td>
                                        <td><?php echo $data['employee_name']; ?></td>
                                        <td><?php echo $data['created_by_role']; ?></td>
                                        <td><?php echo $data['total_sales']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "./footer.php"; ?>
