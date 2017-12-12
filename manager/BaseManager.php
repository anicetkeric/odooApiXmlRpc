<?php

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/config.php';

class BaseManager {

    public $username;
    public $password;
    public $common;
    public $uid;
    public $url;
    public $db;

  function __construct() {
        $this->getRessources();

        //Authentication odoo user
        $this->common = ripcord::client(URL . "/xmlrpc/2/common");
        $this->common->version();
        $this->user_id = $this->common->authenticate($this->db, $this->username,$this->password, array());

        return $this->user_id;
     }

    function getRessources() {
        $this->url = URL;
        $this->db = DB;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;
    }

    public function search_read($model, $criteria,$data=null)
    {
        $res = ripcord::client($this->url . "/xmlrpc/2/object");
        $result = $res->execute_kw($this->db, $this->user_id, $this->password, $model, 'search_read', $criteria,$data);
        return $result;
    }

    public function create($model,$data)
    {
        $res = ripcord::client($this->url . "/xmlrpc/2/object");
        $id =  $res->execute_kw($this->db, $this->user_id, $this->password, $model, 'create', $data);
        return $id;
    }

    public function edit($model,$data,$id)
    {
        $res = ripcord::client($this->url . "/xmlrpc/2/object");
        $id =  $res->execute_kw($this->db, $this->user_id, $this->password, $model, 'write', $data);
        // get record name after having changed it
        $res->execute_kw($this->db, $this->user_id, $this->password, $model, 'name_get', array(array($id)));
        return $id;
    }

    public function delete($model,$id)
    {
        $res = ripcord::client($this->url . "/xmlrpc/2/object");
         $res->execute_kw($this->db, $this->user_id, $this->password, $model, 'unlink', array(array($id)));
        // check if the deleted record is still in the database
        $id = $res->execute_kw($this->db, $this->user_id, $this->password, $model, 'search',array(array(array('id', '=', $id))));
        return $id;
    }


}