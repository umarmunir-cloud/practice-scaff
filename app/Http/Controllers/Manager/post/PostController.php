<?php

namespace App\Http\Controllers\Manager\Post;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\Managercategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function index()
    {
        $data = [
            'page_title' => 'POSTS',
            'p_title' => 'Post',
            'p_summary' => 'List of Posts',
            'p_description' => null,
            'url' => route('manager.post.create'),
            'url_text' => 'Add New',
            'trash' => route('manager.get.post-activity-trash'),
            'trash_text' => 'View Trash',
        ];

        return view('manager.post.index')->with($data);
    }


    public function show(string $id)
    {
        $record = Manager::select('manager_post.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        //Data Array
        $data = array(
            'page_title' => 'POSTS',
            'p_title' => 'Post',
            'p_summary' => 'Show Post',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.post.update', $record->id),
            'url' => route('manager.post.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.post.show')->with($data);
    }

    public function getIndex(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length;

        $columnIndex = $request->order[0]['column'];
        $columnName = $request->columns[$columnIndex]['data'];
        $columnSortOrder = $request->order[0]['dir'];
        $searchValue = $request->search['value'];


        $where = [];

        if (!empty($request->category_id)) {
            $where[] = ['manager_post.category_id', '=', $request->category_id];
        }


        $totalRecords = Manager::where($where)->count();


        $totalRecordswithFilter = Manager::where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('manager_post.name', 'like', "%$searchValue%")
                    ->orWhere('manager_post.slug', 'like', "%$searchValue%");
            })
            ->count();


        $records = Manager::select('manager_post.*', 'manager_category.name as category')
            ->leftJoin('manager_category', 'manager_category.id', '=', 'manager_post.category_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('manager_post.name', 'like', "%$searchValue%")
                    ->orWhere('manager_post.slug', 'like', "%$searchValue%");
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = [];

        foreach ($records as $record) {

            $data_arr[] = [
                "id" => $record->id,
                "name" => $record->name,
                "slug" => $record->slug,
                "category" => $record->category ?? ''
            ];
        }

        return response()->json([
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }


    public function getCategoryIndexSelect(Request $request)
    {
        $data = [];

        if ($request->has('q')) {

            $search = $request->q;

            $data = Managercategory::select('id', 'name')
                ->where('name', 'like', "%$search%")
                ->get();
        }

        return response()->json($data);
    }

    public function create()
    {
        $data = [
            'page_title' => 'POSTS',
            'p_title' => 'Post',
            'p_summary' => 'Add Post',
            'method' => 'POST',
            'action' => route('manager.post.store'),
            'url' => route('manager.post.index'),
            'url_text' => 'View All',
            'enctype' => 'application/x-www-form-urlencoded',
        ];

        return view('manager.post.create')->with($data);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:manager_post,name',
            'slug' => 'required|unique:manager_post,slug',
            'category_id' => 'required|exists:manager_category,id',
        ]);

        Manager::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
        ]);

        Session::flash('messages', [
            [
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ]
        ]);

        return redirect()->route('manager.post.index');
    }

    public function edit(string $id)
    {
        $record = Manager::find($id);

        if (!$record) {
            abort(404);
        }

        $data = [
            'page_title' => 'POSTS',
            'p_title' => 'Post',
            'p_summary' => 'Edit Post',
            'method' => 'POST',
            'action' => route('manager.post.update', $record->id),
            'url' => route('manager.post.index'),
            'url_text' => 'View All',
            'data' => $record,
            'enctype' => 'application/x-www-form-urlencoded',
        ];

        return view('manager.post.edit')->with($data);
    }


    public function update(Request $request, string $id)
    {
        $record = Manager::find($id);

        if (!$record) {
            abort(404);
        }

        $this->validate($request, [
            'name' => 'required|unique:manager_post,name,' . $record->id,
            'slug' => 'required|unique:manager_post,slug,' . $record->id,
            'category_id' => 'required|exists:manager_category,id',
        ]);

        $record->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
        ]);

        Session::flash('messages', [
            [
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ]
        ]);

        return redirect()->route('manager.post.index');
    }


    public function destroy(string $id)
    {
        $record = Manager::find($id);

        if (!$record) {
            abort(404);
        }

        $record->delete();

        Session::flash('messages', [
            [
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ]
        ]);

        return redirect()->route('manager.post.index');
    }
}
