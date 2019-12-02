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
class VirtueMartModelOxota extends VmModel {
    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Vladimir Bugorkov
     */
    function __construct() {
        parent::__construct();
        $this->db = JFactory::getDBO();

        $this->userId=JFactory::getUser()->get('id');
        $this->id=$this->getCmd("location_id");
        $this->prefix="oxota";
    }

    public function checkMyQuestStatus(){
        $result=$this->getElementsByTableName(array("quest_status"), "#__slogin_users", array("user_id"=>$this->userId, "provider"=>"vkontakte"))[0];
        return (object)array("id"=>$this->userId,
            "info"=>(object)array(
             "status"=>$result->quest_status
        ));
    }

    public function getMap(){
        //Получаем опубликованые локации
        $locations=$this->getElementsByTableName(array("id", "name", "lat", "lng", "status", "free_datetime"), "#__oxota_locations", array("published"=> 1));
        $output=array();

        $status=$this->checkMyQuestStatus()->info->status;

        foreach($locations as $location){
            $actions=array();
            switch($status){
                case "admin":
                    array_push($location->actions, "edit", "remove", "add");
                case "member":
                     array_push($output, (object)array("id"=>$location->id,
                        "info"=>(object)array(
                            "name"=>$location->name,
                            "lat"=>$location->lat,
                            "lng"=>$location->lng,
                            "status"=>$location->status,
                            "freeDatetime"=>$location->free_datetime
                        ),
                        "actions"=>$actions
                    ));
                break;
                default:
                   $output=(object)array("status"=>"Acces denied!");
                break;
            }
        }
        return $output;
    }

    public function getLocationTrip(){
        $trip=$this->getElementsByTableName(array("id", "description"), "#__oxota_trips", array("location_id"=>$this->getCmd("location_id")))[0];
        $pictures=$this->getElementByTableName(array("id", "url", "description"), "#__oxota_pictures", array("trip_id"=>$trip->id));
        $freeDatetime=new DateTime($this->getElementsByTableName(array("free_datetime"), "#__oxota_locations", array("id"=>$this->getCmd("location_id")))[0]->free_datetime);
        $isFree=var_dump(new DateTime("now")>$freeDatetime);
        $isPayed=$this->count(getElementsByTableName(array("id"), "#__oxota_trip_payments", array("location_id"=>$this->getCmd("location_id"), "user_id"=>$this->userId)));
        $output=(object)array();
        if($isFree||$isPayed){
            $output=(object)array("id"=>$trip->id,
                "info"=>(object)array(
                    "description"=>$trip->description,
                    "pictures"=>array()
                )
            );
            foreach($pictures as $picture){
                array_push($output->info->pictures, (object)array("id"=>$picture->id,
                    "info"=>(object)array(
                        "url"=>$picture->url,
                        "description"=>$picture->description
                    )
                ));
            }
        }
        return $output;
    }

    public function addMeToQuest(){
        //Добавить верификацию покупки участия в квесте

        return $this->editElementsByTableName(array("quest_status"=>"member"), "#__slogin_users", array("user_id"=>$this->userId, "provider"=>"vkontakte"));
    }

    public function payLocationTrip(){
        //Добавить верификацию покупки подсказки

        $payment=$this->getCmdObject("payment", array("location_id"));
        $payment->user_id=$this->userId;
        return $this->addElementByTableName($payment, "#__oxota_trip_payments");
    }

    public function addLocation(){
        $location=$this->getCmdObject("location", array("name", "lat", "lng"));

        //Добавить время открытия бесплатного доступа к подсказке
        $location->free_datetime="";
        $location->status="actual";
        if($this->checkMyQuestStatus()->info->status=="admin")
        return $this->addElementByTableName($location, "#__oxota_locations");
        else
        return (object)array("status"=>"Acces denied");
    }

    public function addLocationTrip(){
        $trip=$this->getCmdObject("trip", array("location_id", "description"));
        if($this->checkMyQuestStatus()->info->status=="admin")
            return $this->addElementByTableName($trip, "#__oxota_trips");
        else
            return (object)array("status"=>"Acces denied");
    }

    public function addPictureToTrip(){
        $picture=$this->getCmdObject("trip_picture", array("url", "description"));
        if($this->checkMyQuestStatus()->info->status=="admin")
            return $this->addElementByTableName($picture, "#__oxota_pictures");
        else
            return (object)array("status"=>"Acces denied");
    }

    public function passLocation(){
        if($this->checkMyQuestStatus()->info->status=="admin")
            return $this->editElementsByTableName(array("status"=>"passed"), "#__oxota_location", array("id"=>$this->getCmd("location_id")));
        else
            return (object)array("status"=>"Acces denied");
    }
}


?>