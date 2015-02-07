<?php namespace Maka\Less4laravel;

use Less_Cache;
use URL;
use Illuminate\Config\Repository as Config;
use Illuminate\Html\HtmlBuilder as Html;

class Less {
	var $config;
	var $builder;
		
	var $source_path;
	var $cache_path;
	var $target_path;
	var $css_path;
	var $root_path;
	
	
	var $compiled;
	var $humanized;
	var $filename;
	
	var $DS = DIRECTORY_SEPARATOR;
	
	public function __construct(Config $config, Html $builder) {
		$this->config = $config;
		$this->builder = $builder;
	}

	public function to($filename, $attributes=array()) {
			
		$this->filename = $filename;
		
		$this->source_path = base_path() . $this->DS . $this->config->get('less4laravel::source_folder');
		$this->cache_path = base_path() . $this->DS . $this->config->get('less4laravel::cache_folder');
		$this->target_path = base_path() . $this->DS . $this->config->get('less4laravel::target_folder');
		$this->css_path =  $this->config->get('less4laravel::link_folder');
		$this->public_path = url() . '/' . $this->config->get('less4laravel::link_root');

		$this->compiler();
		$this->humanizer();
		$this->register();
		$this->cleaner();
		
		return $this->builder->style($this->css_path . '/' . $this->humanized, $attributes);
	}
		
	private function register(){
		!file_exists($this->target_path . $this->DS . $this->humanized) ? copy($this->cache_path . $this->DS . $this->compiled, $this->target_path . $this->DS . $this->humanized) : null;
	}
	
	private function compiler(){
		Less_Cache::$cache_dir = $this->cache_path;
		Less_Cache::CleanCache();
		$this->compiled =  Less_Cache::Get( array( $this->source_path . $this->DS . $this->filename . '.less' => $this->public_path ) ) ;
	}
	
	private function humanizer(){				
		$this->humanized = $this->filename . '-' . hash('crc32', $this->cache_path . $this->DS . $this->compiled) . ".css";
	}
	
	private function cleaner(){
		$dir = opendir($this->target_path);
		while($file = readdir($dir)) {
			if (preg_match("/^{$this->filename}/", $file)) {
				if($file != $this->humanized)
					unlink($this->target_path . $this->DS . $file);
			}
		}
		closedir($dir);
	}
}