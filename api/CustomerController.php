<?php
/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 09/12/2017
 * Time: 04:33
 */

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/CustomerManager.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/domain/Customer.php';



$METHOD='';
//Action
if(@isset($_REQUEST['action'])) $METHOD=htmlentities($_REQUEST['action']);

//Initialise variables
$id = null;
$name = null;
 $email= null;
 $title= null;
 $phone= null;
 $website= null;
 $birthdate= null;



//get all post variable
$id =htmlentities(@$_REQUEST['id']);
$name =htmlentities(@$_REQUEST['name']);
$email =htmlentities(@$_REQUEST['email']);
$title =htmlentities(@$_REQUEST['title']);
$phone =htmlentities(@$_REQUEST['phone']);
$website =htmlentities(@$_REQUEST['website']);
$birthdate =htmlentities(@$_REQUEST['birthdate']);

//build objects
$manager = new CustomerManager();
$customer = new Customer();

$customer->setId(intval($id));
$customer->setName($name);
$customer->setEmail($email);
$customer->setTitle($title);
$customer->setPhone($phone);
$customer->setWebsite($website);
$customer->setBirthdate($birthdate);




switch($METHOD){
    case 'get':
       // POST
        //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=get
        $manager->getCustomer($name);
        break;

    case 'add_customer':
        //POST
        //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=add_customer
        $manager->addCustomer($customer);
        break;

    case 'put':
        //POST
        //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=put
        $manager->edit($customer);
        break;

    case 'all_customer':
    //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=all_customer
        $manager->getAllCustommers();
        break;

    case 'edit_customer':

        $manager->editCustomer();
        break;
    case 'delete':
        $manager->delete($customer->getId());
        break;
    
    default:

        echo 'Error';
        break;

}

