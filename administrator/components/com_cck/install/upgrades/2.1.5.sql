
ALTER TABLE `#__cck_core_search_position` CHANGE `css` `css` VARCHAR( 255 ) NOT NULL;
ALTER TABLE `#__cck_core_type_position` CHANGE `css` `css` VARCHAR( 255 ) NOT NULL;

INSERT INTO `#__cck_core_fields` (`id`, `title`, `name`, `folder`, `type`, `description`, `published`, `label`, `selectlabel`, `display`, `required`, `validation`, `defaultvalue`, `options`, `options2`, `minlength`, `maxlength`, `size`, `cols`, `rows`, `ordering`, `sorting`, `divider`, `bool`, `location`, `extended`, `style`, `script`, `bool2`, `bool3`, `bool4`, `bool5`, `bool6`, `bool7`, `bool8`, `css`, `attributes`, `storage`, `storage_location`, `storage_table`, `storage_field`, `storage_field2`, `storage_params`, `storages`, `checked_out`, `checked_out_time`) VALUES
(253, 'Core CSS Definitions', 'core_css_definitions', 3, 'select_simple', '', 0, 'CSS Definitions', 'None', 3, '', '', '', 'All=all||Custom=custom', '', 0, 255, 32, 0, 0, 0, 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', 'dev', '', '', 'css_definitions', '', '', '', 0, '0000-00-00 00:00:00'),
(254, 'Core CSS Definitions Custom', 'core_css_definitions_custom', 3, 'checkbox', '', 0, '', ' ', 3, '', '', '', 'Base=base||CSS Spacing=spacing||CSS Writing=writing', '', 0, 255, 32, 0, 0, 0, 0, ',', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', 'dev', '', '', 'css_definitions_custom', '', '', '', 0, '0000-00-00 00:00:00'),
(402, 'Category Extension', 'cat_extension', 11, 'hidden', '', 1, 'Extension', ' ', 1, '', '', '', '', '', 0, 255, 32, 0, 0, 0, 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', 'standard', 'joomla_category', '#__categories', 'extension', '', '', '', 0, '0000-00-00 00:00:00');

UPDATE `#__cck_core_fields` SET `script` = '$j("#title").live("change", function() { if ( !$j("#name").val() ) { var p = ""; if ($j("span.insidebox").length > 0) { var p = $j("span.insidebox").html()+"_"; } $j("#name").val( p+$j("#title").val().toLowerCase().replace(/^\\s+|\\s+$/g,"").replace(/\\s/g, "_").replace(/[^a-z0-9_]/gi, "") ) } }); if(!$j("#title").val()){ $j("#title").focus(); }' WHERE `id` = 39;
UPDATE `#__cck_core_fields` SET `options2` = '{"query":"SELECT DISTINCT a.template AS value, CONCAT(b.title,\\" - \\",b.name) AS text FROM #__template_styles AS a LEFT JOIN #__cck_core_templates AS b ON b.name = a.template WHERE b.id AND b.mode=0 ORDER BY b.title","table":"","name":"","where":"","value":"","orderby":"","language_detection":"joomla","language_codes":"EN,GB,US,FR","language_default":"EN"}', `attributes` = 'onchange="doSubmit();" style="max-width:190px;"' WHERE `id` = 56;

-- --------------------------------------------------------

UPDATE `#__extensions` SET `enabled` = '1' WHERE `folder` = 'cck_field' AND ( `element` = 'joomla_article' );
UPDATE `#__template_styles` SET `params` = '{"top_items":"1","top_display":"renderItem","top_display_field_name":"","top_columns":"1","top_column_width":"0","top_column_width_custom":"50,50","top_item_order":"0","top_item_height":"1","middle_items":"4","middle_display":"renderItem","middle_display_field_name":"","middle_columns":"2","middle_column_width":"0","middle_column_width_custom":"50,50","middle_item_order":"0","middle_item_height":"1","bottom_items":"","bottom_display":"renderItem","bottom_display_field_name":"","bottom_columns":"3","bottom_column_width":"0","bottom_column_width_custom":"33,34,33","bottom_item_order":"0","bottom_item_height":"1","cck_client_item":"1","debug":"0","item_margin":"8"}' WHERE `template` = "seb_blog" AND `title` = "seb_blog - Default";