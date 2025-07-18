<?php
namespace Src\FileTracking\DTO;

use Illuminate\Support\Collection;
use Src\FileTracking\Models\FileRecord;
use Illuminate\Database\Eloquent\Model;

class CcCollectionDto
{
    /**
     * @param CcRecipientDto[] $recipients
     */
    public function __construct(public array $recipients = [])
    {
        // Ensure all recipients are instances of CcRecipientDto
        foreach ($this->recipients as $recipient) {
            if (!$recipient instanceof CcRecipientDto) {
                throw new \InvalidArgumentException('All recipients must be instances of CcRecipientDto.');
            }
        }
    }

    /**
     * Create CcCollectionDto from models collection
     *
     * @param Collection<int, Model> $models
     * @return self
     */
    public static function fromModels(Collection $models): self
    {
        return new self(
            recipients: $models
                ->map(fn(Model $model) => CcRecipientDto::fromModel($model))
                ->all()
        );
    }

    /**
     * Convert CcCollectionDto to an array format
     */
    public function toArray(): array
    {
        return array_map(fn($r) => ['type' => $r->type, 'id' => $r->id], $this->recipients);
    }

    /**
     * Check if the collection is not empty
     */
    public function isNotEmpty(): bool
    {
        return !empty($this->recipients);
    }

    /**
     * Check if the collection is empty
     */
    public function isEmpty(): bool
    {
        return empty($this->recipients);
    }

    /**
     * Create CcCollectionDto from an array of data
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $recipients = array_map(
            fn($r) => new CcRecipientDto($r['type'], $r['id']),
            $data
        );

        return new self($recipients);
    }

    /**
     * Create CcCollectionDto from a collection of recipients
     *
     * @param Collection $cc
     * @return CcCollectionDto
     */
    public static function fromCcCollection(Collection $cc): self
    {
        // Assuming $cc is a collection of CcRecipientDto objects
        return new self(
            recipients: $cc->all() // Directly use the collection as recipients
        );
    }
}
