<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Report</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>
<body>
    <div class="container">
        <span><a href="{{route('home')}}">Back to home</a></span>
        <h1>Company Report</h1>
        <div class="col-md-6">
            <table class="table">
                <tr>
                    <td>Company Name</td>
                    <td>{{$company->company_name}}</td>
                </tr>
                <tr>
                    <td>Company Email</td>
                    <td>{{$company->company_email}}</td>
                </tr>
                <tr>
                    <td>Company Address</td>
                    <td>{{$company->company_address}}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        </div>

        <div class="col-lg-12">
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Earning 2016</th>
                    <th>Earning 2017</th>
                    <th>Earning 2018</th>
                </tr>    
                @foreach($employees as $key=>$value)
                <tr>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->age}}</td>
                    <td>{{'$'.$value->earning2016}}</td>
                    <td>{{'$'.$value->earning2017}}</td>
                    <td>{{'$'.$value->earning2018}}</td>
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
                text: "Company Yearly Earning"
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