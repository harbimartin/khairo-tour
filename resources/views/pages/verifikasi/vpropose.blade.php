    @extends('pages.verifikasi', ['tab'=>'propose'])
    @section('md_content')
        <?php
            $verify_column = array();
            $verify_column['info'] = [ 'name'=>"Total MRA", 'type'=>'Info', "full"=>true, "val"=>$total, "format"=>"Money"];
            $number = 1;
            for ($i=$level; $i <= 8; $i++) {
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
            $url = '/pengajuan';
        ?>
            <?php
                $query = $_GET;
                $id = request()->hid;//$query['hid'];
                unset($query['hid']);
                $back_query = '/pengajuan/';//request()->url().($query ? '?'.http_build_query($query):'');
            ?>
            {{-- <x-update
                title="MRA"
                :column="$column"
                :select="$select"
                :url="$url"
                :data="$header"
                :error="$error"
                :detail="true"
            >
            </x-update> --}}
            <x-add-record
                title="Verification - Proposed"
                :column="$verify_column"
                :select="$select"
            >
            </x-add-record>

    @endsection
