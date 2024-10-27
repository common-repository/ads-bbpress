<?php
defined('ABSPATH') || die();

class AdsBbpressControls {

  var $data;
  var $action = false;
  var $show_key = false; // Hook name under the textareas

  function __construct($data = null) {
    if ($data == null) $this->data = stripslashes_deep($_POST['options']);
    else $this->data = $data;

    $this->action = $_REQUEST['act'];
  }

  /**
   * Return true is there in an asked action is no action name is specified or
   * true is the requested action matches the passed action.
   * Dies if it is not a safe call.
   */
  function is_action($action = null) {
    if ($action == null) return $this->action != null;
    if ($this->action == null) return false;
    if ($this->action != $action) return false;
    if (check_admin_referer()) return true;
    die('Invalid call');
  }

  /**
   * Show the errors and messages. 
   */
  function show() {
    if (!empty($this->errors)) {
      echo '<div class="error"><p>';
      echo $this->errors;
      echo '</p></div>';
    }
    if (!empty($this->messages)) {
      echo '<div class="updated"><p>';
      echo $this->messages;
      echo '</p></div>';
    }
  }

  function yesno($name) {
    $value = isset($this->data[$name]) ? (int) $this->data[$name] : 0;

    echo '<select style="width: 60px" name="options[' . $name . ']">';
    echo '<option value="0"';
    if ($value == 0) echo ' selected';
    echo '>No</option>';
    echo '<option value="1"';
    if ($value == 1) echo ' selected';
    echo '>Yes</option>';
    echo '</select>&nbsp;&nbsp;&nbsp;';
  }

  function select($name, $options, $first = null) {
    $value = '';
    if (isset($this->data[$name])) $value = $this->data[$name];

    echo '<select id="options-' . $name . '" name="options[' . $name . ']">';
    if (!empty($first)) {
      echo '<option value="">' . esc_html($first) . '</option>';
    }
    foreach ($options as $key => $label) {
      echo '<option value="' . esc_attr($key) . '"';
      if ($value == $key) echo ' selected';
      echo '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
  }

  function value($name) {
    if (isset($this->data[$name])) echo esc_html($this->data[$name]);
  }

  function text($name, $size = 20) {
    echo '<input name="options[' . $name . ']" type="text" size="' . $size . '" value="';
    if (isset($this->data[$name])) echo esc_attr($this->data[$name]);
    echo '">';
  }

  function hidden($name) {
    echo '<input name="options[' . $name . ']" type="hidden" value="';
    if (isset($this->data[$name])) echo esc_attr($this->data[$name]);
    echo '"/>';
  }

  function button($action, $label, $function = null) {
    if ($function != null) {
      echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.act.value=\'' . $action . '\';' . htmlspecialchars($function) . '"/>';
    } else {
      echo '<input class="button-primary" type="button" value="' . $label . '" onclick="this.form.act.value=\'' . $action . '\';this.form.submit()"/>';
    }
  }

  function textarea($name, $width = '100%', $height = '150') {
    echo '<textarea class="bbpads" name="options[' . esc_attr($name) . ']" wrap="off" style="width:' . $width . ';height:' . $height . '">';
    if (isset($this->data[$name])) echo esc_html($this->data[$name]);
    echo '</textarea>';
    if ($this->show_key) echo '<small>Key: ', esc_html($name), '</small><br>';
  }

  function checkbox($name, $label = '') {
    echo '<input type="checkbox" id="' . $name . '" name="options[' . $name . ']" value="1"';
    if (!empty($this->data[$name])) echo ' checked="checked"';
    echo '/>';
    if ($label != '') echo ' <label for="' . $name . '">' . $label . '</label>';
  }

  function init() {
    echo '<input name="act" type="hidden" value=""/>';
    echo '<input name="btn" type="hidden" value=""/>';
    wp_nonce_field();
  }

  function button_link($action, $url, $anchor) {
    if (strpos($url, '?') !== false) $url .= $url . '&';
    else $url .= $url . '?';
    $url .= 'act=' . $action;

    $url .= '&_wpnonce=' . wp_create_nonce();

    echo '<a class="button" href="' . $url . '">' . $anchor . '</a>';
  }
  
}
