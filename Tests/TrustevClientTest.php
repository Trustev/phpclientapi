<?php
namespace Trustev;
use PHPUnit\Framework\TestCase;

class TrustevClientTest extends TestCase
{
    public $userName = "test-FancyTees";
    public $password = "e8a9e408358249a38c62f1e45f90f7d0";
    public $secret = "3b2339e75649442297d5176321a52672";

    private function RandomGUID()
	{
	    if (function_exists('com_create_guid') === true)
	    {
	        return trim(com_create_guid(), '{}');
	    }

    	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}


#REGION CASE TESTS 
    public function testPOSTCase()
    {

        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $this->assertNotEmpty($returnCase->Id);
        $this->assertNotEmpty($returnCase->Customer);
        $this->assertNotEmpty($returnCase->Customer->Id);
        $this->assertEquals($kase->Customer->FirstName, $returnCase->Customer->FirstName);
        $this->assertEquals($kase->Customer->LastName, $returnCase->Customer->LastName);
    }


    public function testGETCase()
    {
    	
        ApiClient::SetUp($this->userName, $this->password, $this->secret);
        
        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $getCase = ApiClient::GetCase($returnCase->Id);
        
        $this->assertNotEmpty($getCase->Id);
        $this->assertNotEmpty($getCase->Customer);
        $this->assertNotEmpty($getCase->Customer->Id);
        $this->assertEquals($kase->Customer->FirstName, $getCase->Customer->FirstName);
        $this->assertEquals($kase->Customer->LastName, $getCase->Customer->LastName);
    }

    public function testPUTCase()
    {
        ApiClient::SetUp($this->userName, $this->password, $this->secret);
        
        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);
        $returnCase->Customer->FirstName = "Jane";


        

        $getCase = ApiClient::UpdateCase($returnCase->Id, $returnCase);
        
        $this->assertNotEmpty($getCase->Id);
        $this->assertNotEmpty($getCase->Customer);
        $this->assertNotEmpty($getCase->Customer->Id);
        $this->assertEquals($returnCase->Customer->FirstName, $getCase->Customer->FirstName);
        $this->assertEquals($returnCase->Customer->LastName, $getCase->Customer->LastName);
    }

	/**
     * @expectedException Trustev\Exceptions\TrustevGeneralException
     * @expectedExceptionMessage Exception while executing GetCase
     */
    public function testGETCasewithIncorrectCaseId()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $getCase = ApiClient::GetCase($this->RandomGUID());	
    }

#ENDREGION

#REGION DECISION TESTS
    public function testPOSTDefaultCaseType()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        
        $returnCase = ApiClient::PostCase($kase);

        $this->assertNotEmpty($returnCase->Id);
        $this->assertEquals($returnCase->CaseType, Entities\CaseTypeEnum::Default);
    }

    public function testPOSTAccountCreationCaseType()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID(),
                             'CaseType' => Entities\CaseTypeEnum::AccountCreation,
                             ));
        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe",
                                        'AccountNumber' => $this->RandomGUID()
                                    ));
        
        $returnCase = ApiClient::PostCase($kase);
        
        $this->assertNotEmpty($returnCase->Id);
        $this->assertEquals($returnCase->CaseType, Entities\CaseTypeEnum::AccountCreation);
        $this->assertEquals($returnCase->Customer->AccountNumber, $kase->Customer->AccountNumber);
    }

    public function testPOSTApplicationCaseType()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID(),
                             'CaseType' => Entities\CaseTypeEnum::Application,
                             ));
        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe",
                                        'AccountNumber' => $this->RandomGUID()
                                    ));
        
        $returnCase = ApiClient::PostCase($kase);
        
        $this->assertNotEmpty($returnCase->Id);
        $this->assertEquals($returnCase->CaseType, Entities\CaseTypeEnum::Application);
        $this->assertEquals($returnCase->Customer->AccountNumber, $kase->Customer->AccountNumber);
    }

#ENDREGION    

#REGION DECISION TESTS
    public function testGETDecision()
    {
    	
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $decision = ApiClient::GetDecision($returnCase->Id);
        

        $this->assertNotEmpty($decision->Id);
    }

    public function testDecisionPASS()
    {
    	
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID() . "pass"
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        

        $decision = (ApiClient::GetDecision($returnCase->Id));

        $decisionObject = new Entities\DecisionBase($decision);

        $this->assertEquals($decision->Result, Entities\DecisionResultEnum::Pass);
    }


    public function testDecisionFLAG()
    {
    	
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID() . "flag"
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        

        $decision = (ApiClient::GetDecision($returnCase->Id));

        $decisionObject = new Entities\DecisionBase($decision);

        $this->assertEquals($decision->Result, Entities\DecisionResultEnum::Flag);
    }

    public function testDecisionFAIL()
    {
    	
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID() . "fail"
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        

        $decision = (ApiClient::GetDecision($returnCase->Id));

        $decisionObject = new Entities\DecisionBase($decision);

        $this->assertEquals($decision->Result, Entities\DecisionResultEnum::Fail);
    }
#ENDREGION


#REGION DECISION TESTS
    public function testGETDetailedDecision()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $detaileddecision = ApiClient::GetDetailedDecision($returnCase->Id);
        
        $this->assertNotEmpty($detaileddecision->Id);
    }


    /**
     * @expectedException Trustev\Exceptions\TrustevGeneralException
     * @expectedExceptionMessage Exception while executing GetDetailedDecision
     */
    public function testGETInvalidDetailedDecision()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        
        $detaileddecision = ApiClient::GetDetailedDecision($this->RandomGUID());
        
    }
#ENDREGION



#REGION CUSTOMER TESTS
    public function testPOSTCustomer()
    {
    	
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $returnCase = ApiClient::PostCase($kase);

        $customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));
       
        $returnCaseCustomer = ApiClient::PostCustomer($returnCase->Id, $customer);

        $finalReturnCase = ApiClient::GetCase($returnCase->Id);
        
        $this->assertEquals($finalReturnCase->Id, $returnCase->Id);
        $this->assertEquals($customer->FirstName, $finalReturnCase->Customer->FirstName);
    }


    public function testPUTCustomer()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));


        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $kase->Customer->FirstName = "Jane"; 
        $kase->Customer->LastName = "Derp";       
        $returnCaseCustomer = ApiClient::UpdateCustomer($returnCase->Id, $kase->Customer);

        $finalReturnCase = ApiClient::GetCase($returnCase->Id);
        
        $this->assertEquals($finalReturnCase->Id, $returnCase->Id);
        $this->assertEquals($finalReturnCase->Customer->FirstName, $kase->Customer->FirstName);
        $this->assertEquals($finalReturnCase->Customer->LastName, $kase->Customer->LastName);
    }


    public function testGETCustomer()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));


        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        
        $returnCaseCustomer = ApiClient::GetCustomer($returnCase->Id);
        
        
        $this->assertEquals($returnCaseCustomer->FirstName, $kase->Customer->FirstName);
        $this->assertEquals($returnCaseCustomer->LastName, $kase->Customer->LastName);
    }
#ENDREGION

#REGION Case Status TESTS
    public function testPOSTCaseStatus()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $returnCase = ApiClient::PostCase($kase);

        $caseStatus = new Entities\CaseStatusBase(array(
                            'Status' => Entities\CaseStatusTypeEnum::OnHoldReview,
                             'Comment' => "The comment"
                             ));

        $caseStatusReturn = ApiClient::PostCaseStatus($returnCase->Id, $caseStatus);


        $this->assertNotEmpty($caseStatusReturn->Id);
        $this->assertEquals($caseStatusReturn->Status, Entities\CaseStatusTypeEnum::OnHoldReview);
        $this->assertEquals($caseStatusReturn->Comment, "The comment");
    }

    public function testGETCaseStatus()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $returnCase = ApiClient::PostCase($kase);

        $caseStatusReturn = ApiClient::GetCaseStatus($returnCase->Id, $returnCase->Statuses[0]->Id);

        $this->assertNotEmpty($caseStatusReturn->Id);
        $this->assertEquals($caseStatusReturn->Status, Entities\CaseStatusTypeEnum::Placed);
    }


    public function testGETCaseStatuses()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $returnCase = ApiClient::PostCase($kase);

        $caseStatus = new Entities\CaseStatusBase(array(
                            'Status' => Entities\CaseStatusTypeEnum::OnHoldReview,
                             'Comment' => "The comment"
                             ));

        $caseStatusPOSTReturn = ApiClient::PostCaseStatus($returnCase->Id, $caseStatus);

        $caseStatusReturn = ApiClient::GetCaseStatuses($returnCase->Id);
                
        $this->assertNotEmpty($caseStatusReturn);
        $this->assertEquals(sizeof((array)$caseStatusReturn), 2);
        
    }

    /**
     * @expectedException Trustev\Exceptions\TrustevGeneralException
     * @expectedExceptionMessage Exception while executing GetCaseStatuses
     */
    public function testGETInvalidCaseStatuses()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $caseStatusReturn = ApiClient::GetCaseStatuses($this->RandomGUID());        
    }

#ENDREGION


#REGION CUSTOMER ADDRESS TESTS

    public function testPOSTCustomerAddress()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $address = new Entities\AddressBase(array(
                                        'City' => "Cork City"
                                    ));
       
        $returnCaseCustomerAddress = ApiClient::PostCustomerAddress($returnCase->Id, $address);
        
        $this->assertEquals($returnCaseCustomerAddress->City, $address->City);
    }

    public function testGETCustomerAddress()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $kase->Customer->Addresses = array(new Entities\AddressBase(array(
                                        'City' => "Cork City"
                                    )));

        $returnCase = ApiClient::PostCase($kase);
        $returnCaseCustomerAddress = ApiClient::GetCustomerAddress($returnCase->Id, $returnCase->Customer->Addresses[0]->Id);
        
        $this->assertEquals($returnCaseCustomerAddress->City, $kase->Customer->Addresses[0]->City);
    }


    /**
     * @expectedException Trustev\Exceptions\TrustevGeneralException
     * @expectedExceptionMessage Exception while executing GetCustomerAddresses
     */
    public function testGETCustomerAddresses()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        

        $returnCase = ApiClient::PostCase($kase);
        $returnCaseCustomerAddress = ApiClient::GetCustomerAddresses($returnCase->Id);
        
        $this->assertEmpty($returnCaseCustomerAddress->Customer->Addresses);
        
    }
#ENDREGION


#REGION CUSTOMER EMAIL TESTS
    public function testPOSTCustomerEmail()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $email = new Entities\EmailBase(array(
                                        'EmailAddress' => "John@doe.com"
                                    ));
        $returnCustomerEmail = ApiClient::PostEmail($returnCase->Id, $email);
        
        $this->assertEquals($returnCustomerEmail->EmailAddress, $email->EmailAddress);
        
    }


    public function testPUTCustomerEmail()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));
        $kase->Customer->Emails = array(new Entities\EmailBase(array(
                                        'EmailAddress' => "John@doe.com"
                                    )));

        $returnCase = ApiClient::PostCase($kase);

        $email = new Entities\EmailBase(array(
                                        'EmailAddress' => "John@doe.com"
                                    ));

        $returnPUTEmail = ApiClient::UpdateEmail($returnCase->Id, $email, $returnCase->Customer->Emails[0]->Id);

        $this->assertNotEmpty($returnPUTEmail->Id);
        $this->assertEquals($returnPUTEmail->EmailAddress, $email->EmailAddress);
    }


    public function testGETCustomerEmail()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));
        $kase->Customer->Emails = array(new Entities\EmailBase(array(
                                        'EmailAddress' => "John@doe.com"
                                    )));

        $returnCase = ApiClient::PostCase($kase);

        $returnEmail = ApiClient::GetEmail($returnCase->Id, $returnCase->Customer->Emails[0]->Id);

        $this->assertNotEmpty($returnEmail->Id);
        $this->assertEquals($kase->Customer->Emails[0]->EmailAddress, $returnEmail->EmailAddress);
        
    }

    public function testGETNULLCustomerEmail()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Customer = new Entities\CustomerBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));
        $kase->Customer->Emails = array(new Entities\EmailBase(array(
                                        'EmailAddress' => "John@doe.com"
                                    )));

        $returnCase = ApiClient::PostCase($kase);

        $returnEmail = ApiClient::GetEmail($returnCase->Id, $returnCase->Customer->Emails[0]->Id);

        $this->assertNotEmpty($returnEmail->Id);
        $this->assertEquals($kase->Customer->Emails[0]->EmailAddress, $returnEmail->EmailAddress);
        
    }
#ENDREGION
#REGION TRANSACTION ADDRESS TESTS

    public function testPOSTTransactionAddress()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $returnCase = ApiClient::PostCase($kase);

        $address = new Entities\AddressBase(array(
                                        'City' => "Cork City"
                                    ));
       
        $returnCaseTransactionAddress = ApiClient::PostTransactionAddress($returnCase->Id, $address);
        
        $this->assertEquals($returnCaseTransactionAddress->City, $address->City);
    }

    public function testGETTransactionAddress()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        $kase->Transaction->Addresses = array(new Entities\AddressBase(array(
                                        'City' => "Cork City"
                                    )));

        $returnCase = ApiClient::PostCase($kase);
        $returnCaseTransactionAddress = ApiClient::GetTransactionAddress($returnCase->Id, $returnCase->Transaction->Addresses[0]->Id);
        
        $this->assertEquals($returnCaseTransactionAddress->City, $kase->Transaction->Addresses[0]->City);
    }


    /**
     * @expectedException Trustev\Exceptions\TrustevGeneralException
     * @expectedExceptionMessage Exception while executing GetTransactionAddresses
     */
    public function testGETTransactionAddresses()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionBase(array(
                                        'FirstName' => "John",
                                        'LastName' => "Doe"
                                    ));

        

        $returnCase = ApiClient::PostCase($kase);
        $returnCaseTransactionAddress = ApiClient::GetTransactionAddresses($returnCase->Id);
        
        $this->assertEmpty($returnCaseTransactionAddress->Transaction->Addresses);
        
    }
#ENDREGION

#REGION PAYMENT TESTS
    public function testPOSTPayment()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        
        $returnCase = ApiClient::PostCase($kase);

        $payment = new Entities\PaymentBase(array(
                                        'PaymentType' => Entities\PaymentTypeEnum::CreditCard,
                                        'BINNumber' => '123456'
                                    ));

        $returnPayment = ApiClient::PostPayment($returnCase->Id, $payment);
        
        $this->assertNotEmpty($returnPayment->Id);
        $this->assertEquals($payment->BINNumber, $returnPayment->BINNumber);
        
    }


    public function testPUTPayment()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Payments = array(new Entities\PaymentBase(array(
                                        'PaymentType' => Entities\PaymentTypeEnum::CreditCard,
                                        'BINNumber' => '123456'
                                    )));

        
        $returnCase = ApiClient::PostCase($kase);

        $payment = new Entities\PaymentBase(array(
                                        'PaymentType' => Entities\PaymentTypeEnum::CreditCard,
                                        'BINNumber' => '654321'
                                    ));

        $returnPayment = ApiClient::UpdatePayment($returnCase->Id, $payment, $returnCase->Payments[0]->Id);
        
        $this->assertNotEmpty($returnPayment->Id);
        $this->assertEquals($payment->BINNumber, $returnPayment->BINNumber);

    }

    public function testGETPayment()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Payments = array(new Entities\PaymentBase(array(
                                        'PaymentType' => Entities\PaymentTypeEnum::CreditCard,
                                        'BINNumber' => '123456'
                                    )));

        
        $returnCase = ApiClient::PostCase($kase);

        $returnPayment = ApiClient::GetPayment($returnCase->Id, $returnCase->Payments[0]->Id);
        
        $this->assertNotEmpty($returnPayment->Id);
        $this->assertEquals($kase->Payments[0]->BINNumber, $returnPayment->BINNumber);
        
    }

#ENDREGION


#REGION TRANSACTION ITEM TESTS
    public function testPOSTTransactionItem()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionItemBase();
        
        $returnCase = ApiClient::PostCase($kase);

        $item = new Entities\TransactionItemBase(array(
                            'Name' => 'Harry Potter Nimbus 2000',
                             'ItemValue' => '1000'
                             ));

        $returnItem = ApiClient::PostTransactionItem($returnCase->Id, $item);
        
        $this->assertNotEmpty($returnItem->Id);
        $this->assertEquals($item->Name, $returnItem->Name);
        $this->assertEquals($item->ItemValue, $returnItem->ItemValue);
        
    }


    public function testPUTTransactionItem()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionItemBase();
        
        $returnCase = ApiClient::PostCase($kase);

        $item = new Entities\TransactionItemBase(array(
                            'Name' => 'Harry Potter Nimbus 2000',
                             'ItemValue' => '1000'
                             ));

        $returnItem = ApiClient::PostTransactionItem($returnCase->Id, $item);
        
        $this->assertNotEmpty($returnItem->Id);
        $this->assertEquals($item->Name, $returnItem->Name);
        $this->assertEquals($item->ItemValue, $returnItem->ItemValue);

    }

    public function testGETTransactionItem()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionBase();
        
        $kase->Transaction->Items = array(new Entities\TransactionItemBase(array(
                            'Name' => 'Harry Potter Nimbus 2000',
                             'ItemValue' => '1000'
                             )));

        
        $returnCase = ApiClient::PostCase($kase);
        

        $returnItem = ApiClient::GetTransactionItem($returnCase->Id, $returnCase->Transaction->Items[0]->Id);
                
        $this->assertNotEmpty($returnItem->Id);
        $this->assertEquals($kase->Transaction->Items[0]->Name, $returnItem->Name);
        $this->assertEquals($kase->Transaction->Items[0]->ItemValue, $returnItem->ItemValue);
        
    }

    public function testGETTransactionItems()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));

        $kase->Transaction = new Entities\TransactionBase();
        
        $kase->Transaction->Items = array(new Entities\TransactionItemBase(array(
                            'Name' => 'Harry Potter Nimbus 2000',
                             'ItemValue' => '1000'
                             )));

        
        $returnCase = ApiClient::PostCase($kase);
        

        $returnItem = ApiClient::GetTransactionItems($returnCase->Id);
                
        $this->assertNotEmpty(((array)$returnItem)[0]->Id);
        $this->assertEquals($kase->Transaction->Items[0]->Name, ((array)$returnItem)[0]->Name);
        $this->assertEquals($kase->Transaction->Items[0]->ItemValue, ((array)$returnItem)[0]->ItemValue);
        
    }


    /**
     * @expectedException Trustev\Exceptions\TrustevGeneralException
     * @expectedExceptionMessage Exception while executing GetTransactionItems
     */
    public function testGETNULLTransactionItems()
    {
        
        ApiClient::SetUp($this->userName, $this->password, $this->secret);

        $kase = new Entities\CaseBase(array(
                            'SessionId' => $this->RandomGUID(),
                             'CaseNumber' => $this->RandomGUID()
                             ));
        
        $returnCase = ApiClient::PostCase($kase);
        

        $returnItem = ApiClient::GetTransactionItems($returnCase->Id);
                
        $this->assertNotEmpty(((array)$returnItem)[0]->Id);
        
    }
#ENDREGION

}