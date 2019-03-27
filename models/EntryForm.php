<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EntryForm extends Model
{	
	public $id;
    public $name;
    public $writer;
    public $date;

    public function rules()
    {
        return [
            [['name', 'writer'], 'required']
        ];
    }
}

?>