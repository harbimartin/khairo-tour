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
            $verify_column = array();
            $verify_column['info'] = [ 'name'=>"Total MRA", 'type'=>'Info', "full"=>true, "val"=>$total, "format"=>"Money"];
            $number = 1;
            for ($i=$level; $i <= 4; $i++) {
                $verify_column['ttd'.$i] = [ 'name'=>"TTD ".$number, 'type'=>'TextSel', 'api'=>'user_'.($number+4), 'share'=>['user_id'=>0, 'email'=>0], 'val'=>['division_name', 'NAME'], 'format'=>['',' ',' (',')'], 'full'=>true ];
                $verify_column['uid'.$i] = [ 'name'=>"User ID ".$number, 'type'=>'Reference', 'key'=>'ttd'.$i, 'val'=>'user_id', 'class'=>'hidden'];
                $verify_column['ue'.$i] = [ 'name'=>"Email ".$number, 'type'=>'Reference', 'key'=>'ttd'.$i, 'val'=>'email', 'full'=>true, 'class'=>'hidden'];
                $number++;
            }
            $verify_column['id'] = ['type'=>'Static', 'def'=>request()->id, 'class'=>'hidden'];
            $verify_column = json_encode($verify_column);
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
                :column="$verify_column"
                :select="$select"
            >
            </x-add-record>
    @endsection
