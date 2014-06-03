<?php 
/**
 * Amazon Direct Payment API Component class file.
 *
 * @filesource
 * @copyright        Mariano Iglesias - mariano@cricava.com
 * @link            http://www.marianoiglesias.com.ar Mariano Iglesias
 * @package            cake
 * @subpackage        cake.controllers.components
 */
# PROPER URL FOR CHECKING TRANSACTIONS TESTING IS payments-sandbox.amazon.com/ (NOT sellercentral!)

#App::import('Vendor','pear',array('file'=>'pear.inc.php'));



class AmazonComponent extends Object
{
    	var $name = 'Amazon';
    	var $components = array('Session');

	function startup(&$controller)
	{
		if(!defined('AWS_ACCESS_KEY_ID')) 
		{
			define('AWS_ACCESS_KEY_ID', 'AKIAICPP44OGGA2WBJMA');
		}
		if(!defined('AWS_SECRET_ACCESS_KEY'))
		{
			define('AWS_SECRET_ACCESS_KEY', 'aFvqWlRzo/XwIbujm2rGssEASgLYCYSUg3yxlYsk');
		}
		if(empty($controller->livesite) && !defined("AWS_SANDBOX"))
		{
			define('AWS_SANDBOX', 1); 
		}
		App::import('Vendor','pear',array('file'=>'pear.inc.php'));
	}

# 
	function authorize($purchase_id, $amount = 0)
	{
		require_once('Amazon/CBUI/CBUISingleUsePipeline.php');

		# MISSING SIGNATURE! but how generate?

		$uniqueID = time() . rand(10000,99999);
		$pipeline = new Amazon_FPS_CBUISingleUsePipeline(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
		$REDIRECT_URL = "https://{$_SERVER['HTTP_HOST']}/checkout/receipt_amazon/$purchase_id/pay";
		$pipeline->setMandatoryParameters($uniqueID, $REDIRECT_URL, $amount);

		//optional parameters
		$pipeline->addParameter("currencyCode", "USD");
		$pipeline->addParameter("paymentReason", "Harmony Designs Order #$purchase_id");
		
		$authURL = $pipeline->getURL();

		error_log("AUTH_URL=$authURL");

		return $authURL; # URL cannot be modified except through addParameter()
	}

	function charge($purchase_id, $price, $token)
	{ # Called by redirect url handler.
		# Token is what we get from amazon to identify the user/transaction.
		require_once('Amazon/FPS/Model/Amount.php');
		require_once('Amazon/FPS/Client.php');
		require_once('Amazon/FPS/Model/PayRequest.php');

		$amount = new Amazon_FPS_Model_Amount();
		$amount->setCurrencyCode("USD");
		$amount->setValue($price); //set the transaction amount here;

		$request =  new Amazon_FPS_Model_PayRequest();
		$request->setSenderTokenId($token);//set the proper senderToken here.
		$request->setTransactionAmount($amount);
		$request->setCallerReference($purchase_id); //set the unique caller reference here.

		$service = new Amazon_FPS_Client(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);

		error_log("CHARGING USING ".AWS_ACCESS_KEY_ID.", ".AWS_SECRET_ACCESS_KEY);

	      try {
	              $response = $service->pay($request);

	                #echo ("Service Response\n");
	                #echo ("=============================================================================\n");
	
	                #echo("        PayResponse\n");
	                if ($response->isSetPayResult()) { 
	                    #echo("            PayResult\n");
	                    $payResult = $response->getPayResult();
	                    if ($payResult->isSetTransactionId()) 
	                    {
			    	return true;
	                        #echo("                TransactionId\n");
	                        #echo("                    " . $payResult->getTransactionId() . "\n");
	                    }
	                    if ($payResult->isSetTransactionStatus()) 
	                    {
	                        #echo("                TransactionStatus\n");
	                        #echo("                    " . $payResult->getTransactionStatus() . "\n");
	                    }
	                } 
	                if ($response->isSetResponseMetadata()) { 
	                    #echo("            ResponseMetadata\n");
	                    $responseMetadata = $response->getResponseMetadata();
	                    if ($responseMetadata->isSetRequestId()) 
	                    {
	                        #echo("                RequestId\n");
	                        #echo("                    " . $responseMetadata->getRequestId() . "\n");
	                    }
	                } 

			return true;
	
	     } catch (Amazon_FPS_Exception $ex) {
	         echo("Caught Exception: " . $ex->getMessage() . "\n");
	         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
	         echo("Error Code: " . $ex->getErrorCode() . "\n");
	         echo("Error Type: " . $ex->getErrorType() . "\n");
	         echo("Request ID: " . $ex->getRequestId() . "\n");
	         echo("XML: " . $ex->getXML() . "\n");

		 return $ex->getMessage();
	     }


	}


}
