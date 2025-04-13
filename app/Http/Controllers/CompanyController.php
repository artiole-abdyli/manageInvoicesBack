<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function register(Request $request)
    {
        $this->companyService->registerCompany($request);

       return response()->json('company registered successfully');
    }
}


