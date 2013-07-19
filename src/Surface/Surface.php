<?php

namespace Surface;

/**
 * @author James McFadden <james@jamesmcfadden.co.uk>
 */
class Surface extends Element implements Renderable
{
	/**
	 * @var Surface\Row
	 */
	protected $_head;
	
	/**
	 * @var Surface\Row
	 */
	protected $_foot;
	
	/**
	 * @var array
	 */
	protected $_rows;
	
	/**
	 * Construct the table with some attributes
	 * 
	 * @param array $attributes [optional]
	 */
	public function __construct(array $attributes = array())
	{
		$this->setAttributes($attributes);
	}
	
	/**
	 * Add an array of head items to the table
	 * 
	 * @param array|Surface\Row $head
	 * @return \Surface
	 */
	public function setHead($head)
	{
		if(!$head instanceof Row) {
			$head = new Row($head);
		}
		foreach($head->getData() as $headItem) {
			$headItem->setElementType(Element::TH);
		}
		$this->_head = $head;
		
		return $this;
	}
	
	/**
	 * Add an array of foot items to the table
	 * 
	 * @param array|Surface\Row $foot
	 * @return \Surface
	 */
	public function setFoot($foot)
	{
		if(!$foot instanceof Row) {
			$foot = new Row($foot);
		}
		$this->_foot = $foot;
		
		return $this;
	}
	
	/**
	 * Add a row to the table
	 * 
	 * @param array|Surface\Row $row
	 * @return \Surface
	 */
	public function addRow($row)
	{
		if(!$row instanceof Row) {
			$row = new Row($row);
		}
		$this->_rows[] = $row;
		
		return $this;
	}
	
	/**
	 * Add multiple rows to the table
	 * 
	 * @param array $rows
	 * @return \Surface
	 */
	public function addRows(array $rows)
	{
		foreach($rows as $row) {
			$this->addRow($row);
		}
		return $this;
	}
	
	/**
	 * Generate the table HTML and return it
	 * 
	 * @return string
	 */
	public function render()
	{
		$head = $this->_head;
		$foot = $this->_foot;
		$rows = $this->_rows;
		
		return $this->_renderElement(Element::TABLE, 
			function() use ($head, $foot, $rows) {
			
			$table = '';
			
			if($head instanceof Row) {
				
				$table .= Element::_renderElement(Element::THEAD, 
					function() use ($head) {
					
					$headHtml = '';
					
					foreach($head->getData() as $headItem) {
						$headHtml .= $headItem->render();
					}
					return $headHtml;
				});
			}
			
			if($foot instanceof Row) {
				
				$table .= Element::_renderElement(Element::TFOOT, 
					function() use ($foot) {
					
					$footHtml = '';
					
					foreach($foot->getData() as $footItem) {
						$footHtml .= $footItem->render();
					}
					return $footHtml;
				});
			}
			
			$table .= Element::_renderElement(Element::TBODY, 
				function() use ($rows) {
			
				$bodyHtml = '';
				
				foreach($rows as $row) {
					$bodyHtml .= $row->render();
				}
				return $bodyHtml;
			});
			return $table;
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