<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Region;
use App\Data\RegionData;

use Spatie\LaravelData\DataCollection;

class RegionQueryService
{
  public function searchRegionByName(string $keyword, int $limit = 5): DataCollection
  {
    $regions = Region::where('type', 'village') // sub-district
      ->where(function ($query) use ($keyword) {

        // search the village
        $query->where('name', 'LIKE', "%$keyword%")
          ->orWhere('postal_code', 'LIKE', "%$keyword%")
          // district
          ->orWhereHas('parent', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
          })
          // city
          ->orWhereHas('parent.parent', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
          })
          // province
          ->orWhereHas('parent.parent.parent', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
          });
      })->with(['parent.parent.parent']) // call the province
      ->limit($limit)
      ->get();

    return new DataCollection(RegionData::class, $regions);
  }

  public function searchRegionByCode(string $code): RegionData
  {
    return RegionData::fromModel(
      Region::where('code', $code)->first()
    );
  }
}
