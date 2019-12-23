<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\URL;
use App\Library\PHPMailer;
use App\Library\Paypal\Paypalhelper;
use App\Library\Paypal\Configpaypal;
use App\Library\Paypal\Httphelper;
use App\Orders;
use Yajra\Datatables\Datatables;
use PDF;



class PaymentController extends Controller{
    
    protected $common;
    protected $to='info@maansawebworld.com';
    protected $interview_to='hr@maansawebworld.com';
    protected $paypalhelper;
    protected $configpaypal;

    public function __construct(){ 
        $this->common=new CommonController();
        $this->common->seoTags(); 
        $this->paypalhelper = new Paypalhelper();
        $this->configpaypal = new Configpaypal();
    }
    
    function direct_payment(){
        $configpaypal = new Configpaypal();
        $content['URL'] = $this->configpaypal->get_url();
        $content['PAYPAL_ENVIRONMENT'] = $this->configpaypal->get_environment();
        $content['baseUrl'] = URL::to('/');        
        return view('front.payment.pay',$content);
    }
     function paypal_order_create(Request $request){       
       //echo $this->paypal_module->info();	 die();         
        $invoice_id = "INV-MWPL-".$this->order_save($request->all());       
        $paymentData = array(
	"intent" => "sale",
	"payer" => array(
		"payment_method" => "paypal"
	),
	"transactions" => array(
		array(
			"amount" => array(
				"total" => $request->input('total_amt'),
				"currency" => $request->input('currency'),
				"details" => array (
					"subtotal" => $request->input('item_amt'),
					"tax" => $request->input('tax_amt'),
					"shipping" => $request->input('shipping_amt'),
					"handling_fee" => $request->input('handling_fee'),
					"shipping_discount" => $request->input('shipping_discount'),
					"insurance" => $request->input('insurance_fee')
				)
			),
                    "invoice_number"=>$invoice_id
		)
	),
            "redirect_urls" => array(
                    "return_url" => $request->input('return_url'),
                    "cancel_url" => $request->input('cancel_url')
            )
        );
        
        
        /*if(array_key_exists('shipping_country_code', $_POST)) {
            $paymentData['transactions'][0]['item_list'] = array(
                "shipping_address" => array(
                    "recipient_name" => $this->input->post('shipping_recipient_name'),
                    "line1" => $this->input->post('shipping_line1'),
                    "line2" => $this->input->post('shipping_line2'),
                    "city" => $this->input->post('shipping_city'),
                    "state" => $this->input->post('shipping_state'),
                    "postal_code" => $this->input->post('shipping_postal_code'),
                    "country_code" => $this->input->post('shipping_country_code')
                )
            );
        }*/

        header('Content-Type: application/json');
        echo json_encode($this->paypalhelper->paymentCreate($paymentData));
    }
    function invoice_number_fix($invoice =''){
        if($invoice!=""){
            $content = explode("-", $invoice);            
            if(!empty($content)){
                return $content[2];
            }
        }
    }
    function getPayment(Request $request){  
        $paymentData = array(
            "pay_id" => $request->input('pay_id')
        );

        header('Content-Type: application/json');        
        echo json_encode($this->paypalhelper->paymentGet($paymentData));
    }
    function executePayment(Request $request){ 
        $paymentData = array(
            "pay_id" => $request->input('pay_id'),
                "payer_id" => $request->input('payer_id')
        );

        if(array_key_exists('updated_shipping', $request->all())) {
            $finalTotal = $request->input('total_amt') + ($request->input('updated_shipping') - $request->input('current_shipping'));
            $paymentData['transactions'] = array(
                array(
                    "amount" => array(
                        "total" => $finalTotal,
                        "currency" => $request->input('currency'),
                        "details" => array (
                            "subtotal" => $request->input('item_amt'),
                            "tax" => $request->input('tax_amt'),
                            "shipping" => $request->input('updated_shipping'),
                            "handling_fee" => $request->input('handling_fee'),
                            "shipping_discount" => $request->input('shipping_discount'),
                            "insurance" => $request->input('insurance_fee')
                        )
                    ),                  
                )
            );
            //var_dump($paymentData);
        }
        
        header('Content-Type: application/json');
        echo json_encode($this->paypalhelper->paymentExecute($paymentData));
    }
    
    function success(Request $request){ 
        
        $content['URL'] = $this->configpaypal->get_url();
        $content['PAYPAL_ENVIRONMENT'] = $this->configpaypal->get_environment();
        $content['baseUrl'] = URL::to('/');          
        $content['paymentId'] = $request->get('paymentId');
        $content['PayerID'] = $request->get('PayerID');       
        return view('front.payment.success',$content);
        
    }
    function cancel(){  
       return view('front.payment.cancel');
    }
    
    
    
    
    function getPayment_php($pay_id){  
        $paymentData = array(
            "pay_id" => $pay_id
        );        
        return $this->paypalhelper->paymentGet($paymentData);
    }
    function update_payid(Request $request){
        $pay_id = $request->input('payid');
        $record = $this->getPayment_php($pay_id);        
        if(!empty($record)){
            $id = $record['data']['transactions'][0]['invoice_number'];
            $data['payment_txn_id'] = $request->input('payid');
            $this->order_update($id,$data);
        }
    }    
   
    /*Update Transaction success*/
    function update_status(Request $request){       
       //$pay_id = "PAYID-LROJWKQ3GC88952XX001961K";
       //$pay_id = "PAYID-LRO444A56D604943Y151205B";
      //$pay_id  ="PAYID-LRZX65I5LT22520KW269133P";
        $pay_id = $request->input('payid');
        $record = $this->getPayment_php($pay_id);
        //echo "<pre>"; print_r($record); echo "</pre>"; die();
        if(!empty($record)){
            if($record['data']['transactions'][0]['related_resources'][0]['sale']['state'] =="completed"){
                $data['status'] ="Completed"; 
                $this->invoice($record['data']['transactions'][0]['invoice_number']);
                $this->email_invoice($record['data']['transactions'][0]['invoice_number']);
                $data['payment_order_id'] = $record['data']['transactions'][0]['related_resources'][0]['sale']['id'];       
            }else{
                $data['status']="pending";
            }
               
            $id = $this->invoice_number_fix( $record['data']['transactions'][0]['invoice_number'] ); 
            $this->order_update($id, $data);
        }
           
                                                        
    }
    
    function invoice($id=0){  
        $id= $this->invoice_number_fix($id);
        $order['r'] = Orders::where('id',$id)->first();         
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetImportUse();            
        }];        
        $pdf = PDF::loadView('front.payment.invoice', $order);         
        $filename = public_path('invoice/'.'invoice_'.$id.'.pdf');
        //return $pdf->download('invoice_'.$id.'.pdf');die();
        return $pdf->save($filename);        
    }
    function email_invoice($id=0){
        $id= $this->invoice_number_fix($id);
        $order['r'] = Orders::where('id',$id)->first();
        $view = view('front.payment.invoice',$order);
        $html = $view->render();
        $this->common->sendSMTP($order['r']->email, "MWPL-Payment-Invoice", $html, public_path('invoice/'.'invoice_'.$id.'.pdf'));    
        //$this->common->sendSMTP('info@maansawebworld.com', "MWPL-Payment-Invoice", $html, public_path('invoice/'.'invoice_'.$id.'.pdf'));     
    }
    
    /*Order create*/
    
    function order_save($info){
        $save_data = new Orders($info);
        $save_data->save();
        return $save_data->id;
    }
    function order_update($id,$data){
        $update_data = Orders::find($id);
        $update_data->update($data);
    }
    
    
    
    
    /*Admin show orders*/
    function show(){
        return view('front.payment.list');
    }
    function showList(){        
        $record = Orders::query();        
        return Datatables::of($record) 
           ->editColumn('status',function($record) {
               if($record->status==""){
                   return "Pending";
               }else{
                   return $record->status;
               }              
            })
            ->editColumn('date',function($record) {
                
               return date('d M,Y h:i a');
            })
            ->addColumn('actions',function($record) {
                $actions = '<a href="'. route('admin.vieworder',$record->id).'" class="on-default"><i class="fa fa-search-plus"></i></a> &nbsp;';  
                $actions.= '<a href="'. asset('public/invoice/invoice_'.$record->id.'.pdf').'" class="on-default" download><i class="fa fa-download"></i></a> &nbsp;';  
                return $actions;
            })
           // ->rawColumns(['actions'])
            ->make(true);            
    }   
    
    function showfulll($id=0){
        $record['r'] = Orders::where('id',$id)->first();
        return view('front.payment.vieworder',$record);
    }
    
}
