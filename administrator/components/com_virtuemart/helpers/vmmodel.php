<?php
/**
 * abstract model class containing some standards
 *  get,store,delete,publish and pagination
 *
 * @package	VirtueMart
 * @subpackage Helpers
 * @author Max Milbers
 * @copyright Copyright (c) 2011 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
 *
 * http://virtuemart.net
 */

defined('_JEXEC') or die();

define('USE_SQL_CALC_FOUND_ROWS' , true);

if(!class_exists('vObject')) require(VMPATH_ADMIN .DS. 'helpers' .DS. 'vobject.php');

class VmModel extends vObject{

	/**
	 * Indicates if the internal state has been set
	 *
	 * @var    boolean
	 * @since  11.1
	 */
	protected $__state_set = null;
	/**
	 * The model (base) name
	 *
	 * @var    string
	 * @note   Replaces _name variable in 11.1
	 * @since  11.1
	 */
	protected $name;

	/**
	 * The URL option for the component.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $option = null;

	/**
	 * A state object
	 *
	 * @var    string
	 * @note   Replaces _state variable in 11.1
	 * @since  11.1
	 */
	protected $state;

	/**
	 * The event to trigger when cleaning cache.
	 *
	 * @var      string
	 * @since    11.1
	 */
	protected $event_clean_cache = null;

	var $_id 			= 0;
	var $_data			= null;
	private static $_cache = array();
	var $_query 		= null;

	var $_total			= null;
	var $_pagination 	= 0;
	var $_limit			= 0;
	var $_limitStart	= 0;
	var $_maintable 	= '';	// something like #__virtuemart_calcs
	var $_maintablename = '';
	var $_idName		= '';
	var $_cidName		= 'cid';
	var $_togglesName	= null;
	var $_selectedOrderingDir = 'DESC';
	private $_withCount = true;
	var $_noLimit = false;

	public function __construct($cidName='cid', $config=array()){

        //Added for WX project by Valdimir Bugorkov
        $this->action=$this->getCmd("action");

		// Guess the option from the class name (Option)Model(View).
		if (empty($this->option))
		{
			$r = null;

			if (!preg_match('/(.*)Model/i', get_class($this), $r))
			{
				throw new Exception(vmText::_('JLIB_APPLICATION_ERROR_MODEL_GET_NAME'), 500);
			}

			$this->option = 'com_' . strtolower($r[1]);
		}

		// Set the view name
		if (empty($this->name))
		{
			if (array_key_exists('name', $config))
			{
				$this->name = $config['name'];
			}
			else
			{
				$this->name = $this->getName();
			}
		}

		// Set the model state
		if (array_key_exists('state', $config))
		{
			$this->state = $config['state'];
		}
		else
		{
			$this->state = new JObject;
		}

		// Set the model dbo
		if (array_key_exists('dbo', $config))
		{
			$this->_db = $config['dbo'];
		}
		else
		{
			$this->_db = JFactory::getDbo();
		}

		// Set the default view search path
		if (array_key_exists('table_path', $config))
		{
			$this->addTablePath($config['table_path']);
		}
		elseif (defined('VMPATH_ADMIN'))
		{
			$this->addTablePath(VMPATH_ADMIN . '/tables');
		}

		// Set the internal state marker - used to ignore setting state from the request
		if (!empty($config['ignore_request']))
		{
			$this->__state_set = true;
		}

		// Set the clean cache event
		if (isset($config['event_clean_cache']))
		{
			$this->event_clean_cache = $config['event_clean_cache'];
		}
		elseif (empty($this->event_clean_cache))
		{
			$this->event_clean_cache = 'onContentCleanCache';
		}

		$this->_cidName = $cidName;

		// Get the task
		$task = vRequest::getCmd('task','');
		if($task!=='add' and !empty($this->_cidName)){
			// Get the id or array of ids.
			$idArray = vRequest::getVar($this->_cidName,  0);
			if($idArray){
				if(is_array($idArray) and isset($idArray[0])){
					$this->setId((int)$idArray[0]);
				} else{
					$this->setId((int)$idArray);
				}
			}

		}
		$this->_db = JFactory::getDbo();
		$this->setToggleName('published');
	}

	static private $_vmmodels = array();



	/**
	 * Method to get the model name
	 *
	 * The model name. By default parsed using the classname or it can be set
	 * by passing a $config['name'] in the class constructor
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 * @return  string  The name of the model
	 *
	 * @since   12.2
	 * @throws  Exception
	 */
	public function getName()
	{
		if (empty($this->name))
		{
			$r = null;
			if (!preg_match('/Model(.*)/i', get_class($this), $r))
			{
				throw new Exception(vmText::_('JLIB_APPLICATION_ERROR_MODEL_GET_NAME'), 500);
			}
			$this->name = strtolower($r[1]);
		}

		return $this->name;
	}

	/**
	 * Adds to the stack of model table paths in LIFO order.
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   mixed  $path  The directory as a string or directories as an array to add.
	 *
	 * @return  void
	 *
	 * @since   12.2
	 */
	public static function addTablePath($path)
	{
		VmTable::addIncludePath($path);
	}

	/**
	 * Create the filename for a resource
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $type   The resource type to create the filename for.
	 * @param   array   $parts  An associative array of filename information.
	 *
	 * @return  string  The filename
	 *
	 * @since   11.1
	 */
	protected static function _createFileName($type, $parts = array())
	{
		$filename = '';

		switch ($type)
		{
			case 'model':
				$filename = strtolower($parts['name']) . '.php';
				break;

		}
		return $filename;
	}

	/**
	 * Method to set model state variables
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $value     The value of the property to set or null.
	 *
	 * @return  mixed  The previous value of the property or null if not set.
	 *
	 * @since   12.2
	 */
	public function setState($property, $value = null)
	{
		return $this->state->set($property, $value);
	}

	/**
	 * Method to get model state variables
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $property  Optional parameter name
	 * @param   mixed   $default   Optional default value
	 *
	 * @return  object  The property where specified, the state object where omitted
	 *
	 * @since   11.1
	 */
	public function getState($property = null, $default = null)
	{
		if (!$this->__state_set)
		{
			// Protected method to auto-populate the model state.
			$this->populateState();

			// Set the model state set flag to true.
			$this->__state_set = true;
		}

		return $property === null ? $this->state : $this->state->get($property, $default);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * @return  void
	 *
	 * @note    Calling getState in this method will result in recursion.
	 * @since   11.1
	 */
	protected function populateState()
	{
	}

	/**
	 * Add a directory where JModel should search for models. You may
	 * either pass a string or an array of directories.
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   mixed   $path    A path or array[sting] of paths to search.
	 * @param   string  $prefix  A prefix for models.
	 *
	 * @return  array  An array with directory elements. If prefix is equal to '', all directories are returned.
	 *
	 * @since   11.1
	 */
	public static function addIncludePath($path = '', $prefix = '')
	{
		static $paths;

		if (!isset($paths))
		{
			$paths = array();
		}

		if (!isset($paths[$prefix]))
		{
			$paths[$prefix] = array();
		}

		if (!isset($paths['']))
		{
			$paths[''] = array();
		}

		if (!empty($path))
		{
			//jimport('joomla.filesystem.path');

			if (!in_array($path, $paths[$prefix]))
			{
				array_unshift($paths[$prefix], vRequest::filterPath($path));
			}

			if (!in_array($path, $paths['']))
			{
				array_unshift($paths[''], vRequest::filterPath($path));
			}
		}

		return $paths[$prefix];
	}

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $name     The table name. Optional.
	 * @param   string  $prefix   The class prefix. Optional.
	 * @param   array   $options  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   11.1
	 */
	public function getTable($name = '', $prefix = 'Table', $options = array())
	{
		if (empty($name))
		{
			$name = $this->getName();
		}

		if ($table = $this->_createTable($name, $prefix, $options))
		{
			return $table;
		}

		JError::raiseError(0, vmText::sprintf('JLIB_APPLICATION_ERROR_TABLE_NAME_NOT_SUPPORTED', $name));

		return null;
	}


	/**
	 * Method to load and return a model object.
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $name    The name of the view
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration settings to pass to JTable::getInstance
	 *
	 * @return  mixed  Model object or boolean false if failed
	 *
	 * @since   11.1
	 * @see     JTable::getInstance
	 */
	protected function _createTable($name, $prefix = 'Table', $config = array())
	{
		// Clean the model name
		$name = preg_replace('/[^A-Z0-9_]/i', '', $name);
		$prefix = preg_replace('/[^A-Z0-9_]/i', '', $prefix);

		// Make sure we are returning a DBO object
		if (!array_key_exists('dbo', $config))
		{
			$config['dbo'] = JFactory::getDbo();
		}

		return VmTable::getInstance($name, $prefix, $config);
	}

	/**
	 * Returns a Model object, always creating it
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $type    The model type to instantiate
	 * @param   string  $prefix  Prefix for the model class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  mixed   A model object or false on failure
	 *
	 * @since   11.1
	 */
	public static function getInstance($type, $prefix = '', $config = array())
	{
		$type = preg_replace('/[^A-Z0-9_\.-]/i', '', $type);
		$modelClass = $prefix . ucfirst($type);

		if (!class_exists($modelClass))
		{
			$path = JPath::find(self::addIncludePath(null, $prefix), self::_createFileName('model', array('name' => $type)));
			if (!$path)
			{
				$path = JPath::find(self::addIncludePath(null, ''), self::_createFileName('model', array('name' => $type)));
			}
			if ($path)
			{
				require_once $path;

				if (!class_exists($modelClass))
				{
					vmWarn(vmText::sprintf('JLIB_APPLICATION_ERROR_MODELCLASS_NOT_FOUND', $modelClass));
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		return new $modelClass($config);
	}

	/**
	 * Gets an array of objects from the results of database query.
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string   $query       The query.
	 * @param   integer  $limitstart  Offset.
	 * @param   integer  $limit       The number of records.
	 *
	 * @return  array  An array of results.
	 *
	 * @since   11.1
	 */
	protected function _getList($query, $limitstart = 0, $limit = 0)
	{
		$this->_db->setQuery($query, $limitstart, $limit);
		$result = $this->_db->loadObjectList();

		return $result;
	}

	/**
	 * Returns a record count for the query
	 *
	 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 *
	 * @param   string  $query  The query.
	 *
	 * @return  integer  Number of rows for query
	 *
	 * @since   11.1
	 */
	protected function _getListCount($query)
	{
		$this->_db->setQuery($query);
		$this->_db->execute();

		return $this->_db->getNumRows();
	}

	/**
	 *
	 * @author Patrick Kohl
	 * @author Max Milbers
	 */
	static function getModel($name=false){

		if (!$name){
			$name = vRequest::getCmd('view','');
// 			vmdebug('Get standard model of the view');
		}
		$name = strtolower($name);
		$className = 'VirtueMartModel'.ucfirst($name);


		if(empty(self::$_vmmodels[strtolower($className)])){
			if( !class_exists($className) ){

				$modelPath = VMPATH_ADMIN.DS."models".DS.$name.".php";

				if( file_exists($modelPath) ){
					require( $modelPath );
				}
				else{
					vmWarn( 'Model '. $name .' not found.' );
					echo 'File for Model '. $name .' not found.';
					return false;
				}
			}

			self::$_vmmodels[strtolower($className)] = new $className();
			return self::$_vmmodels[strtolower($className)];
		} else {
			return self::$_vmmodels[strtolower($className)];
		}

	}

	public function setIdName($idName){
		$this->_idName = $idName;
	}

	public function getIdName(){
		return $this->_idName;
	}

	public function getId(){
		return $this->_id;
	}

	/**
	 * Resets the id and data
	 *
	 * @author Max Milbers
	 *
	 */
	function setId($id){

		if(is_array($id) && count($id)!=0){
			reset($id);
			$id = current($id);
		}
		if($this->_id!=$id){
			$this->_id = (int)$id;
			$this->_data = null;
		}
		return $this->_id;
	}


	public function setMainTable($maintablename,$maintable=0){

		$this->_maintablename = $maintablename;
		if(empty($maintable)){
			$this->_maintable = '#__iguide_'.$maintablename;
		} else {
			$this->_maintable = $maintable;
		}
		$defaultTable = $this->getTable($this->_maintablename);
		$this->_idName = $defaultTable->getKeyName();

		$this->setDefaultValidOrderingFields($defaultTable);
		$this->_selectedOrdering = $this->_validOrderingFieldName[0];

	}

	function getDefaultOrdering(){
		return $this->_selectedOrdering;
	}


	function addvalidOrderingFieldName($add){
		$this->_validOrderingFieldName = array_merge($this->_validOrderingFieldName,$add);
	}

	function removevalidOrderingFieldName($name){
		$key=array_search($name, $this->_validOrderingFieldName);
		if($key!==false){
			unset($this->_validOrderingFieldName[$key]) ;
		}
	}

	var $_tablePreFix = '';
	/**
	 *
	 * This function sets the valid ordering fields for this model with the default table attributes
	 * @author Max Milbers
	 * @param unknown_type $defaultTable
	 */
	function setDefaultValidOrderingFields($defaultTable=null){

		if($defaultTable===null){
			$defaultTable = $this->getTable($this->_maintablename);
		}

		$this->_tablePreFix = $defaultTable->_tablePreFix;
		$dTableArray = get_object_vars($defaultTable);

		// Iterate over the object variables to build the query fields and values.
		foreach ($dTableArray as $k => $v){

			// Ignore any internal fields.
			$posUnderLine = strpos ($k,'_');

			if (( $posUnderLine!==false && $posUnderLine === 0) ) {
				continue;
			}

// 			$this->_validOrderingFieldName[] = $this->_tablePreFix.$k;
			$this->_validOrderingFieldName[] = $k;

		}

	}


	function _getOrdering($preTable='') {
		if(empty($this->_selectedOrdering)) vmTrace('empty _getOrdering');
		if(empty($this->_selectedOrderingDir)) vmTrace('empty _selectedOrderingDir');
		return ' ORDER BY '.$preTable.$this->_selectedOrdering.' '.$this->_selectedOrderingDir ;
	}


	var $_validOrderingFieldName = array();

	function checkFilterOrder($toCheck){

		if(empty($toCheck)) return $this->_selectedOrdering;

		if(!in_array($toCheck, $this->_validOrderingFieldName)){

			$break = false;
			foreach($this->_validOrderingFieldName as $name){
				if(!empty($name) and strpos($name,$toCheck)!==FALSE){
					$this->_selectedOrdering = $name;
					$break = true;
					break;
				}
			}
			if(!$break){
				$app = JFactory::getApplication();
				$view = vRequest::getCmd('view');
				if (empty($view)) $view = 'virtuemart';
				$app->setUserState( 'com_virtuemart.'.$view.'.filter_order',$this->_selectedOrdering);
			}
		} else {
			$this->_selectedOrdering = $toCheck;
		}

		return $this->_selectedOrdering;
	}

	var $_validFilterDir = array('ASC','DESC');
	function checkFilterDir($toCheck){

		$filter_order_Dir = strtoupper($toCheck);

		if(empty($filter_order_Dir) or !in_array($filter_order_Dir, $this->_validFilterDir)){
			$filter_order_Dir = $this->_selectedOrderingDir;
			$view = vRequest::getCmd('view');
			if (empty($view)) $view = 'virtuemart';
			$app = JFactory::getApplication();
			$app->setUserState( 'com_virtuemart.'.$view.'.filter_order_Dir',$filter_order_Dir);
		}

		$this->_selectedOrderingDir = $filter_order_Dir;
		return $this->_selectedOrderingDir;
	}


	/**
	 * Loads the pagination
	 *
	 * @author Max Milbers
	 */
	public function getPagination($perRow = 5) {

		if(!class_exists('VmPagination')) require(VMPATH_ADMIN.DS.'helpers'.DS.'vmpagination.php');
		if(empty($this->_limit) ){
			$this->setPaginationLimits();
		}

		$this->_pagination = new VmPagination($this->_total , $this->_limitStart, $this->_limit , $perRow );

		return $this->_pagination;
	}

	public function setPaginationLimits(){

		$app = JFactory::getApplication();
		$view = vRequest::getCmd('view');
		if (empty($view)) $view = $this->_maintablename;

		$limit = (int)$app->getUserStateFromRequest('com_virtuemart.'.$view.'.limit', 'limit');
		if(empty($limit)){
			if($app->isSite()){
				$limit = VmConfig::get ('llimit_init_FE',24);
			} else {
				$limit = VmConfig::get ('llimit_init_BE',30);
			}
			if(empty($limit)){
				$limit = 30;
			}
		}

		$this->setState('limit', $limit);
		$this->setState('com_virtuemart.'.$view.'.limit',$limit);
		$this->_limit = $limit;

		$limitStart = $app->getUserStateFromRequest('com_virtuemart.'.$view.'.limitstart', 'limitstart',  vRequest::getInt('limitstart',0,'GET'), 'int');

		//There is a strange error in the frontend giving back 9 instead of 10, or 24 instead of 25
		//This functions assures that the steps of limitstart fit with the limit
		$limitStart = ceil((float)$limitStart/(float)$limit) * $limit;
		$this->setState('limitstart', $limitStart);
		$this->setState('com_virtuemart.'.$view.'.limitstart',$limitStart);
		$this->_limitStart = $limitStart;

		return array($this->_limitStart,$this->_limit);
	}

	/**
	 * Gets the total number of entries
	 *TODO filters and search ar not set
	 * @author Max Milbers
	 * @return int Total number of entries in the database
	 */
	public function getTotal() {

		if (empty($this->_total)) {
			$db = JFactory::getDbo();
			$query = 'SELECT `'.$this->_db->escape($this->_idName).'` FROM `'.$this->_db->escape($this->_maintable).'`';;
			$db->setQuery( $query );
			if(!$db->execute()){
				if(empty($this->_maintable)) vmError('Model '.get_class( $this ).' has no maintable set');
				$this->_total = 0;
			} else {
				$this->_total = $db->getNumRows();
			}
		}

		return $this->_total;
	}


	public function setGetCount($withCount){

		$this->_withCount = $withCount;
	}

	/**
	 *
	 * exeSortSearchListQuery
	 *
	 * @author Max Milbers
	 * @author Patrick Kohl
	 * @param boolean $object use single result array = 2, assoc. array = 1 or object list = 0 as return value
	 * @param string $select the fields to select
	 * @param string $joinedTables the string of the joined tables or the table
	 * @param string $whereString for the where condition
	 * @param string $groupBy
	 * @param string $orderBy
	 * @param string $filter_order_Dir
	 */

	public function exeSortSearchListQuery($object, $select, $joinedTables, $whereString = '', $groupBy = '', $orderBy = '', $filter_order_Dir = '', $nbrReturnProducts = false ){

		$db = JFactory::getDbo();
		//and the where conditions
		if(empty($filter_order_Dir)){
			$joinedTables .="\n".$whereString."\n".$groupBy."\n".$orderBy ;
		} else {
			$joinedTables .="\n".$whereString."\n".$groupBy."\n".$orderBy.' '.$filter_order_Dir ;
		}
		//vmdebug('my $limitStart $joinedTables ',$joinedTables,$filter_order_Dir );

		if($nbrReturnProducts){
			$limitStart = 0;
			$limit = $nbrReturnProducts;
			$this->_withCount = false;
		} else if($this->_noLimit){
			$this->_withCount = false;
			$limitStart = 0;
			$limit = 0;
		} else {
			$limits = $this->setPaginationLimits();
			$limitStart = $limits[0];
			$limit = $limits[1];
		}

		if($this->_withCount){
			$q = 'SELECT SQL_CALC_FOUND_ROWS '.$select.$joinedTables;
		} else {
			$q = 'SELECT '.$select.$joinedTables;
		}

		if($this->_noLimit or empty($limit)){
			$db->setQuery($q);
		} else {
			$db->setQuery($q,$limitStart,$limit);
		}

		if($object == 2){
			 $this->ids = $db->loadColumn();
		} else if($object == 1 ){
			 $this->ids = $db->loadAssocList();
		} else {
			 $this->ids = $db->loadObjectList();
		}
		if($err=$db->getErrorMsg()){
			vmError('exeSortSearchListQuery '.$err);
		}
 		//vmdebug('my $limitStart '.$limitStart.'  $limit '.$limit.' q '.str_replace('#__',$db->getPrefix(),$db->getQuery()) );

		if($this->_withCount){

			$db->setQuery('SELECT FOUND_ROWS()');
			$count = $db->loadResult();

			if($count == false){
				$count = 0;
			}
			$this->_total = $count;
			if($limitStart>=$count){
				if(empty($limit)){
					$limit = 1.0;
				}
				$limitStart = floor($count/$limit);
				$db->setQuery($q,$limitStart,$limit);
				if($object == 2){
					$this->ids = $db->loadColumn();
				} else if($object == 1 ){
					$this->ids = $db->loadAssocList();
				} else {
					$this->ids = $db->loadObjectList();
				}
			}
		} else {
			$this->_withCount = true;
		}

		if(empty($this->ids)){
			$errors = $db->getErrorMsg();
			if( !empty( $errors)){
				vmdebug('exeSortSearchListQuery error in class '.get_class($this).' sql:',$db->getErrorMsg());
			}
			if($object == 2 or $object == 1){
				$this->ids = array();
			}
		}

		return $this->ids;

	}

	public function emptyCache(){
		$this->_cache = array();
	}

	/**
	 *
	 * @author Max Milbers
	 *
	 */

	public function getData($id = 0){

		if($id!=0) $this->_id = (int)$id;

		if (empty($this->_cache[$this->_id])) {
			$this->_cache[$this->_id] = $this->getTable($this->_maintablename);
			$this->_cache[$this->_id]->load($this->_id);

			//just an idea
			if(isset($this->_cache[$this->_id]->virtuemart_vendor_id) && empty($this->_data->virtuemart_vendor_id)){
				if(!class_exists('VirtueMartModelVendor')) require(VMPATH_ADMIN.DS.'models'.DS.'vendor.php');
				$this->_cache[$this->_id]->virtuemart_vendor_id = VirtueMartModelVendor::getLoggedVendor();
			}
		}

		return $this->_cache[$this->_id];
	}


	public function store(&$data){

		$table = $this->getTable($this->_maintablename);

		if($table->bindChecknStore($data)){
			$_idName = $this->_idName;
			$this->_id = $table->$_idName;
			$this->_cache[$this->_id] = $table;
			return $this->_id;
		} else {
			return false;
		}

	}

	/**
	 * Delete all record ids selected
	 *
	 * @author Max Milbers
	 * @return boolean True is the delete was successful, false otherwise.
	 */
	public function remove($ids) {

		$table = $this->getTable($this->_maintablename);
		foreach($ids as $id) {
			if (!$table->delete((int)$id)) {
				vmError(get_class( $this ).'::remove '.$id);
				return false;
			}
		}

		return true;
	}

	public function setToggleName($togglesName){
		$this->_togglesName[] = $togglesName ;
	}

	/**
	 * toggle (0/1) a field
	 * or invert by $val for multi IDS;
	 * @author Patrick Kohl
	 * @param string $field the field to toggle
	 * @param string $postName the name of id Post  (Primary Key in table Class constructor)
	 */

	function toggle($field,$val = NULL, $cidname = 0,$tablename = 0, $view = false  ) {

		if($view and !vmAccess::manager($view.'.edit.state')){
			return false;
		}
		$ok = true;

		if (!in_array($field, $this->_togglesName)) {
			vmdebug('vmModel function toggle, field '.$field.' is not in white list');
			return false ;
		}
		if($tablename === 0) $tablename = $this->_maintablename;
		if($cidname === 0) $cidname = $this->_cidName;

		$table = $this->getTable($tablename);
		$ids = vRequest::getInt( $cidname, vRequest::getInt('cid', array() ) );

		foreach($ids as $id){
			$table->load( (int)$id );

			if (!$table->toggle($field, $val)) {
				vmError(get_class( $this ).'::toggle  '.$id);
				$ok = false;
			}
		}

		return $ok;
	}

	/**
	 * Original From Joomla Method to move a weblink
	 * @ Author Kohl Patrick
	 * @$filter the field to group by
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function move($direction, $filter=null)
	{
		$table = $this->getTable($this->_maintablename);
		if (!$table->load($this->_id)) {
			vmError('VmModel move '.$table->getDbo()->getErrorMsg());
			return false;
		}

		if (!$table->move( $direction, $filter )) {
			vmError('VmModel move '.$table->getDbo()->getErrorMsg());
			return false;
		}

		return true;
	}
	/**
	 * Original From Joomla Method to move a weblink
	 * @ Author Kohl Patrick
	 * @$filter the field to group by
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveorder($cid = array(), $order, $filter = null)
	{
		$table = $this->getTable($this->_maintablename);
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$table->load( (int) $cid[$i] );
			// track categories
			if ($filter) $groupings[] = $table->$filter;

			if ($table->ordering != $order[$i])
			{
				$table->ordering = $order[$i];
				if (!$table->store()) {
					vmError('VmModel saveorder '.$table->getDbo()->getErrorMsg());
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		if ($filter) {
			$groupings = array_unique( $groupings );
			foreach ($groupings as $group){
				$table->reorder(	$filter.' = '.(int) $group);
			}
		}

		return true;
	}


	/**
	 * Since an object like product, category dont need always an image, we can attach them to the object with this function
	 * The parameter takes a single product or arrays of products, look for BE/views/product/view.html.php
	 * for an exampel using it
	 *
	 * @author Max Milbers
	 * @param object $obj some object with a _medias xref table
	 */

	public function addImages($obj,$limit=0){

		$mediaModel = VmModel::getModel('Media');
		$mediaModel->attachImages($obj,$this->_maintablename,'image',$limit);

	}

	public function resetErrors(){
		$this->_errors = array();
	}




    //Modified for Intent Guide project by Valdimir Bugorkov

    protected $listTmp;
    protected $pageTmp;
    protected $userId;
    protected $id;

    protected function setListTmp($select, $extract){
        $this->listTmp=new stdClass();
        $this->listTmp->select=$select;
        $this->listTmp->extract->$extract;
    }

    protected function getList(){
        if(!isset($this->listTmp->select)){
            return new stdClass();
        }  else {
              $q=$this->_db->getQuery(true);
              $q->select($this->listTmp->select)
                ->from($this->_maintablename)
                ->where("user_id=").$this->_db->quote($this->userId);
              $list=$this->_getList($q);
              foreach($this->listTmp->extract as $name=>$obj){
                  $count=0;
                  $nameid=$name.'_id';
                  foreach($list as $list_el){
                        if(isset($list_el->$nameid)){
                       $q=$this->_db->getQuery(true);
                       $q->select($obj->fields)
                        ->from('#__iguide_'.$name.'s')
                        ->where($name.'_id='.$this->_db->quote($list_el->$nameid));
                         $list[$count] = $this->_db->setQurey($q)->loadObject();
                    }
                  }

              }
        }
    }

    protected function getCmd($name){
        return urldecode(vRequest::getCmd($name, ""));
    }


    protected function quoteCmd($name){
        return $this->_db->quote($this->getCmd($name));
    }

    protected function getCmdObject($prefix, $fields){
        $output=(object)array();
        foreach ($fields as $field){
            $output->$field=$this->getCmd($prefix."_".$field);
        }
        return $output;
    }

    protected function infoFormat($input){
        $output=array();
        foreach($input as $in){
             $ou=(object)array();
             $ou->id=null;
             $ou->info=(object)array();
             foreach($in as $key=>$value){
                 if($key=="id")$ou->id=$value;
                 else $ou->info->$key=$value;
             }
             $ou->actions=(object)array(); //Добавить доступные действия
             array_push($output, $ou);
        }
        return $output;
    }

    protected function groupElements($elements, $fieldGroups, $rootFields){
        $output=array();
        foreach($elements as $el){
            $outel=(object)array();
             foreach($rootFields as $field){
                 $outel->$field=$el->$field;
             }
             foreach($fieldGroups as $group=>$fields){
                 $outel->$group=(object)array();
                 foreach($fields as $field){
                     $outel->$group->$field=$el->$field;
                 }
             }
             array_push($output, $outel);
        }
        return $output;
    }
    protected function addStaticFields(&$elements, $fields){
        foreach($elements as &$el){
            foreach($fields as $key=>$value){$el->$key=$value;}
        }
    }
    protected function addDynamicFieldToGroup(&$elements, $group_name, $field_name, $function){
        foreach($elements as &$el){
             $el->$group_name->$field_name=$this->$function($el);
        }
    }
    protected function renameFields(&$elements, $fields){
        foreach($elements as &$el){
            foreach($fields as $before=>$after)$el->$after=$el->$before;
        }
        return $elements;
    }
    protected function selectString($str, $from){
        foreach($from as $val){
            if($str==$val) return $val;
        }
        return null;
    }

    protected function simpleAction($set){
        $fields=$set->fields;
        if(!is_int(array_search("id", $fields)))array_push($fields, "id");
        //return $set->static_conditions;

        switch ($this->action){
            case "get":
                $data=$this->infoFormat($this->getElementsByTableName($fields, $set->table, $this->getConditions($set)));
            break;
            case "edit":
                $data=$this->editElementsByTableName($this->getCmdObject($set->post_prefix, $set->fields), $set->table, $this->getConditions($set));
            break;
            case "add":
                $data=$this->addElementByTableName($this->getCmdObject($set->post_prefix, $set->fields), $set->table);
            break;
            case "remove":
                $data=$this->removeElementsByTableName($set->table, $this->getConditions($set));
            break;
        }

        return (object)array(
            "data"=>$data,
            "fields"=>$set->fields,
            "conditions"=>$set->conditions
        );
    }

    protected function getConditions($set){
        $this->conditions=(object)array();
        if($set->conditions)$this->conditions=$this->getCmdObject($set->post_prefix, $set->conditions);
        if($set->static_conditions)$this->conditions=(object)array_merge((array)$this->conditions, (array)$set->static_conditions);
        return $this->conditions;
    }

    protected function checkElementAccess($set){

        //Уязвимость: проверяется только перый элемент выборки, действие может производиться для всей выборки по условию
        //return $this->conditions;
        $element=$this->getElementsByTableName(array("id", "user_id"), $set->table, $this->getConditions($set))[0];
        $flag=$set->access_flag;
        $accountType=$this->getElementsByTableName(array($flag), "#__slogin_users", array("user_id"=>$this->userId))[0]->$flag;
        if($accountType==null)$accountType="default";
        $access=$set->access_policy->$accountType;

        //$this->why=array($accountType);
        //return false;
        //Если для меня задан иной идентефикатор доступа в таблице с суффиксом access, проверить блок с заданным идентефикатором объекта Access
        if(array_search($this->_db->replacePrefix($set->table, "#__")."_access", $this->_db->getTableList())!=false){     //проверка наличия access-таблицы
            $accResult=$this->getElementsByTableName(array("access"), $set->table."_access", array("user_id"=>$this->userId, "base_id"=>$element->id));
            if($accResult[0]){        //проверка наличие access-записи
                $accId=$accResult[0]->access;
                if(!(array_search($this->action, $access->$accId)!=false)) return true; else return false;       //проверка прав доступа
            }
        }

        //Если элемент принадлежит мне, проверить наличие действия в блоке "My" объекта Access
        if($element->user_id==$this->userId){
            if(is_integer(array_search($this->action, $access->my))) return true;  else return false;
        }/* */

        //Элемент является чужим, проверить блок foreign объекта Access
        if(is_integer(array_search($this->action, $access->foreign))) return true;

        return false;
    }

    protected function setElementAccess($table, $conditions, $user_id, $access){
        $element=$this->getElementsByTableName(array("id", "user_id"), $table, $conditions)[0];
        if($element->user_id!=$this->userId)return array("status"=>"Acces denied!");
        if(array_search($this->_db->replacePrefix($table, "#__")."_access", $this->_db->getTableList())!=false){     //проверка наличия access-таблицы
            $accResult=$this->getElementsByTableName(array("access"), $table."_access", array("user_id"=>$user_id, "base_id"=>$element->id));
            if($accResult[0]){        //проверка наличие access-записи
                return $this->editElementsByTableName(array("access"=>$access), $table."_access", array("base_id"=>$element->id, "user_id"=>$user_id));
            }else{
                return $this->addElementByTableName((object)array("base_id"=>$element->id, "user_id"=>$user_id, "access"=>$access));
            }
        }
    }

    protected function privateAction($set){
        $this->why=null;
        //return $set->static_conditions;
        if($this->checkElementAccess($set))
        return $this->simpleAction($set);
        return array("status"=>"Access denied!", "why"=>$this->why);
    }

    protected function childPrivateAction($set){
        $accSet=$set->paerent;
        if($set->access_policy)$accSet=$set;
        if($this->checkElementAccess($accSet)) return $this->simpleAction($set);
        return array("status"=>"Access denied!");
    }

    protected function linkedPrivateAction($set){
        $link_key=$set->link->key_field;
        $data_key=$set->link_key;
        $links=$this->getElementsByTableName(array($link_key), $set->link->table, $this->getConditions($set->link));
        $output=(object)array();
        $data=array();
        $linkedSet=$set;
        //return $links;
        if(!$linkedSet->static_conditions)$linkedSet->static_conditions=(object)array();
        foreach($links as $link){
            $linkedSet->static_conditions->$data_key=$link->$link_key;
            $output=$this->privateAction($linkedSet);
            $data=array_merge($data, $output->data);
        }

        $output->data=$data;
        return $output;
    }

    protected function multiLinkedPrivateAction($set){
/*        foreach ($set->links as $key=>$linkset){
            $link_key=$linkset->key_field;
            $links=$this->getElementsByTableName(array($link_key), $linkset->table, $linkset->conditions);
        }

        $link_key=$set->link->key_field;
        $data_key=$set->link_key;
        $links=$this->getElementsByTableName(array($link_key), $set->link->table, $set->link->conditions);
        $output=(object)array();
        $data=array();
        $linkedSet=$set;

        foreach($links as $link){
            $linkedSet->conditions->$data_key=$link->$link_key;
            $output=$this->privateAction($linkedSet);
            $data=array_merge($data, $output->data);
        }
        $output->data=$data;
        return $output;*/
    }

    protected function getForm(){
        $fields=vRequest::getCmd("fields", array());
        $values=vRequest::getCmd("values", array());
        $form=array();
        if(sizeof($fields)==sizeof($values)){
         for($i=0; sizeof($fields)>$i; $i++){
             $field=$fields[$i];
            $form[$field]=urldecode($values[$i]);
         }
    }
         return $form;
    }

    protected function getMultiple($name){
        $fields=vRequest::getCmd("fields", array());
        $values=vRequest::getCmd("values", array());
        $multiple=array();
        if(sizeof($fields)==sizeof($values)){
         for($i=0; sizeof($fields)>$i; $i++){
             $field=$fields[$i];
            if ($field==$name)$multiple[]=urldecode($values[$i]);
         }
        }
        return $multiple;
    }

    protected function checkAccount($user_id, $type){
        $lics=$this->getElementsByTableName(array("type", "begin", "end", "priority"), "#__iguide_lics", array("user_id"=>$user_id));
        $now=date_timestamp_get(date_create());
        foreach ($lics as $lic){
             $begin=date_timestamp_get(date_create_from_format ("Y-m-d H:i:s", $lic->begin));
             $end=date_timestamp_get(date_create_from_format ("Y-m-d H:i:s", $lic->end));
             if($begin<$now&&$now<$end&&$priority<=$lic->priority){
                 if ($lic->type==$type) return true;
             }
        }
        return false;

    }

    public function checkMyAccount(){
        return $this->checkAccount($this->userId, $this->getCmd("type"));
    }

    protected function removeBlock($blockTmp){
        $q=$this->_db->getQuery(true);
        $q->delete(" #__iguide_".$this->prefix."_".$blockTmp['name']."s")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND id=".$this->_db->quote($blockTmp['id']));
        $result=$this->_db->setQuery($q)->loadResult();
        foreach($blockTmp["rows"] as $row){
             $q=$this->_db->getQuery(true);
             $q->delete(" #__iguide_".$this->prefix."_".$row['name']."s")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND ".$this->prefix."_".$blockTmp['name']."_id=".$this->_db->quote($blockTmp['id']));
            $result=$this->_db->setQuery($q)->loadResult();
            $q=$this->_db->getQuery(true);
            $q->delete(" #__iguide_".$this->prefix."_".$row['name']."_fields")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND ".$this->prefix."_".$blockTmp['name']."_id=".$this->_db->quote($blockTmp['id']));
            $result=$this->_db->setQuery($q)->loadResult();
        }
    }

    protected function removeRow($rowName, $rowId, $blockId){
        $q=$q=$this->_db->getQuery(true);
        $q->delete(" #__iguide_".$this->prefix."_".$rowName."s")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND id=".$this->_db->quote($rowId));
        $result=$this->_db->setQuery($q)->loadResult();
        $q=$q=$this->_db->getQuery(true);
        $q->delete(" #__iguide_".$this->prefix."_".$rowName."_fields")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND ".$this->prefix."_".$rowName."_id=".$this->_db->quote($rowId));
        return $this->_db->setQuery($q)->loadResult();
    }

    protected function removeField($rowName, $fieldId){
        $q=$q=$this->_db->getQuery(true);
        $q->delete(" #__iguide_".$this->prefix."_".$rowName."_fields")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND id=".$this->_db->quote($fieldId));
        return $this->_db->setQuery($q)->loadResult();
    }


    protected function pushPro($input, $fields){
        $output=array();
        foreach($input as $field){
            foreach($fields as $key=>$value){
                 $field->$key=$value;
            }
            array_push($output, $field);
        }
        return $output;
    }

    protected function editBlock($blockName, $blockId, $properities){
        $q=$this->_db->getQuery(true);
        $q->update(" #__iguide_".$this->prefix."_".$blockName."s")
            ->set($properities)
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND id=".$this->_db->quote($blockId));
        return $this->_db->setQuery($q)->loadResult();
        return $properities;
    }

    protected function editRow($rowName, $rowId, $properities){
        $q=$this->_db->getQuery(true);
        $q->update(" #__iguide_".$this->prefix."_".$rowName."s")
            ->set($properities)
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND id=".$this->_db->quote($rowId));
        return $this->_db->setQuery($q)->loadResult();
        //return array($q);
    }

    protected function editField($rowName, $fieldId, $name, $measure){
        $q=$this->_db->getQuery(true);
        $q->update(" #__iguide_".$this->prefix."_".$rowName."_fields")
            ->set(array("name=".$this->_db->quote($name), "measure=".$this->_db->quote($measure)))
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND id=".$this->_db->quote($fieldId));
        return $this->_db->setQuery($q)->loadResult();
    }

    protected function addUnion($unionName, $properities){
        $union=new stdClass();
        return $this->addElement($union, $properities, $unionName);
    }

    protected function addBlock($blockName, $properities, $union=null){
        $block=new stdClass();
        if($union!=null){
            $uanme=$union['name']."_id";
            $block->$uanme=$union['id'];
        }
        return $this->addElement($block, $properities, $blockName);
    }

    protected function addRow($rowName, $properities, $block){
        $row=new stdClass();
        $rowname=$this->prefix."_".$block['name']."_id";
        $row->$rowname=$block['id'];
        return $this->addElement($row, $properities, $rowName);
    }

    protected function addField($row, $name, $measure){
        $field=new stdClass();
        $rowname=$row['name']."_id";
        $field-> $rowname=$row['id'];
        return $this->addElement((object)$row, array("name"=>$name, "measure"=>$measure), $row["name"]."_field");
    }

    protected function addElement($element, $properities, $elementName){
        $idi=$this->prefix."_id";
        $element->$idi=$this->id;
        $element->user_id=$this->userId;
        foreach ($properities as $properity=>$value){
            $element->$properity=$value;
        }
        $this->db->insertObject("#__iguide_".$this->prefix."_".$elementName."s", $element);
        $q="SELECT LAST_INSERT_ID()";
        $element->id=$this->_db->setQuery($q)->loadResult();
        return $element;
    }

        protected function addElementByTableName($element, $tableName){

        foreach ($properities as $properity=>$value){
            $element->$properity=$value;
        }
        $this->db->insertObject($tableName, $element);
        $q="SELECT LAST_INSERT_ID()";
        $element->id=$this->_db->setQuery($q)->loadResult();
        return $element;
    }

    protected function getElementsByTableName($properities, $tableName, $conditions, $fields_prefix=null){
        $fields=$properities;
        if($fields_prefix){
            $fields=array();
            foreach($properities as $field){array_push($fields, $fields_prefix."_".$field);}
        }
        $q=$this->_db->getQuery(true);
        $q->select($fields)
            ->from($tableName)
            ->where($this->quoteWhere($conditions));
        $result=$this->_db->setQuery($q)->loadObjectList();
        if($fields_prefix){
            $formated_result=array();
            foreach($result as $row){
                $formated_row=(object)array();
                foreach($properities as $field){
                    $fieldname=$fields_prefix."_".$field;
                    $formated_row->$field=$row->$fieldname;
                }
                array_push($formated_result, $formated_row);
            }
            return $formated_result;
        }
        return $result;
    }

    protected function getElements($properities, $elementTreeName, $conditions){
        $q=$this->_db->getQuery(true);
        $q->select($properities)
            ->from(" #__iguide_".$this->prefix.$this->decodeTreeName($elementTreeName)."s")
            ->where(array_merge((count($elementTreeName))?$this->standartConditions():$this->rootConditions(), $this->quoteWhere($conditions)));
        return $this->_db->setQuery($q)->loadObjectList();
    }

    protected function getRootElements($properities, $conditions){
        $q=$this->_db->getQuery(true);
        $q->select($properities)
            ->from(" #__iguide_".$this->prefix."s")
            ->where(array_merge($this->rootConditions(), $this->quoteWhere($conditions)));
        return $this->_db->setQuery($q)->loadObjectList();
    }

    protected function removeElements($elementTreeName, $conditions){
        $q=$this->_db->getQuery(true);
        $q->delete(" #__iguide_".$this->prefix.$this->decodeTreeName($elementTreeName)."s")
            ->where(array_merge((count($elementTreeName))?$this->standartConditions():$this->rootConditions(), $this->quoteWhere($conditions)));
        return $this->_db->setQuery($q)->loadResult();
    }

    protected function removeElementsByTableName($tableName, $conditions){
        $q=$this->_db->getQuery(true);
        $q->delete($tableName)
            ->where($this->quoteWhere($conditions));
        return $this->_db->setQuery($q)->loadResult();
    }

     protected function editElements($properities, $elementTreeName, $conditions){
        $table="#__iguide_".$this->prefix.$this->decodeTreeName($elementTreeName)."s";
        $conditions=array_merge((count($elementTreeName))?$this->standartConditions():$this->rootConditions(), $conditions);
        return $this->editElementsByTableName($properities, $table, $conditions);
    }

     protected function editElementsByTableName($properities, $tableName, $conditions){
        $q=$this->_db->getQuery(true);
        $pro_string=null;
        foreach($properities as $key=>$value){
            if($pro_string)$pro_string.=", ";
           $pro_string.=$key."=".$this->_db->quote($value);
        }
        $q->update($tableName)
            ->set($pro_string)
            ->where($this->quoteWhere($conditions));
        return $this->_db->setQuery($q)->loadObjectList();
    }

    private function standartConditions(){
        return array($this->prefix."_id=".$this->_db->quote($this->id),"user_id=".$this->_db->quote($this->userId));
    }

    private function rootConditions(){
         return array("user_id=".$this->_db->quote($this->userId));
    }

    private function decodeTreeName($treeName){
        $output="";
        foreach($treeName as $el){
            $output=$output."_".$el;
        }
        return $output;
    }

    private function quoteWhere($where){
        $output=array();
        if(is_array($where)){
            if(count($where)){
                foreach($where as $key=>$value){
                    array_push($output, $key."=".$this->_db->quote($value));
                }
            }

        }

        return $output;
    }

    protected function getUnions($unionName, $properities, $blocks, $rows){
        $q=$this->_db->getQuery(true);
        $select=array("id");
        $select=array_merge($select, $properities);
        $q->select($select)
            ->from(" #__iguide_".$this->prefix."_".$unionName."s")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId));
        $unionsTable= $this->_db->setQuery($q)->loadObjectList();
        return $this->formatUnion($unionsTable, $unionName, $properities, $blocks, $rows);
    }

    protected function formatUnion($tableData, $unionName, $properities, $blocks, $rows){
        $unions=array();
        foreach($tableData as $tableUnion){
            $unios=$this->formatProperities($tableUnion, $properities);
            $union->id=$tableUnion->id;
            foreach($blocks as $block){
                $blockname=$block->name."s";
                $union->$blockname=$this->getBlocks($block->name, $block->properities, $rows, array("name"=>$unionName, "id"=>$union->id) );
            }
            array_push($unions, $union);
        }
        return $unions;
    }

    protected function getBlocks($blockName, $properities, $rows=null, $union=null){
        $q=$this->_db->getQuery(true);
        $select=array("id");
        $select=array_merge($select, $properities);
        $q->select($select)
            ->from(" #__iguide_".$this->prefix."_".$blockName."s")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId));
        if($union!=null)$q=$q." AND ".$union['name']."_id=".$union['id'];
        $blocksTable= $this->_db->setQuery($q)->loadObjectList();
        return $this->formatBlock($blocksTable, $blockName, $properities, $rows);
    }

    protected function formatProperities($object, $fields){
        $_object=new stdClass();
        $_object->properities=array();
        foreach($fields as $name){
            $field=new stdClass();
            $field->name=$name;
            $field->value=$object->$name;
            array_push($_object->properities, $field);
        }
        return $_object;
    }

    protected function formatBlock($tableData, $blockName, $properities, $rows){
        $blocks=array();
        foreach($tableData as $tableBlock){
            $block=$this->formatProperities($tableBlock, $properities);
            $block->id=$tableBlock->id;
            if($rows!=null){
              foreach($rows as $row){
                $rowname=$row->name."s";
                $block->$rowname=$this->getBlockRows($row->name, $blockName, $block->id, $row->properities);
              }
            }
            array_push($blocks, $block);
        }
        if(!count($blocks)){
            $init=new stdClass();
            $init->id=null;
            $init->properities=array();
            foreach($properities as $name){
                $field=new stdClass();
                $field->name=$name;
                $field->value=null;
                array_push($init->properities, $field);
            }
            array_push($blocks, $init);
        }
        return $blocks;
    }

    protected function formatRow($tableData, $rowsName, $properities){
        $rows=array();
        foreach($tableData as $tableRow){
            $row=$this->formatProperities($tableRow, $properities);
            $row->id=$tableRow->id;
            $row->fields=$this->getRowFields($rowsName, $row->id);
            array_push($rows, $row);
        }
        if(!count($rows)){
            $init=new stdClass();
            $init->id=null;
            $init->properities=array();
            foreach($properities as $name){
                $field=new stdClass();
                $field->name=$name;
                $field->value=null;
                array_push($init->properities, $field);
            }
            array_push($rows, $init);
        }
        return $rows;
    }

    protected function getBlockRows($rowsName, $blockName, $blockId, $properities){
        $q=$this->_db->getQuery(true);
        $select=array("id");
        $select=array_merge($select, $properities);
        $q->select($select)
            ->from(" #__iguide_".$this->prefix."_".$rowsName."s")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND ".$this->prefix."_".$blockName."_id=".$this->_db->quote($blockId));
        $rowsTable= $this->_db->setQuery($q)->loadObjectList();
        return $this->formatRow($rowsTable, $rowsName, $properities);
        //return $rowsTable;
    }

    protected function getRowFields($rowsName, $rowId){
        $q=$this->_db->getQuery(true);
        $q->select(array("id", "name", "measure"))
            ->from("#__iguide_".$this->prefix."_".$rowsName."_fields")
            ->where($this->prefix."_id=".$this->_db->quote($this->id)." AND user_id=".$this->_db->quote($this->userId)." AND ".$this->prefix."_".$rowsName."_id=".$this->_db->quote($rowId));
        return $this->_db->setQuery($q)->loadObjectList();
    }

}