<?php

/**
 * Override or insert variables into the html template.
 */
function theme_preprocess_html(&$vars) {
  // Add conditional CSS for IE7.
  drupal_add_css(path_to_theme() . '/ie8.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 8', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/ie7.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));

  // drupal_add_css(path_to_theme() . '/ie8.less', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 8', '!IE' => FALSE), 'preprocess' => FALSE));
  // drupal_add_css(path_to_theme() . '/ie7.less', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));


  $vars['apple_touch_icon'] = base_path() . path_to_theme() . '/apple-touch-icon.png'; 
}

/**
 * Override or insert variables into the page template.
 */
function theme_preprocess_page(&$vars) {
  // Move secondary tabs into a separate variable.

  $vars['tabs2'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => $vars['tabs']['#secondary'],
  );
  unset($vars['tabs']['#secondary']);

  if (isset($vars['main_menu'])) {
    $vars['primary_nav'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'main-menu'),
      )
    ));
  }
  else {
    $vars['primary_nav'] = FALSE;
  }


  if (isset($vars['secondary_menu'])) {
    $vars['secondary_nav'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'secondary-menu'),
      ),
    ));
  }
  else {
    $vars['secondary_nav'] = FALSE;
  }

  // Prepare header.
  $site_fields = array();
  if (!empty($vars['site_name'])) {
    $site_fields[] = $vars['site_name'];
  }
  if (!empty($vars['site_slogan'])) {
    $site_fields[] = $vars['site_slogan'];
  }
  $vars['site_title'] = implode(' ', $site_fields);
  if (!empty($site_fields)) {
    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
  }
  $vars['site_html'] = implode(' ', $site_fields);

  // Set a variable for the site name title and logo alt attributes text.
  $slogan_text = $vars['site_slogan'];
  $site_name_text = $vars['site_name'];
  
}

/**
 * Override or insert variables into the node template.
 */
function theme_preprocess_node(&$vars) {
  $vars['submitted'] = $vars['date'] . ' — ' . $vars['name'];
}

/**
 * Override or insert variables into the comment template.
 */
function theme_preprocess_comment(&$vars) {
  $vars['submitted'] = $vars['created'] . ' — ' . $vars['author'];
}

/**
 * Override or insert variables into the block template.
 */
function theme_preprocess_block(&$vars) {
  $vars['title_attributes_array']['class'][] = 'title';
  $vars['classes_array'][] = 'clearfix';
}

/**
 * Implements hook_js_alter().
 */
function theme_js_alter(&$js) {
  /*if (isset($js['misc/jquery.form.js'])) {
    $jquery_path = drupal_get_path('theme', 'rivercity2') . '/scripts/jquery.form.js';
    $js['misc/jquery.form.js']['data'] = $jquery_path;
    $js['misc/jquery.form.js']['version'] = '2.9.5';
  }*/
}

/*
 * remove a tag from the head for Drupal 7
 */
function theme_html_head_alter(&$head_elements) {
  unset($head_elements['system_meta_generator']);
}

/*title typography*/
function typograf($str) {
	$pattern = '/\s+(в|без|до|из|к|на|по|о|от|перед|при|через|с|у|и|нет|за|над|для|об|под|про)\s+/';
	return preg_replace($pattern, ' \1&nbsp;', $str);
}
/**
 * format date ago
 * @param  int $time timestamp
 * @return string formatted date
 */
function format_date_desc($time, $hours = FALSE) {
  if ($hours) {
    if (date('d', $time) == date('d')) return t('today') . ' ' . t('at') . ' ' . date('H:i', $time);
    if (date('d', $time) == date('d')-1) return t('yesterday'). ' ' . t('at') . ' ' . date('H:i', $time); else return date('d.m', $time). ' ' . t('at') . ' ' . date('H:i', $time); 
  }
  
  if (date('d', $time) == date('d')) return t('today');
  if (date('d', $time) == date('d')-1) return t('yesterday'); else return date('d.m', $time);
}

/**
 * unset unnesasary css
 * @param  array $css [description]
 * @return void
 */
function theme_css_alter(&$css) { 
    unset($css[drupal_get_path('module', 'user').'/user.css']);
    unset($css[drupal_get_path('module', 'system').'/system.menus.css']);
    unset($css[drupal_get_path('module', 'system').'/system.theme.css']);
} 

/**
* load default image from image field
*/
function theme_default_field_image_path($field_name) {
    $result1 = db_query("SELECT id FROM {field_config} WHERE field_name = :field_name",
    array(
        ':field_name' => $field_name,
        ));
    foreach ($result1 as $row) {
        $id = $row->id;
    }
    $bundle = array('news', 'regionalnews', 'friends_news');
    $result2 = db_query("SELECT id FROM {field_config_instance} WHERE field_id = :id AND bundle IN (:bundle)",
    array(
        ':id' => $id, ':bundle' => $bundle
        ));
    foreach ($result2 as $row) {
        $id = $row->id;
    }
    $type = 'default_image';
    
    $result = db_query("SELECT fid FROM {file_usage} WHERE type = :type AND id = :id",
    array(
        ':type' => $type, ':id' => $id
    ));
    foreach ($result as $row) {
        $img = file_load($row->fid)->uri;
    }
    return $img;
}