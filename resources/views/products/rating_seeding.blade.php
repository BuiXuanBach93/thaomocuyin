@extends('layouts.app')

@section('content')
    <style>
        .slide label {
            display:block;
        }

        .slide input[type='radio'] {
            float:left;
            display: block;
            margin-right: 15px;
        }
        .slide input[type='file'] {
            float:left;
        }
        textarea {
            width: 100%;
            max-width: 100%;
            background-color: #d2d6de;
            border:none;
            padding: 5px 10px;
        }
        textarea:focus {
            outline-width: 1px;
            outline-color: red;
        }
    </style>
    <section class="content-header">
        <h1>
            Create seeding for "{{$product->title}}"
        </h1>
    </section>
    <div class="content admin-product">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <form action="" method="POST">
            @csrf
            <div class="box-body">
                <div class="list-rating">
                    <div class="rating">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Customer</span>
                            </div>
                            <img class="direct-chat-img" src="/images/people.png" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                <textarea name="customer_rating[]" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="direct-chat-msg" style="margin-left: 50px;">
                            <div class="direct-chat-info clearfix">
                              <span class="direct-chat-name pull-left">Thảo Mộc Uy Tín</span>
                              <span class="direct-chat-timestamp pull-right"></span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <img class="direct-chat-img" src="/images/favicon.png" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                <textarea name="admin_rating[]" id="" cols="30" rows="3"></textarea>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div> 
                    </div>

                    <div class="rating">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Customer</span>
                            </div>
                            <img class="direct-chat-img" src="/images/people.png" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                <textarea name="customer_rating[]" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="direct-chat-msg" style="margin-left: 50px;">
                            <div class="direct-chat-info clearfix">
                              <span class="direct-chat-name pull-left">Thảo Mộc Uy Tín</span>
                              <span class="direct-chat-timestamp pull-right"></span>
                            </div>
                            <!-- /.direct-chat-info -->
                            <img class="direct-chat-img" src="/images/favicon.png" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                <textarea name="admin_rating[]" id="" cols="30" rows="3"></textarea>
                            </div>
                            <!-- /.direct-chat-text -->
                        </div> 
                    </div>
                    
                    <div class="form-group" style="margin-top:40px;">
                        <input class="btn btn-primary" type="submit" value="Save">
                        <a href="/admin/product" class="btn btn-default">Cancel</a>
                    </div>
                    {{-- @foreach ($ratings as $rating)
                    <div class="rating">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">{{$rating->customer_name}}</span>
                                <span class="direct-chat-timestamp pull-right">{{Date("Y-m-d", strtotime($rating->customer_name))}}</span>
                            </div>
                            <img class="direct-chat-img" src="/images/people.png" alt="message user image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                <textarea name="" id="" cols="30" rows="3">{{$rating->content}}</textarea>
                            </div>

                            @if (count($rating->subRating))
                            @foreach ($rating->subRating as $subRating)
                            <div class="direct-chat-msg" style="margin-left: 50px;">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-left">{{$subRating->customer_name}}</span>
                                  <span class="direct-chat-timestamp pull-right">{{Date("Y-m-d", strtotime($subRating->customer_name))}}</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="/images/favicon.png" alt="message user image">
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                    <textarea name="" id="" cols="30" rows="3">{{$subRating->content}}</textarea>
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            @endforeach
                                
                            @else
                            <div class="direct-chat-msg" style="margin-left: 50px;">
                                <div class="direct-chat-info clearfix">
                                  <span class="direct-chat-name pull-left">Thảo Mộc Uy Tín</span>
                                  <span class="direct-chat-timestamp pull-right">{{Date("Y-m-d")}}</span>
                                </div>
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="/images/favicon.png" alt="message user image">
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                    <textarea name="" id="" cols="30" rows="3"></textarea>
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>        
                        
                            @endif
                        </div>
                    </div>    
                    @endforeach --}}
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
