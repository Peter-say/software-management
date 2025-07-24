<?php

namespace App\Http\Controllers\API\V1\Assistant;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AI\V1\Assistant\SeoAnalysesResource;
use App\Http\Resources\AI\V1\Assistant\SeoAnalyzerResource;
use App\Models\SeoAnalysis;
use App\Models\User;
use App\Services\API\V1\Assistant\SeoAnalyzer;
use App\Services\SiteInspector\SiteInspectorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class SeoAnalyzerController extends Controller
{
    protected $seoAnalyzerService;
    protected $inspector;

    public function __construct(SeoAnalyzer $seoAnalyzerService, SiteInspectorService $inspector)
    {
        $this->seoAnalyzerService = $seoAnalyzerService;
        $this->inspector = $inspector;
    }

    public function analyze(Request $request)
    {
        try {
            set_time_limit(360);
            if ($request->has('html_input') && $request->has('url')) {
                $inspection = $this->validateUrl($request->input('url'));
                if ($inspection !== true) return $inspection;
            }
            $result = $this->seoAnalyzerService->analyzer($request);
            $responseData = [];
            if (isset($result['uuid'])) {
                $responseData['uuid'] = $result['uuid'];
            }
            if (isset($result['response'])) {
                $responseData['response'] = $result['response'];
            }
            if (isset($result['title'])) {
                $responseData['title'] = $result['title'];
            }
            if (isset($result['prompt'])) {
                $responseData['prompt'] = $result['prompt'];
            }
            if (isset($result['raw_response'])) {
                $responseData['raw_response'] = $result['raw_response'];
            }

            return ApiHelper::successResponse('SEO analysis completed successfully', new SeoAnalyzerResource($responseData));
        } catch (ValidationException $e) {
            return ApiHelper::validationErrorResponse($e->errors());
        } catch (RuntimeException $e) {
            $message = $e->getMessage();
            if (str_contains($message, 'net::ERR_INTERNET_DISCONNECTED')) {
                $message = 'Internet connection appears to be offline. Please check your connection and try again.';
            }
            return ApiHelper::validationErrorResponse([$message]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('An unexpected error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function save(Request $request)
    {
        try {
            $result = $this->seoAnalyzerService->saveAnalysis($request);

            $message = $result['status'] === 'created'
                ? 'SEO analysis saved successfully.'
                : 'SEO analysis updated successfully.';

            return ApiHelper::successResponse($message, new SeoAnalysesResource($result['analysis']));
        } catch (ValidationException $e) {
            return ApiHelper::validationErrorResponse($e->errors());
        } catch (RuntimeException $e) {
            $message = $e->getMessage();
            if (str_contains($message, 'net::ERR_INTERNET_DISCONNECTED')) {
                $message = 'Internet connection appears to be offline. Please check your connection and try again.';
            }
            return ApiHelper::validationErrorResponse([$message]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('An unexpected error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function getAnalyses()
    {
        try {
            $user = User::getAuthenticatedUser();
            $analyses = SeoAnalysis::with('user')
                ->where('user_id', $user->id)->latest()
                ->get();

            if ($analyses->isEmpty()) {
                return [];
            }
            return ApiHelper::successResponse('User analyses fetched successfully', [
                'analyses' => $analyses,
            ]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    public function getAnalysis($uuid)
    {
        try {
            $user = User::getAuthenticatedUser();
            $analysis = SeoAnalysis::with('user')
                ->where('uuid', $uuid)
                ->where('user_id', $user->id)
                ->first();

            if (!$analysis) {
                return ApiHelper::errorResponse('Analysis not found', 404);
            }

            return ApiHelper::successResponse('Analysis fetched successfully', [
                'analysis' => $analysis,
            ]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

     public function clearAnalysis($uuid)
    {
        try {
            $this->seoAnalyzerService->clearAnalysis($uuid);
            return ApiHelper::successResponse('Analysis cleared successfully');
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    public function clearAnalyses()
    {
        try {
            $user = User::getAuthenticatedUser();
            $conversations =  $this->seoAnalyzerService->clearAnalyses();
            return ApiHelper::successResponse('Analyses cleared successfully', [
                'conversation' => $conversations,
            ]);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    protected function validateUrl(?string $url)
    {
        if (!$url) return true; // If no URL is provided, skip
        $result = $this->inspector->inspect($url);

        if ($result['error']) {
            return ApiHelper::validationErrorResponse($result['message']);
        }
        return true;
    }
}
