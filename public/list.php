<?php

require_once '../NoteRestController.php';

$controller = new NoteRestController();


try {
    /* Begin Paging Info */
    $pdo = new PDO("mysql:host=test-mysql;
        db_name=note_db;charset=utf8","root","admin");
    $page = 1;

    if (isset($_GET['page'])) {

        $page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);

    }

    $per_page = 1;

    $sqlcount = "select count(*) as total_records from note_db.note";

    $stmt = $pdo->prepare($sqlcount);

    $stmt->execute();

    $row = $stmt->fetch();

    $total_records = $row['total_records'];

    $total_pages = ceil($total_records / $per_page);

    $offset = ($page - 1) * $per_page;

    /* End Paging Info */
    $sql = "select * from note_db.note limit $offset,$per_page";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo "<table border='1' align='center'>";

    while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<tr>";
        if (!empty($row['company']))
        echo "<td>" . $row['company'] . "</td>";
        echo "<td>" . $row['full_name'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        if (!empty($row['birth_date']))
        echo "<td>" . $row['birth_date'] ?? '' . "</td>";
        if (!empty($row['photo']))
        echo "<td>" . $row['photo']. "</td>";
        echo "</tr>";
    }
    echo "</table>";
    /* Begin Navigation */

    echo "<table border='1' align='center'>";

    echo "<tr>";

    if ($page - 1 >= 1) {

        echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . ">Previous</a></td>";

    }

    if ($page + 1 <= $total_pages) {

        echo "<td><a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . ">Next</a></td>";

    }

    echo "</tr>";

    echo "</table>";

    /* End Navigation */
} catch (PDOException $e) {
    echo $e->getMessage();
}




