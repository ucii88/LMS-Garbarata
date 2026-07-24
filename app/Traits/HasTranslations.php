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
        if ($this->isTranslatableAttribute($key)) {
            // Read the original value directly so legacy plain-text values and
            // JSON values are handled consistently. Relying on the array cast
            // first turns malformed/legacy values into null on some drivers.
            $translations = $this->getTranslations($key);
            if ($translations !== []) {
                $locale = App::getLocale();
                $fallback = config('app.fallback_locale', 'id');

                if (!empty($translations[$locale])) {
                    return $translations[$locale];
                }
                if (!empty($translations[$fallback])) {
                    return $translations[$fallback];
                }

                return reset($translations) ?: null;
            }

            return null;
        }

        return parent::getAttributeValue($key);
    }

    /**
     * Get the raw translation array for a given attribute (all locales).
     */
    public function getTranslations($key)
    {
        $raw = $this->getRawOriginal($key);
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            return ['id' => $raw, 'en' => ''];
        }
        return is_array($raw) ? $raw : [];
    }

    /**
     * Get translation for a specific locale.
     */
    public function getTranslation($key, $locale)
    {
        $translations = $this->getTranslations($key);
        $fallback = config('app.fallback_locale', 'id');

        // Empty strings are not valid translations. Fall back to the configured
        // locale and finally to the first available value (usually Indonesian)
        // so EN pages never render a blank question or answer.
        if (!empty($translations[$locale])) {
            return $translations[$locale];
        }
        if (!empty($translations[$fallback])) {
            return $translations[$fallback];
        }

        return reset($translations) ?: null;
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
