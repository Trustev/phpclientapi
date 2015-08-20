![alt text](https://app.trustev.com/assets/img/apple-icon-144.png)


#Trustev .NET Libary
- If you are not familiar with Trustev, start with our [Developer Portal](http://www.trustev.com/developers).
- Check out our [API Documentation](http://www.trustev.com/developers#apioverview).
- If you would like to get some test keys to begin integrating please contact integrate@trustev.com

##Requirements
- PHP 5.3+

##Installation
####Download and Unpackage
- Simply download and untar using curl with the command 

			$> curl -L https://github.com/Trustev/NAME=OF_LIB/tarball/latest | tar zx
			
- Or using wget with the command 

			$> wget --no-check-certificate https://github.com/Trustev/NAME=OF_LIB/tarball/latest -O - | tar xz

## Usage
   The Trustev API has been designed to allow users complete control over what information they are sending to us while still ensuring that integration can be done a couple of simple steps

### Simple Trustev Integration
This is simple version of the trustev integration and involves 4 simple steps
```PHP#

// 1. Set-Up the Trustev Api Client with your user credentials
ApiClient::SetUp($userName, $password, $secret);


// 2. Create your case.
// You will need two bits of information for this step
// 		SessionId : This is the SessionId that you have received from the trustev JavaScript 
//					and transferred server-side
// 		CaseNumber : This is a number that you use to uniquely identify this case. It must
//					 be unique.
$kase = new CaseBase(array(
							'SessionId' => $SessionId,
                             'CaseNumber' => $caseNumber
                             ));
						

// Now add any further information you have. The more you give us, the more accurate 
// our decisions.
$kase->Customer = new Customer(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));


// 3. Post this Case to the Trustev Api
$caseReturn = ApiClient::PostCase($kase);


// 4. You can now get your Decision from Trustev base on the case you have given us!
$decision = ApiClient::GetDecision($caseReturn->Id);


// Now its up to you what you do with our decision

```

#### Optional Integration Steps
As mentioned earlier, we also provided detailed Api endpoints for updating specific parts of your Case. These steps can be used where use cases require. See below for some examples.

##### Example : Adding a Customer

```c#

// 1. Set-Up the Trustev Api Client with your user credentials
ApiClient::SetUp($userName, $password, $secret);


// 2. Create your case.
// You will need two bits of information for this step
// 		SessionId : This is the SessionId that you have received from the trustev JavaScript 
//					and transferred server-side
// 		CaseNumber : This is a number that you use to uniquely identify this case. It must
//					 be unique.
$kase = new CaseBase(array(
							'SessionId' => $SessionId,
                             'CaseNumber' => $caseNumber
                             ));

// 3. Post this Case to the Trustev Api
$returnCase = ApiClient::PostCase($kase);


// 4. You may now want to add a Customer to Case you have already added.
//    First lets create the customer.
$customer = new Customer(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

//    Now we can go ahead and at the customer to the case we added earlier.
$returnCustomer = ApiClient::PostCustomer($returnCase->Id, $customer);


// 5. You can now continue as normal and get the Decision this case including
//    the new customer you have added
$decision = ApiClient::GetDecision($returnCase->Id);


// Now its up to you what you do with our decision

```

##### Example : Updating a Transaction

```c#

// 1. Set-Up the Trustev Api Client with your user credentials
ApiClient::SetUp($userName, $password, $secret);


// 2. Create your case.
// You will need two bits of information for this step
// 		SessionId : This is the SessionId that you have received from the trustev JavaScript 
//					and transferred server-side
// 		CaseNumber : This is a number that you use to uniquely identify this case. It must
//					 be unique.
$kase = new CaseBase(array(
							'SessionId' => $SessionId,
                             'CaseNumber' => $caseNumber
                             ));
$kase.Transaction = new TransactionBase(array(
							'Currency' => "USD",
                             'TotalTransactionValue' => 10
                             ));


// 3. Post this Case to the Trustev Api
$returnCase = ApiClient::PostCase($kase);


// 4. Now, say the value of this transaction changes,
//	  We provide the functionality to update the transaction you have already added
//	  Just rebuild the transaction again with the new information
$transaction = new TransactionBase(array(
							'Currency' => "USD",
                             'TotalTransactionValue' => 2000
                             ));

//    Now we can go ahead and at the customer to the case we added earlier.
$returnTransaction = ApiClient::UpdateTransaction($returnCase->Id, $transaction);


// 5. You can now continue as normal and get the Decision this case including
//    the updated transaction you have added
$decision = ApiClient::GetDecision($returnCase->Id);


// Now its up to you what you do with our decision

```

We provide similar functions i.e. Post, Update and Get for every Sub Entity of the Case Object.