<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Author;
use App\Models\Category;
use App\Models\Client;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Publisher;
use App\Models\Sale;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard() {
        return Inertia::render('Dashboard', [
            'adminCount' => User::where('type', 1)->count(),
            'categoryCount' => Category::count(),
            'authorCount' => Author::count(),
            'publisherCount' => Publisher::count(),
            'productCount' => Product::count(),
            'outletCount' => Outlet::count(),
            'clientCount' => Client::count(),
            'saleCount' => Sale::count(),
            'storageCount' => Storage::count(),
            'accountCount' => Account::count(),
        ]);
    }
}
