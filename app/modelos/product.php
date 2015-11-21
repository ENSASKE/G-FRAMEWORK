<?php

class Product extends baseModel {
	var $hasOne = array('Category' => 'Category');
	var $hasManyAndBelongsToMany = array('Tag' => 'Tag');
}