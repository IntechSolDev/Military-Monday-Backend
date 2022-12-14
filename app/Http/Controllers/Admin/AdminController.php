<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{


    public function index()
    {
      $users = User::latest()->get();
      $user_count = User::count();
      $products = Product::count();
      $sellers = User::where('type','seller')->count();
      $buyers = User::where('type','buyer')->count();
      return view('admin/pages/index',['users'=>$users,'user_count'=>$user_count,'products'=>$products,'buyers'=>$buyers,'sellers'=>$sellers]);
    }


}

