<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Contributor;
use App\Models\Category;
use App\Models\Distribution;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Publisher;
use App\Models\Sale;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'adminCount' => User::where('type', 1)->count(),
            'categoryCount' => Category::count(),
            'ContributorCount' => Contributor::count(),
            'publisherCount' => Publisher::count(),
            'productCount' => Product::count(),
            'outletCount' => Outlet::count(),
            'distributorCount' => Distribution::count(),
            'saleCount' => Sale::count(),
            'storageCount' => Storage::count(),
            'accountCount' => Account::count(),
        ]);
    }
}
