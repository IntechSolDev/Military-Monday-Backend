<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                   ->addColumn('online', function ($row) {
                    if ($row->isOnline())
                          $online = "<span class='badge badge-success'>Online</span>";
                            else
                          $online= "<span class='badge badge-danger'>Offline</span>";

                    return $online;
                })
                ->addColumn('image', function ($row) {
                    if ($row->image)
                        $image = '<img width="30%" src="' . $row->image . '" />';
                    else
                        $image = '<img width="20%" src="https://via.placeholder.com/150" />';

                    return $image;
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="View" class="view view_btn btn btn-success mr-1 btn-sm viewItem">View Referral</a>';
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-sm editItem">Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['image','online','action'])
                ->make(true);
        }

        return view('admin/pages/user');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        if(!$request->Item_id)
        {
        $is_found = User::where('email',$request->email)->first();
        if($is_found)
        {
           return response()->json(['success' => 'User found with same email']);
        }
        }
        if($request->Item_id)
        {
            $user = User::find($request->Item_id);
            $request->password ? $pass = bcrypt($request->password) : $pass = $user->password;
        }
        else
        {
            $pass = bcrypt($request->password);
        }
        $details = [
            'username' => $request->username,
            'email' => trim($request->email),
            'password' => $pass,
            'status'=> $request->status=='on' ? 1 : 0,
        ];
        $user_data = User::updateOrCreate(['id' => $request->Item_id], $details);
        if($user_data)
        {
            $user = User::where('email',trim($request->email))->first();
             $user->createToken($user->email)->accessToken;

            return response()->json(['success' => 'User Updated successfully.']);
        }
        else
        {
            return response()->json(['error' => 'User was not updated.']);
        }
    }

    public function show($id)
    {
        //
    }



    public function edit($id)
    {
        $item = User::find($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $fileArray = array('image');
        $item = User::find($id);
        // if($item->image != null)
        // {
        //     $this->deleteImage($item, $fileArray);
        // }

        User::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
     protected function deleteImage($queryObj, $files)
    {

        foreach ($files as $file) {
            $deletefile = $queryObj->$file;
            if($deletefile)
            {
                     $destinationPath = public_path() . '/assets/images/subcategory'; // upload path
            $deletefile = $destinationPath . '/' . basename($deletefile);
            File::delete($deletefile); 
            }
      
        }

    }


}


