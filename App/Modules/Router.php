<?php

namespace App\Modules;

use App\Controller\Controller;

/**
 * Class Router
 *
 * Handles routing of HTTP requests by defining and dispatching routes.
 * Routes are stored as a collection of method, URI, and callback pairs.
 */
class Router
{
	/**
	 * @var array An array to store the registered routes.
	 */
	private static $routes = [];

	/**
	 * Checks whether the request method matches the expected method.
	 *
	 * If the method does not match, it sends a JSON response with a 405 status code (Method Not Allowed)
	 *
	 * @param HttpMethod $method The expected HTTP method.
	 */
	private static function checkMethod(HttpMethod $method)
	{
		if ($_SERVER['REQUEST_METHOD'] !== $method->value) {
			Controller::sendJSONResponse([
				"message" => "$method->value method is not allowed for this route."
			], 405); // Method Not Allowed
			exit;
		}
	}

	/**
	 * Checks if the current URI matches the given URI.
	 *
	 * @param string $uri The URI to check against the current request URI.
	 * @return bool True if the URIs match, otherwise false.
	 */
	private static function isCurrentUri(string $uri): bool
	{
		return $uri === parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}

	/**
	 * Registers a new route with the given HTTP method, URI, and callback function.
	 *
	 * @param HttpMethod $method The HTTP method for the route (GET, POST, etc.).
	 * @param string $uri The URI pattern for the route.
	 * @param callable $callback The callback function to handle the route.
	 */
	public static function request(HttpMethod $method, string $uri, array $callback)
	{
		self::$routes[] = [
			'method' => $method,
			'uri' => $uri,
			'callback' => $callback
		];
	}

	/**
	 * Handles a 404 Not Found error by sending a JSON response.
	 *
	 * @throws Exception If the request route is not found.
	 */
	public static function handleNotFound()
	{
		Controller::sendJSONResponse([
			"message" => "Not Found"
		], 404); // Not Found
	}

	public static function handleServerError()
	{
		Controller::sendJSONResponse([
			"message" => "The specified function does not exist"
		], 500); // Not Found
	}

	/**
	 * Dispatches the request to the appropriate route based on the current URI and method.
	 *
	 * Iterates through registered routes, checking if any route matches the current request.
	 * If a match is found, the corresponding callback function is executed.
	 * If no match is found, a 404 error is handled.
	 *
	 * @throws Exception If the request route is not found.
	 */
	public static function listen()
	{
		foreach (self::$routes as $route) {
			if (self::isCurrentUri($route['uri'])) {
				self::checkMethod($route['method']);
				$cb = $route['callback'];

				if (method_exists(...$cb)) {
					$route['callback']();
					continue;
				}
				self::handleServerError();
			}
		}

		self::handleNotFound();
	}
}
