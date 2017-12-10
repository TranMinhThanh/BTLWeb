<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    public $timestamps = true;

    /* Trả về người được giao công việc
    * @return User
    */
    public function assign_to(){
        return $this->belongsTo(User::class,'assigned_to');
    }

    /*
     * Trả về người tạo ra công việc
     * @return User
     */
    public function create_by(){
        return $this->belongsTo(User::class,'create_by');
    }

    /*
     * Trả về tên công việc
     * @return string
     */
    public function title(){
        return nl2br($this->title);
    }

    /*
     * Trả về nội dung công việc
     * @return string
     */
    public function content(){
        return nl2br($this->content);
    }
}
