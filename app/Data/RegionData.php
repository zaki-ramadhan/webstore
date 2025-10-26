<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class RegionData extends Data
{
    #[Computed]
    public string $label;

    public function __construct(
        public string $code,
        public string $province,
        public string $city,
        public string $district,
        public string $sub_district,
        public string $postal_code,
        public string $country = 'Indonesia'
    ){
        $this->label = "$sub_district, $district, $city, $province, $postal_code";
    }
}
