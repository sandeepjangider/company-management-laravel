<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Management</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>
<body>
    <div class="container">
        <h1>Company Management</h1>
        <div class="col-md-6">
            <form action="{{route('store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="company_name">Company Name</label>
                <input class="form-control" type="text" name="company_name" required>

                <label for="company_email">Company Email</label>
                <input class="form-control" type="email" name="company_email" required>

                <label for="company_address">Company Address</label>
                <textarea class="form-control" name="company_address" required></textarea>

                <label for="employee_details">Employee Details (CSV file)</label>
                <input class="form-control" type="file" name="employee_details" required accept=".csv">

                <button class="btn btn-success">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        </div>

        <div class="col-lg-12">
            <table class="table table-striped">
                <tr>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Company Address</th>
                    <th>Action</th>
                </tr>    
                @foreach($companies as $key=>$value)
                <tr>
                    <td>{{$value->company_name}}</td>
                    <td>{{$value->company_email}}</td>
                    <td>{{$value->company_address}}</td>
                    <td><a href="{{route('view_report', $value->id)}}">View report</a></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <script src="{{asset('assets/js/canvasjs.min.js')}}"></script>
    <script type="text/javascript">
        window.onload = function () {

        var dataPoints = <?php echo $dataPoints; ?>;

        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light1", // "light2", "dark1", "dark2"
            animationEnabled: false, // change to true		
            title:{
                text: "Companies Total Earning"
            },
            data: [
            {
                // Change type to "bar", "area", "spline", "pie",etc.
                type: "column",
                dataPoints: dataPoints
            }
            ]
        });
        chart.render();

        }
    </script>

</body>
</html>