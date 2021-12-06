<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetRpt extends Model
{
    public $table = 't_budget_rpt';
    public $timestamps = false;
    public $fillable =[
        'budget_code',
        'budget_date',
        'document_type',
        'doc_type_desc',
        'note_header',
        'name',
        'total',
        'budget_attachment',
        'budget_status',
        'created',
        'created_by',
        'divisions_id'
    ];
    public function scopeSearch($query, $request){
        if ($request->search)
            $query->where('budget_code', 'like', '%'. $request->search.'%')->
                    orwhere('doc_type_desc','like', '%'.  $request->search.'%')->
                    orwhere('budget_attachment','like', '%'.  $request->search.'%');
        if (is_array($request->f))
            foreach($request->f as $filter){
                switch($filter['x']){
                    case 'v':
                            $query->where($filter['k'], $filter['v']);
                        break;
                    case 's':
                            $query->where($filter['k'],'like', '%'. $filter['v'] .'%');
                        break;
                    case 'r':
                            $query->whereBetween($filter['k'], [$filter['f'], $filter['t']])->get();
                        break;
                }
            }
        if ($request->sort){
            $query->orderBy($request->sort['k'], $request->sort['t'])->get();
        }
        return $query;
    }
    // public function scopeFilter($query, $request){
    //     if ($request->has('search')) {
    //         $key = $request->search;
    //         $query->where('kode', 'like', '%' . $key . '%')
    //             ->orWhere('divisi', 'like', '%' . $key . '%')
    //             ->orWhere('judul', 'like', '%' . $key . '%')
    //             ->orWhere('pengajuan', 'like', '%' . $key . '%')
    //             ->orWhere('status', 'like', '%' . $key . '%');
    //     }
    //     foreach ($request->ms as $key => $val) {
    //         if ($key && $val)
    //             $query->orwhere($key, 'like', '%' . $val . '%');
    //     }
    //     return $query;
    // }
}
