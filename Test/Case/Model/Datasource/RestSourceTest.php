<?php

App::uses('AppModel', 'Model');

class RestTestModel extends AppModel {

	public $name = 'RestTestModel';

	public $useDbConfig = 'rest_test';

	public $request = array();

}

/**
 * @property RestTestModel $Model
 */
class RestSourceTestCase extends CakeTestCase {

	public static function setUpBeforeClass() {
		ConnectionManager::create('rest_test', array(
			'datasource' => 'Rest.RestSource',
			'database' => false,
		));
	}

	public static function tearDownAfterClass() {
		ConnectionManager::drop('rest_test');
	}

	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('RestTestModel');
	}

	public function tearDown() {
		unset($this->Model);
		parent::tearDown();
	}

	/**
	 * read json data
	 */
	public function testReadJsonData() {
		$this->Model->request = array(
			'uri' => array(
				'host' => 'search.twitter.com',
				'path' => 'search.json',
				'query' => array('q' => 'twitter'),
			),
		);

		$results = $this->Model->find('all');

		$this->assertTrue(isset($results['results']));
	}

	/**
	 * read xml data
	 */
	public function testReadXmlData() {
		$this->Model->request = array(
			'uri' => array(
				'host' => 'bakery.cakephp.org',
				'path' => 'articles.rss',
			),
		);

		$results = $this->Model->find('all');

		$this->assertTrue(isset($results['rss']));
	}

}
