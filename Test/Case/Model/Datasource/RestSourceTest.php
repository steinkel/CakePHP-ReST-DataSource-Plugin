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

    public function setUp() {
        ConnectionManager::create('rest_test', array(
            'datasource' => 'Rest.RestSource',
            'database' => false,
        ));
    }

    public function startTest($method) {

        $this->Model = ClassRegistry::init('RestTestModel');
    }

    public function endTest($method) {
        unset($this->Model);
        ClassRegistry::flush();
    }

    // =========================================================================
    public function testRead_json() {

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

    public function testRead_xml() {

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
