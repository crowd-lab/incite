<?php
/**
 * Incite 
 *
 */

/**
 * Plugin "Incite"
 *
 * @package Incite 
 */
class Incite_DocumentsController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
                        //echo '<div style="color:red">Documents Controller Initialized! This is probably a good place to put the header such as <a href="./discover">discover</a> - <a href="transcribe">transcribe</a> - <a href="tag">tag</a> - <a href="connect">connect</a> - <a href="discuss">discuss</a></div>';
    }

    public function indexAction()
    {
        echo '<div style="color:black">Welcome to Homepage (discover)!</div>';
		$this->_helper->db->setDefaultModelName('Item');
		$record = $this->_helper->db->findById(225);
		$this->view->assign(array('Item' => $record));
		//$this->discoverAction();
    }

    public function discoverAction()
    {

        echo '<div style="color:red">Welcome to Discover!</div>';
		//print_r($this->_getAllParams());
		if ($this->_hasParam('id'))
			echo 'discovering document with id: '.$this->_getParam('id');
		else
			echo 'general discovering';
    }

	public function showAction()
    {

		$this->_helper->db->setDefaultModelName('Item');
		if ($this->_hasParam('id')) {
			$record = $this->_helper->db->find($this->_getParam('id'));
			if ($record != null) {
				$this->view->assign(array('Item' => $record));
			} else {
				//no such item
				$this->_forward('index');
			}
		} else {
			//default view without id
			$this->_forward('discover');
		}
    }
	
    public function transcribeAction()
    {

        //echo '<div style="color:red">Welcome to Transcribe!</div>';
		$this->_helper->db->setDefaultModelName('Item');
		if ($this->_hasParam('id')) {
			$record = $this->_helper->db->find($this->_getParam('id'));
			if ($record != null) {
				$this->_helper->viewRenderer('transcribeid');
				$this->view->transcription = $record;
			} else {
				//no such transcription
				echo 'no such transcription';
			}
		} else {
			//default view without id
			//$this->_forward('discover');
			$records = get_records('Item', array('type' => 21), 20);  //21: Image
			if ($records != null)
				$this->view->assign(array('Transcriptions' => $records));
			else {
				//no need to transcribe
			}
			
		}
    }

    public function tagAction()
    {
                        echo '<div style="color:blue">Welcome to Tag!</div>';
    }

    public function connectAction()
    {
                        echo '<div style="color:green">Welcome to Connect!</div>';
    }

    public function discussAction()
    {
                        echo '<div style="color:black">Welcome to Discuss!</div>';
    }
}
