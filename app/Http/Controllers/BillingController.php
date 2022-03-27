<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Billing;

class BillingController extends Controller
{
    public function index($tenantid)
    {
         $billing = DB::table('billings')
        ->select('billings.*')
        ->where("billings.tenant", "=", $tenantid)
        ->orWhere("billings.tenant", "=", "0")
        ->orderBy('billings.id', 'desc')
        ->get();
        return $billing;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $billing = DB::table('billings')
        ->select('billings.*')
        ->where(function($query) use ($tenantid){
            $query->where("billings.tenant", $tenantid)
                ->orWhere("billings.tenant", "0");
        })
        ->where("billings.".$feild, "=", $search)
        ->orderBy('billings.id', 'desc')
        ->get();
        return $billing;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $billing = DB::table('billings')
        ->select('billings.*')
        ->where(function($query) use ($tenantid){
            $query->where("billings.tenant", $tenantid)
                ->orWhere("billings.tenant", "0");
        })
        ->where("billings.".$feild, "=", $search)
        ->where("billings.".$feild2, "=", $search2)
        ->orderBy('billings.id', 'desc')
        ->get();
        return $billing;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM billings WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (billitemcode LIKE '%$search%' OR billname LIKE '%$search%' OR frequency LIKE '%$search%' OR statusbill LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM billings WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (billitemcode LIKE '%$search%' OR billname LIKE '%$search%' OR frequency LIKE '%$search%' OR statusbill LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $billing = DB::table('billings')
            ->select('billings.*')
->where('billings.id', '=', $id)
        ->get();
        return $billing;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['idsession' => $id]);
        $billing = Billing::create($request->all());
        $getcode = DB::table('billings')->select('id')->where("idsession", "=", $id)->get();
        $billid = $getcode[0]->id;
        $autoid = str_pad($getcode[0]->id, 5, '0', STR_PAD_LEFT);
        $codeupdate = Billing::where('idsession', $id)->update(array('billitemcode' => $autoid));
        //
        $frequency = $request['frequency'];
        $tenant = $request['tenant'];
        $user = $request['user'];
        $results = DB::select(
            DB::raw("SELECT * FROM residents WHERE tenant = '$tenant' ORDER BY id DESC"),
        );
        foreach($results as $r){
            $tenantuser = DB::insert('INSERT INTO invoices (`date`,surname,invoiceno,billitemcode,`invoicestatus`,tenant,user)
            VALUES (CURDATE(),:surname,:invoiceno,:billitemcode,:invoicestatus,:tenant,:user)',
            array(
                'surname' => $r->id,
                'invoiceno' => $billid,
                'billitemcode' => $autoid,
                'invoicestatus' => 'Not Paid',
                'tenant' => $tenant,
                'user' => $user
                )
            );
        }
        return response()->json($billing, 201);
    }

    public function update(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);
        $billing->update($request->all());

        return response()->json($billing, 200);
    }

    public function delete(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);
        $billing->delete();
        DB::table('invoices')
        ->where('invoiceno',$id)
        ->where('invoicestatus','Pending')
        ->delete();
        return response()->json(null, 204);
    }

}
