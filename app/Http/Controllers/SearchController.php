<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $query = $request->data;
            // dd($query);
            $output = "";
            if ($query != '') {
                $categories = Category::where('name', $query)
                    ->orWhere('category_code', $query)->get();
                $category_data = $categories->count();
                // dd($categories);
                // dd($category_data);
                if ($category_data > 0) {
                    foreach ($categories as $category) {
                        $output .= '<a href="#" class="list-group-item list-group-item-action">' . $category->name . '</a>';
                    }
                    return Response($output);
                } else {
                    // dd("Helo");
                    $output = '<li class="list-group-item">No Match Data Found</li>';
                    return Response($output);
                }
            } else {
                $output = '';
                return Response($output);
            }
        }
    }
}
