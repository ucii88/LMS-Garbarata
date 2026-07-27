<?php

use App\Models\Module;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        foreach (Module::all() as $module) {
            $content = $module->getTranslation('content', 'en');

            if (!$content || !str_contains($content, '</p>button')) {
                continue;
            }

            $content = str_replace('</p>button', '</p>', $content);
            $content = str_replace([
                '<strong>c. Emergency Stop</strong>',
                '<strong>g. Cabin Rotation</strong>',
                '<strong>h. Cabin Floor</strong>',
                '<strong>i. Vertical Movement</strong>',
                '<strong>d. Power on and off button</strong>',
                'On button',
                'Off button',
            ], [
                '<strong>c. Emergency Stop Button</strong>',
                '<strong>g. Cabin Rotation Button</strong>',
                '<strong>h. Cabin Floor Button</strong>',
                '<strong>i. Vertical Movement Button</strong>',
                '<strong>d. Power On and Off Button</strong>',
                'On Button',
                'Off Button',
            ], $content);

            $module->setTranslation('content', 'en', $content);
            $module->save();
        }
    }

    public function down(): void
    {
        // Content correction is intentionally not reverted to avoid restoring invalid HTML.
    }
};
