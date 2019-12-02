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
class VirtueMartModelMetodic extends VmModel {
    /**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Vladimir Bugorkov
	 */
	function __construct() {
		parent::__construct();
		$this->setMainTable('orders');
		$this->addvalidOrderingFieldName(array('order_name','order_email','payment_method','virtuemart_order_id' ) );
		$this->populateState();
        $this->db = JFactory::getDBO();
        $this->id=vRequest::getCmd("id", "");
        $this->userId=JFactory::getUser()->get('id');
        $this->prefix="metodic";
	}
    function populateState () {
		$type = 'search';
		$k= 'com_virtuemart.orders.'.$type;

		$ts = vRequest::getString($type, false);
		$app = JFactory::getApplication();

		if($ts===false){
			$this->{$type} = $app->getUserState($k, '');
		} else {
			$app->setUserState( $k,$ts);
			$this->{$type} = $ts;
		}
		$this->__state_set = true;
	}
    public function getMetodicsList($userId){
      $metodicsList=array();
        $q="SELECT m.metodic_id as id, m.category as type_id, m.name as name, cat.category_name as category
            FROM #__iguide_metodics as m
            LEFT JOIN #__virtuemart_categories_".VmConfig::$vmlang." as cat
            ON m.category=cat.slug
            WHERE user_id=".$userId;
        $this->db->setQuery($q);
		$metodicsList = $this->db->loadObjectList();
        return $metodicsList;
    }

    public function addMetodic($metodicName, $category, $userId=0){
      if($userId==0)return 0;
      $metodic=new stdClass();
        $metodic->name=$metodicName;
        $metodic->category=$category;
        $metodic->user_id=$userId;
        #$this->db->setQuery($q);
        $this->db->insertObject("#__iguide_metodics", $metodic);
        $q="SELECT LAST_INSERT_ID()";
        $this->db->setQuery($q);
        $metodicId=$this->db->loadResult();
        return $metodicId;
    }
	public function getMetodic($id=0, $userId=0){
		if($id==0) return 0;
		$metodic=new stdClass();
		$metodic->id=$id;
		$q="SELECT m.name as metodic_name, m.category as category_id, m.user_id as user_id, cat.category_name as category_name
            FROM #__iguide_metodics as m
            LEFT JOIN #__virtuemart_categories_".VmConfig::$vmlang." as cat
            ON m.category=cat.slug
            WHERE metodic_id=".$id;
		$this->db->setQuery($q);
		$metodic->info = $this->db->loadObject();
		if($metodic->info->user_id!=$userId){
			//$metodic->info=new stdClass();
			$metodic->status="Access denied!";
			//return $metodic;
		}
		$metodic->status="OK";
		return $metodic;
	}
	public function getTestStructure($metodicId=0, $userId=0){
		if($metodicId==0) return 0;
        $q="SELECT id, name
        FROM #__iguide_metodic_tests
        WHERE metodic_id=".$metodicId;
        $this->db->setQuery($q);
        $patterns=$this->db->loadObjectList();
        $counter=0;

        foreach ($patterns as $pattern){
          $q="SELECT *
          FROM #__iguide_metodic_fields
          WHERE metodic_test_id=".$pattern->id;
          $this->db->setQuery($q);
          $patterns[$counter]->fields=$this->db->loadObjectList();
          $counter++;
        }
        return $patterns;
	}
    public function removemetodic($id, $userId){
      $dbq=$this->db->getQuery(true);
        $dbq->delete($this->db->quoteName("#__iguide_metodics"))
            ->where(array($this->db->quoteName('user_id')."=".$userId, $this->db->quoteName('metodic_id')."=".$id));
        $this->db->setQuery($dbq);
        $this->db->query();
    }

    public function addControlField(){
        $rowName="field";
        $properities=array(
            "name"=>$this->getCmd("name"),
            "measure"=>$this->getCmd("measure"),
            "power"=>$this->getCmd("power")
        );
        $block=array(
            "name"=>"test",
            "id"=>$this->getCmd("metodic_test_id")
        );
        return $this->addRow($rowName, $properities, $block);
    }

    public function editControlField(){
          $rowName="field";
        $rowId=$this->getCmd("metodic_field_id");
        $properities=array(
            "name=".$this->quoteCmd("name"),
            "measure=".$this->quoteCmd("measure"),
            "power=".$this->quoteCmd("power")
        );
        return $this->editRow($rowName, $rowId, $properities);
    }

	public function removeControlBlock(){
        $this->removeBlock($this->controlBlock());
	}

    public function getIntents($metodicId, $userId){
      $dbq=$this->db->getQuery(true);
      $dbq->select(array("intent_id", "name"));
      $dbq->from("#__iguide_intents");
      $dbq->where(array($this->db->quoteName('metodic_id')."=".$metodicId), $this->db->quoteName('user_id')."=".$userId);
      $this->db->setQuery($dbq);
      $intents=$this->db->loadObjectList();
      return $intents;
    }

    public function createIntent($id, $name, $userId){
        $dbq=$this->db->getQuery(true);
		$dbq->select(array("user_id", "category"));
		$dbq->from("#__iguide_metodics");
		$dbq->where(array($this->db->quoteName('metodic_id')."=".$id));
		$this->db->setQuery($dbq);
		$metodicInfo=$this->db->loadObject();
		if($metodicInfo->user_id!=$userId) return "Access denied!";
		else{
			$intent=new stdClass();
			$intent->metodic_id=$id;
			$intent->name=$name;
            $intent->category_id=$metodicInfo->category;
            $intent->user_id=$userId;
			$this->db->insertObject("#__iguide_intents", $intent);
            $q="SELECT LAST_INSERT_ID()";
            $this->db->setQuery($q);
            $intent->intent_id=$this->db->loadResult();
            $intent->result="OK";
			return $intent;
		}
    }

    public function changeField($metodicId, $fieldId, $name, $measure, $userId){

    }

    public function getControlBlocks(){
        $blockName="test";
        $properities=array("name");
            $field=new stdClass();
            $field->name="field";
            $field->fields=null;
            $field->properities=array("name", "power", "measure");
        $rows=array($field);

        return $this->getBlocks($blockName, $properities, $rows);
    }

    public function editControlBlock(){
        $blockName="test";
        $blockId=$this->getCmd("metodic_test_id");
        $properities=array(
            "name=".$this->quoteCmd("name")
        );
        return $this->editBlock($blockName, $blockId, $properities);
    }

    public function addControlBlock(){
        $properities=array("name"=>$this->getCmd("name"));
        return $this->addBlock("test", $properities);
    }

    public function getTaskTemplates(){
        $blockName="task";
        $properities=array("name");
            $action=new stdClass();
            $action->name="action";
            $action->fields=array();
            $action->properities=array("name");
        $rows=array($action);

        return $this->getBlocks($blockName, $properities, $rows);
    }
    public function _getTaskTemplates(){
        $templates=array();
        foreach($this->getElements(array("id", "name"), array("task"), array()) as $template){
            array_push($templates, (object)array( "id"=>$template->id,
                 "info"=>(object)array(
                    "name"=>$template->name
                 )
            ));
        }

        return $templates;
    }

    public function editTaskTemplate(){
        $blockName="task";
        $blockId=$this->getCmd("metodic_task_id");
        $properities=array(
            "name=".$this->quoteCmd("name")
        );
        return $this->editBlock($blockName, $blockId, $properities);
        //return $properities;
    }

    public function addTaskTemplate(){
        $blockName="task";
        $properities=array(
            "name"=>$this->getCmd("name")
        );
        return $this->addBlock($blockName, $properities);
    }

    public function editActionTemplate(){
        $rowName="action";
        $rowId=$this->getCmd("metodic_action_id");
        $properities=array(
            "name=".$this->quoteCmd("name")
        );
        return $this->editRow($rowName, $rowId, $properities);
    }

    public function addActionTemplate(){
        $rowName="action";
        $properities=array(
            "name"=>$this->getCmd("name")
        );
        $block=array(
            "name"=>"task",
            "id"=>$this->getCmd("metodic_task_id")
        );
        return $this->addRow($rowName, $properities, $block);
    }

    public function addFieldToTaskTemplate(){
        return $this->addField(array("name"=>"action", "metodic_action_id"=>$this->getCmd("metodic_action_id"), "metodic_task_id"=>$this->getCmd("metodic_task_id")), $this->getCmd("name"), $this->getCmd("measure"));
    }

    public function removeTask(){
        return $this->removeBlock($this->taskTemplate());
    }
    public function removeAction(){
        return $this->removeRow("action", $this->getCmd("metodic_action_id"), $this->getCmd("metodic_task_id"));
    }

    public function removeActionField(){
        return $this->removeField("action", $this->getCmd("field_id"));
    }

    public function getTaskFieldsByMeasure(){
        $fields=$this->getElements(
            array("id", "name", "metodic_action_id"),
            array("action", "field"),
            array("measure"=>$this->getCmd('measure'))
        );
        foreach($fields as $field){
            $field->action_name=$this->getElements(
                array("name"),
                array("action"),
                array("id"=>$field->metodic_action_id)
            )[0]->name;
            $link=$this->getElements(
                array("id"),
                array("field", "field"),
                array("metodic_action_field_id"=>$field->id, "metodic_field_id"=>$this->getCmd('link_id'))
            );
            $field->linked=count($link);
        }
       return $fields;
    }

    public function addFieldLink(){
        return $this->addElement((object)array(
            "metodic_field_id"=>$this->getCmd('metodic_field_id'),
            "metodic_test_id"=>$this->getCmd('metodic_test_id'),
            "metodic_action_field_id"=>$this->getCmd('label_id')), (object)array(), "field_field");
    }

    public function removeFieldLink(){
        return $this->removeElements(array("field", "field"), array(
            "metodic_action_field_id"=>$this->getCmd("label_id"),
            "metodic_field_id"=>$this->getCmd('metodic_field_id')));
    }

    private function taskTemplate(){
        return array(
        "name"=>"task",
        "id"=>$this->getCmd("metodic_task_id"),
        "properities"=>array("name"),
        "rows"=>array(
            array(
                "name"=>"action",
                "properities"=>array("name"),
                "id"=>$this->getCmd("metodic_action_id")
            )
        )
    );}

    private function controlBlock(){
        return array(
        "name"=>"test",
        "id"=>$this->getCmd("metodic_test_id"),
        "properities"=>array("name", "power"),
        "rows"=>array(
            array(
                "name"=>"field",
                "properities"=>array("name", "power"),
                "id"=>$this->getCmd("metodic_field_id")
            )
        )
    );}

}
?>