<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\PrivacyPolicy;
use Auth;
use Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $privacyPolicy = PrivacyPolicy::first();

        if (!$privacyPolicy) {
            return response()->json([
                'status' => true,
                'message' => 'Privacy Policy retrieved successfully',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Privacy Policy retrieved successfully',
            'data' => $privacyPolicy->content ?? [],
        ], 200);
    }

    public function getLanguage(Request $request)
    {
        $languages = Language::where('is_enabled', true)->get();

        return response()->json([
            'status' => true,
            'message' => 'Languages retrieved successfully',
            'data' => $languages
        ], 200);
    }

}