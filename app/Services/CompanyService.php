<?php
namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyService
{
    protected $company;
    protected $user;

    public function __construct( Company $company)
    {
        $this->company = $company;
    }

public function registerCompany(Request $request){
    $user=new User();
    $user->name=$request->input('name');
    $user->email=$request->input(key: 'email');
    $user->password=$request->input('password');
    

    $user->save();
    $company=new Company();
    $company->company_name=$request->input("company_name");
    $company->max_number_of_employees=$request->input("max_number_of_employees");
    $company->save();
    return response()->json('company is created successfully');
}
}
?>