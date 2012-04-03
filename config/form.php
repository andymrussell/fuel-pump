<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */


return array(
	'label_class'			=> 'control-label',
	'prep_value'            => true,
	'auto_id'               => true,
	'auto_id_prefix'        => 'form_',
	'form_method'           => 'post',
	'form_template'         => "\n\t\t{open}\n\t\t\n{fields}\n\t\t\n\t\t", //{close}
	'fieldset_template'     => "\n\t\t<fieldset><legend>\n{fields}</legend></fieldset>\n\t\t{close}\n",
	'field_template'        => "\t\t\t<div class=\"control-group{error_class}\">{label}{required}\n\t\t\t<div class=\"controls{error_class}\">{field} {error_msg}</div></div>\n",
	'multi_field_template'  => "\t\t\n\t\t\t<div class=\"control-group{error_class}\">{group_label}{required}\n\t\t\t<div class=\"controls{error_class}\">{fields}\n\t\t\t\t{field} {label}<br />\n{fields}\t\t\t{error_msg}\n\t\t\t</div>\n\t\t</div>\n",
	'error_template'        => '<span class="help-inline">{error_msg}</span>',
	'required_mark'         => '',
	'inline_errors'         => false,
	'error_class'           => ' error',
);


