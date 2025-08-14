<?php

namespace Src\Beruju\Service;

use Src\Beruju\Models\Evidence;
use Src\Beruju\DTO\EvidenceDto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EvidenceService
{
    public function __construct(
        private Evidence $evidence
    ) {}

    public function create(EvidenceDto $dto): Evidence
    {
        $data = $dto->toModelArray();

        // Handle file upload
        if ($dto->file instanceof UploadedFile) {
            $fileData = $this->uploadFile($dto->file);
            $data = array_merge($data, $fileData);
        }

        $data['created_by'] = Auth::id();

        return $this->evidence->create($data);
    }

    public function update(string $id, EvidenceDto $dto): Evidence
    {
        $evidence = $this->evidence->findOrFail($id);

        $data = $dto->toModelArray();

        // Handle file upload if new file is provided
        if ($dto->file instanceof UploadedFile) {
            // Delete old file
            if ($evidence->file_path) {
                Storage::delete($evidence->file_path);
            }

            $fileData = $this->uploadFile($dto->file);
            $data = array_merge($data, $fileData);
        }

        $data['updated_by'] = Auth::id();

        $evidence->update($data);

        return $evidence->fresh();
    }

    public function delete(string $id): bool
    {
        $evidence = $this->evidence->findOrFail($id);

        // Delete file from storage
        if ($evidence->file_path) {
            Storage::delete($evidence->file_path);
        }

        $evidence->deleted_by = Auth::id();
        $evidence->save();

        return $evidence->delete();
    }

    public function findById(string $id): ?Evidence
    {
        return $this->evidence->find($id);
    }

    public function findByBerujuEntryId(string $berujuEntryId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->evidence
            ->where('beruju_entry_id', $berujuEntryId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->evidence
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPaginated(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->evidence
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    private function uploadFile(UploadedFile $file): array
    {
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = 'beruju/evidences/' . $fileName;

        // Store file
        Storage::putFileAs('beruju/evidences', $file, $fileName);

        return [
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
        ];
    }

    public function downloadFile(string $id): ?string
    {
        $evidence = $this->evidence->findOrFail($id);

        if (!$evidence->file_path || !Storage::exists($evidence->file_path)) {
            return null;
        }

        return Storage::path($evidence->file_path);
    }

    public function getFileUrl(string $id): ?string
    {
        $evidence = $this->evidence->findOrFail($id);

        if (!$evidence->file_path) {
            return null;
        }

        return Storage::url($evidence->file_path);
    }
}
