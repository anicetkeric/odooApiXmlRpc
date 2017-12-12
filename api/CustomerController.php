<?php
/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 09/12/2017
 * Time: 04:33
 */

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/Customer.php';



$METHOD='';
//Action
if(@isset($_REQUEST['action'])) $METHOD=htmlentities($_REQUEST['action']);

//Initialise variable
$name = null;


$user = new Customer();

//get all post variable
$name =htmlentities(@$_REQUEST['name']);


switch($METHOD){
    case 'get':
       // POST
        //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=get
        $user->getCustomer($name);
        break;

    case 'add_customer':
        //POST
        //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=add_customer
        $user->addCustomer();
        break;

    case 'all_customer':
    //http://localhost:1180/odooApiXmlRpc/api/CustomerController.php?action=all_customer
        $user->getAllCustommers();
        break;

    case 'edit_customer':

        $user->editCustomer();
        break;
    default:

        echo 'Error';
        break;

}

