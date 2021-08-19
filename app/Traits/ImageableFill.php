<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;

trait ImageableFill
{
    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            // $key = $this->removeTableFromKey($key);
            if($key == 'image')
            {
                $folder = property_exists($this, 'imageFolder')? $this->imageFolder : '';

                try {
                    $value = upload_base_64_image($value, $folder);
                }catch (\Exception $e) {
                    continue;
                }
            }

            // The developers may choose to place some attributes in the "fillable" array
            // which means only those attributes may be set through mass assignment to
            // the model, and all others will just get ignored for security reasons.
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            } elseif ($totallyGuarded) {
                throw new MassAssignmentException(sprintf(
                    'Add [%s] to fillable property to allow mass assignment on [%s].',
                    $key, get_class($this)
                ));
            }
        }

        return $this;
    }

    /**
     * Fill the model with an array of attributes. Force mass assignment.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function forceFill(array $attributes)
    {
        return static::unguarded(function () use ($attributes) {
            return $this->fill($attributes);
        });
    }

    public function getImageAttribute($value)
    {
        $background = dechex(mt_rand(0, 16777215));

        try{
            $rgb = HTMLToRGB($background);
        } catch (\Exception $e) {
            $background = "41abdb";
            $rgb = HTMLToRGB($background);
        }

        $hsl = RGBToHSL($rgb);
        $color = $hsl->lightness > 200 ? "000": "fff";

        // To use UI Avatars this is the parameter structure in sequence from documentation
        // $url = urlencode("https://ui-avatars.com/api/name/size/background/color/length/font-size/rounded/uppercase/bold");
        // return $value
        //     ? asset("storage/{$value}")
        //     : asset("default.png");


        return $value
            ? asset("storage/{$value}")
            : "https://ui-avatars.com/api/{$this->name}/64/{$background}/{$color}/2/0.5/true/true/true";
    }

}
