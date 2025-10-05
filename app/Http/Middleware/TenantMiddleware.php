<?php

namespace App\Http\Middleware;

use App\Models\SchoolInfoModel;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $slug = $request->segment(1);
        $slug = $slug ? Str::lower(trim($slug)) : null;

        if (!$slug) {
            abort(404, 'School not specified.');
        }

        $centralConn = Config::get('database.default');

        $sessionSlug   = session('tenant_slug');

        if ($sessionSlug !== $slug) {
            if ($sessionSlug && $sessionSlug !== $slug) {
                Session::flush();
            }
            $tenant = DB::connection($centralConn)
                ->table('tenants')
                ->where('slug', $slug)
                ->first();


            if (!$tenant) {
                abort(404, 'Tenant not found.');
            }
            $tenantConfig = [
                'driver'    => 'mysql',
                'host'      => $tenant->db_host,
                'port'      => $tenant->db_port,
                'database'  => $tenant->database_name,
                'username'  => $tenant->db_username,
                'password'  => $tenant->db_password,
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'prefix'    => '',
                'strict'    => true,
            ];

            Config::set('database.connections.tenant', $tenantConfig);
            Config::set('database.default', 'tenant');


            DB::purge('tenant');
            DB::reconnect('tenant');

            session(['tenant_slug' => $slug]);
            return redirect()->route('home', ['tenant' => $slug]);
        } else {
            $tenant = DB::connection($centralConn)
                ->table('tenants')
                ->where('slug', $slug)
                ->first();
            $tenantConfig = [
                'driver'    => 'mysql',
                'host'      => $tenant->db_host,
                'port'      => $tenant->db_port,
                'database'  => $tenant->database_name,
                'username'  => $tenant->db_username,
                'password'  => $tenant->db_password,
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'prefix'    => '',
                'strict'    => true,
            ];

            #run time connection configuration
            Config::set('database.connections.tenant', $tenantConfig);
            Config::set('database.default', 'tenant');
            DB::purge('tenant');
            DB::reconnect('tenant');
        }

        app()->instance('tenant', $tenant);

        $school_info = SchoolInfoModel::first(['name', 'short_name', 'address', 'phone', 'email', 'logo_circle', 'logo_transparent', 'website']);
        view()->share('school_info', $school_info);

        if ($request->route() && $request->route()->hasParameter('tenant')) {
            URL::defaults(['tenant' => $slug]);
        }
        return $next($request);
    }
}
