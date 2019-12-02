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
class VirtueMartModelIguide extends VmModel {
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

     public function getIntentsList($uid=0){
        $intentsList=array();
        $q="SELECT i.intent_id as id, i.type as type_id, i.name as name, cat.category_name as category
            FROM #__iguide_intents as i
            LEFT JOIN #__virtuemart_categories_".VmConfig::$vmlang." as cat
            ON i.type=cat.slug
            WHERE user_id=".$uid;
        $this->db->setQuery($q);
		$intentsList = $this->db->loadObjectList();
        return $intentsList;
    }

    public function getIntent($id=0, $userId=0){
        if($id==0) return 0;
        $intent=new stdClass();
        $intent->id=$id;
        $q="SELECT i.name as intent_name, i.type as category_id, i.user_id as user_id, cat.category_name as category_name,
            i.metodic_id as metodic_id, m.name as metodic_name,
            uc.name as coach_name, uc.id as coach_id, g.name as group_name, g.group_id as group_id
            FROM #__iguide_intents as i
            LEFT JOIN #__virtuemart_categories_".VmConfig::$vmlang." as cat
            ON i.type=cat.slug
            LEFT JOIN #__iguide_metodics as m
            ON i.metodic_id=m.metodic_id
            LEFT JOIN #__users as uc
            ON i.coach_user_id=uc.id
            LEFT JOIN #__iguide_groups as g
            ON i.group_id=g.group_id
            WHERE intent_id=".$id;
        $this->db->setQuery($q);
		$intent->info = $this->db->loadObject();
        if($intent->info->user_id!=$userId){
            $intent->info=new stdClass();
            $intent->status="Access denied!";
            return $intent;
        }
        $intent->status="OK";

        $q="SELECT source_type as type, source_id as id
            FROM #__iguide_sources
            WHERE intent_id=".$id;
        $this->db->setQuery($q);
        $sources = $this->db->loadObjectList();
        $intent->peoples=array();
        $intent->places=array();
        $intent->items=array();

        foreach ($sources as $source) {
            switch ($source->type){
                case "people":
                $intent->peoples[]=$this->getPeopleMiniInfo($source->id);
                break;
                case "place":
                $intent->places[]=$this->getPlaceMiniInfo($source->id);
                break;
                case "item":
                $intent->items[]=$this->getItemMiniInfo($source->id);
                break;
            }
        }
        return $intent;
    }

    private function getMetodicId($intentId){
        $q=$this->db->getQuery(true);
        $q->select("metodic_id")
            ->from("#__iguide_intents")
            ->where(("intent_id=").$this->db->quote($intentId));
        return $this->db->setQuery($q)->loadResult();
    }

    private function getControlBlocks($intentId){
        $metodicId=$this->getMetodicId($intentId);
        $q=$this->db->getQuery(true);
        $q->select(array("pattern_id", "test_name"))
            ->from("#__iguide_metodic_tests")
            ->where("metodic_id=".$this->db->quote($metodicId));
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getCurrentIntentStatus($intent_id){

        $cBlocks=$this->getControlBlocks($intent_id);

        $currentStatusTests=array();

        foreach ($cBlocks as $block){
            $last_test=$this->getLastTest($intent_id, $block->pattern_id, 'current');

            $currentTest=array();
            $fields=$this->getTestFields($block->pattern_id);
            $currentTest['fields']=array();
            foreach($fields as $field){
                $fieldData=new stdClass();
                $fieldData->id=$field->field_id;
                $fieldData->name=$field->field_name;
                $fieldData->measure=$field->measure;
                $fieldData->initial=$this->getStartTestResult($intent_id, $block->pattern_id, $field->field_id)[0]->value;
                $fieldData->current=$this->getTestResult($last_test->test_id, $field->field_id)[0]->value;
                $fieldData->target=$this->getTargetTestResult($intent_id, $block->pattern_id, $field->field_id)[0]->value;
                $currentTest['fields'][]=$fieldData;
            }
            $currentTest['name']=$block->test_name;
            $currentTest['datetime']=$last_test->datetime;
            $currentTest['pattern_id']=$block->pattern_id;
            $currentTest['fld']=$fields;
            $currentStatusTests[]=$currentTest;
        }
        //$currentStatusTests['id']="Test name";
        return $currentStatusTests;

    }

    public function getTestFields($pattern_id){
        if(!isset($pattern_id))return null;
        $q=$this->db->getQuery(true);
        $q->select(array("field_id", "field_name", "measure"))
            ->from("#__iguide_test_fields")
            ->where("pattern_id=".$this->db->quote($pattern_id));
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getTestResult($test_id, $field_id){
        if(!isset($test_id))return null;
        $q=$this->db->getQuery(true);
        $q->select(array("field_id", "value"))
            ->from(" #__iguide_test_values")
            ->where("test_id=".$this->db->quote($test_id));
        if(isset($field_id)) $q=$q." AND field_id=".$this->db->quote($field_id);
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getTargetTestResult($intent_id, $pattern_id, $field_id){
        $test_id=$this->getTestId($intent_id, $pattern_id, 'target');
        if(isset($test_id))return $this->getTestResult($test_id, $field_id);
    }

    public function getStartTestResult($intent_id, $pattern_id, $field_id){
        $test_id=$this->getTestId($intent_id, $pattern_id, 'initial');
        if(isset($test_id))return $this->getTestResult($test_id, $field_id);
    }

    public function getTestId($intent_id, $pattern_id, $type){
        $q="SELECT test_id
        FROM #__iguide_intent_tests
        WHERE intent_id=".$intent_id." AND pattern_id=".$pattern_id;
        if($type!="")$q=$q." AND type=".$this->db->quote($type);
        $this->db->setQuery($q);
        $test_id=$this->db->loadObject()->test_id;
        return $test_id;
    }

    public function getLastTest($intent_id, $pattern_id, $type){
        $q="SELECT test_id, datetime
            FROM #__iguide_intent_tests
            WHERE intent_id=".$intent_id." AND pattern_id=".$pattern_id." AND type=".$this->db->quote($type)."
            ORDER BY datetime DESC
            LIMIT 1";
        $this->db->setQuery($q);
        return $this->db->loadObject();
    }

    public function changeState($intentId, $fieldId, $value, $type, $userId){
                $msg=new stdClass();
        $patternId=$this->getFieldPatternId($fieldId);
        $testId=$this->getLastTest($intentId, $patternId, $type)->test_id;
                $msg->first_test_id=$testId;
        if($testId==0){
            $lastTest=$this->addTest($intentId, $patternId, $type);
            $testId=$lastTest->test_id;
                $msg->add_test=$testId;
        }
        $this->setTestValue($intentId, $testId, $fieldId, $value, $type, $userId, $patternId);
                $msg->setValue=$fieldId." = ".$value;
                return $msg;
    }

    public function setTestValue($intentId, $testId, $fieldId, $value, $type, $userId , $patternId=0){
        $current_value=$this->getTestResult($testId, $fieldId);

        if(sizeof($current_value)==0)
            $this->insertTestValue($intentId, $testId, $fieldId, $value, $userId);
        else{
            if($type=='current'){
                $lastTest=$this->addTest($intentId, $patternId, 'current');
                $this->insertTestValue($intentId, $lastTest->test_id, $fieldId, $value, $userId);
            }else $this->changeTestValue($intentId, $testId, $fieldId, $value, $userId);
        }

    }


    public function changeTestValue($intentId, $testId, $fieldId, $value, $userId){
        $dbq=$this->db->getQuery(true);
        $dbq->update("#__iguide_test_values")
            ->set(array("value=".$this->db->quote($value)))
            ->where(array("intent_id=".$this->db->quote($intentId), "test_id=".$this->db->quote($testId), "field_id=".$this->db->quote($fieldId)));
        return $this->db->setQuery($dbq)->loadResult();
    }

    public function addTest($intentId, $patternId, $type){
        $test=new stdClass();
        $test->intent_id=$intentId;
        $test->pattern_id=$patternId;
        $datetime=new DateTime('now');
        $test->datetime=$datetime->format('Y-m-d H:i:s');
        $test->type=$type;
        $this->db->insertObject("#__iguide_intent_tests", $test);
        return $this->getLastTest($intentId, $patternId, $type);
    }
    public function insertTestValue($intentId, $testId, $fieldId, $value, $userId){
        $testValue=new stdClass();
        $testValue->intent_id=$intentId;
        $testValue->test_id=$testId;
        $testValue->field_id=$fieldId;
        $testValue->value=$value;
        $this->db->insertObject("#__iguide_test_values", $testValue);
    }

    private function getFieldPatternId($fieldId){
        $dbq=$this->db->getQuery(true);
        $dbq->select("pattern_id");
        $dbq->from("#__iguide_test_fields");
        $dbq->where(array($this->db->quoteName("field_id")."=".$fieldId));
        $this->db->setQuery($dbq);
        $patternId=$this->db->loadResult();
        return $patternId;
    }

    public function addIntent($intentName, $category, $userId=0){
        #$q="INSERT INTO #__(name, category)
        #VALUES ('".$intentName."', '".$category."');";
        if($userId==0) return 0;
        $metodic=new stdClass();
        $metodic->name=$intentName;
        $metodic->category=$category;
        $metodic->user_id=$userId;
        #$this->db->setQuery($q);
        $this->db->insertObject("#__iguide_metodics", $metodic);
        $q="SELECT LAST_INSERT_ID()";
        $this->db->setQuery($q);
        $metodicId=$this->db->loadResult();
        $intent=new stdClass();
        $intent->user_id=$userId;
        $intent->metodic_id=$metodicId;
        $intent->type=$category;
        $intent->name=$intentName;
        $this->db->insertObject("#__iguide_intents", $intent);
        #$q="INSERT INTO #__iguide_intents(user_id, metodic_id, type, name)
        #VALUES ('".$userId."','".$metodicId."', '".$category."', '".$intentName."')";
        #$this->db->setQuery($q);
        $q="SELECT LAST_INSERT_ID()";
        $this->db->setQuery($q);
        $intentId=$this->db->loadResult();
        return $intentId;
    }

    public function removeIntent($intentId, $userId){
        $dbq=$this->db->getQuery(true);
        $dbq->delete($this->db->quoteName("#__iguide_intents"))
            ->where(array($this->db->quoteName('user_id')."=".$userId, $this->db->quoteName('intent_id')."=".$intentId));
        $this->db->setQuery($dbq);
        $this->db->query();
    }

    public function createControlBlock($blockName, $intentId, $userId){
        $dbq=$this->db->getQuery(true);
        $dbq->select(array("metodic_id", "user_id"));
        $dbq->from("#__iguide_intents");
        $dbq->where(array($this->db->quoteName('intent_id')."=".$intentId));
        $this->db->setQuery($dbq);
        $intentInfo=$this->db->loadObject();
        if($intentInfo->user_id!=$userId) return "Access denied!";
        else{
            $controlBlock=new stdClass();
            $controlBlock->metodic_id=$intentInfo->metodic_id;
            $controlBlock->test_name=$blockName;
            $this->db->insertObject("#__iguide_metodic_tests", $controlBlock);
            return "OK";
        }
}

    public function removeControlBlock($patternId, $userId){
        $dbq=$this->db->getQuery(true);
        $dbq->select(array("metodic_id"));
        $dbq->from("#__iguide_metodic_tests");
        $dbq->where(array($this->db->quoteName('pattern_id')."=".$patternId));
        $this->db->setQuery($dbq);
        $metodicId=$this->db->loadObject()->metodic_id;
        $dbq=$this->db->getQuery(true);
        $dbq->select(array("user_id"));
        $dbq->from("#__iguide_intents");
        $dbq->where(array($this->db->quoteName('metodic_id')."=".$metodicId));
        $this->db->setQuery($dbq);
        $AuthorId=$this->db->loadObject()->user_id;
        if($AuthorId!=$userId) return "Access denied!";
        else{
            $dbq=$this->db->getQuery(true);
            $dbq->delete($this->db->quoteName("#__iguide_metodic_tests"))
                ->where(array($this->db->quoteName('pattern_id')."=".$patternId));
            $this->db->setQuery($dbq);
            $this->db->query();
            return "OK";
        }
    }
    public function addControlBlockField($patternId, $name, $measure, $userId){
        $dbq=$this->db->getQuery(true);
        $field=new stdClass();
        $field->pattern_id=$patternId;
        $field->field_name=$name;
        $field->measure=$measure;
        $this->db->insertObject("#__iguide_test_fields", $field);
        return "OK";
}



   private function getPeopleMiniInfo($id){
       $db = $this->db;
       $q="SELECT name
       FROM #__users
       WHERE id=".$id;
       $db->setQuery($q);
       $info=$db->loadObjectList();
       return $info;
    }

    private function getPlaceMiniInfo($id){
       $db = $this->db;
       $q="SELECT name
       FROM #__iguide_places
       WHERE id=".$id;
       $db->setQuery($q);
       $info=$db->loadObjectList();
       return $info;
    }

    private function getItemMiniInfo($id){
       $db = $this->db;
       $q="SELECT name
       FROM #__iguide_items
       WHERE id=".$id;
       $db->setQuery($q);
       $info=$db->loadObjectList();
       return $info;
    }
}

?>