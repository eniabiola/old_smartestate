<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Wallet;

class WalletController extends Controller
{
    public function walletbalance($tenantid,$walletid)
    {
         $reports = DB::table('wallets')
         ->select(DB::raw('sum(credit) - sum(debit)  balance'))
         ->where("tenant", "=", $tenantid)
         ->where("walletid", "=", $walletid)
         ->where(function($query) use ($tenantid){
            $query->where("transtatus", "Successful")
                ->orWhere("transtatus", "Transaction Successful");
        })
        ->get();
        return $reports;
    }
    public function index($tenantid)
    {
         $wallet = DB::table('wallets')
        ->select('wallets.*','residents.surname AS surname','residents.id AS surnameid')
->leftJoin('residents', 'wallets.surname', '=', 'residents.id')
        ->where("wallets.tenant", "=", $tenantid)
        ->orWhere("wallets.tenant", "=", "0")
        ->orderBy('wallets.id', 'desc')
        ->get();
        return $wallet;
    }
    public function indexresident($tenantid,$search)
    {
         $wallet = DB::table('wallets')
        ->select('wallets.*',DB::raw('credit-debit AS amount'))
        ->where("wallets.tenant", "=", $tenantid)
        ->where("wallets.walletid", "=", $search)
        ->where("transtatus", "=", "Successful")
        ->orderBy('wallets.id', 'desc')
        ->get();
        return $wallet;
    }
    
    public function walletsadmin($tenantid)
    {
         $wallet = DB::table('wallets')
        ->select('wallets.*',DB::raw('credit-debit AS amount'))
        ->where("wallets.tenant", "=", $tenantid)
        ->where("transtatus", "=", "Successful")
        ->orderBy('wallets.id', 'desc')
        ->get();
        return $wallet;
    }
    
public function indexmultiple($tenantid,$feild,$search)
    {
         $wallet = DB::table('wallets')
        ->select('wallets.*','residents.surname AS surname','residents.id AS surnameid')
->leftJoin('residents', 'wallets.surname', '=', 'residents.id')
        ->where(function($query) use ($tenantid){
            $query->where("wallets.tenant", $tenantid)
                ->orWhere("wallets.tenant", "0");
        })
        ->where("wallets.".$feild, "=", $search)
        ->orderBy('wallets.id', 'desc')
        ->get();
        return $wallet;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $wallet = DB::table('wallets')
        ->select('wallets.*','residents.surname AS surname','residents.id AS surnameid')
->leftJoin('residents', 'wallets.surname', '=', 'residents.id')
        ->where(function($query) use ($tenantid){
            $query->where("wallets.tenant", $tenantid)
                ->orWhere("wallets.tenant", "0");
        })
        ->where("wallets.".$feild, "=", $search)
        ->where("wallets.".$feild2, "=", $search2)
        ->orderBy('wallets.id', 'desc')
        ->get();
        return $wallet;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM wallets WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (walletid LIKE '%$search%' OR surname LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM wallets WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (walletid LIKE '%$search%' OR surname LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $wallet = DB::table('wallets')
        ->select('wallets.*')
        ->where('wallets.id', '=', $id)
        ->get();
        return $wallet;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['transid' => $id]);
        $wallet = Wallet::create($request->all());
        $autoid = "".str_pad($wallet['id'], 5, '0', STR_PAD_LEFT);
        $codeupdate = Wallet::where('id', $wallet['id'])->update(array('walletid' => $autoid));
        return response()->json($wallet, 201);
    }

    public function update(Request $request, $id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->update($request->all());

        return response()->json($wallet, 200);
    }

    public function delete(Request $request, $id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->delete();

        return response()->json(null, 204);
    }

}