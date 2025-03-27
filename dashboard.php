<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Selection Page</title>

    <!-- Google Charts Loader -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS Styles -->
    <style>
        <style>
        /* General Styles */

        .title {
            background-color: #ad8cac;
            color: white;
            text-align: center;
            padding: 10px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ad8cac;
            padding: 10px 20px;
            color: white;
        }

        .navbar .nav-left,
        .navbar .nav-right {
            display: flex;
            align-items: center;
        }

        .navbar .nav-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .navbar button,
        .navbar a {
            margin: 0 10px;
            padding: 10px 15px;
            background-color: #917a91;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .navbar button:hover,
        .navbar a:hover {
            background-color: #c7abc6;
        }


    </style>


</head>
<body>

    <link rel="stylesheet" href="loanstyle.css">
    <div class="box" id="message-box">
</form>

        <div class="navbar">
        <!-- Left Section -->
        <!-- Center Section -->
        <div class="nav-center">
            <button id="loan-dv-btn">Load Loan Data Visualization</button>
            <button id="medical-dv-btn">Load Medical Costs Data</button>
        </div>

        <!-- Right Section -->
        <div class="nav-right">
            <a id="help-btn" href="https://docs.google.com/document/d/e/2PACX-1vQ1MnIbyhWxgwigc5ghwbR8OPpn8zdNBOTaFJTORcmeGiigV0xpnWeDaIZK_me-jt8gBAYu64K3moUU/pub" target="_blank">Help</a>
            <button id="logout-btn">Logout</button>
        </div>
    </div>
    <div class="title">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    </div>

    </div>
    
    
        <link rel="stylesheet" href="loanstyle.css">

        <!-- LOAN DATA VISUALIZATION SECTION -->
        
        <link rel="stylesheet" href="loanstyle.css">
    <!-- LOAN DATA VISUALIZATION SECTION -->
    <div id="loan-dv" style="display: none;">
        <div class="title">
            <h1>Loan Data Visualization Project</h1>
        </div>
            <p style="text-align: center;">
            <a href="https://docs.google.com/document/d/1KdAouwaKwIRiiET-FJFIYxvnwEJQhxvzAFY_lCkEqvM/edit?usp=sharing" 
            target="_blank" 
            style="color: #1a73e8; text-decoration: none; font-size: 16px;">
            User Manual
            </a>
        </p>
    


   
    <div class="container">
        <!-- Graph Control Section -->
        <div id="graph-control" class="box">
            <h2>Select Graph Type:</h2>
            <button id="grouped-bar-chart-btn">Grouped Bar Chart</button>

            <!-- CHECKBOXES -->
            <div>
            <label for="home-ownership-filter">Filter by Home Ownership:</label>
            <select id="home-ownership-filter">
            <option value="All">All</option>
            <option value="MORTGAGE">MORTGAGE</option>
            <option value="RENT">RENT</option>
            <option value="OWN">OWN</option>
            <option value="OTHER">OTHER</option>
            </select>
            </div>

            <button id="scatter-chart-btn">Scatter Plot</button>

            <!-- SLIDER -->
            <label for="income-range">Income Range:</label>
                <div>
                <input type="range" id="min-income" min="0" max="250000" value="0" step="5000">
                <input type="range" id="max-income" min="0" max="250000" value="250000" step="5000">
                <span id="income-range-label">0 - 250,000</span>
                </div>


        <h2>Data Results Description:</h2>
        <p id="data-description">Select a graph type to see its description and visualization.</p>
         </div>

        <!-- Graph Display Section -->
        <div id="graph-display" class="box">
            <div id="graph-div"></div> <!-- Grouped Bar Chart Placeholder -->
            <div id="scatter-chart-div" style="display: none;"></div> <!-- Scatter Plot Placeholder -->
        </div>

        <!-- Data Display Section -->
        <div id="data-display" class="box">
            <h2>Data Display</h2>
            <table id="data-table">
                <thead>
                    <tr>
                    <th>Age</th>
                    <th>Income</th>
                    <th>Home Ownership</th>
                    <th>Employment Length</th>
                    <th>Loan Intent</th>
                    <th>Loan Grade</th>
                    <th>Loan Amount</th>
                    <th>Interest Rate</th>
                    <th>Loan Status</th>
                </tr>
                </thead>
                <tbody>
                    <!-- Data will be dynamically added here -->
                </tbody>
            </table>
            </div>
        </div>

        <div id="control-buttons">
        <button id="back-btn" disabled>Back</button>
        <button id="next-btn">Next 10</button>
        </div>
        </div>

        <!-- END OF LOAN VISUALIZATION SECTION -->


        <!--MEDICAL COSTS BEGIN -->
        <link rel="stylesheet" href="medstyle.css">
        <div id='medical-dv' style="display: none;">
            
             <div class="title">
        <h1 >Medical Cost Data Visualization</h1>
    </div>
    <link rel="stylesheet" href="medstyle.css">
    <div class="sidebar">
        <h3>Select Attributes</h3>
        <label><input type="checkbox" class="attribute" value="region"> Region</label><br>
        <label><input type="checkbox" class="attribute" value="smoker"> Smoker</label><br>
        <label><input type="checkbox" class="attribute" value="age"> Age</label><br>
        <label><input type="checkbox" class="attribute" value="sex"> Sex</label><br>
        <label><input type="checkbox" class="attribute" value="children"> Number of Children</label><br>
        <label> X Medical Charges (selected)</label><br><br>

        <h3>Select Chart Type</h3>
        <select id="chart-type">
            <option value="BarChart">Bar Chart</option>
            <option value="LineChart">Line Chart</option>
            <option value="PieChart">Pie Chart</option>
        </select>
        <button id="generate-chart">Generate Chart</button>
        <button id="display-dataset">Display Dataset</button>
        <button id="show-user-manual">Show User Manual</button>
    </div>

    <div class="main-content">
        <div class="chart-container" id="chart-container">
            <h3>Chart Section</h3>
            <div id="chart" style="width: 100%; height: 500px;"></div>
        </div>

        <!-- Dataset Container -->
        <div id="dataset-container"></div>

        <!-- User Manual Container -->
        <div id="user-manual-container">
            <h3>User Manual</h3>
            <iframe src="https://docs.google.com/document/d/e/2PACX-1vQpw8VUhHkttovLlPrIQm-XBeu7OLaLBxY18fxPO_kQugo81WB_8J7tBhmxJp-NJpcsHbmak16SJFwZ/pub?embedded=true">
            </iframe>
            <button id="close-user-manual" style="margin-top: 10px;">Close User Manual</button>
        </div>
    </div>

            
        </div>

        <!--END OF MED COSTS -->
    <script>


        document.getElementById("loan-dv-btn").addEventListener("click", function () {
            document.getElementById("loan-dv").style.display = "block";
            document.getElementById("medical-dv").style.display = "none";
            fetchNextData();
        });

        document.getElementById("medical-dv-btn").addEventListener("click", function () {
        // Show medical costs data visualization and hide loan data
        document.getElementById("loan-dv").style.display = "none";
        document.getElementById("medical-dv").style.display = "block";
        fetchMedicalCostsData(); // Load medical costs data when the button is clicked
    });


        //LISTENERS FOR GOOGLE CHARTS

        var offset = 0; 
        var limit = 10; 

        // Load Google Charts
        google.charts.load('current', {packages: ['corechart']});

        google.charts.setOnLoadCallback(function() {
            setupListeners();
            fetchNextData();
        });


        function setupListeners() {
            document.getElementById("next-btn").addEventListener("click", fetchNextData);
            document.getElementById("back-btn").addEventListener("click", fetchPreviousData);

            document.getElementById("scatter-chart-btn").addEventListener("click", function() {
                document.getElementById("graph-div").style.display = "none";
                document.getElementById("scatter-chart-div").style.display = "block";
                fetchScatterPlotData();

        
            document.getElementById("data-description").innerText = "This scatterplot shows that most loan requests come from applicants with incomes under $200,000, with loan amounts typically below $15,000. A few high-income outliers request much larger loans, but there's no clear link between higher income and loan amount requested.";
                    });
                

            document.getElementById("grouped-bar-chart-btn").addEventListener("click", function() {
                document.getElementById("scatter-chart-div").style.display = "none";
                document.getElementById("graph-div").style.display = "block";
                fetchGroupedBarChartData();

       
            document.getElementById("data-description").innerText = "Short (0–5 years), Medium (6–15 years), and Long (over 15 years). The data suggests that a longer credit history is associated with increased loan approvals. Mortgage holders and renters, particularly those with medium and long credit histories, generally experience better approval outcomes.";
        });

            document.querySelectorAll('#min-income, #max-income').forEach(slider => {
                slider.addEventListener('input', function () {
            // Get current slider values
            let minIncome = parseInt(document.getElementById('min-income').value);
            let maxIncome = parseInt(document.getElementById('max-income').value);

            // Validate: Ensure minIncome is not greater than maxIncome
            if (minIncome > maxIncome) {
                minIncome = maxIncome;
                document.getElementById('min-income').value = minIncome; // Sync slider
            }

            // Update income range label
            document.getElementById('income-range-label').innerText = `${minIncome} - ${maxIncome}`;

            // Debugging: Log slider values
            console.log(`Slider updated: Min Income = ${minIncome}, Max Income = ${maxIncome}`);

            // Fetch and update scatter plot
            fetchScatterPlotData(minIncome, maxIncome);
            });
        });

        document.getElementById('home-ownership-filter').addEventListener('change', function() {
        const selectedValue = this.value;

        // Fetch and update the Grouped Bar Chart based on the selected value
        $.ajax({
            url: `fetch_data.php?type=groupbar&home_ownership=${selectedValue}`,
            dataType: 'json',
            success: function(response) {
                console.log('Filtered Grouped Bar Chart Data:', response);
                var data = google.visualization.arrayToDataTable(response);

                var options = {
                    title: `Loan Approval Status by Credit History Length (${selectedValue})`,
                    hAxis: { title: 'Home Ownership' },
                    vAxis: { title: 'Number of Loans' },
                    chartArea: { width: '80%', height: '70%' },
                    bar: { groupWidth: '75%' },
                    legend: { position: 'top' }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('graph-div'));
                chart.draw(data, options);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching filtered Grouped Bar Chart data:', xhr.responseText, status, error);
                }
            });
        });

        }


            function fetchGroupedBarChartData() {
            $.ajax({
                url: 'fetch_data.php?type=groupbar', 
                dataType: 'json',
                success: function(response) {
                    console.log('Grouped Bar Chart Data:', response);
                    var data = google.visualization.arrayToDataTable(response);

                    var options = {
                        title: 'Loan Approval Status by Home Ownership and Credit History Length',
                        hAxis: { title: 'Home Ownership' },
                        vAxis: { title: 'Number of Loans' },
                        chartArea: { width: '80%', height: '70%' },
                        bar: { groupWidth: '75%' },
                        legend: { position: 'top' }
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('graph-div'));
                    chart.draw(data, options);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching grouped bar chart data:', xhr.responseText, status, error);
                }
            });
        }


        function fetchScatterPlotData(minIncome, maxIncome) {
    $.ajax({
        url: `fetch_data.php?type=scatter&min_income=${minIncome}&max_income=${maxIncome}`,
        dataType: 'json',
        success: function (response) {
            // Debugging: Log the response data
            console.log('Scatter Plot Data:', response);

            // Check if data is valid
            if (!response || response.length < 2) {
                console.error('No valid data returned:', response);
                document.getElementById('data-description').innerText = "This scatterplot shows that most loan requests come from applicants with incomes under $200,000, with loan amounts typically below $15,000. A few high-income outliers request much larger loans, but there's no clear link between higher income and loan amount requested.";
                return;
            }

            // Draw the scatter plot
            const data = google.visualization.arrayToDataTable(response);

            const options = {
                title: 'Income vs Loan Amount',
                hAxis: { title: 'Person Income' },
                vAxis: { title: 'Loan Amount' },
                legend: 'none',
                pointSize: 5,
            };

            const chart = new google.visualization.ScatterChart(document.getElementById('scatter-chart-div'));
            chart.draw(data, options);

            // Update description
            document.getElementById('data-description').innerText =
                "Scatterplot updated based on the selected income range.";
        },
        error: function (xhr, status, error) {
            console.error('Error fetching scatter plot data:', xhr.responseText, status, error);
            document.getElementById('data-description').innerText = "Error fetching scatter plot data.";
        }
    });
}


        function fetchNextData() {
            $.ajax({
                url: `fetch_data.php?type=data&offset=${offset}`,
                dataType: 'json',
                success: function (response) {
                    clearTable();
                    appendDataToTable(response);
                    offset += limit;
                    toggleButtons();
                },
                error: function (error) {
                    console.error("Error fetching next data:", error);
                }
            });
        }

        function fetchPreviousData() {
            offset = Math.max(0, offset - limit);
            $.ajax({
                url: `fetch_data.php?type=data&offset=${offset}`,
                dataType: 'json',
                success: function (response) {
                    clearTable();
                    appendDataToTable(response);
                    toggleButtons();
                },
                error: function (error) {
                    console.error("Error fetching previous data:", error);
                }
            });
        }

        function clearTable() {
            document.querySelector("#data-table tbody").innerHTML = "";
        }

        function appendDataToTable(data) {
            const tableBody = document.querySelector("#data-table tbody");
            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.person_age}</td>
                    <td>${row.person_income}</td>
                    <td>${row.person_home_ownership}</td>
                    <td>${row.person_emp_length}</td>
                    <td>${row.loan_intent}</td>
                    <td>${row.loan_grade}</td>
                    <td>${row.loan_amnt}</td>
                    <td>${row.loan_int_rate}</td>
                    <td>${row.loan_status}</td>
                `;
                tableBody.appendChild(tr);
            });
        }

        function toggleButtons() {
            document.getElementById("back-btn").disabled = offset === 0;
        }





        //enter functions for medical 

         let datasetVisible = false; // Tracks whether the dataset is visible

        // Display Dataset
        document.getElementById('display-dataset').addEventListener('click', function () {
            const datasetContainer = document.getElementById('dataset-container');
            if (!datasetVisible) {
                datasetContainer.innerHTML = '<p>Loading dataset...</p>';
                fetch('medcostsdata.php?type=display_dataset')
                    .then(response => response.json())
                    .then(data => {
                        if (!Array.isArray(data)) {
                            datasetContainer.innerHTML = '<p>Error: Invalid data format received.</p>';
                            return;
                        }

                        // Create a table to display the dataset
                        let tableHTML = '<table>';
                        tableHTML += `
                            <tr>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>BMI</th>
                                <th>Children</th>
                                <th>Smoker</th>
                                <th>Region</th>
                                <th>Medical Charges</th>
                            </tr>
                        `;
                        data.forEach(row => {
                            tableHTML += `
                                <tr>
                                    <td>${row.age}</td>
                                    <td>${row.sex}</td>
                                    <td>${parseFloat(row.bmi).toFixed(2)}</td>
                                    <td>${row.children}</td>
                                    <td>${row.smoker}</td>
                                    <td>${row.region}</td>
                                    <td>${parseFloat(row.medical_charges).toFixed(2)}</td>
                                </tr>
                            `;
                        });
                        tableHTML += '</table>';
                        datasetContainer.innerHTML = tableHTML;

                        datasetVisible = true; // Mark dataset as visible
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        datasetContainer.innerHTML = '<p>Error loading dataset.</p>';
                    });
            } else {
                datasetContainer.innerHTML = ''; // Hide the dataset
                datasetVisible = false; // Mark dataset as hidden
            }
        });

        // Load Google Charts library
        google.charts.load('current', { packages: ['corechart'] });

        // Generate Chart
        document.getElementById('generate-chart').addEventListener('click', function () {
            const selectedAttributes = Array.from(document.querySelectorAll('.attribute:checked')).map(attr => attr.value);

            if (selectedAttributes.length === 0) {
                alert('Please select at least one attribute');
                return;
            }

            const chartType = document.getElementById('chart-type').value;

            // Fetch data for the chart
            fetch(`medcostsdata.php?type=generate_chart&attributes=${selectedAttributes.join(',')}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Prepare data for Google Charts
                    const chartData = [['Attribute', 'Average Medical Cost']];
                    data.labels.forEach((label, index) => {
                        chartData.push([label, data.values[index]]);
                    });

                    // Convert data to Google Charts format
                    const googleData = google.visualization.arrayToDataTable(chartData);

                    // Set chart options
                    const options = {
                        title: `Average Medical Charges by ${selectedAttributes.join(', ')}`,
                        hAxis: { title: 'Attributes' },
                        vAxis: { title: 'Average Medical Charges' },
                        legend: { position: 'top' },
                        height: 500,
                        width: '100%'
                    };

                    // Draw the chart
                    const chartContainer = document.getElementById('chart');
                    let chart;
                    if (chartType === 'BarChart') {
                        chart = new google.visualization.BarChart(chartContainer);
                    } else if (chartType === 'LineChart') {
                        chart = new google.visualization.LineChart(chartContainer);
                    } else if (chartType === 'PieChart') {
                        chart = new google.visualization.PieChart(chartContainer);
                    }
                    chart.draw(googleData, options);
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                    alert('An error occurred while generating the chart. Please try again.');
                });
        });

        // Show User Manual
        document.getElementById('show-user-manual').addEventListener('click', function () {
            document.getElementById('user-manual-container').style.display = 'block';
        });

        // Close User Manual
        document.getElementById('close-user-manual').addEventListener('click', function () {
            document.getElementById('user-manual-container').style.display = 'none';
        });

        //LOGOUT FUNCTIONALITY
        document.getElementById("logout-btn").addEventListener("click", function () {
    if (confirm("Are you sure you want to logout?")) {
        fetch('logout.php', {
            method: 'POST',
        })
        .then(() => {
            window.location.href = 'logout.php?message=logged_out';
        })
        .catch(error => {
            console.error('Error during logout:', error);
            alert("An error occurred during logout. Please try again.");
        });
    }
});
S
// On page load, check if the user is already logged in
window.addEventListener("load", function () {
    // Send a request to the server to check session status
    fetch('check_session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.logged_in) {
            // User is logged in; update the UI
            document.getElementById('welcome-message').innerText = `Welcome, ${data.username}!`;
            document.getElementById('login-btn').style.display = 'none';
            document.getElementById('logout-btn').style.display = 'block';
        } else {
            // User is not logged in; redirect to login page
            window.location.href = 'index.html';
        }
    })
    .catch(error => {
        console.error('Error checking session:', error);
        // Redirect to login page on error
        window.location.href = 'index.html';
    });
});



    </script>
</body>
</html>
