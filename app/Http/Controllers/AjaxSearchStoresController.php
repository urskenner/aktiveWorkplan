<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class AjaxSearchStoresController extends Controller
{

//    function getStoreEmp($characters)
//    {
//        $store = DB::table('retail_store')
//            ->select('retail_store.*')
//            ->join('company', 'company.id', '=', 'retail_store.company_id')
//            ->where('company.admin_id', Auth::user()->id)
//            ->where('retail_store.name', 'like', '%' . $characters . '%')
//            ->get();
//
//        $emp = DB::table('employees as e')
//            ->select('e.name as surname', 'e.forename', 'e.retail_store_id')
//            ->join('retail_store', 'e.retail_store_id', '=', 'retail_store.id')
//            ->join('company', 'company.id', '=', 'retail_store.company_id')
//            ->where('company.admin_id', Auth::user()->id)
//            ->where('employees.name', 'like', '%' . $characters . '%')
//            ->get();
//
//        return response()->json(["store" => $store, "emp" => $emp]);
//    }

}
