<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Resident;

class ResidentController extends Controller
{
    public function index($tenantid)
    {
         $resident = DB::table('residents')
        ->select('*')
        ->where("tenant", "=", $tenantid)
        ->orderBy('id', 'desc')
        ->get();
        return $resident;
    }
    
    public function residentaction($id,$action)
    {
        $resident = Resident::where('id', $id)
        ->update(
            [
                'regstatus' => $action
            ]
            );
        return $resident;
    }
    
public function indexmultiple($tenantid,$feild,$search)
    {
         $resident = DB::table('residents')
        ->select('residents.*','housetypes.housetype AS housetype','housetypes.id AS housetypeid','landlords.landlordname AS landlordname','landlords.id AS landlordnameid')
        ->leftJoin('housetypes', 'residents.housetype', '=', 'housetypes.id')
        ->leftJoin('landlords', 'residents.landlordname', '=', 'landlords.id')
        ->where(function($query) use ($tenantid){
            $query->where("residents.tenant", $tenantid)
                ->orWhere("residents.tenant", "0");
        })
        ->where("residents.".$feild, "=", $search)
        ->orderBy('residents.id', 'desc')
        ->get();
        return $resident;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $resident = DB::table('residents')
        ->select('residents.*','housetypes.housetype AS housetype','housetypes.id AS housetypeid','landlords.landlordname AS landlordname','landlords.id AS landlordnameid')
->leftJoin('housetypes', 'residents.housetype', '=', 'housetypes.id')
->leftJoin('landlords', 'residents.landlordname', '=', 'landlords.id')
        ->where(function($query) use ($tenantid){
            $query->where("residents.tenant", $tenantid)
                ->orWhere("residents.tenant", "0");
        })
        ->where("residents.".$feild, "=", $search)
        ->where("residents.".$feild2, "=", $search2)
        ->orderBy('residents.id', 'desc')
        ->get();
        return $resident;
    }

    public function search($tenantid,$search,$status)
    {
        $statussearch = $status;
        if($status == "All"){
            $statussearch = "";
        }
        if($search == "All"){
            $search = "";
        }
        $results = DB::select(
            DB::raw("SELECT * FROM residents WHERE tenant = '$tenantid' AND street LIKE '%$statussearch%' AND
            (surname LIKE '%$search%' OR othername LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function countresident($tenantid)
    {
        $results = DB::table('residents')
                ->where('tenant', $tenantid)
                ->count();
        return $results;
    }
    public function countrequest($tenantid)
    {
        $results = DB::table('complaints')
        ->where('complaintstatus', 'Pending')
        ->where('tenant', $tenantid)
        ->count();
        return $results;
    }
    
    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM residents WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (surname LIKE '%$search%' OR othername LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%' OR gender LIKE '%$search%' OR landlordname LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $resident = DB::table('residents')
            ->select('*')
->where('id', '=', $id)
        ->get();
        return $resident;
    }

    public function store(Request $request)
    { 
        $id = uniqid('', true);
        $request->request->add(['idsession' => $id]);
        $resident = Resident::create($request->all());
        $getcode = DB::table('residents')->select('id')->where("idsession", "=", $id)->get();
        $autoid = str_pad($getcode[0]->id, 5, '0', STR_PAD_LEFT);
        $codeupdate = Resident::where('idsession', $id)->update(array('residentid' => $autoid));
        return $resident;
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->update($request->all());

        return response()->json($resident, 200);
    }

    public function delete(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return response()->json(null, 204);
    }

}