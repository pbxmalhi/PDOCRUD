<?php
$servername = "localhost";
$username = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=myDB", $username);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    if ((isset($_REQUEST['name']) && (isset($_REQUEST['marks'])))) {
        $name = $_REQUEST['name'];
        $marks = $_REQUEST['marks'];
        $sql = "INSERT INTO details(firstname, marks) VALUES('$name', $marks)";
        $conn->exec($sql);
        echo "Row Inserted Successfully.....";
    }

    // Display Data
    else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = $conn->prepare("select * from details where id=$id");
        $data->execute();
        $row = $data->fetchAll();
?>
        <table border="1" width="30%">
            <tr>
                <th>Name</th>
                <th>Marks</th>
            </tr>
            <?php
            foreach ($row as $val) {
            ?>
                <tr>
                    <td><?php echo $val["firstname"] ?></td>
                    <td><?php echo $val["marks"] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }

    // Deleting Data
    else if (isset($_GET['did'])) {
        $did = $_GET['did'];
        $data = $conn->prepare("delete from details where id=$did");
        $data->execute();
    }

    // Editing data 
    else if (isset($_GET['eid'])) {
        $eid = $_GET['eid'];
        $name = $_GET['uname'];
        $marks = $_GET['umarks'];
        $data = $conn->prepare("update details set firstname='$name', marks=$marks where id=$eid");
        $data->execute();
    } else {
        $data = $conn->prepare("select * from details");
        $data->execute();
        $row = $data->fetchAll();
    ?>
        <table border="1" width="30%">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Marks</th>
            </tr>
            <?php
            foreach ($row as $val) {
            ?>
                <tr>
                    <td><?php echo $val["id"] ?></td>
                    <td><?php echo $val["firstname"] ?></td>
                    <td><?php echo $val["marks"] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
<?php
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
