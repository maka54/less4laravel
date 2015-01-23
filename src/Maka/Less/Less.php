<?php namespace Jtgrimes\Less4laravel;

use Less_Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Html\HtmlBuilder as Html;

class Less {
	var $config;
	var $builder;

	public function __construct(Config $config, Html $builder) {
		$this->config = $config;
		$this->builder = $builder;
	}

	public function to($filename, $attributes=array()) {
		$basePath = base_path();
		$sourceFolder = $this->config->get('less4laravel::source_folder');
		$targetFolder = $this->config->get('less4laravel::target_folder');
		$link_folder = $this->config->get('less4laravel::link_folder');
		$in = "$basePath/$sourceFolder/$filename.less";
		$out = "$basePath/$targetFolder";
		
		
		Less_Cache::$cache_dir = $out;
		$cssFilename =  Less_Cache::Get( array( $in => public_path() ) ) ;
		return $this->builder->style("$link_folder/$cssFilename",$attributes);
	}
}