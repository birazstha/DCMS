<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\CostumeTypeRequest;
use App\Models\CostumeType;
use Illuminate\Http\Request;

class CostumeTypeController extends BackendBaseController
{
    protected $panel='CostumeType';  //for section/moudule
    protected $folder='backend.costumeType.'; //for view file
    protected $base_route='backend.costumeType.'; //for route method
    protected $folder_name='costumeType'; //for route method
    protected $title;
    protected $model='CostumeType';

    function __construct()
    {
        $this->model=new CostumeType();

    }

    public function index()
    {
        $this->title='List';
        $data['rows']=$this->model->all();
        return view($this->__loadDataToView($this->folder.'index'),compact('data'));

    }


    public function create(){
        $this->title='Create';
        return view($this->__loadDataToView($this->folder.'create'));
    }


    public function store(CostumeTypeRequest $request)
    {

        $request->request->add(['created_by'=>auth()->user()->id]);
        $data['row']=$this->model->create($request->all());
        if($data['row'])
        {
            $request->session()->flash('success',$this->panel.' successfully created');
        }
        else
        {
            $request->session()->flash('error','Error in creating'.$this->panel);
        }
        return redirect()->route($this->base_route.'index');
    }


    public function show($id){
        $data['row']=$this->model->find($id);
        if(!$data['row'])
        {
            request()->session()->flash('error','Record not found in '.$this->panel);
            return redirect()->route($this->base_route.'index');
        }
        $this->title='View';
        return view($this->__loadDataToView($this->folder.'show'),compact('data'));

    }


    public function edit($id)
    {

        $this->title='Edit';
        $data['row']=$this->model->find($id);
        return view($this->__loadDataToView($this->folder.'edit'),compact('data'));

    }


    public function update(Request $request, $id)
    {
        $request->request->add(['updated_by'=>auth()->user()->id]);
        $data['row']=$this->model->find($id);
        $data['row']->update($request->all());
        if($data['row'])
        {
            $request->session()->flash('success',$this->panel.' successfully updated');
        }
        else
        {
            $request->session()->flash('error','Error in updating'.$this->panel);
        }
        return redirect()->route($this->base_route.'index');
    }


    public function destroy($id)
    {
        $data['row']=$this->model->find($id);
        $data['row']->delete();
        if($data['row'])
        {
            request()->session()->flash('success',$this->panel.' successfully deleted');
        }
        else
        {
            request()->session()->flash('error','Error in deleting'.$this->panel);
        }
        return redirect()->route($this->base_route.'index');
    }


}
