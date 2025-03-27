<?php


header('Content-Type: application/json');
include "dbconfig.php";


// Establish a connection to the database
$con = mysqli_connect($hostname, $username, $password, $dbname);

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize the request type input
$type = isset($_GET['type']) ? mysqli_real_escape_string($con, $_GET['type']) : '';

// Initialize the data array
$data = [];

if ($type == 'scatter') {
    
    $min_income = isset($_GET['min_income']) ? (float)$_GET['min_income'] : 0;
    $max_income = isset($_GET['max_income']) ? (float)$_GET['max_income'] : 250000;

    $query ="
        SELECT person_income, loan_amnt
        FROM credit_risk_mini
        WHERE person_income BETWEEN $min_income AND $max_income
        ORDER BY person_income";

    $result = mysqli_query($con, $query);

  
    if (!$result) {
        echo json_encode(['error' => mysqli_error($con)]);
        exit();
    }


    $data[] = ['Person Income', 'Loan Amount'];

  
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            (float)$row['person_income'],  // X-axis (Person Income)
            (float)$row['loan_amnt']       // Y-axis (Loan Amount)
        ];
    }

    echo json_encode($data);
    exit();

} elseif ($type == 'table') {
 
    $query2 = "SELECT * FROM credit_risk_mini LIMIT 10";
    $result2 = mysqli_query($con, $query2);

    // Check if the query was successful
    if (!$result2) {
        echo json_encode(['error' => mysqli_error($con)]);
        exit();
    }

    $data[] = ['person_age', 'person_income', 'person_home_ownership', 'person_emp_length', 'loan_intent', 'loan_grade', 'loan_amnt', 'loan_int_rate', 'loan_status', 
    'loan_percent_income', 'cb_person_default_on_file', 'cb_person_cred_hist_length']; // Table headers


    while ($row = mysqli_fetch_assoc($result2)) {
        $data[] = [
            $row['person_age'], $row['person_income'], $row['person_home_ownership'], $row['person_emp_length'], 
            $row['loan_intent'], $row['loan_grade'], $row['loan_amnt'], $row['loan_int_rate'], 
            $row['loan_status'], $row['loan_percent_income'], $row['cb_person_default_on_file'], 
            $row['cb_person_cred_hist_length']
        ];
    }

    // Send JSON response
    echo json_encode($data);
    exit(); 

} elseif ($type == 'groupbar') {
  
   $home_ownership = isset($_GET['home_ownership']) && $_GET['home_ownership'] !== 'All' 
                      ? mysqli_real_escape_string($con, $_GET['home_ownership']) 
                      : null;

    $query3 = "
        SELECT 
            person_home_ownership,
            SUM(CASE WHEN cb_person_cred_hist_length BETWEEN 0 AND 5 AND loan_status = 1 THEN 1 ELSE 0 END) AS `Short Approved`,
            SUM(CASE WHEN cb_person_cred_hist_length BETWEEN 0 AND 5 AND loan_status = 0 THEN 1 ELSE 0 END) AS `Short Not Approved`,
            SUM(CASE WHEN cb_person_cred_hist_length BETWEEN 6 AND 15 AND loan_status = 1 THEN 1 ELSE 0 END) AS `Medium Approved`,
            SUM(CASE WHEN cb_person_cred_hist_length BETWEEN 6 AND 15 AND loan_status = 0 THEN 1 ELSE 0 END) AS `Medium Not Approved`,
            SUM(CASE WHEN cb_person_cred_hist_length > 15 AND loan_status = 1 THEN 1 ELSE 0 END) AS `Long Approved`,
            SUM(CASE WHEN cb_person_cred_hist_length > 15 AND loan_status = 0 THEN 1 ELSE 0 END) AS `Long Not Approved`
        FROM 
            credit_risk_mini
        " . ($home_ownership ? "WHERE person_home_ownership = '$home_ownership'" : "") . "
        GROUP BY 
            person_home_ownership
        ORDER BY 
            FIELD(person_home_ownership, 'MORTGAGE', 'RENT', 'OWN', 'OTHER');
    ";

    $result3 = mysqli_query($con, $query3);

    // Check if the query was successful and provide an error message if it fails
    if (!$result3) {
        echo json_encode(['error' => 'Query failed: ' . mysqli_error($con)]);
        exit();
    }

    // Set up headers with exactly 7 columns for Google Charts
    $data[] = ['Home Ownership', 'Short Approved', 'Short Not Approved', 'Medium Approved', 'Medium Not Approved', 'Long Approved', 'Long Not Approved'];

    // Fetch each row and add it to the data array, defaulting missing values to 0
    while ($row = mysqli_fetch_assoc($result3)) {
        $data[] = [
            $row['person_home_ownership'],
            (int)($row['Short Approved'] ?? 0),
            (int)($row['Short Not Approved'] ?? 0),
            (int)($row['Medium Approved'] ?? 0),
            (int)($row['Medium Not Approved'] ?? 0),
            (int)($row['Long Approved'] ?? 0),
            (int)($row['Long Not Approved'] ?? 0)
        ];
    }

 
    echo json_encode($data);
    exit();

} elseif ($type == 'data') {
    // Fetch data (10 results at a time) with pagination
    $offset = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;
    $query4 = "SELECT * FROM credit_risk_mini LIMIT 10 OFFSET $offset";
    $result4 = mysqli_query($con, $query4);

    
    if (!$result4) {
        echo json_encode(['error' => mysqli_error($con)]);
        exit();
    }

    $data = []; 

   
    while ($row = mysqli_fetch_assoc($result4)) {
        $data[] = [
            'person_age' => $row['person_age'],
            'person_income' => $row['person_income'],
            'person_home_ownership' => $row['person_home_ownership'],
            'person_emp_length' => $row['person_emp_length'],
            'loan_intent' => $row['loan_intent'],
            'loan_grade' => $row['loan_grade'],
            'loan_amnt' => $row['loan_amnt'],
            'loan_int_rate' => $row['loan_int_rate'],
            'loan_status' => $row['loan_status'],
            'loan_percent_income' => $row['loan_percent_income'],
            'cb_person_default_on_file' => $row['cb_person_default_on_file'],
            'cb_person_cred_hist_length' => $row['cb_person_cred_hist_length']
        ];
    }

    echo json_encode($data);
    exit();

} else {
  
    echo json_encode(['error' => 'Invalid request type']);
    exit();
}

// Close the connection
mysqli_close($con);
?>
