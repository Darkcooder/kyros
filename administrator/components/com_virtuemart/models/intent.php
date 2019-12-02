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
class VirtueMartModelIntent extends VmModel {
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
        $this->id=vRequest::getCmd("intent_id", "");
        $this->prefix="intent";
	}

    public function intentList(){
        return $this->privateAction((object)array(
            "table"=>"#__iguide_intents",
            "post_prefix"=>"intent",
            "fields"=>array("name"),
            "static_conditions"=>(object)array(
                "user_id"=>$this->userId
            ),
            "conditions"=>array(),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "default"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    public function taskTemplates(){
        return $this->linkedPrivateAction((object)array(
            "link"=>(object)array(
                "table"=>"#__iguide_intents",
                "key_field"=>"metodic_id",
                "post_prefix"=>"schedule_intent",
                "conditions"=>array("id")
            ),
            "link_key"=>"metodic_id",
            "table"=>"#__iguide_metodic_tasks",
            "post_prefix"=>"intent",
            "fields"=>array("name"),
            "conditions"=>array(),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "default"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    public function dailySchedules(){
        return $this->privateAction((object)array(
            "table"=>"#__iguide_intent_schedules",
            "post_prefix"=>"schedule",
            "fields"=>array("name"),
            "conditions"=>array("intent_id"),
            "static_conditions"=>array("period"=>"day"),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "default"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    public function weeklySchedules(){
        return $this->privateAction((object)array(
            "table"=>"#__iguide_intent_schedules",
            "post_prefix"=>"schedule",
            "fields"=>array("name"),
            "conditions"=>array("intent_id"),
            "static_conditions"=>array("period"=>"week"),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "default"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

    public function monthlySchedules(){
        return $this->privateAction((object)array(
            "table"=>"#__iguide_intent_schedules",
            "post_prefix"=>"schedule",
            "fields"=>array("name"),
            "conditions"=>array("intent_id"),
            "static_conditions"=>array("period"=>"month"),
            "access_flag"=>"ig_acc",
            "access_policy"=>(object)array(
                "vip"=>(object)array(
                    "my"=>array("add", "edit", "get", "remove"),
                    "foreign"=>array("get")
                ),
                "default"=>(object)array(
                    "my"=>array("get", "edit", "remove"),
                    "foreign"=>array("get")
                )
            )
        ));
    }

     public function getIntentsList(){
        $intentsList=array();
        $q="SELECT i.id as id, i.category_id as type_id, i.name as name, cat.category_name as category
            FROM #__iguide_intents as i
            LEFT JOIN #__virtuemart_categories_".VmConfig::$vmlang." as cat
            ON i.category_id=cat.slug
            WHERE user_id=".$this->userId;
		$intentsList = $this->_getList($q);
        return $intentsList;
    }

    public function getIntentList(){
        $output=array();
        $intents=$this->getRootElements(array("id", "name", "category_id"), array());
        foreach($intents as $intent){
            array_push($output, (object)array(
                "id"=>$intent->id,
                "info"=>(object)array(
                    "name"=>$intent->name,
                    "category"=>$intent->category_id
                )
            ));
        }
        return $output;
    }

    public function getIntent(){
        if($this->id==0) return 0;
        $intent=new stdClass();
        $intent->id=$this->id;
        $q="SELECT i.name as intent_name, i.category_id as category_id, i.user_id as user_id, cat.category_name as category_name,
            i.metodic_id as metodic_id, m.name as metodic_name,
            uc.name as coach_name, uc.id as coach_id, g.name as group_name, g.id as group_id
            FROM #__iguide_intents as i
            LEFT JOIN #__virtuemart_categories_".VmConfig::$vmlang." as cat
            ON i.category_id=cat.slug
            LEFT JOIN #__iguide_metodics as m
            ON i.metodic_id=m.metodic_id
            LEFT JOIN #__users as uc
            ON i.coach_user_id=uc.id
            LEFT JOIN #__iguide_groups as g
            ON i.group_id=g.id
            WHERE id=".$this->id;
        $this->db->setQuery($q);
		$intent->info = $this->db->loadObject();
        if($intent->info->user_id!=$this->userId){
            $intent->info=new stdClass();
            $intent->status="Access denied!";
            return $intent;
        }
        $intent->status="OK";

        $q="SELECT source_type as type, source_id as id
            FROM #__iguide_sources
            WHERE intent_id=".$this->id;
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

    private function getMetodicId(){
        $q=$this->db->getQuery(true);
        $q->select("metodic_id")
            ->from("#__iguide_intents")
            ->where(("id=").$this->db->quote($this->id));
        return $this->db->setQuery($q)->loadResult();
    }

    private function getControlBlocks(){
        $metodicId=$this->getMetodicId();
        $q=$this->db->getQuery(true);
        $q->select(array("id", "name", "power"))
            ->from("#__iguide_metodic_tests")
            ->where("metodic_id=".$this->db->quote($metodicId));
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getTaskTemplates(){
        $metodic=VmModel::getModel('metodic');
        $metodic->id=$this->getMetodicId();
        return $metodic->getTaskTemplates();
    }

    public function getTaskTemplates_(){
        $metodic=VmModel::getModel('metodic');
        $metodic->id=$this->getMetodicId();
        return $metodic->_getTaskTemplates();
    }

    public function getCurrentIntentStatus(){

        $cBlocks=$this->getControlBlocks();

        $currentStatusTests=array();

        foreach ($cBlocks as $block){
            $last_test=$this->getLastTest($block->id, 'current');

            $currentTest=array();
            $fields=$this->getTestFields($block->id);
            $currentTest['fields']=array();
            foreach($fields as $field){
                $fieldData=new stdClass();
                $fieldData->id=$field->id;
                $fieldData->name=$field->name;
                $fieldData->measure=$field->measure;
                $fieldData->power=$field->power;
                $fieldData->initial=$this->getStartTestResult($block->id, $field->id)[0]->value;
                $fieldData->current=$this->getTestResult($last_test->id, $field->id)[0]->value;
                $fieldData->target=$this->getTargetTestResult($block->id, $field->id)[0]->value;
                $currentTest['fields'][]=$fieldData;
            }            
            $currentTest['name']=$block->name;
            $currentTest['datetime']=$last_test->datetime;
            $currentTest['id']=$block->id;
            $currentTest['id']=$block->id;
            $currentTest['power']=$block->power;
            $currentTest['fld']=$fields;
            $currentStatusTests[]=$currentTest;
        }
        //$currentStatusTests['id']="Test name";
        return $currentStatusTests;

    }
    
    public function getTestFields($id){
        if(!isset($id))return null;
        $q=$this->db->getQuery(true);
        $q->select(array("id", "name", "measure", "power"))
            ->from("#__iguide_metodic_fields")
            ->where("metodic_test_id=".$this->db->quote($id));
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getTestResult($id, $field_id){
        if(!isset($id))return null;
        $q=$this->db->getQuery(true);
        $q->select(array("field_id", "value"))
            ->from(" #__iguide_test_values")
            ->where("test_id=".$this->db->quote($id));
        if(isset($field_id)) $q=$q." AND field_id=".$this->db->quote($field_id);
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getTargetTestResult($id, $field_id){
        $test_id=$this->getTestId($id, 'target');
        if(isset($test_id))return $this->getTestResult($test_id, $field_id);
    }

    public function getStartTestResult($id, $field_id){
        $test_id=$this->getTestId($id, 'initial');
        if(isset($test_id))return $this->getTestResult($test_id, $field_id);
    }

    public function getTestId($id, $type){
        $q="SELECT id
        FROM #__iguide_intent_tests
        WHERE intent_id=".$this->id." AND metodic_test_id=".$id;
        if($type!="")$q=$q." AND type=".$this->db->quote($type);
        $this->db->setQuery($q);
        $test_id=$this->db->loadObject()->id;
        return $test_id;
    }
    
    public function getLastTest($id, $type){
        $q="SELECT id, datetime
            FROM #__iguide_intent_tests
            WHERE intent_id=".$this->id." AND metodic_test_id=".$id." AND type=".$this->db->quote($type)."
            ORDER BY datetime DESC
            LIMIT 1";
        $this->db->setQuery($q);
        return $this->db->loadObject();
    }

    public function changeState($fieldId, $value, $type){
                $msg=new stdClass();
        $patternId=$this->getFieldPatternId($fieldId);
        $testId=$this->getLastTest($patternId, $type)->id;
                $msg->first_test_id=$testId;
        if($testId==0){
            $lastTest=$this->addTest($patternId, $type);
            $testId=$lastTest->id;
                $msg->add_test=$testId;
        }
        $this->setTestValue($testId, $fieldId, $value, $type, $userId, $patternId);
                $msg->setValue=$fieldId." = ".$value;
                return $msg;
    }
    
    public function setTestValue($testId, $fieldId, $value, $type, $userId , $patternId=0){
        $current_value=$this->getTestResult($testId, $fieldId);

        if(sizeof($current_value)==0)
            $this->insertTestValue($testId, $fieldId, $value, $userId);
        else{
            if($type=='current'){
                $lastTest=$this->addTest($patternId, 'current');
                $this->insertTestValue($lastTest->id, $fieldId, $value, $userId);
            }else $this->changeTestValue($testId, $fieldId, $value, $userId);
        }
            
    }


    public function changeTestValue($testId, $fieldId, $value, $userId){
        $dbq=$this->db->getQuery(true);
        $dbq->update("#__iguide_test_values")
            ->set(array("value=".$this->db->quote($value)))
            ->where(array("intent_id=".$this->db->quote($this->id), "test_id=".$this->db->quote($testId), "field_id=".$this->db->quote($fieldId)));
        return $this->db->setQuery($dbq)->loadResult();
    }

    public function addTest($patternId, $type){
        $test=new stdClass();
        $test->intent_id=$this->id;
        $test->metodic_test_id=$patternId;
        $datetime=new DateTime('now');
        $test->datetime=$datetime->format('Y-m-d H:i:s');
        $test->type=$type;
        $this->db->insertObject("#__iguide_intent_tests", $test);
        return $this->getLastTest($patternId, $type);
    }
    public function insertTestValue($testId, $fieldId, $value, $userId){
        $testValue=new stdClass();
        $testValue->intent_id=$this->id;
        $testValue->test_id=$testId;
        $testValue->field_id=$fieldId;
        $testValue->value=$value;
        $this->db->insertObject("#__iguide_test_values", $testValue);
    }

    private function getFieldPatternId($fieldId){
        $dbq=$this->db->getQuery(true);
        $dbq->select("metodic_test_id");
        $dbq->from("#__iguide_metodic_fields");
        $dbq->where(array($this->db->quoteName("id")."=".$fieldId));
        $this->db->setQuery($dbq);
        $patternId=$this->db->loadResult();
        return $patternId;
    }

    public function addIntent($intentName, $category){
        #$q="INSERT INTO #__(name, category)
        #VALUES ('".$intentName."', '".$category."');";
        if($this->userId==0) return 0;
        $metodic=new stdClass();
        $metodic->name=$intentName;
        $metodic->category=$category;
        $metodic->user_id=$this->userId;
        #$this->db->setQuery($q);
        $this->db->insertObject("#__iguide_metodics", $metodic);
        $q="SELECT LAST_INSERT_ID()";
        $this->db->setQuery($q);
        $metodicId=$this->db->loadResult();
        $intent=new stdClass();
        $intent->user_id=$this->userId;
        $intent->metodic_id=$metodicId;
        $intent->category_id=$category;
        $intent->name=$intentName;
        $this->db->insertObject("#__iguide_intents", $intent);
        #$q="INSERT INTO #__iguide_intents(user_id, metodic_id, type, name)
        #VALUES ('".$userId."','".$metodicId."', '".$category."', '".$intentName."')";
        #$this->db->setQuery($q);
        $q="SELECT LAST_INSERT_ID()";
        $this->db->setQuery($q);
        $this->id=$this->db->loadResult();
        return $this->id;
    }

    public function removeIntent(){
        $dbq=$this->db->getQuery(true);
        $dbq->delete($this->db->quoteName("#__iguide_intents"))
            ->where(array($this->db->quoteName('user_id')."=".$this->userId, $this->db->quoteName('id')."=".$this->id));
        $this->db->setQuery($dbq);
        $this->db->query();
    }

    public function createControlBlock($blockName){
        $dbq=$this->db->getQuery(true);
        $dbq->select(array("metodic_id", "user_id"));
        $dbq->from("#__iguide_intents");
        $dbq->where(array($this->db->quoteName('id')."=".$this->id));
        $this->db->setQuery($dbq);
        $intentInfo=$this->db->loadObject();
        if($intentInfo->user_id!=$this->userId) return "Access denied!";
        else{
            $controlBlock=new stdClass();
            $controlBlock->metodic_id=$intentInfo->metodic_id;
            $controlBlock->test_name=$blockName;
            $this->db->insertObject("#__iguide_metodic_tests", $controlBlock);
            return "OK";
        }
}

    public function removeControlBlock($patternId){
        $dbq=$this->db->getQuery(true);
        $dbq->select(array("metodic_id"));
        $dbq->from("#__iguide_metodic_tests");
        $dbq->where(array($this->db->quoteName('id')."=".$patternId));
        $this->db->setQuery($dbq);
        $metodicId=$this->db->loadObject()->metodic_id;
        $dbq=$this->db->getQuery(true);
        $dbq->select(array("user_id"));
        $dbq->from("#__iguide_intents");
        $dbq->where(array($this->db->quoteName('metodic_id')."=".$metodicId));
        $this->db->setQuery($dbq);
        $AuthorId=$this->db->loadObject()->user_id;
        if($AuthorId!=$this->userId) return "Access denied!";
        else{
            $dbq=$this->db->getQuery(true);
            $dbq->delete($this->db->quoteName("#__iguide_metodic_tests"))
                ->where(array($this->db->quoteName('id')."=".$patternId));
            $this->db->setQuery($dbq);
            $this->db->query();
            return "OK";
        }
    }
    public function addControlBlockField($patternId, $name, $measure){
        $dbq=$this->db->getQuery(true);
        $field=new stdClass();
        $field->id=$patternId;
        $field->name=$name;
        $field->measure=$measure;
        $this->db->insertObject("#__iguide_metodic_fields", $field);
        return "OK";
}

private function getPlanBlocks(){
        $metodicId=$this->getMetodicId();
        $q=$this->db->getQuery(true);
        $q->select(array("id", "name"))
            ->from("#__iguide_metodic_plans")
            ->where("metodic_id=".$this->db->quote($metodicId));
        return $this->db->setQuery($q)->loadObjectList();
    }
    private function getHardTasks($blockId){
         $q->select(array("id", "datetime", "name"))
            ->from("#__iguide_hardtasks")
            ->where("block_id=".$this->db->quote($blockId));
        return $this->db->setQuery($q)->loadObjectList();
    }
    private function getFlexTasks($blockId){
         $q->select(array("id", "name"))
            ->from("#__iguide_flextasks")
            ->where("block_id=".$this->db->quote($blockId));
        return $this->db->setQuery($q)->loadObjectList();
    }
    private function getFlexTaskSources($taskId){
         $q->select(array("type", "id"))
            ->from("#__iguide_flextasks")
            ->where("block_id=".$this->db->quote($blockId));
        return $this->db->setQuery($q)->loadObjectList();
    }

    public function getTodayTasks(){
        $flexTasks=new stdClass();
        $flexTasks->name=vmText::_('COM_IGUIDE_FLEX_TASKS');
        $flexTasks->fields=$this->getTodayFlexTasks();
        $flexTasks->id=0;
        $hardTasks=new stdClass();
        $hardTasks->name=vmText::_('COM_IGUIDE_HARD_TASKS');
        $hardTasks->fields=$this->getTodayHardTasks();
        $hardTasks->id=1;
        return array($flexTasks, $hardTasks);
    }

    public function addTask(){
    $form=$this->getForm();
    $date=Date("Y-m-d");
    $properities=array(
             "name"=>$form["name"],
             "metodic_task_id"=>$form["metodic_task_id"],
             "date"=>$form["date"]
         );
         $isHard=$form["ishard"];

         if($isHard==1){
              $blockName="hardtask";
              $properities['time']=$form["time"];
         }else{
             $blockName="flextask";
         }
         //return $form;


         if($form['sc']=="on"){
             $scPro=array(
                "name"=>$form["name"],
                "metodic_task_id"=>$form["metodic_task_id"],
                "period"=>$form["sc_period"]
             );
             $scName="schedule";

             $daySelector="period";
             if($scPro['period']=="week") $daySelector="weekday";
             if($scPro['period']=="month") $daySelector="day";

             foreach($this->getMultiple("sc_".$daySelector) as $day){
                  $scPro[$daySelector]=$day;
                  $this->addBlock($scName, $scPro);
             }

         }

        return $this->addBlock($blockName, $properities);
    }

    public function getSchedules(){

        $pro=array(
            "id",
            "metodic_task_id",
            "period",
            "weekday",
            "day",
            "name"
        );

        return $this->getBlocks("schedule", $pro);
    }

    public function _getSchedules(){
        $daily=(object)array(
            "tasks"=>$this->getElements(array("id", "metodic_task_id", "name"), array("schedule"), array("period"=>"day")),
            "properities"=>(object)array(
                "name"=>vmText::_('COM_IGUIDE_DAILY_TASKS'),
                "period"=>"day"
            )
        );
        $weekly=(object)array(
            "tasks"=>$this->getElements(array("id", "metodic_task_id", "weekday", "name"), array("schedule"), array("period"=>"week")),
            "properities"=>(object)array(
                "name"=>vmText::_('COM_IGUIDE_WEEKLY_TASKS'),
                "period"=>"week"
            )
        );
        $monthly=(object)array(
            "tasks"=>$this->getElements(array("id", "metodic_task_id", "day", "name"), array("schedule"), array("period"=>"month")),
            "properities"=>(object)array(
                "name"=>vmText::_('COM_IGUIDE_MONTHLY_TASKS'),
                "period"=>"month"
            )
        );

        return array($daily, $weekly, $monthly);
    }

    public function getTodayHardTasks(){
        $staticPro=array("source_type"=>"time");
        $s=array("id", "time", "name");
        $en=array("hardtask");
        $c=array("date"=>Date("Y-m-d"));
        return $this->pushPro($this->getElements($s, $en, $c), $staticPro);
    }
    public function getTodayFlexTasks(){
        $q=$this->_db->getQuery(true);
        $today=Date("Y-m-d");
        $q->select(array("id", "source_type", "source_id", "name"))
            ->from("#__iguide_intent_flextasks")
            ->where("intent_id=".$this->_db->quote($this->id)." AND date=".$this->_db->quote($today));
        return $this->_db->setQuery($q)->loadObjectList();
    }
    public function getDailyTasks(){
        $date=$this->getCmd("date");
        $flexTasks=new stdClass();
        $flexTasks->name=vmText::_('COM_IGUIDE_FLEX_TASKS');
        $flexTasks->fields=$this->getDailyList($date, "flextask", array("id", "source_type", "source_id", "name"));
        $flexTasks->id=1;
        $hardTasks=new stdClass();
        $hardTasks->name=vmText::_('COM_IGUIDE_HARD_TASKS');
        $hardTasks->fields=$this->pushPro($this->getDailyList($date, "hardtask", array("id", "time", "name")), array("source_type"=>"time"));
        $hardTasks->id=0;
        $weeklyTasks=new stdClass();
        $wdays=array("sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
        $weeklyTasks->name=vmText::_('COM_IGUIDE_WEEKLY_TASKS');
        $weeklyTasks->fields=$this->getElements(array("id", "source_type", "source_id", "name"), array("schedule"), array("period"=>"week", "weekday"=>$wdays[date("w",strtotime($date) )]));
        $weeklyTasks->id=2;
        $monthlyTasks=new stdClass();
        $monthlyTasks->name=vmText::_('COM_IGUIDE_MONTHLY_TASKS');
        $monthlyTasks->fields=$this->getElements(array("id", "source_type", "source_id", "name"), array("schedule"), array("period"=>"month", "day"=>date("j", strtotime($date))));
        $monthlyTasks->id=3;
        return array($hardTasks, $flexTasks, $weeklyTasks, $monthlyTasks);
    }

    public function getDailyList($date, $elementName, $select){
        $q=$this->_db->getQuery(true);
        $q->select($select)
            ->from("#__iguide_".$this->prefix."_".$elementName."s")
            ->where("intent_id=".$this->_db->quote($this->id)." AND date=".$this->_db->quote($date));
        return $this->_db->setQuery($q)->loadObjectList();
    }

    public function getControlProgress(){
        $mTestId=$this->getCmd("block");
        $mFieldId=$this->getCmd("row");
        $q=$this->_db->getQuery(true);
        $q->select(array("id", "datetime"))
            ->from("#__iguide_intent_tests")
            ->where("metodic_test_id=".$this->_db->quote($mTestId));
        $testsTable=$this->_db->setQuery($q)->loadObjectList();
        $tests=new stdClass();
        $tests->target=$this->getTargetTestResult($mTestId, $mFieldId)[0]->value;
        $tests->progress=array();

        foreach ($testsTable as $test){
            $testResult=new stdClass();
            $testResult->datetime=$test->datetime;
            $testResult->value=$this->getTestResult($test->id, $mFieldId)[0]->value;
             array_push($tests->progress, $testResult);
        }

        return $tests;
    }

    public function getDailySchedules(){
        $schedules=array();
        foreach($this->getElements(array("id", "source_type", "source_id", "name", "metodic_task_id"), array("schedule"), array("period"=>"day")) as $schedule){
            $task=$this->getElementsByTableName(array("id, name"), "#__iguide_metodic_tasks", array("id"=>$schedule->metodic_task_id))[0];
            array_push($schedules, (object)array("id"=>$schedule->id,
               "info"=>(object)array(
                    "name"=>$schedule->name,
                    "source_type"=>$schedule->source_type,
                    "source_id"=>$schedule->source_id,
                    "category"=>$task->name
               ),
               "actions"=>array("remove", "edit")
            ));
        }
        return $schedules;
    }

    public function getWeeklySchedules(){
        $schedules=array();
        foreach($this->getElements(array("id", "source_type", "source_id", "name", "weekday", "metodic_task_id"), array("schedule"), array("period"=>"week")) as $schedule){
            $task=$this->getElementsByTableName(array("id, name"), "#__iguide_metodic_tasks", array("id"=>$schedule->metodic_task_id))[0];
            array_push($schedules, (object)array("id"=>$schedule->id,
               "info"=>(object)array(
                    "name"=>$schedule->name,
                    "source_type"=>$schedule->source_type,
                    "source_id"=>$schedule->source_id,
                    "weekday"=>$schedule->weekday,
                    "category"=>$task->name
               ),
               "actions"=>array("remove", "edit")
            ));
        }
        return $schedules;
    }

    public function getMonthlySchedules(){
        $schedules=array();
        foreach($this->getElements(array("id", "source_type", "source_id", "name", "day", "metodic_task_id"), array("schedule"), array("period"=>"month")) as $schedule){
            $task=$this->getElementsByTableName(array("id, name"), "#__iguide_metodic_tasks", array("id"=>$schedule->metodic_task_id))[0];
            array_push($schedules, (object)array("id"=>$schedule->id,
               "info"=>(object)array(
                    "name"=>$schedule->name,
                    "source_type"=>$schedule->source_type,
                    "source_id"=>$schedule->source_id,
                    "day"=>$schedule->day,
                    "category"=>$task->name
               ),
               "actions"=>array("remove", "edit")
            ));
        }
        return $schedules;
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