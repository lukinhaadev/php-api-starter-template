<?php

namespace App\Model;

/**
 * Abstract class Model
 *
 * An abstract base class for data models, which provides a foundation for derived models.
 * This class includes a public property for storing rows of data.
 */
abstract class Model
{
	/**
	 * @var array|null $rows
	 * An array that holds rows of data. This property can be used to store the data retrieved
	 * from a database or any other source. It can be accessed and manipulated by subclasses.
	 */
	public $rows;
}