<?php

namespace App\Modules;

/**
 * Enum HttpMethod
 *
 * Represents HTTP methods as an enumeration, providing a type-safe way to specify the HTTP method for routes.
 * Each constant in the enum corresponds to an HTTP method, represented as a string.
 */
enum HttpMethod: string
{
	case GET = 'GET';
	case POST = 'POST';
	case PUT = 'PUT';
	case DELETE = 'DELETE';
	case PATCH = 'PATCH';
	case HEAD = 'HEAD';
	case OPTIONS = 'OPTIONS';
	case CONNECT = 'CONNECT';
	case TRACE = 'TRACE';
}