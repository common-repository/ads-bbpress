<?php
defined('ABSPATH') || die();

include_once __DIR__ . '/controls.php';
$controls = new AdsBbpressControls();

if ($controls->is_action('save')) {
    update_option('ads-bbpress', $controls->data);
    $controls->messages = __('Updated');
} else {
    $controls->data = get_option('ads-bbpress');
}

$controls->show_key = isset($controls->data['test']);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/codemirror.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/show-hint.css">
<style>
    .CodeMirror {
        border: 1px solid #ddd;
        font-weight: normal;
    }
    
    .form-table {
        background-color: #fff;
    }
    
    .form-table th {
        text-align: right;
    }
    
    .form-table h4 {
        margin-top: 0;
        text-transform: uppercase;
        margin-bottom: 10px;
        
    }
    
    .form-table textarea {
        font-size: 12px;
    }

    .form-table.bbpads-editor td {
        width: 50%;
        font-weight: bold;
    }
    .form-table.bbpads-editor td p {
        font-weight: normal;
    }
    .form-table.bbpads-editor td small {
        color: #666;
        font-weight: normal;
    }

    .bbpads-doc, .bbpads-doc:hover {
        font-size: 1.2em;
        background-color: #292;
        color: #fff;
        display: inline-block;
        font-weight: bold;
        padding: 10px;
        text-decoration: none;
    }

    .bbpads-donation, .bbpads-donation:hover {
        font-size: 1.2em;
        background-color: #f80;
        color: #fff;
        display: inline-block;
        font-weight: bold;
        padding: 10px;
        text-decoration: none;
    }

    .bbpads-note, .bbpads-note:hover {
        font-size: 1.2em;
        background-color: #55b;
        color: #fff;
        display: inline-block;
        font-weight: bold;
        padding: 10px;
        text-decoration: none;
    }    

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/codemirror.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/xml/xml.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/javascript/javascript.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/css/css.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/htmlmixed/htmlmixed.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/clike/clike.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/mode/php/php.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/show-hint.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/css-hint.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/xml-hint.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.20.2/addon/hint/html-hint.js"></script>

<script>
    var templateEditor;
    jQuery(document).ready(function () {
        jQuery("textarea.bbpads").each(function () {
            var cmOptions = {
                lineNumbers: true,
                mode: "php",
                extraKeys: {"Ctrl-Space": "autocomplete"}
            }
            CodeMirror.fromTextArea(this, cmOptions);
        });
    });
</script>  
<div class="wrap">
    <h2>bbPress Ads</h2>
    <p>
        <a href="http://www.satollo.net/plugins/bbpress-ads" target="_blank" class="bbpads-doc"><?php _e('You should read the documentation and the tips and tricks', 'bbpress-ads') ?></a>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5PHGDGNHAYLJ8" target="_blank" class="bbpads-donation"><?php _e('Help children with a donation', 'bbpress-ads') ?></a>
        <a href="http://www.satollo.net/donations" target="_blank" class="bbpads-note"><?php _e('Read more about donations I receive', 'bbpress-ads') ?></a>
    </p>
    <p>
        Use PHP code and <code>$count</code> to selectively inject in a loop. <code>$count == 1</code> is <strong>before</strong> or <strong>inside</strong> the first block.
    </p>


    <?php $controls->show(); ?>

    <form method="post" action="">
        <?php $controls->init(); ?>

        <h3><?php _e('General settings', 'bbpress-ads') ?></h3>
        <table class="form-table">

            <tr>
                <th>
                    <?php _e('Test mode', 'bbpress-ads') ?>
                </th>
                <td>
                    <?php $controls->checkbox('test') ?>
                    <p class="description">
                        <?php _e('Show a dummy text on each injection area (only for administrators)', 'bbpress-ads') ?>.
                        <?php _e('Use the key under each editor to match with the online area', 'bbpress-ads') ?>.
                    </p>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php $controls->button('save', __('Update')); ?>
        </p>

        <h3><?php _e('Forum page', 'bbpress-ads') ?></h3>
        <table class="form-table bbpads-editor">
            <tr>
                <td>
                    <h4><?php _e('Before single forum topic list', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_before_single_forum') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>

                <td>
                    <h4><?php _e('After single forum topic list', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_after_single_forum') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>
            </tr>
        </table>



        <h3><?php _e('Topic page', 'bbpress-ads') ?></h3>
        <table class="form-table bbpads-editor">
            <tr>
                <td>
                    <h4><?php _e('Before single topic', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_before_single_topic') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>

                <td>
                    <h4><?php _e('After single topic', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_after_single_topic') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>
            </tr>
        </table>

        <h3><?php _e('Reply body', 'bbpress-ads') ?></h3>
        <?php _e('Just before and after the text by the user', 'bbpress-ads') ?>.
        <table class="form-table bbpads-editor">
            <tr>
                <td>

                    <h4><?php _e('Before reply content', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_theme_before_reply_content') ?>
                    <p class="description"><?php _e('Above the reply text', 'bbpress-ads') ?></p>
                </td>
                <td>
                    <h4><?php _e('After reply content', 'bbpress-ads') ?></h4>


                    <?php $controls->textarea('bbp_theme_after_reply_content') ?>
                    <p class="description"><?php _e('Under the reply text', 'bbpress-ads') ?></p>
                </td>
            </tr>
        </table>


        <h3><?php _e('Loops', 'bbpress-ads') ?></h3>

        <table class="form-table bbpads-editor">
            <tr>
                <td>
                    <h4><?php _e('Before topics loop', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_before_topics_loop') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>
                <td>
                    <h4><?php _e('After topics loop', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_after_topics_loop') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <h4><?php _e('Before replies loop', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_before_replies_loop') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>
                <td>
                    <h4><?php _e('After replies loop', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_template_after_replies_loop') ?>
                    <p class="description"><?php _e('', 'bbpress-ads') ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <h4><?php _e('Before each topic block', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('get_template_part_loop_single-topic') ?>
                    <p class="description"><?php _e('Active in a forum page which lists all the topics', 'bbpress-ads') ?></p>
                </td>
                <td>
                    <h4><?php _e('Before each reply block', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('get_template_part_loop_single-reply') ?>
                    <p class="description"><?php _e('Active in a topic page which lists all the replies', 'bbpress-ads') ?></p>
                </td>
            </tr>
        </table>

        <h3><?php _e('Other', 'bbpress-ads') ?></h3>
        <table class="form-table bbpads-editor">
            <tr>
                <td>
                    <h4><?php _e('Before the new topic form', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_theme_before_topic_form_notices') ?>
                    <p class="description"><?php _e('Could be useful to show new topic rules', 'bbpress-ads') ?></p>
                </td>
                <td>
                    <h4><?php _e('Before the new reply form', 'bbpress-ads') ?></h4>
                    <?php $controls->textarea('bbp_theme_before_reply_form_notices') ?>
                    <p class="description"><?php _e('Could be useful to show reply rules', 'bbpress-ads') ?></p>
                </td>
            </tr>
        </table>

        <p class="submit">
            <?php $controls->button('save', __('Update')); ?>
        </p>
</div>