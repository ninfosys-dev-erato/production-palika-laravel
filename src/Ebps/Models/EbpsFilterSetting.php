<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Model;

class EbpsFilterSetting extends Model
{
    protected $table = 'ebps_filter_setting';

    protected $fillable = [
        'enable_role_filtering',
        'description',
        'updated_by',
    ];

    protected $casts = [
        'enable_role_filtering' => 'boolean',
    ];

    /**
     * Get the single filter setting (there's only one row)
     */
    public static function getSetting(): self
    {
        $setting = self::first();
        
        if (!$setting) {
            // Create default setting if it doesn't exist
            $setting = self::create([
                'enable_role_filtering' => true,
                'description' => 'Role-based filtering enabled - Users only see applications they can work on',
            ]);
        }
        
        return $setting;
    }

    /**
     * Check if role filtering is enabled
     */
    public static function isRoleFilteringEnabled(): bool
    {
        return self::getSetting()->enable_role_filtering;
    }

    /**
     * Enable role filtering
     */
    public static function enableRoleFiltering(): void
    {
        $setting = self::getSetting();
        $setting->update([
            'enable_role_filtering' => true,
            'description' => 'Role-based filtering enabled - Users only see applications they can work on',
            'updated_by' => auth()->id(),
        ]);
    }

    /**
     * Disable role filtering (show all applications)
     */
    public static function disableRoleFiltering(): void
    {
        $setting = self::getSetting();
        $setting->update([
            'enable_role_filtering' => false,
            'description' => 'Role-based filtering disabled - All users see all applications',
            'updated_by' => auth()->id(),
        ]);
    }

    /**
     * Toggle role filtering
     */
    public static function toggleRoleFiltering(): bool
    {
        $setting = self::getSetting();
        $newValue = !$setting->enable_role_filtering;
        
        if ($newValue) {
            self::enableRoleFiltering();
        } else {
            self::disableRoleFiltering();
        }
        
        return $newValue;
    }
} 