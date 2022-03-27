<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Jobcategory;

class JobcategoryController extends Controller
{
    public function index($tenantid)
    {
         $jobcategory = DB::table('')
        ->select('.*')
        ->where(".tenant", "=", $tenantid)
        ->orWhere(".tenant", "=", "0")
        ->orderBy('.id', 'desc')
        ->get();
        return $jobcategory;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $jobcategory = DB::table('')
        ->select('.*')
        ->where(function($query) use ($tenantid){
            $query->where(".tenant", $tenantid)
                ->orWhere(".tenant", "0");
        })
        ->where(".".$feild, "=", $search)
        ->orderBy('.id', 'desc')
        ->get();
        return $jobcategory;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $jobcategory = DB::table('')
        ->select('.*')
        ->where(function($query) use ($tenantid){
            $query->where(".tenant", $tenantid)
                ->orWhere(".tenant", "0");
        })
        ->where(".".$feild, "=", $search)
        ->where(".".$feild2, "=", $search2)
        ->orderBy('.id', 'desc')
        ->get();
        return $jobcategory;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM  WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (jobcategory LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM  WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (jobcategory LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $jobcategory = DB::table('')
            ->select('.*')
->where('.id', '=', $id)
        ->get();
        return $jobcategory;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $jobcategory = Jobcategory::create($request->all());
        
        return response()->json($jobcategory, 201);
    }

    public function update(Request $request, $id)
    {
        $jobcategory = Jobcategory::findOrFail($id);
        $jobcategory->update($request->all());

        return response()->json($jobcategory, 200);
    }

    public function delete(Request $request, $id)
    {
        $jobcategory = Jobcategory::findOrFail($id);
        $jobcategory->delete();

        return response()->json(null, 204);
    }

}