<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorPassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->user,
            'guestname' => $this->guestname,
            'gender' => $this->gender,
            'dateexpires' => $this->dateexpires,
            'generatedcode' => $this->generatedcode,
            'statuspass' => $this->statuspass,
            'tenant' => $this->tenant,
            'tenant' => $this->tenant,
            'user_role' => $this->user_role,
            'visitor_pass_category' => $this->visitor_pass_category_id,
            'visitationdate' => $this->visitationdate,
            'recurrentpass' => $this->recurrentpass,
            $this->mergeWhen($this->user_role == "admin", ['creator_name' => $this->admin->userfullname ?? null]),
            $this->mergeWhen($this->user_role == "resident", ['name' => $this->resident->name ?? null]),
        ];
    }
}
