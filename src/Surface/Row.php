<?php

namespace Surface;

/**
 * @author James McFadden <james@jamesmcfadden.co.uk>
 */
class Row extends Element implements Renderable
{
	protected $_data;
	
	/**
	 * Construct the row an array of data
	 * 
	 * @param array $data
	 * @param array $attributes [optional]
	 */
	public function __construct(array $data, $attributes = array())
	{
		$this->setData($data);
		$this->_attributes = $attributes;
	}
	
	/**
	 * Set the row data
	 * 
	 * The array of data may contain a mixture of Surface\Data objects and
	 * native data types
	 * 
	 * All data will be converted to Surface\Data objects
	 * 
	 * @array $data
	 */
	public function setData(array $data)
	{
		foreach($data as $i => $d) {
			if(!$d instanceof Data) {
				$data[$i] = new Data($d);
			}
		}
		$this->_data = $data;
	}
	
	/**
	 * Return the data in this row
	 * 
	 * @return array
	 */
	public function getData()
	{
		return $this->_data;
	}
	
	/**
	 * Render the row
	 * 
	 * @return string
	 */
	public function render()
	{
		$data = $this->_data;
		
		return $this->_renderElement(Element::TR, function() use ($data) {
			
			$html = '';
			
			foreach($data as $d) {
				$html .= $d->render();
			}
			return $html;
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