Surface
=========

Surface allows the generation of semantically correct HTML tables through a fluent and easy to use interface.

It is designed to be as flexible as possible, and supports attributes and table nesting.

##Requirements

- PHP 5.3 due to the use of namespaces and closures

##Usage
###Simple Table
Creating a table is easy:

    // Some data
    $rows = array(
        array('China', '1,354,040,000', '19.07'),
    	array('India', '1,210,569,573', '17.05'),
    	array('United States', '316,278,000', '4.46'),
    	array('Indonesia', '237,641,326', '3.35'),
    	array('Brazil', '193,946,886', '2.73')
    );
    
    // Create
    $surface = new Surface\Surface();
    
    // Configure
    $surface->setHead(array('Country', 'Population', '% of world'))
      ->addRows($rows);
    
    // Render
    echo $surface->render();
    
The above would output the following HTML:

    <table>
        <thead>
			<tr>
				<th>Country</th>
				<th>Population</th>
				<th>% of world</th>
			</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td>China</td>
    			<td>1,354,040,000</td>
    			<td>19.07</td>
    		</tr>
    		<tr>
    			<td>India</td>
    			<td>1,210,569,573</td>
    			<td>17.05</td>
    		</tr>
    		<tr>
    			<td>United States</td>
    			<td>316,278,000</td>
    			<td>4.46</td>
    		</tr>
    		<tr>
    			<td>Indonesia</td>
    			<td>237,641,326</td>
    			<td>3.35</td>
    		</tr>
    		<tr>
    			<td>Brazil</td>
    			<td>193,946,886</td>
    			<td>2.73</td>
    		</tr>
    	</tbody>
    </table>

###Table Footer

To add a footer to a table, simply use the `setFoot()` method:

    $surface->setHead(array('Country', 'Population', '% of world'))
	        ->addRows($rows)
	        ->setFoot(array('Total', 'Some total figure here'));
      
    echo $surface->render();

This will generate table HTML making use of the `<tfoot>` element:

    <table>
        <thead>
			<tr>
				<th>Country</th>
				<th>Population</th>
				<th>% of world</th>
			</tr>
    	</thead>
    	<tfoot>
			<tr>
				<td>Total</td>
				<td>Some total figure here</td>
			</tr>
    	</tfoot>
    	<tbody>
    		<tr>
    			<td>China</td>
    			<td>1,354,040,000</td>
    			<td>19.07</td>
    		</tr>
    		<tr>
    			<td>India</td>
    			<td>1,210,569,573</td>
    			<td>17.05</td>
    		</tr>
    		<tr>
    			<td>United States</td>
    			<td>316,278,000</td>
    			<td>4.46</td>
    		</tr>
    		<tr>
    			<td>Indonesia</td>
    			<td>237,641,326</td>
    			<td>3.35</td>
    		</tr>
    		<tr>
    			<td>Brazil</td>
    			<td>193,946,886</td>
    			<td>2.73</td>
    		</tr>
    	</tbody>
    </table>

###Using attributes

It is possible to manage parts of Surface at an element level, meaning you can give each element it's own attributes:

    // Create a table as usual, we can pass some attributes too
    $surface = new Surface\Surface(array('id' => 'population-data'));
    $surface->setHead(array('Country', 'Population', '% of world'))
      ->addRows($rows);
    
    // Some new data to add to existing rows
    $newData = array(
        'Pakistan',
        
        // We can specify and manipulate the data at this level
    	new Surface\Data('183,711,000', array('class' => 'td-green-highlight')),
    	'2.59'
    );
    
    // Construct a new row and pass it to the table
    $row = new Surface\Row($newData, array('class' => 'custom-row'));
    $surface->addRow($row);
    
    // Render
    echo $surface->render();

###Nested Tables

Nesting tables is also easy to achieve with Surface. Simply pass an existing table through to a new table as a data item:

    // $nestedTable created up here

    $parentTable = new Surface\Surface();
    $parentTable->setHead(array('Country', 'Population', '% of world'))
      ->addRows($rows)
      ->addRow(array($nestedTable)); // $nestedTable is an instance of Surface\Surface
      
    // Easy!
    echo $parentTable->render();

This produces the following output:

    <table>
        <thead>
			<tr>
				<th>Country</th>
				<th>Population</th>
				<th>% of world</th>
			</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td>China</td>
    			<td>1,354,040,000</td>
    			<td>19.07</td>
    		</tr>
    		<tr>
    			<td>India</td>
    			<td>1,210,569,573</td>
    			<td>17.05</td>
    		</tr>
    		<tr>
    			<td>United States</td>
    			<td>316,278,000</td>
    			<td>4.46</td>
    		</tr>
    		<tr>
    			<td>Indonesia</td>
    			<td>237,641,326</td>
    			<td>3.35</td>
    		</tr>
    		<tr>
    			<td>Brazil</td>
    			<td>193,946,886</td>
    			<td>2.73</td>
    		</tr>
    		<tr>
    			<td>
    				<table>
    					<thead>
    						<th>Id</th>
    						<th>Name</th>
    						<th>Date Created</th>
    					</thead>
    					<tbody>
    						<tr>
    							<td>845</td>
    							<td>User 845</td>
    							<td>2013-01-01</td>
    						</tr>
    						<tr>
    							<td>384</td>
    							<td>User 384</td>
    							<td>2012-05-10</td>
    						</tr>
    					</tbody>
    				</table>
    			</td>
    		</tr>
    	</tbody>
    </table>
