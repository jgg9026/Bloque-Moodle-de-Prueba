<?php
class block_simplehtml extends block_base {
    public function init() {
        $this->title = get_string('simplehtml', 'block_simplehtml');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
    public function get_content() {
    if ($this->content !== null) {
      return $this->content;
    }
    $this->content         =  new stdClass;
    //$this->content->text   = 'The content of our SimpleHTML block!';
    Global $DB;
    Global $COURSE;
    $array = explode('_',$COURSE->shortname);
    $records = $DB->get_records('block_simplehtml',array('component'=>$array[2]));   
    $showrecords = '';
    foreach($records as $record){
      //$showrecords .= '<h3>'.$record->pagetitle.'</h3>';
      $showrecords .=  html_writer::tag('h4',$record->pagetitle, array ('class'=>'titulo', 'style'=>'margin-left: 0px;font-size: 1.1em;color: firebrick;'));
      $showrecords .= html_writer::tag('p',$record->linkdescription, array('class'=>'linkdescription','style'=>'text-align: justify;left:10px;'));
      $temp=html_writer::tag('a',$record->linkurl);
      $showrecords .= html_writer::tag('p',html_writer::tag('a',$record->linkurl),array('class'=>'linkurl', 'style'=>'text-align: center;margin-left: 5px;'));
      $showrecords .= '<br>';
    }
    $this->content->text   = $showrecords;
   
    // The other code.      
    $url = new moodle_url('/blocks/simplehtml/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2]));
    $this->content->footer = html_writer::link($url, get_string('addpage', 'block_simplehtml'));
    if (! empty($this->config->text)) {
    $this->content->text = $this->config->text;
    }
    return $this->content;

  }
  public function specialization() {
    if (isset($this->config)) {
        if (empty($this->config->title)) {
            $this->title = get_string('defaulttitle', 'block_simplehtml');            
        } else {
            $this->title = $this->config->title;
        }
 
        if (empty($this->config->text)) {
            $this->config->text = get_string('defaulttext', 'block_simplehtml');
        }    
    }
  }
  public function instance_allow_multiple() {
    return false;
  }
  function has_config() {return true;}
 
  public function instance_config_save($data) {
    if(get_config('simplehtml', 'Allow_HTML') == '1') {
      $data->text = strip_tags($data->text);
    }
    // And now forward to the default implementation defined in the parent class
    return parent::instance_config_save($data);
  }

}   // Here's th