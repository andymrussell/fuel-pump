<?php


namespace Pump;

class Partial
{
	public static function get($name, $data, $loop = false)
	{
		$module = \Request::active()->module;
		$controller = strtolower(str_replace('Controller_','',\Request::active()->controller));
		$action = \Request::active()->action;

		if(strpos('/',$name) === FALSE)
		{
			$name = $controller .'/_'.$name;
		}
		else
		{
			$parts = explode('/',$name);
			$last = count($parts) - 1;

			$parts[$last] = (strpos('_', $parts[$last]) === 0) ? $parts[$last] : '_'.$parts[$last];
			$name = implode('/', $parts);
		}


		if(isset($module))
		{
			//With HMVC we need to default load the view in the module
			$split = explode('\\',$name);
			$view = $split[1];
			$name = $module.'::'.$view;
		}

		$output = "";
		if($loop && is_array($data))
		{
			foreach($data as $row)
			{
				$output .= \View::forge($name, array('row' => $row), true);
			}
		}
		else
		{
			$output .= \View::forge($name, array('data' => $data), true);
		}
		return $output;

	}	

}