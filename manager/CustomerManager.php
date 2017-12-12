<?php

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/BaseManager.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/Response.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/domain/Customer.php';


class CustomerManager extends Response  {

    private $odoo;

    public function __construct() {
        $this->odoo = new BaseManager();
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

   public function addCustomer(Customer $customer) {

       $data= array(array('name' => $customer->getName(),
           'birthdate' => $customer->getBirthdate(),
           'phone' => $customer->getPhone(),
           'function' => $customer->getTitle(),
           'email' => $customer->getEmail(),
           'website' => $customer->getWebsite()));

       $id = $this->odoo->create('res.partner',$data);

       if(intval($id)){
           $this->getCustomer($customer->getName());
       }else $this->response(null,200,true);

    }

    public function edit(Customer $customer) {

        $data= array(array($customer->getId()), array('name' => $customer->getName(),
            'birthdate' => $customer->getBirthdate(),
            'phone' => $customer->getPhone(),
            'function' => $customer->getTitle(),
            'email' => $customer->getEmail(),
            'website' => $customer->getWebsite()));

       $res = $this->odoo->edit('res.partner',$data,$customer->getId());

        $this->response($res,200,true);

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

     public function delete($id) {
    //  Response: {"status": "200 OK","state": true,"result": []}
      $customers = $this->odoo->delete('res.partner',$id);
      $this->response($customers,200,true);

    }


}
