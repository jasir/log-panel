<?php

namespace jasir\Diagnostics;

use Nette\Object;
use Nette\Diagnostics\IBarPanel;
use jasir\FileHelpers\FileHelpers;

class LogPanel extends Object implements IBarPanel {

	private $files = array();

	public function addFile($file, $rows = 5) {
		$this->files[] = array('file' => $file, 'rows' => $rows);
	}

	public function getPanel() {
		$s = '<div style="max-width:1000px;max-height:500px;overflow:auto;">';
		if (count($this->files) === 0) {
			$s .= "<h1>No files</h1>add files to LogPanel:<br><code>\$panel->addFile(file, rows)</code>";
		} else {
			foreach ($this->files as $file) {
				$rows = $file['rows'];
				$file = $file['file'];
				$lines = FileHelpers::readLastLines($file, $rows);
				$s .= "<h1 style=\"margin:0px;padding:0px;\">{$file} <small style=\"font-size:0.6em\">last {$rows} lines</small></h1>";
				if (count($lines) === 0) {
					$s .= '<pre>Empty file</pre>';
				} elseif ($lines === FALSE) {
					$s .= '<pre>File not exists</pre>';
				} else {
					$s .= '<pre style="white-space:nowrap;">' . implode('<br>', $lines) . '</pre>';
				}
			}
		}
		$s .= "</div>";
		return $s;
	}

	public function getTab() {
		return "<img src=\"data:image/png;base64,
			iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJ
			bWFnZVJlYWR5ccllPAAAAYVJREFUeNqck21LwlAUx8+263tBpZy+64NEJYIVZPUqYtQXC6JhQZCm
			7qGWJX0XN+tVWyBa7aF7j246l5AeGDvcP+ec3z3nXK5Wq314npf2fR+CIID/GMdxwPM8CIJgExYs
			SRKsYrIspwmrzKz/9o5ZQ/P9ADzPRZ8QglWnmg/59TX8k/BQOjuHoihCNpcDx3bA7FtwdXnBgOHk
			VIJiXoRMLks1G3qWBbrSGicPEzQbdUilUlEV13VhNBqh37pvsPuiz/rEtNCiBNXDYygWxgSfjgM9
			04Kbaxm1g+oRapnshIBqmtKMJ9A1BYgw7YHr+TAcDtHX1HakBUjnJQkqu3u0BwW855jAhPrd7UTb
			nyGg/bFMSjDXg6dHPTGmr++fiaYtHGWUoFSu4BQy2AMbCZR2c6ohQajRKahzBB0jSRBu5l9agmC7
			VIaCGK9iPKiobe2U4wR0DwxdjSd46RgLq3SfF2v87PouayyWDAaDV/ooNumjWiqYbSaLZS9kg37p
			FSHsXwEGAExBviyuzxUOAAAAAElFTkSuQmCC\">Logs";
	}

}