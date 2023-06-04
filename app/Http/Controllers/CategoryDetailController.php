<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoryDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Category Detail Index')->only(['index']);
        $this->middleware('can:Category Detail Create')->only(['store']);
          $this->middleware('can:Category Detail Update')->only(['store']);
          $this->middleware('can:Category Detail Delete')->only(['destroy']);
    }

    public function index()
    {
        $category_id = request('category_id');
        $category = Category::where('id',$category_id)->first();
        if(!$category)
        {
            return redirect()->route('categories.index');
        }
        return view('pages.category-detail.index', [
            'title' => 'Data Detail Kategori',
            'category' => $category
        ]);
    }

    public function data()
    {
        $category_id = request('category_id');
        if (request()->ajax()) {
            $data = CategoryDetail::where('category_id',$category_id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    // $link_detail = {{ route() }}
                    $action = "<button class='btn btn-sm py-2 btn-info btnEdit mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-edit'></i> Edit</button><button class='btn btn-sm py-2 btn-danger btnDelete mx-1' data-id='$model->id' data-name='$model->name'><i class='fas fa fa-trash'></i> Hapus</button>";
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        if(request()->ajax()){
            $category_detail = CategoryDetail::where('id',$id)->first();
            return response()->json($category_detail);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'column_name' => ['required'],
            'order' => ['required','numeric']
        ]);

        DB::beginTransaction();
        try {
            CategoryDetail::updateOrCreate([
                'id'  => request('id')
            ], [
                'category_id' => request('category_id'),
                'column_name' => request('column_name'),
                'order' => request('order')
            ]);

            if (request('id')) {
                $message = 'Category Detail updated successfully.';
            } else {
                $message = 'Category Detail created successfully.';
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
            CategoryDetail::find($id)->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Category Detail deleted successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'System Error!']);
        }
    }
}
