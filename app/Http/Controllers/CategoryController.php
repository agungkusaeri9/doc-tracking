<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Category Index')->only(['index']);
        $this->middleware('can:Category Create')->only(['store']);
        $this->middleware('can:Category Update')->only(['store']);
        $this->middleware('can:Category Delete')->only(['destroy']);
    }

    public function index()
    {
        return view('pages.category.index', [
            'title' => 'Data Kategori'
        ]);
    }

    public function data()
    {
        if (request()->ajax()) {
            $data = Category::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $link_detail = route('category-details.index') . '?category_id=' . $model->id;
                    if (cek_user_permission('Category Detail Index')) {
                        $detail = "<a href='$link_detail' class='btn btn-sm py-2 btn-warning btnDetail mx-1'><i class='fas fa fa-eye'></i> Detail</a>";
                    } else {
                        $detail = '';
                    }
                    if (cek_user_permission('Category Update')) {
                        $edit = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name' data-code='$model->code'><i class='fas fa fa-edit'></i> Edit</button>";
                    } else {
                        $edit = '';
                    }
                    if (cek_user_permission('Category Delete')) {
                        $hapus = "<button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    } else {
                        $hapus = '';
                    }


                    return $detail . $edit . $hapus;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => ['required', Rule::unique('categories')->ignore(request('id'))],
            'code' => ['required', Rule::unique('categories')->ignore(request('id'))]
        ]);

        DB::beginTransaction();
        try {
            Category::updateOrCreate([
                'id'  => request('id')
            ], [
                'name' => request('name'),
                'code' => request('code')
            ]);

            if (request('id')) {
                $message = 'Category updated successfully.';
            } else {
                $message = 'Category created successfully.';
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Category::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Category created successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }
}
