@extends('layouts.admin')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{__('Email Notification Template')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">{{__('Email Notification Template')}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="customers__table">
                            <table id="customers-table" class="row-border data-table-filter table-style">
                                <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Subject')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($email_templates as $template)
                                    <tr class="removable-item">
                                        <td>
                                            {{$template->category}}
                                        </td>
                                        <td>
                                            {{$template->subject}}
                                        </td>
                                        <td>
                                            @if($template->status == 1)
                                                Active
                                            @else
                                                Deactiavte
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action__buttons">
                                                <a  href="{{route('email-notification.edit', $template->id)}}" class="btn-action mr-30" title="Edit Details">
                                                    <img src="{{asset('admin/images/icons/edit-2.svg')}}" alt="edit">
                                                </a>
                                                <a href="javascript:void(0);" onclick="getEditModal('{{route('email-notification.view', $template->id)}}', '#page-modal')" title="Preview" class="btn-action">
                                                    <img src="{{asset('admin/images/icons/eye-2.svg')}}" alt="Preview">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{$email_templates->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Page content area end -->

    <!-- Edit Modal section start -->
    <div class="modal fade" id="page-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->

@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/jquery.dataTables.min.css')}}"/>
@push('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="{{asset('common/js/common_helper.js')}}"></script>
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/data-table-page.js')}}"></script>
@endpush
