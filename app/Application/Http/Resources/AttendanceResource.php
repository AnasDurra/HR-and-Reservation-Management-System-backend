<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if(!$this["data"]){
            return [
                    'attendance_id' => $this["attendance_id"],
                    'emp_id' => $this["emp_id"],
                    'state' => $this["state"],
                    'attendance_time' => $this["attendance_time"],
                    'attendance_date' => $this["attendance_date"],
                    'status' => $this["status"],
                    'deleted_at' => $this["deleted_at"],
                    'employee' => [
                        'full_name' =>$this["employee"]["empdata"]["first_name"].' '.$this["employee"]["empdata"]["last_name"],
                        'cur_dep' => $this["employee"]["cur_dep"],
                        'schedule' => [
                            'schedule_id' => $this["employee"]["schedule"]["schedule_id"],
                            'name' => $this["employee"]["schedule"]["name"],
                            'time_in' => $this["employee"]["schedule"]["time_in"],
                            'time_out' => $this["employee"]["schedule"]["time_out"],
                        ],
                    ],
                ];
        }
        $i=0;
        foreach ($this["data"] as $element) {
            $data[$i]["attendance_id"] = $element["attendance_id"];
            $data[$i]["emp_id"] = $element["emp_id"];
            $data[$i]["attendance_date"] = $element["attendance_date"];
            $data[$i]["check_in.state"] = $element["check_in.state"];
            $data[$i]["check_in.status"] = $element["check_in.state"];
            $data[$i]["check_in_time"] = $element["check_in_time"];
            $data[$i]["check_out.state"] = $element["check_out.state"];
            $data[$i]["check_out.status"] = $element["check_out.status"];
            $data[$i]["check_out_time"] = $element["check_out_time"];
            $data[$i]["latetime.duration"] = $element["latetime.duration"];
            $data[$i]["latetime.latetime_date"] = $element["latetime.latetime_date"];

            $data[$i]["employee"]["full_name"] = $element['employee']['emp_data']['first_name'] . ' ' . $element['employee']['emp_data']['last_name'];
            $data[$i]["employee"]["cur_dep"] = $element["employee"]["cur_dep"];
            $data[$i]["employee"]["schedule"]["schedule_id"] = $element["employee"]["schedule"]["schedule_id"];
            $data[$i]["employee"]["schedule"]["name"] = $element["employee"]["schedule"]["name"];
            $data[$i]["employee"]["schedule"]["time_in"] = $element["employee"]["schedule"]["time_in"];
            $data[$i]["employee"]["schedule"]["time_out"] = $element["employee"]["schedule"]["time_out"];
            $i++;
        }
        return [
            "current_page" => $this["current_page"],
            "data" => $data,
            "first_page_url" => $this["first_page_url"],
            "from" => $this["from"],
            "last_page" => $this["last_page"],
            "last_page_url" => $this["last_page_url"],
            "links" => $this["links"],
            "next_page_url" => $this["next_page_url"],
            "path" => $this["path"],
            "per_page" => $this["per_page"],
            "prev_page_url" => $this["prev_page_url"],
            "to" => $this["to"],
            "total" => $this["total"]
        ];
    }
}
