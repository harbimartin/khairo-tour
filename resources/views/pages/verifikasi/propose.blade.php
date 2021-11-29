    @extends('index')
    @section('content')
        <?php
            $title = "Header Pengajuan MRA";
            $column = [
                'budget_date'=>[ 'name'=>"MRA Date", 'type'=>'Date', 'def'=>0, 'req'=> false ],
                'document_type'=>[ 'name'=>"MRA Document", 'type'=>'TextSel', 'api'=>'pr_doc', 'val'=>['doc_type','doc_type_desc'], 'req'=> true ],
                'budget_version'=>[ 'name'=>"Budget Version", 'type'=>'Select', 'api'=>'budget_version', 'val'=>['budget_version_code', 'budget_name'], 'full'=>true, 'req'=> true ],
                'note_header'=>[ 'name'=>'Header Text', 'type'=>'TextArea', 'full'=>true, 'req'=> false ],
                'budget_attachment'=>[ 'name'=>"Upload RAB", 'type'=>'Upload', 'val'=>'name', 'full'=>true, 'req'=> true , 'allow'=> ['pdf']],
            ];
            $verif_column = json_encode([
                'ttd0'=>[ 'name'=>"TTD 1", 'type'=>'TextSel', 'api'=>'user_5', 'share'=>['user_id'=>0, 'email'=>0], 'val'=>['division_name', 'NAME'], 'format'=>['',' ',' (',')'], 'full'=>true ],
                'uid0'=>[ 'name'=>"User ID 1", 'type'=>'Reference', 'key'=>'ttd0', 'val'=>'user_id', 'class'=>'hidden'],
                'ue0'=>[ 'name'=>"Email 1", 'type'=>'Reference', 'key'=>'ttd0', 'val'=>'email', 'full'=>true, 'class'=>'hidden'],
                'ttd1'=>[ 'name'=>"TTD 2", 'type'=>'TextSel', 'api'=>'user_6', 'share'=>['user_id'=>0, 'email'=>0], 'val'=>['division_name', 'NAME'], 'format'=>['',' ',' (',')'],'full'=>true ],
                'uid1'=>[ 'name'=>"User ID 2", 'type'=>'Reference', 'key'=>'ttd1', 'val'=>'user_id', 'class'=>'hidden'],
                'ue1'=>[ 'name'=>"Email 1", 'type'=>'Reference', 'key'=>'ttd1', 'val'=>'email', 'full'=>true, 'class'=>'hidden'],
                'ttd2'=>[ 'name'=>"TTD 3", 'type'=>'TextSel', 'api'=>'user_7', 'share'=>['user_id'=>0, 'email'=>0], 'val'=>['division_name', 'NAME'], 'format'=>['',' ',' (',')'], 'full'=>true ],
                'uid2'=>[ 'name'=>"User ID 3", 'type'=>'Reference', 'key'=>'ttd2', 'val'=>'user_id', 'class'=>'hidden'],
                'ue2'=>[ 'name'=>"Email 1", 'type'=>'Reference', 'key'=>'ttd2', 'val'=>'email', 'full'=>true, 'class'=>'hidden'],
                'ttd3'=>[ 'name'=>"TTD 4", 'type'=>'TextSel', 'api'=>'user_8', 'share'=>['user_id'=>0, 'email'=>0], 'val'=>['division_name', 'NAME'], 'format'=>['',' ',' (',')'], 'full'=>true ],
                'uid3'=>[ 'name'=>"User ID 4", 'type'=>'Reference', 'key'=>'ttd3', 'val'=>'user_id', 'class'=>'hidden'],
                'ue3'=>[ 'name'=>"Email 1", 'type'=>'Reference', 'key'=>'ttd3', 'val'=>'email', 'full'=>true, 'class'=>'hidden'],
                'id'=>[ 'type'=>'Static', 'def'=>request()->id, 'class'=>'hidden'],
            ]);
            if (request()->mra){
                $column['prd']['type'] = 'Disable';
            }
            $column = json_encode($column);
            $url = '/pengajuan';
        ?>
            <?php
                $query = $_GET;
                $id = request()->hid;//$query['hid'];
                unset($query['hid']);
                $back_query = '/pengajuan/';//request()->url().($query ? '?'.http_build_query($query):'');
            ?>
            <x-update
                title="MRA"
                :column="$column"
                :select="$select"
                :url="$url"
                :data="$header"
                :error="$error"
                :detail="true"
            >
            </x-update>
            <x-add-record
                title="Propose"
                :column="$verif_column"
                :select="$select"
            >
            </x-add-record>

    @endsection
