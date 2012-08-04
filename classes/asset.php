<?php
/**
* 
*/
namespace Pump;

class Asset extends \Fuel\Core\Asset
{
	
	/**
	 * @var  string  the folder names
	 */
	protected static $_folders = array(
		'css'  =>  'css/',
		'less' => 'less/',
		'js'   =>  'js/',
		'img'  =>  'img/',
	);


	/**
	 * CSS
	 *
	 * Either adds the stylesheet to the group, or returns the CSS tag.
	 *
	 * @access	public
	 * @param	mixed	The file name, or an array files.
	 * @param	array	An array of extra attributes
	 * @param	string	The asset group name
	 * @return	string
	 */
	public static function less($stylesheets = array(), $attr = array(), $group = NULL, $raw = false)
	{
		static $temp_group = 1000000;

		$render = false;
		if ($group === NULL)
		{
			$group = (string) (++$temp_group);
			$render = true;
		}

		static::_parse_assets('less', $stylesheets, $attr, $group);

		if ($render)
		{
			return static::render($group, $raw);
		}

		return '';
	}



	/**
	 * This is called automatically by the Autoloader.  It loads in the config
	 * and gets things going.
	 *
	 * @return  void
	 */
	public static function _init()
	{
		// Prevent multiple initializations
		if (static::$initialized)
		{
			return;
		}

		\Config::load('asset', true);

		$paths = \Config::get('asset.paths');

		foreach($paths as $path)
		{
			static::add_path($path);
		}

		static::$_add_mtime = \Config::get('asset.add_mtime', true);
		static::$_asset_url = \Config::get('asset.url');

		static::$_folders = array(
			'css'	=>	\Config::get('asset.css_dir'),
			'less'	=>	\Config::get('asset.less_dir'),
			'js'	=>	\Config::get('asset.js_dir'),
			'img'	=>	\Config::get('asset.img_dir')
		);

		static::$initialized = true;
	}


	/**
	 * Renders the given group.  Each tag will be separated by a line break.
	 * You can optionally tell it to render the files raw.  This means that
	 * all CSS and JS files in the group will be read and the contents included
	 * in the returning value.
	 *
	 * @param   mixed   the group to render
	 * @param   bool    whether to return the raw file or not
	 * @return  string  the group's output
	 */
	public static function render($group, $raw = false)
	{
		if (is_string($group))
		{
			$group = isset(static::$_groups[$group]) ? static::$_groups[$group] : array();
		}

		$css = '';
		$js = '';
		$img = '';
		$less ='';

		foreach ($group as $key => $item)
		{
			$type = $item['type'];
			$filename = $item['file'];
			$attr = $item['attr'];

			if ( ! preg_match('|^(\w+:)?//|', $filename))
			{

				if ( ! ($file = static::find_file($filename, static::$_folders[$type])))
				{
					throw new \FuelException('Could not find asset: '.$filename);
				}

				$raw or $file = static::$_asset_url.$file.(static::$_add_mtime ? '?'.filemtime($file) : '');
			}
			else
			{
				$file = $filename;
			}

			switch($type)
			{
				case 'css':
					if ($raw)
					{
						return '<style type="text/css">'.PHP_EOL.file_get_contents($file).PHP_EOL.'</style>';
					}
					$attr['rel'] = 'stylesheet';
					$attr['type'] = 'text/css';
					$attr['href'] = $file;

					$css .= html_tag('link', $attr).PHP_EOL;
				break;
				case 'less':
					if ($raw)
					{
						return '<style type="text/less">'.PHP_EOL.file_get_contents($file).PHP_EOL.'</style>';
					}
					$attr['rel'] = 'stylesheet';
					$attr['type'] = 'text/less';
					$attr['href'] = $file;

					$less .= html_tag('link', $attr).PHP_EOL;
				break;
				case 'js':
					if ($raw)
					{
						return html_tag('script', array('type' => 'text/javascript'), PHP_EOL.file_get_contents($file).PHP_EOL).PHP_EOL;
					}
					$attr['type'] = 'text/javascript';
					$attr['src'] = $file;

					$js .= html_tag('script', $attr, '').PHP_EOL;
				break;
				case 'img':
					$attr['src'] = $file;
					$attr['alt'] = isset($attr['alt']) ? $attr['alt'] : '';

					$img .= html_tag('img', $attr );
				break;
			}

		}

		// return them in the correct order
		return $css.$js.$img.$less;
	}	
}