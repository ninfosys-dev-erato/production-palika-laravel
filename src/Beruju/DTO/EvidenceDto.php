<?php

namespace Src\Beruju\DTO;

use Illuminate\Http\UploadedFile;

class EvidenceDto
{
    public function __construct(
        public ?string $id = null,
        public ?string $berujuEntryId = null,
        public ?string $name = null,
        public ?string $filePath = null,
        public ?string $fileName = null,
        public ?int $fileSize = null,
        public ?string $fileType = null,
        public ?string $description = null,
        public ?string $createdBy = null,
        public ?string $updatedBy = null,
        public ?string $deletedBy = null,
        public ?UploadedFile $file = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            berujuEntryId: $data['beruju_entry_id'] ?? null,
            name: $data['name'] ?? null,
            filePath: $data['file_path'] ?? null,
            fileName: $data['file_name'] ?? null,
            fileSize: $data['file_size'] ?? null,
            fileType: $data['file_type'] ?? null,
            description: $data['description'] ?? null,
            createdBy: $data['created_by'] ?? null,
            updatedBy: $data['updated_by'] ?? null,
            deletedBy: $data['deleted_by'] ?? null,
            file: $data['file'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public static function fromModel($model): self
    {
        return new self(
            id: $model->id,
            berujuEntryId: $model->beruju_entry_id,
            name: $model->name,
            filePath: $model->file_path,
            fileName: $model->file_name,
            fileSize: $model->file_size,
            fileType: $model->file_type,
            description: $model->description,
            createdBy: $model->created_by,
            updatedBy: $model->updated_by,
            deletedBy: $model->deleted_by,
            createdAt: $model->created_at?->toISOString(),
            updatedAt: $model->updated_at?->toISOString(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'beruju_entry_id' => $this->berujuEntryId,
            'name' => $this->name,
            'file_path' => $this->filePath,
            'file_name' => $this->fileName,
            'file_size' => $this->fileSize,
            'file_type' => $this->fileType,
            'description' => $this->description,
            'created_by' => $this->createdBy,
            'updated_by' => $this->updatedBy,
            'deleted_by' => $this->deletedBy,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function toModelArray(): array
    {
        return array_filter([
            'beruju_entry_id' => $this->berujuEntryId,
            'name' => $this->name,
            'file_path' => $this->filePath,
            'file_name' => $this->fileName,
            'file_size' => $this->fileSize,
            'file_type' => $this->fileType,
            'description' => $this->description,
            'created_by' => $this->createdBy,
            'updated_by' => $this->updatedBy,
            'deleted_by' => $this->deletedBy,
        ], fn($value) => !is_null($value));
    }
}
