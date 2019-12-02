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
class VirtueMartModelGroups extends VmModel {
    /**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Vladimir Bugorkov
	 */
	function __construct() {
		parent::__construct();
        $this->db = JFactory::getDBO();

        $this->userId=JFactory::getUser()->get('id');
        $this->id=$this->getCmd("group_id");
        $this->prefix="group";
	}

    public function membered(){
        //return "ksjdklfjsdf";
        return $this->linkedPrivateAction((object)array(
            "link"=>(object)array(
                "table"=>"#__iguide_intents",
                "key_field"=>"group_id",
                "static_conditions"=>(object)array(
                    "user_id"=>$this->userId
                )
            ),
            "link_key"=>"id",
            "table"=>"#__iguide_groups",
            "post_prefix"=>"group",
            "fields"=>array("name", "description", "avatar"),
            "conditions"=>array(),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "default"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array()
                )
            )
        ));
    }

    public function created(){
        return $this->linkedPrivateAction((object)array(
            "link"=>(object)array(
                "table"=>"#__iguide_metodics",
                "key_field"=>"group_id",
                "static_conditions"=>(object)array(
                    "user_id"=>$this->userId
                )
            ),
            "link_key"=>"id",
            "table"=>"#__iguide_groups",
            "post_prefix"=>"group",
            "fields"=>array("name", "description", "avatar"),
            "conditions"=>array(),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                ""=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    public function administrated(){
        return $this->linkedPrivateAction((object)array(
            "link"=>(object)array(
                "table"=>"#__iguide_group_admins",
                "key_field"=>"group_id",
                "static_conditions"=>(object)array(
                    "user_id"=>$this->userId
                )
            ),
            "link_key"=>"id",
            "table"=>"#__iguide_groups",
            "post_prefix"=>"group",
            "fields"=>array("name", "description", "avatar"),
            "conditions"=>array(),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                ""=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    private function getGroupInfo($id){
        $groupInfo=$this->getElementsByTableName(array("id", "name", "description", "avatar", "user_id"), "#__iguide_groups", array("id"=>$id))[0];
        return (object)array("id"=>$id,
            "info"=>(object)array(
             "name"=>$groupInfo->name,
             "description"=>$groupInfo->description,
             "avatar"=>$groupInfo->avatar
        ),
        "actions"=>(object)array()
        );
    }

    public function getMyGroups(){
        //Группы, привязаные к моим методикам создал я
        $_created=$this->getElementsByTableName(array("group_id"), "#__iguide_metodics", array("isgroup"=>1, "user_id"=>$this->userId));
        //В группах, привязаных к моим целям я участвую
        $_membered=$this->getElementsByTableName(array("group_id"), "#__iguide_intents", array("isgroup"=>1, "user_id"=>$this->userId));
        $membered=array();
        $administrated=array();
        $coached=array();
        $created=array();

        foreach($_created as $group){
            $group=$this->getGroupInfo($group->group_id);
            $group->info->created=1;
            $group->actions=array("remove", "edit");
            array_push($created, $group);
        }

        foreach($_membered as $group){
            $group=$this->getGroupInfo($group->group_id);

            if(count($this->getElements(array("group_id"), array("admin"), array("group_id"=>$group->id)))){
                $group->info->administrated=1;
                $group->actions=array("edit");
                array_push($administrated, $group);
            }
            if(count($this->getElements(array("group_id"), array("coach"), array("group_id"=>$group->id)))){
                $group->info->coached=1;
                if(!$group->info->administrated)array_push($coached, $group);

            }else{
                if(!$group->info->administrated)array_push($membered, $group);
            }
        }
        return array_merge($created, $coached, $administrated, $membered);
    }

    public function canIMakeGroup(){
        return $this->checkAccount($this->userId, "pro");
    }

    public function addGroup(){
        if($this->canIMakeGroup())return $this->addElement((object)array(
            "name"=>$this->getCmd("name"),
            "description"=>$this->getCmd("description"),
            "avatar"=>$this->getCmd("avatar"),
            "metodic_id"=>$this->getCmd("metodic_id"),
            "lng"=>$this->getCmd("lng")
        ), null, null);
        else return null;
    }

    public function editGroupProperity(){
        $properity=$this->getCmd("properity");
        return $this->editElements(array(
            $properity."=".$this->quoteCmd("value")
        ), array(), array("id"=>$this->getCmd("id")));
    }

    public function removeGroup(){
        return $this->removeElements(array(), array("id"=>$this->getCmd("id")));
    }

}


?>