<?php // Silence is golden
add_shortcode('woof_search_options', array($this, 'woof_search_options'));
//shortcode
    public function woof_search_tag_options($args = array()) {
        return $this->render_html(WOOF_PATH . 'views/shortcodes/woof_search_tag_options.php', array());
    }