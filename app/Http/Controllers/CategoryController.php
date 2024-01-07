<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        $permissions = Permission::where('name', 'Category')->get();
        foreach ($permissions as $permission) {
            $permission_id = $permission->id;
        }
        $user = Auth::user();
        $user_id = $user->id;
        $categoryPermissions = DB::table('model_has_permissions')->where([
            ['model_id', $user_id],
            ['permission_id', $permission_id]
        ])->get();
        // dd($categoryPermissions);
        $categories = Category::all();
        return view('backend.category.list', compact('categories', 'categoryPermissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'category_code' => ['required', 'string', 'max:6', 'unique:categories'],
            'photo' => 'required|mimes:jpeg,bmp,png,jpg'
        ]);

        if ($validator) {
            $name = $request->name;
            $codeno = $request->category_code;
            $photo = $request->photo;
            // dd($photo);

            //File Uplode

            $imageName = time() . '.' . $photo->extension();
            $photo->move(public_path('images/category'), $imageName);
            $filepath = 'images/category/' . $imageName;

            //Data insert
            $category = new Category;
            $category->name = $name;
            $category->category_code = $codeno;
            $category->photo = $filepath;
            $category->save();

            return redirect()->route('category.index')->with("successMsg", 'New Category is ADDED in your database');
            // successmsg ka session name
        } else {
            return redirect::back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $category = Category::find($id);
        // dd($category);
        $permissions = Permission::where('name', 'Category')->get();
        foreach ($permissions as $permission) {
            $permission_id = $permission->id;
        }
        // dd($permission_id);
        $user = Auth::user();
        $user_id = $user->id;
        $categoryPermissions = DB::table('model_has_permissions')->where([
            ['model_id', $user_id],
            ['permission_id', $permission_id]
        ])->get();
        return view('backend.category.edit', compact('category', 'categoryPermissions')); //data htae pay chin yin compact ko use 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $name = $request->name;
        $category_code = $request->category_code;
        $newphoto = $request->photo;
        $oldphoto = $request->oldPhoto;

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $newphoto->extension();
            $newphoto->move(public_path('images/category'), $imageName);
            $filepath = 'images/category/' . $imageName;
            if (\File::exists(public_path($oldphoto))) {
                \File::delete(public_path($oldphoto));
            }
        } else {
            $filepath = $oldphoto;
        }

        $category = Category::find($id);
        $category->name = $name;
        $category->category_code = $category_code;
        $category->photo = $filepath;
        $category->save();
        return redirect()->route('category.index')->with('successMsg', 'Existing Category is UPDATED in your database');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('category.index')->with('successMsg', 'Existing Category is DELETED in your database');
    }

    public function filter(Request $request)
    {
        if ($request->ajax()) {
            // auth user permissions
            $permissions = Permission::where('name', 'Category')->get();
            foreach ($permissions as $permission) {
                $permission_id = $permission->id;
            }
            $user = Auth::user();
            $user_id = $user->id;
            $categoryPermissions = DB::table('model_has_permissions')->where([
                ['model_id', $user_id],
                ['permission_id', $permission_id]
            ])->get();
            foreach ($categoryPermissions as $categoryPermission) {
                $delete = $categoryPermission->delete;
            }
            // auth user permission end
            // dd($delete);
            $category_name = $request->category_name;
            $category_code = $request->category_code;
            $output = '';
            if ($category_name == null && $category_code == null) {
                // dd("Hello");
                $categories = Category::all();
                $i = 1;
                foreach ($categories as $category) {
                    $output .= '<tr>
                    <td>' . $i++ . '</td>
                    <td><img src="' . asset($category->photo) . '" class="img-fluid" style="width: 170px; object-fit: cover;"></td>
                    <td>' . $category->name . '</td>
                    <td>' . $category->category_code . '</td>
                    <td><a href="' . route("category.edit", $category->id) . '" class="btn btn-warning">
                                            <i class="icofont-ui-settings icofont-1x"></i>
                                        </a>';
                    if ($delete == "yes") {
                        $output .= '<form action="' . route("category.destroy", $category->id) . '" method="POST" class="d-inline-block" onsubmit="return confirm("Are you sure to delete the item?")">';
                        $output .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                        $output .= '<button class="btn btn-outline-danger" type="submit"><i class="icofont-close icofont-1x"></i></button>
                        </form>';
                    }
                    $output .= '</td>
                                    </tr>';
                }
                return Response($output);
            } else {
                // dd("Hii");
                $categories = Category::where('categories.name', 'LIKE', '%' . $category_name . '%')
                    ->where('categories.category_code', 'LIKE', '%' . $category_code . '%')->get();
                $category_data = $categories->count();
                if ($category_data > 0) {
                    $i = 1;
                    foreach ($categories as $category) {
                        $output .=
                            '<tr>
                    <td>' . $i++ . '</td>
                    <td><img src="' . asset($category->photo) . '" class="img-fluid" style="width: 170px; object-fit: cover;"></td>
                    <td>' . $category->name . '</td>
                    <td>' . $category->category_code . '</td>
                    <td><a href="' . route("category.edit", $category->id) . '" class="btn btn-warning">
                                            <i class="icofont-ui-settings icofont-1x"></i>
                                        </a>';
                        if ($delete == "yes") {
                            $output .= '<form action="' . route("category.destroy", $category->id) . '" method="POST" class="d-inline-block" onsubmit="return confirm("Are you sure to delete the item?")">';
                            $output .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                            $output .= '<button class="btn btn-outline-danger" type="submit"><i class="icofont-close icofont-1x"></i></button>
                        </form>';
                        }
                        $output .= '</td>
                                    </tr>';
                    }

                    return Response($output);
                } else {
                    $output = '<tr>
                    <td>No Match Data Found</td>
                    </tr>';
                    return Response($output);
                }
            }
        }
    }
}
