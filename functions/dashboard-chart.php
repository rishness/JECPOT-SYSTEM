<?php
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Get the data from the database
$sql = "SELECT year(created) as year, month(created) as month, day(created) as day, sum(discounted_sales) as total_sales FROM transaction GROUP BY year(created), month(created), day(created) ORDER BY year(created), month(created), day(created);";
$stmt = $db->prepare($sql);
$stmt->execute();

// Create the chart data
$labels = [];
$data = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // Format the label as Month/Day/Year
  $formattedDate = date("M/d/Y", mktime(0, 0, 0, $row['month'], $row['day'], $row['year']));
  $labels[] = $formattedDate;
  $data[] = $row['total_sales'];
}
$chartData = [
  'labels' => $labels,
  'datasets' => [
    [
      'label' => 'Earnings',
      'fill' => true,
      'data' => $data,
      'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
      'borderColor' => 'rgba(78, 115, 223, 1)',
      'borderWidth' => 2
    ]
  ]
];

// Encode the chart data as JSON
$chartDataJson = json_encode($chartData);
?>

<!-- Render the chart -->
<canvas id="myChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Wait for the DOM to be ready before rendering the chart
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myChart').getContext('2d');

    // Chart.js configuration
    var myChart = new Chart(ctx, {
        type: 'line',
        data: <?php echo $chartDataJson; ?>,
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false,
                labels: {
                    fontStyle: 'normal'
                }
            },
            title: {
                fontStyle: 'normal'
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgb(234, 236, 244)',
                        zeroLineColor: 'rgb(234, 236, 244)',
                        drawBorder: false,
                        drawTicks: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                        drawOnChartArea: true
                    },
                    ticks: {
                        fontColor: '#858796',
                        fontStyle: 'normal',
                        padding: 5,  // Reduced padding to bring the ticks closer
                        autoSkip: false,  // Disable auto skip to show all the dates
                        maxTicksLimit: 30,  // Limit the number of ticks on the x-axis
                        minRotation: 45  // Rotate the labels to make them fit better
                    }
                },
                y: {
                    grid: {
                        color: 'rgb(234, 236, 244)',
                        zeroLineColor: 'rgb(234, 236, 244)',
                        drawBorder: false,
                        drawTicks: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    },
                    ticks: {
                        fontColor: '#858796',
                        fontStyle: 'normal',
                        padding: 20,
                        beginAtZero: true
                    }
                }
            }
        }
    });
});
</script>
