<?php

require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/ripcord.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/manager/BaseManager.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/helpers/Response.php';
require_once  $_SERVER['DOCUMENT_ROOT'].'/odooApiXmlRpc/domain/Customer.php';


class UserManager extends Response  {

    private $odoo;

    public function __construct() {
        $this->odoo = new BaseManager();
    }

    public function login(){
        $this->response($this->odoo,200,true);
    }



    function get_userinfo($username) {
        $userinfo = array();
        /* Get admin user's id */
        $uid =$this->odoo->user_id;

        /* Get logged-in user's id */
        $criteria=array(
            array(array('login', '=', $username)),
        );
        $data= "";

        $user_ids = $this->odoo->search('res.users',$criteria);


        /* Get user info */
        if($user_ids) {

            $fields=  array(
                'name',
                'email',
                'city',
                'city_gov',
                'country',
                'country_gov',
                'coordinated_org',
                'organizations',
            );
            $users = $this->odoo->read('res.users',$user_ids,$fields);




            $user = $users[0]; //
            /* Basic fields */
            $name = explode(' ', $user['name'], 2);
            $userinfo['firstname'] = isset($name[0]) ? $name[0] : "";
            $userinfo['lastname'] = isset($name[1]) ? $name[1] : "";
            $userinfo['email'] = $user['email'];
            /* Non-standard fields */
            if(isset($user['city']) && $user['city']) {
                $userinfo['city'] = $user['city'];
            } elseif(isset($user['city_gov']) && $user['city_gov']) {
                $userinfo['city'] = $user['city_gov'];
            }
            /* get country code */
            $country_id = null;
            if(isset($user['country']) && $user['country']) {
                $country_id = $user['country'][0];
            } elseif(isset($user['country_gov']) && $user['country_gov']) {
                $country_id = $user['country_gov'][0];
            }
            if($country_id) {
                $countries = $this->odoo->read('res.country',array($country_id),array('code'));
                $userinfo['country'] = strtoupper($countries[0]['code']);
            }
            /* Get organizations */
            $organization_ids = array();
            if(isset($user['coordinated_org']) && $user['coordinated_org']) {
                $organization_ids = array_merge($organization_ids, $user['coordinated_org']);
            }
            if(isset($user['organizations']) && $user['organizations']) {
                $organization_ids = array_merge($organization_ids, $user['organizations']);
            }
            $organization_ids = array_unique($organization_ids);
            if($organization_ids) {
                $organization_objs= $this->odoo->read('organization',$organization_ids,array('name'));

                $organizations = array();
                foreach($organization_objs as $organization) {
                    $organizations[] = $organization['name'];
                }
                $userinfo['institution'] = implode(', ', $organizations);
            }
        }

        $this->response($userinfo,200,true);
    }



}
