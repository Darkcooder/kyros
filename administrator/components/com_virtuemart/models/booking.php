<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if(!class_exists('VmModel')) require(VMPATH_ADMIN.DS.'helpers'.DS.'vmmodel.php');

/**
 * Model for VirtueMart Orders
 * WHY $this->db is never used in the model ?
 * @package VirtueMart
 */
class VirtueMartModelBooking extends VmModel {
    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Vladimir Bugorkov
     */
    function __construct() {
        parent::__construct();
        $this->db = JFactory::getDBO();

        $this->userId=JFactory::getUser()->get('id');
        //$this->id=$this->getCmd("location_id");
        $this->prefix="booking";
    }

    public function concept(){
        return $this->privateAction((object)array(
            "paerent"=>(object)array(), //SET родительского объекта
            "table"=>"#__booking_apartaments",
            "post_prefix"=>"apartament",
            "fields"=>array("addres", "rooms", "price", "peoples", "deposit"),
            "conditions"=>array(),
            "access_flag"=>"booking_acc",
            "access_policy"=>(object)array(
                "landlord"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "user"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    public function appartament($action){
        $accountType=$this->getElementsByTableName(array("booking_acc"), "#__slogin_users", array("user_id"=>$this->userId, "provider"=>"vkontakte"))[0];
        $access=($accountType=="landlord")?array("my"=>array("add", "edit", "get", "remove")):array("my"=>array());
        $access['foreign']=array("get");
        return $this->privateAction($action, "#__booking_apartaments", $this->getCmdObject("appartament", array("addres", "rooms", "price", "peoples", "deposit")), $this->getCmdObject(), (object)$access);
    }

    public function opentime($action){
        $accountType=$this->getElementsByTableName(array("booking_acc"), "#__slogin_users", array("user_id"=>$this->userId, "provider"=>"vkontakte"))[0];
        $access=($accountType=="landlord")?array("my"=>array("add", "edit", "get", "remove")):array("my"=>array());
        $access['foreign']=array("get");
        //добавить возможность задавать права общего доступа на объект
        return $this->childPrivateAction($action, "#__booking_opentime", $this->getCmdObject(), $this->getCmdObject(), (object)$access, (object)array("table"=>"#__booking_apartaments", "id"=>$this->getCmd("apartament_id")));
    }

    public function busytime($action){
        $accountType=$this->getElementsByTableName(array("booking_acc"), "#__slogin_users", array("user_id"=>$this->userId, "provider"=>"vkontakte"))[0];
        $access=($accountType=="landlord")?array("my"=>array("add", "edit", "get", "remove")):array("my"=>array());
        $access['foreign']=array("get");
        //добавить возможность задавать права общего доступа на объект
        return $this->childPrivateAction($action, "#__booking_busytime", $this->getCmdObject(), $this->getCmdObject(), (object)$access, (object)array("table"=>"#__booking_apartaments", "id"=>$this->getCmd("apartament_id")));
    }


}


?>