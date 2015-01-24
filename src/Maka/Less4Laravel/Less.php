<?php namespace Maka\Less4laravel;

use Less_Cache;
use URL;
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
		$publicPath = URL::to('/');
		$sourceFolder = $this->config->get('less4laravel::source_folder');
		$targetFolder = $this->config->get('less4laravel::target_folder');
		$link_folder = $this->config->get('less4laravel::link_folder');
		$link_root = $this->config->get('less4laravel::link_root');
		$in = "$basePath/$sourceFolder/$filename.less";
		$out = "$basePath/$targetFolder";
		$public = "$publicPath/$link_root";
		
		
		Less_Cache::$cache_dir = $out;
		$cssFilename =  Less_Cache::Get( array( $in => $public ) ) ;
		return $this->builder->style("$link_folder/$cssFilename",$attributes);
	}
}