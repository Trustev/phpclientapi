![alt text](https://app.trustev.com/assets/img/apple-icon-144.png)


#Trustev PHP Libary
- If you are not familiar with Trustev, start with our [Developer Portal](http://www.trustev.com/developers).
- Check out our [API Documentation](http://www.trustev.com/developers#apioverview).
- If you would like to get some Test API Keys to begin Integrating, please contact our Integration Tema: integrate@trustev.com

##Requirements
- PHP 5.3+

##Installation
####Composer
You can install this via [Composer](http://getcomposer.org/). Add this to your `composer.json`:

````json
{
"require" : {
	"trustev/phpclientapi" : "v0.2"
	}
}

````

Then install via:

```bash
composer install
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

####Download and Unpackage
- Simply download and untar using curl with the command 

			$> curl -L https://github.com/Trustev/phpclientapi/tarball/latest | tar zx
			
- Or using wget with the command 

			$> wget --no-check-certificate https://github.com/Trustev/phpclientapi/tarball/latest -O - | tar xz

## Usage
   The Trustev API has been designed to allow users complete control over what information they are sending to us, while still ensuring that the Trustev Integration can be done in a couple of simple steps.

### Simple Trustev Integration
This is a simple version of the Trustev Integration and it involves 4 simple steps.

```PHP

// 1. Set-Up the Trustev Api Client with your user credentials
ApiClient::SetUp($userName, $password, $secret);


// 2. Create your case and POST this Case to the Trustev API.
// You will need two bits of information for this step
// 		SessionId : This is the SessionId that you have received from the Trustev JavaScript (Trustev.js)
//					and transferred server-side.
// 		CaseNumber : This is a number that you use to uniquely identify this Case - we recommend using your internal Order Number for the Case Number. 
					It must be unique per Case request.
$kase = new CaseBase(array(
							'SessionId' => $SessionId,
                             'CaseNumber' => $caseNumber
                             ));
						

// Now add any further information you have. The more you give us, the more accurate 
// our Decisions.
$kase->Customer = new Customer(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));


// Post this Case to the Trustev Api
$caseReturn = ApiClient::PostCase($kase);


// 3. You can now get your Decision from Trustev based on the Case you have given us
$decision = ApiClient::GetDecision($caseReturn->Id);


// 4. Now it's up to you what to do with our Decision, and then updating the Case Status with what the order outcome was.
$status = new Status(array(
							'Status' => 0,
							'Comment' => "Order Completed Successfully"
						));
$statusReturn = ApiClient::PostCaseStatus($caseReturn->Id, $status);


```

#### Optional Integration Steps
We also provide detailed API endpoints for updating specific parts of your Case. These steps can be used where use cases require. See below for some examples.

##### Example : Adding a Customer

```PHP

// 1. Set-Up the Trustev Api Client with your user credentials
ApiClient::SetUp($userName, $password, $secret);


// 2. Create your case.
// You will need two bits of information for this step
// 		SessionId : This is the SessionId that you have received from the Trustev JavaScript (Trustev.js)
//					and transferred server-side.
// 		CaseNumber : This is a number that you use to uniquely identify this Case - we recommend using your internal Order Number for the Case Number. 
					It must be unique per Case request.
$kase = new CaseBase(array(
							'SessionId' => $SessionId,
                             'CaseNumber' => $caseNumber
                             ));

// 3. Post this Case to the Trustev API
$returnCase = ApiClient::PostCase($kase);


// 4. You may now want to add a Customer to the Case you have already added.
//    First let's create the customer.
$customer = new Customer(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

//    Now we can go ahead and add the Customer to the Case we added earlier.
$returnCustomer = ApiClient::PostCustomer($returnCase->Id, $customer);


// 5. You can now continue as normal and get the Decision of this Case including
//    the new Customer you have added
$decision = ApiClient::GetDecision($returnCase->Id);


// 6. Now it's up to you what to do with our Decision, and then updating the Case Status with what the order outcome was.
$status = new Status(array(
							'Status' => 0,
							'Comment' => "Order Completed Successfully"
						));
$statusReturn = ApiClient::PostCaseStatus($caseReturn->Id, $status);

```

##### Example : Updating a Transaction

```PHP

// 1. Set-Up the Trustev Api Client with your user credentials
ApiClient::SetUp($userName, $password, $secret);


// 2. Create your case.
// You will need two bits of information for this step
// 		SessionId : This is the SessionId that you have received from the Trustev JavaScript (Trustev.js)
//					and transferred server-side.
// 		CaseNumber : This is a number that you use to uniquely identify this Case - we recommend using your internal Order Number for the Case Number. 
					It must be unique per Case request.
$kase = new CaseBase(array(
							'SessionId' => $SessionId,
                             'CaseNumber' => $caseNumber
                             ));
							 
$kase->Transaction = new TransactionBase(array(
							'Currency' => "USD",
                             'TotalTransactionValue' => 10
                             ));


// 3. Post this Case to the Trustev Api
$returnCase = ApiClient::PostCase($kase);


// 4. Now, say the value of this Transaction changes,
//	  We provide the functionality to update the Transaction you have already added.
//	  Just rebuild the Transaction again with the new information
$transaction = new TransactionBase(array(
							'Currency' => "USD",
                             'TotalTransactionValue' => 2000
                             ));

//    Now we can go ahead and add the Transaction to the Case we created earlier.
$returnTransaction = ApiClient::UpdateTransaction($returnCase->Id, $transaction);


// 5. You can now continue as normal and get the Decision of this Case including
//    the updated Transaction you have added.
$decision = ApiClient::GetDecision($returnCase->Id);


// Now it's up to you what to do with our Decision, and then updating the Case Status with what the order outcome was.
$status = new Status(array(
							'Status' => 0,
							'Comment' => "Order Completed Successfully"
						));
$statusReturn = ApiClient::PostCaseStatus($caseReturn->Id, $status);

```

We provide similar functions i.e. Post (POST), Update (PUT) and Get (GET) for every Sub Entity of the Case Object.