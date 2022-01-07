<?php 
$user_name = (isset($_GET['user_name']) && $_GET['user_name'] != '') ? $_GET['user_name'] : '';
$email = (isset($_GET['email']) && $_GET['email'] != '') ? $_GET['email'] : '';
$mobile = (isset($_GET['mobile']) && $_GET['mobile'] != '') ? $_GET['mobile'] : '';
$status = (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : '';
?>
@extends('layouts.header')
@section('content')
    <div class="inner-wrapper-g">
        <div class="filter-sec d-flex align-items-center w-bg flex-wrap">
            <div class="main_content">
                @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  </div>
                @endif
                <div class="main_head">
                   <div class="menue_first_head">
                        <div class="list_head">
                            <h1>Manage Team Users </h1>
                        </div>
                        <div class="distict_btn">
                            <a href="{{route('add-team-user')}}"><button class="btn blue_btn">Add Team User</button></a>
                        </div>
                    </div>
                </div>    
                <form action="{{URL::to('team-users')}}" autocomplete="off" method="get" >    
                <div class="filter_by_sec">
                    <input type="text" placeholder="Name" name="user_name" value="{{$user_name}}" >
                    <input type="text" placeholder="Email Address" name="email" value="{{$email}}" >
                    <input type="text" placeholder="Contact Number" name="mobile" value="{{$mobile}}" > 
                    <select class="form-pik-er " name="status">
                        <option value="">Select Status</option>
                        <option value="1"  @if($status=="1") selected @endif>Active</option>
                        <option value="2" @if($status=="2") selected @endif>Inactive</option>
                    </select>
                    
                    <div class="distict_btn list-filter">
                        <button class="btn blue_btn">Filter</button> 
                         <a href="{{url('/team-users')}}"><button type="button" class="btn blue_btn" style="background-color:green">Reset</button></a>
                     </div>
                </div>
                 </form>
    
                <div class="table_main_dist table-responsive">
                    <table class="distict_table">
                        <thead>
                            <tr class="tab">
                                <th>S.NO </th> 
                                <th>@sortablelink('name','FULL NAME')</th>
                                <th>@sortablelink('email','EMAIL ADDRESS')</th>
                                <th>@sortablelink('userDetail.contact_no','CONTACT NUMBER')</th>
                                <th>@sortablelink('userDetail.organization_name','ORGANIZATION NAME')</th>
                                <th>@sortablelink('userRenewalDatail.renewal_date','RENEWAL DATE') </th>
                                <th> DATE </th>
                                <th class="cen">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if(count($users) > 0)
                                @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{$key + $users->firstItem()}}</td>  
                                    <td>{{ucfirst($user->name)}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>@if($user['userDetail']['contact_no'] != null)
                                        {{$user['userDetail']['contact_no']}}
                                        @endif
                                    </td>
                                    <td>@if($user['userDetail']['organization_name'] != null)
                                    {{ucfirst($user['userDetail']['organization_name'])}}
                                    @endif
                                    </td>
                                    <td>@if($user['userRenewalDatail']['renewal_date'] != null)  
                                        {{ date('m/d/Y', strtotime($user['userRenewalDatail']['renewal_date'])) }}
                                        @endif
                                    </td>
                                    @if($user->updated_at !='')
                                            <td><?php $date = explode(' ',$user->updated_at); echo date('m/d/Y',strtotime($date[0])); ?></td>
                                        @else
                                            <td><?php $date = explode(' ',$user->created_at); echo date('m/d/Y',strtotime($date[0])); ?></td>
                                        @endif
                                    <td>
                                        <div class="table_last">
                                            <span><a  data-toggle="modal" data-target="#viewModalCenter{{$user->id}}">  <img src="{{asset('images/front_images/eye.png')}}"></a></span>
                                            <span><a href="{{url('/create/team-user/'.$user->id)}}"><img src="images/Edit.png" title="Edit"></a></span>
                                            <span><a onclick="return confirm('Are you sure to delete?')" href="{{route('team-users-delete',[$user->id])}}"><img src="images/Delete.png"></a></span>
                                             
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr> 
                                    <td  class="text_cen" colspan="8">No Team Users Available</td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>        
                </div> 
            </div> 

      @foreach($users as $key=>$user)
 <div class="modal fade cd-example-modal-xl viewModalCenter{{$user->id}}" id="viewModalCenter{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Team User Detail </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
            <table class="viewmodel_tbl" width="100%"  border="1">
              <tr class="viewmodel_tr">
                <th>Name</th>
                <td>{{ucfirst($user->name)}}</td>
              </tr>
                <tr class="viewmodel_tr">
                <th>Email</th>
                <td>{{$user->email}}</td>
              </tr> 
                <tr class="viewmodel_tr">
                <th>Contact Number</th>
                <td>{{$user['userDetail']['contact_no']}}</td>
              </tr> 
                <tr class="viewmodel_tr">
                <th>Organization Name</th>
                <td>{{ucfirst($user['userDetail']['organization_name'])}}</td>
               
              </tr> 
                <tr class="viewmodel_tr">
                <th>Status</th>
                <td>@if($user->status==1) Active @else Inactive @endif</td>
                  </tr> 
 
                    <tr class="viewmodel_tr">
                    <th>Adderss</th>
                     <td>@if($user['userDetail']['address'] != '')
                     {{ucfirst($user['userDetail']['address'])}},{{ucfirst($user['userDetail']['city'])}},{{ucfirst($user['userDetail']['province'])}}-{{ucfirst($user['userDetail']['postal_code'])}}@else
                      -
                      @endif</td>
                  </tr> 
                    <tr class="viewmodel_tr">
                    <th>Renewal Date</th>
                    <?php
  
                $renewaldate=DB::table('renewal_details')->where('user_id',$user->id)->where('is_activate',1)->where('status',1)->select('*')->first();  
                  ?>  
                    <td>{{date('m/d/Y', strtotime($renewaldate->renewal_date));}} </td> 
                  </tr>   
                  </tr>  

                <tr class="viewmodel_tr">
                <th>Account Created By</th>
                <td>@if($user->is_own==1) Own(Customer) @else Super Admin @endif</td>
              </tr> 
            </table>
            <table class="distict_table">
                <thead>
                    <tr class="tab">
                        <th>S.No </th>
                        <th>#Invoice</th> 
                        <th>Date</th>
                        <th>Plan</th>
                        <th>Coupon Code</th>                        
                        <th>Payment Status </th>
                        <th>Payment Type</th>
                        <th>Amount</th> 
                    </tr>
                </thead>
                <tbody>     
                 <?php $i=0; ?>
                 @foreach($plans as $key=>$plan) 
                 @if($user->id == $plan->user_id) 
                 <?php

                  $i=$i+1; 
                  if($plan->renewal_coupon_id !=''){
                $couponname=DB::table('coupons')->where('id',$plan->renewal_coupon_id)->select('*')->get();
                  } 
                  ?>                
                    <tr 
               @if($plan->renewal_is_activate =='1') style="background-color: rgb(144, 238, 144) !important;" @endif>
                        <td>{{$i}}</td> 
                        <td>#KH{{$plan->id}}{{$key+1}}u{{ $user->id}}</td>
                        <td>{{date('m/d/Y', strtotime($plan->renewal_updated_at));}}</td> 
                        <td>{{$plan->plan_name}}</td> 
                        <td>@if($plan->renewal_coupon_id !='0')
                               {{$couponname[0]->coupon_code}}
                           @elseif($plan->renewal_coupon_id =='0')
                              - 
                           @endif
                         </td> 
                        <td>  
                           @if($plan->renewal_status=='1')
                              Success
                           @elseif($plan->renewal_status=='2')
                             Faild  
                           @endif 
                        </td>  
                        <td>  
                            @if($plan->renewal_paytype=='1')
                                Cash
                            @elseif($plan->renewal_paytype=='2')
                                Cheque
                            @elseif($plan->renewal_paytype=='3')
                                Online Payment
                            @elseif($plan->renewal_paytype=='0')
                                Offline Payment 
                            @endif 
                       </td> 
                        <td>CAD {{$plan->renewal_amt}}</td> 
                    </tr>                                             
                @endif
                @endforeach


            </tbody>
        </table> 
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>
 @endforeach


<div class="table-footer">
               <!--  <div class="table-entries">
                    <label id="page">The Pages You are On</label>
                    <select >
                        <option value="{{ $users->currentPage()}}">{{ $users->currentPage()}}</option>
                    </select>
                </div> -->
                 <!-- <div class="table-pagination">
                    
                    <ul>
                          {!! $users->links() !!}
                    </ul>
                </div> -->
                <div class="table-footer"> 
   <div class="col-xs-12 text-right" align="left">
    {{ $users->appends(['user_name' =>$user_name,'email'=>$email,'mobile'=>$mobile,'status'=>$status])->links('vendor.pagination.default')}}
</div>
</div>
                
            </div>
           
        </div>
    </div>
@endsection