<?php 

namespace Kappa;

/**
 * 
 */
class PageTranslator
{
	
	private $folder;

	private $language;

	public function __construct($folder, $language = 'eng')
	{
		$this->folder = $folder;
		$this->language = $language;
	}

	private function getPath($page)
	{
		return $this->folder . '\\' . $this->language . '\\' . $page . '.php';
	}

	public function translate($page)
	{
		$translation = include $this->getPath($page);
		return $translation;
	}
}