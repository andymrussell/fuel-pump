<?php

namespace Pump\Core;
class Exception extends \Exception {

	/**
	 * Process the custom error
	 *
	 * @return  void
	 */
	public function handle()
	{
		ob_end_clean();
		echo \View::forge('exception', array('exception' => $this), false);
	}
}
