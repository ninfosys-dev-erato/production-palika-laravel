<?php

namespace App\Services;

use Spatie\QueryBuilder\QueryBuilder;

class SearchService
{
    /**
     * Search phone number across models based on priority.
     *
     * @param string $phoneNumber
     * @param array $modelsPriority
     * @return array|null
     */
    public function search(string $phoneNumber, array $modelsPriority): array|bool
    {
        foreach ($modelsPriority as $model) {
            // Create an instance of the model to call non-static methods
            $modelInstance = new $model;

            // Check if 'mobile_no' or 'phone' is fillable in the model
            $query = QueryBuilder::for($modelInstance::query());

            // Conditionally apply filters based on the attributes present in the model
            if (in_array('mobile_no', $modelInstance->getFillable())) {
                $query->where('mobile_no', $phoneNumber);
            }

            if (in_array('phone', $modelInstance->getFillable())) {
                $query->orWhere('phone', $phoneNumber);
            }

            // Fetch the result from the model
            $result = $query->first();

            if ($result) {
                // Standardize the output to the Customer model's attributes
                return $this->formatResult($model, $result);
            }
        }

        return false; // Return null if no result is found
    }

    /**
     * Format result to Customer model attributes.
     *
     * @param string $model
     * @param \Illuminate\Database\Eloquent\Model $data
     * @return array
     */
    protected function formatResult(string $model, $data): array
    {
        return [
            'type' => class_basename($model),
            'id' => $data->id ?? null,
            'name' => $data->name ?? null,
            'email' => $data->email ?? null,
            'mobile_no' => $data->mobile_no ?? $data->phone ?? null,
            'gender' => $data->gender ?? null,
            'avatar' => $data->photo ?? null,
            'created_by' => $data->created_by ?? null,
        ];
    }
}