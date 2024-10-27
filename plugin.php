<?php

/*
  Plugin Name: Ads for bbPress
  Plugin URI: http://www.satollo.net/plugins/ads-bbpress
  Description: Injects ads (and more) in bbPress forums, topics and replies
  Version: 1.0.3
  Author: Stefano Lissa
  Author URI: http://www.satollo.net
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
  Requires at least: 4.6
  Required PHP: 5.6
 */

class AdsBbpress {

    var $options;
    var $count = 0;

    public function __construct() {
        // TODO: check if we are in the forum context (how?)
        // content-single-forum.php
        add_action('bbp_template_before_single_forum', array($this, 'bbp_template_before_single_forum'));
        add_action('bbp_template_after_single_forum', array($this, 'bbp_template_after_single_forum'));
        add_action('bbp_template_before_topics_loop', array($this, 'bbp_template_before_topics_loop'));
        add_action('bbp_template_after_topics_loop', array($this, 'bbp_template_after_topics_loop'));
        add_action('bbp_theme_before_topic_form_notices', array($this, 'bbp_theme_before_topic_form_notices'));

        // content-single-topic.php
        add_action('bbp_template_before_single_topic', array($this, 'bbp_template_before_single_topic'));
        add_action('bbp_template_after_single_topic', array($this, 'bbp_template_after_single_topic'));
        add_action('bbp_template_before_replies_loop', array($this, 'bbp_template_before_replies_loop'));
        add_action('bbp_template_after_replies_loop', array($this, 'bbp_template_after_replies_loop'));
        add_action('bbp_theme_before_reply_form_notices', array($this, 'bbp_theme_before_reply_form_notices'));

        //add_action('bbp_theme_before_topic_form', array($this, 'bbp_theme_before_topic_form'));
        //add_action('bbp_theme_before_reply_form', array($this, 'bbp_theme_before_reply_form'));
        //add_action('bbp_theme_before_topic_content', array($this, 'bbp_theme_before_topic_content'));
        //add_action('bbp_theme_after_topic_content', array($this, 'bbp_theme_after_topic_content'));
        //
        //loop-single-reply.php
        add_action('bbp_theme_before_reply_content', array($this, 'bbp_theme_before_reply_content'));
        add_action('bbp_theme_after_reply_content', array($this, 'bbp_theme_after_reply_content'));

        add_action('get_template_part_loop', array($this, 'get_template_part_loop'), 30, 2);
    }

    /**
     * Get the options only if needed (WP runs a lot of code on get_option() and we need it only in the forum context)
     */
    function init_options() {
        if (!$this->options) {
            $this->options = get_option('ads-bbpress');
        }
    }

    function show($key) {
        $this->init_options();
        $count = $this->count;
        if (isset($this->options['test']) && current_user_can('administrator')) {
            echo '<div style="background-color: #33bb33; border: 3px solid #006600; padding: 20px; margin: 5px 0; color: #fff">', $key;
            if (strpos($key, '_loop_') !== false || strpos($key, '_content') !== false)
                echo ' [', $count, ']';
            echo '</div>';
            return;
        }
        if (empty($this->options[$key])) {
            return;
        }
        if (strpos($this->options[$key], '<?') !== false) {
            ob_start();
            eval('?>' . $this->options[$key]);
            $content = ob_get_clean();
            echo do_shortcode($content);
        } else {
            echo $this->options[$key];
        }
    }

    function bbp_template_before_single_forum() {
        $this->show('bbp_template_before_single_forum');
    }

    function bbp_template_after_single_forum() {
        $this->show('bbp_template_after_single_forum');
    }

    function bbp_theme_before_topic_form() {
        $this->show('bbp_theme_before_topic_form');
    }

    function bbp_template_before_single_topic() {
        $this->show('bbp_template_before_single_topic');
    }

    function bbp_template_after_single_topic() {
        $this->show('bbp_template_after_single_topic');
    }

    function bbp_theme_before_reply_form() {
        $this->show('bbp_theme_before_reply_form');
    }

    function bbp_theme_before_topic_form_notices() {
        $this->show('bbp_theme_before_topic_form_notices');
    }

    function bbp_theme_before_reply_form_notices() {
        $this->show('bbp_theme_before_reply_form_notices');
    }

    function bbp_theme_before_topic_content() {
        $this->show('bbp_theme_before_topic_content');
    }

    function bbp_theme_after_topic_content() {
        $this->show('bbp_theme_after_topic_content');
    }

    function bbp_theme_before_reply_content() {
        $this->show('bbp_theme_before_reply_content');
    }

    function bbp_theme_after_reply_content() {
        $this->show('bbp_theme_after_reply_content');
    }

    function bbp_template_before_topics_loop() {
        $this->show('bbp_template_before_topics_loop');
    }

    function bbp_template_after_topics_loop() {
        $this->show('bbp_template_after_topics_loop');
    }

    function bbp_template_before_replies_loop() {
        $this->show('bbp_template_before_replies_loop');
    }

    function bbp_template_after_replies_loop() {
        $this->show('bbp_template_after_replies_loop');
    }

    /**
     * 
     * @param string $slug is 'loop'
     * @param string $name can be 'single-reply'
     */
    function get_template_part_loop($slug, $name) {

        if ($name === 'single-reply' || $name === 'single-topic') {
            $this->count++;
            $this->show('get_template_part_loop_' . $name);
        }
    }

}

new AdsBbpress();

// All the admin stuff only if we're in the admin side
if (is_admin()) {
    include __DIR__ . '/admin.php';
}