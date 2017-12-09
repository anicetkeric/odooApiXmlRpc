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




}