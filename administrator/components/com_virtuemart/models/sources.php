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
class VirtueMartModelSources extends VmModel {
    /**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Vladimir Bugorkov
	 */
	function __construct() {
		parent::__construct();
		$this->setMainTable('intents', '#__iguide_intents');
        $this->setIdName('intent_id');
		$this->addvalidOrderingFieldName(array('intent_id','metodic_id','type','name' ) );
        $this->db = JFactory::getDBO();
        $this->setListTmp(array('id'=>'intent_id', 'type_id'=>'type', 'name'=>'name'), array('category'=>'name') );

        $this->userId=JFactory::getUser()->get('id');
        $this->id="source";
        $this->prefix="source";
	}

    private function distance($location1, $location2)
     {
         // Convert degrees to radians.
        $lat1=deg2rad($location1->lat);
        $lng1=deg2rad($location1->lng);
        $lat2=deg2rad($location2->lat);
        $lng2=deg2rad($location2->lng);

        // Calculate delta longitude and latitude.
        $delta_lat=($lat2 - $lat1);
        $delta_lng=($lng2 - $lng1);

        return round( 6378137 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lng1 - $lng2 ) + sin( $lat1 ) * sin( $lat2 ) ) );
     }
     protected function distanceFromMe($object){
         if(!$this->me)$this->me=(object)array("location"=>$this->getMyLocation());
         if(isset($this->me)&&$object->location)return $this->distance($this->me->location, $object->location);
     }

     protected function applySeeMe(&$peoples, $for_who){
         foreach($peoples as &$ppl){
             if($ppl->loc_status->$for_who<$this->distanceFromMe($ppl)){
                 $ppl->location=null;
                 $ppl->loc_status="offmap";
             }
             else{
                 //$ppl->max=$ppl->loc_status->$for_who;
                 //$ppl->cur=$this->distanceFromMe($ppl);
                 $ppl->loc_status="onmap";
                 $ppl->distance=$this->distanceFromMe($ppl);
             }
         }
     }

     protected function applyLocationProof(&$meets){
         foreach ($meets as $k=>&$meet){
             if($meet->proof) {
                  $meet->location=$this->getUserLocation($meet->people->people_id);
                  $meet->info->distance=$this->distanceFromMe($meet);
             }
             else {
                  $meet->location=null;
                  if($meet->passive){
                      $meet->actions=array("proof", "reject");
                      if(!$meet->isnew) unset($meets[$k]);
                  }
             }


         }
         return $meets;
     }

     protected function sharePeopleInfo(&$objs){
         foreach($objs as &$obj){
             if($obj->people->people_id){
                 $obj->people->id=$obj->people->people_id;
                 $obj->people=$this->getPeopleInfo($obj->people->id);
             }
         }
         return $objs;
     }

     protected function sharePlace(&$objs){
         foreach($objs as &$obj){
             if($obj->place->place_id){
                 $data=$this->getElementsByTableName(array("name", "description", "lat", "lng"), "#__iguide_source_places",
                      array("id"=>$obj->place->place_id, "user_id"=>$this->userId)
                 )[0];
                 $obj->location=(object)array("lat"=>$data->lat, "lng"=>$data->lng);
                 $obj->place=(object)array("id"=>$obj->place_id, "name"=>$data->name, "description"=>$data->description);
                 $obj->info->distance=$this->distanceFromMe($obj);
             }
         }
         return $objs;
     }

     public function getPlaces(){
         $this->id="place";
         $places=$this->getElements(array("id", "lat", "lng", "name", "description", "source_id"), array("place"), null);
         $places=$this->groupElements($places, array("info"=>array("name", "description"), "location"=>array("lat", "lng")), array("id"));
         $this->addStaticFields($places, array("actions"=>array("edit", "remove"), "type"=>"place"));
         $this->addDynamicFieldToGroup($places, "info", "distance", "distanceFromMe");
         return $places;
     }

    public function getMap(){

        $me=(object)array("id"=>$this->userId, "type"=>"me", "info"=>array("name"=>"Это Я!"), "location"=>$this->getMyLocation(), "isee"=>$this->getMyIseeStatus());
        $this->me=$me;

        $places=$this->getPlaces();
        $tasks=$this->getMyAnchors();

        $friends=$this->getSocialFriends("registered");

        $meets=$this->getMyMeets();
        $pmeets=$this->getMeetsWithMe();

        $this->addStaticFields($friends, array("type"=>"people"));

        $this->addDynamicFieldToGroup($friends, "info", "distance", "distanceFromMe");

        $me=array($me);
        return array_merge($me, $meets, $pmeets, $tasks, $places, $friends);
    }

    public function setMyLocStatus(){
        $type=$this->selectString($this->getCmd("stat_type"), array("isee_public", "isee_friends", "isee_liked", "seeme_public", "seeme_friends", "seeme_liked"));
        $value=(int)$this->getCmd("stat_value");
        if($type){
             return $this->editElementsByTableName(array($type=>$value),
            "#__slogin_users", array("user_id"=>$this->userId)
        );
        }
    }

    public function addPlace(){
        $this->id="place";
        return $this->addElement((object)array(
            "name"=>$this->getCmd("name"),
            "description"=>$this->getCmd("description"),
            "keywords"=>$this->getCmd("keywords"),
            "lat"=>$this->getCmd("lat"),
            "lng"=>$this->getCmd("lng")
        ), null, "place");
    }

    public function editPlaceProperity(){
        $this->id="place";
        $properity=$this->getCmd("properity");
        return $this->editElementsByTableName(array(
            $properity=>$this->getCmd("value")
        ), "#__iguide_source_places", array("id"=>$this->getCmd("id"), "user_id"=>$this->userId));
    }

    public function removePlace(){
        $this->id="place";
        return $this->removeElements(array("place"), array("id"=>$this->getCmd("id")));
    }

    public function addMeet(){
       return $this->addElementByTableName((object)array(
          "people_id"=>$this->getCmd("people_id"),
          "radius"=>$this->getCmd("distance"),
          "name"=>$this->getCmd("name"),
          "description"=>$this->getCmd("description"),
          "isnew"=>"1",
          "user_id"=>$this->userId
       ), "#__iguide_meets");
    }

    public function proofMeetWithMe(){
        return $this->editElementsByTableName(array("proof"=>"1", "isnew"=>"0"), "#__iguide_meets",
        array("id"=>$this->getCmd("meet_id"), "people_id"=>$this->userId));
    }

    public function removeMeet(){
        return $this->removeElementsByTableName("#__iguide_meets",
        array("id"=>$this->getCmd("id"), "user_id"=>$this->userId));
    }

    public function rejectMeetWithMe(){
        return $this->editElementsByTableName(array("proof"=>"0", "isnew"=>"0"), "#__iguide_meets",
        array("id"=>$this->getCmd("meet_id"), "people_id"=>$this->userId));
    }

    public function getMyMeets(){
         $data=$this->getElementsByTableName(array("id", "people_id", "name", "description", "radius", "proof", "isnew"), "#__iguide_meets",
         array("user_id"=>$this->userId));
         $meets=$this->groupElements($data, array("info"=>array("radius", "name", "description"), "people"=>array("people_id")),
         array("id", "proof", "isnew"));
         $this->addStaticFields($meets, array("type"=>"meet"));
         $this->addStaticFields($meets, array("actions"=>array("edit", "remove")));
         $this->applyLocationProof($meets);
         return $this->sharePeopleInfo($meets);
    }

    protected function getMeetsWithMe(){
          $data=$this->getElementsByTableName(array("user_id", "name", "description",  "radius", "proof", "isnew"), "#__iguide_meets",
         array("people_id"=>$this->userId));
         $this->renameFields($data, array("user_id"=>"people_id"));
         $meets=$this->groupElements($data, array("info"=>array("radius", "name", "description"), "people"=>array("people_id")),
         array("id", "proof", "isnew"));
         $this->addStaticFields($meets, array("type"=>"meet"));
         $this->addStaticFields($meets, array("passive"=>"1"));
         //$this->addStaticFields($meets, array("actions"=>array("proof", "reject")));
         $this->applyLocationProof($meets);
         return $this->sharePeopleInfo($meets);
    }

    public function getMyAllMeets(){

    }

    public function getNotices(){
        $meets=array();
        foreach($this->getMyMeets() as $meet){
            if($meet->info->distance<$meet->info->radius) array_push($meets, $meet);
        }
        foreach($this->getMeetsWithMe() as $meet){
            if($meet->info->distance<$meet->info->radius) array_push($meets, $meet);
        }
        foreach($this->getMyAnchors() as $task){
            if($task->info->distance<$task->info->radius) array_push($meets, $task);
        }
        return $meets;
    }

    public function addAnchor(){
         return $this->addElementByTableName((object)array(
            "place_id"=>$this->getCmd("place_id"),
            "radius"=>$this->getCmd("distance"),
            "name"=>$this->getCmd("name"),
            "description"=>$this->getCmd("description"),
            "user_id"=>$this->userId
         ), "#__iguide_anchors");
    }

    public function removeTask(){
        return $this->removeElementsByTableName("#__iguide_anchors",
        array("id"=>$this->getCmd("id"), "user_id"=>$this->userId));
    }

    public function getMyAnchors(){
         $data=$this->getElementsByTableName(array("id", "place_id", "radius", "name", "description"), "#__iguide_anchors",
             array("user_id"=>$this->userId)
         );
         $anchors=$this->groupElements($data, array("info"=>array("radius", "name", "description"), "place"=>array("place_id")),
         array("id"));
         $this->addStaticFields($anchors, array("type"=>"task"));
         $this->addStaticFields($anchors, array("actions"=>array("edit", "remove")));
         return $this->sharePlace($anchors);
    }

    public function getFriends(){
        $this->id="friend";
        $friendList=$this->getElements(array("id", "friend_id"), array("friend"), null);
        foreach ($friendList as $i=>$friend){
            $friend->info=$this->getPeopleInfo($friend->friend_id);
            $friend->location=$this->getUserLocation($friend->friend_id);
            $friend->loc_status=$this->getUserSeemeStatus($friend->friend_id);

            $friend->info->registered=1;
            $friend->info->isfriend=1;
            $friend->info=(object)array_merge((array)$friend->info, (array)$this->getElementsByTableName(array("slogin_id", "provider"), "#__slogin_users", array("user_id"=>$friend->friend_id))[0]);
            $friend->actions=array("remove");
            $friendList[$i]=$friend;
        }
        $this->applySeeMe($friendList, "friends");
        return $friendList;
    }

    protected function getPeopleInfo($people_id){
        return $this->getElementsByTableName(array("name"), "#__users", array("id"=>$people_id))[0];
    }

    public function setMyLocation(){
        $location=$this->getCmdObject("loc", array("lat", "lng"));
        return $this->editElementsByTableName(array("loc_lat"=>$location->lat, "loc_lng"=>$location->lng, "loc_datetime"=>date("Y-m-d h:i:s")),
            "#__slogin_users", array("user_id"=>$this->userId)
        );
    }

    public function getMyLocation(){
        return $this->getUserLocation($this->userId);
    }

    protected function getMyIseeStatus(){
       return $this->getElementsByTableName(array("public", "friends", "liked"), "#__slogin_users", array("user_id"=>$this->userId), "isee")[0];
    }

    protected function getUserSeemeStatus($user_id=null){
       if(!$user_id)$user_id=$this->getCmd("user_id");
       return $this->getElementsByTableName(array("public", "friends", "liked"), "#__slogin_users", array("user_id"=>$user_id), "seeme")[0];
    }

    protected function getUserLocation($user_id=null){
        if(!$user_id)$user_id=$this->getCmd("user_id");
       return $this->getElementsByTableName(array("lat", "lng", "datetime"), "#__slogin_users", array("user_id"=>$user_id), "loc")[0];
    }

    public function getAllFriends(){
        return $this->getSocialFriends("unregistered");
    }

    public function getPeoples(){
        return $this->getSocialFriends("registered");
    }
    public function setFriends(){
        $this->removeElementsByTableName("#__vk_friends", array("user_id"=>$this->userId));
        for($i=0; $this->getCmd("id_".$i); $i++){

            $this->addElementByTableName((object)array("user_id"=>$this->userId,
                "friend_id"=>(int)$this->getCmd("id_".$i),
                "first_name"=>$this->getCmd("first_name_".$i),
                "last_name"=>$this->getCmd("last_name_".$i),
                "photo_50"=>$this->getCmd("photo_50_".$i)
            ), "#__vk_friends");
        }
    }

    protected function getSocialFriends($type){
        $token=JFactory::getApplication()->getUserState("slogin.token");
        require_once JPATH_BASE.'/components/com_slogin/controller.php';
        $controller = new SLoginController();
        $output=(object)array();
        $output->registered=array();
        $output->unregistered=array();

        switch($token['provider']){
            case "vkontakte":
                $url="https://api.vk.com/method/friends.get?fields=first_name,last_name,photo_50&access_token=".$token['token'];
                $data=json_decode($controller->open_http($url))->response;

                if(empty($data)){
                    $data=$this->getElementsByTableName(array("friend_id", "first_name", "last_name", "photo_50"), "#__vk_friends", array("user_id"=>$this->userId));
                    $this->renameFields($data, array("friend_id"=>"user_id"));
                }

                foreach($data as $friend){
                    $check=$this->checkSocialUser("vkontakte", $friend->user_id);
                    $_friend= (object)array(
                        "info"=>(object)array(
                            "name"=>$friend->first_name." ".$friend->last_name,
                            "provider"=>"vkontakte",
                            "slogin_id"=>$friend->user_id,
                            "avatar"=>$friend->photo_50,
                            "registered"=>count($check)
                        ),
                        "actions"=>array()
                    );
                    if($_friend->info->registered){
                         array_push($_friend->actions, "add");
                         $_friend->id=$check[0]->user_id;
                         $_friend->location=$this->getUserLocation($_friend->id);
                         $_friend->loc_status=$this->getUserSeemeStatus($_friend->id);

                         if(!count($this->checkFriend($_friend->id)))array_push($output->registered, $_friend);
                    }else{
                         array_push($_friend->actions, "invite");
                         array_push($output->unregistered, $_friend);
                    }
                }
            break;

            case "facebook":
                $url="https://graph.facebook.com/v2.8/me/friends?access_token=".$token['token'];
                $data=json_decode($controller->open_http($url));
                $output->unregistered=$data;
            break;
        }
        //return array_merge($this->getFriends(), $registered, $unregistered);

        $this->applySeeMe($output->registered, "friends");
        return $output->$type;
    }

    public function removeFriend(){
        $this->id="friend";
        return $this->removeElements(array("friend"), array("id"=>$this->getCmd("id")));
    }

    public function addFriend(){
        $this->id="friend";
        return $this->addElement((object)array("friend_id"=>$this->getCmd("id"), "source_id"=>"friend"), null, "friend");
    }

    protected function checkSocialUser($provider, $uid){
         return $this->getElementsByTableName(array("user_id"), "#__slogin_users", array("slogin_id"=>$uid, "provider"=>$provider));
    }

    protected function checkFriend($uid){
        $this->id="friend";
        return $this->getElements(array("id"), array("friend"), array("friend_id"=>$uid));
    }
}

?>