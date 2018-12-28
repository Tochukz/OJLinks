<?php

namespace Ojlinks\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Ojlinks\Order;
class PaymentController extends Controller
{
	private $action =  "https://sandbox.payfast.co.za/eng/process" ;
	private $validateUrl = "https://sandbox.payfast.co.za/eng/query/validate";
	/*
	 * Returns time in a specified format
	 *@return string
	*/
	public function getTime(){
		return date("D j M Y h:i:s A", time());
	}
	/*
	* This is just like a config method it determines if i am  in production mode or development stages and applies the right settings
	* @return array
	*/
	public function urlStrings(){
		if( preg_match('/ojlinks.tochukwu.xyz/', ($_SERVER['SERVER_NAME']))){
		    $return_url = 'http://ojlinks.tochukwu.xyz/payment/success?order_id=';
		    $cancel_url = 'http://ojlinks.tochukwu.xyz/cart/checkout?status=failed';
		    $notify_url = 'http://ojlinks.tochukwu.xyz/payment/notify';

		}else{
		    $return_url = 'http://d93488cb.ngrok.io/payment/success?order_id=';
		    $cancel_url = 'http://d93488cb.ngrok.io/cart/checkout?status=failed';
		    $notify_url = 'http://d93488cb.ngrok.io/payment/notify';
		}
		return [
			'return_url'=>$return_url,
			'cancel_url'=>$cancel_url,
			'notify_url'=>$notify_url,
		];
	}
	/*
	 * This method handles the sending of the form to the use, the form bounces(form.submit()) on the uses browser and up to the payment system
	 * @return string <html><form>
	 */
	public function process(){
	   $variables = $this->getRequestVariables();
	   //Log Request Variables
	   $time = $this->getTime(); 
	   $json = json_encode($variables, JSON_UNESCAPED_SLASHES);
	   $str = $time."\n".$json;
	   Storage::disk('local')->append('log_request_variables.tmp',  $str);

	   //Save the order to the database
	   $this->saveOrder($variables);

	   //Send form to user to verify pay but she doesn't have to form will bounce and submit itself. JavaScript :)
	   $htmlFrom = '<form action="'.$this->action.'" method="POST" id="form" enctype="application/x-www-form-urlencoded">';
		foreach($variables as $key=>$value){
		      $htmlFrom .='<input type="hidden" name="'.$key.'" value="'.$value.'" />';
		}
		 $htmlFrom .='<noscript>
		 				<input type="submit" value=" Pay Now " />
		 			</noscript>
		 			</form>
		 		<script>
		 			document.getElementById("form").submit();
				</script>';

		return $htmlFrom;  
	}

	/*
	 * It Takes the variables to be submited via html form and creates a hash using the variables key and value query string
	 * The hash generated is added as a new element in the variables array with a key named 'signature'
	 *
	 * @return array 
	 */
	public function getRequestVariables(){
	   $variables = $this->getRequestArray(); //Get variables for html form
	   $query_string = '';
	   foreach($variables as $key=>$value){
	     if(!empty($key)){
	       $query_string .= "$key=".urlencode(trim($value))."&";
	     }
	   }

	   $query_string = chop($query_string, '&');
	   $signature = md5($query_string);

	   $variables['signature'] = $signature;
	   return $variables; //Returns variable having new element key 'signature' for html form
	}
	/*
	 * stores the user's order in the database.
	 * @return void
	 */
	public function saveOrder($variables){    
	   
   		$books = session('cart');
   		$orderArray = [];
   		foreach($books as $book){
   			$item = [
   				'title' => $book['title'],
	   			'qty' => $book['copies'],
	   			'unit_price'=> $book['unit_price'],
	   			'price' => $book['unit_price']*$book['copies'],
   			];
   			$orderArray[] = $item;
   		}
   		$grandTotal = [
   						'grandtotal'=>$this->getTotalAmount()
   					];
   		$orderArray[] = $grandTotal;
   		$json = json_encode($orderArray, JSON_UNESCAPED_SLASHES);   		

	     \DB::table('orders')->insert([
	     	'fullname'=>$variables['name_first'].' '.$variables['name_last'], 
	     	'email'=>$variables['email_address'], 
	     	'receiver_address'=>'default address',
	     	'cell_number'=>$variables['cell_number'], 
	     	'item_name'=> $variables['item_name'],
	     	'amount'=>$variables['amount'], 
	     	'order_id'=>$variables['custom_int1'], 
	     	'order_details'=>$json,
	     	'paid'=>'no',  
	     	'custom_str1'=>$variables['custom_str1'] 
	     	]);
	}

	/*
	 * Takes the url string from the urlString() method and form and associative array whose key, value pairs will be used in the 
	 * name and value of the html form  respectively
	 *
	 * @return array
	 */	
	public function getRequestArray(){

		$cred = $this->urlStrings();
		$return_url = $cred['return_url'];
		$cancel_url = $cred['cancel_url'];
		$notify_url = $cred['notify_url'];

		$order_id = time(); //change your order_id pattern later
		$totalAmount = $this->getTotalAmount();
		$customStr = $this->randString(20);
		$item_name = '';
		$books = session('cart');
		$x=0;
		foreach($books as $book ){
			$item_name .= $book['title'].' and ';
			$x++;
			if($x==3){
				$item_name .= ' other books';
				break;
			}
		}
		$item_name = chop($item_name, 'and');
		if(auth()->check()){
			$name_first = auth()->user()->firstname;
			$name_last = auth()->user()->lastname;
			$phone_number = '0633641007';
		}else{
			$name_first = 'Anonymous';
			$name_last = 'Anonymous';
			$phone_number = '0633641007';
		}
		$variables=[
		   'merchant_id'=>'10006595',
		   'merchant_key'=>'vn5qdyhrxxiky',
		   'return_url'=>$return_url.$order_id,
		   'cancel_url'=>$cancel_url,
		   'notify_url'=>$notify_url,
		   //Buyer info
		   'name_first'=>$name_first,
		   'name_last'=>$name_last,
		   'email_address'=>'sbtu01@payfast.co.za',
		   'cell_number'=>$phone_number,
		   //Payment info
		   'm_payment_id'=>'01AB',
		   'amount'=>number_format( sprintf( "%.2f", $totalAmount), 2, '.', '' ),
		   //Product info
		   'item_name'=>'Books',
		   'item_description'=>'Advanced Books',
		   'custom_int1'=>$order_id,
		   'custom_str1'=> $customStr,
		   'email_confirmation'=>'1',
		   'confirmation_address'=>'truetochukz@gmail.com',
		 ];

		return $variables;
	}
	/*
	 * calculates the total amount of the users order from the order details stored in the session('cart') global variable
	 * 
	 * @return string
	 */
	public function getTotalAmount(){
      $cart = [];
      if(session('cart')!==null || !empty(session('cart'))){
             $cart = session('cart');
      }
      $grandTotal = 0;
      foreach($cart as $book){
          $price = (float) $book['price'];
          $grandTotal+=$price;
      }
	   return $grandTotal;
    }

    /*
     * Creates a random string which is used as the value of the custom_str1 key of the variable array and eventually used 
     * for the custom_str1 form field.
     * 
     * @return string
     */
    public function randString($key_len){
	  $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	  $chars_array=str_split($chars);
	  $key="";
	  for($i=0;$i<$key_len;$i++)
	  {
	    $randKey=array_rand($chars_array);
	    $key.=$chars_array[$randKey];
	  }
	  return $key;
	}

	/*
	 * This method handles the response from the payment system after a successful transaction has been made.
	 *
	 * @return void
	 */
    public function notify(Request $request){    
    	header( 'HTTP/1.0 200 OK' ); 

    	$cred = $this->urlStrings();
		$return_url = $cred['return_url'];
		$cancel_url = $cred['cancel_url'];
		$notify_url = $cred['notify_url'];

		if($request->has('signature')){
		 	//Log Response Variables
	    	$json = json_encode($request->all(), JSON_UNESCAPED_SLASHES);
	    	$time = $this->getTime(); 
	    	$str = $time."\n".$json;
	    	Storage::disk('local')->append('log_response_variables.tmp', $str); 	    	

			try{

			 	$record = Order::where([
				 	'order_id'=> $request->input('custom_int1'),		 	
				 	'custom_str1'=> $request->input('custom_str1')
				 	])->select('fullname', 'amount')->first();			 	
			 	if(count($record)!=1){
			 		throw new \Exception('Record for order id '. $request->input('order_id').' was not found');			 	
			 	}
			 	$name = $record->fullname;
		        $amount = $record->amount;
		     
				$this->authDomain();
				$this->verifyAmount($amount, $request->input('amount_gross')); //Check amount in database against amount sent from payment system
				$this->contactPaymentSystem($request->all());
				return "Ok notified database updated! :)";
			}catch(\Exception $e){
				$time = $this->getTime(); 
	    		$str = $time." | ". $e->getMessage().' on line '.$e->getLine(); //$e->getFile();
				Storage::disk('local')->append('log_exceptions.tmp', $str);							
				die();
			}
			
		}

    }
 	
 	/*
 	 * Checking if the request is actually coming from the payfast defined domain. Protection from CSRF since am now open
	 *
 	 * @return void
 	 */
    public function authDomain(){
		$validHosts = ['www.payfast.co.za', 'w1w.payfast.co.za', 'w2w.payfast.co.za', 'sandbox.payfast.co.za', 'payfast.dev'];
		$validIps = [];
		foreach( $validHosts as $pfHostname )
		{
		    $ips = gethostbynamel( $pfHostname );
		    if( $ips !== false )
		    {
		        $validIps = array_merge( $validIps, $ips );
		    }
		}
		// Remove duplicates
		$validIps = array_unique( $validIps );
		if( !in_array( $_SERVER['REMOTE_ADDR'], $validIps ) )
		{
		    throw new \Exception('Source IP not Valid');
		}
    }
    /*
     * Check amount for order in db  against amount paid as returned via POST from payment system.
     * 
     * @return void
     */
    public function verifyAmount($amount_in_db, $amount_from_PS){
    	$pfData = $_POST; //Sanitize variables later
		if( abs( floatval( $amount_in_db ) - floatval( $amount_from_PS) )  > 0.01 ){
		    throw new \Exception('Amounts Mismatch db amount= '.$amount_in_db.' and payment system amount = '.$amount_from_PS);
		}
    }
    /*
     * Contact payment system to verify validity of payment. Response should be VALID or INVALID
     * 
     * @return void
     */
    public function contactPaymentSystem($postVariables){
		$url = $this->validateUrl;
		$pfData = $postVariables;
		foreach( $pfData as $key => $val )
		{
		    $pfData[$key] = stripslashes( $val );
		}
		$pfData = $postVariables; // I don't know why they did this after cleaing up;
		$query_string = '';
		 foreach($pfData  as $key=>$value){
		   if($key!='signature'){
		     $query_string .= "$key=".urlencode(trim($value))."&";
		   }
		 }

		 $query_string = chop($query_string, '&');
		 $signature = md5($query_string);

		 if($signature!=$pfData['signature']){
		   throw new \Exception('Invalid Signature');
		 }

		// Create default cURL object
		$ch = curl_init();

		// Use curl_setopt for greater PHP compatibility
		// Base settings
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		// Standard settings
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $query_string );
		
		//$query_string  is the query string formed from the posted variables and values from the payment system excluding the signature 
		//The passphrase is included if you used on your settings in the payment system
		

		// Execute CURL
		$response = curl_exec( $ch );
		curl_close( $ch );

		$lines = explode( "\r\n", $response );
		$verifyResult = trim( $lines[0] );

		//log_verify_response.tmp will store logs of the verification responses of the payment system this could be one of two string: 'VALID' or 'INVALID'		
		$time = $this->getTime();
		$log = $time.'  '.$response;
		Storage::disk('local')->append('log_verify_response.tmp', $log);
		if( strcasecmp( $verifyResult, 'VALID' ) != 0 )
		{
		    throw new \Exception('Data not valid');
		}

		/*Query your database and compare the pf_payment_id in order to verify that the order hasn’t already been processed on your system.*/

		$pfPaymentId = $pfData['pf_payment_id'];
		/*Once you have completed these tests and the data received is valid, check the payment status and handle appropriately.*/
		 if( $pfData ['payment_status'] == 'COMPLETE' ){
		  Order::where([
		  	'order_id'=> $pfData['custom_int1'],
		  	'amount'=> $pfData['amount_gross'],
		  	'custom_str1'=>$pfData['custom_str1'],
		  	])->update(['paid'=>'yes']);
		}else{
			throw new \Exception('Payment_status NOT COMPLETE');		   
		}
    }

    /*
     * For successful transaction the user is returned here
     */
    public function success(Request $request){
    	$order_id = $request->input('order_id');
    	$order = Order::where('order_id', $order_id)->first();
    	session(['cart'=>null]);
    	return view('success')->with('order', $order);
    }
    /*
     * For cancelation of transaction the user is returned here
     */
    public function cancel(){
    	return 'Unsuccessful please buy, we need the money';
    }
}
