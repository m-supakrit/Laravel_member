@extends('layouts.app')
@section('content')
<div class="p-3 mb-2 bg-white text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12"><br />
                <div align="center">
                    <h1><kbd>ข้อมูลสมาชิก</kbd></h1>
                </div>
                <br>
   
                <br>
                @if(\Session::has('success'))
                    <div class="alert alert-success">
                    <p>{{\Session::get('success')}}</p>
                    </div>
                @endif    
               
                <div class="text-right mb-4 float-right">
                    <form class="form-inline" action={{route('member.search')}} method="GET">
                        <div class="form-group">
                            <input type="text" id="name" name="name" class="form-control" placeholder="ค้นหาข้อมูลผู้ใช้" />
                        </div>
                    <button type="submit" class="btn btn-success ml-2">ค้นหา</a>    
                </div>
                <div align="left">
                    <a href = {{route('member.index')}} class="btn btn-info">หน้าเเรก</a> 
                    <a href="{{route('member.create')}}" class="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                <br>
                <table class="table table-striped table-striped">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมลล์</th>
                            <th>ที่อยู่</th>
                            <th>จังหวัด</th>
                            <th>อำเภอ</th>
                            <th>รหัสไปรษณีย์</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    @foreach($member as $row)
                    <tr>
                        <td>{{$row['id']}}</td>
                        <td>{{$row['fname']}}</td>
                        <td>{{$row['lname']}}</td>
                        <td>{{$row['tel']}}</td>
                        <td>{{$row['email']}}</td>
                        <td>{{$row['address']}}</td>
                        <td>{{$row['province_name']}}</td>
                        <td>{{$row['districts_name']}}</td>
                        <td>{{$row['code']}}</td>
                        <td><a href = "{{action('MembersController@edit',$row['id'])}}" class = "btn btn-warning">แก้ไข</a></td>
                        <td>
                         <form method="post" class = "delete_form" action ="{{action('MembersController@destroy',$row['id'])}}">
                         {{csrf_field()}}
                         <input type="hidden" name="_method" value="DELETE"/>
                         <button type = "submit" class = "btn btn-danger">ลบ</button> 
                         </form>
                        </td>
                    </tr>
    
                    @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type = "text/javascript">
        $(document).ready(function(){ 
            $('.delete_form').on('submit',function(){
            if(confirm("คุณต้องการลบข้อมูลใช่หรือไม่")){
                return true;
            }
            else
            {
                return false;
            }
        });
        });
        </script>
@endsection