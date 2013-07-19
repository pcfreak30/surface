<?php

namespace Surface;

/**
 * @author James McFadden <james@jamesmcfadden.co.uk>
 */
class Element
{
	const	TABLE = 'table',
			THEAD = 'thead',
			TBODY = 'tbody',
			TFOOT = 'tfoot',
			TR = 'tr',
			TH = 'th',
			TD = 'td';
	
	/**
	 * Any attributes being used
	 * 
	 * @var array
	 */
	static protected $_attributes = array();
	
	/**
	 * Return all attributes
	 * 
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->_attributes;
	}
	
	/**
	 * Get a specific attribute
	 * 
	 * Return false if the attribute does not exist
	 * 
	 * @param string $attribute
	 * @return mixed
	 */
	public function getAttribute($attribute)
	{
		return (isset($this->_attributes[$attribute]) 
			? $this->_attributes[$attribute] : null);
	}
	
	/**
	 * Set an attribute
	 * 
	 * @param string $attribute
	 * @param mixed $value
	 */
	public function setAttribute($attribute, $value)
	{
		$this->_attributes[$attribute] = $value;
	}
	
	/**
	 * Set multiple attributes
	 * 
	 * This removes any previously set attributes
	 * 
	 * @param array $attributes
	 */
	public function setAttributes(array $attributes)
	{
		$this->_attributes = $attributes;
	}
	
	/**
	 * Render an element
	 * 
	 * Wraps an element around a closure to create a valid HTML
	 * element
	 * 
	 * Static allows us to nest this in other closures
	 * 
	 * @param string $name
	 * @param Closure $closure
	 * @param array $attributes [optional] Must be passed explicity due to closure scope
	 * @return string
	 */
	static public function _renderElement($name, \Closure $closure, array $attributes = array())
	{
		$tag = '<' . $name;
		
		foreach($attributes as $attr => $value) {
			$tag .= ' ' . $attr . '="' . $value . '"';
		}
		
		$tag .= '>' 
			. $closure()
			. '</' . $name . '>';
		
		return $tag;
	}
}