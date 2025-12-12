<?php
    namespace App\Http\Controllers;
    use App\Models\Invoice;
    use Illuminate\Http\Request;

class InvoiceController extends Controller
{
   public function show($id)
    {
        $invoice = Invoice::with(['history.customer', 'history.historyDetails.service','user','history.historyDetails'])
            ->where('invoice_id', $id)
            ->firstOrFail();

        return view('QuanLyLichSu.Modal.invoice', compact('invoice'));
    }

    function execPostRequest($url, $data)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data))
            );
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
            return $result;
        }

 public function momo_payment(Request $request)
    {
        $invoice = Invoice::where('invoice_id', $request->invoice_id)->firstOrFail();

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = "MOMOBKUN20180529";
        $accessKey = "klm05TvNBzhg7h7j";
        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

        $orderInfo = "Thanh toán ATM MoMo";
        $amount = (int)$invoice->total_price;
        $orderId = $invoice->invoice_id . '_' . time();  
        $redirectUrl = "http://127.0.0.1:8000/payment/result";
        $ipnUrl = "http://127.0.0.1:8000/momo/ipn";
        $requestId = $invoice->invoice_id.time(); 

        $requestType = "payWithMethod";
        $extraData = "";

        $rawHash = "accessKey=" . $accessKey .
                "&amount=" . $amount .
                "&extraData=" . $extraData .
                "&ipnUrl=" . $ipnUrl .
                "&orderId=" . $orderId .
                "&orderInfo=" . $orderInfo .
                "&partnerCode=" . $partnerCode .
                "&redirectUrl=" . $redirectUrl .
                "&requestId=" . $requestId .
                "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MoMoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        // dd($jsonResult);
        return redirect()->to($jsonResult['payUrl']);
    }

    public function paymentResult(Request $request)
    {
        if(!$request->has('orderId') || !$request->has('resultCode')) {
            return redirect()->route('lichsu.index')->with('error', 'Không tìm thấy thông tin giao dịch.');
        }

        $orderId = $request->orderId;
        $resultCode = $request->resultCode;

        $invoice = Invoice::where('invoice_id', $orderId)->firstOrFail();

        if(!$invoice) {
            return redirect()->route('lichsu.index')->with('error', 'Không tìm thấy hóa đơn.');
        }

        if($resultCode == 0) {
            $invoice->status = 'paid';
            $invoice->save();
            return redirect()->route('lichsu.index')->with('success', 'Thanh toán Momo thành công!');
        } else {
            return redirect()->route('lichsu.index')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
        }
    }



    // Thanh toan bang tien mat

    public function cash_payment(Request $request) {
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
            $invoice = Invoice::where('invoice_id', $request->invoice_id)->firstOrFail();
            $invoice->method_payment = 'cash';
            $invoice->status = 'paid';
            $invoice->save();
            return redirect()->route('lichsu.index')->with('success', 'Thanh toán bằng tiền mặt thành công!');
        }
        else {
            return redirect()->route('lichsu.index')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
        }
    }
}