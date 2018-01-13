<?php

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/BaseManager.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/Response.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/domain/Sales.php';


class SalesManager extends Response  {

    private $odoo;

    public function __construct() {
        $this->odoo = new BaseManager();
    }





  public function getAllSalesOrders($name) {

        $criteria=array(array(array('customer', '=', true), array('name', '=', $name)));
        $data= array(
            'limit' => 200,
            'fields' => array(
                'name',
                'state',
                'date_order',
                'user_id',
            ));

        $customers = $this->odoo->search_read('sale.order',$criteria,$data);
       var_dump(array(array(array('customer', '=', true))));
        $this->response($customers,200,true);

      }



}
