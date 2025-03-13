<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>

<?php 
    $data = Response::getData();
?>
<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                Books
                <h1><?=$data->bookCount->count?></h1>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                Genres
                <h1><?=$data->genreCount->count?></h1>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                Arrangements
                <h1><?=$data->arrangementCount->count?></h1>
            </div>
            
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                Unassigned Books
                <h1><?=$data->unassignedBooks->count?></h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-pie me-1"></i>
                Genres with most Books
            </div>
            <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
        </div>
    </div>
    <!-- <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                Bar Chart Example
            </div>
            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
        </div>
    </div> -->
</div>
                    
<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>

<script>
    // Ensure PHP data is properly passed to JavaScript
    var topGenreData = <?= json_encode($data->topGenreData) ?>;

    // Extract labels and values from the PHP array
    var labels = topGenreData.map(item => item.genre);
    var dataValues = topGenreData.map(item => item.count);

    // Define colors dynamically (extendable)
    var backgroundColors = [
        '#007bff', '#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d'
    ];

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: backgroundColors.slice(0, labels.length) // Adjust colors dynamically
            }]
        }
    });
</script>
