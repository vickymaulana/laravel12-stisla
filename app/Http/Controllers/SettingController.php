<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                // Handle boolean values
                if ($setting->type === 'boolean') {
                    $value = $request->has("settings.{$key}") ? '1' : '0';
                }

                $setting->update(['value' => $value]);
            }
        }

        // Clear cache
        Setting::clearCache();

        // Log activity
        ActivityLog::log('Settings updated', 'System Settings', 'updated');

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Create a new setting.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:settings,key',
            'label' => 'required|string',
            'value' => 'nullable',
            'type' => 'required|in:text,number,boolean,json,email,url,textarea',
            'group' => 'required|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        Setting::create($request->all());

        ActivityLog::log('New setting created: ' . $request->key, 'System Settings', 'created');

        return redirect()->route('settings.index')
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Delete a setting.
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $key = $setting->key;
        
        $setting->delete();
        Setting::clearCache();

        ActivityLog::log('Setting deleted: ' . $key, 'System Settings', 'deleted');

        return redirect()->route('settings.index')
            ->with('success', 'Setting deleted successfully.');
    }

    /**
     * Reset settings to default.
     */
    public function reset(Request $request)
    {
        if ($request->group) {
            Setting::where('group', $request->group)->delete();
            $message = ucfirst($request->group) . ' settings reset successfully.';
        } else {
            Setting::truncate();
            $message = 'All settings reset successfully.';
        }

        Setting::clearCache();
        $this->seedDefaultSettings();

        ActivityLog::log('Settings reset', 'System Settings', 'updated');

        return redirect()->route('settings.index')
            ->with('success', $message);
    }

    /**
     * Seed default settings.
     */
    private function seedDefaultSettings()
    {
        $defaults = [
            // General Settings
            ['key' => 'app_name', 'value' => 'Laravel Admin', 'type' => 'text', 'group' => 'general', 'label' => 'Application Name', 'description' => 'The name of your application', 'order' => 1],
            ['key' => 'app_description', 'value' => 'A modern admin panel', 'type' => 'textarea', 'group' => 'general', 'label' => 'Application Description', 'description' => 'Short description of your application', 'order' => 2],
            ['key' => 'app_logo', 'value' => '/img/logo.png', 'type' => 'text', 'group' => 'general', 'label' => 'Application Logo', 'description' => 'Path to your application logo', 'order' => 3],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'general', 'label' => 'Maintenance Mode', 'description' => 'Enable maintenance mode', 'order' => 4],
            
            // Email Settings
            ['key' => 'contact_email', 'value' => 'admin@example.com', 'type' => 'email', 'group' => 'email', 'label' => 'Contact Email', 'description' => 'Primary contact email address', 'order' => 1],
            ['key' => 'support_email', 'value' => 'support@example.com', 'type' => 'email', 'group' => 'email', 'label' => 'Support Email', 'description' => 'Support email address', 'order' => 2],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Facebook URL', 'description' => 'Your Facebook page URL', 'order' => 1],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Twitter URL', 'description' => 'Your Twitter profile URL', 'order' => 2],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Instagram URL', 'description' => 'Your Instagram profile URL', 'order' => 3],
            
            // Appearance
            ['key' => 'items_per_page', 'value' => '20', 'type' => 'number', 'group' => 'appearance', 'label' => 'Items Per Page', 'description' => 'Number of items to display per page', 'order' => 1],
            ['key' => 'theme_color', 'value' => '#6777ef', 'type' => 'text', 'group' => 'appearance', 'label' => 'Primary Color', 'description' => 'Primary theme color', 'order' => 2],
        ];

        foreach ($defaults as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
