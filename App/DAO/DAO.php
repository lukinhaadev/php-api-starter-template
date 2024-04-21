<?php

namespace App\DAO;

use PDO;
use PDOException;

/**
 * Abstract class DAO
 *
 * Provides a base class for Data Access Objects (DAOs) that handle database interactions.
 * This class extends PDO and provides methods for connecting to and managing a MySQL database connection.
 */
abstract class DAO extends PDO
{
	/**
	 * @var PDO|null $conn
	 * The PDO connection instance used for database interactions.
	 */
	protected $conn;

	/**
	 * Constructor initializes the database connection.
	 *
	 * Initializes the database connection by calling the `connect` method.
	 *
	 * @throws PDOException If the connection fails.
	 */
	public function __construct()
	{
		$this->connect();
	}

	/**
	 * Establish a connection to the MySQL database.
	 *
	 * Establishes a connection to the MySQL database using environment variables for configuration.
	 *
	 * @throws PDOException If the connection fails.
	 */
	protected function connect(): void
	{
		$dsn = sprintf(
			"mysql:host=%s;dbname=%s;charset=utf8",
			$_ENV['DB_HOST'],
			$_ENV['DB_NAME']
		);

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_CASE => PDO::CASE_LOWER,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];

		try {
			$this->conn = new PDO(
				$dsn,
				$_ENV['DB_USER'],
				$_ENV['DB_PASS'],
				$options
			);
		} catch (PDOException $e) {
			throw new PDOException("Failed to connect to MySQL: " . $e->getMessage(), $e->getCode(), $e);
		}
	}

	/**
	 * Get the database connection.
	 *
	 * Returns the PDO connection instance used for database interactions.
	 *
	 * @return PDO The PDO connection instance.
	 */
	public function getConnection(): PDO
	{
		return $this->conn;
	}

	/**
	 * Close the database connection.
	 *
	 * Closes the database connection by setting the connection instance to null.
	 */
	public function closeConnection(): void
	{
		$this->conn = null;
	}
}