<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluation;
use App\Http\Resources\EvaluationResource;
use App\Jobs\EvaluationCreated;
use App\Models\Evaluation;
use App\Services\CompanyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EvaluationController extends Controller
{
    public function __construct(
        protected Evaluation $repository,
        protected CompanyService $companyService,
    ) {
    }

    public function index(string $company): AnonymousResourceCollection
    {
        $evaluation = $this->repository->whereCompany($company)->get();

        return EvaluationResource::collection($evaluation);
    }

    public function store(StoreEvaluation $request, string $company)
    {
        $comapnyResponse = $this->companyService->getCompany($company);
        $statusCode = $comapnyResponse->status();
        if ($statusCode != 200)
            return response()->json([
                'message' => 'Invalid Company',
            ], $statusCode);

        $email = json_decode($comapnyResponse->body())->data->email;

        EvaluationCreated::dispatch($email)->onQueue('queue_email');

        $evaluation = $this->repository->create($request->validated());

        return new EvaluationResource($evaluation);
    }
}
