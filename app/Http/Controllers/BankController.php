<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Bank;

class BankController extends Controller
{
    public function index($tenantid)
    {
         $bank = DB::table('banks')
        ->select('banks.*')
        ->where("banks.tenant", "=", $tenantid)
        ->orWhere("banks.tenant", "=", "0")
        ->orderBy('banks.id', 'desc')
        ->get();
        return $bank;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $bank = DB::table('banks')
        ->select('banks.*')
        ->where(function($query) use ($tenantid){
            $query->where("banks.tenant", $tenantid)
                ->orWhere("banks.tenant", "0");
        })
        ->where("banks.".$feild, "=", $search)
        ->orderBy('banks.id', 'desc')
        ->get();
        return $bank;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $bank = DB::table('banks')
        ->select('banks.*')
        ->where(function($query) use ($tenantid){
            $query->where("banks.tenant", $tenantid)
                ->orWhere("banks.tenant", "0");
        })
        ->where("banks.".$feild, "=", $search)
        ->where("banks.".$feild2, "=", $search2)
        ->orderBy('banks.id', 'desc')
        ->get();
        return $bank;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM banks WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (bank LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM banks WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (bank LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $bank = DB::table('banks')
            ->select('banks.*')
->where('banks.id', '=', $id)
        ->get();
        return $bank;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $bank = Bank::create($request->all());
        
        return response()->json($bank, 201);
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->update($request->all());

        return response()->json($bank, 200);
    }

    public function delete(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return response()->json(null, 204);
    }

}