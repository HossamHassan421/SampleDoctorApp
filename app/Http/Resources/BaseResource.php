<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
  public function with($request)
  {
    return [
      'status' => 200,
      'message'=>trans('system.success_msg'),
    ];
  }

  public static function collection($resource)
  {
    return parent::collection($resource)->additional([
      'status' => 200,
      'message'=>trans('system.success_msg'),
    ]);
  }
}
