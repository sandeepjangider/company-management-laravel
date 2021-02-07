<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::select('id','company_name','company_email','company_address')->get();

        $dataPoints = [];

        foreach($companies as $key=>$value)
        {
            $earning2016 = Employee::where('company_id',$value->id)->sum('earning2016');
            $earning2017 = Employee::where('company_id',$value->id)->sum('earning2017');
            $earning2018 = Employee::where('company_id',$value->id)->sum('earning2018');

            $total_earning = $earning2016 + $earning2017 + $earning2018;

            $dataPoints[] = array('label'=>$value->company_name, 'y'=>(int)$total_earning);
        }

        $dataPoints = json_encode($dataPoints);

        // echo $dataPoints;
        // die;
        
        return view('index', compact('companies','dataPoints'));
    }

    public function store(Request $request)
    {
        $input['company_name'] = $request->input('company_name');
        $input['company_email'] = $request->input('company_email');
        $input['company_address'] = $request->input('company_address');
        $employeeCSV = $request->file('employee_details');

        if($input['company_email'])
        {
            $company = Company::updateOrCreate(['company_email'=>$input['company_email']], $input);

            if($employeeCSV)
            {
                $filePath = $employeeCSV->getRealPath();

                $file = fopen($filePath, 'r');
                
                $headers = fgetcsv($file);

                while ($columns = fgetcsv($file)) {
                    if($columns[1]=="")
                    {
                        continue;
                    }

                    $employee = Employee::select('company_id')->where('email', $columns[1])->first();

                    if(isset($employee->company_id) && $employee->company_id != $company->id)
                    {
                        continue;
                    }
                    
                    $data = array_combine($headers, $columns);
                    $data['company_id'] = $company->id;
                    // dd($data);
                    Employee::updateOrCreate(['company_id'=>$data['company_id'], 'email'=>$data['email']], $data);
                }

                fclose($file);
            }
        }

        // die('ok');
        return redirect()->route('home');
    }

    public function view_report($id) 
    {
        $company = Company::select('company_name','company_email','company_address')->where('id',$id)->firstOrFail();
        $employees = Employee::select('name','email','age','earning2016','earning2017','earning2018')->where('company_id',$id)->get();

        $earning2016 = Employee::where('company_id',$id)->sum('earning2016');
        $earning2017 = Employee::where('company_id',$id)->sum('earning2017');
        $earning2018 = Employee::where('company_id',$id)->sum('earning2018');

        $dataPoints = [];

        $dataPoints[] = array('label'=>"2016", 'y'=>(int)$earning2016);
        $dataPoints[] = array('label'=>"2017", 'y'=>(int)$earning2017);
        $dataPoints[] = array('label'=>"2018", 'y'=>(int)$earning2018);
          
        $dataPoints = json_encode($dataPoints);

        // echo $dataPoints;
        // die;
        
        return view('report', compact('company','employees','dataPoints'));
    }
}
