<?php

include "dbconfig.php";

// Connect to the database
$conn = new mysqli($hostname, $username, $password, '2024F_mozruizd');

// Check for connection errors
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the request type and attributes
$type = $_GET['type'] ?? '';
$attributes = isset($_GET['attributes']) ? explode(',', $_GET['attributes']) : [];

// Handle the "generate_chart" type
if ($type === 'generate_chart') {
    if (empty($attributes)) {
        echo json_encode(['error' => 'No attributes provided for grouping.']);
        $conn->close();
        exit();
    }

    // Sanitize and prepare the SELECT and GROUP BY columns
    $selectColumns = [];
    $groupByColumns = [];

    foreach ($attributes as $attr) {
        $sanitizedAttr = $conn->real_escape_string($attr);
        $selectColumns[] = "`$sanitizedAttr`";
        $groupByColumns[] = "`$sanitizedAttr`";
    }

    // Construct the SQL query
    $columns = implode(', ', $selectColumns);
    $groupBy = implode(', ', $groupByColumns);
    $query = "
        SELECT $columns, AVG(medical_charges) AS avg_charges
        FROM med_cost
        GROUP BY $groupBy
    ";

    // Execute the query
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(['error' => 'Error executing query: ' . $conn->error]);
        $conn->close();
        exit();
    }

    // Prepare the data for the chart
    $data = ['labels' => [], 'values' => []];
    while ($row = $result->fetch_assoc()) {
        $labelParts = [];
        foreach ($attributes as $attr) {
            $labelParts[] = $row[$attr] ?? 'N/A';
        }
        $data['labels'][] = implode(', ', $labelParts);
        $data['values'][] = (float)$row['avg_charges'];
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();
    exit();
}

// Handle the "display_dataset" type
if ($type === 'display_dataset') {
    $query = "SELECT * FROM med_cost";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(['error' => 'Error executing query: ' . $conn->error]);
        $conn->close();
        exit();
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    $conn->close();
    exit();
}

// Handle invalid request types
echo json_encode(['error' => 'Invalid request type.']);
$conn->close();
?>