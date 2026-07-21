<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Get the casts array — inject 'array' cast for all translatable attributes.
     */
    public function getCasts()
    {
        $casts = parent::getCasts();
        foreach ($this->translatable ?? [] as $key) {
            $casts[$key] = 'array';
        }
        return $casts;
    }

    /**
     * Determine if an attribute is translatable.
     */
    public function isTranslatableAttribute($key)
    {
        return in_array($key, $this->translatable ?? []);
    }

    /**
     * Override setAttribute to auto-wrap plain strings into locale arrays.
     * This allows old seeders that pass plain strings to still work.
     */
    public function setAttribute($key, $value)
    {
        if ($this->isTranslatableAttribute($key) && is_string($value)) {
            // Wrap plain strings: use as 'id' locale, leave 'en' empty
            $value = ['id' => $value, 'en' => ''];
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Override getAttributeValue to return the correct locale translation.
     */
    public function getAttributeValue($key)
    {
        // Get the raw value from attributes (already decoded by 'array' cast via parent)
        $value = parent::getAttributeValue($key);

        if ($this->isTranslatableAttribute($key)) {
            // If it's an array (decoded JSON), pick the correct locale
            if (is_array($value)) {
                $locale = App::getLocale();
                $fallback = config('app.fallback_locale', 'id');
                
                if (!empty($value[$locale])) {
                    return $value[$locale];
                }
                if (!empty($value[$fallback])) {
                    return $value[$fallback];
                }
                return reset($value) ?: null;
            }

            // If still a string (e.g., old data not yet migrated), return as-is
            if (is_string($value)) {
                return $value;
            }
        }

        return $value;
    }

    /**
     * Get the raw translation array for a given attribute (all locales).
     */
    public function getTranslations($key)
    {
        $raw = $this->getRawOriginal($key);
        if (is_string($raw)) {
            return json_decode($raw, true) ?? [];
        }
        return is_array($raw) ? $raw : [];
    }

    /**
     * Get translation for a specific locale.
     */
    public function getTranslation($key, $locale)
    {
        $translations = $this->getTranslations($key);
        return $translations[$locale] ?? null;
    }

    /**
     * Set translation for a specific locale.
     */
    public function setTranslation($key, $locale, $value)
    {
        $translations = $this->getTranslations($key);
        $translations[$locale] = $value;
        $this->setAttribute($key, $translations);
        return $this;
    }
    /**
     * Override toArray to ensure translatable attributes are serialized as localized strings.
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        
        foreach ($this->translatable ?? [] as $key) {
            if (array_key_exists($key, $attributes)) {
                $attributes[$key] = $this->getAttributeValue($key);
            }
        }
        
        return $attributes;
    }
}

