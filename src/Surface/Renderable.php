<?php

namespace Surface;

/**
 * Contract for any renderable item
 * 
 * @author James McFadden <james@jamesmcfadden.co.uk>
 */
interface Renderable
{
	/**
	 * Render the item
	 * 
	 * @return string
	 */
	public function render();
	
	/**
	 * The __toString method should return the rendered item
	 * 
	 * @return string
	 */
	public function __toString();
}