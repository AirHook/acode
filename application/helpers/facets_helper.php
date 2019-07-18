<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Facet Helper
 *
 * Procedural functions to help in any ways about Facets
 *
 * @package		CodeIgniter
 * @subpackage	Custom Helpers
 * @category	Facets
 * @author		WebGuy
 * @link		
 */
 
// ------------------------------------------------------------------------

/**
 * Extract Facets
 *
 * Extract facets from current collection based on a facet field name
 *
 * @access	public
 * @param	mix
 * @return	array
 */
	if ( ! function_exists('extract_facets'))
	{
		function extract_facets($object, $facet_field_name)
		{
			// set an array to collect all facets
			$array_facet = array();
			
			if ($object && $object->num_rows() > 0)
			{
				$i = 0;
				foreach ($object->result_array() as $facet_data)
				{
					// for size facets
					if ($facet_field_name === 'size')
					{
						if ($facet_data['size_mode'] === '0')
						{
							$size_ary = array(
								'size_ss', 'size_sm', 'size_sl', 'size_sxl', 'size_sxxl', 'size_sxl1', 'size_sxl2'
							);
						}
						else
						{
							$size_ary = array(
								'size_0', 'size_2', 'size_4', 'size_6', 'size_8', 'size_10', 'size_12', 'size_14', 'size_16', 'size_18', 'size_20', 'size_22'
							);
						}
						
						foreach ($size_ary as $field_name)
						{
							if ($facet_data[$field_name] != NULL)
							{
								// check size facet if not zero
								if ($facet_data[$field_name] > 0)
								{
									// get the size if facet field name is not zero
									$exploded_2 = explode('_',$field_name);
									
									// remove extra character for size mode B "0"
									if ($facet_data['size_mode'] === '0') $facet_temp = substr($exploded_2[1],1);
									else $facet_temp = $exploded_2[1];
									
									// use lower caps in array
									if ( ! in_array(trim(strtolower($facet_temp)), $array_facet))
									{
										// if not in array, store in array
										$array_facet[$i] = trim(strtolower($facet_temp));
										$i++;
									}
								}
							}
						}
					}
					else
					{
						if ($facet_data[$facet_field_name] != NULL)
						{
							// explode facet data where necessary
							$exploded_1 = explode('-',$facet_data[$facet_field_name]);
							foreach ($exploded_1 as $facet)
							{
								// clean facets for unwanted characters if entered via CSV
								$facet = str_replace(
									array('"','&'),
									array('','and'),
									$facet
								);
								
								// check for two worded facets and replace underscore with space
								$facet = str_replace('_',' ',$facet);
								
								// check for 4 chars facets with #1 at the end and remove it
								// the 1 as 4th char is for the MySQL search feature shortcoming
								$pos = strpos($facet,'1');
								if (strlen($facet) == 4 && $pos == 3) $facet = substr($facet,0,-1);
								
								// use lower caps in array
								if ( ! in_array(trim(strtolower($facet)),$array_facet))
								{
									// if not in array, store in array
									$array_facet[$i] = trim(strtolower($facet));
									$i++;
								}
							}
						}
					}
				}
				
				// sort array alphabetically
				sort($array_facet);
			}
			else
			{
				return FALSE;
			}
			
			return $array_facet;
		}
	}

// ------------------------------------------------------------------------

