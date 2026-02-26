<?php

namespace App\Http\Controllers\Manager\category;

use App\Http\Controllers\Controller;
use App\Models\Managercategory;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'category',
            'p_title' => 'category',
            'p_summary' => 'List of category',
            'p_description' => null,
            'url' => route('manager.category.create'),
            'url_text' => 'Add New',
            'trash' => route('manager.get.category-activity-trash'),
            'trash_text' => 'View Trash',
        ];
        return view('manager.category.index')->with($data);
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Managercategory::select('manager_category.*')->count();
        // Total records with filter
        $totalRecordswithFilter = Managercategory::select('manager_category.*')
            ->where(function ($q) use ($searchValue) {
                $q->where('manager_category.name', 'like', '%' . $searchValue . '%');
            })
            ->count();
        // Fetch records
        $records = Managercategory::select('manager_category.*')
            ->where(function ($q) use ($searchValue) {
                $q->where('manager_category.name', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $slug = $record->slug;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "slug" => $slug,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndexSelect(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Managercategory::select('manager_category.id as id', 'manager_category.name as name')
                ->where(function ($q) use ($search) {
                    $q->where('manager_category.name', 'like', '%' . $search . '%');
                })
                ->get();
        }

        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array(
            'page_title' => 'category Page',
            'p_title' => 'category',
            'p_summary' => 'Add category',
            'p_description' => null,
            'method' => 'category',
            'action' => route('manager.category.store'),
            'url' => route('manager.category.index'),
            'url_text' => 'View All',
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.category.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:manager_category,name',
            'slug' => 'required|unique:manager_category,slug',
        ]);
        //
        $arr = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ];
        $record = Managercategory::create($arr);
        $messages = [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.category.index');
    }

    /**
     * Display the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $record = Managercategory::select('manager_category.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        // Add activity logs
        $user = Auth::user();
        activity('category Operation Groups')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->name]])
            ->log('viewed');
        //Data Array
        $data = array(
            'page_title' => 'category',
            'p_title' => 'category',
            'p_summary' => 'Show category',
            'p_description' => null,
            'method' => 'category',
            'action' => route('manager.category.update', $record->id),
            'url' => route('manager.category.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.category.show')->with($data);
    }

    /**
     * Display the specified resource Activity.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getActivity(string $id)
    {
        //Data Array
        $data = array(
            'page_title' => 'Activity Page',
            'p_title' => 'category Activity',
            'p_summary' => 'Show category Activity',
            'p_description' => null,
            'url' => route('manager.category.index'),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.category.activity')->with($data);
    }

    /**
     * Display the specified resource Activity Logs.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getActivityLog(Request $request, string $id)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('manager_category', 'manager_category.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Managercategory::class)
            ->where('activity_log.subject_id', $id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('manager_category', 'manager_category.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Managercategory::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('manager_category', 'manager_category.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Managercategory::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $attributes = (!empty($record->properties['attributes']) ? $record->properties['attributes'] : '');
            $old = (!empty($record->properties['old']) ? $record->properties['old'] : '');
            $current = '<ul class="list-unstyled">';
            //Current
            if (!empty($attributes)) {
                foreach ($attributes as $key => $value) {
                    if (is_array($value)) {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    } else {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                }
            }
            $current .= '</ul>';
            //Old
            $oldValue = '<ul class="list-unstyled">';
            if (!empty($old)) {
                foreach ($old as $key => $value) {
                    if (is_array($value)) {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    } else {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                }
            }
            //updated at
            $updated = 'Updated:' . $record->updated_at->diffForHumans() . '<br> At:' . $record->updated_at->isoFormat('llll');
            $oldValue .= '</ul>';
            //Causer
            $causer = isset($record->causer) ? $record->causer : '';
            $type = $record->description;
            $data_arr[] = array(
                "id" => $id,
                "current" => $current,
                "old" => $oldValue,
                "updated" => $updated,
                "causer" => $causer,
                "type" => $type,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Display the trash resource Activity.
     * @return \Illuminate\Http\Response
     */
    public function getTrashActivity()
    {
        //Data Array
        $data = array(
            'page_title' => 'Trashed page',
            'p_title' => 'category Activity',
            'p_summary' => 'Show category Trashed Activity',
            'p_description' => null,
            'url' => route('manager.category.index'),
            'url_text' => 'View All',
        );
        return view('manager.category.trash')->with($data);
    }

    /**
     * Display the trash resource Activity Logs.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getTrashActivityLog(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('permission_groups', 'permission_groups.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', PermissionGroup::class)
            ->where('activity_log.event', 'deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('manager_category', 'manager_category.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', PermissionGroup::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('manager_category', 'manager_category.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Managercategory::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->get();

        $data_arr = [];

        foreach ($records as $record) {
            $attributes = $record->properties['attributes'] ?? [];

            // Fetch relations
            $relations = '';
            if ($record->subject) {
                $relations .= '<ul class="list-unstyled mb-0">';
                $relations .= '<li><strong>Permissions:</strong> ' . implode(', ', $record->subject->permissions->pluck('name')->toArray()) . '</li>';
                $relations .= '<li><strong>Users:</strong> ' . implode(', ', $record->subject->user->pluck('name')->toArray()) . '</li>';
                $relations .= '<li><strong>SEO:</strong> ' . ($record->subject->seo->title ?? 'N/A') . '</li>';
                $relations .= '</ul>';
            }

            $current = '<ul class="list-unstyled">';
            foreach ($attributes as $key => $value) {
                $current .= '<li><i class="fas fa-angle-right"></i> ' . $key . ': <mark>' . (is_array($value) ? json_encode($value) : $value) . '</mark></li>';
            }
            $current .= '</ul>';

            $current .= '<hr>' . $relations;

            $old = $record->properties['old'] ?? [];
            $oldValue = '<ul class="list-unstyled">';
            foreach ($old as $key => $value) {
                $oldValue .= '<li><i class="fas fa-angle-right"></i> ' . $key . ': <mark>' . (is_array($value) ? json_encode($value) : $value) . '</mark></li>';
            }
            $oldValue .= '</ul>';

            $updated = 'Updated:' . $record->updated_at->diffForHumans() . '<br> At:' . $record->updated_at->isoFormat('llll');
            $causer = $record->causer ?? '';
            $type = $record->description;

            $data_arr[] = [
                "id" => $record->id,
                "current" => $current,
                "old" => $oldValue,
                "updated" => $updated,
                "causer" => $causer,
                "type" => $type,
            ];
        }
        return response()->json([
            "draw" => intval($request->draw),
            "iTotalRecords" => count($records),
            "iTotalDisplayRecords" => count($records),
            "aaData" => $data_arr
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $record = Managercategory::select('manager_category.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'category',
            'p_title' => 'category',
            'p_summary' => 'Edit category',
            'p_description' => null,
            'method' => 'category',
            'action' => route('manager.category.update', $record->id),
            'url' => route('manager.category.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.category.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        // Manager model ko select kar rahe hain
        $record = Managercategory::where('id', '=', $id)->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // Validation: manager_category table ke mutabiq unique check
        $this->validate($request, [
            'name' => 'required|unique:manager_category,name,' . $record->id,
            'slug' => 'required|unique:manager_category,slug,' . $record->id,
        ]);

        // Update record
        $arr = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ];

        $record->update($arr);
        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.category.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $record = Managercategory::select('manager_category.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $record->delete();

        $messages = [
            array(
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.category.index');
    }
}
