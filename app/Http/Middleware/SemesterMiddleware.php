<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKelas;
use Symfony\Component\HttpFoundation\Response;

class SemesterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Skip check for admin and dosen roles
        if (in_array($user->role, ['admin', 'dosen'])) {
            return $next($request);
        }

        // Get class_id from route parameters
        $classId = $request->route('jadwalKelas')?->class_id ?? $request->route('class_id') ?? $request->input('class_id');

        if (!$classId) {
            return response()->json(['message' => 'Class ID is required'], 400);
        }

        // Find the jadwal kelas
        $jadwalKelas = JadwalKelas::find($classId);

        if (!$jadwalKelas) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        // Check if class has semester restriction
        if ($jadwalKelas->semester && $user->semester !== $jadwalKelas->semester) {
            return response()->json(['message' => 'Unauthorized: Semester does not match'], 403);
        }

        return $next($request);
    }
}
