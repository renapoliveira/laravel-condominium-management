<?php

namespace App\Services;

use App\Http\Controllers\Controller;

/** * 
 * This service purpose is to handle main features used in all CRUDS like sorting and privileges 
 **/

class MainService extends Controller
{

    public function __construct($sortLink, $tableTitles, $input)
    {
        $this->sortLink = $sortLink;
        $this->tableTitles = $tableTitles;
        $this->input = $input;
    }

    public function createTableHeader()
    {
        $tableTitles = [];
        $sortLink = $this->sortLink;

        foreach($this->tableTitles as $t){
            if (isset($this->input['sort'])) {
                if ($this->input['sort'] == $t['value']) {
                    if (isset($this->input['order'])) {
                        $link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order='. (($this->input['order'] == 'asc') ? 'desc ' : 'asc') . '">' . $t['label'] .'</a> <i class="fa fa-chevron-' . (($this->input['order'] == 'asc') ? 'up' : 'down') . '"></i>';                     
                    } else {
                        $link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order=asc' . '">' . $t['label'] .'</a> <i class="fa fa-chevron-up"></i>';
                    }
                } else {
                    $link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order=asc' . '">' . $t['label'] .'</a>';                 
                }
            } else {
                $link = '<a href="' . $sortLink . '&sort='. $t['value']. '&order=asc' . '">' . $t['label'] .'</a>';             
            }
            $tableTitles[] = $link;         
        }

        return $tableTitles;
    }

    public function sort($data)
    {
        if (isset($this->input['sort'])) {
            if (isset($this->input['order']) && ($this->input['order'] == 'asc' || $this->input['order'] == 'desc') ) {
                $data = $data->orderBy($this->input['sort'], $this->input['order']);
            } else {
                $data = $data->orderBy($this->input['sort'], 'asc');
            }
        } else {
            $data = $data->orderBy('created_at', 'DESC');
        }
        $data = $data->paginate(15);
        return $data;
    }
    

}
