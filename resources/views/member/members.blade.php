@extends('layouts.app')
@section('content')

<div class="p-3 mb-2 bg-light text-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-12"><br />
                <h1 align="center"><kbd>เพิ่มข้อมูลผู้ใช้</kbd></h1><br />
            @if(count($errors)>0)
                <div class = "alert alert-danger">
                <ul> 
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
                </ul>
                </div>
                @endif
                @if(\Session::has('success'))
                <div class = "alert alert-success">
                <p>{{\Session::get('success')}}</p>
                </div>
                @endif
            
                <form method="post" action="{{url('member')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">ชื่อ</label>
                        <input type="text" name="fname" class="form-control" placeholder="ป้อนชื่อ" />
                    </div>
                    
                    <div class="form-group">
                        <label for="name">นามสกุล</label>
                        <input type="text" name="lname" class="form-control" placeholder="ป้อนนามสกุล" />
                    </div>
                    <div class="form-group"> 
                        <label for="name">เบอร์โทร</label>
                        <input type="text" name="tel" class="form-control" placeholder="ป้อนเบอร์โทร" />
                    </div>
                    <div class="form-group">
                        <label for="name">อีเมลล์</label>
                        <input type="text" name="email" class="form-control" placeholder="ป้อนอีเมลล์" />
                    </div>
                    <div class="form-group">
                        <label for="name">ที่อยู่</label>
                        <input type="text" name="address" class="form-control" placeholder="ป้อนที่อยู่" />
                    </div> 
                    <div class="form-group">
                        <label for="name">จังหวัด</label>
                        <select name="province" id="province" class="province form-control">
                            <option value="">--เลือกจังหวัด--</option>
                            @foreach ($prov as $row)
                                <option value="{{$row->id}}">{{$row->province_name}}</option>
                            @endforeach
                        </select>
                    </div> 
    
                    <div class="form-group">
                        <label for="name">อำเภอ</label>
                        <select name="district" id="district" class="district form-control">
                            <option value="" disabled selected>--เลือกอำเภอ--</option>
    
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="name">รหัสไปรษณีย์</label>
                        <input type="text" name="code" class="code form-control" placeholder="ป้อนรหัสไปรษณีย์" value=""/>
                    </div> 
                    
                    
                    <div class="container">
                    <div class="row">
                        <input type="submit" class="btn btn-primary" value="บันทึก" />
                        <div class="col-md-auto"> 
                        {{-- <<a href = {{route('member.index')}} class="btn btn-danger">ยกเลิก</a>  --}}
                    </div>
                </div>
                <br><br>
                </form>
        </div>
    </div>
</div>
<script type ="text/javascript">
    var url_gb = '{{url("/")}}';
    $(document).ready(function(){
        $(document).on('change','.province',function(){
            // console.log("test");
            var province_id = $(this).val();
            var district = $('#district');
            console.log(district);
            var op = "";
            console.log(province_id);
            $.ajax({
                type:'get',
                url:'{!!URL::to('findDistrictName')!!}',
                data:{'id':province_id},
                success:function(data){
                    // console.log('success');
                    // console.log(data);
                    // console.log(data.length);
                    op += '<option value="0" selected disabled>--เลือกอำเภอ--</option>';
                    for(var i=0; i < data.length; i++){
                        op += '<option value="'+data[i].districts_id+'">'+data[i].districts_name+'</option>';
                    }
                    district.html(op);
                },
                error:function(){
                    console.log("error");
                }
            });
        });
        
        $(document).on('change','.district',function(){
            // var postcode = $(this).find('option:selected').data('code');
            // $(".code").val(postcode);
            var post_id = $(this).val();
            var post = $(".code");
            $.ajax({
                type:'get',
                url:'{!!URL::to('findPostCode')!!}',
                data:{'id':post_id},
                success:function(data){
                    // post.val();
                    console.log(data);
                    post.val(data.postcode);
                },
                error:function(){
                    console.log("error");
    
                }
            })
        });
    });
    </script>
@endsection