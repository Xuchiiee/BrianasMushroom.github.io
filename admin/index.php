<?php
include("../includes/config.php");
session_start();

if (isset($_SESSION['admin_login'])) {
    if ($_SESSION['admin_login'] == true) {
        //select last 5 retailers
        $query_selectRetailer = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id ORDER BY retailer_id DESC LIMIT 5";
        $result_selectRetailer = mysqli_query($con, $query_selectRetailer);

        //select last 5 manufacturers
        $query_selectManufacturer = "SELECT * FROM manufacturer ORDER BY man_id DESC LIMIT 5";
        $result_selectManufacturer = mysqli_query($con, $query_selectManufacturer);

        //select last 5 distributors
        $query_selectDistributor = "SELECT * FROM distributor,area WHERE distributor.dist_email=area.area_id ORDER BY dist_id DESC LIMIT 5";
        $result_selectDistributor = mysqli_query($con, $query_selectDistributor);
    } else {
        header('Location:../index.php');
    }
} else {
    header('Location:../index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    
    <title> Admin: Home </title>
    <link rel="stylesheet" href="../includes/main_style.css">
</head>

<body>

    <?php
    include("../includes/header.inc.php");
    include("../includes/nav_admin.inc.php");
    include("../includes/aside_admin.inc.php");
    ?>

    <section>
        <h1>Welcome Admin</h1>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="" method="GET">
                <input type="text" name="search" class="search-box" placeholder="Name/Email/Username">
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>

        <article>
            <h2> Retailers</h2>
            <table class="table_displayData">
                <tr>
                    <th>Sr. No.</th>
                    <th>Username</th>
                    <th>Area Code</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
                <?php
                $i = 1;
                // Modify query based on search input
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $searchQuery = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id";

                if (!empty($search)) {
                    $searchQuery .= " AND (retailer.username LIKE '%$search%' OR retailer.email LIKE '%$search%' OR retailer.username LIKE '%$search%')";
                }

                $searchQuery .= " ORDER BY retailer_id DESC LIMIT 5";

                $result_selectRetailer = mysqli_query($con, $searchQuery);

                while ($row_selectRetailer = mysqli_fetch_array($result_selectRetailer)) {
                ?>
                    <tr>
                        <td> <?php echo $i; ?> </td>
                        <td> <?php echo $row_selectRetailer['username']; ?> </td>
                        <td> <?php echo $row_selectRetailer['area_code']; ?> </td>
                        <td> <?php echo $row_selectRetailer['phone']; ?> </td>
                        <td> <?php echo $row_selectRetailer['email']; ?> </td>
                        <td> <?php echo $row_selectRetailer['address']; ?> </td>
                    </tr>
                <?php $i++;
                } ?>
            </table>
        </article>

        <article>
            <h2> Manufacturers</h2>
            <table class="table_displayData">
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Username</th>
                </tr>
                <?php
                $i = 1;
                // Modify query based on search input
                $searchQuery = "SELECT * FROM manufacturer";

                if (!empty($search)) {
                    $searchQuery .= " WHERE man_name LIKE '%$search%' OR man_email LIKE '%$search%' OR manufacturer.man_name LIKE '%$search%'";
                }

                $searchQuery .= " ORDER BY man_id DESC LIMIT 5";

                $result_selectManufacturer = mysqli_query($con, $searchQuery);

                while ($row_selectManufacturer = mysqli_fetch_array($result_selectManufacturer)) {
                ?>
                    <tr>
                        <td> <?php echo $i; ?> </td>
                        <td> <?php echo $row_selectManufacturer['man_name']; ?> </td>
                        <td> <?php echo $row_selectManufacturer['man_email']; ?> </td>
                        <td> <?php echo $row_selectManufacturer['man_phone']; ?> </td>
                        <td> <?php echo $row_selectManufacturer['username']; ?> </td>
                    </tr>
                <?php $i++;
                } ?>
            </table>
        </article>

        <article>
            <h2> Distributors</h2>
            <table class="table_displayData">
                <tr>
                    <th>Sr. No.</th>
                    <th>Username</th>
                    <th>Area Code</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
                <?php
                $i = 1;
                // Modify query based on search input
                $searchQuery = "SELECT * FROM distributor,area WHERE distributor.dist_id=area.area_id";

                if (!empty($search)) {
                    $searchQuery .= " AND (distributor.dist_name LIKE '%$search%' OR distributor.dist_email LIKE '%$search%' OR distributor.dist_name LIKE '%$search%')";
                }

                $searchQuery .= " ORDER BY dist_id DESC LIMIT 5";

                $result_selectDistributor = mysqli_query($con, $searchQuery);

                while ($row_selectDistributor = mysqli_fetch_array($result_selectDistributor)) {
                ?>
                    <tr>
                        <td> <?php echo $i; ?> </td>
                        <td> <?php echo $row_selectDistributor['dist_name']; ?> </td>
                        <td> <?php echo $row_selectDistributor['area_code']; ?> </td>
                        <td> <?php echo $row_selectDistributor['dist_phone']; ?> </td>
                        <td> <?php echo $row_selectDistributor['dist_email']; ?> </td>
                        <td> <?php echo $row_selectDistributor['dist_address']; ?> </td>
                    </tr>
                <?php $i++;
                } ?>
            </table>
        </article>
    </section>

    <?php
    include("../includes/footer.inc.php");
    ?>
</body>

</html>
