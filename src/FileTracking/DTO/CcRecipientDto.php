<?php
namespace Src\FileTracking\DTO;
use Illuminate\Database\Eloquent\Model;

class CcRecipientDto
{
    public function __construct(
        public string $type, // e.g., 'branch', 'ward'
        public string $id    // model ID
    ) {}

    public static function fromModel(Model $model): self
    {
        return new self(
            type: get_class($model), // Or use a mapping if needed
            id: (string) $model->getKey()
        );
    }
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
        ];
    }

    // Optional: Useful if you ever want to resolve this DTO back to a model
    public function toModel(): ?Model
    {
        if (!class_exists($this->type)) {
            return null;
        }

        return app($this->type)->find($this->id);
    }
}