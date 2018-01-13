<?php
/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 09/12/2017
 * Time: 04:33
 */

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/SalesManager.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/domain/Sales.php';



$METHOD='';
//Action
if(@isset($_REQUEST['action'])) $METHOD=htmlentities($_REQUEST['action']);

//Initialise variables
$name = null;
$state= null;
$date_order= null;
 $s_id= null;



//get all post variable
$name =htmlentities(@$_REQUEST['name']);
$state =htmlentities(@$_REQUEST['state']);
$date_order =htmlentities(@$_REQUEST['date_order']);
$s_id =htmlentities(@$_REQUEST['user_id']);

//build objects
$s = new SalesManager();
$sales = new Sales();

$sales->setName($name);
$sales->setState($state);
$sales->setDateOrder($date_order);
$sales->setUserId($s_id);


switch($METHOD){

    case 'all':
    //http://localhost:1180/odooApiXmlRpc/api/SalesController.php?action=all
        $s->getAllSalesOrders($name);
        break;

    default:
        echo 'Error';
        break;

}

