<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use Statamic\Events\AssetUploaded;

/**
 * Rewrites the filename of every newly-uploaded asset to a lowercase,
 * hyphen-separated form so the S3 store stays consistent.
 *
 * "My Screenshot (v2).PNG"      -> "my-screenshot-v2.png"
 * "Team_photo Update.jpg"        -> "team-photo-update.jpg"
 * "IMG_1234.JPEG"                -> "img-1234.jpeg"
 *
 * Runs on the AssetUploaded event so files uploaded via the CP or
 * programmatically are both covered.
 */
class NormaliseAssetFilename
{
    public function handle(AssetUploaded $event): void
    {
        $asset = $event->asset;

        $current = $asset->filename();
        $extension = $asset->extension();

        $normalised = $this->normalise($current);

        if ($normalised === '' || $normalised === $current) {
            return;
        }

        // Asset::rename() takes the filename WITHOUT the extension. The
        // second argument uniquifies against collisions in the same
        // folder by suffixing -1, -2 etc.
        $asset->rename($normalised, true);
    }

    /**
     * Convert an arbitrary filename (extension already stripped) to a
     * lowercase, hyphen-separated slug. Preserves alphanumerics and
     * hyphens; collapses runs of non-word characters into a single hyphen.
     */
    private function normalise(string $filename): string
    {
        $lower = Str::lower($filename);

        // Replace anything that isn't a-z, 0-9 or hyphen with a hyphen.
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $lower);

        // Collapse consecutive hyphens.
        $slug = preg_replace('/-+/', '-', $slug);

        return trim($slug, '-');
    }
}
