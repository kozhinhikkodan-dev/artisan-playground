<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ArtisanPlaygroundMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $config = config('artisan-playground');

        // Check if IP is allowed
        if (!$this->isIpAllowed($request, $config)) {
            abort(403, 'Access denied from this IP address.');
        }

        // Check if authentication is enabled
        if ($config['auth']['enabled'] ?? true) {
            // Check if user is authenticated (either standard Laravel auth or custom credentials)
            if (!Auth::check() && !session('artisan_playground_authenticated')) {
                return redirect()->route('artisan-playground.login');
            }

            // Check if user has permission
            if (Auth::check() && !$this->hasPermission(Auth::user(), $config)) {
                abort(403, 'You do not have permission to access Artisan Playground.');
            }
        }

        return $next($request);
    }

    /**
     * Check if the IP address is allowed.
     */
    protected function isIpAllowed(Request $request, array $config): bool
    {
        $allowedIps = $config['access_control']['allowed_ips'] ?? [];

        if (empty($allowedIps)) {
            return true; // Allow all IPs if none specified
        }

        $clientIp = $request->ip();

        foreach ($allowedIps as $allowedIp) {
            if ($this->ipMatches($clientIp, $allowedIp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if IP matches pattern (supports wildcards).
     */
    protected function ipMatches(string $clientIp, string $allowedIp): bool
    {
        if ($allowedIp === '*' || $allowedIp === $clientIp) {
            return true;
        }

        // Support for CIDR notation
        if (str_contains($allowedIp, '/')) {
            return $this->ipInCidr($clientIp, $allowedIp);
        }

        // Support for wildcard patterns
        $pattern = str_replace('*', '.*', $allowedIp);
        return preg_match('/^' . $pattern . '$/', $clientIp);
    }

    /**
     * Check if IP is in CIDR range.
     */
    protected function ipInCidr(string $ip, string $cidr): bool
    {
        list($subnet, $mask) = explode('/', $cidr);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $mask);
        $subnet &= $mask;
        return ($ip & $mask) == $subnet;
    }

    /**
     * Check if user has permission to access Artisan Playground.
     */
    protected function hasPermission($user, array $config): bool
    {
        // If auth is disabled, allow access
        if (!($config['auth']['enabled'] ?? true)) {
            return true;
        }

        // Check specific roles
        if (!empty($config['access_control']['allowed_roles'])) {
            if (!$user->hasAnyRole($config['access_control']['allowed_roles'])) {
                return false;
            }
        }

        // Check specific permissions
        if (!empty($config['access_control']['required_permissions'])) {
            if (!$user->hasAnyPermission($config['access_control']['required_permissions'])) {
                return false;
            }
        }

        // Check specific users
        if (!empty($config['access_control']['allowed_users'])) {
            if (!in_array($user->id, $config['access_control']['allowed_users'])) {
                return false;
            }
        }

        return true;
    }
}