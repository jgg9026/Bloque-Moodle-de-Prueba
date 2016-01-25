<?php
  require_once("{$CFG->libdir}/formslib.php");
 
  class simplehtml_form extends moodleform {
 
    function definition() {
 
        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', get_string('textfields', 'block_simplehtml'));
        // add page title element.
        $mform->addElement('text', 'pagetitle', get_string('pagetitle', 'block_simplehtml'));
        $mform->addRule('pagetitle', null, 'required', null, 'client');
        $mform->setType('pagetitle', PARAM_TEXT);
        // $mform->addElement('text', 'linkdescription', get_string('linkdescription', 'block_simplehtml'));
        // $mform->addRule('linkdescription', null, 'required', null, 'client');
        // $mform->setType('linkdescription', PARAM_TEXT);
        $mform->addElement('textarea', 'linkdescription', get_string('linkdescription', 'block_simplehtml'),'wrap="virtual" rows="5" cols="50"');
        $mform->setType('linkdescription', PARAM_RAW);
        $mform->addRule('linkdescription', null, 'required', null, 'client');

        global $COURSE;

        //------------------
        $mform->addElement('text', 'linkurl', get_string('linkurl', 'block_simplehtml'));
        $mform->addRule('linkurl', null, 'required', null, 'client');
        $mform->setType('linkurl', PARAM_TEXT);

        // hidden elements
        $mform->addElement('hidden', 'blockid');
        $mform->setType('blockid', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);
        $mform->addElement('hidden', 'component');
        $mform->addElement('hidden','id','0');
        
        //$mform->setType('component' PARAM_TEXT);
        $this->add_action_buttons();
   
    }
  }