<?php
 
  require_once('../../config.php');
  require_once('simplehtml_form.php');
   
  global $DB, $OUTPUT, $PAGE, $COURSE;
   
  // Check for all required variables.
  $courseid = required_param('courseid', PARAM_INT);

  //-----
  $blockid = required_param('blockid', PARAM_INT);
   
  // Next look for optional variables.
  $id = optional_param('id', 0, PARAM_INT);

  $component = required_param('component', PARAM_RAW);
  //----
   
   
  if (!$course = $DB->get_record('course', array('id' => $courseid))) {
      print_error('invalidcourse', 'block_simplehtml', $courseid);
  }
   
   require_login($course);

  //----
  $PAGE->set_url('/blocks/simplehtml/view.php', array('id' => $courseid));
  $PAGE->set_pagelayout('standard');
  $PAGE->set_heading(get_string('edithtml', 'block_simplehtml'));
  $PAGE->set_title('Nuevo Rea');
  //$cssblock = new strcssclass();
  // $cssblock = '.titulo{margin-left: 10%;color:}';
  // $PAGE->add_body_class($cssblock);
  //----
   
  $simplehtml = new simplehtml_form();
  $toform['blockid'] = $blockid;
  $toform['courseid'] = $courseid;
  $toform['component'] = $component;
  $simplehtml->set_data($toform);

  $settingsnode = $PAGE->settingsnav->add(get_string('simplehtmlsettings', 'block_simplehtml'));
  $editurl = new moodle_url('/blocks/simplehtml/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid, 'component'=>$component));
  $editnode = $settingsnode->add(get_string('editpage', 'block_simplehtml'), $editurl);
  $editnode->make_active();

  if($simplehtml->is_cancelled()) {
      // Cancelled forms redirect to the course main page.
       $courseurl = new moodle_url('/');
      redirect($courseurl);
  } else if ($simplehtml->get_data()) {
      $fromform=$simplehtml->get_data();
      //print_r("hooolaaa");
      // We need to add code to appropriately act on and store the submitted data
      if (!$DB->insert_record('block_simplehtml', $fromform)) {
        print_error('inserterror', 'block_simplehtml');
      }

      // but for now we will just redirect back to the course main page.
      $courseurl = new moodle_url('/');
      print_object($fromform);
      redirect($courseurl);
      //print_object($fromform);
  } else {
      // form didn't validate or this is the first display
      $site = get_site();
      echo $OUTPUT->header();
      $simplehtml->display();
      echo $OUTPUT->footer();
  }
   

?>