<?php

namespace App\Http\Controllers;

use App\Members;
use App\Districts;
use App\Province;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $member = Members::select(
             "provinces.province_name",
             "members.*",
             "districts.districts_name"
             )
        ->join('provinces', 'members.province', '=', 'provinces.id')
        ->join('districts', 'members.district','=', 'districts.districts_id')
        ->get()
        ->toArray();
        // $member = Members::all();
        

    return view('member.index',compact('member'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prov=Province::all();
        return view('member.create',compact('prov'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['fname'=>'required' , 'lname'=>'required','tel'=>'required',
        'email'=>'required', 'address'=>'required','province'=>'required', 
        'district'=>'required', 'code'=>'required'
        ]);
        $member = new Members([ 
            'fname' => $request->get('fname'),
            'lname' => $request->get('lname'),
            'tel' => $request->get('tel'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'province' => $request->get('province'),
            'district' => $request->get('district'),
            'code' => $request->get('code')
        ]);
        $member->save();
        return redirect()->route('member.create')->with('success','บันทึกข้อมูลเรียบร้อยเเล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Members::find($id);
        $prov = Province::all();
        return view('member.edit',compact('member','id','prov'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['fname'=>'required' , 'lname'=>'required','tel'=>'required',
        'email'=>'required', 'address'=>'required','province'=>'required', 
        'district'=>'required', 'code'=>'required']);
        
            $member =  Members::find($id);
            $member->fname = $request->get('fname');
            $member->lname = $request->get('lname');
            $member->tel = $request->get('tel');
            $member->email = $request->get('email');
            $member->address = $request->get('address');
            $member->province = $request->get('province');
            $member->district = $request->get('district');
            $member->code = $request->get('code');
        
        $member->save();
        return redirect()->route('member.index')->with('success','อัพเดทข้อมูลเรียบร้อยเเล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Members::find($id);
        $member->delete();
        return redirect()->route('member.index')->with('success','ลบข้อมูลเรียบร้อยแล้ว');
    }
    public function findDistrictName(Request $request)
    {
        // $province_id = Province::select('id')->where('province_name',$request->id);

      
        // dd($province_id);
        $data = Districts::select('districts_name', 'districts_id', )->where('province_id', $request->id)->get();
        // dd($data);
        return response()->json($data);
    }
    public function findPostCode(Request $request)
    {
        $data = Districts::select('postcode')->where('districts_id',$request->id)->first();
        return response()->json($data);
    }
    public function search(Request $request)
    {
        
        $member = Members::where('fname','like','%'.$request->name.'%')
        ->orWhere('lname','like','%'.$request->name.'%')
        ->orWhere('tel','like','%'.$request->name.'%')
        ->orwhere('email','like','%'.$request->name.'%')
        ->select("provinces.province_name","members.*","districts.districts_name")
        ->join('provinces', 'members.province', '=', 'provinces.id')
        ->join('districts', 'members.district','=', 'districts.districts_id')
        ->get()
        ->toArray();
        // dd($member);
        return view('member.index',compact('member'));
    }

}
