<?php

/**
* 
*/

namespace Pump\Helper;
class Elements
{

	static function form_field_class($valid = null)
	{
		$class = 'control-group';

		if(\Validation::instance()->errors($valid))
		{
			$class .=' error';	
		}

		return $class;
	}
	
	static function blockquote($content ='', $name ='')
	{
		$data =  "<blockquote>";
		$data .=  "<p>$content</p>";
		if($name)
		{
			$data .=  "<small>$name</small>";	
		}

		$data .=  "</blockquote>";

		return $data;
	}


	/**
	 * Build labels
	 *  
	 *	CSS bootstrap currently allows for:
	 *	(success, warning, important, notice)
	 */
	static function label($content ='', $style ='')
	{
		if($style)
		{
			$style = " ".$style;
		}

		$data =  "<span class=\"label{$style}\">{$content}</span>";

		return $data;
	}


	/**
	 * Build anchor buttons
	 *  
	 *	CSS bootstrap currently allows for:
	 *	Style - (primary, info, success, danger)
	 *	Types - HTML attribute to use (anchor, button, input)
	 *	Size - (small, large)
	 */
	static function button($content ='', $style ='', $type = 'anchor', $href = '', $size = '')
	{
		if($style)
		{
			$style = " ".$style;
		}

		if($size == 'l' or $size == 'large')
		{
			$size = " large";
		}
		elseif($size == 's' or $size == 'small')
		{
			$size = " small";
		}


		if($type == 'anchor' or $type == 'a')
		{
			$el = 'a';
		}
		elseif($type == 'button')
		{
			$el = 'button';
		}
		elseif($type == 'input')
		{
			$el = 'input';
		}
		else{
			$el = 'a';
		}


		if($el == 'a')
		{
			$href = " href=\"{$href}\"";
		}
		else
		{
			$href = '';
		}
		$data =  "<{$el} class=\"btn{$style}{$size}\"$href>{$content}</{$el}>\n";

		return $data;
	}		

	/**
	 * Block message
	 * 
	 */
	static function alert()
	{
		return new Elements_alert();
	}	
}


namespace Pump\Helper;
class Elements_alert{

	private $title = '';
	private $content = '';
	private $style = 'warning';
	private $close = true;
	private $block = false;
	private $buttons = array();

	function title($data ='')
	{
		$this->title = $data;
		return $this;
	}

	function content($data)
	{
		$this->content = $data;
		return $this;
	}

	function style($data)
	{
		$this->style = $data;
		return $this;
	}	

	function close($data)
	{
		$this->close = $data;
		return $this;
	}	

	function buttons($data = array())
	{
		$this->buttons = $data;
		return $this;
	}

	function button($data = array())
	{
		$this->buttons[] = $data;
		return $this;
	}

	function block($data)
	{
		$this->block = $data;
		return $this;
	}		

	function generate()
	{
		return $this->alert($this->content, $this->style, $this->buttons, $this->close);
	}

	/**
	 * Build labels
	 *  
	 *	CSS bootstrap currently allows for:
	 *	(success, warning, important, notice)
	 */
	function alert($content ='', $style ='warning', $buttons = array(), $close = true)
	{

		if($style == 'warning')
		{
			$style = " alert-warning";
		}
		elseif($style == 'error')
		{
			$style = " alert-error";
		}
		elseif($style == 'success')
		{
			$style = " alert-success";
		}
		elseif($style == 'info')
		{
			$style = " alert-info";
		}
		else
		{
			$style = " alert-warning";
		}		



		if($this->block == true)
		{
			$style = ' alert-block'.$style;
			$title = '<h4 class="alert-heading">'.$this->title.'</h4>';
		}
		elseif($this->title != '')
		{
			$title = '<strong>'.$this->title.'</strong> ';
		}
		else
		{
			$title = '';
		}


		$data =  "<div class=\"alert{$style}\">";

		if($close == true)
		{
			$data .= "<a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>";
		}

		$data .= $title.$content;


		if(count($buttons) > 0)
		{
			$data .= "<div class=\"alert-actions\">";
				foreach($buttons as $button)
				{
					$data .= Elements::button($button['content'], $button['style'], 'anchor', $button['href'], 'small');
				}
			$data .= "</div>";
		}
		

		$data .= "</div>";
		return $data;
	}		
}