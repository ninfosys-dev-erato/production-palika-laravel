<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\FormSigneeNameDto;
use Src\Yojana\Models\FormSigneeName;

class FormSigneeAdminService
{
    /**
     * Store a new FormSigneeName record.
     */
    public function store(FormSigneeNameDto $dto): FormSigneeName
    {
        return FormSigneeName::create([
            'work_order_id' => $dto->work_order_id,
            'signee_id'     => $dto->signee_id,
            'created_at'    => now(),
            'created_by'    => Auth::id(),
        ]);
    }

    /**
     * Update an existing FormSigneeName record.
     */
    public function update(FormSigneeName $formSignee, FormSigneeNameDto $dto): FormSigneeName
    {
        $formSignee->update([
            'work_order_id' => $dto->work_order_id,
            'signee_id'     => $dto->signee_id,
            'updated_at'    => now(),
            'updated_by'    => Auth::id(),
        ]);

        return $formSignee;
    }

    /**
     * Soft delete a single FormSigneeName record.
     */
    public function delete(FormSigneeName $formSignee): FormSigneeName
    {
        $formSignee->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);

        return $formSignee;
    }

    /**
     * Soft delete multiple FormSigneeName records by IDs.
     */
    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));

        FormSigneeName::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }

    public function storeOrUpdate(FormSigneeNameDto $dto): FormSigneeName
    {
        return FormSigneeName::updateOrCreate(
            [
                'id' => $dto->id ?? null, // If DTO has id, update; else create
            ],
            [
                'work_order_id' => $dto->work_order_id,
                'signee_id'     => $dto->signee_id,
                'created_by'    => $dto->id ? null : Auth::id(),
                'updated_by'    => $dto->id ? Auth::id() : null,
                'created_at'    => $dto->id ? null : now(),
                'updated_at'    => $dto->id ? now() : null,
            ]
        );
    }
}
