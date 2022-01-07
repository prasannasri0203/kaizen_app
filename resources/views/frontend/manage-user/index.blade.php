<?php 
$user_name = (isset($_GET['user_name']) && $_GET['user_name'] != '') ? $_GET['user_name'] : '';
$email = (isset($_GET['email']) && $_GET['email'] != '') ? $_GET['email'] : '';
$mobile = (isset($_GET['mobile']) && $_GET['mobile'] != '') ? $_GET['mobile'] : '';
$status = (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : '';
$role = (isset($_GET['role']) && $_GET['role'] != '') ? $_GET['role'] : '';
?>
@extends('layouts.frontend.header')
@section('content')
<div class="container-fluid px-4 main_part">
    <div class="t-h">
        <a href="{{url('/user-list')}}">
            <h4 class="Acc_Setting bl">Manage User List </h4>
        </a>
         <a href="{{route('user-list.create')}}" class="float-right" >
            <div class="distict_btn">
                <h4 class="Acc_Setting ">
                    <button class="btn blue_btn ">Add  User</button></h4>
            </div>
        </a>
      
    </div>
    @if(session('status')) 
    <div class="col-md-12">
     <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
</div>
    @endif 
     @if(session('failure')) 
    <div class="col-md-12">
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('failure') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
</div>
    @endif
    
     <div class="inner-wrapper-g">            
        <div class="filter-sec d-flex align-items-center w-bg flex-wrap">
        <form action="{{url('/user-list')}}" autocomplete="off" method="get" >
                <input type="hidden" name="base_url" value="{{url('/')}}">                      
                 <div class="filter_by_sec long-filter list-filter-div">
                    <input type="text" placeholder="Name " name="user_name"  value="{{$user_name}}">  
                    <input type="text" placeholder="Email Address " name="email"  value="{{$email}}">  
                    <input type="text" placeholder="Contact No. " name="mobile"  value="{{$mobile}}">   
                    <select class="form-pik-er" name="role">
                        <option value="">Role</option>
                        @foreach($roleList as $list)
                        <option value="{{$list->id}}"  @if($role==$list->id) selected @endif>{{$list->role}}</option>
                        @endforeach                        
                    </select> 
                    <select class="form-pik-er" name="status">
                        <option value="">Status</option>
                        <option value="1"  @if($status=="1") selected @endif>Active</option>
                        <option value="0" @if($status=="0") selected @endif>Inactive</option>
                    </select> 
                    
                    <div class="distict_btn  list-filter">
                        <button class="btn blue_btn">Filter</button>
                        <a href="{{url('/user-list')}}"><button type="button" class="btn blue_btn" style="background-color:green">Reset</button></a>
                     </div>
                </div>
         </form> 
                    
            <div class="container-fluid p-0 mt-2 table-responsive">
                <table class="distict_table">
                    <thead>
                        <tr class="tab">
                            <th>S.NO </th>
                            <th>@sortablelink('name','FULL NAME')</th>
                            <th>@sortablelink('email','EMAIL ADDRESS')</th>
                            <th>@sortablelink('userDetail.contact_no','CONTACT NUMBER')</th>
                            <th>@sortablelink('user_role_id','ROLE')</th>
                            <th>DATE</th>
                            <th>@sortablelink('status','STATUS')</th>
                            <th class="cen">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($users) > 0)
                        @foreach($users as $key => $list)
                        <tr>
                            <td> {{ $key + $users->firstItem() }} </td>
                            <td> {{ucfirst($list->name)}} </td>
                            <td> {{$list->email}} </td>
                            <td> {{$list->userDetail->contact_no}} </td>
                            <?php  $roleList    = DB::table('team_user_roles')->where('id',$list->user_role_id)->first(); ?>
                            <td> {{$roleList->role}} </td>
                            <td>@if($list->updated_at == null) {{ $list->created_at->format('d/m/Y') }} @else {{ $list->updated_at->format('d/m/Y')}} @endif</td>
                            <td> @if($list->status ==1) Active @else Inactive @endif </td>
                            <td> 
                            
                             <div class="table_last">         
                                <form action="{{action('App\Http\Controllers\Frontend\FrontUserController@destroy', $list->id)}}" method="POST">
                                @csrf   @method('DELETE')
                                <span><a href="{{route('user-list.edit',$list->id)}}"><img src="images/Edit.png" title="Edit"></a></span>
                                <span>
                                <a> <button class="btn" id="button" type="submit" onclick="return confirm('Are you sure to delete?')"> <img  type="submit"  src="images/Delete.png" ></button></a>   

                                     </span>
                                </form>
                   </div>
                   </td>
                         
                        </tr>
                        @endforeach
                        @else
                            <tr>
                             <td colspan="3"></td>
                             <td colspan="2" class="text_cen">No Users Available</td>
                             <td colspan="3"></td>                    
                            </tr>
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>

        <div class="table-footer"> 
    <div class="col-xs-12 text-right" align="left">
      {{ $users->appends(['user_name' =>$user_name,'email'=>$email,'mobile'=>$mobile,'status'=>$status])->links('frontend.pagination.default')}}
</div>
    </div>
</div>
@endsection