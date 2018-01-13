<?php
/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 09/12/2017
 * Time: 04:33
 */

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/UserManager.php';



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
$username =htmlentities(@$_REQUEST['username']);

//build objects
$user = new UserManager();




switch($METHOD){
    case 'login':
       // POST
        //http://localhost:1180/odooApiXmlRpc/api/UserController.php?action=login
        $user->login();
        break;

    case 'get':
        //POST
        //http://localhost:1180/odooApiXmlRpc/api/UserController.php?action=get
        $user->get_userinfo($username);
        break;

    default:

        echo 'Error';
        break;

}

