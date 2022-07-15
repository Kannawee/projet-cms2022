<?php
namespace App\Model;

use App\Core\Sql;

class Elementpage extends Sql
{
    protected $id = null;
    protected $type;
    protected $id_obj;
    protected $ordre;
    protected $id_page;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFromArray($data)
    {
        $this->id = (isset($data['id']) && $data['id']!=0)?$data['id']:null;
        $this->type = (isset($data['type']) && $data['type']!=0)?$data['type']:null;
        $this->ordre = (isset($data['ordre']) && $data['ordre']!=0)?$data['ordre']:null;
        $this->id_page = (isset($data['id_page']) && $data['id_page']!=0)?$data['id_page']:null;

    }

    public function getId()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getIdObj()
    {
        return $this->id_obj;
    }

    public function setIdObj($id_obj)
    {
        $this->id_obj = $id_obj;
    }

    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    public function getOrdre()
    {
        return $this->ordre;
    }

    public function setIdPage($id_page)
    {
        $this->id_page = $id_page;
    }

    public function getIdPage()
    {
        return $this->id_page;
    }

    public function getListElement($id)
    {
        $where = array(
            "id_page"=>$id
        );

        return $this->select($where,null,["ordre ASC"]);
    }

    public function checkOrdre($ordre, $id_page)
    {
        $where = array(
            "ordre"=>$ordre,
            "id_page"=>$id_page,
        );

        $check = $this->select($where);

        if (count($check)>0) {
            return false;
        }

        return true;
    }

    public function changeOrdre($change)
    {

        $col1 = $col2 = array();
        $otherordre = $ordre = $this->ordre;

        echo $change.'<br>';

        if ($change=="up" && $this->ordre>1) {
            $col1["ordre"] = $ordre-1;
            $col2["ordre"] = $ordre;
            $otherordre -= 1;
        } else if ($this->ordre < $this->getMaxOrdre($this->id_page)-1) {
            $col1["ordre"] = $ordre+1;
            $col2["ordre"] = $ordre;
            $otherordre += 1;
        } else {
            die("Nouvel ordre tout cassé");
        }

        $this->reset();
        $this->builder->update($this->table, $col2);
        $this->builder->where("id_page", $this->table);
        $this->builder->where("ordre", $this->table, "=", 1);

        $data = array(
            "id_page"=>$this->id_page,
            "ordre"=>$col2['ordre'],
            "ordre1"=>$otherordre
        );
        
        $tmp_res = $this->execute($data);

        $this->reset();
        $this->builder->update($this->table, $col1);
        $this->builder->where('id', $this->table);

        $col1['id'] = $this->id;

        $res = $this->execute($col1);
        return $res;
    }

    public function getMaxOrdre($id_page)
    {
        $where = array(
            "id_page"=>$id_page
        );
        $this->reset();
        $this->builder->select(DBPREFIXE.'elementpage', ['MAX(ordre)+1 as max']);
        $this->builder->where('id_page',DBPREFIXE.'elementpage');
        $res = $this->execute($where, true);
        $max = 1;
        if (count($res)>0) {
            $max = $res[0]['max'];
        }
        return $max;    }

    public function getMinOrdre($id_page)
    {
        $where = array(
            "id_page"=>$id_page
        );
        $this->reset();
        $this->builder->select(DBPREFIXE.'elementpage', ['MIN(ordre) as min']);
        $this->builder->where('id_page',DBPREFIXE.'elementpage');
        $res = $this->execute($where, true);
        $min = 1;
        if (count($res)>0) {
            $min = $res[0]['min'];
        }
        return $min;
    }

    public function getAddForm($id_page): array
    {
        

        $ordre = $this->getMaxOrdre($id_page);

        return [
            "config"=>[
                "class"=>"formAddPage",
                "method"=>"POST",
                "action"=>"/administration/element/add/".$id_page,
                "submit"=>"Add"
            ],
            'inputs'=>[
                "ordre"=>[
                    "type"=>"number",
                    "required"=>true,
                    "error"=>"Incorrect ordre",
                    "value"=>$ordre,
                    "min"=>$ordre,
                ]
            ],
            'select'=>[
                "type"=>[
                    "type"=>"select",
                    "required"=>true,
                    "options"=>[1=>'html',2=>'image',3=>'project'],
                    "error"=>"Incorrect title"
                ],
            ]
        ];
    }

    public function getEditForm(): array
    {

        $form = [
            "config"=>[
                "class"=>"formEditElemPage",
                "method"=>"POST",
                "action"=>"/administration/elementpage/edit/".$this->id_page."/".$this->id,
                "submit"=>"EDIT"
            ],
            'inputs'=>[
                "ordre"=>[
                    "type"=>"hidden",
                    "required"=>true,
                    "error"=>"Incorrect title",
                    "value"=>$this->ordre
                ],
            ],
            "select"=>[
                "type"=>[
                    "required"=>true,
                    "error"=>"Incorrect type",
                    "options"=>[1=>"html",2=>"image",3=>"project"],
                    "value"=>$this->type,
                    "label"=>"Visible"
                ]
            ]
        ];

        return $form;
    }

}