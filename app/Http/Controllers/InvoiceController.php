<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Invoice;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function invoicebalance($tenantid,$resid)
    {
         $reports = DB::table('invoices')
         ->select(DB::raw('sum(billings.amount) AS balance'))
         ->leftJoin('billings', 'billings.id', '=', 'invoices.invoiceno')
         ->where("invoices.tenant", "=", $tenantid)
         ->where("billings.tenant", "=", $tenantid)
         ->where("surname", "=", $resid)
         ->where("invoicestatus", "=", "Not Paid")
        ->get();
        return $reports;
    }
    public function index($tenantid)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','residents.surname AS surname','residents.id AS surnameid','billings.billitemcode AS billitemcode','billings.id AS billitemcodeid')
->leftJoin('residents', 'invoices.surname', '=', 'residents.id')
->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.id')
        ->where("invoices.tenant", "=", $tenantid)
        ->orWhere("invoices.tenant", "=", "0")
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }
    public function indexresident($tenantid,$resident)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','billings.billname AS billname','billings.amount AS amount')
        ->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.billitemcode')
        ->where("invoices.tenant", "=", $tenantid)
        ->where("invoices.surname", "=", $resident)
        ->where("invoices.invoicestatus", "=", "Not Paid")
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }
    public function indexresidentpaid($tenantid,$resident)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','billings.billname AS billname','billings.amount AS amount')
        ->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.billitemcode')
        ->where("invoices.tenant", "=", $tenantid)
        ->where("invoices.surname", "=", $resident)
        ->where("invoices.invoicestatus", "=", "Paid")
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }

    public function invoiceadmin($tenantid)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','residents.surname AS surname','residents.othername AS othername','billings.billname AS billname','billings.amount AS amount')
        ->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.billitemcode')
        ->leftJoin('residents', 'invoices.surname', '=', 'residents.id')
        //->leftJoin('billings', 'billings.id', '=', 'invoices.invoiceno')
        ->where("invoices.tenant", "=", $tenantid)
        ->where("billings.tenant", "=", $tenantid)
        ->where("invoices.invoicestatus", "=", "Not Paid")
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }

    public function paymentadmin($tenantid)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','residents.surname AS surname','residents.othername AS othername','billings.billname AS billname','billings.amount AS amount')
        ->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.billitemcode')
        ->leftJoin('residents', 'invoices.surname', '=', 'residents.id')
        //->leftJoin('billings', 'billings.id', '=', 'invoices.invoiceno')
        ->where("invoices.tenant", "=", $tenantid)
        ->where("billings.tenant", "=", $tenantid)
        ->where("invoices.invoicestatus", "=", "Paid")
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }

public function indexmultiple($tenantid,$feild,$search)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','residents.surname AS surname','residents.id AS surnameid','billings.billitemcode AS billitemcode','billings.id AS billitemcodeid')
->leftJoin('residents', 'invoices.surname', '=', 'residents.id')
->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.id')
        ->where(function($query) use ($tenantid){
            $query->where("invoices.tenant", $tenantid)
                ->orWhere("invoices.tenant", "0");
        })
        ->where("invoices.".$feild, "=", $search)
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','residents.surname AS surname','residents.id AS surnameid','billings.billitemcode AS billitemcode','billings.id AS billitemcodeid')
->leftJoin('residents', 'invoices.surname', '=', 'residents.id')
->leftJoin('billings', 'invoices.billitemcode', '=', 'billings.id')
        ->where(function($query) use ($tenantid){
            $query->where("invoices.tenant", $tenantid)
                ->orWhere("invoices.tenant", "0");
        })
        ->where("invoices.".$feild, "=", $search)
        ->where("invoices.".$feild2, "=", $search2)
        ->orderBy('invoices.id', 'desc')
        ->get();
        return $invoice;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM invoices WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (invoiceno LIKE '%$search%' OR surname LIKE '%$search%' OR billitemcode LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM invoices WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (invoiceno LIKE '%$search%' OR surname LIKE '%$search%' OR billitemcode LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $invoice = DB::table('invoices')
        ->select('invoices.*','billings.billname AS billname','billings.amount AS amount')
        ->where('invoices.id', '=', $id)
        ->leftJoin('billings', 'invoices.invoiceno', '=', 'billings.id')
        ->get();
        return $invoice;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $invoice = Invoice::create($request->all());
        $autoid = "".str_pad($invoice['id'], 5, '0', STR_PAD_LEFT);
        $codeupdate = Invoice::where('id', $invoice['id'])->update(array('invoiceno' => $autoid));
        return response()->json($invoice, 201);
    }

    public function electricityinvoice(Request $request){
        $tenant = $request['tenant'];
        $user = $request['user'];
        $amount = $request['amount'];

        $validator = Validator::make($request->all(), [
            'amount'        => 'required',
            'user'          => 'required',
            'tenant'        => 'required'
        ]);

        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return response()->json($errorString, 400);
        }

        $baseUrl = env('MMECOL_BASE_URL');
        $merchantCode = env('MMECOL_MERCHANT_CODE');

        $resident = DB::table('residents')->where('id', $user)->first();

        if(!$resident) {
            return response()->json("Invalid user ID", 400);
        }

        $meterno = $resident->meterno;
        $apiurl = "http://memmcolweb.memmserve.com:8080/MEMMCOLWebServices_Pilot/webresources/IdentificationV2/101/$meterno";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $apiurl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        //$ver = response()->json($response, 201);
        $ver = json_decode($response,true);

        if($ver["responsecode"] === "00"){
            $id = uniqid();
            $apiurl = "$baseUrl/webresources/PaymentV2/$meterno/prepaid/$merchantCode/$id/$amount";
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $apiurl,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $ver2 = json_decode($response,true);
            $status = 'Failed';

            //dd($ver2);

            if($ver2["responsecode"] === "00") {
                $status = 'Successful';
                $token = $ver2["recieptNumber"];
                $trans_ref = $ver2["transactionReference"];
                $trans_date = date("Y-m-d H:i:s");
                $iddd = uniqid('', true);

                $tenantuser = DB::insert('INSERT INTO electricity_tokens (`tokenid`, `date`, transref, transtatus, surname, amount, token, statuspurchase, tenant, user)
                VALUES (:tokenid,CURDATE(),:transref,:transtatus,:surname,:amount,:token,:statuspurchase,:tenant,:user)',
                array(
                    'tokenid' => $iddd,
                    'transref' => $trans_ref,
                    'transtatus' => $status,
                    'surname' => $resident->surname,
                    'amount' => $amount,
                    'token' => $token,
                    'statuspurchase' => $ver2['responsedesc'],
                    'tenant' => $tenant,
                    'user' => $user
                    )
                );

                $tenantuser = DB::insert('INSERT INTO invoices (`date`,amount,surname,billitemcode,`invoicestatus`,tenant,user)
                VALUES (CURDATE(),:amount,:surname,:billitemcode,:invoicestatus,:tenant,:user)',
                array(
                    'amount' => $amount,
                    'surname' => $user,
                    'billitemcode' => $id,
                    'invoicestatus' => 'Paid',
                    'tenant' => $tenant,
                    'user' => $user
                    )
                );

                $tenantuser = DB::insert('INSERT INTO wallets (`date`,transid,walletid,surname,debit,transref,`transtatus`,tenant,user)
                VALUES (CURDATE(),:transid,:walletid,:surname,:debit,:transref,:transtatus,:tenant,:user)',
                array(
                    'transid' => $iddd,
                    'walletid' => $user,
                    'surname' => "Electricity Token",
                    'debit' => $amount,
                    'transref' => $id,
                    'transtatus' => $status,
                    'tenant' => $tenant,
                    'user' => $user
                    )
                );
            }
        }

        return response()->json(json_decode($response), 201);
    }

    public function payelectricity($tenantid,$id){
        $iddd = uniqid('', true);
        $results = DB::table('invoices')
        ->select('*')
        ->where('billitemcode', '=', $id)
        ->get();
        $tenantuser = DB::insert('INSERT INTO wallets (`date`,transid,walletid,surname,debit,transref,`transtatus`,tenant,user)
            VALUES (CURDATE(),:transid,:walletid,:surname,:debit,:transref,:transtatus,:tenant,:user)',
            array(
                'transid' => $iddd,
                'walletid' => $results[0]->surname,
                'surname' => $results[0]->billname,
                'debit' => $results[0]->amount,
                'transref' => $results[0]->id,
                'transtatus' => 'Successful',
                'tenant' => $results[0]->tenant,
                'user' => $results[0]->user
                )
            );
        $codeupdate = Invoice::where('id', $id)->update(array('invoicestatus' => "Paid"));
    }
    public function pay($tenantid,$id){
        $iddd = uniqid('', true);
        $results = DB::table('invoices')
        ->select('invoices.*','billings.billname AS billname','billings.amount AS amount')
        ->where('invoices.id', '=', $id)
        ->leftJoin('billings', 'invoices.invoiceno', '=', 'billings.id')
        ->get();
        $tenantuser = DB::insert('INSERT INTO wallets (`date`,transid,walletid,surname,debit,transref,`transtatus`,tenant,user)
            VALUES (CURDATE(),:transid,:walletid,:surname,:debit,:transref,:transtatus,:tenant,:user)',
            array(
                'transid' => $iddd,
                'walletid' => $results[0]->surname,
                'surname' => $results[0]->billname,
                'debit' => $results[0]->amount,
                'transref' => $results[0]->id,
                'transtatus' => 'Successful',
                'tenant' => $results[0]->tenant,
                'user' => $results[0]->user
                )
            );
            $codeupdate = Invoice::where('id', $id)->update(array('invoicestatus' => "Paid"));
    }
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        return response()->json($invoice, 200);
    }

    public function delete(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(null, 204);
    }

}
