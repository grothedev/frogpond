<?php //some useful functions

	function getFile($croak){
		if ($file = $croak->files->first()){
			return $file;
		}
		return null;
	}

	function fileIsType($fn, $ext){
		$e = strlen($fn) - strlen($ext);
		return ( stripos($fn, $ext) == $e);
	}

	/**
	 * @return array of strings containing the label of each tag
	 */
	function getTagsLabelArray($croak){
		$tags = [];
		foreach ($croak->tags as $t){
			array_push($tags, $t->label);
		}
		return $tags;
	}

	/**
	 * @return the labels of the tags as a single string, seperated by comma
	 */
	function getTagsAsStr($croak){
		return implode(', ', getTagsLabelArray($croak));
	}

?>