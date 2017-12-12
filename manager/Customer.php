<?php

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/BaseManager.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/Response.php';


class Customer extends Response  {

    private $odoo;

    public function __construct() {
        $this->odoo = new BaseManager();
    }



    function editCustomer() {

        $name = $_POST['name'];

        $key = $_POST['key'];
        $value = $_POST['value'];


        $models = ripcord::client($this->odoo->url . "/xmlrpc/2/object");


        $customer_ids = $models->execute_kw($this->odoo->db, $this->odoo->user_id, $this->odoo->password, 'res.partner', 'search_read', array(array(array('customer', '=', true), array('name', '=', $name))), array(
                    'limit' => 1,
                    'fields' => array('id')));


        foreach ($customer_ids as $uid) {

            $customer_id = $uid;
        }


        $models->execute_kw($this->odoo->db, $this->odoo->user_id, $this->odoo->password, 'res.partner', 'write', array(array($customer_id), array($key => $value)));
    }


   public function getCustomer($name) {

        $criteria=array(array(array('customer', '=', true), array('name', '=', $name)));
        $data= array(
            'limit' => 1,
            'fields' => array(
                'birthdate',
                'phone',
                'function',
                'name',
                'email',
                'address',
                'website',
            ));

        $customers = $this->odoo->search_read('res.partner',$criteria,$data);
        $this->response($customers,200,true);
    }

    function addCustomer() {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $title = $_POST['title'];
        $phone = $_POST['phone'];
        $website = $_POST['website'];
        $birthdate = $_POST['birthdate'];

        $models = ripcord::client($this->odoo->url . "/xmlrpc/2/object");

        //Add user to DB
        $id = $models->execute_kw($this->odoo->db, $this->odoo->user_id, $this->odoo->password, 'res.partner', 'create', array(array('name' => $name,
                'birthdate' => $birthdate,
                'phone' => $phone,
                'function' => $title,
                'email' => $email,
                'website' => $website)));

        //Display Profile 
        $client = $models->execute_kw($this->odoo->db, $this->odoo->user_id, $this->odoo->password, 'res.partner', 'search_read', array(array(array('customer', '=', true), array('name', '=', $name))), array(
                    'limit' => 1,
                    'fields' => array('birthdate', 'phone', 'function', 'name',
                        'email',
                        'address',
                        'website')));


        $this->response($client,200,true);
    }


  public function getAllCustommers() {

        $criteria=array(array(array('customer', '=', true)));
        $data= array(
            'limit' => 100,
            'fields' => array(
                'birthdate',
                'phone',
                'function',
                'name',
                'email',
                'address',
                'website',
            ));

        $customers = $this->odoo->search_read('res.partner',$criteria,$data);
//        var_dump(array(array(array('customer', '=', true))));
        $this->response($customers,200,true);

    }


}
