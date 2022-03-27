<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Payment;

class PaymentController extends Controller
{
    public function index($tenantid)
    {
         $payment = DB::table('payments')
        ->select('payments.*','residents.surname AS surname','residents.id AS surnameid')
->leftJoin('residents', 'payments.surname', '=', 'residents.id')
        ->where("payments.tenant", "=", $tenantid)
        ->orWhere("payments.tenant", "=", "0")
        ->orderBy('payments.id', 'desc')
        ->get();
        return $payment;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $payment = DB::table('payments')
        ->select('payments.*','residents.surname AS surname','residents.id AS surnameid')
->leftJoin('residents', 'payments.surname', '=', 'residents.id')
        ->where(function($query) use ($tenantid){
            $query->where("payments.tenant", $tenantid)
                ->orWhere("payments.tenant", "0");
        })
        ->where("payments.".$feild, "=", $search)
        ->orderBy('payments.id', 'desc')
        ->get();
        return $payment;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $payment = DB::table('payments')
        ->select('payments.*','residents.surname AS surname','residents.id AS surnameid')
->leftJoin('residents', 'payments.surname', '=', 'residents.id')
        ->where(function($query) use ($tenantid){
            $query->where("payments.tenant", $tenantid)
                ->orWhere("payments.tenant", "0");
        })
        ->where("payments.".$feild, "=", $search)
        ->where("payments.".$feild2, "=", $search2)
        ->orderBy('payments.id', 'desc')
        ->get();
        return $payment;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM payments WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (receiptno LIKE '%$search%' OR surname LIKE '%$search%' OR statuspayment LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM payments WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (receiptno LIKE '%$search%' OR surname LIKE '%$search%' OR statuspayment LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $payment = DB::table('payments')
            ->select('payments.*','residents.surname AS surname_get')
->where('payments.id', '=', $id)
->leftJoin('residents', 'payments.surname', '=', 'residents.id')
        ->get();
        return $payment;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $payment = Payment::create($request->all());
        $autoid = "".str_pad($payment['id'], 5, '0', STR_PAD_LEFT);
        $codeupdate = Payment::where('id', $payment['id'])->update(array('receiptno' => $autoid));
        return response()->json($payment, 201);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());

        return response()->json($payment, 200);
    }

    public function delete(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(null, 204);
    }

}