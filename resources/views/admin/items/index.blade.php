@extends('admin.layouts.app')
@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                @include('admin.includes.alert')

                <div class="card shadow">
                    {{-- Grid Header --}}
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Items</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                    </div>

                    {{-- Grid --}}
                    <div class="table-responsive">
                        <table class="table text-center table-hover items-dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        title
                                    </th>
                                    <th>
                                        quantity
                                    </th>
                                    <th>
                                        author
                                    </th>
                                    <th>
                                        Created at
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $key => $item)
                                    <tr data-entry-id="{{ $item->id }}">
                                        <td>
                                            {{ $item->id ?? '' }}
                                        </td>
                                        <td class="text-capitalize">
                                            {{ $item->title ?? ''}}
                                        </td>
                                        <td class="text-lowercase">
                                            {{ $item->quantity ?? 0 }}
                                        </td>
                                        <td class="text-capitalize">
                                            {{ $item->user->name ?? ''}}
                                        </td>
                                        <td class="text-lowercase">
                                            {{ $item->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="text-capitalize" >
                                            <a  href="{{ route('admin.items.show', $item->id) }}">
                                                <i class="far fa-edit text-primary"></i>
                                            </a>
                                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <i class="far fa-trash-alt text-danger delete-btn" style=" cursor: pointer;"></i>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="card-footer py-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('.items-dataTable').DataTable();
            $('.dataTables_filter').append('<i class=" fa fa-search dataTable-search"></i>');
        });


        $('.delete-btn').on('click', function () {
            swal({
                    title: "Are you sure?",
                    text: "you want to delete this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $(this).closest('form').submit();
                        swal("Poof! Item has been deleted!", {
                            icon: "success",
                            buttons: false,
                        });
                    } else {
                        swal("Item is safe!", {
                            buttons: false,
                        });
                    }
                });
        });
    </script>
@endpush
@endsection
