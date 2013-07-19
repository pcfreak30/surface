<?php

namespace Surface;

/**
 * @author James McFadden <james@jamesmcfadden.co.uk>
 */
class Data extends Element implements Renderable
{
	/**
	 * The data element type
	 * 
	 * @var string
	 */
	protected $_elementType;
	
	/**
	 * The data value
	 * 
	 * @param mixed
	 */
	protected $_value;
	
	/**
	 * An array of valid element types
	 * 
	 * @var array
	 */
	protected $_validElementTypes = array(
		Element::TH,
		Element::TD
	);
	
	/**
	 * Instantiate with a value
	 * 
	 * @param mixed $value
	 * @param array $attributes [optional]
	 * @param string $elementType [optional]
	 */
	public function __construct($value, $attributes = array(), $elementType = Surface::TD)
	{
		$this->_value = $value;
		$this->setElementType($elementType);
		$this->setAttributes($attributes);
	}
	
	/**
	 * Set the element type to use
	 * 
	 * This means we can use both td and th
	 * 
	 * @param string $elementType
	 * @throws Exception
	 */
	public function setElementType($elementType)
	{
		if(!in_array($elementType, $this->_validElementTypes)) {
			throw new \Exception('Invalid data element type ' . $elementType . '. '
				. 'Must be one of ' . implode($this->_validElementTypes, ', '));
		}		
		$this->_elementType = $elementType;
	}
	
	/**
	 * Render the data in an element
	 * 
	 * @return string
	 */
	public function render()
	{
		$value = $this->_value;
		
		return $this->_renderElement($this->_elementType, function() use ($value) {
			return $value;
		},
		$this->getAttributes());
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}