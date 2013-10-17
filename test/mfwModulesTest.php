<?php
require_once __DIR__.'/initialize.php';

class TestModules extends mfwModules {
	protected static function rootdir()
	{
		return realpath(__DIR__);
	}
	public static function getActionClassNames($module,$action)
	{
		return parent::getActionClassNames($module,$action);
	}
	public static function getActionClass($module,$action)
	{
		return parent::getActionClass($module,$action);
	}
	public static function executeAction($module,$action)
	{
		return parent::executeAction($module,$action);
	}
}


/**
 * Test class for mfwModules.
 * Generated by PHPUnit on 2013-01-09 at 00:31:28.
 */
class mfwModulesTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @dataProvider classNamesProvider
	 */
	public function testGetActionClassNames($module,$action,$exp)
	{
		$ret = TestModules::getActionClassNames($module,$action);
		$this->assertEquals($exp,$ret);
	}
	public function classNamesProvider()
	{
		return array(
			array(
				'aaa','ab1DefGhiJkl',
				array(
					'ab1DefGhiJklAction.php' => 'ab1DefGhiJklAction',
					'ab1DefActions.php' => 'ab1DefActions',
					'ab1Actions.php' => 'ab1Actions',
					'actions.php' => 'aaaActions',
					),
				),
			array(
				'abc','bcdEFg',
				array(
					'bcdEFgAction.php' => 'bcdEFgAction',
					'bcdEActions.php' => 'bcdEActions',
					'bcdActions.php' => 'bcdActions',
					'actions.php' => 'abcActions',
					),
				),
			array(
				'abcd','efghA',
				array(
					'efghAAction.php' => 'efghAAction',
					'efghAActions.php' => 'efghAActions',
					'efghActions.php' => 'efghActions',
					'actions.php' => 'abcdActions',
					),
				),
			array(
				'abc123','de_fg0',
				array(
					'de_fg0Action.php' => 'de_fg0Action',
					'de_fg0Actions.php' => 'de_fg0Actions',
					'deActions.php' => 'deActions',
					'actions.php' => 'abc123Actions',
					),
				),
			);
	}

	/**
	 * @dataProvider actionClassProvider
	 */
	public function testGetActionClass($module,$action,$classname)
	{
		$class = TestModules::getActionClass($module,$action);
		if($classname){
			$this->assertEquals($classname,get_class($class));
		}
		else{
			$this->assertNull($class);
		}
	}

	public function actionClassProvider()
	{
		return array(
			array('testmodule','','testmoduleActions'),
			array('testmodule','actTest','actActions'),
			array('testmodule','act','actActions'),
			array('dummymodule','act',null),
			);
	}

	/**
	 */
	public function testExecuteActionWithDummyModule()
	{
		$msg = '';
		try{
			TestModules::executeAction('dummy','test');
		}
		catch(Exception $e){
			$msg = $e->getMessage();
		}
		$this->assertStringStartsWith('action class not found:',$msg);
	}

	/**
	 */
	public function testExecuteActionWithInitializeError()
	{
		$exp = array(array(),'initialize error');

		elb_start();
		$err = TestModules::executeAction('testmodule','initError');
		$errorlog = elb_get_clean();

		$this->assertEquals($exp,$err);
		$this->assertStringStartsWith('initializing action failed:',$errorlog);
	}

	/**
	 * @dataProvider executeActionProvider
	 */
	public function testExecuteAction($action,$msg)
	{
		$exp = array(array(),$msg);
		$ret = TestModules::executeAction('testmodule',$action);
		$this->assertEquals($exp,$ret);
	}
	public function executeActionProvider()
	{
		return array(
			array('dummy','execute default action'),
			array('act','execute test'),
			);
	}
}
?>