<?php

namespace App\Imports;

use App\SapMaterial;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToModel;

class SapMaterialImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (is_numeric($row[0]))
            return new SapMaterial([
                'df' => $row[1],
                'material' => $row[2],
                'material_type' => $row[3],
                'plant' => $row[4],
                'sloc' => $row[5],
                'material_desc' => $row[6],
                'uom' => $row[7],
                'material_group' => $row[8],
                'old_number' => $row[9],
                'mrp_type' => $row[10],
                'avail_check' => $row[11],
                'sn_profile' => $row[12],
                'profit_center' => $row[13],
                'val_class' => $row[14],
                'costing_lot_size' => $row[15],
                'price_ctrl' => $row[16],
                'per' => $row[17],
                'moving_price' => $row[18],
                'last_change' => Date::now(),
                'order_text' => $row[20],
                'status' => $row[21],
            ]);
    }
}
