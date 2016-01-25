<?php
class block_simplehtml extends block_base {
    public function init() {
        $this->title = get_string('simplehtml', 'block_simplehtml');
    }
    public function get_content() {
      if ($this->content !== null) {
        return $this->content;
      }
      $this->content         =  new stdClass;
      Global $DB, $COURSE, $PAGE;
      $array = explode('_',$COURSE->shortname);
      $records = $DB->get_records('block_simplehtml',array('component'=>$array[2]));   
      $showrecords = '';
      $editimgcurl .= new moodle_url('/pix/t/edit.png');
      $deletepicurl = new moodle_url('/pix/t/delete.png');
      $showrecords.=html_writer::start_tag('ul');
      $context = context_course::instance($COURSE->id);
      $canmanage = has_capability('block/simplehtml:managepages', $context);
      $canview = has_capability('block/simplehtml:viewpages', $context);
      foreach($records as $record){
        $showrecords.=html_writer::start_tag('li');
        $showrecords .=  html_writer::tag('h4',$record->pagetitle, array ('class'=>'titulo', 'style'=>'margin-left: 0px;font-size: 1.1em;color: firebrick;'));
        $showrecords .= html_writer::tag('p',$record->linkdescription, array('class'=>'linkdescription','style'=>'text-align: justify;left:10px;'));
        $temp=html_writer::tag('a',$record->linkurl);
        $showrecords .= html_writer::tag('p',html_writer::tag('a',$record->linkurl),array('class'=>'linkurl', 'style'=>'text-align: center;margin-left: 5px;'));
        $editurl2 = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2], 'id'=>$record->id));
        $deleteparam = array('id' => $record->id, 'courseid' => $COURSE->id);
        $deleteurl = new moodle_url('/blocks/simplehtml/delete.php', $deleteparam);
        if ($canmanage) {
          $showrecords .= html_writer::link($editurl2, html_writer::tag('img', '', array('src' => $editimgcurl, 'alt' => 'Edit')));
          $showrecords .= html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => 'Delete')));
        } else {
        }
        $showrecords .= '<br>';
        $showrecords.=html_writer::end_tag('li');
      }
      $showrecords.=html_writer::end_tag('ul');
      $this->content->text   = $showrecords;
   
      $url = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2]));
      if (has_capability('block/simplehtml:managepages', $context)) {
        $url = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
        $this->content->footer = html_writer::link($url, get_string('addpage', 'block_simplehtml'));
      } else {
        $this->content->footer = '';
      }
      //$this->content->footer = html_writer::link($url, get_string('addpage', 'block_simplehtml'));
      if (! empty($this->config->text)) {
        $this->content->text = $this->config->text;
      }
      return $this->content;

    }
  // public function specialization() {
  //   if (isset($this->config)) {
  //       if (empty($this->config->title)) {
  //           $this->title = get_string('defaulttitle', 'block_simplehtml');            
  //       } else {
  //           $this->title = $this->config->title;
  //       }
 
  //       if (empty($this->config->text)) {
  //           $this->config->text = get_string('defaulttext', 'block_simplehtml');
  //       }    
  //   }
  // }
    public function instance_allow_multiple() {
    return false;
    }
  //function has_config() {return true;}
 
    public function instance_config_save($data) {
      if(get_config('simplehtml', 'Allow_HTML') == '1') {
        $data->text = strip_tags($data->text);
      }
    // And now forward to the default implementation defined in the parent class
      return parent::instance_config_save($data);
    }
    public function applicable_formats() {
    return array(
             'course-view' => true,
      'site'=>false,
      'my'=>false);
    }




}   // Here's th