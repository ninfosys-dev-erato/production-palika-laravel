<?php


namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;
use Illuminate\Support\Facades\App;

enum ConsumerCommitteeMemberDesgination: string implements EnumInterface
{
    case Chair = 'chair';
    case ViceChair = 'vice_chair';
    case Treasurer = 'treasurer';
    case Secretary = 'secretary';
    case JointSecretary = 'joint_secretary';
    case Member = 'member';




    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[] = [
                'value' => $value,
                'label' => $value->label(),
            ];
        }

        return $valuesWithLabels;
    }

    public static function getLabel(EnumInterface $value): string
    {
        return match ($value) {
            self::Chair => __('yojana::yojana.chair'),
            self::ViceChair => __('yojana::yojana.vice_chair'),
            self::Treasurer => __('yojana::yojana.treasurer'),
            self::Secretary => __('yojana::yojana.secretary'),
            self::JointSecretary => __('yojana::yojana.joint_secretary'),
            self::Member => __('yojana::yojana.member')
        };
    }
}
