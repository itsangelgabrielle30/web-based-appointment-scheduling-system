<?php
class AccountData {
    private $AccountID;
    private $FirstName;
    private $LastName;
    private $MiddleName;
    private $Suffix;
    private $Age;
    private $Gender;
    private $Address;
    private $Email;
    private $ContactNo;

    // Constructor
    public function __construct($AccountID, $FirstName, $LastName, $MiddleName, $Suffix, $Age, $Gender, $Address, $Email, $ContactNo) {
        $this->AccountID = $AccountID;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->MiddleName = $MiddleName;
        $this->Suffix = $Suffix;
        $this->Age = $Age;
        $this->Gender = $Gender;
        $this->Address = $Address;
        $this->Email = $Email;
        $this->ContactNo = $ContactNo;
    }

    // Setters
    public function setAccountID($AccountID) { $this->AccountID = $AccountID; }
    public function setFirstName($FirstName) { $this->FirstName = $FirstName; }
    public function setLastName($LastName) { $this->LastName = $LastName; }
    public function setMiddleName($MiddleName) { $this->MiddleName = $MiddleName; }
    public function setSuffix($Suffix) { $this->Suffix = $Suffix; }
    public function setAge($Age) { $this->Age = $Age; }
    public function setGender($Gender) { $this->Gender = $Gender; }
    public function setAddress($Address) { $this->Address = $Address; }
    public function setEmail($Email) { $this->Email = $Email; }
    public function setContactNo($ContactNo) { $this->ContactNo = $ContactNo; }

    // Getters
    public function getAccountID() { return $this->AccountID; }
    public function getFirstName() { return $this->FirstName; }
    public function getLastName() { return $this->LastName; }
    public function getMiddleName() { return $this->MiddleName; }
    public function getSuffix() { return $this->Suffix; }
    public function getAge() { return $this->Age; }
    public function getGender() { return $this->Gender; }
    public function getAddress() { return $this->Address; }
    public function getEmail() { return $this->Email; }
    public function getContactNo() { return $this->ContactNo; }
}

class GetAccountData{
    private $accountID;
    private $email;
    private $password;

    public function __construct($accountID = null, $email = null, $password = null) {
        $this->accountID = $accountID;
        $this->email = $email;
        $this->password = $password;
    }

    public function getAccountID() {
        return $this->accountID;
    }

    public function setAccountID($accountID) {
        $this->accountID = $accountID;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
}



class getAppointmentSchedData
{

private $firstname;
private $lastname;

private $middlename;
private $suffix ; 



public function __construct($firstname, $lastname, $middlename, $suffix)
{

    $this-> firstname = $firstname;
    $this->lastname = $lastname;
    $this->middlename = $middlename;
    $this->suffix = $suffix;

}

public function getFirstname(){
    return $this->firstname;
}
public function setFirstname($firstname){
    $this ->firstname = $firstname;
}

public function getLastname(){
    return $this ->lastname;
}
public function setLastname($lastname){
    $this ->lastname = $lastname;
}
public function getMiddlename(){
    return $this -> middlename;
}
public function setMiddleName($middleName){
    $this -> middlename = $middleName;
}
public function getSuffix(){
    return $this -> suffix;
}
public function setSuffix($suffix){
    $this -> suffix = $suffix;
}




}



class AppointmentSchedData
{
    private $accountNo;
    private $fullname;
    private $contactNo;
    private $email;
    private $address;
    private $dateTimeSchedule;
    private $patientNo;
    private $serviceType;

    public function __construct(
        $accountNo = '',
        $fullname = '',
        $contactNo = '',
        $email = '',
        $address = '',
        $dateTimeSchedule = '',
        $patientNo = '',
        $serviceType = ''
    ) {
        $this->accountNo = $accountNo;
        $this->fullname = $fullname;
        $this->contactNo = $contactNo;
        $this->email = $email;
        $this->address = $address;
        $this->dateTimeSchedule = $dateTimeSchedule;
        $this->patientNo = $patientNo;
        $this->serviceType = $serviceType;
    }

    public function setAccountNo($accountNo) {
        $this->accountNo = $accountNo;
    }

    public function getAccountNo() {
        return $this->accountNo;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function getFullname() {
        return $this->fullname;
    }
    public function setContactNo($contactNo) {
        $this->contactNo = $contactNo;
    }
    public function getContactNo() {
        return $this->contactNo;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setAddress($address) {
        $this->address = $address;
    }
    public function getAddress() {
        return $this->address;
    }


    public function setDateTimeSchedule($dateTimeSchedule) {
        $this->dateTimeSchedule = $dateTimeSchedule;
    }
    public function getDateTimeSchedule() {
        return $this->dateTimeSchedule;
    }

    public function setPatientNo($patientNo) {
        $this->patientNo = $patientNo;
    }

    public function getPatientNo() {
        return $this->patientNo;
    }


    public function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
    }

    // Getter for serviceType
    public function getServiceType() {
        return $this->serviceType;
    }
}



